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

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-FEM99EH898"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-FEM99EH898');
    </script>

</head>
<body>
    <div class="container">
        <main>
            @include('templates.header')
            @yield('content')
        </main>

        <footer class="my-5 pt-5 text-muted text-center text-small ua-border">
            <p class="mb-1">© {{ Carbon\Carbon::today()->year }} {{ __('app.app_title') }}</p>
            <ul class="list-inline small">
                <li class="list-inline-item"><a href="{{ route('index', ['lang' => __('app.locale_version_code')]) }}">{{ __('app.locale_version') }}</a></li>
            </ul>
        </footer>
    </div>



    @vite('resources/js/app.js')
    @stack('extrascripts')
</body>
</html>
