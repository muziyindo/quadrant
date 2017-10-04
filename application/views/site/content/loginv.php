<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Captcha Value Doesn't Match</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!--<div class="ajax-loader">
			<center><img src="<?php echo base_url(); ?>asset/images/page-loader.gif"></img></center>
</div>-->

<div class="container-fluid" id="container-fluid-preregister" style="height:500px">
	<div class="container" id="container-preregister">
		<div class="container-fluid" id="container-fluid-preheader">
			
		</div>
		
		<div class="panel panel-default" id="panel-default-form">
		
			<div class="panel-heading" id="panel-heading-preregister">
				Kindly enter your login details below
			</div>
			<form class="form-horizontal" action="<?php echo site_url('authenticateLogin') ?>" method="post" id="form_">
			<div class="panel-body">
				
				<div class="panel panel-default" style="background:#fff; border-radius:0;  border:0">
					
					<div class="panel-body" style="color:red; font-weight:bold">
							<?php 
								$message=$this->session->flashdata('message');
								if($message=="invalid_password")
								{
									echo "Invalid Password";
							?>
								<script>
								$(function(){
									$("#captcha").css("border","4px solid red");
								});
								</script>
							<?php } ?>
							
					</div>
				</div>
				
				
				<div class="panel panel-default col-xs-12 col-sm-6" style="background:#Fff; border-radius:0;  box-shadow: 0; ">
					
					<div class="panel-body">
						
						
						
						<div class="form-group">
								
								<input type="email" class="form-control" id="email" name="email" value="<?php echo $_POST['email'] ; ?>"   placeholder="Enter email" required>
						</div>
						
						
						
						<div class="form-group">
								
								<input type="password" class="form-control" id="pwd" name="password" placeholder="Enter password" required>
						</div>
						
						
						
						<input type="submit" value="Login" class="btn btn-default btn-md" style="border: 1px solid #C7C7C7; box-shadow: inset 0 3px 6px 0 rgba(0,0,0,0.10); border-radius: 3px;">
						
						
						
						
						
						
					</div>
				</div>
				
			
			
			
			</div>
			</form>
		</div>
		
	</div>
	
</div>

<!--<script src="<?php echo base_url(); ?>asset/js/jquery.min.js"></script>
<script>
	$(function(){
		$('.ajax-loader').hide();
		$("#btn").on("click",function(e){
			
			var captchaValue = $("#captcha").val();
			//convert to lower case
			captchaValue = captchaValue.toLowerCase();
			
			var captchaServer = <?php echo json_encode($this->session->userdata('captcha')) ?>
			//convert to lower case
			captchaServer = captchaServer.toLowerCase();
			
			if(captchaValue === captchaServer)
			{
				$("#form_").trigger("submit");
			}
			else
			{
				$('#myModal').modal('show');
				//alert("Captcha Value Doesn't Match");
				$("#captcha").css("border","4px solid red");
			}
			e.preventDefault();
		});
		
		$("#form_").on("submit",function(){
			$('.ajax-loader').show();
			$.post("<?php echo site_url('preregisteri') ?>",
			$("#form_").serialize(),
			function(data){
				//alert(data);
				$("body").html(data);
				$('.ajax-loader').hide();
			});
			return false;
			
		
		});
	});
</script>-->