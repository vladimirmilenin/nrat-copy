@php
    $currentRouteName = !empty(Route::current()) ? (Route::current()->getName()) : '';
@endphp
<header class="pb-2 mb-4 border-bottom">
    <div class="container d-flex flex-wrap align-items-center justify-content-center border-bottom">
        <ul class="nav col-12 col-md-auto my-2 justify-content-center my-md-0">
            <li><a href="{{ route('index', ['lang' => app()->getLocale()]) }}" @class([
                'nav-link px-2',
                'link-secondary' => in_array($currentRouteName, ['home', 'index']),
                'link-dark' => !in_array($currentRouteName, ['home', 'index']),
                ])>{{ __('app.menu.home') }}</a></li>
            <li><a href="{{ route('direction', ['lang' => app()->getLocale()]) }}" @class([
                'nav-link px-2',
                'link-secondary' => $currentRouteName == 'direction',
                'link-dark' => $currentRouteName !== 'direction',
            ])>{{ __('app.menu.direction') }}</a></li>
            <li><a href="{{ route('search', ['lang' => app()->getLocale()]) }}" @class([
                'nav-link px-2',
                'link-secondary' => $currentRouteName == 'search',
                'link-dark' => $currentRouteName !== 'search',
            ])>{{ __('app.menu.search') }}</a></li>
          </ul>
    </div>
    <div class="container d-flex flex-wrap align-items-center  justify-content-center">
        <a href="{{ route('index', ['lang' => app()->getLocale() ]) }}" class="my-3 my-lg-0 me-lg-auto text-dark text-decoration-none">
            <img class="logo" src="{{ Vite::asset('resources/images/logo_' . app()->getLocale() . '.webp') }}" alt="{{ __('app.app_title') }}" width="297" height="82">
        </a>

        <form method="GET" id="headerSearchForm" action="{{ route('search', ['lang' => app()->getLocale()]) }}" class="col-12 col-lg-auto mb-3 mb-lg-0 align-middle">
            @csrf
            <input type="hidden" name="sortOrder" value="score">
            <div class="input-group">
                <input type="text" name="searchTheme" class="search-input form-control" placeholder="{{ __('app.placeholder_search') }}..." aria-label="{{ __('app.placeholder_search') }}">
                {{-- <input type="text" name="searchFilter[]" class="search-input form-control" placeholder="{{ __('app.placeholder_search') }}..." aria-label="{{ __('app.placeholder_search') }}"> --}}
                <button class="btn btn-primary" name="btnSearch" type="submit" id="headerSearchButton">{{ __('app.search_link_search') }}</button>
            </div>
        </form>

    </div>
</header>
