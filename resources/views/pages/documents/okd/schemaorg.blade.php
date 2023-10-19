@section('schemaorg')
<script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "Thesis",
        "name": "{{ $document->document['addons']['descriptions']['theme_' . $lang] ?? '' }}",
        "description": "",
        "author": {
            "@type": "Person",
            "name": "{{ $document->document['addons']['author'][0]['full_name'][$lang] ?? '' }}"
        },
        "datePublished": "{{ Carbon\Carbon::parse($document->document['version']['registration_date'] ?? 0)->format('Y-m-d') }}",
        "keywords": "{{ __('app.meta_okd_keywords', ['year' => ($document->document['addons']['documentYear'] ?? ''), 'author' => ($document->document['addons']['author'][0]['short_name'][$lang] ?? ''), 'theme' => ($document->document['addons']['descriptions']['theme_' . $lang] ?? '')]) }}",
        "url": "{{ route('document', ['lang' => $lang, 'registrationNumber' => $document->document['version']['registration_number']]) }}",
        "fileFormat": "application/pdf",
        "contentUrl": "{{ route('downloadCard', ['registrationNumber' => ($document->document['version']['registration_number'] ?? '')]) }}"
    }
</script>
@endsection
