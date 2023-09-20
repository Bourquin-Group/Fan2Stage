@extends('fanweb.layouts.main')
@section('header')
<style>
      
</style>
@endsection
@section('content')
<section class="main_section"> 
    <div class="custom_container">
        <div class="tab-heading arrow-align">
          <h1 class="font-28"> <a href="./My-profile.html"><img src="{{asset('/fan/images/arrow-left.png')}}" alt="" srcset=""></a>Subscriptions</h1>
        </div>
        @if(session()->has('error'))
                        <p class="alert alert-danger">{{session('error')}}</p>
                    @endif
                    @if(session()->has('success'))
                        <p class="alert alert-success">{{session('success')}}</p>
                    @endif
        <div class="profile-main sub-main billinginfo_section ">
          <div class="plan_preview">
            <div class="plan_preview_left">
              <div class="plan_preview_section">
                <h4>{{$event->event_title}}</h4>
                <p>Payment details for the plan of “ Basic”</p>
              </div>
              <div class="plan_preview_price"><h1>${{$event->eventamount}}</h1></div>
            </div>
            <div class="plan_preview_right">
              <div class="plan_preview_limit">
                <p>Total Amount</p>
                <h6>${{$event->eventamount}}</h6>
              </div>
            </div>
          </div>
          <div class="more_informstion">
                                <div class="cardDetails">
                                  <form method="post" action="{{route('subscription.posts')}}"
                                        role="form" 
                                    action="{{ route('stripe.post') }}" 
                                    method="post" 
                                    class="require-validation"
                                    data-cc-on-file="false"
                                    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                    id="payment-form">
                                    @csrf() 
                                    <input type="hidden" value="{{$event->id}}" name="event_id">
                                    <input type="hidden" value="{{$event->user_id}}" name="artist_id">
                                   <input type="hidden" value="1" name="type">
                                  <h2 class="detail_header">Card Details</h2>
                                  <div class="card_img_section">
                                  <div class="card_list"><img src="{{asset('assets/images/Card_1.png')}}" alt=""></div>
                                  <div class="card_list"><img src="{{asset('assets/images/Card_2.png')}}" alt=""></div>
                                  <div class="card_list"><img src="{{asset('assets/images/Card_3.png')}}" alt=""></div>
                                  <div class="card_list"><img src="{{asset('assets/images/Card_4.png')}}" alt=""></div>
                                  </div>
                                  <label class="error mb-2" id="paymenterror"></label>
                                  <div class="form-section">
                                  <label for="">Card Number</label>
                                  <input type="text" autocomplete='off' id="card" class='form-control card-number' maxlength="19" placeholder="Enter card number"  name="card" onkeyup="if (/[^\d\s]/g.test(this.value)) this.value = this.value.replace(/[^\d\s]/g, '');">
                                  <label class="error paymenterror" id="card-error"></label>
                                  @if($errors->has('card'))
                                  <label class="error" id="paymenterror">{{$errors->first('card')}}</label>
                                  @endif
                                  </div>
                                  <div class="billinginfo row">
                                  <div class="form-section col-md-3" style="min-width:45%">
                                      <label for="month">Month</label>
                                      <input type="number" name="month" id="month"  class='form-control card-expiry-month' placeholder="MM" oninput="this.value=this.value.replace(/[^0-9]/g,'');" minlength="2" maxlength="2"/>
                                      <label class="error paymenterror" id="month_error"></label>
                                      @if($errors->has('month'))
                                      <label class="error" id="paymenterror">{{$errors->first('month')}}</label>
                                      @endif
                                  </div>
                                  <div class="form-section col-md-3" style="min-width:50%; ">
                                      <label for="year">Year</label>
                                      <input type="number" name="year" id="year"  placeholder="YYYY"  class='form-control card-expiry-year' oninput="this.value=this.value.replace(/[^0-9]/g,'');" minlength=4 maxlength=4>
                                      <label class="error paymenterror" id="year_error"></label>
                                      @if($errors->has('year'))
                                      <label class="error" id="paymenterror">{{$errors->first('year')}}</label>
                                      @endif
                                  </div>
                                  </div>
                                  <div class="billinginfo">
                                  <div class="form-section">
                                      <label for="">CVV</label>
                                      <input type="text" placeholder="(Eg). 123" name="cvv"  id="cvv"   autocomplete='off'
                                    class='form-control card-cvc' oninput="this.value=this.value.replace(/[^0-9]/g,'');" minlength=3 maxlength=3>
                                    <label class="error paymenterror" id="cvv_error"></label>
                                     @if($errors->has('cvv'))
                                      <label class="error" id="paymenterror">{{$errors->first('cvv')}}</label>
                                      @endif
                                  </div>
                                  </div>
                                  <div class="form-section">
                                  <label for="">Account Holders Name</label>
                                  <input type="text" placeholder="Type Name" id="account_holder_name" name="account_holder_name">
                                  <label class="error paymenterror" id="account_holder_name_error"></label>
                                      @if($errors->has('account_holder_name'))
                                      <label class="error" id="paymenterror">{{$errors->first('account_holder_name')}}</label>
                                      @endif
                                  </div>
                                  <div class="button_gorup">
                                  <button><a href="#">Cancel</a> </button>
                                  <button  type="submit"  > Pay Now</button>
                              </div>
          </form>
          </div>
          
      </div>
    </div>
