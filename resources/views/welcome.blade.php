<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        @vite('resources/scss/user.scss')
    </head>
    <body>
        <div class="container">
            <p class="text">Hello world</p>
        </div>
    </body>
</html>
