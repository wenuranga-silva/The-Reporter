@extends('frontend.layouts.app')

@section('content')
    <!-- Features Start -->
    @include('frontend.sections.features')
    <!-- Features End -->


    <!-- Main Post Section Start -->
    @include('frontend.sections.main-post')
    <!-- Main Post Section End -->


    <!-- Banner Start -->
    @include('frontend.sections.banner')
    <!-- Banner End -->


    <!-- Latest Videos Start -->
    @include('frontend.sections.latest-videos')
    <!-- Latest Videos End -->


    <!-- Most Populer News Start -->
    @include('frontend.sections.popular-news')
    <!-- Most Populer News End -->
@endsection
