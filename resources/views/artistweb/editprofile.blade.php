@extends('artistweb.layouts.main')
@section('css')
<style>
div#imagePreview {
    background-repeat: no-repeat;
    height: 265px;
    width: 100% !important;
    border: 1px solid #A6C2E9;
    background-position: center;
    background-size: contain;
    border-radius: 10px;
}

.profile-banner {
    position: relative;
}


.avatar-preview.container2 {
    border: 1px solid #A6C2E9;
    border-radius: 10px;
} 

.drop-zone__prompt_1 {
    display: none;
}
.avatar-edit{
    height: 0;
}
</style>
@endsection
@section('body')
<section class="main_section">     
    <div class="custom_container">
        <div class="d-flex align-items-start res-flex-wrap">
            @include('artistweb.layouts.sidebar')
            <div class="tab-content col-lg-9 col-md-12 col-sm-12 col-xs-12 {{ (isset($errors)) ? 'edit-input-filed' : '' }}" id="v-pills-tabContent ">
                @include('artistweb.quicklinks.editprofile')
                
            </div>
        </div>
    </div>
@endsection
@section('profileedit')
<script>
    new Choices(document.querySelector(".choices-multiple"));

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
    var $modal = $('.imagecrop');
    var image = document.getElementById('image');
    var cropper;
    
    $("body").on("change", "#imageUpload", function(e){
        var files = e.target.files;
        var done = function(url) {
            image.src = url;
            $modal.modal('show');
        };
        var reader;
        var file;
        var url;
        if (files && files.length > 0) {
            file = files[0];
            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });
    
    $modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: NaN, // Allow any aspect ratio
            viewMode: 3, // Set view mode to 3 for covering the whole image
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });
    
    $("body").on("click", "#crop", function() {
        canvas = cropper.getCroppedCanvas({
          width: 320, // Larger width
    height: 320, // Larger height
    quality: 0.1, // Adjust quality as needed
        });
        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                var base64data = reader.result;
                $('#base64image').val(base64data);
                document.getElementById('imagePreview').style.backgroundImage = "url("+base64data+")";
                $modal.modal('hide');
            }
        });
    });
});

  </script>
  <script>
    $(document).ready(function(){
  
  $(document).on("click", "#changepasswordweb", function (e) {
     var current_password = $("input[name=current_password]").val();
     var new_password = $("input[name=new_password]").val();
     var c_password = $("input[name=c_password]").val();
       e.preventDefault();
       $.ajax({
           headers: {
               'X-CSRF-Token': '{{ csrf_token() }}',
           },
           url: "{{route('changepasswordweb') }}",
        
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
@endsection