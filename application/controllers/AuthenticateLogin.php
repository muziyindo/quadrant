<?php
/**
Author			: 	Dauda Musideen Ayinde
Initiated		: 	29th August, 2017
Last Modified	:	29th August, 2017
Description		: Insert pre-registered user info on db
**/
ob_start();
error_reporting(E_ERROR|E_WARNING);

class AuthenticateLogin extends CI_Controller 
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
		$username = $this->input->post('email');
		$password = $this->input->post('password');
		$check = $this->db->query("SELECT * FROM client_info WHERE email='$username'");
		
		if($check->num_rows()>0)
		{
			$pword = $this->db->query("SELECT password_,verified FROM client_info WHERE email='$username'");
			$pword = $pword->result();
			$decrypted_password = $this->encrypt->decode($pword[0]->password_);
			$verified = $pword[0]->verified ;
			if($decrypted_password==$password)
			{
				
				if($verified =="yes")
				{
				
					//get user details
					foreach($check->result() as $value)
					{
						$uid = $value->id ;
						$username = $value->email ;
						$name = $value->name_ ;
						$new_application = $value->new_application ;
					}
					
					//store user details in session
					$this->session->set_userdata('userid', $uid);
					$this->session->set_userdata('uname', $username);
					$this->session->set_userdata('name', $name);
					
					if($new_application=="yes")
					{
						
						redirect('registeration','refresh');
					}
					else
					{
						
						//redirect('main/view_dashboard','refresh');
						echo "Show dashboard";
					}
				
				}
				else
				{
					echo 'Your account have not been verified. Check your mail and click on the verification link or click <a href="#">HERE</a> to receieve the link again';
				}
				
				
			}
			else
			{
				$this->session->set_flashdata('message', 'invalid_password');
				redirect('login');
			}
			
		}
		else
		{
			$this->session->set_flashdata('message', 'invalid_user');
			redirect('login');
		}
	}
	
}//end controller class


ob_clean();
?>