<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel + Vue 3 + PrimeVue</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body>
<div id="app">
    <example-component></example-component>
</div>
</body>
</html>
