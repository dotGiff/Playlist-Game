<?php

namespace App\Models;

use App\Traits\FirstOrInstantiate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scoreForUser($user_id)
    {
        return $this->scores()->where('user_id', $user_id)->first();
    }

    public function round()
    {
        return $this->belongsTo(Round::class);
    }

    public function totalScoreForRound($round_id)
    {
        return Score::where('submission_id', $this->id)
            ->where('round_id', $round_id)
            ->sum('score');
    }

    public function allScoresAreIn()
    {
        return $this->round->season->participants->count() ==
            $this->scores->count();
    }
}
