        <!-- Latest News Start -->
        <div class="container-fluid latest-news py-3">
            <div class="container py-5">
                <h2 class="mb-4 csutom">Latest Videos</h2>
                <div class="latest-news-carousel owl-carousel">

                    @foreach ($videos as $video)

                    <div class="latest-news-item">
                        <div class="bg-light rounded">
                            <div class="rounded-top overflow-hidden">

                                <iframe src="{{ $video->video_url }}" frameborder="0" width="100%"></iframe>
                            </div>
                            <div class="d-flex flex-column p-4">
                                <a href="{{ $video->post_id == null ? route('video' ,$video->id) : route('post' ,$video->post_id) }}" class="h4">
                                    {{ strlen($video->clean_desc) >= 30 ? Str::substr($video->clean_desc, 0, 30) . '...' : $video->clean_desc }}
                                </a>
                                <div class="d-flex justify-content-between">
                                    <a href="javascript:void(0)" class="small text-body link-hover">by {{ $video->Author->name }}</a>
                                    <small class="text-body d-block"><i class="fas fa-calendar-alt me-1"></i> {{ $video->formatted_date }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
        <!-- Latest News End -->
