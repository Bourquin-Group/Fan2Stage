
{{-- <script src="{{ asset('assets/web/js/jquery.min.js') }}"></script> --}}
    <script src="{{ asset('assets/web/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/web/bootstrap/js/bootstrap.bundle.js') }}"></script>

    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.multi-select.js"></script>
    <script src="{{ asset('assets/web/js/custom.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
  

  {{-- vimal --}}
  <script>

function phoneFormat2(input) {//returns (###) ###-####
    input = input.replace(/\D/g,'');
    var size = input.length;
    if (size>0) {input="("+input}
    if (size>3) {input=input.slice(0,4)+") "+input.slice(4,11)}
    if (size>6) {input=input.slice(0,9)+"-" +input.slice(9)}
    return input;
}
  </script>
  {{-- vimal --}}
     <script>
    // OTP 


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

const formatToPhone = (event) => {


  // I am lazy and don't like to type things more than once
  const target = event.target;
  const input = event.target.value.replace(/\D/g,'').substring(0,10); // First ten digits of input only
  // const zip = input.substring(0,4);
  // const middle = input.substring(4,6);
  // const last = input.substring(6,10);

  // if(input.length > 6){target.value = `${zip} - ${middle} - ${last}`;}
  // else if(input.length > 3){target.value = `${zip} - ${middle}`;}
  // else if(input.length > 0){target.value = `${zip}`;}
};

const inputElement = document.getElementById('phoneNumber');
inputElement.addEventListener('keyup',formatToPhone);
</script>
<script>

    $(document).ready(function(){
          $(".alert").delay(4000).slideUp(500);
    });

    </script>

    <script>  
$(document).ready(function(){  
  $(".resend").click(function(){ 
   var email =  $(this).attr("value");
  //var email = $('#resend').val(); 
    //alert(email);
jQuery.ajax({  
url: '{{route("resendotp")}}',
headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
        },
        //data: email, 
        data:{
        email:email,
    }, 
type: 'POST',  
  success: function(data) {  
   
    console.log(data.message);
     console.log(data);
    $("#result").html(data.message);
    $("#result").show();
    $("#result").delay(4000).slideUp(500); 
    $("#js-startTimer").click();              
  }  
});  
  });  
});  
</script> 
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
</script>
@yield('timer')

@yield('script')

@yield('eventdetail')
@yield('eventedit')
@yield('profileedit')
@yield('golive')
@yield('login-validation')
@yield('contact')
@yield('homeblade')
  </body>
</html>