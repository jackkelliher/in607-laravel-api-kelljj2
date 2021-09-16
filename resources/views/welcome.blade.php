<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    </head>
    <body>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </body>
</html>
