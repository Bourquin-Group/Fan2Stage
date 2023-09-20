@extends('artistweb.layouts.main')
@section('body')
   <div class="login-page-main">
         <div class="login-section ">             
             <div class="login-form-section">
                  <a href="{{url('/web/login')}}" class="arrow-left"><img src="../../../assets/web/images/arrow-left.svg" alt="" srcset=""></a>
                  <div class="mbl-logo-sec">
                        <img src="../../../assets/web/images/mbl-Logo.png" alt="logo" class="src">
                  </div>
                  <div class="form-title">
                       <h1 class="font-32 wel-txt">Create New Password</h1>
                       <h6 class="font-20 wel-sub-txt">Your new password must be different 
                        from previous used passwords.</h6>
                  </div>
                   {{-- @if(session()->has('status'))
                    <p class="alert alert-danger">{{session('status')}}</p>
                    @endif --}}
                    @if(session()->has('message'))
                    <p class="text-danger" id="change-password">{{session('message')}}</p>
                    @endif
                  <div class="form-input-section ver-otp-inpt">
                      <form method="post" action="{{url('/web/changepasswordstore')}}">
                         @csrf
                        <div class="password-section">
                            <label for="" class="font-16">Password*</label>
                            <div class="psd-eye">
                                <span class="psd-icon"> <img src="../../../assets/web/images/password.svg" alt="" srcset=""> </span>
                                <input class="font-16" type="password" name="password" placeholder="Enter Password">
                                <span class="eye-icon">                                    
                                        <img id="pw-close" src="../../../assets/web/images/eye-hide.svg" alt="" srcset="">
                                        <img id="pw-open" src="../../../assets/web/images/eye-open.svg" alt="" srcset="">
                                </span>
                            </div>
                            @if ($errors->has('password'))
                            <span class="error_msg">{{ $errors->first('password') }}</span><br>
                            @endif
                        </div>
                        <div class="password-section Confirm-psd">
                                <label for="" class="font-16">Confirm Password*</label>
                                <div class="psd-eye">
                                    <span class="psd-icon"> <img src="../../../assets/web/images/password.svg" alt="" srcset=""> </span>
                                    <input class="font-16" type="password" name="c_password" placeholder="Enter Confirm Password">
                                    <span class="eye-icon">                                    
                                            <img id="pw-close" src="../../../assets/web/images/eye-hide.svg" alt="" srcset="">
                                            <img id="pw-open" src="../../../assets/web/images/eye-open.svg" alt="" srcset="">
                                    </span>
                                </div>
                                @if ($errors->has('c_password'))
                                <span class="error_msg">{{ $errors->first('c_password') }}</span><br>
                                @endif
                        </div>
                        <input type="hidden" value="{{$user->email}}" name="email">
                        <div class="login-btn">
                            <button type="submit" class="font-16">Submit</button>
                        </div>

                      </form>
                  </div>                  
             </div>
         </div>
   </div>
@endsection