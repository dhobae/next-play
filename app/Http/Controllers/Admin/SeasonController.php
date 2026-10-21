<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atlet;
use App\Models\Klub;
use App\Models\Season;
use App\Models\SeasonKlub;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class SeasonController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Season::query();
            if (! $request->filled('order')) {
                $query->latest();
            }

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->editColumn('tanggal_mulai', fn (Season $season) => $season->tanggal_mulai?->format('d-m-Y') ?: '-')
                ->editColumn('tanggal_selesai', fn (Season $season) => $season->tanggal_selesai?->format('d-m-Y') ?: '-')
                ->addColumn('aksi', fn (Season $season) => view('admin.season.partials.actions', compact('season'))->render())
                ->rawColumns(['aksi'])
                ->toJson();
        }

        return view('admin.season.index');
    }

    public function create()
    {
        $klubs = Klub::orderBy('nama_klub')->get();
        $atlets = Atlet::query()->with('klub')->orderBy('nama_atlet')->get();

        return view('admin.season.create', compact('klubs', 'atlets'));
    }

    public function show(Season $season)
    {
        if (request()->ajax()) {
            $query = $season->standingsKlub()->with(['klub', 'atlets']);
            if (! request()->filled('order')) {
                $query->latest('id');
            }

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('klub_nama', fn ($standing) => $standing->klub?->nama_klub ?: '-')
                ->addColumn('atlet_nama', fn ($standing) => $standing->atlets->pluck('nama_atlet')->implode(', ') ?: '-')
                ->filterColumn('klub_nama', function ($query, $keyword) {
                    $query->whereHas('klub', fn ($clubQuery) => $clubQuery->where('nama_klub', 'like', "%{$keyword}%"));
                })
                ->orderColumn('klub_nama', function ($query, $direction) {
                    $query->orderBy(
                        Klub::select('nama_klub')->whereColumn('klub.id', 'season_klub.klub_id'),
                        $direction
                    );
                })
                ->toJson();
        }

        return view('admin.season.show', compact('season'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        DB::transaction(function () use ($data) {
            $season = Season::create($data['season']);
            foreach ($data['standings'] as $standingData) {
                $atletIds = $standingData['atlet_ids'];
                unset($standingData['atlet_ids']);
                $season->standingsKlub()->create($standingData)->atlets()->syncWithPivotValues(
                    $atletIds,
                    ['season_id' => $season->id]
                );
            }

            $this->refreshLatestClubs(
                collect($data['standings'])->flatMap(fn (array $standing) => $standing['atlet_ids'])->unique()
            );
        });

        return redirect()->route('admin.season.index')->with('success', 'Season berhasil ditambahkan.');
    }

    public function edit(Season $season)
    {
        $klubs = Klub::orderBy('nama_klub')->get();
        $atlets = Atlet::query()->with('klub')->orderBy('nama_atlet')->get();
        $season->load('standingsKlub.atlets');

        return view('admin.season.edit', compact('season', 'klubs', 'atlets'));
    }

    public function update(Request $request, Season $season)
    {
        $data = $this->validated($request);
        DB::transaction(function () use ($data, $season) {
            $affectedAtletIds = $season->standingsKlub()
                ->with('atlets:id')
                ->get()
                ->flatMap(fn ($standing) => $standing->atlets->pluck('id'));

            $season->update($data['season']);
            $season->standingsKlub()->delete();
            foreach ($data['standings'] as $standingData) {
                $atletIds = $standingData['atlet_ids'];
                unset($standingData['atlet_ids']);
                $season->standingsKlub()->create($standingData)->atlets()->syncWithPivotValues(
                    $atletIds,
                    ['season_id' => $season->id]
                );
            }

            $affectedAtletIds = $affectedAtletIds
                ->merge(collect($data['standings'])->flatMap(fn (array $standing) => $standing['atlet_ids']))
                ->unique();

            $this->refreshLatestClubs($affectedAtletIds);
        });

        return redirect()->route('admin.season.index')->with('success', 'Season berhasil diperbarui.');
    }

    public function destroy(Season $season)
    {
        $season->delete();

        return redirect()->route('admin.season.index')->with('success', 'Season berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'nama_season' => 'required|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'klub_ids' => 'required|array|min:1',
            'klub_ids.*' => 'required|distinct|exists:klub,id',
            'stats' => 'required|array',
            'stats.*.mp' => 'required|integer',
            'stats.*.w' => 'required|integer',
            'stats.*.l' => 'required|integer',
            'stats.*.pp' => 'required|integer',
            'stats.*.lp' => 'required|integer',
            'atlets' => 'nullable|array',
            'atlets.*' => 'nullable|array',
            'atlets.*.*' => 'integer|exists:atlet,id',
        ]);

        $atletsByKlub = collect($validated['atlets'] ?? []);
        $selectedAtletIds = collect($validated['klub_ids'])
            ->flatMap(fn ($klubId) => $atletsByKlub->get($klubId, []));

        if ($selectedAtletIds->count() !== $selectedAtletIds->unique()->count()) {
            throw ValidationException::withMessages([
                'atlets' => 'Setiap atlet hanya boleh terdaftar satu kali dalam season yang sama.',
            ]);
        }

        return [
            'season' => [
                'nama_season' => $validated['nama_season'],
                'tanggal_mulai' => $validated['tanggal_mulai'] ?? null,
                'tanggal_selesai' => $validated['tanggal_selesai'] ?? null,
                'mp' => 0,
                'w' => 0,
                'l' => 0,
                'pp' => 0,
                'lp' => 0,
            ],
            'standings' => collect($validated['klub_ids'])->map(function ($klubId) use ($validated, $atletsByKlub) {
                $atletIds = collect($atletsByKlub->get($klubId, []))->map(fn ($id) => (int) $id)->values();

                return [
                    'klub_id' => $klubId,
                    ...$validated['stats'][$klubId],
                    'atlet_ids' => $atletIds->all(),
                ];
            })->all(),
        ];
    }

    private function refreshLatestClubs(Collection $atletIds): void
    {
        Atlet::query()
            ->whereIn('id', $atletIds)
            ->with('seasonKlubs.season')
            ->get()
            ->each(function (Atlet $atlet): void {
                $latestMembership = $atlet->seasonKlubs
                    ->filter(fn (SeasonKlub $standing): bool => $standing->season !== null)
                    ->sort(function (SeasonKlub $a, SeasonKlub $b): int {
                        $aDate = $a->season->tanggal_mulai?->getTimestamp();
                        $bDate = $b->season->tanggal_mulai?->getTimestamp();

                        if ($aDate !== null && $bDate !== null && $aDate !== $bDate) {
                            return $bDate <=> $aDate;
                        }

                        if (($aDate === null) !== ($bDate === null)) {
                            return $aDate === null ? 1 : -1;
                        }

                        $aCreatedAt = $a->season->created_at?->getTimestamp() ?? 0;
                        $bCreatedAt = $b->season->created_at?->getTimestamp() ?? 0;

                        return ($bCreatedAt <=> $aCreatedAt) ?: ($b->season_id <=> $a->season_id);
                    })
                    ->first();

                if ($latestMembership && $atlet->klub_id != $latestMembership->klub_id) {
                    $atlet->update(['klub_id' => $latestMembership->klub_id]);
                }
            });
    }
}
