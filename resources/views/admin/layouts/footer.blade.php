 <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer text-center">
          All Rights Reserved by Fan2Stage. Designed and Developed by
          <a href="https://colaninfotech.com/">Colan Infotech</a>.
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
      </div>
      <!-- ============================================================== -->
      <!-- End Page wrapper  -->
      <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->

    <script src="{{ asset('assets/admin/libs/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/admin/extra-libs/DataTables/datatables.min.js') }}"></script>

    <script type="text/javascript">
        
        $( document ).ready(function() {
   
     $("#zero_config").DataTable();
});
    </script>

     <script src="{{ asset('assets/admin/libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/select2/dist/js/select2.min.js') }}"></script>
       <script type="text/javascript">
        
        $( document ).ready(function() {
   
     
     $(".select2").select2();
});</script>
@yield('script')

    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('assets/admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/perfect-scrollbar/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/extra-libs/sparkline/sparkline.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('assets/admin/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('assets/admin/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('assets/admin/js/custom.min.js') }}"></script>
    <!--This page JavaScript -->
    <!-- <script src="../dist/js/pages/dashboards/dashboard1.js"></script> -->
    <!-- Charts js Files -->
    <script src="{{ asset('assets/admin/libs/flot/excanvas.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/flot/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/flot/jquery.flot.crosshair.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/flot.tooltip/js/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('assets/admin/extra-libs/multicheck/datatable-checkbox-init.js') }}"></script>
    <script src="{{ asset('assets/admin/extra-libs/multicheck/jquery.multicheck.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/chart/chart-page-init.js') }}"></script>

      <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('assets/admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('assets/admin/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/extra-libs/sparkline/sparkline.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('assets/admin/js/waves.js') }}"></script>

    @yield('eventcreate')
    @yield('eventupdate')
    <script>
      $(document).ready(function() {
    // Close the success alert after 5 seconds (adjust the duration as needed)
    setTimeout(function() {
        $('#successAlert').alert('close');
    }, 5000);
});
    </script>
  </body>
</html>
