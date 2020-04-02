<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="api-base-url" content="{{ url('demos/app') }}" />


        <title>Fashion clue</title>
        <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
                <link rel="stylesheet" href="{{asset('css/app.css')}}">


    </head>
    <body>
        <div id="app">
            <app-component/>
        </div>
        <script>
            window.Laravel = {!! json_encode([
                'apiToken' => \Auth::user()->api_token ?? null
            ]) !!};
        </script>
                <script src="https://cdn.linearicons.com/free/1.0.0/svgembedder.min.js"></script>
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>