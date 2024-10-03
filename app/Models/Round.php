<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'closed_at' => 'datetime',
            'start_at' => 'datetime',
        ];
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function winner()
    {
        $participants = $this->season->participants;
        foreach ($participants as $participant) {
            $participant->roundTotal = $this->calculateScore($participant);
        }

        return $participants->sortByDesc('roundTotal')->first();
    }

    public function allSubmissionScoresAreIn()
    {
        if ($this->submissions->count() == 0) {
            return false;
        }

        foreach ($this->submissions as $submission) {
            if(! $submission->allScoresAreIn()) {
                return false;
            }
        }

        return true;
    }

    public function allSubmissionsAreIn()
    {
        return $this->season->participants()->count() == $this->submissions()->count();
    }

    public function isOpenForSubmissions()
    {
        return ($this->start_at <= now() || is_null($this->start_at)) && $this->closed_at >= now() || is_null($this->closed_at);
    }

    public function getSubmissionPercentage()
    {
        return $this->season->participants()->count()
            ? round(($this->submissions()->count() / $this->season->participants()->count()) * 100)
            : 0;
    }

    public function getSubmissionPercentageColor()
    {
        $percentage = $this->getSubmissionPercentage();
        if ($percentage < 33) {
            return 'red';
        } elseif ($percentage < 66) {
            return 'orange';
        } elseif ($percentage < 99) {
            return 'yellow';
        } else {
            return 'green';
        }
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function scoresForUser($user_id)
    {
        return Score::where('round_id', $this->id)
            ->where('user_id', $user_id)
            ->get()
            ->keyBy('submission_id');
    }

    public function close()
    {
        $this->closed_at = now();
        $submissions = $this->calculateScores();
        $this->user_id = $submissions->sortByDesc('calculated_score')->first()->user_id;
        $this->save();
    }

    public function calculateScores()
    {
        foreach ($this->submissions as $submission) {
            $submission->calculateScore($this->id);
        }

        return $this->submissions;
    }

    public function calculateScore(User $user)
    {
        return $this->scores->where('submissions.user_id', $user->id)->sum('score');
    }

    public function totalScoresForRound()
    {
        $submissions = $this->submissions;
        $submissions->each(function ($submission) {
            $submission->totalScore = $submission->totalScoreForRound($this->id);
        });

        return $submissions->pluck('totalScore')->toArray();
    }
}
