<?php
ob_start();
error_reporting(E_ERROR|E_WARNING);

class Site extends CI_Controller 
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
		$data['title'] = 'Welcome To Receptio';
		$this->load->view('header/site_header',$data);
		$this->load->view('content/site/site');
		$this->load->view('footer/site_footer');
	}
	
	function trial_register()
	{
		$data['title'] = 'Start Free Trial';
		$this->load->view('content/site/trial_register',$data);
	}
	
	function login()
	{
		$data['title'] = 'Login';
		$this->load->view('content/site/login',$data);
	}
	
	function insert_user()
	{
		$this->form_validation->set_error_delimiters('<div class="error" style="color: red">', '</div>');
		$this->form_validation->set_message('matches', 'Passwords do not match');
		$this->form_validation->set_message('is_unique', 'User with %s already exists');
		$this->form_validation->set_message('required', 'The %s field must be filled');
		$this->form_validation->set_rules('fname', 'Firstname', 'trim|required');
		$this->form_validation->set_rules('lname', 'Lastname', 'trim|required');
		$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[company.email]');//|is_unique[members.phone]
		$this->form_validation->set_rules('password1', 'Password', 'trim|min_length[6]|alpha_numeric|required|matches[password2]');
        $this->form_validation->set_rules('password2', 'Password Confirmation', 'required');
		$this->form_validation->set_rules('agree', 'Terms agreement', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = 'Start Free Trial';
			$this->load->view('content/site/trial_register');
		}
		else
		{
					$tab_code = $this->generate_sponsor_id();
					
					$this->load->model('site_model');
					$company_id = $this->site_model->insert_user("RC".$tab_code);
					$num_inserts = $this->db->affected_rows();
					if($num_inserts=="1" || $num_inserts=="0")
					{
						$customer_email = $this->input->post('email');
						$customer_name = $this->input->post('fname');
						$company_name = $this->input->post('company_name');
						$this->mail_customer($customer_email,$customer_name,$company_name);
						$this->session->set_userdata('userid', $company_id);
						
						$this->session->set_flashdata('message', 'record_inserted');
						redirect('site/success_response/'.$company_id);

					}
					else
					{
						/*$this->session->set_flashdata('message', 'record_inserted_not');
						redirect('user_login');*/
						echo "There is an error with your submission, try again or contact our support team";
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
	
	function success_response($company_id)
	{	
		$data['company_id'] = $company_id;
		$data['title'] = 'Successful registration';
		$this->load->view('header/setup_header',$data);
		$this->load->view('content/site/success_response',$data);
	}
	
	function load_step($step,$company_id)
	{
		
		if($step=="1")
		{	
			$data['company_id'] = $company_id;
			$data['title'] = 'Upload Employee List';
			$this->load->view('header/setup_header',$data);
			$this->load->view('content/site/step1',$data); //upload employee
		}
	}
	
	function skip_step($company_id)
	{	
		$data['company_id'] = $company_id;
		$data['title'] = 'Add Logo';
		$this->load->view('header/setup_header',$data);
		$this->load->view('content/site/step2',$data); //add logo
	}
	
	function skip_step_($company_id)
	{	
		$data['company_id'] = $company_id;
		$data['title'] = 'Visit App site';
		$this->load->view('header/setup_header',$data);
		$this->load->view('content/site/step3',$data); //add logo
	}
	
	/*function download_template()
	{
			$this->load->model('site_model');
			$report=$this->site_model->download_template();
			
			$dataToExports = [];
			foreach ($report as $data) 
			{
				$arrangeData['Firstname'] = $data['firstname'];
				$arrangeData['Lastname'] = $data['lastname'];
				$arrangeData['Email'] = $data['email'];
				$arrangeData['Phone'] = $data['phone'];
				$dataToExports[] = $arrangeData;
			}
			// set header
			$filename = "template.xls";
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
			$this->exportExcelData($dataToExports);

	}*/
	
	function download_template()
	{
	$p1=$this->uri->segment(3);
	$p2=$this->uri->segment(4);
	$p3=$this->uri->segment(5);
	$full_path = $p1."/".$p2."/".$p3;
	echo $full_path." ".base_url().$full_path;
	
	$this->load->helper('file');
	$this->load->helper('download');
	
	ob_clean();
	$data = file_get_contents(base_url().$full_path);
	
	$exten = explode(".",$p3) ;
	
	if($exten[1]=="xlsx")
	{
		$name = 'template.xlsx';
	}
	
	//$name = 'document.docx';
	force_download($name,$data);
	
	}
	
	public function exportExcelData($records)
	{
		$heading = false;
        if (!empty($records))
            foreach ($records as $row) {
                if (!$heading) {
                    // display field/column names as a first row
                    echo implode("\t", array_keys($row)) . "\n";
                    $heading = true;
                }
                echo implode("\t", ($row)) . "\n";
            }
	}
	
	function authenticate()
   {
		$username = $this->input->post('email');
		$password = $this->input->post('password');
		$check = $this->db->query("SELECT * FROM company WHERE email='$username' ");
		
		if($check->num_rows()>0)
		{
			$pword = $this->db->query("SELECT password FROM company WHERE email='$username' ");
			$pword = $pword->result();
			$decrypted_password = $this->encrypt->decode($pword[0]->password);
			if($decrypted_password==$password)
			{
				
				//get user details
				foreach($check->result() as $value)
				{
					$uid = $value->id ;
					$username = $value->email ;
					$fname = $value->firstname ;
					$lname = $value->lastname ;
					$company_name = $value->company_name ;
					$date_added = $value->date_added ;
					
				}
				
				//store user details in session
				$this->session->set_userdata('userid', $uid);
				$this->session->set_userdata('uname', $username);
				$this->session->set_userdata('fname', $fname);
				$this->session->set_userdata('lname', $lname);
				$this->session->set_userdata('company_name', $company_name);
				$this->session->set_userdata('date_added', $date_added);
				
				$query = $this->db->query("SELECT tab_code FROM tablet WHERE company_id='$uid' ");
				foreach($query->result() as $value)
				{
					$tab_code = $value->tab_code ;
				}
				$this->session->set_userdata('tab_code', $tab_code);
				redirect('main/view_dashboard','refresh');
			}
			else
			{
				$this->session->set_flashdata('message', 'invalid_password');
				redirect('site/login');
			}
			
		}
		else
		{
			$this->session->set_flashdata('message', 'invalid_user');
			redirect('site/login');
		}
	}
	
	
	
	
	
	/********************************Upload employees on trial***************************************************************************************************/
	
	function insert_upload_employees($company_id)
	{
		
		$uname = $this->session->userdata('uname');
		$this->form_validation->set_rules('test', 'Test', 'required');
		if (empty($_FILES['myuploadFile']['name']))
		{
			$this->form_validation->set_rules('myuploadFile', 'Document', 'required');
		}

		if ($this->form_validation->run() === FALSE)
		{
			$data['company_id'] = $company_id;
			$data['title'] = 'Upload Employee List';
			$this->load->view('header/setup_header',$data);
			$this->load->view('content/site/step1',$data); //upload employee
		}
		else
		{
			$storeFolder = './uploads/';
			if (!empty($_FILES)) 
			{ 
				$tempFile = $_FILES['myuploadFile']['tmp_name'];            
				$targetPath =$storeFolder;
				$temp = explode(".", $_FILES["myuploadFile"]["name"]);
				$newfilename = time().$_FILES["myuploadFile"]["name"];
				$targetFile =  $targetPath. $newfilename;  
				move_uploaded_file($tempFile,$targetFile); 
				$path=$file_name='uploads/'.$newfilename;
		
				$this->insert_from_uploaded_employees($path,$company_id);
			}
		}
	}
	
	function insert_from_uploaded_employees($path,$company_id)
	{

		$this->load->library('PHPExcel/Classes/PHPExcel');
		$inputFileType = PHPExcel_IOFactory::identify($path);
		$objReader1     = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel1   = $objReader1->load($path);
		$sheetList      = $objReader1->listWorksheetNames($path); 
		foreach ($sheetList as $sheetName)
		{
			$currentObjectName  = $objPHPExcel1->setActiveSheetIndexByName($sheetName);
			$result=$this->insertintodb_uploaded_employees($currentObjectName,$company_id);
		}
  }
  
  function insertintodb_uploaded_employees($objWorksheet1,$company_id)
  { 
	
	error_reporting(E_ERROR|E_WARNING);
	ini_set('memory_limit','512M');
	ini_set('max_execution_time', 10000); //300 seconds = 5 minutes

    $unames = $this->session->userdata('uname');

    $entry_date=date('Y-m-d');
    $this->load->library('form_validation');
    $highestRow1 = $objWorksheet1->getHighestRow(); // e.g. 10
    $row1=1; // row in which customers description starts in a work sheet
    $row_start= $row1+1;
    
			for ($row_start; $row_start <= $highestRow1; $row_start++) //$highestRow
			{
				$row1=$row_start;
				$fname=$objWorksheet1->getCellByColumnAndRow(0, $row1)->getValue()?$objWorksheet1->getCellByColumnAndRow(0, $row1)->getValue():'';
				$lname=$objWorksheet1->getCellByColumnAndRow(1, $row1)->getValue()?$objWorksheet1->getCellByColumnAndRow(1, $row1)->getValue():'';
				$email=$objWorksheet1->getCellByColumnAndRow(2, $row1)->getValue()? $objWorksheet1->getCellByColumnAndRow(2, $row1)->getValue():'';
				$phone=$objWorksheet1->getCellByColumnAndRow(3, $row1)->getValue()? $objWorksheet1->getCellByColumnAndRow(3, $row1)->getValue():'';
				
				
				//validate mandatory fields --- if(!empty($oracle_no) && !empty($name) && !empty($expected_monthly_repayment_amount) )
				if(!empty($fname) && !empty($lname) && !empty($email) && !empty($phone))
				{
		
					//validate duplicacy
						$result3 = mysql_query("SELECT * from company_staff where phone='$phone' and email='$email' and company_id='$company_id'");
						if(mysql_num_rows($result3)>0)
						{
							redirect('site/skip_step/'.$company_id);
						}
						else
						{
							$member_id = $this->session->userdata('userid');
							//Insert employee data
							$data=array(
							"firstname"=>$fname,
							"lastname"=>$lname,
							"email"=>$email,
							"phone"=>$phone,
							"status"=>"checked out",
							"role"=>"staff",
							"company_id"=>$company_id,
							"date_added"=>date('Y-m-d'),
							"inputter"=>$company_id
							);
							$this->db->insert('company_staff',$data);
							
							
							$num_inserts = $this->db->affected_rows();
							if($num_inserts=="1")
							{
								redirect('site/skip_step/'.$company_id);
							}
							
						}//end duplicacy validation
				}//end fields validation if
				else
				{	
							redirect('site/skip_step/'.$company_id);
				}
			}//end for
			
	}
	
	function insert_logo($company_id)
	{
		$member_id = $this->session->userdata('userid');
		$storeFolder = './uploads/images/';
        if ($_FILES["pay_slip"]["error"]!=4) 
        {
              $max_filesize=2000000 ;
              $base_uploadSize = $_FILES['pay_slip']['size'];
          
              if($base_uploadSize<$max_filesize)
              {
                $base_tempFile = $_FILES['pay_slip']['tmp_name']; 
                         
                //moving the base image
                $targetPath =$storeFolder;
                $temp = explode(".", $_FILES["pay_slip"]["name"]);
                $base_filename = time().$_FILES["pay_slip"]["name"];
                $targetFile =  $targetPath. $base_filename;  
                move_uploaded_file($base_tempFile,$targetFile); 
                $base_path=$file_name='uploads/images/'.$base_filename;

                $data = array(
              'company_id' => $company_id,
              'path' =>$base_path
                );
               $this->db->insert('documents', $data);
			   $num_inserts = $this->db->affected_rows();
				if($num_inserts=="1")
				{
					redirect('site/skip_step_/'.$company_id);
				}

            }//end base if
			 else
			{
				$data['company_id'] = $company_id;
				$data['upload_error'] = 'Image size is too big';
				$data['title'] = 'Add Logo';
				$this->load->view('header/setup_header',$data);
				$this->load->view('content/site/step2',$data); //add logo 
			}
         }
		 else
		 {
			$data['company_id'] = $company_id;
			$data['upload_error'] = 'No image selected';
			$data['title'] = 'Add Logo';
			$this->load->view('header/setup_header',$data);
			$this->load->view('content/site/step2',$data); //add logo 
		 }
	}
	
	
	function mail_customer($customer_email,$customer_name,$company_name)
	{
		
			$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'mail.receptio.com.ng',
			'smtp_port' => 25,
			/*'smtp_user' => 'primeracredit2017@gmail.com',
			'smtp_pass' => 'Default@123',*/
			'smtp_user' => 'darlington@receptio.com.ng',
			'smtp_pass' => 'Default@123',
			'mailtype'  => 'html', 
			'charset'   => 'iso-8859-1',
			'wordwrap'	=> TRUE
			);
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
	
			$this->email->from('darlington@receptio.com.ng', 'Darlington from Receptio');
			//$list = array('mdauda@otandtconsulting.com','dr_da4real@yahoo.com');
			$this->email->to($customer_email); //();
			$this->email->cc('dr_da4real@yahoo.com');//sales supervisor will be added here.
			//$this->email->reply_to('my-email@gmail.com', 'Explendid Videos');
			$this->email->subject('Welcome To Receptio');
			$this->email->message('Hello '.$customer_name.',<br><br> Welcome to receptio, We are excited to see how Receptio can transform your visitor experience at '.$company_name.'. <BR><BR> <b style="color:red; font-size:20px">You have now started our 5 Day Free Trial</b>.<br><br>
			Awesome, you are all set up! It is really easy to get started, just browse around your Dashboard and you will quickly discover how everything works. For any questions or queries you can reach us at support@receptio.com.ng.<br><br>
			Visit <b style="color:blue">https://receptio.com.ng/visitor</b> on your tablet
			Your access code is RCDDD219
			<br><br> Best regards,<br>Darlington,<br> Receptio, <br> Receptio.com.ng');
			$this->email->send();
			
	}
   
	
   
  

}//end controller class


ob_clean();
?>