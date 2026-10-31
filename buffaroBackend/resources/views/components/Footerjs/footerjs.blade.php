
  <script src="dashboard/vendor/jquery-3.2.1.min.js"></script>

<!--<script type="text/javascript" src="dashboard/assets/scripts/main.js"></script>-->

    <!--offline-->
   <!-- <script src="dashboard/offline/jquery.dataTables.min.js" ></script>
       <script src="dashboard/offline/dataTables.fixedHeader.min.js" ></script>
       <script src="dashboard/offline/dataTables.responsive.min.js" ></script>
       <script src="dashboard/offline/responsive.bootstrap.min.js" ></script>-->
       <!--offline-->


      <!-- <script src="dashboard/offline/socket.io.js"></script>-->

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>




<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Bootstrap JS-->

<!-- Datatable JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!--<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>>-->
<script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>

<script>

 lazyload();
  /*$(document).ready(function() {
    $('#example').DataTable();

} );*/
$(document).ready(function(){//initialization of popover
  $('[data-toggle="popover"]').popover();
});
$('.btn-group').click(function(evt){
console.log("done");
$('.btn-group .dropdown-menu').toggle();

});

</script>
