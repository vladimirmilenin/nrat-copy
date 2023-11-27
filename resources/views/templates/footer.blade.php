<footer class="page-footer text-muted text-center text-small">
    <div class="container">
        <div class="col ua-border my-5 pt-5">
            <p class="mb-1">© {{ Carbon\Carbon::today()->year }} {{ __('app.app_title') }}</p>
            <ul class="list-inline small">
                <li class="list-inline-item"><a href="{{ route('index', ['lang' => __('app.locale_version_code')]) }}">{{ __('app.locale_version') }}</a></li>
            </ul>
        </div>
    </div>
</footer>
