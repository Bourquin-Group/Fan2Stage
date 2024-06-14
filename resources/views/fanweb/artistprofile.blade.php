@extends('fanweb.layouts.main')
@section('header')
<style>
    .modal-text
    {
        color:black;
    }
    .ms-0
    {
        background:#C2285C;
    }
    </style>
@endsection
@section('content')
<h1 class="font-28 navgatePage custom_container"><a href="{{route('fanhome')}}"><img src="{{asset('/assets/fan/images/arrow-left.svg')}}" alt="arrow"></a>Artist Profile</h1>
    <section class="main_section">
        <div class="home_banner">
          <img src="{{(isset($profile['landing_page_image']))? $profile['landing_page_image'] : asset('/assets/fan/images/boo-svg.svg')}}" alt="bg" />
  
        </div>
        <div class="inner_main_section custom_container d-flex">
            <div class=" section_profile">
               
                <div class="profile_card">
                    <div class="profile_img_section">
                      <div class="profile-img-wrapper">
                      <img
                        class="profile_img"
                        src="{{(isset($profile['profile_image'])) ? $profile['profile_image']:asset('/assets/fan/images/boo-svg.svg')}}"
                        alt="profile"
                      />
                      <div class="@if($profile['favourite_status'])profile-img-red-heart @else profile-img-heart @endif"   onclick="favOption({{$profile['artist_id']}},@if($profile['favourite_status'])'remove'@else 'add'@endif)"> 
                      <img src="{{asset('/assets/fan/images/white-heart.svg')}}" alt=""> 
                      </div>
                      </div>
                      @if($profile['d_stagename'] == 'on')
                      <p>{{(isset($profile['stage_name'])) ? $profile['stage_name'] : '-'}}</p>
                      <h2>{{(isset($profile['name'])) ? $profile['name'] : '-'}}</h2>
                      @else
                      <h2>{{(isset($profile['name'])) ? $profile['name'] : '-'}}</h2>
                      <p>{{(isset($profile['stage_name'])) ? $profile['stage_name'] : '-'}}</p>
                      @endif
                      <p class="Followers_part">@if($profile['followers'] != 0){{ $profile['followers']}} Followers @else<span>No Followers Yet</span> @endif</p>
                    </div>
                    <div class="profile_section_inner">
                      <div class="profilr_part_section">
                        <h6 class="sub_header">Bio:</h6>
                        <p>
                            {{substr_replace($profile['bio'],"...", 120)}}
                        </p>
                      </div>
                      <div class="profilr_part_section">
                        <h6 class="sub_header">Genre:</h6>
                        <p>{{$profile['genre']}}</p>
                      </div>
                      <div class="profilr_part_section">
                        <h6 class="sub_header">Social Links :</h6>
          
                        <div class="social_icon">
                            @if($profile['facebook_link'])
                            <a href="https://{{$profile['facebook_link']}}" target="_blank"><span class="face_book"></span></a>
                            @else
                            <a><span class="face_book"></span></a>
                            @endif
                            @if($profile['instagram_link'])
                            <a href="https://{{ $profile['instagram_link']}}"  target="_blank"><span class="instagram"></span></a>
                            @else
                            <a><span class="instagram"></span></a>
                            @endif
                            @if($profile['itunes_link'])
                            <a href="https://{{ $profile['itunes_link']}}" target="_blank" ><span class="itnes"></span></a>
                            @else
                            <a><span class="itnes"></span></a>
                            @endif
                            @if($profile['youtube_link'])
                            <a href="https://{{ $profile['youtube_link']}}" target="_blank"><span class="youtube"></span></a>
                            @else
                            <a><span class="youtube"></span></a>
                            @endif
                            @if($profile['website_link'])
                            <a href="https://{{ $profile['website_link']}}" target="_blank"><span class="world"></span></a>
                            @else
                            <a><span class="world"></span></a>
                            @endif
                        </div>
                      </div>
          
                    </div>
                  </div>
            </div>
         
          <div class="event_list_section">
            <div class="event_list_section_tab">
                <ul class="nav nav-pills " id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button
                        class="nav-link active"
                        id="pills-home-tab"
                        data-bs-toggle="pill"
                        data-bs-target="#pills-home"
                        type="button"
                        role="tab"
                        aria-controls="pills-home"
                        aria-selected="true"
                      >
                      Live Events
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button
                        class="nav-link"
                        id="pills-profile-tab"
                        data-bs-toggle="pill"
                        data-bs-target="#pills-profile"
                        type="button"
                        role="tab"
                        aria-controls="pills-profile"
                        aria-selected="false"
                      >
                      Scheduled Events
                      </button>
                    </li>
                  </ul>
            </div>

            <div class="tab-content p-0" id="pills-tabContent">
              <div
                class="tab-pane fade show active"
                id="pills-home"
                role="tabpanel"
                aria-labelledby="pills-home-tab"
                tabindex="0"
              >
                <div class="event_tabe_section">
                  {{-- <a href="./Event-Detail.html"> --}}
                    @if(count($live_event) > 0 )
                    @foreach($live_event as $l_event)
                    <div class="event_card">
                      <img src="{{$l_event['image']}}" alt="card" />
                      <div class="today_btn"><button>Live</button></div>
                      <div class="event_card_bottom">
                        <div class="event_card_bottom_left">
                          <h3>{{$l_event['event_title']}}</h3>
                          <?php
                                $date = DateTime::createFromFormat('H:i:s',$l_event['time']);
                                $date->modify('+'.$l_event['duration'].' minutes');
                            ?>
                            <p>{{date("g A", strtotime($l_event['time']." UTC"))}} - {{$date->format('h:i A')}}</p>
                        </div>
                        <div class="event_card_bottom_right">
                          <a href="{{route('live-event',base64_encode($l_event['event_id']))}}"><button>Join Now</button></a>
                        </div>
                      </div>
                    </div>
                    @endforeach
                    @else
                      <p>"No Live Events Found"</p>
                    @endif
                   {{-- </a> --}}
                </div>
              </div>
              <div
                class="tab-pane fade"
                id="pills-profile"
                role="tabpanel"
                aria-labelledby="pills-profile-tab"
                tabindex="0"
              >
              <div class="event_tabe_section">
                @if(count($sceduled_event) > 0 )
                @foreach($sceduled_event as $sc_event)
                <div class="event_card">
                  <img src="{{$sc_event['image']}}" alt="card" />
                  <div class="today_btn"></div>
                  <div class="event_card_bottom">
                    <div class="event_card_bottom_left">
                      <h3>{{$sc_event['event_title']}}</h3>
                      <?php
                      $date = DateTime::createFromFormat('H:i:s',$sc_event['time']);
                      $date->modify('+'.$sc_event['duration'].' minutes');
                    ?>
                      <p>{{date("g A", strtotime($sc_event['time']." UTC"))}} - {{$date->format('h:i A')}}</p>
                    </div>
                    <div class="event_card_bottom_right">
                      <button>
                        @if($sc_event['booking_status'] == 'true')
                        <a href="{{route('scheduled-event',base64_encode($sc_event['event_id']))}}">Booked</a>
                        @else
                        <a href="{{route('scheduled-event',base64_encode($sc_event['event_id']))}}"> Book Now</a> 
                        @endif
                    </button>
                    </div>
                  </div>
                </div>
                @endforeach
                @else
                <p>"No Scheduled Events Found"</p>
                @endif
              </div>
            </div>
            </div>
          </div>
        </div>
      </section>
      <input type="hidden" name="artist_id" id="artist_id">  
      <div class="modal fade can-book-pop-up" id="myModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <img src="{{asset('/assets/fan/images/cancel-img.png')}}" alt="" srcset="">
                    <h5 class="modal-title font-20"  id="warning-text">Are you sure you want to cancel this event?</h5>
                    <button type="button" class="btn-close top-pos" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn skip-bth  model-no" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn go-btn ms-0  model-yes"  id="fav-update">Yes</button>
                    </div>
                </div>
      </div>
