<header>
        <div class="custom_container header_section ">
            <div class="header_logo_section"> 
                <div class="header_logo"><a href="{{route('fanhome')}}"><img src="{{asset('/assets/fan/images/header_logo.png')}}" alt="logo"></a></div>
            </div>
            <ul class="nav_list">
                <a href="{{ url('fan/fanhome')}}"><li class="{{ (request()->is('fan/fanhome')) ? 'active' : '' }}">Home</li></a>
                <a href="{{ url('fan/myevent')}}"><li class ="{{ (request()->is('fan/myevent') || request()->is('fan/scheduled-event*') )  ? 'active' : '' }}">My Events</li></a>
                <a href="{{ url('fan/contact')}}"><li class ="{{ (request()->is('fan/contact')) ? 'active' : '' }}">Support</li></a>
            </ul>
            <div class="header_profile_section">
                <div class="header_icon_section">
                    <div class="seach_icon" data-bs-toggle="modal" href="#exampleModalToggle1" role="button"><img
                            src="{{asset('/assets/fan/images/magnifying-glass.svg')}}" alt=""> </div> 
                        <div class="fav_icon"><a href="{{route('favorites')}}"><img src="{{asset('/assets/fan/images/heart.svg')}}" alt=""></a></div>
                    {{-- <div class="notfication_icon" data-bs-toggle="modal" href="#exampleModalToggle" role="button"><img
                            src="{{asset('/assets/fan/images/notification.svg')}}" alt=""></div> --}}
                </div>
                <a href="{{route('editProfile')}}">
                    <div class="header_profile">
                        <div class="header_profile_img">
                            <img src="{{auth()->user()->profile()}}" alt="profile" />
                        </div>
                        <div class="header_profile_name">
                            <p>Welcome!</p>
                            <h6>{{ isset(auth()->user()->name) ? auth()->user()->name : '' }}</h6>
                        </div>
                        <div class="header_profile_icon">
                            {{-- <img src="{{asset('/assets/fan/images/down_arrow.svg')}}" alt="arrow"> --}}
                        </div>
                    </div>
                </a>
                <div class="menu_icon nav-icon" aria-label="Main Menu">
                    <svg width="30" height="30" viewBox="0 0 100 100">
                        <path class="line line1"
                            d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058" />
                        <path class="line line2" d="M 20,50 H 80" />
                        <path class="line line3"
                            d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942" />
                    </svg>
  
                </div>
            </div>
        </div>
</header>