@extends('artistweb.layouts.main')
@section('header-script')

@endsection
@section('header')
<style>
label.error {
    color: red!important;
}
</style>
<style type="text/css">
        .panel-title {
        display: inline;
        font-weight: bold;
        }
        .display-table {
            display: table;
        }
        .display-tr {
            display: table-row;
        }
        .display-td {
            display: table-cell;
            vertical-align: middle;
            width: 61%;
        }
    </style>
@endsection
@section('body')
<section class="main_section">     
    <div class="custom_container">
        <div class="d-flex align-items-start res-flex-wrap">
            @include('artistweb.layouts.sidebar')
            <div class="tab-content col-lg-9 col-md-12 col-sm-12 col-xs-12" >
                <div class="tab-pane  {{ (request()->is('web/subscription-payment/*')) ? 'show active' : '' }}"  tabindex="0">
                    <div class="tab-heading">
                        <h1 class="font-28">Subscriptions </h1>
                    </div>
                    @if(session()->has('error'))
                        <p class="alert alert-danger">{{session('error')}}</p>
                    @endif
                    @if(session()->has('success'))
                        <p class="alert alert-success">{{session('success')}}</p>
                    @endif
                    <div class="profile-main  billinginfo_section ">
                <div class="plan_preview">
                  <div class="plan_preview_left">
                    <div class="plan_preview_section">
                      <h4>Subscription Preview</h4>
                      <p>Subscription preview details for the plan of “ Basic”</p>
                    </div>
                    <div class="plan_preview_price"><h1>$ {{$subscriptionplan->cost_value}}</h1></div>
                  </div>
                  <div class="plan_preview_right">
                    <div class="plan_preview_limit">
                      <p>Events Limit</p>
                      <h6>{{$subscriptionplan->events_per_month}} Events /  Month</h6>
                    </div>
                    <div class="plan_preview_limit">
                      <p>Fans Limit</p>
                      <h6>{{$subscriptionplan->fans_per_event}} Fans</h6>
                    </div>
                    <div class="plan_preview_change"><h2>
                      <a href="{{route('subscription')}}">  Change Plan <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
                      <path d="M1.5 11L6.5 6L1.5 1" stroke="#081A34" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg> </a>
                    </h2></div>
                  </div>
                </div>
                <div class="more_informstion">
                  <div class="billingInformation">
                    <h2 class="detail_header">Billing Information</h2>
                    <form method="post" action="{{route('subscription.post')}}"
                                        role="form" 
                                    action="{{ route('stripe.post') }}" 
                                    method="post" 
                                    class="require-validation"
                                    data-cc-on-file="false"
                                    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                    id="payment-form">
                                    @csrf() 
                                    <input type="hidden" value="{{$subscriptionplan->id}}" name="subscription_plan_id">
                                   <input type="hidden" value="1" name="type">
                                    <div class="billinginfo">
                                        <div class="form-section">
                                            <label for="first_name">First Name</label>
                                            <input type="text"  name="first_name" id="first_name" placeholder="First Name" value="">
                                        </div>
                                        <div class="form-section">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" placeholder="Last Name" name="last_name" id="last_name" value="">
                                        </div>
                                        </div>
                                        <div class="form-section">
                                        <label for="">Email</label>
                                        <input type="text" placeholder="Enter Email"  id="email"  name="email">
                                        </div>
                                        <div class="form-section">
                                        <label for="">Address line </label>
                                        <input type="text" placeholder="Enter address"   id="address"  name="address" >
                                        </div>
                                        <div class="billinginfo">
                                        <div class="form-section">
                                            <label for="city">City</label>
                                            <input type="text" name="city"  id="city"  placeholder="Enter City" >
                                        </div>
                                        <!-- <div class="form-section">
                                            <label for="state">State</label>
                                            <select name="state"  id="state">
                                            <option value="11 AM" >Select State</option>
                                            <option value="11 AM">Select State</option>
                                            </select>
                                        </div> -->
                                        </div>
                                        <div class="billinginfo">
                                        <div class="form-section">
                                            <label for="">Country</label>
                                            <input type="text" name="country" placeholder="Enter Country" >
                                        </div>
                                        <div class="form-section">
                                            <label for="">Postal Code</label>
                                            <input type="text" name="postal_code" placeholder="Enter Postal code" >
                                        </div>
                                        </div>
                                    </div>
                                    <div class="cardDetails">
                                        <h2 class="detail_header">Card Details</h2>
                                        <div class="card_img_section">
                                        <div class="card_list"><img src="{{asset('assets/images/Card_1.png')}}" alt=""></div>
                                        <div class="card_list"><img src="{{asset('assets/images/Card_2.png')}}" alt=""></div>
                                        <div class="card_list"><img src="{{asset('assets/images/Card_3.png')}}" alt=""></div>
                                        <div class="card_list"><img src="{{asset('assets/images/Card_4.png')}}" alt=""></div>
                                        </div>
                               
                                        <div class="form-section">
                                        <label for="">Card Number</label>
                                        <input type="text" autocomplete='off' id="card" class='form-control card-number' maxlength="19" placeholder="0000 0000 0000 0000"  name="card" >
                                        <label class="error" id="card_error"></label>
                                        @if($errors->has('card'))
                                        <label class="error">{{$errors->first('card')}}</label>
                                        @endif
                                        </div>
                                        <div class="billinginfo row">
                                        <div class="form-section col-md-3">
                                            <label for="month">Month</label>
                                            <input type="number" maxlength="2" minlength="2" name="month" id="month"  class='form-control card-expiry-month' placeholder="MM" value="">
                                            <label class="error" id="month_error"></label>
                                            @if($errors->has('month'))
                                            <label class="error">{{$errors->first('month')}}</label>
                                            @endif
                                        </div>
                                        <div class="form-section col-md-3">
                                            <label for="year">Year</label>
                                            <input type="number" maxlength="4" minlength="4" name="year" id="year"  placeholder="YYYY"  class='form-control card-expiry-year' value="">
                                            <label class="error" id="year_error"></label>
                                            @if($errors->has('year'))
                                            <label class="error">{{$errors->first('year')}}</label>
                                            @endif
                                        </div>
                                        </div>
                                        <div class="billinginfo">
                                        <div class="form-section">
                                            <label for="">CVV</label>
                                            <input type="text" placeholder="(Eg). 123" name="cvv"  id="cvv"   autocomplete='off'
                                          class='form-control card-cvc'>
                                          <label class="error" id="cvv_error"></label>
                                           @if($errors->has('cvv'))
                                            <label class="error">{{$errors->first('cvv')}}</label>
                                            @endif
                                        </div>
                                        </div>
                                        <div class="form-section">
                                        <label for="">Account Holders Name</label>
                                        <input type="text" placeholder="Type Name" id="account_holder_name" name="account_holder_name">
                                        <label class="error" id="account_holder_name_error"></label>
                                            @if($errors->has('account_holder_name'))
                                            <label class="error">{{$errors->first('account_holder_name')}}</label>
                                            @endif
                                        </div>
                                        <div class="button_gorup">
                                        <button><a href="{{url('web/subscription')}}">Cancel</a> </button>
                                        <button  type="submit"  > Pay Now</button>
                                    </div>
                    </form>  
                  </div>
                </div>
              </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    
