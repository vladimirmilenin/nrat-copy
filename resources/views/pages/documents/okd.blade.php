@extends('layouts.document')

@section('meta')
<meta name="description" content="{{ $document->document['addons']['descriptions']['theme_' . $lang] ?? '' }}">
<meta name="keywords" content="">
<meta name="author" content="{{ $document->document['addons']['author'][0]['short_name'][$lang] ?? '' }}">
@endsection

@section('opengraph')
@endsection

@section('schemaorg')
@endsection

@section('title')
{{ $document->document['addons']['title'] ?? '' }}
@endsection

@section('content')
<div class="row g-5">
    <div class="col-md-7 col-lg-8">
        <h1>{{ $document->document['addons']['title'] ?? '' }}</h1>
        <p>{{ __('app.caption_okd_research_for') . __('app.caption_okd_type_research.' . ($document->document['version']['okd_type']) ?? 0) }}</p>

        <!-- state registration number -->
        <label class="h6">{{ __('app.caption_registration_number') }}</label>
        <p>{{ $document->document['version']['registration_number'] }}</p>

        <!-- files -->
        <label class="h6">{{ __('app.caption_files') }}</label>
        <ul>
            <li>
                <a href="{{ route('download', ['filetype' => 'card.okd', 'filename' => $document->document['version']['okd_hash']]) }}" target="_blank">
                {{ $document->document['version']['registration_number'] }}.pdf
                </a>
            </li>
            @foreach ($document->document['version']['files']['autoreferat'] ?? [] as $file)
            <li>
                <a href="{{ route('download', ['filetype' => 'okd', 'filename' => $file['file_hash']]) }}" target="_blank">
                {{ $file['file_name'] }}
                </a>
            </li>
            @endforeach
            @foreach ($document->document['version']['files']['diser'] ?? [] as $file)
            <li>
                <a href="{{ route('download', ['filetype' => 'okd', 'filename' => $file['file_hash']]) }}" target="_blank">
                {{ $file['file_name'] }}
                </a>
            </li>
            @endforeach
        </ul>

        <!-- applicant for -->
        <label class="h6">{{ __('app.caption_author') }}</label>
        <ul class="list-unstyled">
        @foreach ($document->document['addons']['author'] as $person)
            <li><a href="#!">{{ $person['full_name'][$lang] }}</a></li>
        @endforeach
        </ul>

        <!-- specialization -->
        <label class="h6">{{ __('app.caption_speciality') }}</label>
        <ul class="list-unstyled">
        @foreach ($document->document['addons']['specialty'] as $key => $spec)
            <li>{{ $key }} - {{ $spec }}</li>
        @endforeach
        </ul>

        <!-- date of defence  -->
        @unless($document->document['version']['date_defense'])
        <label class="h6">{{ __('app.caption_date_defense') }}</label>
        <p>{{ Carbon\Carbon::parse($document->document['version']['date_defense'] ?? 0)->format('d-m-Y') }}</p>
        @endunless

        <!-- specialized academic board -->
        <label class="h6">{{ __('app.caption_spec') }}</label>
        <p class="mb-0">{{ $document->document['version']['user']['user_number'] }}</p>
        @if (!empty($document->document['addons']['user_firm'][$lang]))
        <p>{{ $document->document['addons']['user_firm'][$lang] }}</p>
        @endif

        <!-- essay -->
        <label class="h6">{{ __('app.caption_essay') }}</label>
        <p>{{ $document->document['addons']['descriptions']['referat_' . $lang] ?? '' }}</p>

        <!-- thesis supervisor -->
        @unless(empty($document->document['addons']['heads']))
            <label class="h6">{{ __('app.caption_supervisor') }}</label>
            <ul class="list-unstyled">
            @foreach ($document->document['addons']['heads'] as $person)
                <li><a href="#!">{{ $person['full_name'][$lang] }}</a></li>
            @endforeach
            </ul>
        @endunless

        <!-- official opponents -->
        @unless(empty($document->document['addons']['opponents']))
            <label class="h6">{{ __('app.caption_opponents') }}</label>
            <ul class="list-unstyled">
            @foreach ($document->document['addons']['opponents'] as $person)
                <li><a href="#!">{{ $person['full_name'][$lang] }}</a></li>
            @endforeach
            </ul>
        @endunless

        <!--  reviewers -->
        @unless(empty($document->document['addons']['reviewers']))
            <label class="h6">{{ __('app.caption_reviewers') }}</label>
            <ul class="list-unstyled">
            @foreach ($document->document['addons']['reviewers'] as $person)
                <li><a href="#!">{{ $person['full_name'][$lang] }}</a></li>
            @endforeach
            </ul>
        @endunless

        <!--  advisors -->
        @unless(empty($document->document['addons']['advisors']))
            <label class="h6">{{ __('app.caption_advisors') }}</label>
            <ul class="list-unstyled">
                @foreach ($document->document['addons']['advisors'] as $person)
                <li><a href="#!">{{ $person['full_name'][$lang] }}</a></li>
                @endforeach
            </ul>
        @endunless

        <!-- theme connection -->
        {{--
        @unless(empty($document->document['addons']['theme_relations']))
            <label class="h6">{{ __('app.caption_connection') }}</label>
            <p>{{ implode(', ', $document->document['addons']['theme_relations']) }}</p>
        @endunless
        --}}

        <!-- biblos -->
        @unless(empty($document->document['version']['total']['okdTotal']['biblos']))
            <label class="h6">{{ __('app.caption_biblos') }}</label>
            <ul>
                @foreach ($document->document['version']['total']['okdTotal']['biblos'] as $item)
                <li>{{ $item }}</li>
                @endforeach
            </ul>
        @endunless


    </div>
    <div class="col-md-5 col-lg-4 order-md-last">
        {{-- {{ app()->getLocale() }} --}}
    </div>
</div>
@endsection


@push('extrascripts')
@endpush


