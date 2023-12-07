@extends('fanweb.layouts.main')
@section('header')
<style>
.error_msg {
    color: red !important;
}
.edit-btn-1 {
    display: flex;
    align-items: baseline;
}

.edit-btn-none-1 {
    display: none;
}

.edit-input-1{
  display: none;
}

.edit-input-section .edit-input-1{
  display: block;
}
.edit-input-section .edit-text-1 {
  display: none;
}
.edit-input-section .edit-btn-1 {
        display:none;
      }

      .edit-btn-1 button {
    font-style: normal;
    font-weight: 700;
    line-height: 20px;
    text-align: center;
    text-transform: uppercase;
    color: #FFFFFF;
    background: #081A34;
    border: 1px solid #A6C2E9 !important;
    box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.05);
    border-radius: 50px;
    width: 155px;
    height: 40px;
    display: block;
}

      .edit-input-section .edit-btn-none-1 {
        display: flex;
      }

      .edit-input-section span.edit-text {
        display: none;
      }

      .edit-input-section .edit-input {
        display: block;
      }
    
</style>
@endsection
@section('content')
<section class="main_section">
        <div class="custom_container">
            <div class="row d-flex align-items-start res-flex-wrap">
                <div class="col-lg-3 col-md-12 col-sm-12 tab-navbar">
                   <h1 class="font-28">Quick Links</h1>
                    @include('fanweb.profile.side-menu')               
                </div>
                <div class="tab-content col-lg-9 col-md-12 col-sm-12 col-xs-12 profiletab-wrapper " id="v-pills-tabContent ">
                  <!-- Myprofile -->
                  <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                    <div class="tab-heading arrow-align">
                      <h1 class="font-28">Profile</h1>                    
                    </div>
                    <div class="profile-main profile-icon-flex">
                    @if(session()->has('success1'))
                        <p class="alert alert-success">{{session('success1')}}</p>
                    @endif
                    @if (Session::has('error'))
                      <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                      {{-- <form method="post" action="{{route('profileStore')}}"  enctype="multipart/form-data"> --}}
                        {{-- @csrf --}}
                        <form method="post" id="update_form" enctype="multipart/form-data">
                          {{ csrf_field() }}
                          <div class="profilr-avater">
                              <div class="avatar-detalis"> 
                                  <img class="imgs" src="{{auth()->user()->profile()}}" alt="" srcset="">
                                  {{-- <img class="imgs" src="" alt="" srcset=""> --}}
                                  <div class="avater-text">
                                      <h6 class="font-18">{{$profile['name']}}</h6>
                                      <p class="font-14">{{$profile['email']}}</p>
                                  </div>
                              </div>
                              <div class="avater-btn">
                              <input type="file" name="image" class="font-16 edit-input" value="Change Avatar" id="profile_fan">
                              <label for="profile_fan">
                                  <button type="button" class="font-16 edit-input profile_fan "> Change Avatar</button>
                                </label>
                              </div>
                          </div>
                          {{-- @if ($errors->has('image')) --}}
                                          <span class="error_msg" id="image"></span><br>
                                          {{-- @endif    --}}
                          <div class="profile-inform">
                            <div class="d-flex">
                              <h5 class="font-22">Basic Details</h5>
                              <div class ="edit-input" style="color:red;margin-left:12px;">(Please update mandatory fields and profile picture to proceed further)</div>
                          </div>
                              <div class="first-column">
                                    <div class="form-section">
                                        <div class="svg-sec"> 
                                          <img src="{{asset('/assets/fan/images/user.svg')}}" alt="" srcset="">
                                        </div> 
                                        <div class="label-sec">
                                          <label for="">Name*</label>
                                          <span class="edit-text">{{$profile['name']}}</span>
                                          <input class="edit-input" type="text" name="name" placeholder="Name" 
                                          value="{{old('name')?old('name'):$profile['name']}}"> 
                                          {{-- @if ($errors->has('name')) --}}
                                          <span class="error_msg" id="name"></span><br>
                                          {{-- @endif                            --}}
                                        </div>
                                    </div>
                                    <div class="form-section">
                                        <div class="svg-sec"> 
                                          <img src="{{asset('/assets/fan/images/Email.svg')}}" alt="" srcset="">
                                        </div>
                                        <div class="label-sec">
                                        <label for="">Email Address*</label>
                                        <span class="edit-text">{{$profile['email']}}</span>
                                        <div class="edit-input">
                                          <input type="email" name="email" placeholder="Email Address" value="{{old('email')?old('email'):$profile['email']}}">
                                          {{-- @if ($errors->has('email')) --}}
                                          <span class="error_msg" id="email"></span><br>
                                          {{-- @endif    --}}
                                        </div>
                                          
                                        </div>
                                    </div>
                                    <div class="form-section">
                                        <div class="svg-sec">
                                          <img src="{{asset('/assets/fan/images/phone.svg')}}" alt="" srcset="">
                                        </div>
                                        <div class="label-sec">
                                          <label for="">Mobile Number*</label>
                                          <span class="edit-text">{{$profile['phone_number']}}</span>
                                          <div class="email-icon mbl-num-sec edit-mbl">
                                            <input type="" id="phoneNumber1" value="{{old('phone_number')?old('phone_number'):$profile['phone_number']}}" name="phone_number" placeholder="Phone Number" maxlength="16" onInput="this.value = phoneFormat(this.value)"/>
                                            <div class="num-drp">
                                                <p>+1</p>
                                            </div>
                                          </div>
                                          {{-- @if ($errors->has('phone_number')) --}}
                                          <span class="error_msg" id="phone_number"></span><br>
                                          {{-- @endif --}}
                                        </div>
                                    </div>
                                    <div class="form-section">
                                        <div class="svg-sec">
                                          <img src="{{asset('/assets/fan/images/birthday_icon.svg')}}" alt="" srcset="">
                                        </div>
                                        <div class="label-sec">
                                          <label for="">Date of Birth*</label>
                                          <?php 
                                          
                                          $dob ="";
                                          if($profile['dob'])
                                          {
                                            $dob = date_format(date_create($profile['dob']), 'Y-m-d');
                                          }
                                          ?>
                                          <span class="edit-text font-16">{{$dob}} </span>
                                          <input type="date" placeholder="Select Date" id="dob" class="edit-select" name="dob" value="{{ date_format(date_create($profile['dob']), 'Y-m-d') }}">
                                          {{-- @if ($errors->has('dob')) --}}
                                          <span class="error_msg" id="dob"></span><br>
                                          {{-- @endif --}}
                                        </div>
                                      
                                    </div>

                                      <div class="form-section">
                                        <div class="svg-sec">
                                          <img src="{{asset('/assets/fan/images/prefer.svg')}}" alt="" srcset="">
                                        </div>
                                        <div class="label-sec">
                                          <label for="">Preferred genre*</label>
                                          <span class="edit-text">{{(isset($profile['preferred_genre'])) ? implode(',',$profile['preferred_genre']): '-'}}</span>
                                          <div class="genere_sec edit-select">
                                            <select class="selectpicker" name="preferred_genre[]" id="genre" multiple>
                                              <?php 
                                           $genre =[];
                                            $genre = ($profile['preferred_genre']) ? $profile['preferred_genre']: [] ;?>
                                                   @forEach($genres as $value)
                                                   <option value="{{$value->genre1}}" {{(in_array($value->genre1, $genre)) ? 'selected' : ''}}>{{$value->genre1}}</option>
                                                   @endforeach
                                            </select>
                                          </div>
                                          <span class="error_msg" id="preferred_genre1"></span><br>
                                        </div>
                                    </div>
                                      <div class="form-section">
                                        <div class="svg-sec">
                                          <img src="{{asset('/assets/fan/images/prefer.svg')}}" alt="" srcset="">
                                        </div>
                                        <div class="label-sec">
                                          <label for="">Time Zone*</label>
                                          <span class="edit-text">
                                            @if($profile['timezone'] == 1)
                                                {{ "PST" }}
                                            @elseif($profile['timezone'] == 2)
                                                {{ "IST" }}
                                            @elseif($profile['timezone'] == 3)
                                                {{ "EST" }}
                                            @elseif($profile['timezone'] == 4)
                                                {{ "MDT" }}
                                            @elseif($profile['timezone'] == 5)
                                                {{ "GMT" }}
                                            @else
                                                {{ "PDT" }}
                                            @endif
                                        </span>
                                        
                                          <div class="genere_sec edit-select">
                                            <select class="selectpicker" name="timezone" id="timezone">
                                              <option value="">Select Time Zone</option>
                                              @forEach($timezone as $value)
                                                  <option value="{{$value->id}}" @if ($profile['timezone'] == $value->id) {{ 'selected' }} @endif >{{$value->timezone}}</option>
                                                  @endforeach
                                            </select>
                                          </div>
                                          <span class="error_msg" id="timezone1"></span><br>
                                        </div>
                                    </div>
                                    <div class="form-section">
                                      <span class="edit-text">
                                        <input type="checkbox" name="dsname"{{(($profile['newsletter'] == 1) && ($profile['newsletter'] != NULL)) ? 'checked': ''}} id="cus-box1" disabled/>
      
                                        <label class="font-16" for="cus-box1">Subscribed to Newsletter</label>
                                      </span>
                                      <div class="genere_sec edit-select">
                                      <input type="checkbox" name="newsletter" id="cus-box" {{(($profile['newsletter'] == 1) && ($profile['newsletter'] != NULL)) ? 'checked': ''}}>
                                      <label class="font-16" for="cus-box">Subscribed to Newsletter</label>
                                      </div>
                                      </div>
                                    
                                  </div>
                              </div>
                              <div class="tab-heading arrow-align">
                                <div class="edit-btn">
                                  <button type="button" class="font-16 page_moving">Edit profile</button>
                                </div> 
                                <div class="edit-btn edit-btn-none">
                                  <button type="button" class="font-16 page_moving page-move-cancel">Cancel</button>
                                  <button class="font-16 save-btn" id="profiless" >Save</button>              
                                </div>                     
                              </div>
                          </div>
                      </form>    
                    </div>
                    <div class="profile-main profile-icon-flex">
                      @if(session()->has('billsuccess'))
                      <p class="text-success" id="success-alert" style="margin-left:30%">{{session('billsuccess')}}</p>
                      @endif
                      @if (Session::has('billerror'))
                        <div class="text-danger" id="billingsuccess" style="margin-left:30%">{{ Session::get('billerror') }}</div>
                      @endif
                      <form method="post" action="{{url('fan/billinginformation')}}"  enctype="multipart/form-data">
                        @csrf
                      <div class="profile-inform billing-form">
                        <h5 class="font-22">Billing Information</h5>
                        <div class="first-column">
                          <div class="form-section">
                            <div class="label-sec">
                              <label for="">Address*</label>
                              <span class="edit-text-1">{{(isset($getbillinfo['address'])) ? $getbillinfo['address']: ''}}</span>
                              <input
                                class="edit-input-1"
                                type="text"
                                name="address"
                                id=""
                                placeholder="Enter Address"
                                value="{{old('address')?old('address'):((isset($getbillinfo['address'])) ? $getbillinfo['address']: '')}}"
                              />
                              @if ($errors->has('address'))
                                <span class="error_msg">{{ $errors->first('address') }}</span><br>
                               @endif
                            </div>
                          </div>
                        </div>
                        <div class="first-column">
                          <div class="form-section">
                            <div class="label-sec">
                              <label for="">city*</label>
                              <span class="edit-text-1">{{(isset($getbillinfo['city'])) ? $getbillinfo['city']: ''}}</span>
                              <input
                                class="edit-input-1"
                                type="text"
                                name="city"
                                id=""
                                placeholder="Enter City"
                                value="{{old('city')?old('city'):((isset($getbillinfo['city'])) ? $getbillinfo['city']: '')}}"
                              />
                              @if ($errors->has('city'))
                                <span class="error_msg">{{ $errors->first('city') }}</span><br>
                               @endif
                            </div>
                          </div>
                          <div class="form-section">
                            <div class="label-sec">
                              <label for="">State*</label>
                              <span class="edit-text-1">{{(isset($getbillinfo['state'])) ? $getbillinfo['state']: ''}}</span>
                              <input
                                class="edit-input-1"
                                type="text"
                                name="state"
                                id=""
                                placeholder="Enter state"
                                value="{{old('state')?old('state'):((isset($getbillinfo['state'])) ? $getbillinfo['state']: '')}}"
                              />
                              @if ($errors->has('state'))
                                <span class="error_msg">{{ $errors->first('state') }}</span><br>
                               @endif
                            </div>
                          </div>
                        </div>
                        <div class="first-column">
                          <div class="form-section">
                            <div class="label-sec">
                              <label for="">Country*</label>
                              <span class="edit-text-1">{{(isset($getbillinfo['country'])) ? $getbillinfo['country']: ''}}</span>
                              <input
                                class="edit-input-1"
                                type="text"
                                name="country"
                                id=""
                                placeholder="Enter Country"
                                value="{{old('country')?old('country'):((isset($getbillinfo['country'])) ? $getbillinfo['country']: '')}}"
                              />
                              @if ($errors->has('country'))
                                <span class="error_msg">{{ $errors->first('country') }}</span><br>
                               @endif
                            </div>
                          </div>
                          <div class="form-section">
                            <div class="label-sec">
                              <label for="">Postal Code*</label>
                              <span class="edit-text-1">{{(isset($getbillinfo['postalcode'])) ? $getbillinfo['postalcode']: ''}}</span>
                              <input
                                class="edit-input-1"
                                type="text"
                                name="postalcode"
                                id=""
                                maxlength="6"
                                placeholder="Postal Code"
                                value="{{old('postalcode')?old('postalcode'):((isset($getbillinfo['postalcode'])) ? $getbillinfo['postalcode']: '')}}"
                              />
                              @if ($errors->has('postalcode'))
                                <span class="error_msg">{{ $errors->first('postalcode') }}</span><br>
                               @endif
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="arrow-align billing-align">
                        <div class="edit-btn-1">
                          <button type="button" class="font-16 page_moving" id="add-class">
                            Edit Info
                          </button>
                        </div>
                        <div class="edit-btn edit-btn-none-1">
                          <button
                            type="button"
                            class="font-16  remove-class"
                          >
                            Cancel
                          </button>
                          <button type="submit" class="font-16 save-btn">
                            Submit
                          </button>
                        </div>
                      </div>
                      </form>
                    </div>
                    <div class="profile-main">
                      <div class="profile-inform" style="display: flex;align-items:baseline;">
                        <h5 class="font-22">Change password</h5>
                        @if(session()->has('success'))
                          <span class="text-success" style="margin-top: -49px;">{{session('success')}}</span>
                        @endif
                      </div>
                      <div class="form-input-section com-psd-inpt">
                          {{-- <form method="post" action="{{url('fan/change-password')}}"  enctype="multipart/form-data" id="password-change">
                            @csrf --}}
                            <div class="first-column">
                            <div class="password-section">
                              <label for="" class="font-16">Old Password</label>
                              <div class="psd-eye">
                                  <span class="psd-icon"> <img src="{{asset('/assets/fan/images/password.svg')}}" alt="" srcset=""> </span>
                                  <input class="font-16" type="password" placeholder="Enter Current Password" name="current_password"  value="">
                                  <span class="eye-icon">                                    
                                          <img id="pw-close" src="{{asset('/assets/fan/images/eye-hide.svg')}}" alt="" srcset="">
                                          <img id="pw-open" src="{{asset('/assets/fan/images/eye-open.svg')}}" alt="" srcset="">
                                  </span>
                                  {{-- @if ($errors->has('current_password'))
                                  <span class="error_msg">{{ $errors->first('current_password') }}</span><br>
                                  @endif     --}}
                                </div>
                                <span class="error_msg" id="current_password"></span>
                            </div>
                            <div class="password-section">
                              <label for="" class="font-16">New Password</label>
                              <div class="psd-eye">
                                  <span class="psd-icon"> <img src="{{asset('/assets/fan/images/password.svg')}}" alt="" srcset=""> </span>
                                  <input class="font-16" type="password" placeholder="Enter New Password" name="new_password" value="">
                                  <span class="eye-icon">                                    
                                          <img id="pw-close" src="{{asset('/assets/fan/images/eye-hide.svg')}}" alt="" srcset="">
                                          <img id="pw-open" src="{{asset('/assets/fan/images/eye-open.svg')}}" alt="" srcset="">
                                  </span>
                              </div>
                              <span class="error_msg" id="new_password"></span>
                              {{-- @if ($errors->has('new_password'))
                                          <span class="error_msg">{{ $errors->first('new_password') }}</span><br>
                              @endif    --}}
                            </div>
                            <div class="password-section">
                              <label for="" class="font-16">Confirm New Password</label>
                              <div class="psd-eye">
                                  <span class="psd-icon"> <img src="{{asset('/assets/fan/images/password.svg')}}" alt="" srcset=""> </span>
                                  <input class="font-16" type="password" placeholder="Enter Confirm New Password" name="c_password" value="" >
                                  <span class="eye-icon">                                    
                                          <img id="pw-close" src="{{asset('/assets/fan/images/eye-hide.svg')}}" alt="" srcset="">
                                          <img id="pw-open" src="{{asset('/assets/fan/images/eye-open.svg')}}" alt="" srcset="">
                                  </span>
                              </div>
                              <span class="error_msg" id="c_password"></span>
                              {{-- @if ($errors->has('c_password'))
                                          <span class="error_msg">{{ $errors->first('c_password') }}</span><br>
                              @endif  --}}
                            </div>                            
                           </div>
                           <div class="login-btn">
                            <button type="submit" class="font-16" id="changepasswordfan" >Update Password</button>
                          </div>
                          {{-- </form> --}}
                      </div>
                    </div>
                  </div>
                  <!-- END -->
               
                </div>
            </div>  
        </div> 
      
