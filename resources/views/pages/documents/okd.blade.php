@extends('layouts.document')

@section('canonical')
<link rel="canonical" href="{{ route('document', ['lang' => $lang, 'registrationNumber' => $document->document['version']['registration_number']]) }}" />
@endsection


@include('pages.documents.okd.meta')
@include('pages.documents.okd.opengraph')
@include('pages.documents.okd.schemaorg')

@section('title')
{{ $document->document['addons']['title'] ?? '' }}
@endsection

@section('content')


<div class="row g-5">
    <div class="col-md-7 col-lg-8">
        <h1>{{ $document->document['addons']['title'] ?? '' }}</h1>
        <a class="d-block small mb-3" href="{{ route('document', ['lang' => __('app.locale_version_code'), 'registrationNumber' => $document->document['version']['registration_number'] ]) }}">{{ __('app.work_locale_version') }}</a>

        <p>{{ __('app.caption_okd_research_for') . __('app.caption_okd_type_research.' . ($document->document['version']['okd_type']) ?? 0) }}</p>

        <!-- state registration number -->
        <h2 class="h6 mb-1">{{ __('app.caption_registration_number') }}</h2>
        <p class="opacity-75">{{ $document->document['version']['registration_number'] }}</p>

        <!-- files -->
        @if (session('download_error'))
            <div class="alert alert-danger">{{ session('download_error') }}</div>
        @endif



        <div class="list-group mb-4">
            <a href="{{ route('downloadCard', ['registrationNumber' => ($document->document['version']['registration_number'] ?? '')]) }}" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                <x-bi-file-earmark-pdf class="w-8 h-8 text-danger"/>
                <div class="d-flex gap-2 w-100 justify-content-between">
                    <div>
                        <h2 class="h6 mb-0">{{ __('app.caption_file_okd') }}</h2>
                        <p class="mb-0 opacity-75">{{ $document->document['version']['registration_number'] }}.pdf</p>
                    </div>
                    <small class="opacity-75 text-nowrap"><x-bi-download /></small>
                </div>
            </a>
        </div>


        <!-- applicant for -->
        <h2 class="h6 mb-1">{{ __('app.caption_author') }}</h2>
        <ul class="list-unstyled">
        @foreach ($document->document['addons']['author'] as $person)
            <li><a href="#!">{{ $person['full_name'][$lang] }}</a></li>
        @endforeach
        </ul>

        <!-- specialization -->
        <h2 class="h6 mb-1">{{ __('app.caption_speciality') }}</h2>
        <ul class="list-unstyled opacity-75">
        @foreach ($document->document['addons']['specialty'] as $key => $spec)
            <li>{{ $key }} - {{ $spec }}</li>
        @endforeach
        </ul>

        <!-- date of defence  -->
        @unless(empty($document->document['version']['date_defense']))
        <label class="h6 mb-1">{{ __('app.caption_date_defense') }}</label>
        <p class="opacity-75">{{ Carbon\Carbon::parse($document->document['version']['date_defense'] ?? 0)->format('d-m-Y') }}</p>
        @endunless

        <!-- specialized academic board -->
        <h2 class="h6 mb-1">{{ __('app.caption_spec') }}</h2>
        <p class="mb-0 opacity-75">{{ $document->document['version']['user']['user_number'] }}</p>
        @if (!empty($document->document['addons']['user_firm'][$lang]))
        <p class="opacity-75">{{ $document->document['addons']['user_firm'][$lang] }}</p>
        @endif

        <!-- essay -->
        <h2 class="h6 mb-1">{{ __('app.caption_essay') }}</h2>
        <p class="opacity-75">{{ $document->document['addons']['descriptions']['referat_' . $lang] ?? '' }}</p>

        <!-- thesis supervisor -->
        @unless(empty($document->document['addons']['heads']))
            <label class="h6 mb-1">{{ __('app.caption_supervisor') }}</label>
            <ul class="list-unstyled">
            @foreach ($document->document['addons']['heads'] as $person)
                <li><a href="#!">{{ $person['full_name'][$lang] }}</a></li>
            @endforeach
            </ul>
        @endunless

        <!-- official opponents -->
        @unless(empty($document->document['addons']['opponents']))
            <label class="h6 mb-1">{{ __('app.caption_opponents') }}</label>
            <ul class="list-unstyled">
            @foreach ($document->document['addons']['opponents'] as $person)
                <li><a href="#!">{{ $person['full_name'][$lang] }}</a></li>
            @endforeach
            </ul>
        @endunless

        <!--  reviewers -->
        @unless(empty($document->document['addons']['reviewers']))
            <label class="h6 mb-1">{{ __('app.caption_reviewers') }}</label>
            <ul class="list-unstyled">
            @foreach ($document->document['addons']['reviewers'] as $person)
                <li><a href="#!">{{ $person['full_name'][$lang] }}</a></li>
            @endforeach
            </ul>
        @endunless

        <!--  advisors -->
        @unless(empty($document->document['addons']['advisors']))
            <label class="h6 mb-1">{{ __('app.caption_advisors') }}</label>
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
            <h2 class="h6 mt-4 mb-1">{{ __('app.caption_biblos') }}</h2>
            {{-- <label class="h6">{{ __('app.caption_biblos') }}</label> --}}

            <div class="list-group mb-4 list-group-flush">
                @foreach ($document->document['version']['total']['okdTotal']['biblos'] as $item)
                <div  @class(['list-group-item py-3 px-0', 'pt-1' => $loop->first])>
                            <p class="mb-0 opacity-75">{{ $item }}</p>
                </div>
                @endforeach
            </div>

        @endunless

        @unless(empty($document->document['files']))
        <h2 class="h6 mb-2">{{ __('app.caption_files') }}</h2>
        <div class="list-group mb-4">
            @foreach ($document->document['files'] ?? [] as $file)
            <a href="{{ route('downloadFile', ['registrationNumber' => ($document->document['version']['registration_number'] ?? ''), 'filename' => $file]) }}" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true" target="_blank">
                <x-bi-file-earmark-pdf class="w-8 h-8 text-danger"/>
                <div class="d-flex gap-2 w-100 justify-content-between">
                    <div>
                        <p class="mb-0 opacity-75">{{ $file }}</p>
                    </div>
                    <small class="opacity-75 text-nowrap"><x-bi-download /></small>
                </div>
            </a>
            @endforeach
        </div>
        @endunless


        <!-- similar -->
        @unless(empty($document->document['similar']))
        <h2 class="h6 mt-5 mb-2">{{ __('app.caption_similar') }}</h2>
        <div class="list-group mb-4">
            @foreach ($document->document['similar'] as $okd)
                @unless(empty($okd['registration_number']))
                <a href="{{ route('document', ['lang' => $lang, 'registrationNumber' => ($okd['registration_number'] ?? '') ]) }}" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true" target="_blank">
                    <x-bi-link-45deg class="w-8 h-8 text-primary opacity-75"/>
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div>
                            <h2 class="h6 mb-0">{{ $okd['registration_number'] ?? '' }}</h2>
                            <p class="mb-0 opacity-75">{{ $okd['theme'][$lang] ?? '' }}</p>
                        </div>
                    </div>
                </a>
                @endunless
            @endforeach
        </div>
        @endunless


    </div>
    <div class="col-md-5 col-lg-4 order-md-last">
        {{-- {{ app()->getLocale() }} --}}
    </div>
</div>
@endsection


@push('extrascripts')
@endpush


