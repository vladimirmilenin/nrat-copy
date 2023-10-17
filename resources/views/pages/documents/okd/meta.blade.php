@section('meta')
<meta name="description" content="{{ Str::limit(__('app.meta_okd_description', ['theme' => $document->document['addons']['descriptions']['theme_' . $lang] ?? '']), 160) }}">
<meta name="keywords" content="{{ __('app.meta_okd_keywords', ['year' => ($document->document['addons']['documentYear'] ?? ''), 'author' => ($document->document['addons']['author'][0]['short_name'][$lang] ?? ''), 'theme' => ($document->document['addons']['descriptions']['theme_' . $lang] ?? '')]) }}">
<meta name="author" content="{{ $document->document['addons']['author'][0]['short_name'][$lang] ?? '' }}">
@endsection
