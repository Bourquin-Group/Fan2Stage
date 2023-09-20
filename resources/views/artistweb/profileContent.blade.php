@extends('artistweb.layouts.main')
@section('body')
<section class="main_section">     
    <div class="custom_container">
        <div class="d-flex align-items-start res-flex-wrap">
            @include('artistweb.layouts.sidebar')
            <div class="tab-content col-lg-9 col-md-12 col-sm-12 col-xs-12 {{ (isset($errors)) ? 'edit-input-filed' : '' }}" id="v-pills-tabContent ">
                @include('artistweb.quicklinks.myprofile')
            </div>
        </div>
    </div>
@endsection