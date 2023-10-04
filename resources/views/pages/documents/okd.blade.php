@extends('layouts.document')

@section('meta')
<meta name="description" content="{{ $document->original['descriptions']['theme_' . $lang] ?? '' }}">
<meta name="keywords" content="">
<meta name="author" content="{{ $document->addons['author']['short_name'][$lang] ?? '' }}">
@endsection

@section('opengraph')
@endsection

@section('schemaorg')
@endsection

@section('title')
{{ $document->addons['title'] ?? '' }}
@endsection

@section('content')
<div class="row g-5">
    <div class="col-md-7 col-lg-8">
        <div class="row">
            <div class="col">
                <h1>{{ $document->addons['title'] ?? '' }}</h1>
                <p>{{ __('app.okd_research_for') . __('app.okd_type_research.' . $document->original['okd_type']) }}</p>
            </div>
        </div>

    </div>
    <div class="col-md-5 col-lg-4 order-md-last">
        {{ app()->getLocale() }}
    </div>
</div>
@endsection


@push('extrascripts')
@endpush


