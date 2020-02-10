@extends('layout/app')
@section('content')

    @auth
        <a href="{{ route('logout') }}">
            <font-awesome-icon icon="times-circle" size="3x" title="Exit game" class="position-absolute"
                               style="top: 10px; right: 10px; cursor: pointer;" />
        </a>

        <game></game>
    @endauth

    @guest
        <login></login>
    @endguest

@endsection
