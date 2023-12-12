@extends('layouts.common')


@section('description')
<meta name="description" content="@unless(empty($direction['name_' . $lang])){{ $direction['name_' . $lang] . '.' }} @endunless{{ __('app.directions_description') }}">
<meta name="keywords" content="@unless(empty($direction['name_' . $lang])){{ $direction['name_' . $lang] . ',' }} @endunless{{ __('app.directions_keywords', ['year' => ($document->document['addons']['documentYear'] ?? '')]) }}">
@endsection

@section('title')
@unless(empty($direction['name_' . $lang])){{ $direction['name_' . $lang] . '.' }} @endunless{{ __('app.directions_title') }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div id="mainSide" class="col-md-7 col-lg-8 overflow-hidden mb-4">
            @if (!empty($direction))
                <h1 class="mb-4">
                    <a class="align-middle" href="{{ route('direction', ['lang' => $lang]) }}"><x-bi-arrow-left-square-fill class="w-6 h-6" /></a>
                    <span class="align-middle">   {{ $direction['code'] . ' ' . $direction['name_' . $lang] }}</span>
                </h1>
                {{ $records->links() }}
                <div class="list-group mb-4">
                    @foreach ($records as $item)
                    <x-okd-list-item
                            registrationNumber="{{ $item['registration_number'] ?? '' }}"
                            url="{{ route('document', ['lang' => $lang, 'registrationNumber' => ($item['registration_number'] ?? '') ]) }}"
                            author="{{ $item['author_' . $lang] ?? '' }}"
                            theme="{{ $item['title_' . $lang] ?? '' }}"
                            target="_blank"
                        />
                    @endforeach
                </div>
                {{ $records->links() }}
            @else
                {{-- Directions list only --}}
                <!-- PhD -->
                <div class="row">
                    <h2 class="h1 mb-4">{{ __('app.directions_heading_2') }}</h2>
                    @foreach ($directions['vak'] ?? [] as $item)
                    <p class="col-12 col-md-6">
                    <a href="{{ route('direction', ['lang' => $lang, 'code' => $item['code']]) }}" >
                        {{ $item['name_' . $lang] }}
                    </a>
                    </p>
                    @endforeach
                </div>
                <!-- VAK -->
                <div class="row">
                    <h1 class="h1 my-4">{{ __('app.directions_heading_1') }}</h1>
                    @foreach ($directions['phD'] ?? [] as $item)
                    <p class="col-12 col-md-6">
                    <a href="{{ route('direction', ['lang' => $lang, 'code' => $item['code']]) }}" >
                        {{ $item['name_' . $lang] }}
                    </a>
                    </p>
                    @endforeach
                </div>
            @endif




        </div>

        @include('templates.aside')

    </div>
</div>


@endsection

