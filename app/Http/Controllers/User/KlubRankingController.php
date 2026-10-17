<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Klub;
use App\Models\KlubHero;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KlubRankingController extends Controller
{
    public function index(Request $request)
    {
        $hero = KlubHero::latest()->first();

        if ($request->ajax()) {
            $query = $this->rankingQuery();
            $rankByKlubId = (clone $query)
                ->orderByRaw('COALESCE(riwayat_liga_sum_poin_liga, 0) DESC')
                ->orderBy('nama_klub')
                ->pluck('id')
                ->flip()
                ->map(fn(int $rank) => $rank + 1);

            if (!$request->filled('order')) {
                $query->orderByRaw('COALESCE(riwayat_liga_sum_poin_liga, 0) DESC')
                    ->orderBy('nama_klub');
            }

            $dataTable = DataTables::eloquent($query)
                ->addColumn('rank', fn(Klub $klub) => $rankByKlubId[$klub->id] ?? '-')
                ->addColumn('klub_display', function (Klub $klub) {
                    $image = $klub->gambar
                        ? '<img src="' . e(asset('storage/' . $klub->gambar)) . '" alt="' . e($klub->nama_klub) . '">'
                        : '<span class="club-avatar-fallback"><i class="fa-solid fa-building"></i></span>';

                    return '<div class="ranking-club-name"><span class="ranking-club-avatar">' . $image . '</span><strong>' . e($klub->nama_klub) . '</strong></div>';
                })
                ->addColumn('detail_url', fn(Klub $klub) => route('peringkat-klub.show', $klub))
                ->addColumn('total_liga', fn(Klub $klub) => (int) $klub->riwayat_liga_count)
                ->addColumn('poin_liga', fn(Klub $klub) => (int) ($klub->riwayat_liga_sum_poin_liga ?? 0))
                ->orderColumn('total_liga', 'riwayat_liga_count $1')
                ->orderColumn('poin_liga', 'riwayat_liga_sum_poin_liga $1')
                ->filterColumn('klub_display', fn($query, $keyword) => $query->where('nama_klub', 'like', "%{$keyword}%"))
                ->filterColumn('total_liga', function ($query, $keyword) {
                    $query->whereRaw(
                        '(select count(*) from klub_riwayat_liga where klub_riwayat_liga.klub_id = klub.id) like ?',
                        ["%{$keyword}%"]
                    );
                })
                ->filterColumn('poin_liga', function ($query, $keyword) {
                    $query->whereRaw(
                        '(select coalesce(sum(klub_riwayat_liga.poin_liga), 0) from klub_riwayat_liga where klub_riwayat_liga.klub_id = klub.id) like ?',
                        ["%{$keyword}%"]
                    );
                })
                ->orderColumn('klub_display', 'nama_klub $1')
                ->rawColumns(['klub_display']);

            return $dataTable->toJson();
        }

        return view('user.klub-ranking.index', compact('hero'));
    }

    public function show(Klub $klub)
    {
        $ranking = $this->rankingQuery()
            ->orderByRaw('COALESCE(riwayat_liga_sum_poin_liga, 0) DESC')
            ->orderBy('nama_klub')
            ->pluck('id');

        $rank = $ranking->search($klub->id);
        $klub->load(['riwayatLiga' => fn($query) => $query->latest('tanggal_liga')->latest('id')]);
        $klub->loadSum('riwayatLiga', 'poin_liga');

        return view('user.klub-ranking.show', [
            'klub' => $klub,
            'rank' => $rank === false ? '-' : $rank + 1,
            'totalPoin' => (int) ($klub->riwayat_liga_sum_poin_liga ?? 0),
            'totalLiga' => $klub->riwayatLiga->count(),
        ]);
    }

    private function rankingQuery()
    {
        return Klub::query()
            ->withCount('riwayatLiga')
            ->withSum('riwayatLiga', 'poin_liga');
    }
}