@endsection
@section('script')

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
    //    console.log('submit');
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
        // var card += $(".credit").credit();
           var month =  $('#month').val();
           var year =  $('#year').val();
           var cvv  =  $('#cvv').val();
           var validation =0;
           var account_holder_name  =  $('#account_holder_name').val();
           
            if(card == '')
           {
            validation =1;
            $('#card_error').html('Please enter a Card Number');
           } else if(!numbers.test(card)){
            $('#card_error').html('Please enter only number');
           }
           else{
            $('#card_error').html('');
           }

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

           if(cvv == '')
           {
            validation =1;
            $('#cvv_error').html('Please enter a cvv');
           }

           if(account_holder_name == '')
           {
            validation =1;
            $('#account_holder_name_error').html('Please enter a Account Holder Name');
           }
           else if(!regex.test(account_holder_name)){
            $('#account_holder_name_error').html('Please enter only Alphabets');
           }else{
            $('#account_holder_name_error').html('');
           }
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
    var cvv  =  $('#cvv').val();
          var account_holder_name  =  $('#account_holder_name').val();
          if(account_holder_name != '' && cvv != '')
      
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
              }
       
              else {
           /* token contains id, last4, and card type */
           var token = response['id'];
              
           $form.find('input[type=text]').empty();
           $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
           $form.get(0).submit();
       }
   }
}
  
});
  $("#payment-form").validate({
    rules: {
        email: {
            required: true,
            email: true
        },
        first_name: "required",
        last_name: "required",
        email:"required",
        address:"required",
        city:"required",
        state:"required",
        country:"required",
        postal_code:"required",
        card:"required",
        month:"required",
        year:"required",
        cvv:"required",
        account_holder_name:"required",
    },
    messages: {
        email: {
            required: "Please enter your email",
            email: "Please enter a valid email address"
        },
        first_name: "Please enter a First Name",
        last_name: "Please enter a Last Name",
        address: "Please enter a Address Line",
        city: "Please enter a City",
        state: "Please enter a State",
        country: "Please enter a Country",
        postal_code: "Please enter a Postal Code",
        card: "Please enter a Card",
        month: "Please enter a Month",
        year: "Please enter a Year",
        cvv: "Please enter a CVV",
        account_holder_name: "Please enter a Account Holder Name",
    }
});
 $('#card').on('keypress change', function () {
                 $(this).val(function (index, value) {
                     return value.replace(/\W/gi, '').replace(/(.{4})/g, '$1 ');
                 });
            });
</script>
@endsection