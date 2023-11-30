@extends('layouts.common')


@section('content')

<div class="px-4 py-5 my-5 text-center">
    <div class="display-1 fw-bold text-brand">404</div>
    <div class="display-6 fw-bold my-4">{{ __('app.404_subheader') }}</div>
    <div class="col-lg-8 mx-auto">
        <p class="lead mb-2">{!! __('app.404_text') !!}</p>
        <p class="lead mb-4">{{ __('app.404_text_2') }}</p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <a class="btn btn-secondary btn-lg px-4 gap-3" href="{{ route('index', ['lang' => app()->getLocale()]) }}">{{ __('app.button_home') }}</a>
            <a class="btn btn-outline-secondary btn-lg px-4" href="#!">{{ __('app.button_search') }}</a>
            {{-- <a class="btn btn-outline-secondary btn-lg px-4" href="{{ route('search', ['lang' => app()->getLocale()]) }}">{{ __('app.button_search') }}</a> --}}
        </div>
    </div>
</div>

@endsection


