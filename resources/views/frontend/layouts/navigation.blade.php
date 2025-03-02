<!-- Navbar start -->
<div class="container-fluid sticky-top px-0">
    <div class="container-fluid topbar bg-dark d-none d-lg-block stk">
        <div class="container px-0">
            <div class="topbar-top d-flex justify-content-between flex-lg-wrap">
                <div class="top-info flex-grow-0">
                    <span class="rounded-circle btn-sm-square bg-primary me-2">
                        <i class="fas fa-bolt text-white"></i>
                    </span>
                    <div class="pe-2 me-3 border-end border-white d-flex align-items-center">
                        <p class="mb-0 text-white fs-6 fw-normal">Trending</p>
                    </div>
                    <div class="overflow-hidden" style="width: 735px;">
                        <div id="note" class="ps-2">
                            <a href="{{ route('post' ,$_news[0]->id) }}">
                                <p class="text-white mb-0 link-hover">{!! $_news[0]->title !!}</p>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="container-fluid bg-light">
        <div class="container px-0">
            <nav class="navbar navbar-light navbar-expand-xl">
                <a href="{{ route('home') }}" class="navbar-brand mt-3">
                    <p class="text-primary display-6 mb-2" style="font-size: 33px;line-height: 0;">The Reporter</p>
                    <small class="text-body fw-normal" style="letter-spacing: 14px;">Newspaper</small>
                </a>
                <button class="navbar-toggler py-2 px-3 btn-sm shadow-sm" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-light py-3" id="navbarCollapse">
                    <div class="navbar-nav mx-auto border-top">
                        <a href="{{ route('home') }}" class="nav-item nav-link {!! isset($title) && Str::lower($title) == 'home' ? 'active' : '' !!}">Home</a>


                        @foreach ($_cats as $key => $cat)

                        @if ($key == 4)
                        @break
                        @endif

                        <a href="{{ route('post.category' ,$cat->category_id) }}" class="nav-item nav-link {!! isset($title) && Str::lower($title) == Str::lower($cat->Category->name) ? 'active' : '' !!}">{!! $cat->Category->name !!}</a>
                        @endforeach


                    </div>
                    <div class="d-flex flex-nowrap border-top pt-3 pt-xl-0">
                        {{-- <div class="d-flex">
                            <img src="img/weather-icon.png" class="img-fluid w-100 me-2" alt="">
                            <div class="d-flex align-items-center">
                                <strong class="fs-4 text-secondary">31°C</strong>
                                <div class="d-flex flex-column ms-2" style="width: 150px;">
                                    <span class="text-body">NEW YORK,</span>
                                    <small>Mon. 10 jun 2024</small>
                                </div>
                            </div>
                        </div> --}}

                        <div class="d-flex dropdown">

                            @auth
                            <a class="nav-link dropdown-toggle me-3"href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="display: flex;align-items: center">

                                @if (Auth::user()->photo != null)

                                <img src="{{ asset(Auth::user()->photo) }}" width="40px" style="border-radius: 3px" alt="image"/>
                                @else

                                {{ Auth::user()->name }}
                                @endif
                            </a>

                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item ps-4" href="{{ route('profile.edit') }}">Profile</a></li>

                                @hasrole('admin|writer')
                                <li><a class="dropdown-item ps-4" href="{{ route('dashboard') }}">Dashboard</a></li>
                                @endhasrole

                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </li>

                            </ul>
                            @endauth

                            @guest

                            <button class="btn btn-primary btn-sm shadow-sm me-3" style="color: white;" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="fas fa-users"></i> Login
                            </button>
                            @endguest

                        </div>

                        <button
                            class="btn-search btn border border-primary btn-md-square rounded-circle bg-white my-auto"
                            data-bs-toggle="modal" data-bs-target="#searchModal"><i
                                class="fas fa-search text-primary"></i></button>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->

