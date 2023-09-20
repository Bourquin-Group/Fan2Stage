<div class="tab-pane fade {{ (request()->is('web/editprofile')) ? 'show active' : '' }}" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
    <div class="tab-heading arrow-align">
    <h1 class="font-28">Edit Profile</h1>
    <form method="post" action="{{ url('/web/artistupdate') }}" enctype="multipart/form-data">
        @csrf
        @method("POST")
    <div class="edit-btn1 edit-btn-none1">
        <button type="button" class="font-16 page_moving"><a href ="{{ url('web/profile') }}">Cancel</a></button>
        <button type="submit" class="font-16 save-btn page_moving">Save</button>              
    </div>                     
    </div>
    <div class="profile-main">
        <div class="profile-inform">
            <div class="profile-banner_section">
                <div class="profile-banner">
                    <div class="avatar-edit">
                        
                        <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" name="landing_page_image1" class="drop-zone__prompt_1" />
                        <input type="hidden" name="landing_page_image" id="base64image">
                        <label for="imageUpload">
                            <span class="pencil_icon"><img src="{{ asset('assets/web/images/pencil_icon.svg') }}" alt=""></span> 
                        </label>
                    </div>
                    <div class="avatar-preview container2">
                        @php
                            if(!empty($image->image) && $image->image!='' && file_exists(public_path('images/'.$image->image))){
                              $image =$image->image;
                            }else{
                              $image = 'default.png';
                            }
                            $url = url('public/images/'.$image);
                            $imgs =  "background-image:url($url)";
                              
                        @endphp
                        {{-- <div class="profile-banner">
                            <div class="drop-zone drop-none">
                                @if(isset($a_profile['landing_page_image']) && $a_profile['landing_page_image'] != '')
                            <img class="drop-zone__prompt" src="{{(isset($a_profile['landing_page_image'])) ? $a_profile['landing_page_image']: ''}}" alt="">
                            @endif  
                            <input type="file" name="landing_page_image" class="drop-zone__input" id="imageUpload" accept=".png, .jpg, .jpeg">
                            <span class="pencil_icon"><img src="{{ asset('assets/web/images/pencil_icon.svg') }}" alt=""></span>
                        </div>
                        </div> --}}
                        @if(isset($a_profile['landing_page_image']) && $a_profile['landing_page_image'] != '')
                        <div id="imagePreview" style="background-image:url({{($a_profile['landing_page_image'])}});">
                        </div>
                        @endif
                        <div id="imagePreview" style="{{$imgs}};">
                        </div>
                    </div>
                </div>
                {{-- modal --}}
                <div class="modal fade bd-example-modal-lg imagecrop" id="model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                            <button type="button" class="close crop_banner_close" data-bs-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="img-container">
                                <div class="row">
                                    <div class="col-md-11">
                                        <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                                    </div>
                                </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary crop" id="crop">Crop</button>
                          </div>
                      </div>
                    </div>
                  </div>		
                {{-- modal --}}
                <div class="profile_img_main">
                    <div class="drop-zone">
                        @if(isset($a_profile['profile_image']) && $a_profile['profile_image'] != '')
                    <img class="drop-zone__prompt" src="{{(isset($a_profile['profile_image'])) ? $a_profile['profile_image']: ''}}" alt="">  
                    @endif
                    <input type="file" name="profile_image" class="drop-zone__input">
                    <span class="pencil_icon"><img src="{{ asset('assets/web/images/pencil_icon.svg') }}" alt=""></span>
                </div>
            </div>
            @if ($errors->has('profile_image'))
            <span class="error_msg">{{ $errors->first('profile_image') }}</span><br>
            @endif
            @if ($errors->has('landing_page_image'))
            <span class="error_msg">{{ $errors->first('landing_page_image') }}</span><br>
            @endif
            </div>
            <h5 class="font-22">Basic Details</h5>
            {{-- @if(isset($a_profile) && $a_profile) --}}
            
            <div class="first-column">
                <div class="form-section">
                <label for="">Name*</label>
                <input class="edit-input1" type="text" name="full_name" id="" placeholder="name" value="{{ ($a_profile)? (old('full_name')? old('full_name') : $a_profile['name']) : old('full_name') }}">
                @if ($errors->has('full_name'))
                <span class="error_msg">{{ $errors->first('full_name') }}</span><br>
                @endif
                </div>
                
                <div class="form-section">
                <label for="">Email Address*</label>
                <input class="edit-input1" type="emails" name="email" id="" placeholder="Email Address" value="{{ ($a_profile)? (old('email')? old('email') : $a_profile['email']) : old('email') }}">
                @if ($errors->has('email'))
                <span class="error_msg">{{ $errors->first('email') }}</span><br>
                @endif
                </div>
                
                <div class="form-section">
                <label for="">Mobile Number*</label>
                <div class="email-icon mbl-num-sec edit-mbl1">
                    <input type="" id="phoneNumber" name="mobile_number" placeholder="Phone Number" maxlength="16"style="padding-left: 100px !important;" value="{{ ($a_profile)? (old('mobile_number')? old('mobile_number') : $a_profile['phone']) : old('mobile_number') }}" onInput="this.value = phoneFormat(this.value)">
                    <div class="num-drps">
                        {{-- <p>+1</p> --}}
                        <select class="num-drpOne">
                            <option>+1</option>
                            <option>+2</option>
                        </select>
                    </div>
                </div>
                @if ($errors->has('mobile_number'))
                <span class="error_msg">{{ $errors->first('mobile_number') }}</span><br>
                @endif
                </div>
            </div>
            <div class="first-column">
                <div class="form-section">
                <label for="">Stage Name*</label>
                <input class="edit-input1" type="text" name="stagename" id="" placeholder="Stage Name" value="{{ ($a_profile)? (old('stagename')? old('stagename') : $a_profile['stage_name']) : old('stagename') }}">
                @if ($errors->has('stagename'))
                <span class="error_msg">{{ $errors->first('stagename') }}</span><br>
                @endif
                </div>
               
                <div class="form-section">
                <label for="">Genre*</label>
                <div class="genere_sec">
                <select class="selectpicker" name="genre[]" placeholder="Select genre" multiple>
                    <?php 
                        $genre = explode(',',$a_profile['genre']);?>
                     @forEach($genres as $value)
                     <option value="{{$value->genre1}}" {{(in_array($value->genre1, $genre)) ? 'selected' : ''}}>{{$value->genre1}}</option>
                     @endforeach
                  </select>
                </div>
                @if ($errors->has('genre'))
                <span class="error_msg">{{ $errors->first('genre') }}</span><br>
                @endif
                </div>
                <div class="form-section">
                <label for="">Time Zone*</label>
                <select name="timezone" placeholder="Select timezone">
                    <option value="">Select Time Zone</option>
                    @if($a_profile['timezone'] == '-' || $a_profile['timezone'] == null)
                    @forEach($timezone as $value)                    
                        <option value="{{$value->id}}" @if ($a_profile['timezone'] == $value->timezone) {{ 'selected' }} @endif >{{$value->timezone}}</option>
                    @endforeach
                    @else
                    @forEach($timezone as $value)                    
                        <option value="{{$value->id}}" @if ($a_profile['timezone']['timezone'] == $value->timezone) {{ 'selected' }} @endif >{{$value->timezone}}</option>
                    @endforeach
                    @endif
                  </select>
                @if ($errors->has('timezone'))
                <span class="error_msg">{{ $errors->first('timezone') }}</span><br>
                @endif
                </div>
                <div class="form-section">
                <div class="check-box-section">
                    <input type="checkbox" name="dsname" id="cus-box" {{(($a_profile['d_stagename'] != '') && ($a_profile['d_stagename'] != NULL)) ? 'checked': ''}}>
                    <label class="font-16" for="cus-box">Display Stage Name on Top</label>
                </div>
                </div>
            </div>
            <div class="form-section">
                <label for="">Bio*</label>
                <textarea class="edit-input1" name="bio">{{ ($a_profile)? (old('bio')? old('bio') : $a_profile['bio']) : old('bio') }}</textarea>
                @if ($errors->has('bio'))
                <span class="error_msg">{{ $errors->first('bio') }}</span><br>
                @endif
            </div>
            <h5 class="font-22">Social Links</h5>

            <div class="first-column">
                <div class="form-section">
                    <label for="">Facebook</label>
                    <div class="cpy-sec">
                    <div class="copy-input1">
                        <input type="text" name="facebook_link" id="" value="{{(isset($a_profile['facebook_link'])) ? $a_profile['facebook_link']: ''}}">
                        <img src="{{ asset('assets/web/images/copy_icon.svg') }}" alt="" srcset="">
                    </div>
                        @if ($errors->has('facebook_link'))
                        <span class="error_msg">{{ $errors->first('facebook_link') }}</span><br>
                        @endif
                    </div>
                </div>
                <div class="form-section">
                    <label for="">Instragram</label>
                    <div class="cpy-sec">
                    <div class="copy-input1">
                        <input type="text" name="instagram_link" id="" value="{{(isset($a_profile['instagram_link'])) ? $a_profile['instagram_link']: ''}}">
                        <img src="{{ asset('assets/web/images/copy_icon.svg') }}" alt="" srcset="">
                    </div>
                    @if ($errors->has('instagram_link'))
                    <span class="error_msg">{{ $errors->first('instagram_link') }}</span><br>
                    @endif
                    </div>
                </div>
                <div class="form-section">
                    <label for="">iTunes</label>
                    <div class="cpy-sec">
                    <div class="copy-input1">
                        <input type="text" name="itunes_link" id="" value="{{(isset($a_profile['itunes_link'])) ? $a_profile['itunes_link']: ''}}">
                        <img src="{{ asset('assets/web/images/copy_icon.svg') }}" alt="" srcset="">
                    </div>
                    @if ($errors->has('itunes_link'))
                    <span class="error_msg">{{ $errors->first('itunes_link') }}</span><br>
                    @endif
                    </div>
                </div>
                <div class="form-section">
                    <label for="">Youtube</label>
                    <div class="cpy-sec">
                    <div class="copy-input1">
                        <input type="text" name="youtube_link" id="" value="{{(isset($a_profile['youtube_link'])) ? $a_profile['youtube_link'] : ''}}">
                        <img src="{{ asset('assets/web/images/copy_icon.svg') }}" alt="" srcset="">
                    </div>
                    @if ($errors->has('youtube_link'))
                    <span class="error_msg">{{ $errors->first('youtube_link') }}</span><br>
                    @endif
                    </div>
                </div>
                <div class="form-section">
                    <label for="">Website</label>
                    <div class="cpy-sec">
                        <div class="copy-input1">
                        <input type="text" name="website_link" id="" value="{{(isset($a_profile['website_link'])) ? $a_profile['website_link']: ''}}">
                        <img src="{{ asset('assets/web/images/copy_icon.svg') }}" alt="" srcset="">
                        </div>
                        @if ($errors->has('website_link'))
                        <span class="error_msg">{{ $errors->first('website_link') }}</span><br>
                        @endif
                    </div>
                </div>
            </div>
            </form>
            {{-- @endif --}}
        </div>
    </div>
    <div class="profile-main">
    <div class="profile-inform">
        <h5 class="font-22">Change password</h5>
    </div>
    <div class="form-input-section com-psd-inpt">
        {{-- <form method="post" action="{{ url('/web/changepassword') }}"> --}}
            {{-- @csrf --}}
            {{-- @method("POST") --}}
            <div class="first-column">
            <div class="password-section">
            <label for="" class="font-16">Current Password*</label>
            <div class="psd-eye">
                <span class="psd-icon"> <img src="{{ asset('assets/web/images/password.svg') }}" alt="" srcset=""> </span>
                <input class="font-16" type="password" name="current_password" placeholder="Enter Current Password" >
                <span class="eye-icon">                                    
                        <img id="pw-close" src="{{ asset('assets/web/images/eye-hide.svg') }}" alt="" srcset="">
                        <img id="pw-open" src="{{ asset('assets/web/images/eye-open.svg') }}" alt="" srcset="">
                </span>
            </div>
            <span class="error_msg" id="current_password"></span>
            {{-- @if ($errors->has('current_password'))
                <span class="error_msg">{{ $errors->first('current_password') }}</span><br>
            @endif
            @if(session()->has('current_password'))
            <span class="error_msg">{{session()->get('current_password') }}</span><br>
            @endif --}}
            </div>
            <div class="password-section">
            <label for="" class="font-16">New Password*</label>
            <div class="psd-eye">
                <span class="psd-icon"> <img src="{{ asset('assets/web/images/password.svg') }}" alt="" srcset=""> </span>
                <input class="font-16" type="password" name="new_password" placeholder="Enter New Password" >
                <span class="eye-icon">                                    
                        <img id="pw-close" src="{{ asset('assets/web/images/eye-hide.svg') }}" alt="" srcset="">
                        <img id="pw-open" src="{{ asset('assets/web/images/eye-open.svg') }}" alt="" srcset="">
                </span>
            </div>
            <span class="error_msg" id="new_password"></span>
            {{-- @if ($errors->has('new_password'))
                <span class="error_msg">{{ $errors->first('new_password') }}</span><br>
            @endif
            @if(session()->has('new_password'))
            <span class="error_msg">{{session()->get('new_password') }}</span><br>
            @endif --}}
            </div>
            <div class="password-section">
            <label for="" class="font-16">Confirm New Password*</label>
            <div class="psd-eye">
                <span class="psd-icon"> <img src="{{ asset('assets/web/images/password.svg') }}" alt="" srcset=""> </span>
                <input class="font-16" type="password" name="c_password" placeholder="Enter Confirm New Password">
                <span class="eye-icon">                                    
                        <img id="pw-close" src="{{ asset('assets/web/images/eye-hide.svg') }}" alt="" srcset="">
                        <img id="pw-open" src="{{ asset('assets/web/images/eye-open.svg') }}" alt="" srcset="">
                </span>
            </div>
            <span class="error_msg" id="c_password"></span>
            {{-- @if ($errors->has('c_password'))
                <span class="error_msg">{{ $errors->first('c_password') }}</span><br>
            @endif --}}
            </div>                            
        </div>
        <div class="login-btn">
            <button type="submit" class="font-16" id="changepasswordweb">Update Password</button>
        </div>
        {{-- </form> --}}
    </div>
    </div>
</div>



