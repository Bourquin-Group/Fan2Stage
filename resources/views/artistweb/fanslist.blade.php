@extends('artistweb.layouts.main')
@section('body')
<section class="main_section custom_container">
    <div class="navgat_otherpage">
        <h1 class="task_titlt"><a href="{{ url()->previous() }}"><span><img src="{{ asset('assets/web/images/arrow-left.svg') }}" alt="arrow"></span></a> Fans List</h1>
    </div>
  <!-- content  -->
  <div class="followers_section">
    @if(count($fanslist) > 0)
    @foreach($fanslist as $f_list )
    <div class="followers_section_card bg_layout">
      @if(file_exists(public_path('/fans_profile_images/'.$f_list['image'])) && isset($f_list['image']))
      <img src="{{ asset('fans_profile_images/'.$f_list['image']) }}" alt="flow_profile">
      @else
          <img src="{{ asset('artist_profile_images/profile1.jpeg')}}" alt="profile" />
      @endif
        
        <h4 class="followers_name">{{$f_list['name']}}</h4>
    </div>
    @endforeach
    @else
    <div class="followers_section_card bg_layout" style="position: relative;
    aspect-ratio: 1;
    padding: 20px;
    display: flex;
    align-items: stretch;
    z-index: 4;
    justify-content: center;">
        <h4 class="task_titlt">No Fans List <span style="font-weight: bold">{{Auth::user()->name}}</span>!!</h4>
    </div>
    @endif
  </div>
</section>
@endsection