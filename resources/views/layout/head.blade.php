<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Postal Battle - DBgames</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <script type="text/javascript" src="{{ asset('js/app.js') }}" defer></script>
    @auth
        <script>
            window.USER = '{{ \Illuminate\Support\Facades\Auth::user()->id }}';
        </script>
    @endauth
</head>
<body>
    <div id="app">
