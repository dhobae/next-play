<?php

namespace Database\Seeders;

use App\Models\Atlet;
use App\Models\AtletRiwayat;
use App\Models\Klub;
use App\Models\KlubRiwayatLiga;
use App\Models\Season;
use App\Models\SeasonKlub;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $clubData = [
                ['nama_klub' => 'Borneo Padel Club', 'alamat' => 'Banjarmasin'],
                ['nama_klub' => 'South Court Padel', 'alamat' => 'Banjarbaru'],
                ['nama_klub' => 'Kalimantan Smash', 'alamat' => 'Martapura'],
                ['nama_klub' => 'Rally House', 'alamat' => 'Banjarmasin'],
                ['nama_klub' => 'Ace Padel Banjarmasin', 'alamat' => 'Banjarmasin'],
                ['nama_klub' => 'Green Court Balikpapan', 'alamat' => 'Balikpapan'],
                ['nama_klub' => 'Smash Point Samarinda', 'alamat' => 'Samarinda'],
                ['nama_klub' => 'Urban Padel Jakarta', 'alamat' => 'Jakarta'],
                ['nama_klub' => 'Garuda Padel Bandung', 'alamat' => 'Bandung'],
                ['nama_klub' => 'Nusantara Padel Surabaya', 'alamat' => 'Surabaya'],
                ['nama_klub' => 'Rally Point Makassar', 'alamat' => 'Makassar'],
                ['nama_klub' => 'Prime Court Yogyakarta', 'alamat' => 'Yogyakarta'],
            ];

            $clubs = collect($clubData)->mapWithKeys(function (array $club) {
                $model = Klub::updateOrCreate(
                    ['nama_klub' => $club['nama_klub']],
                    ['alamat' => $club['alamat'], 'gambar' => '']
                );

                return [$club['nama_klub'] => $model];
            });

            $seasons = collect(range(2022, 2026))->mapWithKeys(function (int $year) {
                $name = 'Season Demo ' . $year;
                $season = Season::updateOrCreate(
                    ['nama_season' => $name],
                    [
                        'mp' => '0',
                        'w' => '0',
                        'l' => '0',
                        'pp' => '0',
                        'lp' => '0',
                        'tanggal_mulai' => $year . '-01-01',
                        'tanggal_selesai' => $year . '-12-31',
                    ]
                );

                return [$year => $season];
            });

            $legacyRoster = [
                'Borneo Padel Club' => [['Andi Pratama', 0, 'Elektrum']],
                'South Court Padel' => [['Bima Saputra', 0, 'Silver']],
                'Kalimantan Smash' => [['Citra Lestari', 1, 'Silver'], ['Eko Maulana', 0, 'Beginner']],
                'Rally House' => [['Dewi Anggraini', 1, 'Bronze'], ['Fajar Hidayat', 0, 'Bronze']],
            ];
            $firstNames = [
                'Aditya',
                'Bagas',
                'Candra',
                'Dimas',
                'Farhan',
                'Galih',
                'Hendra',
                'Ilham',
                'Joko',
                'Kevin',
                'Luthfi',
                'Made',
                'Naufal',
                'Oscar',
                'Putra',
                'Rizky',
                'Surya',
                'Taufik',
                'Yoga',
                'Zidan',
            ];
            $lastNames = [
                'Prakoso',
                'Wijaya',
                'Firmansyah',
                'Ramadhan',
                'Setiawan',
                'Nugroho',
                'Saputro',
                'Permana',
                'Kurniawan',
                'Mahendra',
                'Wibowo',
                'Santoso',
                'Pangestu',
                'Halim',
                'Purnama',
                'Kusuma',
            ];
            $levels = ['Bronze', 'Silver', 'Elektrum', 'Beginner'];
            $rosters = [];
            $nameSequence = 0;
            $athleteSequence = 0;

            foreach ($clubData as $clubIndex => $clubDataItem) {
                $clubName = $clubDataItem['nama_klub'];
                $rosters[$clubName] = [];

                foreach ($legacyRoster[$clubName] ?? [] as [$name, $gender, $level]) {
                    $rosters[$clubName][] = compact('name', 'gender', 'level');
                }

                while (count($rosters[$clubName]) < 5) {
                    $firstName = $firstNames[$nameSequence % count($firstNames)];
                    $lastName = $lastNames[intdiv($nameSequence, count($firstNames)) % count($lastNames)];
                    $nameSequence++;
                    $name = $firstName . ' ' . $lastName;

                    $rosters[$clubName][] = [
                        'name' => $name,
                        'gender' => ($clubIndex + count($rosters[$clubName])) % 2,
                        'level' => $levels[($clubIndex + count($rosters[$clubName])) % count($levels)],
                    ];
                }

                foreach ($rosters[$clubName] as $rosterIndex => $roster) {
                    $birthYear = 1988 + (($clubIndex * 2 + $rosterIndex * 3) % 16);
                    $birthMonth = (($clubIndex + $rosterIndex) % 12) + 1;
                    $birthDay = (($clubIndex * 3 + $rosterIndex * 4) % 27) + 1;
                    $athlete = Atlet::updateOrCreate(
                        ['nama_atlet' => $roster['name']],
                        [
                            'foto_atlet' => '',
                            'level' => $roster['level'],
                            'jenis_kelamin' => $roster['gender'],
                            'klub_id' => $clubs[$clubName]->id,
                            'tempat_lahir' => $clubDataItem['alamat'],
                            'tanggal_lahir' => sprintf('%04d-%02d-%02d', $birthYear, $birthMonth, $birthDay),
                            'kebangsaan' => 'Indonesia',
                        ]
                    );

                    $rosters[$clubName][$rosterIndex]['id'] = $athlete->id;
                    $this->seedTournamentHistory($athlete, $athleteSequence, $clubIndex);
                    $athleteSequence++;
                }
            }

            foreach ($seasons as $year => $season) {
                $seasonTotals = ['mp' => 0, 'w' => 0, 'l' => 0, 'pp' => 0, 'lp' => 0];

                foreach ($clubs->values() as $clubIndex => $club) {
                    $mp = 10 + (($clubIndex * 3 + ($year - 2022) * 2) % 11);
                    $wins = max(1, min($mp - 1, 4 + ((12 - $clubIndex) * 2 + ($year - 2022) * 2) % ($mp - 1)));
                    $losses = $mp - $wins;
                    $pointsFor = $wins * 5 + 18 + (($clubIndex * 7 + $year) % 34);
                    $pointsAgainst = $losses * 5 + 15 + (($clubIndex * 11 + $year * 3) % 34);
                    $statistics = [
                        'mp' => $mp,
                        'w' => $wins,
                        'l' => $losses,
                        'pp' => $pointsFor,
                        'lp' => $pointsAgainst,
                    ];

                    SeasonKlub::updateOrCreate(
                        ['season_id' => $season->id, 'klub_id' => $club->id],
                        $statistics
                    )->atlets()->sync(collect($rosters[$club->nama_klub])->pluck('id')->all());

                    foreach ($statistics as $key => $value) {
                        $seasonTotals[$key] += $value;
                    }
                }

                $season->update(array_map('strval', $seasonTotals));
            }

            $leagueResults = ['Champions', 'Runner Up', 'R4', 'R8', 'R16', 'R32', 'Kualifikasi'];
            foreach ($clubs->values() as $clubIndex => $club) {
                for ($leagueIndex = 0; $leagueIndex < 5; $leagueIndex++) {
                    $year = 2022 + $leagueIndex;
                    $month = (($clubIndex + $leagueIndex * 2) % 12) + 1;
                    $day = (($clubIndex * 2 + $leagueIndex * 5) % 27) + 1;

                    KlubRiwayatLiga::updateOrCreate(
                        [
                            'klub_id' => $club->id,
                            'nama_liga' => 'Demo League ' . $year,
                        ],
                        [
                            'hasil_liga' => $leagueResults[($clubIndex + $leagueIndex) % count($leagueResults)],
                            'tanggal_liga' => sprintf('%04d-%02d-%02d', $year, $month, $day),
                            'poin_liga' => max(40, 360 - ($clubIndex * 19) + ($leagueIndex * 9)),
                        ]
                    );
                }
            }
        });
    }

    private function seedTournamentHistory(Atlet $athlete, int $athleteSequence, int $clubIndex): void
    {
        AtletRiwayat::where('atlet_id', $athlete->id)
            ->where('nama_turnamen', 'like', 'Demo Tournament %')
            ->delete();

        $tournaments = ['Premiere Cup', 'City Open', 'National Padel Series'];
        $results = ['Champions', 'Runner Up', 'R4', 'R8', 'R16', 'R32', 'Kualifikasi'];

        foreach ($tournaments as $tournamentIndex => $tournament) {
            $year = 2022 + (($athleteSequence + $tournamentIndex) % 5);
            $month = (($athleteSequence + $tournamentIndex * 3) % 12) + 1;
            $day = (($athleteSequence * 2 + $tournamentIndex * 7) % 27) + 1;
            $resultIndex = ($athleteSequence + $clubIndex + $tournamentIndex) % count($results);

            AtletRiwayat::updateOrCreate(
                [
                    'atlet_id' => $athlete->id,
                    'nama_turnamen' => $tournament . ' ' . $year,
                ],
                [
                    'tanggal_turnamen' => sprintf('%04d-%02d-%02d', $year, $month, $day),
                    'hasil_turnamen' => $results[$resultIndex],
                    'poin_turnamen' => max(20, 240 - ($clubIndex * 12) + ($athleteSequence % 7) * 11 - $tournamentIndex * 17),
                ]
            );
        }
    }
}