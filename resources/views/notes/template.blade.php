<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>@yield('title')</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
    </head>
    <body>
        <nav>      
            <a href="{{ route('notes.show_creation') }}">Create note</a>      
            <a href="{{ route('notes.show_links') }}">Note links</a>
        </nav>

        @yield('content')

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        @yield('scripts')
    </body>
</html>