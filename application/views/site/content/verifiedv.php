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
							Your account has been successfully verified. Login, to complete your application process.
							<p><a href="<?php echo site_url('login'); ?>" class="btn btn-default" style="border: 1px solid #C7C7C7; box-shadow: inset 0 3px 6px 0 rgba(0,0,0,0.10); border-radius: 3px;">Login</a></p>
					</div>
				</div>
				
				
	
			</div>
			</form>
		</div>
		
	</div>
	
</div>

<script src="<?php echo base_url(); ?>asset/js/jquery.min.js"></script>
