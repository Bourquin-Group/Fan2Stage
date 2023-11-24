@extends('fanweb.layouts.main')
@section('header')
<style>
    .no-fav
    {
        text-align:center;
    }
    </style>
@endsection
@section('content')
<section class="main_section">
        <div class="custom_container">
            <div class="row d-flex align-items-start res-flex-wrap">
                <div class="col-lg-3 col-md-12 col-sm-12 tab-navbar">
                   <h1 class="font-28">Quick Links</h1>
                    @include('fanweb.profile.side-menu')               
                </div>
                <div class="tab-content col-lg-9 col-md-12 col-sm-12 col-xs-12 profiletab-wrapper " id="v-pills-tabContent ">
                  <!-- Myprofile -->
                 
                  <!-- END -->
                   
                  <!-- Fav -->

                  <div class="tab-pane fade show active" id="v-pills-fav" role="tabpanel" aria-labelledby="v-pills-fav-tab" tabindex="0">
                    <div class="tab-heading">
                      <h1 class="font-28">Favorites</h1>
                    </div>
                    <div class="fav-colunm first-column">
                      @if(count($favorties))
                      @foreach($favorties as $list)
                      <div style="position: relative">
                      <a href="{{url('/fan/artistprofile/'.base64_encode($list['artist_id']))}}">
                        <div class="fav-list-card">
                            @if(file_exists($list['artist_profile']) && isset($list['artist_profile']))
                              <img src="{{$list['artist_profile']}}" alt="" srcset="">
                            @else
                            <img src="{{ asset('artist_profile_images/profile1.jpeg')}}" alt="profile" />
                            @endif
                            <div class="artists-detalis">
                              <h6 class="font-18">{{$list['artist_name']}}</h6>
                              <p class="font-14"> {{$list['genre']}}</p>
                              <span>{{$list['rating']}} <img src="{{asset('/assets/fan/images/artists_card_star.svg')}}" alt="" srcset=""></span>
                            </div>
                        </div>
                     </a>
                     <img class="close-icon" src="{{asset('/assets/fan/images/artists-close.svg')}}" alt=""  onclick="favOption({{$list['artist_id']}})" srcset="" >
                    </div>
                      @endforeach
                      @else
                      <p class="no-fav mt-3"> No Favorites </p>

                      @endif
                      
                    </div>
                    </div>                                
                  </div>

                  <!-- END -->

                  
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
                    <button type="button" class="btn skip-bth model-no" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn go-btn ms-0 model-yes"  id="fav-update">Yes</button>
                    </div>
                </div>
      </div>
</div>  
@endsection
@section('footer')
<script>
    function favOption(id)
    {
        var text =" Do you want to remove artist from your favourites?";
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
            var artist_id = $('#artist_id').val();
             $.ajax({
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                type:'POST',
                url:"{{ route('favoritesUpdate') }}",
                data:{artist_id:artist_id,type:1},
                success: function (data) {
                    if(data.favourite == 'fill'){
                    localStorage.setItem("favouriteadd","Favourites Added Successfully");
                  }else{
                    localStorage.setItem("favouriteremove","Favourites removed Successfully");
                  }
                    location.reload();
                }
                 

            });
        })
  
})
</script>    
@endsection