</section>
@endsection
@section('script')

@endsection
@section('footer')
<script>
  
  $(document).ready(function(){
    toastr.options = {
          "closeButton": true,
          "newestOnTop": true,
          "positionClass": "toast-top-right"
        };
      if(localStorage.getItem("changepasswordfan"))
    {
      toastr.success("Password Changed Successfully");
        localStorage.clear();
    }


$(document).on("click", "#changepasswordfan", function (e) {
   var current_password = $("input[name=current_password]").val();
   var new_password = $("input[name=new_password]").val();
   var c_password = $("input[name=c_password]").val();
     e.preventDefault();
     $.ajax({
         headers: {
             'X-CSRF-Token': '{{ csrf_token() }}',
         },
         url: "{{route('changepasswordfan') }}",
      
         type: 'POST',
         data: {'current_password':current_password,'new_password':new_password,'c_password': c_password}, // Setting the data attribute of ajax with form_data
         success: function (data) {
          if(data['flag'] == 1){
              $('#current_password').html(data['message']);
          }else{
           $('#current_password').html('');
         }
          if(data['flag'] == 2){
              $('#new_password').html(data['message']);
          }else{
           $('#new_password').html('');
         }
         if(data['flag'] == 3){
          // Swal.fire({
          //   position: 'top-end',
          //   icon: 'success',
          //   title: data['message'],
          //   showConfirmButton: false,
          //   timer: 1500
          // })
          localStorage.setItem("changepasswordfan",data['message']);
          location.reload();
         }
         },
         error:function(data){
          var error_msg1  = data['responseJSON'];
           var error_msg2  = error_msg1['errors'];
           console.log(error_msg2);

           if(error_msg2['current_password'] && error_msg2['current_password'].length > 0){
             var current_password_error  = error_msg2['current_password'][0];
           $('#current_password').html(current_password_error);
         }else{
           $('#current_password').html('');
         }
           if(error_msg2['c_password'] && error_msg2['c_password'].length > 0){
             var c_password_error  = error_msg2['c_password'][0];
           $('#c_password').html(c_password_error);
         }else{
           $('#c_password').html('');
         }
           if(error_msg2['new_password'] && error_msg2['new_password'].length > 0){
             var new_password_error  = error_msg2['new_password'][0];
           $('#new_password').html(new_password_error);
         }else{
           $('#new_password').html('');   
         }
         }
     });
 });
});
</script>
<script>
$('#success-alert').delay(5000).fadeOut('slow');

