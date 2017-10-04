<?php
/**
Author			: 	Dauda Musideen Ayinde
Initiated		: 	29th August, 2017
Last Modified	:	29th August, 2017
Description		: Insert pre-registered user info on db
**/
ob_start();
error_reporting(E_ERROR|E_WARNING);

class Preregisteri extends CI_Controller 
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

		//validate personal info
		$this->form_validation->set_rules('investment_type', 'Investment Type', 'trim|required');
		$this->form_validation->set_rules('name', 'Full Name', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone Number', 'trim|exact_length[11]|numeric|required|is_unique[client_info.phone]');
		$this->form_validation->set_rules('sex', 'Sex/Gender', 'required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[client_info.email]');
		$this->form_validation->set_rules('dob', 'Date of birth', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('password1', 'Password', 'trim|min_length[8]|alpha_numeric|required|matches[password2]');
        $this->form_validation->set_rules('password2', 'Password Confirmation', 'required');
		
		$this->form_validation->set_rules('account_name', 'Account Name', 'required');
		$this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
		$this->form_validation->set_rules('account_no', 'Account Number', 'trim|exact_length[10]|numeric|required|is_unique[client_info.account_no]');
		$this->form_validation->set_rules('captcha_', 'Captcha', 'trim|required');
		
		
		if ($this->form_validation->run() == FALSE)
		{
			$captcha = random_string('alnum',5);
			$this->session->set_userdata('captcha', $captcha);
			$data['captcha'] = $captcha;
			$data['title'] = 'Pre registeration';
			$this->load->view('site/header/site_header',$data);
			$this->load->view('site/content/preRegisterv',$data);
			$this->load->view('site/footer/site_footer');
		}
		else
		{
			//validate captcha
			$captchaForm = $this->input->post("captcha_");
			$captchaForm = strtolower($captchaForm);
			$captchaSession  = $this->session->userdata("captcha");
			$captchaSession = strtolower($captchaSession);
			if($captchaForm !=$captchaSession)
			{
				$captcha = random_string('alnum',5);
				$this->session->set_userdata('captcha', $captcha);
				$data['captcha'] = $captcha;
				$data['captcha_invalid'] = "captcha_invalid";
				$data['title'] = 'Pre registeration';
				$this->load->view('site/header/site_header',$data);
				$this->load->view('site/content/preRegisterv',$data);
				$this->load->view('site/footer/site_footer');
			}
			else
			{
			
			
				//store in database
				$client_email = $this->input->post("email");
				$client_link = $this->session->userdata("captcha");
				$client_name = $this->input->post("name");
				$password1 = $this->input->post('password1');
				$encrypted_password = $this->encrypt->encode($password1);
				$data = array(
				"investment_type"=>$this->input->post("investment_type"),
				"name_"=>$this->input->post("name"),
				"phone"=>$this->input->post("phone"),
				"sex"=>$this->input->post("sex"),
				"dob"=>$this->input->post("dob"),
				"address"=>$this->input->post("address"),
				"email"=>$this->input->post("email"),
				"password_"=>$encrypted_password,
				"bank_name"=>$this->input->post("bank_name"),
				"account_name"=>$this->input->post("account_name"),
				"account_no"=>$this->input->post("account_no"),
				"verification_code"=>$this->session->userdata("captcha"),
				"new_application"=>"yes",
				"verified"=>"no"
				);
				$this->db->insert("client_info",$data);
				$num_inserts = $this->db->affected_rows();
				
				//mail client
				$this->mail_client($client_email,$client_link,$client_name);
				if($num_inserts=="1")// || $num_inserts=="0"
				{
					//$this->session->set_flashdata('message', 'record_inserted');
					redirect('response');
				}
				else
				{
					//$this->session->set_flashdata('message', 'record_inserted_not');
					//redirect('user_login');
					echo "There is an issue";
				}
			}
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
			$this->email->message('Hi '.$client_name.',<br><br> Thank you for joining Quadrant Investment Plan. Kindly click the link below to verify your account : <BR><BR> <b>link :<b> http://localhost/quadrant/verify/'.$client_link.' <br><br> Best regards,<br> Quadrant.');
			$this->email->send();		
	}
	
}//end controller class


ob_clean();
?>