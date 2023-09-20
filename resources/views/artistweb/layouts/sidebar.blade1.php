<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 tab-navbar">
    <h1 class="font-28">Quick Links</h1>
    <div class="tab-list nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <h6 class="font-18">General</h6>
         <button class="font-18 nav-tab-btn {{ (request()->is('web/profile') || request()->is('web/editprofile')) ? 'active' : '' }}" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="{{ (request()->is('web/profile') || request()->is('web/editprofile')) ? 'true' : 'false' }}" {{(!auth()->user()->subscription_plan_id)? 'disabled': '' }}>
             <img class="active-none" src="{{ asset('assets/web/images/user-hov-tab.svg') }}" alt="" srcset="">
             <img src="{{ asset('assets/web/images/user-tab.svg') }}" alt="" srcset="">
             <span>Profile</span>
             <a class="mbl-block" href="{{ url('web/profile') }}">Profile</a>
           </button>
         <button class="font-18 nav-tab-btn {{ (request()->is('web/subscription')) ? 'active' : '' }}" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="{{ (request()->is('web/subscription')) ? 'true' : 'false' }}">                                                 
              <img src="{{ asset('assets/web/images/sub-tab.svg') }}" alt="" srcset="">
              <img class="active-none" src="{{ asset('assets/web/images/sub-tab-hov.svg') }}" alt="" srcset="">
           <span>Subscriptions</span>
           <a class="mbl-block" href="{{ url('web/subscription') }}">Subscriptions</a>
         </button>
         <h6 class="font-18">Other</h6>
         <button class="font-18 nav-tab-btn {{ (request()->is('web/about')) ? 'active' : '' }}" id="v-pills-disabled-tab" data-bs-toggle="pill" data-bs-target="#v-pills-disabled" type="button" role="tab" aria-controls="v-pills-disabled" aria-selected="{{ (request()->is('web/about')) ? 'true' : 'false' }}" {{(!auth()->user()->subscription_plan_id)? 'disabled': '' }} >                                                 
           <img src="{{ asset('assets/web/images/help-circle-tab.svg') }}" alt="" srcset="">  
           <img class="active-none" src="{{ asset('assets/web/images/help-circle-hov-tab.svg') }}" alt="" srcset="">                          
            <span>About</span><a class="mbl-block" href="./Terms-and-Conditions.html">About</a> </button>
         <button class="font-18 nav-tab-btn" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-terms" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false" {{(!auth()->user()->subscription_plan_id)? 'disabled': '' }}>                                                
              <img src="{{ asset('assets/web/images/terms-and-conditions-tab.svg') }}" alt="" srcset="">  
              <img class="active-none" src="{{ asset('assets/web/images/terms-and-conditions-tab-hov.svg') }}" alt="" srcset="">
           <span>Terms and Conditions</span><a class="mbl-block" href="./Terms-and-Conditions.html">Terms and Conditions</a> </button>
         <button class="font-18 nav-tab-btn" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false" {{(!auth()->user()->subscription_plan_id)? 'disabled': '' }}>                       
             <img src="{{ asset('assets/web/images/shield-tab.svg') }}" alt="" srcset=""> 
             <img class="active-none" src="{{ asset('assets/web/images/shield-hov-tab.svg') }}" alt="" srcset="">
             <span>Privacy Policy</span><a class="mbl-block" href="./Privacy-Policy.html">Privacy Policy</a> </button></button>
         <button class="font-18 nav-tab-btn"type="button"><a href="{{ url('web/logout') }}"><img src="{{ asset('assets/web/images/logout-tab.svg') }}" alt="" srcset="">Logout</a></button>
    </div>                  
 </div>