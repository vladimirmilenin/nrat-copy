@extends('layouts.common')


@section('canonical')
<link rel="canonical" href="{{ route('index', ['lang' => $lang ]) }}" />
@endsection

@section('description')
<meta name="description" content="{{  __('app.common_description') }}">
<meta name="keywords" content="{{ __('app.common_keywords', ['year' => ($document->document['addons']['documentYear'] ?? '')]) }}">
@endsection

@section('title')
{{ __('app.common_title') }}
@endsection


@section('content')


<div class="container">
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-4">
            <h1 class="display-5 fw-bold">{{ __('app.index_welcome_header') }}</h1>
            <div class="col-md-10">
                {!! __('app.index_text_1') !!}
                <p class="fs-5">{{ __('app.index_text_2') }}</p>
            </div>
            <a href="{{ route('search', ['lang' => app()->getLocale()]) }}" class="btn btn-secondary px-4 btn-lg" type="button">{{ __('app.button_search') }}</a>
        </div>
    </div>

    <div class="row align-items-md-stretch">
        <div class="col-md-7 col-lg-8">
            <div class="container-fluid">
                <h2 class="h3 mb-3">{{ __('app.index_last_diser') }}</h2>

                @unless(empty($latestOkd))
                <div class="list-group mb-4">
                    @foreach ($latestOkd as $okd)
                        <x-okd-list-item
                            registrationNumber="{{ $okd['registration_number'] ?? '' }}"
                            url="{{ route('document', ['lang' => $lang, 'registrationNumber' => ($okd['registration_number'] ?? '') ]) }}"
                            author="{{ $okd['author_' . $lang] ?? '' }}"
                            theme="{{ $okd['theme_' . $lang] ?? '' }}"
                        />
                    @endforeach
                </div>
                @endunless

            </div>
        </div>
        <div class="col-md-5 col-lg-4 order-md-last">

        </div>
    </div>

</div>


@endsection


