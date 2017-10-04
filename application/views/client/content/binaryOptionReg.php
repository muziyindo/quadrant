<!DOCTYPE HTML>
<html>
<head>
	<title><?php echo $title ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Quadrant Network Services Limited" />
	<!-- css files -->
	<link href="<?php echo base_url(); ?>asset/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />
	<link href="<?php echo base_url(); ?>asset/css/font-awesome.css" rel="stylesheet" type="text/css" media="all" />
	
	<!--datepicker-->
	<link href="<?php echo base_url(); ?>asset/css/datepicker3.css" rel="stylesheet" type="text/css" media="all" />
	
	<link href="<?php echo base_url(); ?>asset/css/client.css" rel="stylesheet" type="text/css" media="all" />
	<link href="https://fonts.googleapis.com/css?family=Fredericka+the+Great" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Merriweather+Sans" rel="stylesheet">
	<script src="<?php echo base_url(); ?>asset/js/jquery.min.js"></script>
	
	
	
</head>

<body>
	
	
	<div class="container-fluid" id="container-fluid-topmost">
		<div class="container" id="container-topmost">
			<i class="fa fa-phone" aria-hidden="true"></i> &nbsp;&nbsp;&nbsp; Phone: (+234) 70 6232 4923 &nbsp;&nbsp;&nbsp; <i class="fa fa-envelope" aria-hidden="true"></i> &nbsp;&nbsp;&nbsp; info@quadrant.com.ng
		</div>
	</div>
	<div class="container" id="container-logo">
			<!--First small nav links-->
			<div class="row">
				<div class="col-xs-12 col-md-1">
					
				</div>
				
				<div class="col-xs-12 col-md-11">
					<div class="col-xs-12 col-md-3">
					</div>
					<div class="col-xs-12 col-md-1 nav-links-top">
						
					</div>
					<div class="col-xs-12 col-md-1 nav-links-top" style="color:#0096aa">
						
					</div>
					<div class="col-xs-12 col-md-2 nav-links-top">
						
					</div>
					<div class="col-xs-12 col-md-2 nav-links-top">
						
					</div>
					<div class="col-xs-12 col-md-2" id="nav-links-top-id">
						
					</div>
					
				</div>
			</div>
			
			<!--Second Big nav links-->
			<div class="row">
				<div class="col-xs-12 col-md-1">
					<a href="<?php echo site_url(); ?>"><img src="<?php echo base_url('asset/images/logo.png'); ?>"></img></a>
				</div>
				
				<div class="col-xs-12 col-md-11">
					<div class="col-xs-12 col-md-3">
					</div>
					<div class="col-xs-12 col-md-2 nav-links">
						<i class="fa fa-home" aria-hidden="true"></i>
					</div>
					<div class="col-xs-12 col-md-2 nav-links">
						<a href="<?php echo site_url('logout') ?>">Logout</a>
					</div>
					<div class="col-xs-12 col-md-2 nav-links">
						
					</div>
					<div class="col-xs-12 col-md-1" id="nav-links-id">
						
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
			<form class="form-horizontal" action="<?php echo site_url('registerationi') ?>" method="post" id="form_">
			<div class="panel-body">
				
				<div class="panel panel-default" style="background:#fff; border-radius:0;  border:0">
					
					<div class="panel-body" style="color:red; font-weight:bold">
							
							<?php 	echo validation_errors(); ?>
								
							<?php
									$message1=$this->session->flashdata('message1');
									if(!empty($message1))
									{
										echo $message1;
							?>
								<script>
								$(function(){
									$("#principal_amount").css("border","4px solid red");
								});
								</script>
							<?php } ?>
							
							<?php
									$message2=$this->session->flashdata('message2');
									if(!empty($message2))
									{
										echo $message2;
							?>
								<script>
								$(function(){
									$("#duration").css("border","4px solid red");
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
					
					
					
					
					<div class="panel-body">
						<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="form-group " >
								<center><label class="control-label" for="email">Investment Amount: </label></center>
								<input type="text" class="form-control form-control_" id="principal_amount" name="principal_amount" value="<?php if(isset($_POST['principal_amount'])) echo $_POST['principal_amount']; else echo '100000'  ; ?>" onkeyup="computeInterest()" min="100000" tabindex="1" max="50000000" required>
						</div>
						</div>
						
						<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="form-group " >
								<center><label class="control-label" for="email">Investment Duration : </label></center>
								<input type="text" class="form-control form-control_" id="duration" name="duration" min="1" tabindex="2" max="12" readonly required>
						</div>
						</div>
						
						<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="form-group " >
								<center><label class="control-label" for="email">Maturity Amount: </label></center>
								<input type="text" class="form-control form-control_" id="maturity_amount" name="maturity_amount" value="<?php echo $_POST['maturity_amount'] ; ?>" readonly>
						</div>
						</div>
						
						
						
						<div class="col-xs-12">
						<div class="form-group" style="color:red">
								NB:Your commencement date will be the date you successfully made payment either online or bank deposit(i.e after payment approval). This will now determine your maturity date
						</div>
						</div>
						
						
						
						
					</div>
					
					
					
					
				</div>
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				<div class="panel panel-default" style="background:#ddd; border-radius:0;  box-shadow: 0px 3px 3px 0px rgba(0,0,0,0.2); border:0; ">
					<div class="panel-heading" style="background:#0096aa;  color:#fff; border-radius:0; ">
						Payment option
					</div>
					<div class="panel-body">
					
						
						<div class="col-xs-12 col-sm-6 col-md-4">
							<label class="radio">
								<input type="radio" name="payment_type" value="Online payment" required>Online payment
							</label>
							<div>
								Select this option if you want to pay with your debit card (i.e MasterCard, Verve, Visa). Commencement date will begin immediately you successfully completed your online payment 
							</div>
						</div>
						
						<div class="col-xs-12 col-sm-6 col-md-4">
							<label class="radio">
								<input type="radio" name="payment_type" value="Bank deposit" required>Bank deposit
							</label>
							<div>
								Bank Name : Guaranty Trust Bank, Account Name: Quadrant Investment, Account No: 001311784
							</div>
							<div>
								Use your registered name and phone no as depositors name and phone. You can include this in your narration if mobile transfer or on the teller if bank deposit. Commencement date will begin after administrator approved your payment.
							</div>
						</div>
						
						
						
						
					</div>
				</div>
				
				
				
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



<script src="<?php echo base_url(); ?>asset/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>asset/js/jquery.validate_.min.js"></script>
<script src="<?php echo base_url(); ?>asset/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>asset/js/bootstrap-datepicker.js"></script>

<script>

(function ($) {
    'use strict';
    $('#form_').validate();
})(jQuery);

</script>


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


<script type="text/javascript">
$(function(){
	var maturity_amount ;
	var principal_amount = $("#principal_amount").val();
	if(principal_amount>=100000 && principal_amount<=950000)
	{
		$("#duration").val("30 Working days");
		
		maturity_amount = interest_rate * principal_amount ;
		$("#maturity_amount").val(maturity_amount);

	}
	else if(principal_amount>=1000000 && principal_amount<=4500000)
	{
		$("#duration").val("40 Working days");
		
		maturity_amount = interest_rate * principal_amount ;
		$("#maturity_amount").val(maturity_amount);

	}
	else if(principal_amount>=5000000 && principal_amount<=7500000)
	{
		$("#duration").val("50 Working days");
		
		maturity_amount = interest_rate * principal_amount ;
		$("#maturity_amount").val(maturity_amount);

	}
	else if(principal_amount>=8000000 && principal_amount<=10000000)
	{
		$("#duration").val("60 Working days");
		
		maturity_amount = interest_rate * principal_amount ;
		$("#maturity_amount").val(maturity_amount);

	}
	else if(principal_amount>=11000000 && principal_amount<=18000000)
	{
		$("#duration").val("80 Working days");
		
		maturity_amount = interest_rate * principal_amount ;
		$("#maturity_amount").val(maturity_amount);

	}
	else if(principal_amount>=20000000 && principal_amount<=27000000)
	{
		$("#duration").val("100 Working days");
		
		maturity_amount = interest_rate * principal_amount ;
		$("#maturity_amount").val(maturity_amount);

	}
	else if(principal_amount>=30000000 && principal_amount<=40000000)
	{
		$("#duration").val("120 Working days");
		
		maturity_amount = interest_rate * principal_amount ;
		$("#maturity_amount").val(maturity_amount);

	}
	else if(principal_amount>=41000000 && principal_amount<=50000000)
	{
		$("#duration").val("150 Working days");
		
		maturity_amount = interest_rate * principal_amount ;
		$("#maturity_amount").val(maturity_amount);

	}
	else
	{
		$("#duration").val("Invalid investment amount");
		
		maturity_amount = interest_rate * principal_amount ;
		$("#maturity_amount").val(0);
	}


});
//compute maturity amount based on investment_amount and duration for binary option
function computeInterest()
{

    // get the principal
    var principal_amount = $('#principal_amount').val();
    
    var maturity_amount ;
	
    // set rate
    var interest_rate = 0.4;
	
   if(principal_amount>=100000 && principal_amount<=950000)
	{
		$("#duration").val("30 Working days");
		
		maturity_amount = interest_rate * principal_amount ;
		$("#maturity_amount").val(maturity_amount);

	}
	else if(principal_amount>=1000000 && principal_amount<=4500000)
	{
		$("#duration").val("40 Working days");
		
		maturity_amount = interest_rate * principal_amount ;
		$("#maturity_amount").val(maturity_amount);

	}
	else if(principal_amount>=5000000 && principal_amount<=7500000)
	{
		$("#duration").val("50 Working days");
		
		maturity_amount = interest_rate * principal_amount ;
		$("#maturity_amount").val(maturity_amount);

	}
	else if(principal_amount>=8000000 && principal_amount<=10000000)
	{
		$("#duration").val("60 Working days");
		
		maturity_amount = interest_rate * principal_amount ;
		$("#maturity_amount").val(maturity_amount);

	}
	else if(principal_amount>=11000000 && principal_amount<=18000000)
	{
		$("#duration").val("80 Working days");
		
		maturity_amount = interest_rate * principal_amount ;
		$("#maturity_amount").val(maturity_amount);

	}
	else if(principal_amount>=20000000 && principal_amount<=27000000)
	{
		$("#duration").val("100 Working days");
		
		maturity_amount = interest_rate * principal_amount ;
		$("#maturity_amount").val(maturity_amount);

	}
	else if(principal_amount>=30000000 && principal_amount<=40000000)
	{
		$("#duration").val("120 Working days");
		
		maturity_amount = interest_rate * principal_amount ;
		$("#maturity_amount").val(maturity_amount);

	}
	else if(principal_amount>=41000000 && principal_amount<=50000000)
	{
		$("#duration").val("150 Working days");
		
		maturity_amount = interest_rate * principal_amount ;
		$("#maturity_amount").val(maturity_amount);

	}
	else
	{
		$("#duration").val("Invalid investment amount");
		
		maturity_amount = interest_rate * principal_amount ;
		$("#maturity_amount").val(0);
	}
}
</script>

</body>
</html>


