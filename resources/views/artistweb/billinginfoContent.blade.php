@extends('artistweb.layouts.main')
@section('css')
<style>
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
@section('body')
<section class="main_section">     
    <div class="custom_container">
        <div class="d-flex align-items-start res-flex-wrap">
            @include('artistweb.layouts.sidebar')
            <div class="tab-content col-lg-9 col-md-12 col-sm-12 col-xs-12 {{ (isset($errors)) ? 'edit-input-filed' : '' }}" id="v-pills-tabContent ">
                @include('artistweb.quicklinks.billinginfo')
            </div>
        </div>
    </div>
@endsection
@section('myprofile')
<script>
    $(document).ready(function(){
  
  $(document).on("click", "#billinginfo", function (e) {
     var address = $("input[name=address]").val();
     var city = $("input[name=city]").val();
     var state = $("input[name=state]").val();
     var country = $("input[name=country]").val();
     var postalcode = $("input[name=postalcode]").val();
       e.preventDefault();
       $.ajax({
           headers: {
               'X-CSRF-Token': '{{ csrf_token() }}',
           },
           url: "{{route('billinginformationweb') }}",
        
           type: 'POST',
           data: {'address':address,'city':city,'state': state,'country': country,'postalcode': postalcode}, // Setting the data attribute of ajax with form_data
           success: function (data) {
           if(data['flag'] == 3){
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: data['message'],
              showConfirmButton: false,
              timer: 1500
            })
            location.reload();
           }
           },
           error:function(data){
            var error_msg1  = data['responseJSON'];
             var error_msg2  = error_msg1['errors'];
             console.log(error_msg2);
  
             if(error_msg2['address'] && error_msg2['address'].length > 0){
               var address_error  = error_msg2['address'][0];
             $('#address1').html(address_error);
           }else{
             $('#address1').html('');
           }
             if(error_msg2['city'] && error_msg2['city'].length > 0){
               var city_error  = error_msg2['city'][0];
             $('#city1').html(city_error);
           }else{
             $('#city1').html('');
           }
             if(error_msg2['state'] && error_msg2['state'].length > 0){
               var state_error  = error_msg2['state'][0];
             $('#state1').html(state_error);
           }else{
             $('#state1').html('');
           }
             if(error_msg2['country'] && error_msg2['country'].length > 0){
               var country_error  = error_msg2['country'][0];
             $('#country1').html(country_error);
           }else{
             $('#country1').html('');
           }
             if(error_msg2['postalcode'] && error_msg2['postalcode'].length > 0){
               var postalcode_error  = error_msg2['postalcode'][0];
             $('#postalcode1').html(postalcode_error);
           }else{
             $('#postalcode1').html('');
           }
           }
       });
   });
  });
  </script>
@endsection