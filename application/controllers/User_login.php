<?php

error_reporting(E_ERROR|E_WARNING);

class User_login extends CI_Controller 
{

   public function __construct()
   {
       parent::__construct();

		$this->load->database();
       $this->load->library('encrypt');
       $this->load->library('session');
       $this->load->library('form_validation');
	   
   }
   
   function index()
	{
		$data['title'] = 'Visitor Page';
		$this->load->view('header/site_header',$data);
		$this->load->view('content/site');
		$this->load->view('footer/site_footer');
		
		/*$data['title'] = 'Welcome to creativeindexes';
		$this->load->view('header/site_header',$data);
		$this->load->view('content/site');
		$this->load->view('footer/site_footer');*/
		
	}
   
	function login()
	{
		$data['title'] = 'Login Page';
		$this->load->view('header/login_header',$data);
		$this->load->view('content/login');
		$this->load->view('footer/site_footer');
		
	}
	
	function new_visitor()
	{
		$data['title'] = 'Visitor Page';
		$this->load->view('header/site_header',$data);
		$this->load->view('content/new_visitor');
		$this->load->view('footer/site_footer');
		
	}
	
	function new_visitor2()
	{
		$data['title'] = 'Visitor Page';
		$this->load->view('header/site_header',$data);
		$this->load->view('content/new_visitor2');
		$this->load->view('footer/site_footer');
		
	}
	
	function camera()
	{
		/*$data['title'] = 'Visitor Page';
		$this->load->view('header/site_header',$data);
		$this->load->view('content/camera');
		$this->load->view('footer/site_footer');*/
		
		redirect('http://localhost/visitor/camera/camera.php');
	}
	
	function upload_()
	{
		/* JPEGCam Test Script */
		/* Receives JPEG webcam submission and saves to local file. */
		/* Make sure your directory has permission to write files as your web server user! */
		
		$filename = date('YmdHis') . '.jpg';
		
		//$result = file_put_contents( $filename, file_get_contents('php://input') );
		$result = file_put_contents('http://localhost/visitor/asset/images/'.$filename, file_get_contents('php://input') );
		if (!$result) {
			print "ERROR: Failed to write data to $filename, check permissions\n";
			exit();
		}
		
		$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $filename;
		print "$url\n";
	}

        function admin_reg2345()
	{
		$data['title'] = 'Login Page';
		$this->load->view('header/login_header',$data);
		$this->load->view('content/admin_reg');
		$this->load->view('footer/site_footer');
		
	}
	
	function register()
	{
		$data['title'] = 'Join Us';
		$this->load->view('header/login_header',$data);
		$this->load->view('content/register');
		$this->load->view('footer/site_footer');
	}
	
   
   function authenticate()
   {
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$check = $this->db->query("SELECT * FROM members WHERE username='$username' and (role='user' or role='admin')");
		
		if($check->num_rows()>0)
		{
			$pword = $this->db->query("SELECT password FROM members WHERE username='$username' and (role='user' or role='admin')");
			$pword = $pword->result();
			$decrypted_password = $this->encrypt->decode($pword[0]->password);
			if($decrypted_password==$password)
			{
				
				//get user details
				foreach($check->result() as $value)
				{
					$uid = $value->id ;
					$username = $value->username ;
					$name = $value->name ;
					$role = $value->role ;
					$sponsor_id = $value->sponsor_id ;
					
			
				}
				
				//store user details in session
				$this->session->set_userdata('userid', $uid);
				$this->session->set_userdata('uname', $username);
				$this->session->set_userdata('name', $name);
				$this->session->set_userdata('role', $role);
				$this->session->set_userdata('sponsor_id', $sponsor_id);
				
				
				redirect('main/view_dashboard','refresh');
			}
			else
			{
				$this->session->set_flashdata('message', 'invalid_password');
				redirect('user_login/login');
			}
			
		}
		else
		{
			$this->session->set_flashdata('message', 'invalid_user');
			redirect('user_login/login');
		}
	}
	
	function insert_user()
	{
		$this->form_validation->set_error_delimiters('<div class="error" style="color: red">', '</div>');
		$this->form_validation->set_message('matches', 'Passwords do not match');
		$this->form_validation->set_message('is_unique', 'User with %s already exists');
		$this->form_validation->set_message('required', 'The %s field must be filled');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		
		$this->form_validation->set_rules('account_name', 'Account name', 'trim|required');
		$this->form_validation->set_rules('account_no', 'Account Number', 'trim|exact_length[10]|numeric|required');
		$this->form_validation->set_rules('phone', 'Phone Number', 'trim|exact_length[11]|numeric|required');//|is_unique[members.phone]
		$this->form_validation->set_rules('bank', 'Bank Name', 'required');
		$this->form_validation->set_rules('amount', 'Amount', 'trim|numeric|required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[members.username]');
		$this->form_validation->set_rules('password1', 'Password', 'trim|min_length[6]|alpha_numeric|required|matches[password2]');
        $this->form_validation->set_rules('password2', 'Password Confirmation', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = 'Welcome to pplpayppl';
			$this->load->view('header/login_header',$data);
			$this->load->view('content/login');
			$this->load->view('footer/site_footer');
		}
		else
		{
					$sponsor_id = $this->generate_sponsor_id();
					
					$this->load->model('main_model');
					$this->main_model->insert_user("NG".$sponsor_id);
					$num_inserts = $this->db->affected_rows();
					if($num_inserts=="1" || $num_inserts=="0")
					{
						$this->session->set_flashdata('message', 'record_inserted');
						redirect('user_login');

					}
					else
					{
						$this->session->set_flashdata('message', 'record_inserted_not');
						redirect('user_login');
					}
		}

	}
	
	function generate_sponsor_id() 
	{
	$character_set_array = array();
    $character_set_array[] = array('count' => 3, 'characters' => 'abcdef');
    $character_set_array[] = array('count' => 1, 'characters' => '0123456789');
    $temp_array = array();
    foreach ($character_set_array as $character_set) {
        for ($i = 0; $i < 3; $i++) {
            $temp_array[] = $character_set['characters'][rand(0, strlen($character_set['characters']) - 1)];
        }
    }
	// shuffle($temp_array);
    return strtoupper(implode('', $temp_array));
	}
   
   
  

}//end controller class



?>