@extends('admin.layouts.master')

@section('content')
<div class="page-wrapper">
<!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Subscription Plan Management</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Subscription Plan
                    </li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
          <!-- ============================================================== -->
          <!-- Start Page Content -->
          <!-- ============================================================== -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <form class="form-horizontal" method="post" action="{{url('/admin/subscriptionplanstore')}}">
                  @csrf
                  <div class="card-body">
                   <!--  <h4 class="card-title">Add</h4> -->
                    <div class="form-group row">
                      <label
                        for="f2s_plan"
                        class="col-sm-2 text-end control-label col-form-label"
                        >F2S Plan<span class="text-danger">*</span></label
                      >
                      <div class="col-sm-5">
                        <input name="f2s_plan" value="{{old('f2s_plan')}}"
                          type="text"
                          class="form-control @error('f2s_plan') is-invalid @enderror"
                          id="f2s_plan"
                          placeholder="Enter The F2S Plan"
                        />
                        @error('f2s_plan')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group row">
                      <label
                        for="fans_per_event"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Fans Per Event<span class="text-danger">*</span></label
                      >
                      <div class="col-sm-5">
                        <input name="fans_per_event" value="{{old('fans_per_event')}}"
                          type="text"
                          class="form-control @error('fans_per_event') is-invalid @enderror"
                          id="fans_per_event"
                          placeholder="Enter The Fans Per Event"
                        />
                        @error('fans_per_event')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>

                      <div class="form-group row">
                      <label
                        for="events_per_month"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Events Per Month<span class="text-danger">*</span></label
                      >
                      <div class="col-sm-5">
                       <input name="events_per_month" value="{{old('events_per_month')}}"
                          type="text"
                          class="form-control @error('events_per_month') is-invalid @enderror"
                          id="events_per_month"
                          placeholder="Enter The Events Per Month"
                        />
                        @error('events_per_month')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>



                    <div class="form-group row">
                      <label
                        for="push_notification"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Push Notification<span class="text-danger">*</span></label
                      >
                      <div class="col-sm-5">
                        <select name="push_notification" id="push_notification"
                        class="select2 form-select shadow-none @error('push_notification') is-invalid @enderror"
                        style="width: 100%; height: 36px"
                      >
                        <option value="">Select Your Push Notification</option>
                        <option value="no">No</option>
                        <option value="per_event">Per Event</option>
                        <option value="per_event_plus_30_marketing_notification"> Per Event + 30 Marketing Notification</option>
                       <option value="yes_plus_drip_marketing">Yes + Drip Marketing</option>
                      </select>
                        @error('push_notification')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>


                    </div>
                     <div class="form-group row">
                      <label
                        for="favorite_link"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Favorite Link<span class="text-danger">*</span></label
                      >
                      <div class="col-sm-5">
                        <select name="favorite_link" id="favorite_link"
                        class="select2 form-select shadow-none @error('favorite_link') is-invalid @enderror"
                        style="width: 100%; height: 36px"
                      >
                        <option value="">Select Your Favorite Link</option>
                         
                        <option value="yes" {{old('favorite_link')=='yes'?'selected':''}}>yes</option>
                          
                        <option value="yes_plus+auto_link_from_website" {{old('favorite_link')=='yes_plus+auto_link_from_website'?'selected':''}}>Yes + Auto Link From Website</option>
                       
                      </select>
                        @error('favorite_link')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group row">
                      <label
                        for="cost"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Cost<span class="text-danger">*</span></label
                      > <br>
                      <div class="col-sm-5">
                      <input type="radio" id="free" name="cost" value="free" class="@error('anual_plan') is-invalid @enderror">
                      <label for="free">Free</label><br>

                      <input type="radio" id="permonth" name="cost" value="permonth">
                      <label for="permonth">Per Month</label><br>
                     
                    <input type="radio" id="callforquoate" name="cost" value="call for quoate">
                      <label for="callforquoate">Call For a Quoate</label> 
                     
                        @error('cost')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>


                    <div class="form-group row cast_value"  {{ ($errors->isEmpty('cost_value'))?'style="display:block"':'style="display:none" '}}>
                      <label
                        for="cost_value"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Cost Value<span class="text-danger">*</span></label
                      >
                      <div class="col-sm-5">
                       <input name="cost_value" value="{{old('cost_value')}}"
                          type="text"
                          class="form-control @error('cost_value') is-invalid @enderror"
                          id="cost_value"
                          placeholder="Enter The Cost Value"
                        />
                        @error('cost_value')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group row">
                      <label
                        for="anual_plan"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Anual Plan<span class="text-danger">*</span></label
                      >
                      <div class="col-sm-5">
                        <select name="anual_plan" id="anual_plan"
                        class="select2 form-select shadow-none @error('anual_plan') is-invalid @enderror"
                        style="width: 100%; height: 36px"
                      >
                        <option value="">Select Your Anual Plan</option>
                        <option value="no">No</option>
                        <option value="yes 1 month free">Yes 1 Month Fee</option>
                        <option value="yes 2 month free">Yes 2 Month Fee</option>
                        <option value="yes 3 month free">Yes 3 Month Fee</option>
                        
                       anual_plan
                      </select>
                        @error('anual_plan')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>


                    <div class="form-group row">
                      <label
                        for="hardware_required"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Hardware Required<span class="text-danger">*</span></label
                      >
                      <div class="col-sm-5">
                      <input type="checkbox" id="hardware_required1" name="hardware_required[]" value="Laptop" class="@error('anual_plan') is-invalid @enderror">
                      <label for="Labtop"> Labtop</label><br>

                      <input type="checkbox" id="hardware_required2" name="hardware_required[]" value="desktop with speaker">
                      <label for="vehicle2"> Desktop With Speaker</label><br>

                      <input type="checkbox" id="hardware_required3" name="hardware_required[]" value="fan2stage server">
                      <label for="vehicle3"> Fan 2 Stage Server</label><br>

                      <input type="checkbox" id="hardware_required4" name="hardware_required[]" value="amp desc with xlr inputs">
                      <label for="vehicle3"> Amp Desc With XLR Inputs</label><br>

                        @error('hardware_required')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>

               
                  </div>
                  <div class="border-top">
                    <div class="card-body">
                      <button type="submit" class="btn btn-primary">
                        Submit
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              </div>
            </div> 
          </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
         </div>
   
@endsection

@section('script')
<script type="text/javascript">
 $( document ).ready(function() {

$('input[type=radio][name=cost]').change(function(){
  //alert('test');
if($(this).val()=='permonth')
  $('.cast_value').show();
else
  $('.cast_value').hide();

})
  });
</script>
@endsection