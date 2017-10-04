<!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.3.8
    </div>
    <strong>Copyright &copy; 2017 <a href="http://almsaeedstudio.com"> Receptio</a>.</strong> All rights
    reserved.
  </footer>

  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->




<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url(); ?>asset/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->





<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url(); ?>asset/bootstrap/js/bootstrap.min.js"></script>





<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?php echo base_url(); ?>asset/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url(); ?>asset/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo base_url(); ?>asset/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url(); ?>asset/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>asset/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?php echo base_url(); ?>asset/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url(); ?>asset/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url(); ?>asset/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>


<!-- DataTables -->
<script src="<?php echo base_url(); ?>asset/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.bootstrap.min.js"></script>

<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>




<script type="text/javascript">

	<!--for the modal that shows up when an agreement is saved
    $(window).on('load',function(){
        $('#myModal').modal('show');
		setTimeout(function(){$('#myModal').modal('hide')},2000);
    });
	
	/*$(window).on('load',function(){
        $('#myModal2').modal('show');
		setTimeout(function(){$('#myModal2').modal('hide')},2000);
    });*/
</script>


<script>

	//for group head change
 $(document).ready(function(){
  $('#group_head').click(function(e){
   //if(this.checked){
   var selTable = $(this).val(); // selected name from dropdown #table
   var gn = $('#group_name').val();

   //var group_id2 = $('#group_id').val();
   $.ajax({
    url: "<?php echo site_url(); ?>/main/ajax_call_changegh", // or "resources/ajax_call" - url to fetch the next dropdown
    async: false,
    type: "POST",     // post
    data: "table1="+selTable+"&gn2="+gn,  // variable send
    dataType: "html",    // return type
    success: function(data) {  // callback function
     $('#in').html(data);
    }
   })
  //}///////
  });
 });
 
 
 
 
 //for group head change
 $(document).ready(function(){
  $('#group_head2').click(function(e){
   //if(this.checked){
   var selTable = $(this).val(); // selected name from dropdown #table
   var gn = $('#group_name').val();

   //var group_id2 = $('#group_id').val();
   $.ajax({
    url: "<?php echo site_url(); ?>/main/ajax_call_changegh", // or "resources/ajax_call" - url to fetch the next dropdown
    async: false,
    type: "POST",     // post
    data: "table1="+selTable+"&gn2="+gn,  // variable send
    dataType: "html",    // return type
    success: function(data) {  // callback function
     $('#in').html(data);
    }
   })
  //}///////
  });
 });
 
 
</script>


<!-- Select2 -->
<script src="<?php echo base_url(); ?>asset/plugins/select2/select2.full.min.js"></script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
	
	 });
</script>

	


   <!--Bootstrap Date Picker-->
   <script src="<?php echo base_url(); ?>asset/plugins/datepicker/bootstrap-datepicker.js"></script>
   <script>
   //--Bootstrap Date Picker--
   //Date picker
    $('.datepicker').datepicker({format: 'yyyy-mm-dd'}).val();
   </script>
   
	<script>
         function printContent(el)
         {
           var restorepage=$('body').html();
           var printcontent = $('#' + el).clone();
           $('body').empty().html(printcontent);
           window.print();
           $('body').html(restorepage);


         }
	</script>
   
   <!--Datetimepicker plugin-->
	<!--<script src="<?php echo base_url(); ?>asset/plugins/datetimepicker/jquery.js"></script>
	<script src="<?php echo base_url(); ?>asset/plugins/datetimepicker/jquery.datetimepicker.js"></script>
	<script>
   
	/**jQuery('#datetimepicker').datetimepicker({
	startDate:'+1971/05/01'//or 1986/12/08
	});**/
	jQuery('#datetimepicker').datetimepicker();
	
	
	</script>-->
   
   
<!-- Slimscroll -->
<script src="<?php echo base_url(); ?>asset/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>asset/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>asset/dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url(); ?>asset/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>asset/dist/js/demo.js"></script>

</body>
</html>
