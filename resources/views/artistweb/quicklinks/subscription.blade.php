<div class="tab-pane fade {{ (request()->is('web/subscription')) ? 'show active' : '' }}" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">
  <div class="tab-heading">
    <h1 class="font-28">Subscriptions</h1>
  </div>
  <div class="profile-main sub-main1">
                @if(session()->has('error'))
                      <p class="alert alert-danger">{{session('error')}}</p>
                  @endif
                  @if(session()->has('success'))
                      <p class="alert alert-success">{{session('success')}}</p>
                  @endif
      <div class="sub-content">
         <h6 class="font-24">Choose the plan that’s right for you </h6>
         <p class="text-danger"> 
          @if($expired_status)
          Your {{auth()->user()->subscriptionPlan->f2s_plan}} plan is expired, Please choose the plan..
          @endif
        </p>
      </div>
      <div class="plan-section">
        @if(isset($planlist) && $planlist)
        @foreach ($planlist as $pl_value)
          <div class="plan-details @if(auth()->user()->subscription_plan_id == $pl_value['id'] && $expired_status ==0) plan-active @endif">
            <div class="plan-img">
              <img src="{{ asset('assets/web/images/parachute.svg') }}" alt="" srcset="">
            </div>
            <h3 class="font-20">{{ ucfirst($pl_value['f2s_plan'])}}</h3>
            <h1 class="font-28">
              @if($pl_value['cost'] =='free')
               {{ ucfirst($pl_value['cost']) }}
              @elseif($pl_value['cost'] =='call for Quote')
               {{ ucfirst($pl_value['cost']) }}
              @else
              ${{$pl_value['cost_value']}}
              @endif
            </h1>
            <p>Events Limit</p>
            <h6>{{$pl_value['events_per_month']}} Events <span>/ Month</span></h6>
            <p class="font-16">Fans Limit</p>
            <h3 class="font-20">{{$pl_value['fans_per_event']}} Fans</h3>
            @if($pl_value['cost'] =='free')
              <form method="post" action="{{route('subscription.post')}}">
                @csrf()
                <input type="hidden" value="{{$pl_value['id']}}" name="subscription_plan_id">
                <input type="hidden" value="0" name="type">
                <button class="select-btn font-16" type="submit">Select</button>
              </form>
            @elseif($pl_value['cost'] =='call for Quote')
              <a class="header_profile_subscription" href="{{ url('web/contact')}}"><button class="font-16 save-btn">Contact us</button></a>
            @else
            <button class="select-btn font-16" ><a href="{{route('subscription-payment',$pl_value['id'])}}">Select</a></button>
            @endif
            
            <div class="active-bottom">
              <span>Active Plan</span>
            </div>
          </div>
        @endforeach
        @endif
      </div>
  </div>
              
</div>