</section>
@endsection
@section('footer')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/css/screen.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    $(function() {
   var $form = $(".require-validation");
  
   $('form.require-validation').bind('submit', function(e) {
       var $form         = $(".require-validation"),
       inputSelector = ['input[name=card]','input[name=month]',
                        ].join(', '),
       $inputs       = $form.find('.required').find(inputSelector),
       $errorsMessage = $form.find('div.error'),
       valid         = true;
       $errorsMessage.addClass('hide');
       console.log('submit');
       $('.has-error').removeClass('has-error');
       $inputs.each(function(i, el) {
         var $input = $(el);
         if ($input.val() === '') {
           $input.parent().addClass('has-error');
           $errorsMessage.removeClass('hide');
           e.preventDefault();
         }
       });
  
       if (!$form.data('cc-on-file')) {
           var regex = /^[a-z]*$/i;
           var numbers = /^[0-9]+$/;
           var card =  $('#card').val();
        
           var month =  $('#month').val();
           var year =  $('#year').val();
           var cvv  =  $('#cvv').val();
           var validation =0;
           var account_holder_name  =  $('#account_holder_name').val();
           if(card == '')
          
           {
            validation =1;
           
            $('#card-error').html('Please enter a Card');
           }
           $("#card").inputFilter(function(value) {
               return /^\d*$/.test(value);    // Allow digits only, using a RegExp
               },"Only digits allowed");
           if(month == '')
           {
            validation =1;
            $('#month_error').html('Please enter a Month');
           }

           if(year == '')
           {
            validation =1;
            $('#year_error').html('Please enter a Year');
           }

          //  if(cvv == '')
          //  {
          //   validation =1;
          //   $('#cvv_error').html('Please enter a cvv');
          //  }

          //  if(account_holder_name == '')
          //  {
          //   validation =1;
          //   $('#account_holder_name_error').html('Please enter a Account Holder Name');
          //  }
         e.preventDefault();
         Stripe.setPublishableKey($form.data('stripe-publishable-key'));
         Stripe.createToken({
           number: $('.card-number').val(),
           cvc: $('.card-cvc').val(),
           exp_month: $('.card-expiry-month').val(),
           exp_year: $('.card-expiry-year').val()
         }, stripeResponseHandler);
       }
 
 });
 
 function stripeResponseHandler(status, response) {
      //  if (response.error) {
      //      $('.error')
      //          .removeClass('hide')
      //          .find('.alert')
      //          .text(response.error.message);
      //  } else {
      //      /* token contains id, last4, and card type */
      //      var token = response['id'];
              
      //      $form.find('input[type=text]').empty();
      //      $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
      //      $form.get(0).submit();
      //  }
          var cvv  =  $('#cvv').val();
          var account_holder_name  =  $('#account_holder_name').val();
          if(account_holder_name != '' && cvv != '')
           {
              if (response.error) {
                    if(response.error.param == "number"){
                      $('#card-error').html(response.error.message);
                    }else{
                      $('#card-error').html("");
                    }
                    if(response.error.code == "missing_payment_information"){
                      $('#paymenterror').html(response.error.message);
                    }else{
                      $('#paymenterror').html("");
                    }
                    if(response.error.param == "exp_month"){
                      $('#month_error').html(response.error.message);
                    }else{
                      $('#month_error').html("");
                    }
                    if(response.error.param == "exp_year"){
                      $('#year_error').html(response.error.message);
                    }else{
                      $('#year_error').html("");
                    }
              } else {
                    var token = response['id'];
                      
                      $form.find('input[type=text]').empty();
                      $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                      $form.get(0).submit();
                  //  }
                  /* token contains id, last4, and card type */
                  
              }
           }else{
            if(card == '')
           {
            $('#card-error').html('Please enter a Card');
           }

           if(month == '')
           {
            $('#month_error').html('Please enter a Month');
           }

           if(year == '')
           {
            $('#year_error').html('Please enter a Year');
           }
                if(account_holder_name == ''){
                  $('#account_holder_name_error').html('Please enter a Account Holder Name');
                }else{
                  $('#account_holder_name_error').html('');
                }
                if(cvv == ''){
                  $('#cvv_error').html('Please enter a cvv');
                }else{
                  $('#cvv_error').html('');
                }
                if (response.error) {
                    if(response.error.param == "number"){
                      $('#card-error').html(response.error.message);
                    }else{
                      $('#card-error').html("");
                    }
                    if(response.error.code == "missing_payment_information"){
                      $('#paymenterror').html(response.error.message);
                    }else{
                      $('#paymenterror').html("");
                    }
                    if(response.error.param == "exp_month"){
                      $('#month_error').html(response.error.message);
                    }else{
                      $('#month_error').html("");
                    }
                    if(response.error.param == "exp_year"){
                      $('#year_error').html(response.error.message);
                    }else{
                      $('#year_error').html("");
                    }
              } else {
                if(account_holder_name != '' && cvv != '')
           {
                    var token = response['id'];
                      
                      $form.find('input[type=text]').empty();
                      $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                      $form.get(0).submit();
           }
                  //  }
                  /* token contains id, last4, and card type */
                  
              }
                
           }
   }
  
});
$('#card').on('keypress change', function () {
                 $(this).val(function (index, value) {
                     return value.replace(/\W/gi, '').replace(/(.{4})/g, '$1 ');
                 });
            });
//   $("#payment-form").validate({
//     rules: {
//         card:"required",
//         month:"required",
//         year:"required",
//         cvv:"required",
//         account_holder_name:"required",
//     },
//     messages: {
//         postal_code: "Please enter a Postal Code",
//         card: "Please enter a Card",
//         month: "Please enter a Month",
//         year: "Please enter a Year",
//         cvv: "Please enter a CVV",
//         account_holder_name: "Please enter a Account Holder Name",
//     }
// });

</script>
      
@endsection
