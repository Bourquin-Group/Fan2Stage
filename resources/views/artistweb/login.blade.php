@extends('artistweb.layouts.main')
@section('body')
    <div class="login-page-main">
         <div class="login-section">
             <div class="login-form-section">
                 <div class="mbl-logo-sec">
                     <img src="{{ asset('assets/web/images/mbl-Logo.png') }}" alt="logo" class="src">
                 </div>
                  <div class="form-title">
                       <h1 class="font-32 wel-txt">Welcome Back</h1>
                       <h6 class="font-20 wel-sub-txt">Login to continue using your account</h6>
                       @if (Session::has('message'))
                      <div class="alert alert-info">{{ Session::get('message') }}</div>
                      @endif

                       @if (Session::has('error'))
                      <div class="text-danger">{{ Session::get('error') }}</div>
                      @endif
                      @if(session()->has('success'))
                      <p class="text-success">{{session('success')}}</p>
                        @endif
                  </div>
                  <div class="form-input-section">
                      <form method="post" action="{{url('/web/loginstore')}}" autocomplete="on" id="signupForm">
                         @csrf
                          <div class="email-section">
                              <label for="" class="font-16">Email Address*</label>
                              <div class="email-icon">
                                <span>
                                    <img src="{{ asset('assets/web/images/Email.svg') }}" alt="" srcset="">
                                </span>
                                <input class="font-16" type="email" name="email" placeholder="Enter Address" value="{{old('email')}}">
                              </div>
                              @if ($errors->has('email'))
                              <span class="error_msg">{{ $errors->first('email') }}</span>
                              @endif
                          </div>
                          <div class="password-section">
                                <label for="" class="font-16">Password*</label>
                                <div class="psd-eye">
                                    <span class="psd-icon"> <img src="{{ asset('assets/web/images/password.svg') }}" alt="" srcset=""> </span>
                                    <input class="font-16" type="password" name="password" placeholder="Enter Password">
                                    <span class="eye-icon">                                    
                                            <img id="pw-close" src="{{ asset('assets/web/images/eye-hide.svg') }}" alt="" srcset="">
                                            <img id="pw-open" src="{{asset('assets/web/images/eye-open.svg') }}" alt="" srcset="">
                                    </span>
                                </div>
                                @if ($errors->has('password'))
                                <span class="error_msg">{{ $errors->first('password') }}</span>
                                @endif
                                <a href="{{url('/web/forgotpassword')}}" class="font-16">Forgot Password?</a>
                          </div>
                          <div class="login-btn">
                              <button type="submit" class="font-16">Login Now</button>
                          </div>
                      </form>

                      <div class="reg-link-sec mt-3">
                          <p class="font-16">Don’t Have an Account?<a href="{{url('/web/register')}}" class="font-16">Register Here</a></p>
                      </div>

                  </div>                  
             </div>
         </div>
    </div>
@endsection
@section('login-validation')
{{-- validation --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/css/screen.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
{{-- validation --}}
<script>
//     $(document).ready(function(){
//         $("#signupForm").validate({
//     rules: {
//         email: {
//             required: true,
//             email: true
//         },
//         password: "required",
//     },
//     messages: {
//         email: {
//             required: "Please enter your email",
//             email: "Please enter a valid email address"
//         },
//         password: "Please enter your password",
//     }
// });
//     });
    
</script>
@endsection