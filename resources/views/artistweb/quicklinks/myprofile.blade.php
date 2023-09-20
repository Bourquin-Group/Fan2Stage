<div class="tab-pane fade {{ (request()->is('web/profile')) ? 'show active' : '' }}" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
    <div class="tab-heading arrow-align">
      <h1 class="font-28">Profile</h1>
      @if (session('successweb'))
        <div class="alert alert-success custom-success-box" style="background-color:#59a783 !important">
          <strong> {{ session('successweb') }} </strong>
        </div>
      @endif
      <div class="edit-btn1">
        <button type="button"class="font-16"><a href ="{{ url('web/editprofile') }}">Edit profile</a></button>
      </div>
    </div>
    <div class="profile-main">
          <div class="profile-inform"> 
            <div class="profile-banner_section">
              <div class="profile-banner">
                <div class="drop-zone drop-none">
                  <img src="{{(isset($a_profile['landing_page_image'])) ? $a_profile['landing_page_image']: ''}}" style="    object-fit: contain;
                  width: 100%;
                  height: 100%;object-position: top;" alt="">
                </div>
              </div>
              <div class="profile_img_main">
                <div class="drop-zone">
                  <img src="{{(isset($a_profile['profile_image'])) ? $a_profile['profile_image']: ''}}" alt="">
                </div>
              </div>
            </div>
              <h5 class="font-22">Basic Details</h5>
              {{-- @if(isset($a_profile) && $a_profile) --}}
              
              <div class="first-column">
                <div class="form-section">
                  <label for="">Name</label>
                  <span class="edit-text1">{{(isset($a_profile['name'])) ? $a_profile['name']: ''}}</span>
                </div>
                  
                <div class="form-section">
                  <label for="">Email Address</label>
                  <span class="edit-text1">{{(isset($a_profile['email'])) ? $a_profile['email']: ''}}</span>
                </div>
                  
                <div class="form-section">
                  <label for="">Mobile Number</label>
                  <span class="edit-text1">{{(isset($a_profile['phone'])) ? $a_profile['phone']: ''}}</span>
                </div>
              </div>
              <div class="first-column">
                <div class="form-section">
                  <label for="">Stage Name</label>
                  <span class="edit-text1">{{(isset($a_profile['stage_name'])) ? $a_profile['stage_name']: ''}}</span>
                </div>
                <div class="form-section">
                  <label for="">Genre</label>
                  <span class="edit-text1">{{(isset($a_profile['genre'])) ? $a_profile['genre']: ''}}</span>
                </div>
                <div class="form-section">
                  <label for="">Time Zone</label>
                  <span class="edit-text1">{{(isset($a_profile['timezone']['timezone'])) ? $a_profile['timezone']['timezone']: ''}}</span>
                </div>

                <div class="form-section">
                  <div class="check-box-section">
                    <input type="checkbox" name="dsname" {{(($a_profile['d_stagename'] != '') && ($a_profile['d_stagename'] != NULL)) ? 'checked': ''}} id="cus-box" readonly/>
                    <label class="font-16" for="cus-box ">Display Stage Name on Top</label>
                  </div>
                </div>
              </div>
              <div class="form-section">
                <label for="">Bio</label>
                <span class="edit-text1">{{(isset($a_profile['bio'])) ? $a_profile['bio']: ''}}</span>
              </div>
              <h5 class="font-22">Social Links</h5>

              <div class="first-column">
                  <div class="form-section">
                    <label for="">Facebook</label>
                    <div class="cpy-sec">
                      <span class="edit-text1">{{(isset($a_profile['facebook_link'])) ? $a_profile['facebook_link']: ''}}</span>
                    </div>
                  </div>
                  <div class="form-section">
                    <label for="">Instragram</label>
                    <div class="cpy-sec">
                      <span class="edit-text1">{{(isset($a_profile['instagram_link'])) ? $a_profile['instagram_link']: ''}}</span>
                    </div>
                  </div>
                  <div class="form-section">
                    <label for="">iTunes</label>
                    <div class="cpy-sec">
                      <span class="edit-text1">{{(isset($a_profile['itunes_link'])) ? $a_profile['itunes_link']: ''}}</span>
                    </div>
                  </div>
                  <div class="form-section">
                    <label for="">Youtube</label>
                    <div class="cpy-sec">
                      <span class="edit-text1">{{(isset($a_profile['youtube_link'])) ? $a_profile['youtube_link']: ''}}</span>
                    </div>
                  </div>
                  <div class="form-section">
                    <label for="">Website</label>
                    <div class="cpy-sec">
                         <span class="edit-text1">{{(isset($a_profile['website_link'])) ? $a_profile['website_link']: ''}}</span>
                     </div>
                  </div>
              </div>
            </form>
              {{-- @endif --}}
          </div>
    </div>
  </div>