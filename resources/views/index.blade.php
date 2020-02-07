@extends('layout/app')
@section('content')

    @auth
        <pusher></pusher>
    @elseguest
        <login></login>
    @endauth

@endsection
