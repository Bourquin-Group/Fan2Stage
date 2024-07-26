@extends('artistweb.layouts.main')
@section('body')
 <div class="login-page-main">
         <div class="login-section ">             
             <div class="login-form-section otp-section">
                  <a href="{{url('/web/login')}}" class="arrow-left"><img src="./assets/images/arrow-left.svg" alt="" srcset=""></a>
                  <div class="mbl-logo-sec">
                        <img src="../../../assets/images/mbl-Logo.png" alt="logo" class="src">
                  </div>
                  <div class="form-title">
                       <h1 class="font-32 wel-txt">Please Verify Account</h1>
                       <h6 class="font-20 wel-sub-txt">Enter the 4 digit code we sent to your email address
                        to verify your account</h6>
                  </div>
                  <div class="text-success" id="result"></div>
                  
                  @if (Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                  @endif
                  @if(session()->has('status'))
                    <p class="text-danger">{{session('status')}}</p>
                  @endif
                  
                  <div class="form-input-section ver-otp-inpt">
                      <form method="post" action="{{url('/web/otpverification/')}}">
                         @csrf
                          <div class="ver-otp">
                              <input type="number" name="otp[]" id="" class="font-24" maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');" >
                              <input type="number" name="otp[]" id="" class="font-24" maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');"disabled >
                              <input type="number" name="otp[]" id="" class="font-24" maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');" disabled>
                              <input type="number" name="otp[]" id="" class="font-24" maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');" disabled>
                             <input type="hidden" value="{{$user->email}}" name="email">
                             <input type="hidden" id="type" value="{{$type}}" name="type">
                             <input type="hidden" value="{{$user->uuid}}" name="uuid">
                             <!--  <input type="number" name="" id="" class="font-24"  disabled>
                              <input type="number" name="" id="" class="font-24"  disabled> -->
                          </div>

                          <div class="login-btn ">
                              <button type="submit" class="font-16">Verify and Continue</button>
                          </div>
                      </form>


                      <div class="resend-sec">
                          <p class="font-18"><span class="resend" id="resend" value="{{$user->email}}">Resend Code</span><span class="font-18 js-timeout">02:00</span></p>
                          <button id="js-startTimer">Start Countdown</button>
                          <button id="js-resetTimer">Stop &amp; Reset</button>
                      </div>

                  </div>                  
             </div>
         </div>
   </div>
@endsection
@section('timer')
<script type="text/javascript">
$(document).ready(function(){
   $("#js-startTimer").click(); 
});
</script>
@endsection