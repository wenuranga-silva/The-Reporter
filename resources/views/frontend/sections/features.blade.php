<div class="container-fluid features mb-5">
    <div class="container py-5">
        <div class="row g-4 justify-content-around">

            @if (empty($popular_news))

                @for ($i = 0; $i < 3; $i++)
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="row g-4 align-items-center features-item">

                            <div class="col-12">
                                <div class="features-content d-flex flex-column">
                                    <p class="text-uppercase mb-2">{{ $popular_news[$i]->Category->name }}</p>
                                    <a href="{{ route('post', $popular_news[$i]->id) }}" class="h6">
                                        {!! $popular_news[$i]->title !!}
                                    </a>
                                    <small class="text-body d-block"><i class="fas fa-calendar-alt me-1"></i>
                                        {{ $popular_news[$i]->formatted_date }} </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            @endif


        </div>
    </div>
</div>
