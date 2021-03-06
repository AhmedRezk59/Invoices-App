<!-- main-header opened -->
<div class="main-header sticky side-header nav nav-item">
    <div class="container-fluid">
        <div class="main-header-left ">
            <div class="responsive-logo">
                <a href="{{ url('/' . ($page = 'index')) }}"><img
                        src="{{ URL::asset('assets/img/brand/logo.png') }}" class="logo-1" alt="logo"></a>
                <a href="{{ url('/' . ($page = 'index')) }}"><img
                        src="{{ URL::asset('assets/img/brand/logo-white.png') }}" class="dark-logo-1"
                        alt="logo"></a>
                <a href="{{ url('/' . ($page = 'index')) }}"><img
                        src="{{ URL::asset('assets/img/brand/favicon.png') }}" class="logo-2" alt="logo"></a>
                <a href="{{ url('/' . ($page = 'index')) }}"><img
                        src="{{ URL::asset('assets/img/brand/favicon.png') }}" class="dark-logo-2" alt="logo"></a>
            </div>
            <div class="app-sidebar__toggle" data-toggle="sidebar">
                <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
                <a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
            </div>
            
        </div>
        <div class="main-header-right">
            
        <div class="nav nav-item  navbar-nav-right ml-auto">
            
           
            @can('الاشعارات')

                <div class="dropdown nav-item main-header-notification">
                    <a class="new nav-link" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-bell">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg><span class=" pulse"></span></a>
                    <div class="dropdown-menu">
                        <div class="menu-header-content bg-primary text-right">
                            <div class="d-flex">
                                <h6 class="dropdown-title tx-15 text-white font-weight-semibold">الاشعارات</h6>
                                 <span
                                        class="badge badge-pill badge-danger mr-auto float-left"><a href="\readAll" class="text-white">تعين
                                        قراءة الكل</a></span>
                            </div>

                            <h6 style="color: yellow" id="notifications_count">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </h6>

                        </div>
                        <div id="unreadNotifications">
                            @foreach (auth()->user()->unreadNotifications as $notification)
                                <div class="main-notification-list Notification-scroll">
                                    <a class="border-bottom"
                                        href="{{ url('InvoicesDetails') }}/{{ $notification->data['id'] }}">

                                        <div class=" font-weight-semibold">
                                            <h5
                                                class="
                                            notification-label mb-1">
                                                {{ $notification->data['title'] }}
                                                {{ $notification->data['user'] }}
                                            </h5>
                                        </div>
                                        <div class="notification-subtext">{{ $notification->created_at }}</div>
                                    </a>
                                    <a href="\read\{{ $notification->data['id'] }}">
                                        <span
                                            class="badge badge-pill badge-primary p-2 mr-auto mb-2 float-left text-white">تعين
                                            قراءة</span></a>


                                </div>
                                <hr>
                            @endforeach

                        </div>
                    </div>
                </div>
            @endcan
            <div class="nav-item full-screen fullscreen-button">
                <a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg"
                        class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize">
                        <path
                            d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3">
                        </path>
                    </svg></a>
            </div>
            <div class="dropdown main-profile-menu nav nav-item nav-link">
                <a class="profile-user d-flex" href=""><img alt=""
                        src="{{ URL::asset('assets/img/faces/6.jpg') }}"></a>
                <div class="dropdown-menu">
                    <div class="main-header-profile bg-primary p-3">
                        <div class="d-flex wd-100p">
                            <div class="main-img-user"><img alt="" src="{{ URL::asset('assets/img/faces/6.jpg') }}"
                                    class=""></div>
											<div class=" mr-3 my-auto">
                                <h6>{{ Auth::User()->name }}</h6><span>{{ Auth::User()->email }}</span>
                            </div>
                        </div>
                    </div>
                    <a class="dropdown-item" href=""><i class="bx bx-user-circle"></i>Profile</a>
                    <a class="dropdown-item" href=""><i class="bx bx-cog"></i> Edit Profile</a>
                    <a class="dropdown-item" href=""><i class="bx bxs-inbox"></i>Inbox</a>
                    <a class="dropdown-item" href=""><i class="bx bx-envelope"></i>Messages</a>
                    <a class="dropdown-item" href=""><i class="bx bx-slider-alt"></i> Account Settings</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                            class="bx bx-log-out"></i>تسجيل خروج</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>



                </div>
            </div>
           
        </div>
    </div>
</div>
</div>
<!-- /main-header -->
