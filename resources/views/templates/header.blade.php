<header class="py-2 mb-4 border-bottom">
    <div class="container d-flex flex-wrap align-items-center  justify-content-center">
        <a href="{{ route('index', ['lang' => app()->getLocale() ]) }}" class="mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none">
            <img class="logo" src="{{ Vite::asset('resources/images/logo_' . app()->getLocale() . '.webp') }}" alt="{{ __('app.app_title') }}" width="297" height="82">
        </a>
        <form class="col-12 col-lg-auto mb-3 mb-lg-0 align-middle">
            <input type="search" class="form-control align-middle" placeholder="{{ __('app.placeholder_search') }}..." aria-label="Search">
        </form>
    </div>
</header>
