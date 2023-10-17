<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @yield('meta')
    @yield('opengraph')
    @yield('schemaorg')

    @vite('resources/css/app.scss')

    <title>@yield("title")</title>
</head>
<body>
    <div class="container">
        <main>

            <header class="py-2 mb-4 border-bottom">
                <div class="container d-flex flex-wrap align-items-center  justify-content-center">
                    <a href="/" class="mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none">
                        <img src="{{ Vite::asset('resources/images/logo.png') }}">
                    </a>
                    <form class="col-12 col-lg-auto mb-3 mb-lg-0 align-middle">
                        <input type="search" class="form-control align-middle" placeholder="{{ __('app.placeholder_search') }}..." aria-label="Search">
                    </form>
                </div>
            </header>


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
