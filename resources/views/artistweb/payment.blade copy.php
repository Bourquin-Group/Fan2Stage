@extends('artistweb.layouts.main')
@section('header')
<style>
.error {
    color: red!important;
}
</style>
@endsection
@section('body')
<section class="main_section">     
    <div class="custom_container">
        <div class="d-flex align-items-start res-flex-wrap">
            @include('artistweb.layouts.sidebar')
            <div class="tab-content col-lg-9 col-md-12 col-sm-12 col-xs-12" id="v-pills-tabContent ">
                <div class="tab-pane fade {{ (request()->is('web/subscription-payment/*')) ? 'show active' : '' }}" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">
                    <div class="tab-heading">
                        <h1 class="font-28">Subscriptions </h1>
                    </div>

                    <p class="alert alert-success" id="success_msg"></p>
                    <p class="alert alert-danger" id="failer_msg"></p>
                   
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
                                   <input type="hidden" id="stripeToken" name="stripeToken">
                                   
                                    <div class="billinginfo">
                                        <div class="form-section">
                                            <label for="first_name">First Name</label>
                                            <input type="text"  name="first_name" id="first_name" placeholder="First Name" value="">
                                            <span class="error" id="first_name_error"></span>
                                        </div>
                                        <div class="form-section">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" placeholder="Last Name" name="last_name" id="last_name" value="">
                                            <span class="error" id="last_name_error"></span>
                                        </div>
                                        </div>
                                        <div class="form-section">
                                        <label for="">Email</label>
                                        <input type="text" placeholder="Enter Email"  id="email"  name="email">
                                        <span class="error" id="email_error"></span>
                                        </div>
                                        <div class="form-section">
                                        <label for="">Address line </label>
                                        <input type="text" placeholder="Enter address"   id="address"  name="address" >
                                        <span class="error" id="address_error"></span>
                                        </div>
                                        <div class="billinginfo">
                                        <div class="form-section">
                                            <label for="city">City</label>
                                            <input type="text" name="city"  id="city"  placeholder="Enter City" >
                                            <span class="error" id="city_error"></span>
                                        </div>
                                        <div class="form-section">
                                            <label for="state">State</label>
                                            <select name="state"  id="state">
                                            <option value="11 AM" >Select State</option>
                                            <option value="11 AM">Select State</option>
                                            </select>
                                            <span class="error" id="state_error"></span>
                                        </div>
                                        </div>
                                        <div class="billinginfo">
                                        <div class="form-section">
                                            <label for="">Country</label>
                                            <input type="text" name="country" id="country" placeholder="Enter Country" >
                                            <span class="error" id="country_error"></span>
                                        </div>
                                        <div class="form-section">
                                            <label for="">Postal Code</label>
                                            <input type="text" name="postal_code" id="postal_code" placeholder="Enter Postal code" >
                                            <span class="error" id="postal_code_error"></span>
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
                                        <input type="text"  id="card" autocomplete='off' class='form-control card-number' placeholder="Enter card number"  name="card" >
                                        <span  class="error" id="card_error"></span>
                                        </div>
                                        <div class="billinginfo row">
                                        <div class="form-section col-md-3">
                                            <label for="month">Month</label>
                                            <input type="number" maxlength="2"  id="month" minlength="2" name="month"  class='form-control card-expiry-month' placeholder="MM" value="">
                                            <span class="error" id="month_error"></span>
                                        </div>
                                        <div class="form-section col-md-3">
                                            <label for="year">Year</label>
                                            <input type="number" maxlength="4" minlength="4" name="year"  id="year" placeholder="YYYY"  class='form-control card-expiry-year' value="">
                                            <span class="error" id="year_error"></span>
                                        </div>
                                        </div>
                                        <div class="billinginfo">
                                        <div class="form-section">
                                            <label for="">CVV</label>
                                            <input type="text" placeholder="(Eg). 123" name="cvv" id="cvv"  autocomplete='off'
                                          class='form-control card-cvc'>
                                          <span class="error" id="cvv_error"></span>
                                        </div>
                                        </div>
                                        <div class="form-section">
                                        <label for="">Account Holders Name</label>
                                        <input type="text" placeholder="Type Name" id="account_holder_name" name="account_holder_name">
                                        <span class="error" id="account_holder_name_error"></span>
                                        </div>
                                        <div class="button_gorup">
                                        <button><a href="#">Cancel</a> </button>
                                        <button  type="button"  id="paynow"> Pay Now</button>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/css/screen.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">

    $(function() {

    $('#success_msg').hide();
    $('#failer_msg').hide();
       

    function stripeResponseHandler(status, response) {
      if (response.error) {
        $('#failer_msg').html(response.error.message);
      } else {
          /* token contains id, last4, and card type */
          var token = response['id'];
          $('#stripeToken').val(token);
      }
    }

        $("#paynow").click(function(){
           var first_name  =  $('#first_name').val();
           var last_name  =  $('#last_name').val();
           var email = $('#email').val();
           var address = $('#address').val();
           var city = $('#city').val();
           var state = $('#state').val();
           var country = $('#country').val();
           var postal_code = $('#postal_code').val();
           var card =  $('#card').val();
           var month =  $('#month').val();
           var year =  $('#year').val();
           var cvv  =  $('#cvv').val();
           var account_holder_name  =  $('#account_holder_name').val();
            var validation  =0;
           if(first_name == '')
           {
            validation =1;
            $('#first_name_error').html('Please enter a First Name');
           }

           if(last_name == '')
           {
            validation =1;
            $('#last_name_error').html('Please enter a Last Name');
           }
           if(email == '')
           {
            validation =1;
            $('#email_error').html('Please enter a Email');
           }
           if(address == '')
           {
            validation =1;
            $('#address_error').html('Please enter a Address');
           }

           if(city == '')
           {
            validation =1;
            $('#city_error').html('Please enter a City');
           }

           if(state == '')
           {
            validation =1;
            $('#state_error').html('Please enter a State');
           }

           if(country == '')
           {
            validation =1;
            $('#country_error').html('Please enter a Country');
           }

           if(postal_code == '')
           {
            validation =1;
            $('#postal_code_error').html('Please enter a Postal Code');
           }

           if(card == '')
           {
            validation =1;
            $('#card_error').html('Please enter a Card');
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

           if(validation  ==0)
           {

            Stripe.setPublishableKey("{{ env('STRIPE_KEY') }}");
            var check =  Stripe.createToken({
                    number: card,
                    cvc: cvv,
                    exp_month: month,
                    exp_year: year
                    },stripeResponseHandler);
                    var form = $('#payment-form')[0];
                    var data = new FormData(form);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('subscription.post') }}",
                        data: data,
                        processData: false,
                        contentType: false,
                        cache: false,
                        async: false,
                        success: function (data) {
                            if(data.status ==500)
                            {
                                $('#failer_msg').html(data.msg);
                                $('#failer_msg').show();

                                window.setTimeout(function(){
                                    $('#success_msg').show();
                                    location.reload(true);

                                    }, 5000);

                                
                            }else
                            {
                                window.setTimeout(function(){
                                    $('#success_msg').show();
                                    // Move to a new location or you can do something else
                                    window.location.href = "web/subscription";

                                    }, 5000);
                            }
                          
                        }
                        
                    });
           }

         


           
        });

  
});

</script>
      
@endsection