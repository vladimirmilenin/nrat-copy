@extends('layouts.common')


@section('description')
<meta name="description" content="{{  __('app.common_description') }}">
<meta name="keywords" content="{{ __('app.common_keywords', ['year' => ($document->document['addons']['documentYear'] ?? '')]) }}">
@endsection

@section('title')
{{ __('app.search_title') }}
@endsection

@section('content')

<div class="px-4 py-5 my-5 text-center">
    <div class="display-1 text-brand">Вже скоро буде</div>
</div>

@endsection


