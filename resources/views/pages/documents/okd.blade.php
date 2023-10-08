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
        <h1>{{ $document->addons['title'] ?? '' }}</h1>
        <p>{{ __('app.caption_okd_research_for') . __('app.caption_okd_type_research.' . $document->original['okd_type']) }}</p>

        <!-- state registration number -->
        <label class="h6">{{ __('app.caption_registration_number') }}</label>
        <p>{{ $document->original['registration_number'] }}</p>

        <!-- files -->
        <label class="h6">{{ __('app.caption_files') }}</label>
        <ul>
            <li>
                <a href="{{ route('download', ['filetype' => 'card.okd', 'filename' => $document->original['okd_hash']]) }}" target="_blank">
                {{ __('app.caption_file_okd') }}.pdf
                </a>
            </li>
            @foreach ($document->original['files']['autoreferat'] ?? [] as $file)
            <li>
                <a href="{{ route('download', ['filetype' => 'okd', 'filename' => $file['file_hash']]) }}" target="_blank">
                {{ $file['file_name'] }}
                </a>
            </li>
            @endforeach
            @foreach ($document->original['files']['diser'] ?? [] as $file)
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
        @foreach ($document->addons['author'] as $person)
            <li><a href="#!">{{ $person['full_name'][$lang] }}</a></li>
        @endforeach
        </ul>

        <!-- specialization -->
        <label class="h6">{{ __('app.caption_speciality') }}</label>
        <ul class="list-unstyled">
        @foreach ($document->addons['specialty'] as $key => $spec)
            <li>{{ $key }} - {{ $spec }}</li>
        @endforeach
        </ul>

        <!-- date of defence  -->
        @unless($document->original['date_defense'])
        <label class="h6">{{ __('app.caption_date_defense') }}</label>
        <p>{{ Carbon\Carbon::parse($document->original['date_defense'] ?? 0)->format('d-m-Y') }}</p>
        @endunless

        <!-- specialized academic board -->
        <label class="h6">{{ __('app.caption_spec') }}</label>
        <p class="mb-0">{{ $document->original['user']['user_number'] }}</p>
        @if (!empty($document->addons['user_firm'][$lang]))
        <p>{{ $document->addons['user_firm'][$lang] }}</p>
        @endif

        <!-- essay -->
        <label class="h6">{{ __('app.caption_essay') }}</label>
        <p>{{ $document->original['descriptions']['referat_' . $lang] ?? '' }}</p>

        <!-- thesis supervisor -->
        @unless(empty($document->addons['heads']))
            <label class="h6">{{ __('app.caption_supervisor') }}</label>
            <ul class="list-unstyled">
            @foreach ($document->addons['heads'] as $person)
                <li><a href="#!">{{ $person['full_name'][$lang] }}</a></li>
            @endforeach
            </ul>
        @endunless

        <!-- official opponents -->
        @unless(empty($document->addons['opponents']))
            <label class="h6">{{ __('app.caption_opponents') }}</label>
            <ul class="list-unstyled">
            @foreach ($document->addons['opponents'] as $person)
                <li><a href="#!">{{ $person['full_name'][$lang] }}</a></li>
            @endforeach
            </ul>
        @endunless

        <!--  reviewers -->
        @unless(empty($document->addons['reviewers']))
            <label class="h6">{{ __('app.caption_reviewers') }}</label>
            <ul class="list-unstyled">
            @foreach ($document->addons['reviewers'] as $person)
                <li><a href="#!">{{ $person['full_name'][$lang] }}</a></li>
            @endforeach
            </ul>
        @endunless

        <!--  reviewers -->
        @unless(empty($document->addons['advisors']))
            <label class="h6">{{ __('app.caption_advisors') }}</label>
            <ul class="list-unstyled">
                @foreach ($document->addons['advisors'] as $person)
                <li><a href="#!">{{ $person['full_name'][$lang] }}</a></li>
                @endforeach
            </ul>
        @endunless

        <!-- theme connection -->
        @unless(empty($document->addons['theme_relations']))
            <label class="h6">{{ __('app.caption_connection') }}</label>
        @endunless

        <!-- biblos -->
        @unless(empty($document->original['total']['okdTotal']['biblos']))
            <label class="h6">{{ __('app.caption_connection') }}</label>
            <ul>
                @foreach ($document->original['total']['okdTotal']['biblos'] as $item)
                <li>{{ $item }}</li>
                @endforeach
            </ul>
        @endunless


    </div>
    <div class="col-md-5 col-lg-4 order-md-last">
        {{ app()->getLocale() }}
    </div>
</div>
@endsection


@push('extrascripts')
@endpush


