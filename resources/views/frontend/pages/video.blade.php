@extends('frontend.layouts.app')

@section('content')
    <div class="container-fluid py-5">
        <div class="container py-5">

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <a href="javascript:void(0)" class="h1 display-5">{!! $video->description !!}</a>
                    </div>

                    <div class="position-relative rounded overflow-hidden mb-3">
                        <iframe src="{{ $video->video_url }}" frameborder="0" width="100%" style="min-height: 400px"></iframe>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ $video->copyright_link }}">{{ $video->copyright_text }}</a>
                    </div>

                    <div class="tab-class">
                        <div class="d-flex justify-content-between border-bottom mb-4">
                            <ul class="nav nav-pills d-inline-flex text-center">


                                @if (count($video->Tags) != 0)
                                    <li class="nav-item mb-3">
                                        <h5 class="mt-2 me-3 mb-0">Tags:</h5>
                                    </li>
                                @endif

                                @foreach ($video->Tags as $tag)
                                    <li class="nav-item mb-3">
                                        <a class="d-flex py-2 bg-light rounded-pill active me-2" data-bs-toggle="pill"
                                            href="#tab-1">
                                            <span class="text-dark" style="width: 100px;">{{ $tag->Tag->name }}</span>
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                            <div class="d-flex align-items-center">
                                <h5 class="mb-3 me-3">Share:</h5>
                                <i
                                    class="fab fa-facebook-f link-hover mb-3 btn btn-square rounded-circle border-primary text-dark me-2"></i>
                                <i
                                    class="btn fab bi-twitter link-hover mb-3 btn btn-square rounded-circle border-primary text-dark me-2"></i>
                                <i
                                    class="btn fab fa-instagram link-hover mb-3 btn btn-square rounded-circle border-primary text-dark me-2"></i>
                                <i
                                    class="btn fab fa-linkedin-in link-hover mb-3 btn btn-square rounded-circle border-primary text-dark"></i>
                            </div>
                        </div>
                        <div class="tab-content">

                            <div id="tab-1" class="tab-pane fade show active">
                                <div class="row g-4 align-items-center">
                                    <div class="col-3">
                                        @if ($video->Author->photo != null)
                                            <img src="{{ asset($video->Author->photo) }}" class="img-fluid w-100 rounded"
                                                alt="profile Pic">
                                        @endif
                                    </div>
                                    <div class="col-9">
                                        <h3>{{ $video->Author->name }}</h3>
                                        <p class="mb-0">
                                            {{ $video->Author->userDesc != null ? $video->Author->userDesc->description : '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-light rounded my-4 p-4">
                        <h4 class="csutom-5 mb-4">You Might Also Like</h4>
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center p-3 bg-white rounded">
                                    <img src="{{ asset($liked_news[0]->PostImage[0]->image) }}" width="100px"
                                        class="img-fluid" style="border-radius: 3px" alt="image">
                                    <div class="ms-3">
                                        <a href="{{ route('post', $liked_news[0]->id) }}"
                                            class="h5 mb-2">{!! $liked_news[0]->title !!}</a>
                                        <p class="text-dark mt-3 mb-0 me-3"><i class="fa fa-clock"></i>
                                            {!! $liked_news[0]->reading_time !!} minute(s) read</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center p-3 bg-white rounded">
                                    <img src="{{ asset($liked_news[1]->PostImage[0]->image) }}" width="100px"
                                        class="img-fluid" style="border-radius: 3px" alt="image">
                                    <div class="ms-3">
                                        <a href="{{ route('post', $liked_news[1]->id) }}"
                                            class="h5 mb-2">{!! $liked_news[1]->title !!}</a>
                                        <p class="text-dark mt-3 mb-0 me-3"><i class="fa fa-clock"></i>
                                            {!! $liked_news[1]->reading_time !!} minute(s) read</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-light rounded p-4">
                        <h4 class="csutom-5 mb-4">Comments</h4>
                        <div class="p-4 bg-white rounded mb-4">
                            <div class="row g-4">


                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-4">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="p-3 rounded border">

                                <h4 class="csutom-5 my-4">Popular News</h4>
                                <div class="row g-4">

                                    @foreach ($popular_news as $item)
                                        <div class="col-12">
                                            <div class="row g-4 align-items-center features-item">
                                                <div class="col-4">
                                                    <div class="rounded-circle position-relative">
                                                        <div class="overflow-hidden ">
                                                            <img src="{{ asset($item->PostImage[0]->image) }}"
                                                                class="img-zoomin img-fluid w-100" alt="Image"
                                                                style="border-radius: 3px">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-8">
                                                    <div class="features-content d-flex flex-column">
                                                        <p class="text-uppercase mb-2">{{ $item->Category->name }}</p>
                                                        <a href="{{ route('post', $item->id) }}" class="h6">
                                                            {!! $item->title !!}
                                                        </a>
                                                        <small class="text-body d-block"><i
                                                                class="fas fa-calendar-alt me-1"></i>
                                                            {{ $item->formatted_date }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                                <div class="row g-2">
                                    <img src="{{ asset('uploads/Ad.png') }}" alt="image">
                                </div>

                                <h4 class="csutom-5 mb-4 mt-5">Popular Categories</h4>
                                <div class="row g-2">

                                    @foreach ($categories as $category)
                                        <div class="col-12">
                                            <a href="{{ route('post.category', $category->Category->id) }}"
                                                class="link-hover btn btn-light w-100 rounded text-uppercase text-dark py-3">
                                                {{ $category->Category->name }}
                                            </a>
                                        </div>
                                    @endforeach

                                </div>

                                <div class="row g-2">
                                    <img src="{{ asset('uploads/Ad.png') }}" alt="image">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
