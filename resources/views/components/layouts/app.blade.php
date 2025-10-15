<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Request a Quote - Property Services' }}</title>

        @filamentStyles
        @vite('resources/css/app.css')

        <style>
            [x-cloak] { display: none !important; }

        </style>
    </head>
    <body class="antialiased">
        <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold header-gradient mb-4">Request a Quote</h1>
                    <p class="text-white text-lg max-w-2xl mx-auto">
                        Get a professional quote for your property services. Fill out the form below and we'll get back to you within 24 hours.
                    </p>
                </div>

                {{ $slot }}
            </div>
        </div>

        @filamentScripts
        @vite('resources/js/app.js')
    </body>
</html>
