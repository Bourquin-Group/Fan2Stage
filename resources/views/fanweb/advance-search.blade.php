@extends('fanweb.layouts.main')
@section('header')
<style>
    .modal-text
    {
        color:black;
    }

  
    .no-fav
    {
        text-align:center;
    }
    </style>
@endsection
@section('content')

<section class="main_section">
<div class="custom_container">
    <div class="navgat_otherpage flex-just">
        <h1 class="task_titlt artistsearchtitle">Search results for <span> “artists”</span> 
        </h1>
       
        @if(session()->has('success'))
                        <p class="alert alert-success">{{session('success')}}</p>
        @endif
                    
        @if (Session::has('error'))
                      <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <div class="filter-doted">
          <span data-bs-toggle="modal" href="#exampleModalToggle1" role="button">Filter</span>
            <div><img src="{{ asset('assets/fan/images/filter_svg.svg')}}" alt=""></div>
        </div>            
    </div>
<!-- Content -->       
<input type="hidden" name="ad_type" value="{{$request->ad_type}}" id="type">  
<input type="hidden" name="ad_genre_checkbox" value="{{$request->ad_genre_checkbox}}">  
<input type="hidden" name="ad_genre" value="{{$request->ad_genre}}">  
<input type="hidden" name="artist_id" id="artist_id">  


    <div class="followers_section artis-follower">
    @if(count($advanceSearch))
        @foreach($advanceSearch as $list)
        <a href="{{url('/fan/artistprofile/'.base64_encode($list['artist_id']))}}">
          <div class="followers_section_card bg_layout">
                {{--<img src="{{$list['profile_image']}}" alt="flow_profile">--}}
                @if(file_exists(public_path('/artist_profile_images/'.$list['profile_image_web'])) && isset($list['profile_image_web']))
                    <img src="{{asset('/artist_profile_images/'.$list['profile_image_web'])}}" alt="flow_profile" />
                @else
               <img src="{{ asset('artist_profile_images/profile1.jpeg')}}" alt="flow_profile" />
                @endif
                <h4 class="followers_name">{{$list['artist_name']}} <button class="font-16">{{$list['rating']}} <img src="{{asset('assets/fan/images/star 1.svg')}}" alt="" srcset=""></button></h4>
                <span class="font-14">{{$list['genre']}}</span>
                <div class="follow-heart @if($list['favourite_status']) searchheartactive @endif " onclick="favOption({{$list['artist_id']}},@if($list['favourite_status'])'remove'@else 'add'@endif)">
                    <img class="img-active" src="{{ asset('assets/fan/images/follow-heart.svg')}}" alt="">
                    <img class="img-inactive" src="{{ asset('assets/fan/images/follow-heart-hov.svg')}}" alt="">
                </div>
          </div>
        </a>
        @endforeach
        @else
           <p class="no-fav mt-3"> No Results Found </p>
        @endif
    </div>
 <!-- END -->
</div> 
</section>
<div id="myModal1d" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Modal header</h3>
    </div>
    <div class="modal-body">
        <p>One fine body…</p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button class="btn btn-primary">Save changes</button>
    </div>
</div>

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
      function favOption(id,type)
    {
       
        var text ='';
        if(type =="add")
        {
           text =" Do you want to add the artist in your favourites?";
        }else{
            text =" Do you want to remove artist from your favourites?";
        }
        $('#artist_id').val(id);
        $('#warning-text').html(text);
        $("#myModal1").modal('show');
    }
    $(document).ready(function(){
        $('#fav-update').click(function(){
            var ad_type = $('#type').val();
            var artist_id = $('#artist_id').val();
             $.ajax({
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                type:'POST',
                url:"{{ route('favoritesUpdate') }}",
                data:{artist_id:artist_id,ad_type:ad_type,type:2},
                success: function (data) {
                    location.reload();
                }
                 

            });
        })
  
})
</script>
@endsection