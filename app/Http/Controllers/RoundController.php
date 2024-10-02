<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoundRequest;
use App\Http\Requests\UpdateRoundRequest;
use App\Models\Round;
use App\Models\Score;
use App\Models\Season;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoundController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $seasonId)
    {
        $round = new Round();
        $round->season_id = $seasonId;
        $round->name = $request->get('name');
        $round->category = $request->get('category');
        $round->description = $request->get('description');
        $round->save();

        return redirect()->route('season', ['seasonId' => $seasonId]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $seasonId, int $roundId)
    {
        $round = Round::findOrFail($roundId);
        $user = User::findOrFail(Auth::id());
        $season = Season::findOrFail($seasonId);
        return view('round.show', [
            'round' => $round,
            'submissions' => $round->submissions()->get()->keyby('user_id'),
            'users' => $season->participants,
            'season' => $round->season,
            'user' => $user,
            'submission' => $round->submissions()->where('user_id', Auth::id())->first() ?? null,
            'scoreSubmissionUserIds' => $round->scores()->get()->pluck('user_id')->unique()->toArray(),
        ]);
    }

    public function submitScores(Request $request, int $seasonId, int $roundId)
    {
        $user = Auth::user();
        $round = Round::findOrFail($roundId);

        $scoreMap = config('game.score_map');

        foreach ($round->submissions()->get() as $submission) {
            if (Score::where('user_id', Auth::id())->where('round_id', $roundId)->where('submission_id', $submission->id)->exists()) {
                continue;
            }
            $score = new Score();
            $score->user()->associate($user);
            $score->round()->associate($round);
            $score->submission()->associate($submission);
            if ($submission->id == $request->get('best')) {
                $rank = 1;
            } elseif ($submission->id == $request->get('second_best')) {
                $rank = 2;
            } elseif ($submission->id == $request->get('third_best')) {
                $rank = 3;
            } elseif (is_array($request->get('heard_it')) && in_array($submission->id, $request->get('heard_it'))) {
                $rank = 0;
            } else {
                $rank = 4;
            }
            $score->rank = $rank;
            $score->score = calculateScore($rank);
            $score->save();
        }

        return redirect()->route('round', ['seasonId' => $seasonId, 'roundId' => $roundId]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $seasonId, int $roundId)
    {
        Round::destroy($roundId);
        return redirect()->route('season', ['seasonId' => $seasonId]);
    }

    public function close(int $seasonId, int $roundId)
    {
        $round = Round::find($roundId);
        $round->closed_at = now();
        $round->save();

        return redirect()->route('round', ['seasonId' => $seasonId, 'roundId' => $roundId]);
    }

    public function showScores(int $seasonId, int $roundId)
    {
        $round = Round::find($roundId);
        $season = Season::find($seasonId);

        return view('round.scores', [
            'round' => $round,
            'season' => $season,
            'participants' => $season->participants,
            'totalScoresPerSubmission' => $round->totalScoresForRound()
        ]);
    }
}
