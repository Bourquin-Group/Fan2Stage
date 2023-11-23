

<div class="tab-list nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <h6 class="font-18">Fan2Stage And You</h6> 
     <a  href="{{route('editProfile')}}" class="font-18 nav-tab-btn {{ (request()->is('fan/edit-profile')) ? 'active' : '' }}" id="v-pills-home-tab"  type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">
         <img class="active-none" src="{{asset('/assets/images/user-hov-tab.svg')}}" alt="" srcset="">
         <img src="{{asset('/assets/images/user-tab.svg')}}" alt="" srcset="">
         <span>Profile</span>
     </a>
     <a class="font-18 nav-tab-btn" id="v-pills-home-tab"  type="button" role="tab" aria-controls="v-pills-home" aria-selected="true" data-bs-toggle="modal" data-bs-target="#upgradeartist"> 
         <img class="active-none" src="{{asset('/assets/images/user-hov-tab.svg')}}" alt="" srcset="">
         <img src="{{asset('/assets/images/user-tab.svg')}}" alt="" srcset="">
         <span>Upgrade to Artist</span>
     </a>
     <a  href="{{route('favorites')}}" class="font-18 nav-tab-btn {{ (request()->is('fan/favorites')) ? 'active' : '' }}" id="v-pills-fav-tabs"  type="button" role="tab" aria-controls="v-pills-fav" aria-selected="true">
         <img class="active-none" src="{{asset('/assets/fan/images/heart-hov-svg.svg')}}" alt="" srcset="">
         <img src="{{asset('/assets/fan/images/heart.svg')}}" alt="" srcset="">
         <span>Favorites </span>
     </a>
     <a  href="{{route('premium')}}"  class="font-18 nav-tab-btn {{ (request()->is('fan/premium')) ? 'active' : '' }}" id="v-pills-profile-tab" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">                                                 
          <img src="{{asset('/assets/images/sub-tab.svg')}}" alt="" srcset="">
          <img class="active-none" src="{{asset('/assets/images/sub-tab-hov.svg')}}" alt="" srcset="">
       <span>Go Ad Free Now</span>
     </a>
     {{-- <h6 class="font-18">Other</h6>  --}}

     <a  href="{{route('about')}}" class="font-18 nav-tab-btn {{ (request()->is('fan/about')) ? 'active' : '' }}" id="v-pills-disabled-tab" type="button" role="tab" aria-controls="v-pills-disabled" aria-selected="false" >                                                 
       <img src="{{asset('/assets/images/help-circle-tab.svg')}}" alt="" srcset="">  
       <img class="active-none" src="{{asset('/assets/images/help-circle-hov-tab.svg')}}" alt="" srcset="">                          
        <span>About</span>
     </a> 

     <a  href="{{route('term')}}" class="font-18 nav-tab-btn {{ (request()->is('fan/term')) ? 'active' : '' }}" id="v-pills-messages-tab" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">                                                 
          <img src="{{asset('/assets/images/terms-and-conditions-tab.svg')}} " alt="" srcset="">  
          <img class="active-none" src="{{asset('/assets/images/terms-and-conditions-tab-hov.svg')}}" alt="" srcset="">
       <span>Terms and Conditions</span>
     </a>

     <a  href="{{route('privacy')}}" class="font-18 nav-tab-btn {{ (request()->is('fan/privacy')) ? 'active' : '' }}" id="v-pills-settings-tab"  type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">                       
         <img src="{{asset('/assets/images/shield-tab.svg')}}" alt="" srcset=""> 
         <img class="active-none" src="{{asset('/assets/images/shield-hov-tab.svg')}}" alt="" srcset="">
         <span>Privacy Policy</span>
     </a>
 </button>
     <button class="font-18 nav-tab-btn"type="button">
         <a href="{{route('logout')}}"  class="img-icon"><img src="{{asset('/assets/images/logout-tab.svg')}}" alt="" srcset=""><span>Logout</span></a>
     </button>
 </div> 


 <div class="modal fade rating-pop-up" id="upgradeartist" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title font-22" id="exampleModalLabel">Do you want to upgrade to Artist ?</h5>
           <button type="button" class="btn-close top-pos" data-bs-dismiss="modal" aria-label="Close" id="timezone_no"></button>
         </div>
         <div class="modal-footer premium-footer">
                 <button type="button" class="btn go-btn ms-0" id="upgrade_artist">Yes</button>
             <button type="button" class="btn go-btn ms-0" data-bs-dismiss="modal">No</button>
         </div>
       </div>
     </div>
 </div>


 <script>
     toastr.options = {
         "closeButton": true,
         "newestOnTop": true,
         "positionClass": "toast-top-right"
         };
     if(localStorage.getItem("upgradetype"))
     {
     toastr.success("Upgrade to artist successfully");
         localStorage.clear();
     }
      $(document).on("click", "#upgrade_artist", function (e) {
         e.preventDefault();
         $.ajax({
             headers: {
                 'X-CSRF-Token': '{{ csrf_token() }}',
             },
             url: "{{route('upgradeartist') }}",
         
             type: 'GET',
             success: function (data) {
                 $("#upgradeartist").modal('hide');
                 localStorage.setItem("upgradetype",data['message']);
                 location.reload();
             },
         });
     });
 </script>