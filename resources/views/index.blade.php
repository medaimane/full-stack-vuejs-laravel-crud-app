<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="appname" content="Full Stack VueJS/Laravel">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Full Stack VueJS/Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <script>
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            }
        </script>
        
    </head>
    <body>
        <div id="app">
            <navbar-component></navbar-component>
            
            <main role="main">
                <jumbotron-component></jumbotron-component> 
                <posts-component></posts-component>
            </main>

            <footer-component></footer-component>
        </div>
    </body>
</html>
