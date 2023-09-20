@extends('fanweb.layouts.main')
@section('content')
<div class="login-page-main">
    <div class="login-section res-pad-top">
        <div class="login-form-section">
            <div class="mbl-logo-sec">
                <img src="{{asset('/assets/fan/images/mbl-Logo.png')}}" alt="logo" class="src">
            </div>
             <div class="form-title">
                  <h1 class="font-32 wel-txt">Lets’s Get Started!</h1>
                  <h6 class="font-20 wel-sub-txt">Create an Account to Fan2Stage</h6>
             </div>
             <div class="form-input-section">
                  @if(session()->has('success'))
                        <p class="alert alert-success">{{session('success')}}</p>
                  @endif
                 <form method="post" action="{{url('/fan/registerstore')}}" autocomplete="on">
                 @csrf
                   <div class="email-section">
                       <label for="" class="font-16">Full Name*</label>
                       <div class="email-icon">
                         <span>
                             <img src="{{asset('/assets/fan/images/user.svg')}}" alt="" srcset="">
                         </span>
                         <input class="font-16" type="text" placeholder="Name" value="{{old('full_name')}}" name="full_name">
                       </div>
                        @if ($errors->has('full_name'))
                          <span class="error_msg">{{ $errors->first('full_name') }}</span>
                        @endif
                   </div>
                   <div class="email-section">
                       <label for="" class="font-16">Mobile Number* </label>
                       <div class="email-icon mbl-num-sec">
                         <span>
                             <img src="{{asset('/assets/fan/images/phone.svg')}}" alt="" srcset="">
                         </span>
                         <input type="" id="phoneNumber1" value="{{old('phone_number')}}" name="phone_number" placeholder="Phone Number" maxlength="16" onInput="this.value = phoneFormat1(this.value)"/>
                         <div class="num-drp">
                                <p>
                                  <select name="country_code" id="country_code">
                                    <option value="+01" @if (old('country_code') == "+01") {{ 'selected' }} @endif>+01</option>
                                    <option value="+07" @if (old('country_code') == "+07") {{ 'selected' }} @endif>+07</option>
                                    <option value="+61" @if (old('country_code') == "+61") {{ 'selected' }} @endif>+61</option>
                                    <option value="+91" @if (old('country_code') == "+91") {{ 'selected' }} @endif>+91</option>
                                  </select>
                                </p>
                         </div>
                       </div>
                        @if ($errors->has('country_code'))
                          <span class="error_msg">{{ $errors->first('country_code') }}</span><br>
                        @endif
                        @if ($errors->has('phone_number'))
                          <span class="error_msg">{{ $errors->first('phone_number') }}</span>
                        @endif
                   </div>
                     <div class="email-section">
                         <label for="" class="font-16">Email Address*</label>
                         <div class="email-icon">
                           <span>
                               <img src="{{asset('/assets/fan/images/Email.svg')}}" alt="" srcset="">
                           </span>
                           <input class="font-16" type="emails" name="email" placeholder="Enter Email Address" value="{{old('email')}}">
                         </div>
                         @if ($errors->has('email'))
                          <span class="error_msg">{{ $errors->first('email') }}</span>
                          @endif
                          @if (isset($error)&& $error)
                          <span class="error_msg">{{ $error }}</span>
                          @endif
                     </div>
                     <div class="password-section">
                           <label for="" class="font-16">Password*</label>
                           <div class="psd-eye">
                               <span class="psd-icon"> <img src="{{asset('/assets/fan/images/password.svg')}}" alt="" srcset=""> </span>
                               <input class="font-16" type="password" name="password" placeholder="Enter Password">
                               <span class="eye-icon">                                    
                                       <img id="pw-close" src="{{asset('/assets/fan/images/eye-hide.svg')}}" alt="" srcset="">
                                       <img id="pw-open" src="{{asset('/assets/fan/images/eye-open.svg')}}" alt="" srcset="">
                               </span>
                           </div>
                           @if ($errors->has('password'))
                                <span class="error_msg">{{ $errors->first('password') }}</span>
                            @endif
                     </div>
                     <div class="password-section Confirm-psd">
                           <label for="" class="font-16">Confirm Password*</label>
                           <div class="psd-eye">
                               <span class="psd-icon"> <img src="{{asset('/assets/fan/images/password.svg')}}" alt="" srcset=""> </span>
                               <input class="font-16" name="c_password" type="password" placeholder="Enter Password">
                               <span class="eye-icon">                                    
                                       <img id="pw-close" src="{{asset('/assets/fan/images/eye-hide.svg')}}" aalt="" srcset="">
                                       <img id="pw-open" src="{{asset('/assets/fan/images/eye-open.svg')}}" alt="" srcset="">
                               </span>
                           </div>
                            @if ($errors->has('c_password'))
                            <span class="error_msg">{{ $errors->first('c_password') }}</span>
                            @endif
                     </div>

                      <div class="check-box-section reg-check-box">
                          <input type="checkbox" name="accept" id="cus-box">
                          <label class="font-16" for=" cus-box ">I Accept all<span><a data-bs-toggle="modal" href="#exampleModalToggle">Terms and Conditions</a></span></label>
                      </div>
                        @if ($errors->has('accept') && !$errors->has('full_name')  && !$errors->has('phone_number') && !$errors->has('email') && !$errors->has('password') &&  !$errors->has('c_password') &&  !$errors->has('country_code'))
                          <span class="error_msg">{{ $errors->first('accept') }}</span>
                        @endif

                     <div class="login-btn">
                         <button type="submit" class="font-16">create account</button>
                     </div>
                 </form>                
                 <div class="reg-link-sec reg-mt">
                     <p class="font-16"> Already Have an Account?<a href="{{route('login')}}" class="font-16">Login Here</a></p>
                 </div>

             </div>                  
        </div>
    </div>
</div>


<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered home_popup">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="bio_header">
            <h4 class="font-18">
             {{$content->title}}
            </h4>
            <p class="font-20"> {!! $content->description !!} </p>
          </div>
        </div>
      </div>
</div>
@endsection

