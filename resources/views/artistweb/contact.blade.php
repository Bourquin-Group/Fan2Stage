@extends('artistweb.layouts.main')
@section('body')
<section class="main_section">     
    <div class="custom_container contact-section">
      <div class="tab-heading arrow-align">
        <h1 class="font-28"> Support</h1>
        @if(Session::has('success'))
        <div class="text-success" id="contacttext-success">
            {{ Session::get('success') }}
            @php
                Session::forget('success');
            @endphp
        </div>
        @endif
      </div> 
          <div class="row">
              <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
                 <div class="con-left-sec">
                     <div class="contact-text">
                          <h1 class="font-22">Let's Talk</h1>
                          <p class="font-18">{!! $contactdetail->title1 !!}</p>
                     </div>
                     <div class="form-input-section">
                        {{-- <form action="{{ url('/web/contactcreate') }}" class="contact-form-section" method="post">
                            @csrf
                            @method("POST") --}}
                          <div class="first-column">
                                <div class="email-section ">
                                <label for="" class="font-16">First Name*</label>
                                <div class="email-icon">
                                <span>
                                <img src="{{ asset('assets/web/images/user.svg') }}" alt="" srcset="">
                                </span>
                                <input class="font-16" name="first_name" type="text" placeholder="Enter First Name" value="{{old('first_name')}}">
                                </div>
                                {{-- @if ($errors->has('first_name')) --}}
                                <span class="first_name"></span>
                                {{-- @endif --}}
                                </div>
                                  <div class="email-section ">
                                    <label for="" class="font-16">Last Name*</label>
                                    <div class="email-icon">
                                    <span>
                                    <img src="{{ asset('assets/web/images/user.svg') }}" alt="" srcset="">
                                    </span>
                                    <input class="font-16" name="last_name" type="text" placeholder="Enter Last Name" value="{{old('last_name')}}">
                                    </div>
                                    {{-- @if ($errors->has('last_name')) --}}
                                    <span class="last_name"></span><span class="text-danger" id="contacttext-danger">{{ $errors->first('last_name') }}</span>
                                    {{-- @endif --}}
                                  </div>                            
                                  <div class="email-section">
                                    <label for="" class="font-16">Email* </label>
                                    <div class="email-icon">
                                      <span>
                                          <img src="{{ asset('assets/web/images/Email.svg') }}" alt="" srcset="">
                                      </span>
                                      <input class="font-16" name="email" type="email" placeholder="Enter Email" value="{{old('email')}}">
                                    </div>
                                    {{-- @if ($errors->has('email')) --}}
                                    <span class="email"></span>
                                    {{-- @endif --}}
                                  </div>
                                  <div class="email-section">
                                    <label for="" class="font-16">Phone*</label>
                                    <div class="email-icon">
                                    <span>
                                    <img src="{{ asset('assets/web/images/phone.svg') }}" alt="" srcset="">
                                    </span>
                                    <input class="font-16" name="phone" type="text" maxlength="10" placeholder="Enter Phone" value="{{old('phone')}}">
                                    </div>
                                    {{-- @if ($errors->has('phone')) --}}
                                    <span class="phone"></span>
                                    {{-- @endif --}}
                                  </div>
                           </div>
                           <div class="con-text-area">
                              <label for="">Comment*</label>
                              <textarea name="comments" id=""  class="font-15" placeholder="Enter Message"></textarea>
                              {{-- @if ($errors->has('comments')) --}}
                              <span class="comments"></span>
                                {{-- @endif --}}

                              <div class="login-btn con-form-btn">
                                <button type="submit" id="contact" class="font-16">Submit</button>
                            </div>
                           </div>
                        {{-- </form> --}}
                     </div>
                 </div>
              </div>
              <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                <div class="con-right-sec">
                    <div class="more-options-sec">
                      <div class="contact-text">
                        <h1 class="font-22 ">More Options</h1>
                        <p class="font-18">{!! $contactdetail->title2 !!}</p>
                     </div>    
                       <div class="second-column">
                          <div class="calls-sec">
                             <img src="{{ asset('assets/web/images/con-phone.svg') }}" alt="" srcset="">
                             <h6 class="font-20">Call us
                               <span class="font-18">+(1) {{$contactdetail->phone}}</span>
                             </h6>
                          </div>

                          <div class="calls-sec">
                            <img src="{{ asset('assets/web/images/con-email.svg') }}" alt="" srcset="">
                            <h6 class="font-20">Email us
                              <span class="font-18">{{$contactdetail->email}}</span>
                            </h6>
                         </div>
                       </div>
                       <div class="loction-sec">
                        <div class="calls-sec">
                          <img src="{{ asset('assets/web/images/con-location.svg') }}" alt="" srcset="">
                          <h6 class="font-20">Location
                            <span class="font-18">{{$contactdetail->location}}</span>
                          </h6>
                       </div>
                       </div>
                    </div>
                    <div class="map-section">
                      <iframe src="{{$contactdetail->map}}" width="100%" height="430" frameborder="0" style="border:0"></iframe>
                    </div>
                </div>
              </div>
          </div>
    </div>

   


</section>
@endsection
@section('contact')
<script>
  $(document).ready(function(){

$(document).on("click", "#contact", function (e) {
   var first_name = $("input[name=first_name]").val();
   var last_name = $("input[name=last_name]").val();
   var email = $("input[name=email]").val();
   var phone = $("input[name=phone]").val();
   var comments = $("textarea[name=comments]").val();
     e.preventDefault();
     $.ajax({
         headers: {
             'X-CSRF-Token': '{{ csrf_token() }}',
         },
         url: "{{route('contactcreates') }}",
      
         type: 'POST',
         data: {'first_name':first_name,'last_name':last_name,'email': email,'phone': phone,'comments': comments}, // Setting the data attribute of ajax with form_data
         success: function (data) {
          // Swal.fire({
          //                   title: data['message'],
          //                   confirmButtonText: 'OK',
          //                   }).then((result) => {
          //                   if (result.isConfirmed) {
          //                       alert('ok');
          //                   }
          //                   })
          Swal.fire({
            icon: 'success',
            title: data['message'],
            showConfirmButton: false,
            timer: 30000
          })
          location.reload();
         },
         error:function(data){
          var error_msg1  = data['responseJSON'];
           var error_msg2  = error_msg1['errors'];
          //  var error_msg3  = error_msg2['comments'][0];
           console.log(error_msg2);

           if(error_msg2['first_name'] && error_msg2['first_name'].length > 0){
             var first_name_error  = error_msg2['first_name'][0];
           $('.first_name').html(first_name_error);
         }else{
           $('.first_name').html('');
         }
           if(error_msg2['last_name'] && error_msg2['last_name'].length > 0){
             var last_name_error  = error_msg2['last_name'][0];
           $('.last_name').html(last_name_error);
         }else{
           $('.last_name').html('');
         }
           if(error_msg2['email'] && error_msg2['email'].length > 0){
             var email_error  = error_msg2['email'][0];
           $('.email').html(email_error);
         }else{
           $('.email').html('');
         }
           if(error_msg2['phone'] && error_msg2['phone'].length > 0){
             var phone_error  = error_msg2['phone'][0];
           $('.phone').html(phone_error);
         }else{
           $('.phone').html('');
         }
           if(error_msg2['comments'] && error_msg2['comments'].length > 0){
             var comments_error  = error_msg2['comments'][0];
           $('.comments').html(comments_error);
         }else{
           $('.comments').html('');
         }
         }
     });
 });
});
</script>
@endsection