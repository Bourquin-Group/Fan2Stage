@extends('fanweb.layouts.main')
@section('content')
   <div class="login-page-main">
    <div class="login-section ">             
        <div class="login-form-section otp-section"> 
             <a href="{{url('/fan/login')}}" class="arrow-left"><img src="{{asset('/assets/fan/images/arrow-left.svg')}}" alt="" srcset=""></a>
             <div class="mbl-logo-sec">
                   <img src="{{asset('/assets/fan/images/mbl-Logo.png')}}" alt="logo" class="src">
             </div>
             <div class="form-title">
                  <h1 class="font-32 wel-txt">Please Verify Account</h1>
                  <h6 class="font-20 wel-sub-txt">Enter the 4 digit code that we sent to your registered
                   email to verify your account</h6>
             </div>
             <div class="text-success" id="result" style="display:none"></div>
             @if (Session::has('message'))
             <div class="alert alert-info">{{ Session::get('message') }}</div>
           @endif
           @if(session()->has('status'))
             <p class="text-danger" id="e-status">{{session('status')}}</p>
           @endif
             <div class="form-input-section ver-otp-inpt">
                 <form method="post" action="{{url('/fan/otpverification/')}}">
                    @csrf
                     <div class="ver-otp">
                        <input type="number" name="otp[]" id="" class="font-24" >
                        <input type="number" name="otp[]" id="" class="font-24" disabled>
                        <input type="number" name="otp[]" id="" class="font-24" disabled>
                        <input type="number" name="otp[]" id="" class="font-24" disabled>
                        <input type="hidden" value="{{$user->email}}" name="email">
                        <input type="hidden" value="{{$type}}" name="type">
                        <input type="hidden" value="{{$user->uuid}}" name="uuid">
                     </div>

                     <div class="login-btn ">
                         <button type="submit" class="font-16">Verify and Continue</button>
                     </div>
                 </form>

                 <div class="resend-sec">
                    <p class="font-18"><span class="resend" id="resend" value="{{$user->email}}">Resend Code</span><span class="font-18 js-timeout">02:00</span></p>
                    <button id="js-startTimer">Start Countdown</button>
                    <button id="js-resetTimer">Stop &amp; Reset</button>
                 </div>

             </div>                  
        </div>
    </div>
</div>
@endsection
@section('timer')
<script type="text/javascript">
 var interval;

function countdown() {
  clearInterval(interval);
  interval = setInterval( function() {
      var timer = $('.js-timeout').html();
      timer = timer.split(':');
      var minutes = timer[0];
      var seconds = timer[1];
      seconds -= 1;
      if (minutes < 0) return;
      else if (seconds < 0 && minutes != 0) {
          minutes -= 1;
          seconds = 59;
      }
      else if (seconds < 10 && length.seconds != 2) seconds = '0' + seconds;

      $('.js-timeout').html(minutes + ':' + seconds);

      if (minutes == 0 && seconds == 0) clearInterval(interval);
  }, 1000);
}

$('#js-startTimer').click(function () {
  $('.js-timeout').text("2:00");
  countdown();
});

$('#js-resetTimer').click(function () {
  $('.js-timeout').text("2:00");
  clearInterval(interval);
});
$(document).ready(function(){
   $("#js-startTimer").click(); 
});

// ---------------------------
const inputs = document.querySelectorAll(".ver-otp input"),
  button = document.querySelector("button");


inputs.forEach((input, index1) => {
  input.addEventListener("keyup", (e) => {
    
    const currentInput = input,
      nextInput = input.nextElementSibling,
      prevInput = input.previousElementSibling;

    if (currentInput.value.length > 1) {
      currentInput.value = "";
      return;
    }

    if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
      nextInput.removeAttribute("disabled");
      nextInput.focus();
    }

 
    if (e.key === "Backspace") {

      inputs.forEach((input, index2) => {
       
        if (index1 <= index2 && prevInput) {
          input.setAttribute("disabled", true);
          input.value = "";
          prevInput.focus();
        }
      });
    }

    if (!inputs[3].disabled && inputs[3].value !== "") {
      button.classList.add("active");
      return;
    }
    button.classList.remove("active");
  });
});


window.addEventListener("load", () => inputs[0].focus());
</script>
<script>  
    $(document).ready(function(){  
      $(".resend").click(function(){ 
       var email =  $(this).attr("value");
    jQuery.ajax({  
    url: '{{route("resentotp")}}',
    headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
            data:{
            email:email,
        }, 
    type: 'POST',  
      success: function(data) {  
       
        console.log(data.message);
         console.log(data);
         if(data.message != ''){
          $("#e-status").css("display", "none")
          $("#result").css("display", "block")
          $("#result").html(data.message);
         }
        $("#result").show();
        $("#result").delay(4000).slideUp(500); 
        $("#js-startTimer").click();              
      }  
    });  
      });  
    });  
    </script> 
@endsection

