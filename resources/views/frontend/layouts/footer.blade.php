<!-- Footer Start -->
<div class="container-fluid bg-dark footer py-5">
    <div class="container py-5">
        <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
            <div class="row g-4">
                <div class="col-lg-3">
                    <a href="{{ route('home') }}" class="d-flex flex-column flex-wrap">
                        <p class="text-white mb-0 display-6">Newsers</p>
                        <small class="text-light" style="letter-spacing: 11px; line-height: 0;">Newspaper</small>
                    </a>
                </div>
                <div class="col-lg-9">

                </div>
            </div>
        </div>
        <div class="row g-5">
            <div class="col-lg-6 col-xl-4">
                <div class="footer-item-1">
                    <h4 class="mb-4 text-white">Get In Touch</h4>
                    <p class="text-secondary line-h">Address: <span class="text-white">{{ $webInfo->address }}</span>
                    </p>
                    <p class="text-secondary line-h">Email: <span class="text-white">{{ $webInfo->email }}</span></p>
                    <p class="text-secondary line-h">Phone: <span class="text-white">{{ $webInfo->tel }}</span></p>
                    <div class="d-flex line-h" style="margin-top: 10px">
                        <a class="btn btn-light me-2 btn-md-square rounded-circle" href="{{ $webInfo->tw_url }}"><i
                                class="fab fa-twitter text-dark"></i></a>
                        <a class="btn btn-light me-2 btn-md-square rounded-circle" href="{{ $webInfo->fb_url }}"><i
                                class="fab fa-facebook-f text-dark"></i></a>
                        <a class="btn btn-light me-2 btn-md-square rounded-circle" href="{{ $webInfo->yt_url }}"><i
                                class="fab fa-youtube text-dark"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4">
                <div class="footer-item-2">
                    <div class="d-flex flex-column mb-4">
                        <h4 class="mb-4 text-white">Recent Posts</h4>
                        <a href="{{ route('post', $_news[0]->id) }}">
                            <div class="d-flex align-items-center">
                                <div class="border-primary overflow-hidden" style="border-radius: 3px">
                                    <img src="{{ $_news[0]->PostImage[0]->image }}"
                                        style="border-radius: 3px;width: 210px !important"
                                        class="img-zoomin img-fluid w-100" alt="image">
                                </div>
                                <div class="d-flex flex-column ps-4">
                                    <p class="text-uppercase text-white mb-3">{{ $_news[0]->Category->name }}</p>
                                    <a href="{{ route('post', $_news[0]->id) }}" class="h6 text-white">
                                        {!! strlen($_news[0]->title) > 60 ? Str::substr($_news[0]->title, 0, 60) . '...' : $_news[0]->title !!}
                                    </a>
                                    <small class="text-white d-block"><i class="fas fa-calendar-alt me-1"></i>
                                        {{ $_news[0]->formatted_date }}</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="d-flex flex-column mb-4">
                        <a href="{{ route('post', $_news[1]->id) }}">
                            <div class="d-flex align-items-center">
                                <div class="border-primary overflow-hidden" style="border-radius: 3px">
                                    <img src="{{ $_news[1]->PostImage[0]->image }}"
                                        style="border-radius: 3px;width: 210px !important;"
                                        class="img-zoomin img-fluid w-100" alt="image">
                                </div>
                                <div class="d-flex flex-column ps-4">
                                    <p class="text-uppercase text-white mb-3">{{ $_news[1]->Category->name }}</p>
                                    <a href="{{ route('post', $_news[1]->id) }}" class="h6 text-white">
                                        {!! strlen($_news[1]->title) > 60 ? Str::substr($_news[1]->title, 0, 60) . '...' : $_news[1]->title !!}
                                    </a>
                                    <small class="text-white d-block"><i class="fas fa-calendar-alt me-1"></i>
                                        {{ $_news[1]->formatted_date }}</small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4">
                <div class="d-flex flex-column text-start footer-item-3">
                    <h4 class="mb-4 text-white">Categories</h4>

                    @foreach ($_cats as $c)
                        <a class="btn-link text-white" href="{{ route('post.category', $c->Category->id) }}"><i
                                class="fas fa-angle-right text-white me-2"></i> {{ $c->Category->name }}</a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Footer End -->


<!-- Copyright Start -->
<div class="container-fluid copyright bg-dark py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>The
                        Reporter</a>, All right reserved.</span>
            </div>
        </div>
    </div>
</div>
<!-- Copyright End -->


<!-- Back to Top -->
<a href="#" class="btn btn-primary border-2 border-white rounded-circle back-to-top"><i
        class="fa fa-arrow-up"></i></a>


<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('vendor/lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('vendor/lib/waypoints/waypoints.min.js') }}"></script>
<script src="{{ asset('vendor/lib/owlcarousel/owl.carousel.min.js') }}"></script>

<!-- Template Javascript -->
<script src="{{ asset('vendor/js/main.js') }}"></script>

<script>
    let width = screen.width;

    let item_count = 10

    if (width < 400) {

        item_count = 4
    } else if (width < 550) {

        item_count = 5
    } else if (width < 768) {

        item_count = 7
    }

    var owl = $('.owl-carousel');
    owl.owlCarousel({
        items: item_count,
        loop: true,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 3500,
        autoplayHoverPause: true,
    })

    owl.on('mousewheel', '.owl-stage', function(e) {
        if (e.deltaY > 0) {
            owl.trigger('next.owl');
        } else {
            owl.trigger('prev.owl');
        }
        e.preventDefault();
    })

    $(document).ready(function() {


        let typingTimer
        let doneTypingInterval = 500


        $('.search_input').on('keyup', function() {
            clearTimeout(typingTimer)
            typingTimer = setTimeout(doneTyping, doneTypingInterval)
        })

        $('.search_input').on('keydown', function() {
            clearTimeout(typingTimer)
        })

        function doneTyping() {

            let txt = $('.search_input').val()

            let url = "{{ route('request.search.result', ':txt') }}"
            url = url.replace(':txt', txt)
            $.ajax({
                type: "GET",
                url: url,
                data: {
                    txt: txt
                },
                success: function(response) {

                    let results = `<li style="color:black;font-size:  20px">Related Keywords - </li>`

                    if (response.status == 'y') {

                        $.each(response.search_result, function(index, val) {

                            let link = "{{ route('request.search' ,':key_') }}"
                            link = link.replace(':key_' ,val['name'])

                            results += `<li><a href="${link}">${val['name']}</a></li>`
                        })
                    } else {

                        results = ''
                    }

                    $('#search_results').html(results)
                }
            })

        }

        $('body').on('submit' ,'.serch_form' , function (e) {
            e.preventDefault()

            let txt = $('.search_input').val()

            let url = "{{ route('request.search', ':txt') }}"
            url = url.replace(':txt', txt)

            window.open(url, "_self")

        })

    })
</script>

@stack('js')

</body>

</html>
