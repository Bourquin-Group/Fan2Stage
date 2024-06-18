@extends('artistweb.layouts.main')
@section('body')

    <div class="login-page-main">
         <div class="login-section res-pad-top">
             <div class="login-form-section">
                 <div class="mbl-logo-sec">
                     <img src="../../../assets/web/images/mbl-Logo.png" alt="logo" class="src">
                 </div>
                  <div class="form-title">
                       <h1 class="font-32 wel-txt">Lets’s Get Started!</h1>
                       <h6 class="font-20 wel-sub-txt">Create an Account to Fan2Stage</h6>
                       @if (session('Error'))
                       <span class="error_msg">
                         {{ session('Error') }}
                       </span>
                 @endif

                  </div>
                  <div class="form-input-section">
                      <form method="post" action="{{url('/web/registerstore')}}" autocomplete="on">
                         @csrf

                        <div class="email-section">
                            <label for="" class="font-16">Full Name*</label>
                            <div class="email-icon">
                              <span>
                                  <img src="../../../assets/web/images/user.svg" alt="" srcset="">
                              </span>
                              <input class="font-16"type="text" placeholder="Name" value="{{old('full_name')}}" name="full_name">
                              @if ($errors->has('full_name'))
                              <span class="error_msg">{{ $errors->first('full_name') }}</span>
                              @endif
                            </div>
                        </div>
                        <div class="email-section">
                            <label for="" class="font-16">Mobile Number*</label>
                            <div class="email-icon mbl-num-sec">
                              <span>
                                  <img src="../../../assets/web/images/phone.svg" alt="" srcset="">
                              </span>
                              <input type="" id="phoneNumber1" value="{{old('phone_number')}}" name="phone_number" placeholder="Phone Number" maxlength="16" onInput="this.value = phoneFormat2(this.value)"/>
                              @if ($errors->has('country_code'))
                              <span class="error_msg">{{ $errors->first('country_code') }}</span><br>
                              @endif
                                  @if ($errors->has('phone_number'))
                              <span class="error_msg">{{ $errors->first('phone_number') }}</span>
                              @endif
                              <div class="num-drp">
                                  <p><select name="country_code" id="country_code">
                                  <option value="+01" @if (old('country_code') == "+01") {{ 'selected' }} @endif>+01</option>
                                  <option value="+07" @if (old('country_code') == "+07") {{ 'selected' }} @endif>+07</option>
                                  <option value="+61" @if (old('country_code') == "+61") {{ 'selected' }} @endif>+61</option>
                                  <option value="+91" @if (old('country_code') == "+91") {{ 'selected' }} @endif>+91</option>
                                  </select></p>

                              </div>
                                       
                            </div>

                        </div>
                          <div class="email-section">
                              <label for="" class="font-16">Email Address*</label>
                              <div class="email-icon">
                                <span>
                                    <img src="../../../assets/web/images/Email.svg" alt="" srcset="">
                                </span>
                                <input class="font-16" type="email" name="email" placeholder="Enter Email Address" value="{{old('email')}}">
                                @if ($errors->has('email'))
                                <span class="error_msg">{{ $errors->first('email') }}</span>
                                @endif
                                        @if (isset($error)&& $error)
                                <span class="error_msg">{{ $error }}</span>
                                @endif
                              </div>
                          </div>
                          <div class="password-section">
                                <label for="" class="font-16">Password*</label>
                                <div class="psd-eye pass-section">
                                    <span class="psd-icon"> <img src="../../../assets/web/images/password.svg" alt="" srcset=""> </span>
                                    <input class="font-16" type="password" name="password" placeholder="Enter Password">
                                    @if ($errors->has('password'))
                                      <span class="error_msg">{{ $errors->first('password') }}</span>
                                    @endif
                                    <span class="eye-icon">                                    
                                            <img id="pw-close" src="../../../assets/web/images/eye-hide.svg" alt="" srcset="">
                                            <img id="pw-open" src="../../../assets/web/images/eye-open.svg" alt="" srcset="">
                                    </span>
                                    
                                </div>
                               
                          </div>
                          <div class="password-section Confirm-psd">
                                <label for="" class="font-16">Confirm Password*</label>
                                <div class="psd-eye pass-section">
                                    <span class="psd-icon"> <img src="../../../assets/web/images/password.svg" alt="" srcset=""> </span>
                                    <input class="font-16" name="c_password" type="password" placeholder="Enter Password">
                                    @if ($errors->has('c_password'))
                                    <span class="error_msg">{{ $errors->first('c_password') }}</span>
                                    @endif
                                    <span class="eye-icon">                                    
                                            <img id="pw-close" src="../../../assets/web/images/eye-hide.svg" alt="" srcset="">
                                            <img id="pw-open" src="../../../assets/web/images/eye-open.svg" alt="" srcset="">
                                    </span>
                                    
                                </div>
                                
                          </div>

                           <div class="check-box-section">
                               <input type="checkbox" name="accept" id="cus-box">
                               <label class="font-16" for="cus-box ">I Accept the all<span><a data-bs-toggle="modal" href="#exampleModalToggle">Terms and Conditions</a></span></label>

                           </div>
                         @if ($errors->has('accept') && !$errors->has('full_name')  && !$errors->has('phone_number') && !$errors->has('email') && !$errors->has('password') &&  !$errors->has('c_password') &&  !$errors->has('country_code'))
                          <span class="error_msg">{{ $errors->first('accept') }}</span>
                          @endif
                          <div class="login-btn">
                              <button type="submit" class="font-16">create account</button>
                          </div>
                      </form>                
                      <div class="reg-link-sec reg-mt">
                          <p class="font-16"> Already Have an Account?<a href="{{url('/web/login')}}">Login Here</a></p>
                      </div>

                  </div>                  
             </div>
         </div>
   </div>




       <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered home_popup">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         <!--  <div class="profile_card popup_home">

            <div class="profile_section_inner">
              <div class="profile_img_section">
                <img
                  class="profile_img"
                  src="./assets/images/homepage-cart-user.png"
                  alt="profile"
                />
               <div class="">
                <a href="./My-profile.html"><h2>Justin biber</h2></a>
                <p>Late Night Union</p>
               </div>
              </div>

              <div class="profilr_part_section">
                <h6 class="sub_header">Genre:</h6>
                <p>Dance pop, Trance, Vocal</p>
              </div>
              <div class="profilr_part_section">
                <h6 class="sub_header">Social Links :</h6>
  
                <div class="social_icon">
                  <span class="face_book"></span>
                  <span class="instagram"></span>
                  <span class="itnes"></span>
                  <span class="youtube"></span>
                  <span class="world"> </span>
                </div>
              </div>
  
              <div class="profilr_part_section">
               <a href="My-profile.html"><button class="gray_btn">Upgrade plan</button></a> 
              </div>
            </div>

          </div> -->
          <div class="bio_header">
            <h4 class="font-18">
             <?php echo $content->title;?>
            </h4>
            <p class="font-20"> <?php echo $content->description;?> </p>
          </div>
        </div>
      </div>
    </div>

@endsection