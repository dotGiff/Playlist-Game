<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSeasonRequest;
use App\Models\Season;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeasonController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::find(Auth::id());
        if (!$user->isAdmin()) {
            return back();
        }
        return view('season.create', [
            'users' => User::all(),
            'user' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $season = new Season();
        $season->name = $request->get('season_name');
        $season->user_id = $request->get('user_id');
        $season->save();

        foreach ($request->get('users') as $user) {
            $season->users()->attach($user);
        }

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $seasonId)
    {
        $season = Season::findOrFail($seasonId);
        return view('season.show', [
            'season' => $season,
            'rounds' => $season->rounds()->with('submissions')->get()
        ]);
    }

    public function leaderboard(int $seasonId)
    {
        $season = Season::findOrFail($seasonId);

        return view('season.leaderboard', [
            'season' => $season,
            'users' => $season->participants->each(function (User $user) use ($season) {
                $user->seasonScore = $user->calculateScoreForSeason($season->id);
                $user->wins = $user->calculateHowManyWinsForSeason($season->id);
            })->sortByDesc([
                ['wins', 'desc'],
                ['seasonScore', 'desc'],
            ])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $seasonId)
    {
        Season::destroy($seasonId);
        return redirect()->route('dashboard');
    }
}
