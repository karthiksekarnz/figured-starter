<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>LaraBlog</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">

    </head>
    <body>
        <App></App>
        <script src="{{ asset(mix('js/app.js')) }}"></script>
    </body>
</html>