function phoneFormat(input) {//returns (###) ###-####
    input = input.replace(/\D/g,'');
    var size = input.length;
    if (size>0) {input="("+input}
    if (size>3) {input=input.slice(0,4)+") "+input.slice(4,11)}
    if (size>6) {input=input.slice(0,9)+"-" +input.slice(9)}
    return input;
}
</script>
<script>
  $(document).ready(function(){
    toastr.options = {
          "closeButton": true,
          "newestOnTop": true,
          "positionClass": "toast-top-right"
        };
      if(localStorage.getItem("profilesave"))
    {
      toastr.success("Profile updated successfully");
        localStorage.clear();
    }
  
  $("#update_form").on('submit', function (e) {
     var name = $("input[name=name]").val();
     var image = $("input[name=image]").prop('files')[0];
     var email = $("input[name=email]").val();
     var phone_number = $("input[name=phone_number]").val();
     var dob = $("input[name=dob]").val();
     var newsletter = $("input[name=newsletter]").val();
    //  var preferred_genre = $("select[name=preferred_genre]").val();
    var preferred_genre = $("#genre").val();
    var timezone = $("#timezone").val();
       e.preventDefault();
       $.ajax({
           headers: {
               'X-CSRF-Token': '{{ csrf_token() }}',
           },
           url: "{{route('profileStore') }}",
        
           method:"POST",
            data:new FormData(this),
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
          //  data: {'name':name,'image': image,'email': email,'phone_number': phone_number,'dob':dob,'newsletter':newsletter,'preferred_genre':preferred_genre}, // Setting the data attribute of ajax with form_data
           success: function (data) {
            console.log(data);
            // Swal.fire({
            //   position: 'top-end',
            //   icon: 'success',
            //   title: data['message'],
            //   showConfirmButton: false,
            //   timer: 1500
            // })
            // location.reload();
            var error_msg  = data;
               if(error_msg['status'] == 0){
                var error_msg1  = error_msg['message'];
                if(error_msg1['name'] && error_msg1['name'].length > 0){
               var name_error  = error_msg1['name'][0];
             $('#name').html(name_error);
           }else{
             $('#name').html('');
           }
             if(error_msg1['email'] && error_msg1['email'].length > 0){
               var email_error  = error_msg1['email'][0];
             $('#email').html(email_error);
           }else{
             $('#email').html('');
           }
             if(error_msg1['image'] && error_msg1['image'].length > 0){
               var image_error  = error_msg1['image'][0];
             $('#image').html(image_error);
           }else{
             $('#image').html('');
           }
             if(error_msg1['phone_number'] && error_msg1['phone_number'].length > 0){
               var phone_number_error  = error_msg1['phone_number'][0];
             $('#phone_number').html(phone_number_error);
           }else{
             $('#phone_number').html('');
           }
             if(error_msg1['dob'] && error_msg1['dob'].length > 0){
               var dob_error  = error_msg1['dob'][0];
             $('#dob').html(dob_error);
           }else{
             $('#dob').html('');
           }
           if(error_msg1['preferred_genre'] && error_msg1['preferred_genre'].length > 0){
               var preferred_genre_error  = error_msg1['preferred_genre'][0];
             $('#preferred_genre1').html(preferred_genre_error);
           }else{
             $('#preferred_genre1').html('');
           }
           if(error_msg1['timezone'] && error_msg1['timezone'].length > 0){
               var timezone_error  = error_msg1['timezone'][0];
             $('#timezone1').html(timezone_error);
           }else{
             $('#timezone1').html('');
           }

               }else{
                localStorage.setItem("profilesave",error_msg['message']);
                location.reload();
                
                // location.reload();
               }
           },
           error:function(data){
            var error_msg  = JSON.parse(data);
               if(error_msg['status'] == 0){
                var error_msg1  = error_msg['message'];
                // var error_msg2  = error_msg['flag'];
                // if(error_msg2 && error_msg2 == 1){
                //   var event_image_error  = error_msg1;
                //   $('#main_msg').html(event_image_error);
                // }else{
                //   $('#main_msg').html('');
                // }
                if(error_msg1['name'] && error_msg1['name'].length > 0){
               var name_error  = error_msg1['name'][0];
             $('#name').html(name_error);
           }else{
             $('#name').html('');
           }
             if(error_msg1['email'] && error_msg1['email'].length > 0){
               var email_error  = error_msg1['email'][0];
             $('#email').html(email_error);
           }else{
             $('#email').html('');
           }
             if(error_msg1['phone_number'] && error_msg1['phone_number'].length > 0){
               var phone_number_error  = error_msg1['phone_number'][0];
             $('#phone_number').html(phone_number_error);
           }else{
             $('#phone_number').html('');
           }
             if(error_msg1['dob'] && error_msg1['dob'].length > 0){
               var dob_error  = error_msg1['dob'][0];
             $('#dob').html(dob_error);
           }else{
             $('#dob').html('');
           }
           if(error_msg1['preferred_genre'] && error_msg1['preferred_genre'].length > 0){
               var preferred_genre_error  = error_msg1['preferred_genre'][0];
             $('#preferred_genre').html(preferred_genre_error);
           }else{
             $('#preferred_genre').html('');
           }
           if(error_msg1['timezone'] && error_msg1['timezone'].length > 0){
               var timezone_error  = error_msg1['timezone'][0];
             $('#timezone1').html(timezone_error);
           }else{
             $('#timezone1').html('');
           }

               }else{
                location.reload();
               }
              
           }
       });
   });
  });
  </script>
  <script>
    var uploaderBtn = document.querySelector("#profile_fan")
    uploaderBtn.addEventListener("change", function (event) {
      console.log(src,preview ,"text")
    if (event.target.files.length > 0) {
      var src = URL.createObjectURL(event.target.files[0]);
      var preview = (document.querySelector(".imgs").src = src);
      console.log(src,preview ,"text")
    }
  });
  </script>
@endsection

