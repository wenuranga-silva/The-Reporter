<div class="container-fluid populer-news py-5">
    <div class="container py-5">
        <div class="tab-class mb-4">
            <div class="row g-4">

                <div class="col-lg-8 col-xl-9">
                    <div class="d-flex flex-column flex-md-row justify-content-md-between border-bottom mb-4">
                        <h1 class="csutom mb-4">What’s New</h1>
                        <ul class="nav nav-pills d-inline-flex text-center">

                            @foreach ($category_news as $key => $item)

                            <li class="nav-item mb-3">
                                <a class="d-flex py-2 bg-light rounded-pill {{ $key == 0 ? 'active' : '' }} me-2" data-bs-toggle="pill" href="#tab-{{ $item->Category->name  }}">
                                    <span class="text-dark" style="width: 100px;">{{ $item->Category->name }}</span>
                                </a>
                            </li>
                            @endforeach

                        </ul>
                    </div>

                    <div class="tab-content mb-4">


                        @foreach ($category_news as $key => $item)

                        <?php

                        $cat_name = $item->Category->name;
                        ?>

                        <div id="tab-{{ $cat_name }}" class="tab-pane fade show p-0 {{ $key == 0 ? 'active' : '' }}">
                            <div class="row g-4">

                                <div class="col-lg-8">
                                    <div class="position-relative rounded overflow-hidden">
                                        <img src="{{ asset($item->Category->News[0]->PostImage[0]->image) }}" class="img-zoomin img-fluid rounded w-100" alt="">
                                        <div class="position-absolute text-white px-4 py-2 bg-primary rounded" style="top: 20px; right: 20px;">
                                            {{ $cat_name }}
                                        </div>
                                    </div>
                                    <div class="my-4">
                                        <a href="{{ route('post' ,$item->Category->News[0]->id) }}" class="h4">{!! $item->Category->News[0]->title !!}</a>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <a href="javascript:void(0)" class="text-dark link-hover me-3"><i class="fa fa-clock"></i> {{ $item->Category->News[0]->reading_time }} minute(s) read</a>
                                        <a href="javascript:void(0)" class="text-dark link-hover me-3"><i class="fa fa-eye"></i> {{ $item->Category->News[0]->views_count }} Views</a>
                                    </div>
                                    <p class="my-4">
                                        {!! strip_tags(Str::substr($item->Category->News[0]->description, 0, 280)) . ' ....' !!}
                                    </p>
                                </div>

                                <div class="col-lg-4">
                                    <div class="row g-4">

                                        @for ($i = 1; $i < count($item->Category->News); $i++)

                                        <div class="col-12">
                                            <div class="row g-4 align-items-center">
                                                <div class="col-5">
                                                    <div class="overflow-hidden" style="border-radius: 3px">
                                                        <img src="{{ asset($item->Category->News[$i]->PostImage[0]->image) }}" style="border-radius: 3px" class="img-zoomin img-fluid w-100" alt="image">
                                                    </div>
                                                </div>
                                                <div class="col-7">
                                                    <div class="features-content d-flex flex-column">
                                                        <p class="text-uppercase mb-2">{{ $cat_name }}</p>
                                                        <a href="{{ route('post' ,$item->Category->News[$i]->id) }}" class="h6" style="font-size: 0.9rem">{!! Str::substr($item->Category->News[$i]->title, 0, 43) . '...' !!}</a>
                                                        <small class="text-body d-block"><i class="fas fa-calendar-alt me-1"></i> {{ $item->Category->News[$i]->formatted_date }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endfor

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach


                    </div>

                    <div class="border-bottom mb-4">
                        <h2 class="csutom my-4">Most Views News</h2>
                    </div>

                    <div class="whats-carousel owl-carousel">

                        @for ($i = 3; $i < count($popular_news); $i++)

                        <div class="whats-item">
                            <div class="bg-light rounded">
                                <div class="rounded-top overflow-hidden">
                                    <img src="{{ asset($popular_news[$i]->PostImage[0]->image) }}" style="width: auto;height: 200px;" class="img-zoomin img-fluid rounded-top w-100" alt="image">
                                </div>
                                <div class="d-flex flex-column p-4">
                                    <a href="{{ route('post' ,$popular_news[$i]->id) }}" class="h5">{!! Str::length($popular_news[$i]->title) > 100 ? Str::substr($popular_news[$i]->title, 0, 110) . '...' : $popular_news[$i]->title !!}</a>
                                    <div class="d-flex justify-content-between">
                                        <a href="javascript:void(0)" class="small text-body link-hover">by {{ $popular_news[$i]->author->name }}</a>
                                        <small class="text-body d-block"><i class="fas fa-calendar-alt me-1"></i> {{ $popular_news[$i]->formatted_date }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endfor


                    </div>

                </div>

                {{-- side bar news --}}
                <div class="col-lg-4 col-xl-3">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="p-3 rounded border">

                                <div class="row g-4">
                                    <div class="col-12" style="margin-bottom: 10px">

                                        <img src="{{ asset('uploads/Ad.png') }}" width="100%" alt="image">
                                    </div>

                                    <div class="col-12" style="margin-bottom: 10px">

                                        <img src="{{ asset('uploads/Ad.png') }}" width="100%" alt="image">
                                    </div>

                                    <div class="col-12" style="margin-bottom: 10px">

                                        <img src="{{ asset('uploads/Ad.png') }}" width="100%" alt="image">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
