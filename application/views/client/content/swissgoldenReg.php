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

<div class="container-fluid" id="container-fluid-preregister">
	<div class="container" id="container-preregister">
		<div class="container-fluid" id="container-fluid-preheader">
			Product Registeration/Payment &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-question-circle" aria-hidden="true" style="font-size:20px"></i>
		</div>
		
		<div class="panel panel-default" id="panel-default-form">
		
			<div class="panel-heading" id="panel-heading-preregister">
				Please complete the final step of your application for one of our product(s). All Fields are required (<i class="fa fa-asterisk" aria-hidden="true" style="font-size:10px; color:red"></i>).
			</div>
			<form class="form-horizontal" action="<?php echo site_url('Preregisteri') ?>" method="post" id="form_">
			<div class="panel-body">
				
				<div class="panel panel-default" style="background:#fff; border-radius:0;  border:0">
					
					<div class="panel-body" style="color:red; font-weight:bold">
							<?php 
								echo validation_errors();
								
								if(!empty($captcha_invalid))
								{
									echo "Invalid captcha value";
							?>
								<script>
								$(function(){
									$("#captcha").css("border","4px solid red");
								});
								</script>
							<?php } ?>
							
					</div>
				</div>
				
				<div class="panel panel-default" style="background:#fff; border-radius:0;  border:0">
					<div class="panel-heading" style="background:#0096aa;  color:#fff; border-radius:0; ">
						Products
					</div>
					<div class="panel-body">
						
						<label class="radio-inline">
							<input type="radio" name="investment_type" value="Binary option" <?php if($investment_type=='Binary option') echo 'checked="checked"';?> >Binary option
						</label>
						<label class="radio-inline">
							<input type="radio" name="investment_type" value="Cryptocurrency" <?php if($investment_type=='Cryptocurrency') echo 'checked="checked"';?> >Cryptocurrency
						</label>
						<label class="radio-inline">
							<input type="radio" name="investment_type" value="Swissgolden" <?php if($investment_type=='Swissgolden') echo 'checked="checked"';?> >Swissgolden
						</label>
					</div>
				</div>
				
				
				
				<div class="panel panel-default" style="background:#Fff; border-radius:0;  box-shadow: 0px 3px 3px 0px rgba(0,0,0,0.2); border:0; ">
					<div class="panel-heading" style="background:#0096aa;  color:#fff; border-radius:0; ">
						Personal Information
					</div>
					<div class="panel-body">
						<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="form-group " >
								<center><label class="control-label" for="email">Name: </label></center>
								<input type="text" class="form-control form-control_" id="email" name="name" value="<?php echo $_POST['name'] ; ?>" required>
						</div>
						</div>
						
						<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="form-group">
								<center><label class="control-label for="email">Phone:</label></center>
								<input type="number" class="form-control form-control_" id="email" name="phone" value="<?php echo $_POST['phone'] ; ?>" required>
						</div>
						</div>
						
						<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="form-group">
								<center><label class="control-label" for="email">Sex:</label></center>
								<select type="number" class="form-control form-control_" id="email" name="sex" required>
									<option value="">--Select--</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
							
						</div>
						</div>
						
						<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="form-group">
								<center><label class="control-label" for="email">Date of birth:</label></center>
								<input type="text" class="form-control form-control_ datepicker" id="email" name="dob" value="<?php echo $_POST['dob'] ; ?>" required>
						</div>
						</div>
						
						<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="form-group">
								<center><label class="control-label" for="email">Address:</label></center>
								<input type="text" class="form-control form-control_" id="email" name="address" value="<?php echo $_POST['address'] ; ?>"   required>
						</div>
						</div>
						
						<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="form-group">
								<center><label class="control-label" for="email">Email:</label></center>
								<input type="email" class="form-control form-control_" id="email" name="email" value="<?php echo $_POST['email'] ; ?>"  required>
						</div>
						</div>
						
						<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="form-group">
								<center><label class="control-label" for="pwd">Password:</label></center>
								<input type="password" class="form-control form-control_" id="pwd" name="password1" required>
						</div>
						</div>
						
						<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="form-group">
								<center><label class="control-label" for="pwd">Confirm Password:</label></center>
								<input type="password" class="form-control form-control_" id="pwd" name="password2" required>
						</div>
						</div>
						
						
					</div>
				</div>
				
				<div class="panel panel-default" style="background:#Fff; border-radius:0;  box-shadow: 0px 3px 3px 0px rgba(0,0,0,0.2); border:0">
					<div class="panel-heading" style="background:#0096aa;  color:#fff; border-radius:0;">
						Bank Details
					</div>
					<div class="panel-body">
						
						<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="form-group">
								<center><label class="control-label" for="email">Bank Name:</label></center>
								<select class="form-control form-control_" id="email" name="bank_name" required>
									<option value="">--Select--</option>
									<option value="Guaranty Trust Bank">Guaranty Trust Bank</option>
									<option value="First Bank">First Bank</option>
									<option value="Skye Bank">Skye Bank</option>
									<option value="Diamond Bank">Diamond Bank</option>
									<option value="Fidelity">Fidelity</option>
									<option value="Access Bank">Access Bank</option>
									<option value="Zenith Bank">Zenith Bank</option>
									<option value="Wema Bank">Wema Bank</option>
									<option value="Union Bank">Union Bank</option>
									<option value="Heritage Bank">Heritage Bank</option>
									<option value="Fidelity">Fidelity</option>
									<option value="Fcmb">Fcmb</option>
									<option value="Eco bank">Eco bank</option>
									<option value="Stanbic Ibtc">Stanbic Ibtc</option>
									<option value="Unity bank">Unity bank</option>
									<option value="UBA">UBA united bank of africa</option>
									<option value="Keystone Bank">Keystone Bank</option>
								</select>
						</div>
						</div>
						
						<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="form-group">
								<center><label class="control-label" for="pwd">Account Name:</label></center>
								<input type="text" class="form-control form-control_" id="pwd" name="account_name" value="<?php echo $_POST['account_name'] ; ?>" required>
						</div>
						</div>
						
						<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="form-group">
								<center><label class="control-label" for="pwd">Account Number:</label></center>
								<input type="text" class="form-control form-control_" id="pwd" name="account_no" value="<?php echo $_POST['account_no'] ; ?>" required>
						</div>
						</div>
						
						
						
					</div>
				</div>
				
				<div class="panel panel-default" style="background:#fff; border-radius:0; box-shadow: 0px 3px 3px 0px rgba(0,0,0,0.2); border:0">
					<div class="panel-heading" style="background:#0096aa;  color:#fff; border-radius:0; ">
						Tell us you are not a robot
					</div>
					<div class="panel-body">
						
						<div class="form-group">
							<center><label class="control-label" for="email">Enter what you see below:</label></center>
							
								<input type="text" class="form-control form-control_" id="captcha" name="captcha_" required>
							
						</div>
						
						<div class="form-group">
							<div class="col-xs-12 col-sm-4"></div>
							<div class="col-xs-12 col-sm-4" style="background:url(<?php echo base_url(); ?>asset/images/captchabg.png) no-repeat center center;
	background-size: cover; font-size:20px; font-weight:bold; text-align:center; font-family: 'Fredericka the Great', cursive;"> 
								<?php echo $captcha ; ?>
							</div>
							<div class="col-xs-12 col-sm-4" id="cap"></div>
							
						</div>
						
					</div>
				</div>
				
				<!--<div class="panel panel-default" style="background:#F2F2F2; border-radius:0; border:0">
					<div class="panel-heading" style="background:rgb(0, 152, 169);  color:white; border-radius:0;">
						Next of Kin Information
					</div>
					<div class="panel-body">
						
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Email:</label>
							<div class="col-sm-7">
								<input type="email" class="form-control" id="email">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="pwd">Password:</label>
							<div class="col-sm-7"> 
								<input type="password" class="form-control" id="pwd" >
							</div>
						</div>
						
					</div>
				</div>-->
				
				<div class="panel panel-default" style="background:none; border:0; border-radius:0; box-shadow:none">
					
					<div class="panel-body">
					<i class="fa fa-warning" aria-hidden="true" style="font-size:20px;"></i> Please Review the information you have entered before continuing.
					</div>
					<div class="panel-footer" style="background:none; border:0; border-radius:0; box-shadow:none">
						
						
								<button type="submit" class="btn btn-default btn-md" style="border-radius:0; background:rgb(0, 152, 169); color:white;" id="btn">Continue</button>
							
						
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