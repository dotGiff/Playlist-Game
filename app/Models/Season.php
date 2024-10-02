<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    public function rounds()
    {
        return $this->hasMany(Round::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function isMySeason($userId)
    {
        return $this->user_id == $userId;
    }

    public function userAdmin()
    {
        return $this->belongsTo(User::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class);
    }
}