</div>  
@endsection
@section('footer')

<script>
       function favOption(id,type)
    {
       
        var text ='';
        if(type =="add")
        {
           text =" Do you want to add the artist in your favourites?";
        }else{
            text =" Do you want to remove artist from your favourites?";
        }
        $('#warning-text').html(text);
        $('#artist_id').val(id);
        $("#myModal1").modal('show');
    }
    $(document).ready(function(){
      toastr.options = {
          "closeButton": true,
          "newestOnTop": true,
          "positionClass": "toast-top-right"
        };
      if(localStorage.getItem("favouriteadd"))
    {
      toastr.success("Favourites Added Successfully");
        localStorage.clear();
    }
      if(localStorage.getItem("favouriteremove"))
    {
      toastr.error("Favourites Removed Successfully");
        localStorage.clear();
    }
        $('#fav-update').click(function(){

          toastr.options = {
          "closeButton": true,
          "newestOnTop": true,
          "positionClass": "toast-top-right"
        };

            var ad_type = $('#type').val();
            var artist_id = $('#artist_id').val();
             $.ajax({
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                type:'POST',
                url:"{{ route('favoritesUpdate') }}",
                data:{artist_id:artist_id,type:1},
                success: function (data) {
                  console.log(data);
                  if(data.favourite == 'fill'){
                    localStorage.setItem("favouriteadd","Favourites Added Successfully");
                  }else{
                    localStorage.setItem("favouriteremove","Favourites removed Successfully");
                  }
                  location.reload();
                  // localStorage.setItem("favourite","Favourites Added Successfully");
                  // toastr.success("Favourites Added Successfully");
                }
                 

            });
        })
  
})
</script>

@endsection