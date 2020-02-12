<?php

namespace App\Http\Controllers;

use App\Game;
use App\Http\Resources\GameResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        // $game = optional(Auth::user())->game ? new GameResource(Auth::user()->game) : null;

        return view('index');
    }
}
