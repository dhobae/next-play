<?php

namespace Database\Seeders;

use App\Models\Atlet;
use App\Models\AtletRiwayat;
use App\Models\Klub;
use App\Models\Season;
use App\Models\SeasonKlub;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $clubs = collect([
                ['nama_klub' => 'Borneo Padel Club', 'alamat' => 'Banjarmasin'],
                ['nama_klub' => 'South Court Padel', 'alamat' => 'Banjarbaru'],
                ['nama_klub' => 'Kalimantan Smash', 'alamat' => 'Martapura'],
                ['nama_klub' => 'Rally House', 'alamat' => 'Banjarmasin'],
            ])->mapWithKeys(function (array $club) {
                $model = Klub::updateOrCreate(
                    ['nama_klub' => $club['nama_klub']],
                    ['alamat' => $club['alamat'], 'gambar' => '']
                );

                return [$club['nama_klub'] => $model];
            });

            $season = Season::updateOrCreate(
                ['nama_season' => 'Season Demo 2026'],
                [
                    'mp' => '0',
                    'w' => '0',
                    'l' => '0',
                    'pp' => '0',
                    'lp' => '0',
                    'tanggal_mulai' => '2026-01-01',
                    'tanggal_selesai' => '2026-12-31',
                ]
            );

            $standings = [
                'Borneo Padel Club' => [18, 14, 4, 96, 54],
                'South Court Padel' => [15, 10, 5, 81, 63],
                'Kalimantan Smash' => [12, 7, 5, 68, 61],
                'Rally House' => [9, 3, 6, 49, 72],
            ];

            foreach ($standings as $clubName => [$mp, $wins, $losses, $pointsFor, $pointsAgainst]) {
                SeasonKlub::updateOrCreate(
                    ['season_id' => $season->id, 'klub_id' => $clubs[$clubName]->id],
                    ['mp' => $mp, 'w' => $wins, 'l' => $losses, 'pp' => $pointsFor, 'lp' => $pointsAgainst]
                );
            }

            $seasonKlubs = SeasonKlub::where('season_id', $season->id)
                ->get()
                ->keyBy('klub_id');

            $athletes = [
                ['nama_atlet' => 'Andi Pratama', 'level' => 'Elektrum', 'jenis_kelamin' => 0, 'club' => 'Borneo Padel Club', 'points' => 320],
                ['nama_atlet' => 'Bima Saputra', 'level' => 'Silver', 'jenis_kelamin' => 0, 'club' => 'South Court Padel', 'points' => 245],
                ['nama_atlet' => 'Citra Lestari', 'level' => 'Silver', 'jenis_kelamin' => 1, 'club' => 'Kalimantan Smash', 'points' => 290],
                ['nama_atlet' => 'Dewi Anggraini', 'level' => 'Bronze', 'jenis_kelamin' => 1, 'club' => 'Rally House', 'points' => 175],
                ['nama_atlet' => 'Eko Maulana', 'level' => 'Beginner', 'jenis_kelamin' => 0, 'club' => 'Kalimantan Smash', 'points' => 120],
                ['nama_atlet' => 'Fajar Hidayat', 'level' => 'Bronze', 'jenis_kelamin' => 0, 'club' => 'Rally House', 'points' => 205],
            ];

            foreach ($athletes as $index => $data) {
                $athlete = Atlet::updateOrCreate(
                    ['nama_atlet' => $data['nama_atlet']],
                    [
                        'foto_atlet' => '',
                        'level' => $data['level'],
                        'jenis_kelamin' => $data['jenis_kelamin'],
                        'klub_id' => $clubs[$data['club']]->id,
                        'tempat_lahir' => 'Banjarmasin',
                        'tanggal_lahir' => '1990-01-01',
                        'kebangsaan' => 'Indonesia',
                    ]
                );

                AtletRiwayat::where('atlet_id', $athlete->id)->delete();
                AtletRiwayat::create([
                    'atlet_id' => $athlete->id,
                    'nama_turnamen' => 'Demo Tournament ' . ($index + 1),
                    'tanggal_turnamen' => '2026-08-' . str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
                    'hasil_turnamen' => 'R16',
                    'poin_turnamen' => $data['points'],
                ]);

                $seasonKlubs[$clubs[$data['club']]->id]
                    ->atlets()
                    ->syncWithoutDetaching([$athlete->id]);
            }

            foreach ($seasonKlubs as $seasonKlub) {
                $athleteIds = collect($athletes)
                    ->filter(fn (array $athlete) => $clubs[$athlete['club']]->id === $seasonKlub->klub_id)
                    ->map(fn (array $athlete) => Atlet::where('nama_atlet', $athlete['nama_atlet'])->value('id'))
                    ->filter()
                    ->values()
                    ->all();

                $seasonKlub->atlets()->sync($athleteIds);
            }
        });
    }
}