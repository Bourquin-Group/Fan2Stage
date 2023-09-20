@include('admin.layouts.header')
@include('admin.layouts.sidebar')



<div class="content-wrapper">
    <!-- Dynamic Content !-->
    
       @yield('content')
</div>




@include('admin.layouts.footer')