<!-- Category Slider -->
<div class="owl-carousel owl-theme category_slider" style="background-color: #f4f6f8 !important;box-shadow: 0 1px 2px rgba(0 ,0 ,0 ,.2);border-top: 1px solid rgba(0 ,0 ,0 ,.2);padding: 10px 0;">

    @foreach ($categories_all as $category)

    <div><a href="{{ route('post.category' ,$category->id) }}" class="cat_a " style="{!! isset($title) && Str::lower($title) == Str::lower($category->name) ? 'color: #1b7dff;' : '' !!}">{!! $category->name !!}</a></div>
    @endforeach

</div>

<!-- Login Model Start -->

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header" style="border-bottom: none">
                <a href="javascript:void(0)" class="navbar-brand mt-3">
                    <p class="text-primary display-6 mb-2" style="font-size: 33px;line-height: 0;">The Reporter</p>
                    <small class="text-body fw-normal" style="letter-spacing: 14px;">Newspaper</small>
                </a>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <ul class="nav nav-tabs" id="myTab" role="tablist">

                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                            data-bs-target="#home-tab-pane" type="button" role="tab"
                            aria-controls="home-tab-pane" aria-selected="true">Login</button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                            data-bs-target="#profile-tab-pane" type="button" role="tab"
                            aria-controls="profile-tab-pane" aria-selected="false">Register</button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="forgot-tab" data-bs-toggle="tab"
                            data-bs-target="#forgot-tab-pane" type="button" role="tab"
                            aria-controls="forgot-tab-pane" aria-selected="false">Forgot Password</button>
                    </li>

                </ul>

                <div class="tab-content mt-4" id="myTabContent">

                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                        aria-labelledby="home-tab" tabindex="0">

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('login.submit') }}">
                            @csrf

                            <!-- Email Address -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                    :value="old('email')" required autofocus autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mt-4">
                                <x-input-label for="password" :value="__('Password')" />

                                <x-text-input id="password" class="block mt-1 w-full" type="password"
                                    name="password" required autocomplete="current-password" />

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Remember Me -->
                            <div class="block mt-4">
                                <label for="remember_me" class="inline-flex items-center">
                                    <input id="remember_me" type="checkbox"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                        name="remember">
                                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                </label>
                            </div>

                            <div class="flex items-center justify-end mt-4">

                                <x-primary-button class="ms-3">
                                    {{ __('Log in') }}
                                </x-primary-button>
                            </div>
                        </form>

                    </div>

                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                        tabindex="0">

                        <form method="POST" action="{{ route('register.submit') }}">
                            @csrf

                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                    :value="old('name')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email Address -->
                            <div class="mt-4">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                    :value="old('email')" required autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mt-4">
                                <x-input-label for="password" :value="__('Password')" />

                                <x-text-input id="password" class="block mt-1 w-full" type="password"
                                    name="password" required autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="mt-4">
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                    name="password_confirmation" required autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end mt-4">

                                <x-primary-button class="ms-4">
                                    {{ __('Register') }}
                                </x-primary-button>
                            </div>
                        </form>

                    </div>

                    <div class="tab-pane fade" id="forgot-tab-pane" role="tabpanel" aria-labelledby="forgot-tab"
                        tabindex="0">

                        <div class="mb-4 text-sm text-gray-600">
                            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                        </div>

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- Email Address -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                    :value="old('email')" required autofocus />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button>
                                    {{ __('Email Password Reset Link') }}
                                </x-primary-button>
                            </div>
                        </form>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<!-- Login Model End -->

<!-- Modal Search Start -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title csutom-5" id="exampleModalLabel">Search by keyword</h5>
                <button type="button" class="btn-close shadow-sm btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body search_body d-flex align-items-center">
                <form style="width: 100%" class="serch_form">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="search_input form-control p-3" placeholder="keywords"
                            aria-describedby="search-icon-1" name="search">
                        <button type="submit" id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></button>
                    </div>
                </form>

                <ul id="search_results">

                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Modal Search End -->
