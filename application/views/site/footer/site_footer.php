
<script src="<?php echo base_url(); ?>asset/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>asset/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>asset/js/bootstrap-datepicker.js"></script>
<script>
   //Date picker
    $('.datepicker').datepicker({format: 'yyyy-mm-dd'}).val();
</script>

<!--for text slider-->
<!--textslider-->
<script src="<?php echo base_url(); ?>asset/js/text-slider.js"></script>
	
<script>
	$(document).ready(function () {
		$('.slide').textSlider();
	});
</script>

</body>
</html>