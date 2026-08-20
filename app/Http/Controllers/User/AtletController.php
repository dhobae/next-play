<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Atlet;
use App\Models\AtletHero;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AtletController extends Controller
{
    public function index(Request $request)
    {
        $hero = AtletHero::latest()->first();

        if ($request->ajax()) {
            $query = Atlet::query()
                ->withSum('riwayatTurnamen', 'poin_turnamen')
                ->when($request->filled('jenis_kelamin'), function ($query) use ($request) {
                    $query->where('jenis_kelamin', (int) $request->jenis_kelamin);
                })
                ->when($request->filled('level'), function ($query) use ($request) {
                    $levels = [
                        'bronze' => 'Bronze',
                        'silver' => 'Silver',
                        'elektrum' => 'Elektrum',
                        'beginner' => 'Beginner',
                    ];

                    if (isset($levels[$request->level])) {
                        $query->where('level', $levels[$request->level]);
                    }
                })
                ->orderByDesc('riwayat_turnamen_sum_poin_turnamen')
                ->orderBy('nama_atlet');

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('nama_atlet_display', function (Atlet $atlet) {
                    $initial = strtoupper(substr($atlet->nama_atlet, 0, 1));
                    $foto = $atlet->foto_atlet
                        ? '<img src="' . e(asset('storage/' . $atlet->foto_atlet)) . '" alt="' . e($atlet->nama_atlet) . '">'
                        : '<span class="athlete-avatar-fallback">' . e($initial) . '</span>';

                    $level = '<span class="level-badge level-' . strtolower($atlet->level) . '"><i class="' . $this->levelIcon($atlet->level) . '"></i>' . '(' . e($atlet->level) . ')' . '</span>';

                    return '<div class="athlete-name"><span class="athlete-avatar">' . $foto . '</span><div><strong>' . e($atlet->nama_atlet) . '</strong>' . $level . '</div></div>';
                })
                ->addColumn('detail_url', fn(Atlet $atlet) => route('atlets.show', $atlet))
                ->addColumn('poin', fn(Atlet $atlet) => (int) ($atlet->riwayat_turnamen_sum_poin_turnamen ?? 0))
                ->editColumn('klub_asosiasi', fn(Atlet $atlet) => $atlet->klub_asosiasi ?: '-')
                ->rawColumns(['nama_atlet_display'])
                ->toJson();
        }

        return view('user.atlets.index', compact('hero'));
    }

    public function show(Atlet $atlet)
    {
        $atlet->load(['riwayatTurnamen' => fn($query) => $query->latest('tanggal_turnamen')->latest('id')]);
        $atlet->loadSum('riwayatTurnamen', 'poin_turnamen');

        $ranking = Atlet::query()
            ->withSum('riwayatTurnamen', 'poin_turnamen')
            ->orderByDesc('riwayat_turnamen_sum_poin_turnamen')
            ->orderBy('nama_atlet')
            ->pluck('id');

        $rank = $ranking->search($atlet->id);
        $totalPoin = (int) ($atlet->riwayat_turnamen_sum_poin_turnamen ?? 0);

        return view('user.atlets.show', [
            'atlet' => $atlet,
            'rank' => $rank === false ? '-' : $rank + 1,
            'totalPoin' => $totalPoin,
            'totalTurnamen' => $atlet->riwayatTurnamen->count(),
        ]);
    }

    private function levelIcon(string $level): string
    {
        return match (strtolower($level)) {
            'elektrum' => 'fa-solid fa-crown',
            'silver' => 'fa-solid fa-medal',
            'bronze' => 'fa-solid fa-medal',
            'beginner' => 'fa-solid fa-shield-halved',
            default => 'fa-solid fa-shield-halved',
        };
    }
}
