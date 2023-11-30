@extends('layouts.common')


@section('description')
<meta name="description" content="{{  __('app.common_description') }}">
<meta name="keywords" content="{{ __('app.common_keywords', ['year' => ($document->document['addons']['documentYear'] ?? '')]) }}">
@endsection

@section('title')
{{ __('app.search_title') }}
@endsection

{{-- {{ dd(request()->all()) }} --}}

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
                                        @foreach (__('app.search_document_types') as $key => $type)
                                            <option value="{{ $key }}" @selected((old('searchType') ?? $fill['searchType'] ?? 'ok') == $key)>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                    <label for="searchType">{{ __('app.search_label_document_type') }}</label>
                                </div>
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
                                    <div class="col-md mb-3">
                                        <div class="form-floating d-grid">
                                            <a href="{{ route('search', ['lang' => app()->getLocale()]) }}" class="btn btn-secondary" name="btnClear" value="1">{{ __('app.search_button_clear') }}</a>
                                        </div>
                                    </div>
                                    <div class="col-md mb-3">
                                        <div class="form-floating d-grid">
                                            <button class="btn btn-primary" type="submit" name="btnSearch" value="1">{{ __('app.search_button_search') }}</button>
                                        </div>
                                    </div>
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
                                @foreach ((old('searchFilter') ?? $fill['searchFilter'] ?? []) as $step)
                                <div class="input-group mb-3">
                                    @if (!$errors->has("Filter.*"))
                                        <input type="text" readonly class="form-control bg-secondary bg-opacity-10" name="searchFilter[]" value="{{ $step }}">
                                        <button class="btn btn-outline-secondary remove-input" type="button"><x-bi-x class="w-6 h-6"/></button>
                                    @else
                                        <input type="text" @readonly(!$loop->last) @class(['form-control', 'bg-secondary bg-opacity-10' => !$loop->last, 'is-invalid' => $loop->last]) name="searchFilter[]" value="{{ $step }}">
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
                                    <input type="text" class="form-control" name="searchFilter[]" value="">
                                </div>
                                @endunless

                                <div class="row g-md-2">
                                    <div class="col-md mb-3">
                                        <div class="form-floating d-grid">
                                            <a href="{{ route('search', ['lang' => app()->getLocale()]) }}" class="btn btn-secondary" name="btnClear" value="1">{{ __('app.search_button_clear') }}</a>
                                        </div>
                                    </div>
                                    <div class="col-md mb-3">
                                        <div class="form-floating d-grid">
                                            <button class="btn btn-primary" type="submit" id="advancedSubmitButton" name="btnSearch" value="1">{{ __('app.search_button_search') }}</button>
                                        </div>
                                    </div>
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


