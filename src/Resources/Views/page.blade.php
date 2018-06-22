@extends('layouts.default')

@section('title')
    @render(\Agencms\Core\Components\Title::class, ['title' => array_get($page, 'name') ?? $title])
@endsection

@section('head-meta')
    @parent

    <meta property="og:url" content="{{ Request::url() }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ array_get($page, 'name') ?? $title }}">
    <meta property="og:image" content="{{ array_get($page, 'image') ?? $shareimage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:description" content="{{ array_get($page, 'summary') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ Request::url() }}">
    <meta name="twitter:creator" content="{{ $twitter_handle }}">
    <meta name="twitter:title" content="{{ array_get($page, 'name') ?? $title }}">
    <meta name="twitter:image" content="{{ array_get($page, 'image') ?? $shareimage }}">
    <meta name="twitter:description" content="{{ array_get($page, 'summary') }}">

    @repeater(array_get($page, 'structured_data'))
@endsection

@section('content')

    @repeater($page['content'])

@endsection
