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
        <div class="col-md-7 col-lg-8">
            <div class="accordion accordion-flush" id="accordionSearchPanels">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelFormalizedSearch-open">
                        <button @class(['accordion-button fw-bold', 'collapsed' => !Cookie::has('panelFormalizedSearch')])  type="button" data-bs-toggle="collapse" data-bs-target="#panelFormalizedSearch" aria-expanded="true" aria-controls="panelFormalizedSearch">
                            {{ __('app.search_heading_formalized') }}
                        </button>
                    </h2>
                    <div id="panelFormalizedSearch" @class(["accordion-collapse collapse", 'show' => Cookie::has('panelFormalizedSearch')]) aria-labelledby="panelFormalizedSearch-open">
                        <div class="accordion-body px-0">
                            <form method="GET" id="formalizedSearchForm">
                                @csrf
                                <div class="form-floating mb-3">
                                    <select class="form-select" name="searchType" id="searchType">
                                        <option value="all">{{ __('app.search_document_types.all') }}</option>
                                        <option value="okd">{{ __('app.search_document_types.okd') }}</option>
                                        <option value="ok">{{ __('app.search_document_types.ok') }}</option>
                                    </select>
                                    <label for="searchType">{{ __('app.search_label_document_type') }}</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input name="searchAuthor" id="searchAuthor" class="form-control" type="text" value="" placeholder="{{ __('app.search_label_person_name') }}">
                                    <label for="searchAuthor">{{ __('app.search_label_person_name') }}</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input name="searchTheme" id="searchTheme" class="form-control" type="text" value="" placeholder="{{ __('app.search_label_theme') }}">
                                    <label for="searchTheme">{{ __('app.search_label_theme') }}</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input name="searchContent" id="searchContent" class="form-control" type="text" value="" placeholder="{{ __('app.search_label_content') }}">
                                    <label for="searchContent">{{ __('app.search_label_content') }}</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input name="searchRegNo" id="searchRegNo" class="form-control" type="text" value="" placeholder="xxxxUxxxxxx">
                                    <label for="searchRegNo">{{ __('app.search_label_regno') }}</label>
                                </div>
                                <div class="row g-md-2">
                                    <div class="col-md mb-3">
                                        <div class="form-floating">
                                            <input name="searchDateFrom" id="searchDateFrom" type="date" class="form-control " value="" placeholder="{{ __('app.search_label_date_from') }}">
                                            <label for="searchDateFrom">{{ __('app.search_label_date_from') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md mb-3">
                                        <div class="form-floating">
                                            <input name="searchDateTo" id="searchDateTo" type="date" class="form-control " value="" placeholder="{{ __('app.search_label_date_to') }}">
                                            <label for="searchDateTo">{{ __('app.search_label_date_to') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-select" name="sortOrder" id="sortOrder">
                                        <option value="registration_date">{{ __('app.search_sort_types.registration_date') }}</option>
                                        <option value="author">{{ __('app.search_sort_types.author') }}</option>
                                        <option value="score">{{ __('app.search_sort_types.score') }}</option>
                                    </select>
                                    <label for="sortOrder">{{ __('app.search_label_sort') }}</label>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary" type="submit" name="btnSearch" value="1">{{ __('app.search_button_search') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelAdvancedSearch-open">
                        <button @class(['accordion-button fw-bold', 'collapsed' => !Cookie::has('panelAdvancedSearch')]) type="button" data-bs-toggle="collapse" data-bs-target="#panelAdvancedSearch" aria-expanded="false" aria-controls="panelAdvancedSearch">
                            {{ __('app.search_heading_advanced') }}
                        </button>
                    </h2>
                    <div id="panelAdvancedSearch" @class(["accordion-collapse collapse", 'show' => Cookie::has('panelAdvancedSearch')]) aria-labelledby="panelAdvancedSearch-open">
                        <div class="accordion-body px-0">
                            <form method="GET" id="advancedSearchForm">
                                @csrf
                                <input type="hidden" name="sortOrder" value="score">
                                <div class="input-group mb-3">
                                    <input name="searchFilter[]" class="form-control" type="text" value="" placeholder="{{ __('app.search_label_search_text') }}">
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary" type="submit" name="btnSearch" value="1">{{ __('app.search_button_search') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        @include('templates.aside')


    </div>




</div>

@endsection

@push('extrascripts')
    @vite('resources/js/pages/search.js')
@endpush


