@extends('artistweb.layouts.main')
@section('body')
   <div class="login-page-main">
         <div class="login-section">             
             <div class="login-form-section">
                  <div class="mbl-logo-sec">
                     <img src="../../../assets/web/images/mbl-Logo.png" alt="logo" class="src">
                  </div>
                  <div class="form-title">
                       <h1 class="font-32 wel-txt">Forgot Password</h1>
                       <h6 class="font-20 wel-sub-txt">Enter your registered email address we will send a link to your email address</h6>
                  </div>
                   @if(session()->has('status'))
                  <p class="alert alert-danger">{{session('status')}}</p>
                  @endif
                  <div class="form-input-section">
                      <form method="post" action="{{url('/web/forgotpasswordcheck')}}">
                         @csrf
                          <div class="email-section">
                              <label for="" class="font-16">Email Address*</label>
                              <div class="email-icon">
                                <span>
                                    <img src="../../../assets/web/images/Email.svg" alt="" srcset="">
                                </span>
                                <input class="font-16" type="emails" name="email" placeholder="Enter Email Address" value="">
                              </div>
                              @if ($errors->has('email'))
                              <span class="error_msg">{{ $errors->first('email') }}</span><br>
                              @endif
                          </div>

                          <div class="login-btn">
                              <button type="submit" class="font-16">Submit</button>
                          </div>
                      </form>

                      <div class="reg-link-sec fg-psd-link">
                          <p class="font-16">Back to<a href="{{url('/web/login')}}" class="font-16">Login</a></p>
                      </div>

                  </div>                  
             </div>
         </div>
   </div>
@endsection