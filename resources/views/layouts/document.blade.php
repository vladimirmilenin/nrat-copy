<!DOCTYPE html>
<html lang="{{ app()->getLocale() == 'ua' ? 'uk' : 'en' }}">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="/favicon.png" type="image/x-icon">

    @yield('canonical')
    @yield('meta')
    @yield('opengraph')
    @yield('schemaorg')

    @vite('resources/css/app.scss')

    <title>@yield("title")</title>

    @include('templates.googletag')

</head>
<body>

    <main>
        <div class="container">
            @include('templates.header')
        </div>

        @yield('content')
    </main>

    @include('templates.footer')


    @vite('resources/js/app.js')
    @stack('extrascripts')

    {{-- @vite('resources/js/app.js') --}}

    {{-- @stack('extrascripts') --}}
</body>
</html>
