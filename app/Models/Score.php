<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Score extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function round(): BelongsTo
    {
        return $this->belongsTo(Round::class);
    }

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    public static function calculateScore($rank): int
    {
        $map = config('game.score_map');

        foreach ($map as $v) {
            if (compare($rank, $v[1], $v[0])) {
                return $v[2];
            }
        }
    }

    public static function explainRank($rank): string
    {
        $map = config('game.score_map');

        foreach ($map as $v) {
            if (compare($rank, $v[1], $v[0])) {
                return $v[3];
            }
        }
    }

}
