<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function seasonsAsAdmin()
    {
        return $this->hasMany(Season::class);
    }

    public function hasSubmittedScoresForRound(int $roundId)
    {
        return $this->scores()->where('round_id', $roundId)->exists();
    }

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    public function seasonsAsParticipant()
    {
        return $this->belongsToMany(Season::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function roundWins()
    {
        return $this->hasMany(Round::class);
    }

    public function scoresForRound(int $roundId)
    {
        return $this->scores;
    }

    public function calculateScoreForSeason(int $seasonId)
    {
        return $this->submissions()->whereHas('round', function ($query) use ($seasonId) {
            $query->where('season_id', $seasonId);
        })->sum('calculated_score');
    }

    public function calculateHowManyWinsForSeason(int $seasonId)
    {
        return $this->roundWins()->where('season_id', $seasonId)->count();
    }
}
