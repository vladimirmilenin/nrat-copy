<form method="GET" id="mainSearchForm" action="{{ route('search', ['lang' => app()->getLocale()]) }}" class="col-12 col-lg-auto mb-3 mb-lg-0 align-middle">
    @csrf
    <input type="hidden" name="sortOrder" value="score">
    <div class="input-group">
        <input type="text" name="searchFilter[]" class="search-input form-control" placeholder="{{ __('app.placeholder_search') }}..." aria-label="{{ __('app.placeholder_search') }}">
        <button class="btn btn-primary" name="btnSearch" type="submit" id="headerSearchButton">{{ __('app.search_button_search') }}</button>
    </div>
</form>
