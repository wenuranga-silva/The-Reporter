<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-7 col-xl-8 mt-0">
                <div class="position-relative overflow-hidden rounded">
                    <img src="{{ asset($latest_news[0]->PostImage[0]->image) }}" class="img-fluid rounded img-zoomin w-100" alt="image">
                    <div class="d-flex justify-content-center px-4 position-absolute flex-wrap"
                        style="bottom: 10px; left: 0;">
                        <a href="javascript:void(0)" class="text-white me-3 link-hover"><i class="fa fa-clock"></i> {!! $latest_news[0]->reading_time !!} minute(s)
                            read</a>
                        <a href="javascript:void(0)" class="text-white me-3 link-hover"><i class="fa fa-eye"></i> {!! $latest_news[0]->views_count !!} Views</a>

                    </div>
                </div>
                <div class=" py-3">
                    <a href="{{ route('post' ,$latest_news[0]->id) }}" class="display-4 text-dark mb-0 link-hover">{!! $latest_news[0]->title !!}</a>
                </div>

                {{-- top story --}}
                <div class="bg-light p-4 rounded">
                    <div class="news-2">
                        <h3 class="csutom mb-4">Latest News</h3>
                    </div>
                    <div class="row g-4 align-items-center">
                        <div class="col-md-6">
                            <div class="rounded overflow-hidden">
                                <img src="{{ asset($latest_news[1]->PostImage[0]->image) }}" class="img-fluid rounded img-zoomin w-100" alt="image">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column">
                                <a href="{{ route('post' ,$latest_news[1]->id) }}" class="h3">{!! $latest_news[1]->title !!}</a>
                                <p class="mb-0 fs-5"><i class="fa fa-clock"> {!! $latest_news[1]->reading_time !!} minute(s) read</i> </p>
                                <p class="mb-0 fs-5"><i class="fa fa-eye"> {!! $latest_news[1]->views_count !!} Views</i></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- side bar news --}}
            <div class="col-lg-5 col-xl-4">
                <div class="bg-light rounded p-4 pt-0">
                    <div class="row g-4">

                        <div class="col-12">
                            <div class="rounded overflow-hidden">
                                <img src="{{ asset($latest_news[2]->PostImage[0]->image) }}" class="img-fluid rounded img-zoomin w-100" alt="Image">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex flex-column">
                                <a href="{{ route('post' ,$latest_news[2]->id) }}" class="h4 mb-2">{!! $latest_news[2]->title !!}</a>
                                <p class="fs-5 mb-0"><i class="fa fa-clock"> {!! $latest_news[2]->reading_time !!} minute(s) read</i> </p>
                                <p class="fs-5 mb-0"><i class="fa fa-eye"> {!! $latest_news[2]->views_count !!} Views</i></p>
                            </div>
                        </div>

                        @for ($i = 3; $i < count($latest_news); $i++)

                        <div class="col-12">
                            <div class="row g-4 align-items-center">
                                <div class="col-5">
                                    <div class="overflow-hidden rounded">
                                        <img src="{{ asset($latest_news[$i]->PostImage[0]->image) }}" class="img-zoomin img-fluid rounded w-100"
                                            alt="image">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="features-content d-flex flex-column">
                                        <a href="{{ route('post' ,$latest_news[$i]->id) }}" class="h6">{!! $latest_news[$i]->title !!}</a>
                                        <small><i class="fa fa-clock"> {!! $latest_news[$i]->reading_time !!} minute(s) read</i> </small>
                                        <small><i class="fa fa-eye"> {!! $latest_news[$i]->views_count !!} Views</i></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endfor


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
