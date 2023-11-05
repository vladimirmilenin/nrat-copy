<!DOCTYPE html>
<html lang="{{ app()->getLocale() == 'ua' ? 'uk' : 'en' }}" class="h-100">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="/favicon.png" type="image/x-icon">

    <meta name="description" content="{{  __('app.common_description') }}">
    <meta name="keywords" content="{{ __('app.common_keywords', ['year' => ($document->document['addons']['documentYear'] ?? '')]) }}">


    <meta property="og:url" content="{{ Request::url() }}">
    <meta property="og:description" content="{{  __('app.common_description') }}">
    <meta property="og:locale" content="{{ __('app.meta_og_locale') }}">
    <meta property="og:site_name" content="{{ __('app.app_title') }}">
    <meta property="og:image" content="{{ Vite::asset('resources/images/atu_' . app()->getLocale() . '.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">


    @vite('resources/css/app.scss')

    <title>{{ __('app.common_title') }}</title>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-FEM99EH898"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-FEM99EH898');
    </script>

</head>

<body class="d-flex flex-column justify-content-between h-100">

    <!-- Begin page content -->
    <main>
        <div class="container">
            @include('templates.header')
        </div>

        @yield('content')
    </main>


    <footer class="page-footer text-muted text-center text-small">
        <div class="container ua-border my-5 pt-5 ">
        <p class="mb-1">© {{ Carbon\Carbon::today()->year }} {{ __('app.app_title') }}</p>
        <ul class="list-inline small">
            <li class="list-inline-item"><a href="{{ route('index', ['lang' => __('app.locale_version_code')]) }}">{{ __('app.locale_version') }}</a></li>
        </ul>
        </div>
    </footer>

</body>

</html>
