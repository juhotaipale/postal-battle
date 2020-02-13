@extends('layout/app')
@section('content')

    @auth
        <div class="position-absolute text-right" style="top: 35px; right: 30px;">
            Player: <b>{{ \Illuminate\Support\Facades\Auth::user()->name }}</b><br />
            <a href="{{ route('logout') }}">End session</a>
        </div>

        @if (isset($game))
            <game :uuid="{{ json_encode($game->id) }}"></game>
        @else
            <select-game :games="{{ json_encode($games) }}"></select-game>
        @endif
    @endauth

    @guest
        <login></login>
    @endguest

@endsection