<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Klub;
use App\Models\Season;
use App\Models\SeasonKlub;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $seasons = $this->decorateRanks($this->seasonQuery()->limit(5)->get());
        $hasMoreSeasons = Season::query()->count() > 5;

        return view('user.history.index', compact('seasons', 'hasMoreSeasons'));
    }

    public function loadMore(Request $request)
    {
        $page = max(2, $request->integer('page', 2));
        $seasons = $this->decorateRanks($this->seasonQuery()
            ->skip(($page - 1) * 5)
            ->limit(5)
            ->get());

        return response()->json([
            'html' => view('user.history.partials.season-card', compact('seasons'))->render(),
            'has_more' => $seasons->count() === 5 && Season::query()->count() > $page * 5,
        ]);
    }

    public function show(Season $season, Klub $klub)
    {
        $standing = SeasonKlub::query()
            ->where('season_id', $season->id)
            ->where('klub_id', $klub->id)
            ->with('atlets')
            ->firstOrFail();

        $standing->load(['atlets' => fn($query) => $query->orderBy('nama_atlet')]);
        $seasonStandings = $this->seasonQuery()
            ->whereKey($season->id)
            ->firstOrFail()
            ->standingsKlub;
        $standing->setAttribute('rank', $seasonStandings->search(fn($item) => $item->id === $standing->id) + 1);

        return view('user.history.show', compact('season', 'klub', 'standing'));
    }

    private function seasonQuery()
    {
        return Season::query()
            ->with([
                'standingsKlub' => function ($query) {
                    $query->with('klub')
                        ->whereHas('klub')
                        ->orderByDesc('w')
                        ->orderByDesc('pp')
                        ->orderBy('lp')
                        ->orderBy(
                            Klub::select('nama_klub')->whereColumn('klub.id', 'season_klub.klub_id')
                        );
                }
            ])
            ->orderByDesc('created_at')
            ->orderByDesc('id');
    }

    private function decorateRanks($seasons)
    {
        return $seasons->each(function (Season $season): void {
            $season->standingsKlub->values()->each(function (SeasonKlub $standing, int $index): void {
                $standing->setAttribute('rank', $index + 1);
            });
        });
    }
}