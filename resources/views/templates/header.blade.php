<header class="py-2 mb-4 border-bottom">
    <div class="container d-flex flex-wrap align-items-center  justify-content-center">
        <a href="{{ route('index', ['lang' => app()->getLocale() ]) }}" class="mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none">
            <img class="logo" src="{{ Vite::asset('resources/images/logo_' . app()->getLocale() . '.webp') }}" alt="{{ __('app.app_title') }}" width="297" height="82">
        </a>

        <form method="GET" id="headerSearchForm" action="{{ route('search', ['lang' => app()->getLocale()]) }}" class="col-12 col-lg-auto mb-3 mb-lg-0 align-middle">
            @csrf
            <input type="hidden" name="sortOrder" value="score">
            <div class="input-group">
                <input type="text" name="searchContent" class="search-input form-control" placeholder="{{ __('app.placeholder_search') }}..." aria-label="{{ __('app.placeholder_search') }}">
                {{-- <input type="text" name="searchFilter[]" class="search-input form-control" placeholder="{{ __('app.placeholder_search') }}..." aria-label="{{ __('app.placeholder_search') }}"> --}}
                <button class="btn btn-primary" name="btnSearch" type="submit" id="headerSearchButton">{{ __('app.search_link_search') }}</button>
            </div>
        </form>

    </div>
</header>
