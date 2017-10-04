<?php
    $message=$this->session->flashdata('message');
?>



<div class="container-fluid" id="container-fluid-preregister" style="height:500px">
	<div class="container" id="container-preregister">
		<div class="container-fluid" id="container-fluid-preheader">
			Online Preregisteration &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-question-circle" aria-hidden="true" style="font-size:20px"></i>
		</div>
		
		<div class="panel panel-default" id="panel-default-form">
		
			<div class="panel-heading" id="panel-heading-preregister">
				 Notification
			</div>
			<form class="form-horizontal" id="form_"><!--action="<?php echo site_url('Preregisteri') ?>" method="post"-->
			<div class="panel-body">
				
				<div class="panel panel-default" style="background:#fff; border-radius:0;  border:0">
					
					<div class="panel-body" style="color:red; font-weight:bold">
							Thank You, An email has been sent to you for confirmation, kindly click on the link in the mail to confirm your account.
					</div>
				</div>
				
				
	
			</div>
			</form>
		</div>
		
	</div>
	
</div>

<script src="<?php echo base_url(); ?>asset/js/jquery.min.js"></script>
