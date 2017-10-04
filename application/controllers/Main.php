<?php

error_reporting(E_ERROR|E_WARNING);
ob_start();
class Main extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->database();
		$this->load->library('form_validation');
		$this->load->library('encrypt');
		$this->load->library('session');
		$this->load->model('main_model');
		
		$ud = $this->session->userdata('userid');
        if ($ud < 1)
        {
              redirect('site/login','refresh');
        }
		
	}
	
	function view_dashboard()
	{
		$data['title'] = 'Dashboard';
		$data['employees_count'] = $this->main_model->get_employees_count();
		$data['visitors_count'] = $this->main_model->get_visitors_count();
		$data['prereg_count'] = $this->main_model->get_prereg_count();
		$data['subscription'] = $this->main_model->get_subscription();
		$this->load->view('header/header',$data);
		$this->load->view('content/inner/dashboard',$data);
		$this->load->view('footer/footer');
	}
	
	/***********************employees start********************/
	function view_employees()
	{
		$data['title'] = 'Employees';
		$data['data'] = $this->main_model->get_employees();
		$this->load->view('header/header',$data);
		$this->load->view('content/inner/employees',$data);
		$this->load->view('footer/footer');
	}
	
	function add_employee()
	{
		$data['title'] = 'New employee';
		$this->load->view('header/header',$data);
		$this->load->view('content/inner/add_employee',$data);
		$this->load->view('footer/footer');
	}
	
	function insert_employee()
	{
		
		$this->form_validation->set_rules('fname', 'Firstname', 'trim|required');
		$this->form_validation->set_rules('lname', 'Lastname', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|exact_length[11]|numeric|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('role', 'Position/Role', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = 'New employee';
			$this->load->view('header/header',$data);
			$this->load->view('content/inner/add_employee',$data);
			$this->load->view('footer/footer');
		}
		else
		{
					//$this->handle_upload();
					$this->load->model('main_model');
					$this->main_model->insert_employee();
					$num_inserts = $this->db->affected_rows();
					if($num_inserts=="1")
					{
						$this->session->set_flashdata('message', 'success');
						redirect('main/add_employee');

					}
					else
					{
						$this->session->set_flashdata('message', 'failed');
						redirect('main/add_employee');
					}
		}

	}
	
	function upload_employees()
	{
		$data['title'] = 'Upload Employees';
		$this->load->view('header/header',$data);
		$this->load->view('content/inner/upload_employees',$data);
		$this->load->view('footer/footer');
	}
	
	function insert_upload_employees()
	{
    
		$uname = $this->session->userdata('uname');
		$this->form_validation->set_rules('test', 'Test', 'required');
		if (empty($_FILES['myuploadFile']['name']))
		{
			$this->form_validation->set_rules('myuploadFile', 'Document', 'required');
		}

		if ($this->form_validation->run() === FALSE)
		{
			$data['title'] = 'Upload Employees';
			$this->load->view('header/header',$data);
			$this->load->view('content/inner/upload_employees',$data);
			$this->load->view('footer/footer');
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
		
				$this->insert_from_uploaded_employees($path);
			}
		}
	}
	
	function insert_from_uploaded_employees($path)
	{

		$this->load->library('PHPExcel/Classes/PHPExcel');
		$inputFileType = PHPExcel_IOFactory::identify($path);
		$objReader1     = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel1   = $objReader1->load($path);
		$sheetList      = $objReader1->listWorksheetNames($path); 
		foreach ($sheetList as $sheetName)
		{
			$currentObjectName  = $objPHPExcel1->setActiveSheetIndexByName($sheetName);
			$result=$this->insertintodb_uploaded_employees($currentObjectName);
		}
  }
  
  function insertintodb_uploaded_employees($objWorksheet1)
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
    
    //design error page ;
    echo '<html>';
    echo '<head>';
    echo '<title>Result</title>';
    echo '<head>';
    echo '<link href="'.base_url().'asset/bootstrap/css/bootstrap.min.css" rel="stylesheet">';
    //echo '<link href="'.base_url().'asset/css/style.css" rel="stylesheet">';
    echo '<link href="'.base_url().'asset/bootstrap/js/bootstrap.min.js"></script>';
    echo '<link href="'.base_url().'asset/bootstrap/js/jquery.min.js"></script>';
    echo '</head>';

    echo '<body>';

    echo '<p><div class="container">';
    echo '<div class="panel panel-primary">';
    echo '<div class="panel-heading">Payment Upload Report(s)</div>';
    echo '<div class="panel-body">';

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
						
							
							echo '<center><strong>Error!</strong><span class="text-danger">Employee record already exist ('.$phone.'/'.$email.') </span></center>';
							$error_report=1 ;
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
							"company_id"=>$member_id,
							"date_added"=>date('Y-m-d'),
							"inputter"=>$member_id
							);
							$this->db->insert('company_staff',$data);
							
							
							$num_inserts = $this->db->affected_rows();
							if($num_inserts=="1")
							{
								echo $oracle_no.'<center><strong>Success!</strong><span class="text-danger">EMPLOYEES SUCCESSFULLY UPLOADED</span></center>';
							}
							$un=0;
						}//end duplicacy validation
				}//end fields validation if
				else
				{	
					$error_report=1 ;
					echo $fname.' '.$lname.'<center><strong>Error!</strong><span class="text-danger">FIRSTNAME , LASTNAME,  EMAIL,PHONE NO are mandatory</span></center>';
				}
			}//end for
			if($error_report==1)
			{
				echo '<a href="'.site_url().'/main/view_employees/'.$un.'" class="btn btn-primary">Return to employees page</a>';
			}
			else
			{
				echo '<a href="'.site_url().'/main/view_employees/'.$un.'" class="btn btn-primary">Return to employees page</a>';
			}
	}
	
	
	
	function checkin_employee($employee_id)
	{
		$this->db->query("update company_staff set status='checked in' where id='$employee_id'");
		$num_inserts = $this->db->affected_rows();
		if($num_inserts=="1")
		{
			$this->session->set_flashdata('message', 'success');
			redirect('main/view_employees');

		}
		else
		{
			$this->session->set_flashdata('message', 'failed');
			redirect('main/view_employees');
		}
		
	}
	
	function checkout_employee($employee_id)
	{
		$this->db->query("update company_staff set status='checked out' where id='$employee_id'");
		$num_inserts = $this->db->affected_rows();
		if($num_inserts=="1")
		{
			$this->session->set_flashdata('message', 'success');
			redirect('main/view_employees');

		}
		else
		{
			$this->session->set_flashdata('message', 'failed');
			redirect('main/view_employees');
		}
	}
	
	function employee_details($employee_id)
	{
		$data['title'] = 'Employees';
		$data['data'] = $this->main_model->get_employee_details($employee_id);
		$data['visit_data'] = $this->main_model->get_staff_history($employee_id);
		$this->load->view('header/header',$data);
		$this->load->view('content/inner/employee_details',$data);
		$this->load->view('footer/footer');
	}
	
	function employeesReport()
	{
		$data['title'] = 'Employees';
		$data['data'] = $this->main_model->get_employees_full();
		$this->load->view('header/header',$data);
		$this->load->view('content/inner/employeesReport',$data);
		$this->load->view('footer/footer');
	}
	
	function search($table,$view)
	{
		$this->load->model('main_model');
		
		$btn_search = $this->input->post('btn_search');
		
		/**Passed to view,to keep selected value after page refresh**/
		$data['start_date'] = $this->input->post('start_date');
		$data['end_date'] = $this->input->post('end_date');
		//$data['year'] = $this->input->post('year');
		$data['keyword'] = $this->input->post('keyword');
		
		if($btn_search == "Search Filter")
		{
			$data['data'] = $this->main_model->search($table);
			$data['title'] = 'Employees';
			$this->load->view('header/header',$data);
			$this->load->view('content/inner/'.$view,$data);
			$this->load->view('footer/footer');
		}
		else if($btn_search == "Spool")
		{
			$this->file_path = realpath(APPPATH . '../asset/csv');
           //$this->load->model('csv_m');
           $this->load->dbutil();
           $this->load->helper('file');
           //get the object
           
           $report=$this->main_model->spool($table);

           //generate the csv report
            $delimiter = ",";
            $newline = "\r\n";
            $new_report = $this->dbutil->csv_from_result($report, $delimiter, $newline);
            // write file
            write_file($this->file_path . '/csv_file.csv', $new_report);
            //force download from server
            $this->load->helper('download');
            $data = file_get_contents($this->file_path . '/csv_file.csv');
            $name = 'name-'.date('d-m-Y').'.csv';
            force_download($name, $data);
		}
		
	}
	/***********************employee end********************/
	
	
	
	/***********************visitors start********************/
	function view_visitors($status)
	{
		$data['title'] = 'Visitors';
		$data['data'] = $this->main_model->get_visitors($status);
		$this->load->view('header/header',$data);
		$this->load->view('content/inner/visitors',$data);
		$this->load->view('footer/footer');
	}
	
	function visitor_details($visitor_id)
	{
		$data['title'] = 'Visitors';
		$data['data'] = $this->main_model->get_visitor_details($visitor_id);
		$data['visit_data'] = $this->main_model->get_visits_history($visitor_id);
		$this->load->view('header/header',$data);
		$this->load->view('content/inner/visitor_details',$data);
		$this->load->view('footer/footer');
	}
	
	function checkin_visitor($visitor_id)
	{
		$this->db->query("update visitors set status='visitor in' where id='$visitor_id'");
		$num_inserts = $this->db->affected_rows();
		if($num_inserts=="1")
		{
			$this->session->set_flashdata('message', 'success');
			redirect('main/view_visitors/out');

		}
		else
		{
			$this->session->set_flashdata('message', 'failed');
			redirect('main/view_visitors/out');
		}
		
	}
	
	function checkout_visitor($visitor_id)
	{
		$this->db->query("update visitors set status='visitor out' where id='$visitor_id'");
		$num_inserts = $this->db->affected_rows();
		if($num_inserts=="1")
		{
			$this->session->set_flashdata('message', 'success');
			redirect('main/view_visitors/in');

		}
		else
		{
			$this->session->set_flashdata('message', 'failed');
			redirect('main/view_visitors/in');
		}
	}
	
	
	function visitorsReport()
	{
		$data['title'] = 'Employees';
		$data['data'] = $this->main_model->get_visitors_full();
		$this->load->view('header/header',$data);
		$this->load->view('content/inner/visitorsReport',$data);
		$this->load->view('footer/footer');
	}
	
	function searchv($table,$view)
	{
		$this->load->model('main_model');
		
		$btn_search = $this->input->post('btn_search');
		
		/**Passed to view,to keep selected value after page refresh**/
		$data['start_date'] = $this->input->post('start_date');
		$data['end_date'] = $this->input->post('end_date');
		//$data['year'] = $this->input->post('year');
		$data['keyword'] = $this->input->post('keyword');
		
		if($btn_search == "Search Filter")
		{
			$data['data'] = $this->main_model->searchv($table);
			$data['title'] = 'Employees';
			$this->load->view('header/header',$data);
			$this->load->view('content/inner/'.$view,$data);
			$this->load->view('footer/footer');
		}
		else if($btn_search == "Spool")
		{
			$this->file_path = realpath(APPPATH . '../asset/csv');
           //$this->load->model('csv_m');
           $this->load->dbutil();
           $this->load->helper('file');
           //get the object
           
           $report=$this->main_model->spoolv($table);

           //generate the csv report
            $delimiter = ",";
            $newline = "\r\n";
            $new_report = $this->dbutil->csv_from_result($report, $delimiter, $newline);
            // write file
            write_file($this->file_path . '/csv_file.csv', $new_report);
            //force download from server
            $this->load->helper('download');
            $data = file_get_contents($this->file_path . '/csv_file.csv');
            $name = 'name-'.date('d-m-Y').'.csv';
            force_download($name, $data);
		}
		
	}
	
	/*****************visitors end**************************/
	
	
	/***********************evacuation start********************/
	function evacuation()
	{
		$data['title'] = 'Evacuation';
		$data['datav'] = $this->main_model->get_visitors_in();
		$data['datae'] = $this->main_model->get_employees_in();
		$this->load->view('header/header',$data);
		$this->load->view('content/inner/evacuation',$data);
		$this->load->view('footer/footer');
	}
	
	function checkout_allv()
	{
		$company_id = $this->session->userdata('userid');
		$this->db->query("update visitors set status='visitor out' where company_id='$company_id' and status='visitor in'");
		$num_inserts = $this->db->affected_rows();
		if($num_inserts=="1")
		{
			$this->session->set_flashdata('message', 'successv');
			redirect('main/evacuation');

		}
		else
		{
			$this->session->set_flashdata('message', 'failed');
			redirect('main/evacuation');
		}
	}
	
	function checkout_alle()
	{
		$company_id = $this->session->userdata('userid');
		$this->db->query("update company_staff set status='checked out' where company_id='$company_id' and status='checked in'");
		$num_inserts = $this->db->affected_rows();
		if($num_inserts=="1")
		{
			$this->session->set_flashdata('message', 'successe');
			redirect('main/evacuation');

		}
		else
		{
			$this->session->set_flashdata('message', 'failed');
			redirect('main/evacuation');
		}
	}
	/***********************evacuation end********************/
	
	
	function view_devices()
	{
		$data['title'] = 'Devices and Locations';
		$this->load->view('header/header',$data);
		$this->load->view('content/inner/devices',$data);
		$this->load->view('footer/footer');
	}
	
	function view_agreement()
	{
		
		$data['agreement'] = $this->main_model->get_agreement();
		$data['agreement_status'] = $this->main_model->get_agreement_status();
		$data['title'] = 'Visitor Agreement';
		$this->load->view('header/header',$data);
		$this->load->view('content/inner/agreement',$data);
		$this->load->view('footer/footer');
	}
	
	function insert_agreement()
	{
		$company_id = $this->session->userdata('userid');
		
		$data = array(
		"agreement"=>$this->input->post('agreement')
		);
		$this->db->where("id",$company_id);
		$this->db->update("company",$data);
		$num_inserts = $this->db->affected_rows();
		if($num_inserts=="1")
		{
			$this->session->set_flashdata('message', 'success');
			redirect('main/view_agreement');

		}
		else
		{
			$this->session->set_flashdata('message', 'failed');
			redirect('main/view_agreement');
		}

	}
	
	function ajax_call_changegh()
	{
		$company_id = $this->session->userdata('userid');
		if ($_POST) 
		{
				
				$gh = $_POST['table1']; //obtain group id
				$gn = $_POST['gn2'];
		
				//echo $gh." ".$gn ;
				
				if($gh=="enabled")
				{
					$this->db->query("update company set agreement_status='enabled' where id = '$company_id'");
					echo "enabled";
				}
				else if($gh=="disabled")
				{
					$this->db->query("update company set agreement_status='disabled' where id = '$company_id'");
					echo "disabled";
				}
				
			
		}

	}
	
	
	/***********************preregistered start********************/
	function view_prereg()
	{
		$data['title'] = 'Employees';
		$data['data'] = $this->main_model->get_prereg();
		$this->load->view('header/header',$data);
		$this->load->view('content/inner/prereg',$data);
		$this->load->view('footer/footer');
	}
	
	function add_prereg()
	{
		$data['title'] = 'New employee';
		$this->load->view('header/header',$data);
		$this->load->view('content/inner/add_prereg',$data);
		$this->load->view('footer/footer');
	}
	
	function insert_prereg()
	{
		
		$this->form_validation->set_rules('visitor_type', 'Visitor Type', 'trim|required');
		$this->form_validation->set_rules('fullname', 'Fullname', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone Number', 'trim|exact_length[11]|numeric|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('whom_to_see', 'Whom to see', 'trim|required');
		$this->form_validation->set_rules('type_of_visit', 'Type of visit', 'trim|required');
		$this->form_validation->set_rules('reason_for_visit', 'Reason for visit', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = 'New employee';
			$this->load->view('header/header',$data);
			$this->load->view('content/inner/add_prereg',$data);
			$this->load->view('footer/footer');
		}
		else
		{
					//$this->handle_upload();
					$this->load->model('main_model');
					$this->main_model->insert_prereg();
					$num_inserts = $this->db->affected_rows();
					if($num_inserts=="1")
					{
						$this->session->set_flashdata('message', 'success');
						redirect('main/add_prereg');

					}
					else
					{
						$this->session->set_flashdata('message', 'failed');
						redirect('main/add_prereg');
					}
		}

	}
	/***preregistered end ***/
	
	function message_all()
	{
			$email = $this->input->post('email');
			$sms = $this->input->post('sms');
			$company_id = $this->session->userdata('userid');
			
			//Message checked-in staff
			$query = $this->db->query("select * from company_staff where company_id='$company_id' and status='checked in'");
			foreach($query->result() as $value)
			{
				$staff_email = $value->email;
				$staff_phone = $value->phone;
				$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'mail.receptio.com.ng',
				'smtp_port' => 25,
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
				$this->email->to($staff_email); //();
				//$this->email->reply_to('my-email@gmail.com', 'Explendid Videos');
				$this->email->subject('Emergency Evacuation Notification');
				$this->email->message($email.'<br><br> Best regards,<br>Darlington,<br> Receptio, <br> Receptio.com.ng');
				$this->email->send();
				//$this->sms_all($staff_phone,$sms);
			}
			
			//Message checked-in
			$query = $this->db->query("select * from visitors where company_id='$company_id' and status='visitor in'");
			foreach($query->result() as $value)
			{
				$visitor_email = $value->email;
				$visitor_phone = $value->phone;
				$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'mail.receptio.com.ng',
				'smtp_port' => 25,
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
				$this->email->to($visitor_email); //();
				//$this->email->reply_to('my-email@gmail.com', 'Explendid Videos');
				$this->email->subject('Emergency Evacuation Notification');
				$this->email->message($email.'<br><br> Best regards,<br>Darlington,<br> Receptio, <br> Receptio.com.ng');
				$this->email->send();
				//$this->sms_all($visitor_phone,$sms);
			}
			
			echo "Successful!" ;
	}
	
	
	function sms_all($staff_phone,$message_)
	{
		$length_ = strlen($staff_phone);
		if($length_>10)
		{
			$staff_phone = substr($staff_phone,1,10);
		}
		$staff_phone="234".$staff_phone;
		$message = $message_;
		$message = urlencode($message);
		$data = array(
		"username" => "muziyindojava@gmail.com", 
		"password" => "52089900m",
		"message" => "api text", 
		"sender" => "receptio",
		"mobiles"=>"2347084702950"
		);
		$data_string = json_encode($data);
		//http://portal.bulksmsnigeria.net/api/?username=user&password=pass&message=test&sender=welcome&mobiles=2348030000000,2348020000000
		$ch = curl_init('http://portal.bulksmsnigeria.net/api/?username=muziyindojava@gmail.com&password=52089900m&message='.$message.'&sender=Receptio&mobiles='.$staff_phone);
		//$ch = curl_init('http://portal.bulksmsnigeria.net/api/?username=muziyindojava@gmail.com&password=52089900m&message=test&sender=receptio&mobiles=2347084702950');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($data_string))
		);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		$result = curl_exec($ch);//execute post
		curl_close($ch); //close connection
		//echo $result ;
	}
	
	
	
	
	
	
	function logout()
	{
		$member_id = $this->session->userdata('userid');
		$this->session->unset_userdata('userid');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('fname');
		$this->session->unset_userdata('lname');
		$this->session->unset_userdata('company_name');
		$this->session->unset_userdata('company');
		
		redirect('site/login');
	}


}

?>
