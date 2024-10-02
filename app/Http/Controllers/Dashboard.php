<?php

namespace App\Http\Controllers;

use App\Models\Season;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function show()
    {
        return view('dashboard', [
            'seasons' => Season::get(),
            'user' => User::findOrFail(Auth::id()),
        ]);
    }
}
