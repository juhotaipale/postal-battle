@extends('layout/app')
@section('content')

    @auth
        <a href="{{ route('logout') }}">
            <font-awesome-icon icon="times-circle" size="3x" title="Exit game" class="position-absolute"
                               style="top: 15px; right: 15px; cursor: pointer;" />
        </a>

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