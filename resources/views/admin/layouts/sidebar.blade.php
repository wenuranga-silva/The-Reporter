<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15" style="color: #fff;font-size: 30px">
            R
        </div>
        <div class="sidebar-brand-text mx-3">The Reporter <sub>Admin Panel</sub></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    @hasrole('admin')
    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ setActive(['dashboard'], 'active') }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    @endhasrole

    <!-- Heading -->
    <div class="sidebar-heading">
        starter
    </div>

    @hasrole('admin')
    <li class="nav-item {{ setActive(['admin.category.*', 'admin.tag.*' ,'admin.category-home.*'], 'active') }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
            aria-expanded="true" aria-controls="collapseOne">
            <i class="fas fa-tags"></i>
            <span>Tags  / Categories</span>
        </a>
        <div id="collapseOne"
            class="collapse {{ setActive(['admin.category.*', 'admin.tag.*' ,'admin.category-home.*'], 'show') }}"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">

            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item {{ setActive(['admin.category.*'], 'active') }}"
                    href="{{ route('admin.category.index') }}">Category</a>

                <a class="collapse-item {{ setActive(['admin.category-home.*'], 'active') }}"
                    href="{{ route('admin.category-home.index') }}">Category - Home</a>

                <a class="collapse-item {{ setActive(['admin.tag.*'], 'active') }}" href="{{ route('admin.tag.index') }}">Tag</a>
            </div>
        </div>
    </li>
    @endhasrole

    <li class="nav-item {{ setActive(
        [
            'admin.news.*',
            'admin.new.*',
            'admin.video.*',
            'admin.video_news.all'
        ]
         ,'active')
        }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-rss"></i>
            <span>News</span>
        </a>
        <div id="collapseTwo" class="collapse {{ setActive([
            'admin.news.*',
            'admin.new.*',
            'admin.video.*',
            'admin.video_news.all'
        ] ,'show') }}"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ setActive(['admin.news.*'] ,'active') }}" href="{{ route('admin.news.index') }}">News</a>
                <a class="collapse-item {{ setActive(['admin.video.*'] ,'active') }}" href="{{ route('admin.video.index') }}">News - Videos</a>

                @hasrole('admin')
                <a class="collapse-item {{ setActive(['admin.new.all'] ,'active') }}" href="{{ route('admin.new.all') }}">News - All</a>
                <a class="collapse-item {{ setActive(['admin.video_news.all'] ,'active') }}" href="{{ route('admin.video_news.all') }}">Video - All</a>
                @endhasrole

            </div>
        </div>
    </li>

    @hasrole('admin')
    <li class="nav-item {{ setActive(['admin.permission.*'], 'active') }}">
        <a class="nav-link" href="{{ route('admin.permission.index') }}">
            <i class="fas fa-user-lock"></i>
            <span>Permission</span></a>
    </li>

    <li class="nav-item {{ setActive([
            'admin.settings.*'
        ] ,'active') }}">

        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse_4" aria-expanded="true"
            aria-controls="collapse_4">
            <i class="fas fa-cogs"></i>
            <span>General Settings</span>
        </a>

        <div id="collapse_4" class="collapse {{ setActive([
            'admin.settings.*',
        ] ,'show') }}"
        aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ setActive(['admin.settings.nav.*'] ,'active') }}" href="{{ route('admin.settings.nav.index') }}">Navigation</a>
                <a class="collapse-item {{ setActive(['admin.settings.webInfo.*'] ,'active') }}" href="{{ route('admin.settings.webInfo.index') }}">Website Info</a>
            </div>
        </div>
    </li>
    @endhasrole

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

{{--
<!-- example -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Components</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Components:</h6>
            <a class="collapse-item" href="buttons.html">Buttons</a>
            <a class="collapse-item" href="cards.html">Cards</a>
        </div>
    </div>
</li> --}}
