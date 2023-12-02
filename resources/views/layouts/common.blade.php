<!DOCTYPE html>
<html lang="{{ app()->getLocale() == 'ua' ? 'uk' : 'en' }}" class="h-100">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="/favicon.png" type="image/x-icon">

    @yield('canonical')
    @yield('description')


    <meta property="og:url" content="{{ Request::url() }}">
    <meta property="og:description" content="{{  __('app.common_description') }}">
    <meta property="og:locale" content="{{ __('app.meta_og_locale') }}">
    <meta property="og:site_name" content="{{ __('app.app_title') }}">
    <meta property="og:image" content="{{ Vite::asset('resources/images/atu_' . app()->getLocale() . '.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">


    @vite('resources/css/app.scss')


    <title>@yield("title")</title>

    @include('templates.googletag')
    {{-- APP_URL=https://uacademic.info --}}

</head>

<body class="d-flex flex-column justify-content-between h-100" id="page-top">


    <!-- Begin page content -->
    <main>
        <div class="container">
            @include('templates.header')
        </div>

        @yield('content')
    </main>


    @include('templates.footer')
</body>
</html>
