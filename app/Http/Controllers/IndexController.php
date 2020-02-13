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


        return view('index');
    }
}
