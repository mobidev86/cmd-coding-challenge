<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Request a Quote - Property Services</title>

    @filamentStyles
    @vite('resources/css/app.css')

</head>

<body class="antialiased">
    <div class="min-h-screen py-6 sm:py-12 px-3 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            @livewire('quote-request-form')
        </div>
    </div>

    @filamentScripts
    @vite('resources/js/app.js')
</body>

</html>
