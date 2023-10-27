<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FanToStage</title>
<link rel="stylesheet" href="{{ asset('assets/fan/css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/fan/css/responsive.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/fan/css/variable.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/fan/bootstrap/css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/fan/css/fontawesome.min.css') }}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>

    {{-- sweet alert --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>
    {{-- sweet alert --}}

    {{-- Toast message --}}
    <link rel="stylesheet" type="text/css" 
     href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- Toast message --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    {{-- socket cdn --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.1/socket.io.js" integrity="sha512-Z6C1p1NIexPj5MsVUunW4pg7uMX6/TT3CUVldmjXx2kpip1eZcrAnxIusDxyFIikyM9A61zOVNgvLr/TGudOQg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- socket cdn --}}
    
@yield('header')
</head>
<body>
@if(auth()->user() &&  !request()->is('fan/login') && !request()->is('fan/register'))
@include('fanweb.layouts.header')
@endif
@yield('content')
@if(auth()->user() &&  !request()->is('fan/login') && !request()->is('fan/register') )
@include('fanweb.layouts.footer')
@endif  
<script src="{{ asset('assets/fan/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/fan/js/custom.js') }}"></script>
<script src="{{ asset('assets/fan/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/fan/bootstrap/js/bootstrap.bundle.js') }}"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.slick/1.4.1/slick.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/js-base64@3.6.0/base64.min.js"></script>

<script>
  function phoneFormat1(input) {//returns (###) ###-####
    input = input.replace(/\D/g,'');
    var size = input.length;
    if (size>0) {input="("+input}
    if (size>3) {input=input.slice(0,4)+") "+input.slice(4,11)}
    if (size>6) {input=input.slice(0,9)+"-" +input.slice(9)}
    return input;
}

$(document).ready(function(){

  $('.event_div').hide();

  $("input[name='ad_type']").change(function(){
    
    var type =$('input[name="ad_type"]:checked').val();
    if(type =="artists")
    $('.event_div').hide();
    else if(type =='events')
    $('.event_div').show();

});

  var intArr = [];
  var intArr1 = [];
    $(".Rating_star").click(function(){
        $(this).toggleClass("active");
      });

      $(".gender_lisr").click(function(){
        $(this).toggleClass("active gender_lisr-active");
      })

      $(".gender_lisr").click(function(){
        var value = $(this).text();

        if($(this).hasClass('gender_lisr-active'))
        {
          intArr.push(value);
        }else{
          intArr.pop(value);
        }
        $('#ad_genre').val(intArr);
      });
      $(".Rating_star").click(function(){
        var value = $(this).data("value");

        if($(this).hasClass('active'))
        {
          intArr1.push(value);
        }else{
          intArr1.pop(value);
        }
        $('#ad_rating_value').val(intArr1);
      });
    });

    
   
</script>
<script>

$(document).ready(function(){
  var hasSeenPopupToday = localStorage.getItem('hasSeenPopupToday');
if(hasSeenPopupToday != null ){
  if(hasSeenPopupToday == 'true'){
    $('.footer_newsletter').hide();
  }else{
    $('.footer_newsletter').show();
  }
}else{
  $('.footer_newsletter').show();
}
  

  $('.Maybe').click(function(){
    var hasSeenPopupToday = localStorage.getItem('hasSeenPopupToday');
    if(hasSeenPopupToday != null ){
    if(hasSeenPopupToday == 'true'){
      $('.footer_newsletter').hide();
    }else{
      localStorage.setItem('hasSeenPopupToday', 'true');
    }
  }else{
    $('.footer_newsletter').hide();
    localStorage.setItem('hasSeenPopupToday', 'true');
  }
  });

});
</script>
<script>
  $(document).ready(function() {
    $('.notify').on('click', function() {
      $('#exampleModalTogglenotify').modal('show');
    });
      $.ajax({
        headers: {
             'X-CSRF-Token': '{{ csrf_token() }}',
         },
         url: "{{route('notify') }}",
          type: 'GET',
          dataType: 'json',
          success: function(data) {
            // console.log();
            if(data.notify){
              if (data.notify.length > 0) {
                  var notificationsHtml = '';
                  data.notify.forEach(function(notification) {
                      notificationsHtml += '<div class="list_notification_innre not_open" id="yes">';
                      notificationsHtml += '<div class="close_notification">';
                      notificationsHtml += '<div class="img_noti"><img src="' + notification.profile_image + '" alt=""></div>';
                      notificationsHtml += '<div class="notification_text">';
                      notificationsHtml += '<h4 id="yes">' + notification.description + '</h4>';
                      notificationsHtml += '<p>' + notification.date + '</p>';
                      notificationsHtml += '</div>';
                      notificationsHtml += '</div>';
                      notificationsHtml += '<i class="fa-solid fa-xmark close_icon  yes" data-id="'+notification.id+'"></i>';
                      notificationsHtml += '</div>';
                  });

                  $(notificationsHtml).insertAfter('#notifications-inner-container');
              } else {
                  $('#notifications-inner-container').html('<p style="text-align:center;">Notifications not available.</p>');
              }
            }else{
              $('#notifications-inner-container').html('<p style="text-align:center;">Notifications not available.</p>');
            }
          },
          error: function() {
              $('#notifications-inner-container').html('<p>Error loading notifications.</p>');
          }
      });
      $(document).on("click", ".yes" , function() {    

        var dataId = $(this).data('id');
            var notificationItem = $(this);
            var notificationId = notificationItem.data('id');
            var url = "{{ route('notifyread', ':notificationId') }}";
            url = url.replace(':notificationId', notificationId);
            var closestDiv = $(this).closest('.list_notification_innre');

      $.ajax({
        headers: {
             'X-CSRF-Token': '{{ csrf_token() }}',
         },
         url: url,
          type: 'GET',
          dataType: 'json',
          success: function(data) {
        closestDiv.addClass('new-class');
        setTimeout(() => {
          closestDiv.remove();
        }, 1000);
            if(!data.notify){
              $('#notifications-inner-container').html('<p style="text-align:center;">Notifications not available!!!.</p>');
            }
          },
          error: function(data) {
            closestDiv.addClass('new-class');
            setTimeout(() => {
          closestDiv.remove();
        }, 1000);
            if(!data.notify){
              $('#notifications-inner-container').html('<p style="text-align:center;">Notifications not available!!!.</p>');
            }
           
          }
      });
    });
    $('.markallread').on('click', function() {
            var $divs = $('.list_notification_innre').get().reverse();

      $.ajax({
        headers: {
             'X-CSRF-Token': '{{ csrf_token() }}',
         },
         url: "{{ route('notifyreadall') }}",
          type: 'GET',
          dataType: 'json',
          success: function(data) {

             var $divs = $('.list_notification_innre');
        var delayDuration = 300; 

        $($divs.get().reverse()).each(function(index, element) {
            setTimeout(function() {
                $(element).addClass('new-class');
            }, delayDuration * index);
        });
            if(!data.notify){
              $('#notifications-inner-container').html('<p style="text-align:center;">Notifications not available!!!.</p>');
            }
              
          },
          error: function(data) {

            var $divs = $('.list_notification_innre');
            var delayDuration = 300; 

            $($divs.get().reverse()).each(function(index, element) {
                setTimeout(function() {
                    $(element).addClass('new-class');
                }, delayDuration * index);
            });
                if(!data.notify){
              $('#notifications-inner-container').html('<p style="text-align:center;">Notifications not available!!!.</p>');
            }
          }
      });
    });
  });
</script>
@yield('timer')
@yield('footer')
</body>
</html>