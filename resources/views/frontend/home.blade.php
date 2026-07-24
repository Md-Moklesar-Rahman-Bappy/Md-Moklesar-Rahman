@php
$themeSlug = $activeTheme?->slug ?? 'developer';
@endphp

@extends("themes.{$themeSlug}.layout")

@section('page_title', $profile->full_name . ' - ' . ($profile->tagline ?? 'Portfolio'))

@section('content')
@foreach($sections as $section)
    @includeIf("themes.{$themeSlug}.sections.{$section->section_type}", ['data' => $section->content, 'section' => $section, 'profile' => $profile])
@endforeach
@endsection
