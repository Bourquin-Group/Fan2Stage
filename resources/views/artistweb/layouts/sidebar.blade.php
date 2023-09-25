<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 tab-navbar">
  <h1 class="font-28">Quick Links</h1>
  <div class="tab-list nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <h6 class="font-18">Fan2Stage And You</h6>
       
        <a href="{{route('profile')}}" class="font-18 nav-tab-btn {{ (request()->is('web/profile') || request()->is('web/editprofile')) ? 'active' : '' }}" style="{{(!auth()->user()->subscription_plan_id || !auth()->user()->billinginfo)? 'pointer-events: none;': '' }}" > 
             <img class="active-none" src="{{ asset('assets/web/images/user-hov-tab.svg') }}" alt="" srcset="">
             <img src="{{ asset('assets/web/images/user-tab.svg') }}" alt="" srcset="">
             <span>Profile</span>
        </a>
        <a href="{{route('billinginfo')}}" class="font-18 nav-tab-btn {{ 
          (request()->is('web/billinginfo') || request()->is('web/billinginfo/*')) ? 'active' : '' }}" style="{{(!auth()->user()->billinginfo)? 'pointer-events: none;': '' }}"  > 
            <img src="{{ asset('assets/web/images/sub-tab.svg') }}" alt="" srcset="">
            <img class="active-none" src="{{ asset('assets/web/images/sub-tab-hov.svg') }}" alt="" srcset=""> 
            <span>Billing Info</span>
        </a>
        <a href="{{route('subscription')}}" class="font-18 nav-tab-btn {{ 
          (request()->is('web/subscription') || request()->is('web/subscription-payment/*')) ? 'active' : '' }}" style="{{(!auth()->user()->billinginfo)? 'pointer-events: none;': '' }}"  > 
            <img src="{{ asset('assets/web/images/sub-tab.svg') }}" alt="" srcset="">
            <img class="active-none" src="{{ asset('assets/web/images/sub-tab-hov.svg') }}" alt="" srcset=""> 
            <span>Subscriptions</span>
        </a>
       {{-- <h6 class="font-18">Other</h6> --}}
        <a href="{{route('aboutus')}}" class="font-18 nav-tab-btn {{ (request()->is('web/aboutus')) ? 'active' : '' }}" style="{{(!auth()->user()->subscription_plan_id  || auth()->user()->verified_profile == 0 || !auth()->user()->billinginfo)? 'pointer-events: none;': '' }}" > 
         <img src="{{ asset('assets/web/images/help-circle-tab.svg') }}" alt="" srcset="">  
         <img class="active-none" src="{{ asset('assets/web/images/help-circle-hov-tab.svg') }}" alt="" srcset=""> <span>About</span>
        </a>

        <a href="{{route('termscondition')}}" class="font-18 nav-tab-btn {{ (request()->is('web/termscondition')) ? 'active' : '' }}" style="{{(!auth()->user()->subscription_plan_id  || auth()->user()->verified_profile == 0 || !auth()->user()->billinginfo)? 'pointer-events: none;': '' }}"   > 
            <img src="{{ asset('assets/web/images/terms-and-conditions-tab.svg') }}" alt="" srcset="">  
            <img class="active-none" src="{{ asset('assets/web/images/terms-and-conditions-tab-hov.svg') }}" alt="" srcset="">
         <span>Terms and Conditions</span>
        </a>
       
        <a href="{{route('privacypolicy')}}" class="font-18 nav-tab-btn {{ (request()->is('web/privacypolicy')) ? 'active' : '' }}" style="{{(!auth()->user()->subscription_plan_id  || auth()->user()->verified_profile == 0 || !auth()->user()->billinginfo)? 'pointer-events: none;': '' }}"  > 
            <img src="{{ asset('assets/web/images/shield-tab.svg') }}" alt="" srcset=""> 
            <img class="active-none" src="{{ asset('assets/web/images/shield-hov-tab.svg') }}" alt="" srcset="">
            <span>Privacy Policy</span>
        </a>
       </button>
       <button class="font-18 nav-tab-btn"type="button"><a onclick="return confirm('Are you sure want to logout?')" class="img-icon" href="{{ url('web/logout') }}"><img src="{{ asset('assets/web/images/logout-tab.svg') }}" alt="" srcset=""><span>Logout</span></a></button>
  </div>                  
</div>