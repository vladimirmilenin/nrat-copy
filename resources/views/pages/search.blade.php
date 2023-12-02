@extends('layouts.common')


@section('description')
<meta name="description" content="{{  __('app.common_description') }}">
<meta name="keywords" content="{{ __('app.common_keywords', ['year' => ($document->document['addons']['documentYear'] ?? '')]) }}">
@endsection

@section('title')
{{ __('app.search_title') }}
@endsection


@section('content')
<div class="container">
    <div class="row">
        <div id="mainSide" class="col-md-7 col-lg-8 overflow-hidden">
            <div id="tabContainer">
                    <ul class="nav nav-pills mb-3" id="formTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button @class(['nav-link', 'active' =>  Cookie::has('panelAdvancedSearch')]) id="panelAdvancedSearch" data-bs-toggle="tab" data-bs-target="#advanced-tab" type="button" role="tab" aria-controls="advanced-tab" aria-selected="false">{{ __('app.search_heading_advanced') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button @class(['nav-link', 'active' => Cookie::has('panelFormalizedSearch')])  id="panelFormalizedSearch" data-bs-toggle="tab" data-bs-target="#formalized-tab" type="button" role="tab" aria-controls="formalized-tab" aria-selected="true">{{ __('app.search_heading_formalized') }}</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="formTabContent">
                        <div @class(["tab-pane fade", "show active" => Cookie::has('panelAdvancedSearch')]) id="advanced-tab" role="tabpanel" aria-labelledby="panelAdvancedSearch">
                            <form method="GET" id="advancedSearchForm" data-submit-allowed="0">
                                @csrf
                                <input type="hidden" name="sortOrder" value="score">
                                <input type="hidden" name="searchType" value="okd">

                                @foreach ((old('searchFilter') ?? $fill['searchFilter'] ?? []) as $step)
                                <div class="input-group mb-3">
                                    @if (!$errors->has("Filter.*"))
                                        <input type="text" readonly class="form-control bg-secondary bg-opacity-10" name="searchFilter[]" value="{{ $step }}">
                                        <button class="btn btn-outline-secondary remove-input" type="button"><x-bi-x class="w-6 h-6"/></button>
                                    @else
                                        <input type="text" @readonly(!$loop->last) @if($loop->last) id="lastField" @endif @class(['form-control', 'bg-secondary bg-opacity-10' => !$loop->last, 'is-invalid' => $loop->last]) name="searchFilter[]" value="{{ $step }}">
                                        @if ($loop->index <= $loop->count - 2)
                                        <button class="btn btn-outline-secondary remove-input" type="button"><x-bi-x class="w-6 h-6"/></button>
                                        @endif
                                        @if ($loop->last)
                                            @error("Filter.*")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        @endif
                                    @endif
                                </div>
                                @endforeach

                                @unless ($errors->has("Filter.*"))
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="lastField" name="searchFilter[]" value="">
                                </div>
                                @endunless

                                <div id="formButtons">
                                    <div class="row g-md-2">
                                        <div class="col-md mb-3 order-md-last">
                                            <div class="form-floating d-grid">
                                                <button class="btn btn-primary btn-lg" type="submit" id="advancedSubmitButton" name="btnSearch" value="1">{{ __('app.search_button_search') }}</button>
                                            </div>
                                        </div>
                                        <div class="col-md mb-3">
                                            <div class="form-floating d-grid">
                                                <a href="{{ route('search', ['lang' => app()->getLocale()]) }}" class="btn btn-secondary btn-lg" name="btnClear" value="1">{{ __('app.search_button_clear') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div @class(["tab-pane fade", "show active" => Cookie::has('panelFormalizedSearch')]) id="formalized-tab" role="tabpanel" aria-labelledby="panelFormalizedSearch">
                            <form method="GET" id="formalizedSearchForm">
                                @csrf
                                <div class="form-floating mb-3">
                                    <input name="searchAuthor" id="searchAuthor" class="form-control @error('Author') is-invalid @enderror" type="text" value="{{ old('searchAuthor') ?? $fill['searchAuthor'] ?? '' }}" placeholder="{{ __('app.search_label_person_name') }}">
                                    @error("Author")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <label for="searchAuthor">{{ __('app.search_label_person_name') }}</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input name="searchTheme" id="searchTheme" class="form-control  @error('Theme') is-invalid @enderror" type="text" value="{{ old('searchTheme') ?? $fill['searchTheme'] ?? '' }}" placeholder="{{ __('app.search_label_theme') }}">
                                    @error("Theme")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <label for="searchTheme">{{ __('app.search_label_theme') }}</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input name="searchContent" id="searchContent" class="form-control @error("Content") is-invalid @enderror" type="text" value="{{ old('searchContent') ?? $fill['searchContent'] ?? '' }}" placeholder="{{ __('app.search_label_content') }}">
                                    @error("Content")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <label for="searchContent">{{ __('app.search_label_content') }}</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input name="searchRegNo" id="searchRegNo" class="form-control @error("RegNo") is-invalid @enderror" type="text" value="{{ old('searchRegNo') ?? $fill['searchRegNo'] ?? '' }}" placeholder="xxxxUxxxxxx">
                                    @error("RegNo")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <label for="searchRegNo">{{ __('app.search_label_regno') }}</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-select" name="searchType" id="searchType">
                                        @foreach (__('app.search_document_types') as $key => $type)
                                            <option value="{{ $key }}" @selected((old('searchType') ?? $fill['searchType'] ?? 'okd') == $key)>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                    <label for="searchType">{{ __('app.search_label_document_type') }}</label>
                                </div>
                                <div class="row g-md-2">
                                    <div class="col-md mb-3">
                                        <div class="form-floating">
                                            <input name="searchDateFrom" id="searchDateFrom" type="date" class="form-control @error("DateFrom") is-invalid @enderror" value="{{ old('searchDateFrom') ?? $fill['searchDateFrom'] ?? '' }}" placeholder="{{ __('app.search_label_date_from') }}">
                                            @error("DateFrom")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <label for="searchDateFrom">{{ __('app.search_label_date_from') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md mb-3">
                                        <div class="form-floating">
                                            <input name="searchDateTo" id="searchDateTo" type="date" class="form-control @error("DateTo") is-invalid @enderror" value="{{ old('searchDateTo') ?? $fill['searchDateTo'] ?? '' }}" placeholder="{{ __('app.search_label_date_to') }}">
                                            @error("DateTo")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <label for="searchDateTo">{{ __('app.search_label_date_to') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-select" name="sortOrder" id="sortOrder">
                                        @foreach (__('app.search_sort_types') as $key => $sort)
                                            <option value="{{ $key }}" @selected((old('sortOrder') ?? $fill['sortOrder'] ?? 'score') == $key)>{{ $sort }}</option>
                                        @endforeach
                                    </select>
                                    <label for="sortOrder">{{ __('app.search_label_sort') }}</label>
                                </div>
                                <div class="row g-md-2">
                                    <div class="col-md mb-3 order-md-last">
                                        <div class="form-floating d-grid">
                                            <button class="btn btn-primary btn-lg" type="submit" name="btnSearch" value="1">{{ __('app.search_button_search') }}</button>
                                        </div>
                                    </div>
                                    <div class="col-md mb-3">
                                        <div class="form-floating d-grid">
                                            <a href="{{ route('search', ['lang' => app()->getLocale()]) }}" class="btn btn-secondary btn-lg" name="btnClear" value="1">{{ __('app.search_button_clear') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
            </div><!-- tabContainer -->

            @include('templates.searchresult')

        </div>

        @include('templates.aside')


    </div>








</div>


@endsection


@push('extrascripts')
    @vite('resources/js/pages/search.js')
@endpush


