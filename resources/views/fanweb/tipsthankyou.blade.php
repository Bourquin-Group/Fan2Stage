@extends('fanweb.layouts.main')
@section('header')
<style>
      /* .custom_container{
        text-align: center;
    margin-top: 4%;
    padding: 9%;
      } */
</style>
@endsection
@section('content')
<section class="main_section"> 
    <div class="custom_container">
        <h2>@if(session()->has('paymentsuccess'))
            <span class="text-success" style="font-size:30px;margin:auto;display: block;
            width: 100%;
            text-align: center;
            margin-top: 30px !important;">{{session('paymentsuccess')}}</span>
        @endif</h2>
    </div>
</section>
@endsection
