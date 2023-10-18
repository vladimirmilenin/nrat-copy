@section('opengraph')
<meta property="og:title" content="{{ __('app.meta_okd_og_title', ['theme' => $document->document['addons']['title'] ?? '']) }}">
<meta property="og:url" content="{{ route('document', ['lang' => $lang, 'registrationNumber' => $document->document['version']['registration_number']]) }}">
<meta property="og:description" content="{{ __('app.meta_okd_og_description') }}">
<meta property='article:author' content='{{ $document->document['addons']['author'][0]['full_name'][$lang] ?? '' }}'>
<meta property="og:publication_date" content="{{ Carbon\Carbon::parse($document->document['version']['registration_date'] ?? 0)->format('Y-m-d') }}">
<meta property="og:locale" content="{{ __('app.meta_og_locale') }}">
<meta property="og:site_name" content="{{ __('app.app_title') }}">
<meta property="og:image" content="{{ Vite::asset('resources/images/atu_' . app()->getLocale() . '.png') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
{{-- <meta property="article:section" content="spec"> --}}
<meta property="twitter:card" content="summary">
<meta property="twitter:title" content="{{ $document->document['addons']['title'] ?? '' }}">
<meta property="twitter:description" content="{{ __('app.meta_okd_og_description') }}">
@endsection
