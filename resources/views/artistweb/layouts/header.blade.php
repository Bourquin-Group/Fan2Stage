<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FanToStage</title>
    <link rel="stylesheet" href="{{ asset('assets/web/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/web/css/fontawesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/web/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/web/css/responsive.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/web/css/variable.css') }}" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>

    {{-- image crop --}}
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
    {{-- image crop --}}

    {{-- sweet alert --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>
    {{-- sweet alert --}}

    {{-- Toast message --}}
    <link rel="stylesheet" type="text/css" 
     href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- Toast message --}}
    

    {{-- socket cdn --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.1/socket.io.js" integrity="sha512-Z6C1p1NIexPj5MsVUunW4pg7uMX6/TT3CUVldmjXx2kpip1eZcrAnxIusDxyFIikyM9A61zOVNgvLr/TGudOQg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- socket cdn --}}
    
    @yield('header-script')
    @yield('header')
  @yield('css')
</head>

  <body>
    
    @if(\Auth::check()) 
    @if((!request()->is('web/login')) && (!request()->is('web/forgotpassword')))
<header>
    <div class="custom_container header_section">
      <div class="header_logo_section">
        <div class="header_logo">
          {{-- <img src="./assets/images/header_logo.png" alt="logo" /> --}}
          <img src="{{ asset('assets/web/images/header_logo.png') }}" alt="logo" />
        </div>
      </div>
      <ul class="nav_list">
        <a href="{{ url('web/artisthome') }}"><li class="{{ (request()->is('web/artisthome')) ? 'active' : '' }}">Home</li></a>
        <li class="{{ (request()->is('web/golive*')) ? 'active' : '' }}">Live Event</li>
        {{-- <li class="{{ (request()->is('web/liveevent')) ? 'active' : '' }}"><a href="{{ url('web/liveevent') }}">Live Event</a></li> --}}
        <a href="{{route('eventHistory')}}" ><li  class="{{ (request()->is('web/event-history*')) ? 'active' : '' }}">Event History</li></a>
        {{-- <li><a href="#">Latest Event History</a></li> --}}
        <a href="{{ url('web/contact')}}"><li class="{{ (request()->is('web/contact*')) ? 'active' : '' }}">Support</li></a>
      </ul>
      <div class="header_profile_section">
        <a href="{{ url('web/eventCreate')}}"> <button>
          <img src="{{ asset('assets/web/images/add_event_icon.svg') }}" alt="icon" />Create
          Event
        </button></a>
     <a href="{{ isset(auth()->user()->subscription_plan_id) ? url('web/profile') : '' }}">
      <div class="header_profile">
        <div class="header_profile_img">
          @if(isset(auth()->user()->artistProfile->profile_image))
          <img src="{{ asset('artist_profile_images/'.optional(auth()->user()->artistProfile)->profile_image)}}" alt="profile" />
          @else
          <img src="{{ asset('artist_profile_images/profile1.jpeg')}}" alt="profile" />
          @endif
        </div>
        <div class="header_profile_name">
          <p>Welcome!</p>
          <h6>{{ isset(auth()->user()->name) ? auth()->user()->name : '' }}</h6>
        </div>
        <div class="header_profile_icon">
          {{-- <img src="{{ asset('assets/web/images/down_arrow.svg') }}" alt="arrow" /> --}}
        </div>
      </div>
     </a>
        <div class="menu_icon nav-icon" aria-label="Main Menu">
          <svg width="30" height="30" viewBox="0 0 100 100">
            <path
              class="line line1"
              d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058"
            />
            <path class="line line2" d="M 20,50 H 80" />
            <path
              class="line line3"
              d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942"
            />
          </svg>
        </div>
      </div>
    </div>
  </header>
  @endif
  @endif