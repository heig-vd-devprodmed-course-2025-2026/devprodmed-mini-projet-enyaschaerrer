<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        @isset($description)
        <meta name="description" content="{{ $description }}" />
        @endisset
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        @isset($title)
        <title>{{ $title }} - {{ config('app.name') }}</title>
        @else
        <title>{{ config('app.name') }}</title>
        @endisset

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body>
        <header>
            <nav>
                <div>
                    <a href="{{ url('/') }}"> {{ config('app.name') }} </a>
                    <a href="{{ url('/profile') }}"> {{ __('ui.profile.title') }} </a>
                </div>
            </nav>
        </header>

        <main>{{ $slot }}</main>

        <footer>
            <div>
                <div>
                    <p>{{ __('ui.about.copyright', ['year' => date('Y')]) }}</p>
                    <a href="{{ url('/about') }}"> {{ __('ui.about.title') }} </a>
                </div>
            </div>
        </footer>
    </body>
</html>