<div class="tab-pane fade {{ (request()->is('web/billinginfo')) ? 'show active' : '' }}" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
    <div class="tab-heading arrow-align">
      <h1 class="font-28">Billing Information</h1>
    </div>
    

    {{-- @endif --}}
    <div class="profile-main profile-icon-flex">
        @if (Session::has('error1'))
        <div class="text-danger text-center">{{ Session::get('error1') }}</div>
        @endif
      {{-- <form method="post" action="{{url('web/billinginformation')}}"  enctype="multipart/form-data">
        @csrf --}}
      <div class="profile-inform billing-form">
        <div class="first-column">
          <div class="form-section">
            <div class="label-sec">
              <label for="">Address*</label>
              <span class="edit-text-1">{{(isset($getbillinfo['address'])) ? $getbillinfo['address']: ''}}</span>
              <input
                class="edit-input-1"
                type="text"
                name="address"
                id=""
                placeholder="Enter Address"
                value="{{old('address')?old('address'):((isset($getbillinfo['address'])) ? $getbillinfo['address']: '')}}"
              />
                <span class="error_msg" id="address1"></span><br>
            </div>
          </div>
        </div>
        <div class="first-column">
          <div class="form-section">
            <div class="label-sec">
              <label for="">city*</label>
              <span class="edit-text-1">{{(isset($getbillinfo['city'])) ? $getbillinfo['city']: ''}}</span>
              <input
                class="edit-input-1"
                type="text"
                name="city"
                id=""
                placeholder="Enter City"
                value="{{old('city')?old('city'):((isset($getbillinfo['city'])) ? $getbillinfo['city']: '')}}"
              />
              <span class="error_msg" id="city1"></span><br>
            </div>
          </div>
          <div class="form-section">
            <div class="label-sec">
              <label for="">State*</label>
              <span class="edit-text-1">{{(isset($getbillinfo['state'])) ? $getbillinfo['state']: ''}}</span>
              <input
                class="edit-input-1"
                type="text"
                name="state"
                id=""
                placeholder="Enter state"
                value="{{old('state')?old('state'):((isset($getbillinfo['state'])) ? $getbillinfo['state']: '')}}"
              />
              <span class="error_msg" id="state1"></span><br>
            </div>
          </div>
        </div>
        <div class="first-column">
          <div class="form-section">
            <div class="label-sec">
              <label for="">Country*</label>
              <span class="edit-text-1">{{(isset($getbillinfo['country'])) ? $getbillinfo['country']: ''}}</span>
              <input
                class="edit-input-1"
                type="text"
                name="country"
                id=""
                placeholder="Enter Country"
                value="{{old('country')?old('country'):((isset($getbillinfo['country'])) ? $getbillinfo['country']: '')}}"
              />
              <span class="error_msg" id="country1"></span><br>
            </div>
          </div>
          <div class="form-section">
            <div class="label-sec">
              <label for="">Postal Code*</label>
              <span class="edit-text-1">{{(isset($getbillinfo['postalcode'])) ? $getbillinfo['postalcode']: ''}}</span>
              <input
                class="edit-input-1"
                type="text"
                name="postalcode"
                id=""
                maxlength="6"
                placeholder="Postal Code"
                value="{{old('postalcode')?old('postalcode'):((isset($getbillinfo['postalcode'])) ? $getbillinfo['postalcode']: '')}}"
              />
              <span class="error_msg" id="postalcode1"></span><br>
            </div>
          </div>
        </div>
      </div>
      <div class="arrow-align billing-align">
        <div class="edit-btn-1">
          <button type="button" class="font-16 page_moving" id="add-class">
            Edit Info
          </button>
        </div>
        <div class="edit-btn edit-btn-none-1">
          <button
            type="button"
            class="font-16  remove-class"
          >
            Cancel
          </button>
          <button type="submit" class="font-16 save-btn" id="billinginfo">
            Submit
          </button>
        </div>
      </div>
      {{-- </form> --}}
    </div>
  </div>