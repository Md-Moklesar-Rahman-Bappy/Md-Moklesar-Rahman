@extends('layouts.frontend')

@section('page_title', $profile->full_name . ' - ' . ($profile->tagline ?? 'Portfolio'))

@section('content')
    @include('frontend.partials.hero', ['profile' => $profile])
    @include('frontend.partials.about', ['profile' => $profile])
    @include('frontend.partials.skills', ['profile' => $profile])
    @include('frontend.partials.experience', ['profile' => $profile])
    @include('frontend.partials.education', ['profile' => $profile])
    @include('frontend.partials.projects', ['profile' => $profile])
    @include('frontend.partials.services', ['profile' => $profile])
    @include('frontend.partials.testimonials', ['profile' => $profile])
    @include('frontend.partials.certifications', ['profile' => $profile])
    @include('frontend.partials.blog', ['profile' => $profile])
    @include('frontend.partials.contact', ['profile' => $profile])
@endsection
