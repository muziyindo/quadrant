<?php
/**
Author			: 	Dauda Musideen Ayinde
Initiated		: 	29th August, 2017
Last Modified	:	29th August, 2017
Description		: Insert pre-registered user info on db
**/
ob_start();
error_reporting(E_ERROR|E_WARNING);

class Registerationi extends CI_Controller 
{

   public function __construct()
   {
		parent::__construct();
		$this->load->helper('string');
		$this->load->library('session');
		$this->load->helper('email');
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->library('encrypt');
		$this->load->database();
   }
   
   function index()
   {
		$this->form_validation->set_error_delimiters('<div class="error" style="color: red">', '</div>');
		$this->form_validation->set_message('matches', 'Passwords do not match');
		$this->form_validation->set_message('is_unique', 'User with %s already exists');
		$this->form_validation->set_message('required', 'The %s field must be filled');

		$investment_type = $this->input->post('investment_type');
		if(!empty($investment_type))
		{
			if($investment_type=="Binary option")
			{
				$this->form_validation->set_rules('investment_type', 'Investment Type', 'trim|required');
				$this->form_validation->set_rules('principal_amount', 'Investment Amount', 'trim|numeric|required');
				$this->form_validation->set_rules('duration', 'Duration', 'trim|required');
				$this->form_validation->set_rules('maturity_amount', 'Maturity Amount', 'trim|numeric|required');
				$this->form_validation->set_rules('payment_type', 'Payment Type', 'trim|required');
				
				if ($this->form_validation->run() == FALSE)
				{
					$data['title'] = 'Registeration/Binary option';
					$data['investment_type'] = $investment_type ;
					$this->load->view('client/content/binaryOptionReg',$data);
				}
				else
				{
					//validate principal_amount and duration
					$principal_amount = $this->input->post('principal_amount');
					$duration = $this->input->post('duration');
					
					//validate principal
					if($principal_amount>=100000 && $principal_amount<=50000000)
					{
								//set interest rate
								$interest_rate = 0.4 ;
								$flag = 0 ;
								//get duration based on investment amount
								if($principal_amount>=100000 && $principal_amount<=950000)
								{
									$duration = 30 ;
									$maturity_amount = $interest_rate * $principal_amount ;
									$flag = 1;

								}
								else if($principal_amount>=1000000 && $principal_amount<=4500000)
								{
									$duration = 40 ;
									$maturity_amount = $interest_rate * $principal_amount ;
									$flag = 1;
								}
								else if($principal_amount>=5000000 && $principal_amount<=7500000)
								{
									$duration = 50 ;
									$maturity_amount = $interest_rate * $principal_amount ;
									$flag = 1;
								}
								else if($principal_amount>=8000000 && $principal_amount<=10000000)
								{
									$duration = 60 ;
									$maturity_amount = $interest_rate * $principal_amount ;
									$flag = 1;
								}
								else if($principal_amount>=11000000 && $principal_amount<=18000000)
								{
									$duration = 80 ;
									$maturity_amount = $interest_rate * $principal_amount ;
									$flag = 1;
								}
								else if($principal_amount>=20000000 && $principal_amount<=27000000)
								{
									$duration = 100 ;
									$maturity_amount = $interest_rate * $principal_amount ;
									$flag = 1;
								}
								else if($principal_amount>=30000000 && $principal_amount<=40000000)
								{
									$duration = 120 ;
									$maturity_amount = $interest_rate * $principal_amount ;
									$flag = 1;
								}
								else if($principal_amount>=41000000 && $principal_amount<=50000000)
								{
									$duration = 150 ;
									$maturity_amount = $interest_rate * $principal_amount ;
									$flag = 1;
								}
								else
								{
									$flag = 0;
									$this->session->set_flashdata('message1', 'Invalid investment amount, Investment amount must be between 100,000 and 50,000,000');
									redirect('registeration');
								}



								if($flag==1)
								{




									
								}



					}
					else
					{
						$this->session->set_flashdata('message1', 'Invalid investment amount, Investment amount must be between 100,000 and 50,000,000');
						redirect('registeration');
					}
				
					
					
				}
			}//end if binaryOptionReg
		}

	}
	
	
	
	function mail_client($client_email,$client_link,$client_name)
	{
			$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			/*'smtp_user' => 'primeracredit2017@gmail.com',
			'smtp_pass' => 'Default@123',*/
			'smtp_user' => 'musideendauda@gmail.com',
			'smtp_pass' => 'M52089900m',
			'mailtype'  => 'html', 
			'charset'   => 'iso-8859-1',
			'wordwrap'	=> TRUE
			);
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
	
			$this->email->from('noreply@primeracredit.com','Quadrant Verification Link');
			
			$this->email->to($client_email); //();
			
			//$this->email->reply_to('my-email@gmail.com', 'Explendid Videos');
			$this->email->subject('Quadrant Verification Link');
			$this->email->message('Hi '.$client_name.',<br><br> Thank you for joining Quadrant Investment Plan. Kindly click the link below to verify your account : <BR><BR> <b>link :<b> http://localhost/quadrant/emailverify/'.$client_link.' <br><br> Best regards,<br> Quadrant.');
			$this->email->send();		
	}
	
}//end controller class


ob_clean();
?>