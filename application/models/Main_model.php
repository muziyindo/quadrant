<?php
ob_start();

class Main_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->database();
		
		date_default_timezone_set("Africa/Lagos");
	}
	
	
	
	function get_employees_count()
	{
		$company_id = $this->session->userdata('userid');
		$query = $this->db->query("SELECT * FROM company_staff WHERE company_id='$company_id'");
		return $query->num_rows();
	}
	
	function get_visitors_count() 
	{
		$company_id = $this->session->userdata('userid');
		$query = $this->db->query("SELECT * FROM visitors WHERE company_id='$company_id' and status='visitor in'");
		return $query->num_rows();
	}
	
	function get_subscription()
	{
		$company_id = $this->session->userdata('userid');
		$query = $this->db->query("SELECT package FROM company WHERE id='$company_id'");
		//$result = $query->result();
		foreach($query->result() as $value)
		{
			$package = $value->package ;
		}
		return $package;
		
	}
	
	/***********************employees start********************/
	function get_employees()
	{
		$company_id = $this->session->userdata('userid');
		$sql = "select * from company_staff where company_id='$company_id' order by id asc";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function get_employees_full()
	{
		$company_id = $this->session->userdata('userid');
		$sql = "select * from staff_hist where company_id='$company_id' order by id asc";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function insert_employee()
	{
			$phone = $this->input->post('phone');
			$truncated_phone = substr($phone,1,10);
			
			$quantity_supplied = $this->input->post('quantity_supplied');
			$member_id = $this->session->userdata('userid');
			$name = $this->session->userdata('name');
			$data = array(
			'firstname'=>$this->input->post('fname'),
			'lastname'=>$this->input->post('lname'),
			'phone'=>$truncated_phone,
			'email'=>$this->input->post('email'),
			'role'=>$this->input->post('role'),
			"status"=>"checked out",
			"company_id"=>$member_id,
			'date_added'=>date('Y-m-d'),
			'inputter'=>$member_id
			);
			$this->db->insert('company_staff',$data);
	
	}
	
	function get_employee_details($employee_id)
	{
		$company_id = $this->session->userdata('userid');
		$sql = "select * from company_staff where company_id='$company_id' and id='$employee_id' order by id asc";	
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function get_staff_history($employee_id)
	{
		$company_id = $this->session->userdata('userid');
		$sql = "select * from staff_hist where company_id='$company_id' and staff_id='$employee_id' order by time_in desc";	
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function search($table)
	{
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$keyword = $this->input->post('keyword');
		$company_id = $this->session->userdata('userid');
		
		if(empty($start_date) && empty($end_date) && empty($keyword))
		{
			$sql = "select * from ".$table." where company_id='$company_id'";
		}
		if(empty($start_date) && empty($end_date) && !empty($keyword))
		{
			$sql = "select * from ".$table." where (firstname like '%$keyword%' or  lastname like '%$keyword%' ) and company_id='$company_id'";
		}
		else if(!empty($start_date) && empty($end_date) && empty($keyword))
		{
			$sql = "select * from ".$table." where date_added>='$start_date' and company_id='$company_id'";
		}
		else if(empty($start_date) && !empty($end_date) && empty($keyword))
		{
			$sql = "select * from ".$table." where date_added<='$end_date' and company_id='$company_id'";
		}
		else if(!empty($start_date) && empty($end_date) && !empty($keyword))
		{
			$sql = "select * from ".$table." where date_added>='$start_date' and (firstname like '%$keyword%' or  lastname like '%$keyword%' ) and company_id='$company_id'";
		}
		else if(empty($start_date) && !empty($end_date) && !empty($keyword))
		{
			$sql = "select * from ".$table." where date_added<='$end_date' and (firstname like '%$keyword%' or  lastname like '%$keyword%' ) and company_id='$company_id'";
		}
		else if(!empty($start_date) && !empty($end_date) && empty($keyword))
		{
			$sql = "select * from ".$table." where date_added>='$start_date' and date_added<='$end_date' and company_id='$company_id'";
		}
		else if(empty(!$start_date) && !empty($end_date) && !empty($keyword))
		{
			$sql = "select * from ".$table." where date_added>='$start_date' and date_added<='$end_date' and (firstname like '%$keyword%' or  lastname like '%$keyword%' ) and company_id='$company_id'";
		}
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function spool($table)
	{
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$keyword = $this->input->post('keyword');
		$company_id = $this->session->userdata('userid');
		
		if(empty($start_date) && empty($end_date) && empty($keyword))
		{
			$sql = "select firstname,lastname,status,time_in,time_out from ".$table." where company_id='$company_id'";
		}
		if(empty($start_date) && empty($end_date) && !empty($keyword))
		{
			$sql = "select firstname,lastname,status,time_in,time_out from ".$table." where (firstname like '%$keyword%' or  lastname like '%$keyword%' ) and company_id='$company_id'";
		}
		else if(!empty($start_date) && empty($end_date) && empty($keyword))
		{
			$sql = "select firstname,lastname,status,time_in,time_out from ".$table." where date_added>='$start_date' and company_id='$company_id'";
		}
		else if(empty($start_date) && !empty($end_date) && empty($keyword))
		{
			$sql = "select firstname,lastname,status,time_in,time_out from ".$table." where date_added<='$end_date' and company_id='$company_id'";
		}
		else if(!empty($start_date) && empty($end_date) && !empty($keyword))
		{
			$sql = "select firstname,lastname,status,time_in,time_out from ".$table." where date_added>='$start_date' and (firstname like '%$keyword%' or  lastname like '%$keyword%' ) and company_id='$company_id'";
		}
		else if(empty($start_date) && !empty($end_date) && !empty($keyword))
		{
			$sql = "select firstname,lastname,status,time_in,time_out from ".$table." where date_added<='$end_date' and (firstname like '%$keyword%' or  lastname like '%$keyword%' ) and company_id='$company_id'";
		}
		else if(!empty($start_date) && !empty($end_date) && empty($keyword))
		{
			$sql = "select firstname,lastname,status,time_in,time_out from ".$table." where date_added>='$start_date' and date_added<='$end_date' and company_id='$company_id'";
		}
		else if(empty(!$start_date) && !empty($end_date) && !empty($keyword))
		{
			$sql = "select firstname,lastname,status,time_in,time_out from ".$table." where date_added>='$start_date' and date_added<='$end_date' and (firstname like '%$keyword%' or  lastname like '%$keyword%' ) and company_id='$company_id'";
		}
		$query = $this->db->query($sql);
		return $query;
	}
	/***********************employees end********************/
	
	
	/***********************visitors start********************/
	function get_visitors($status)
	{
		$company_id = $this->session->userdata('userid');
		if($status=="all")
			$sql = "select * from visitors where company_id='$company_id'and status in ('visitor in','visitor out') order by visit_time desc";
		else if($status=="in")
				$sql = "select * from visitors where company_id='$company_id' and status='visitor in' order by visit_time desc";
		else if($status=="out")
				$sql = "select * from visitors where company_id='$company_id' and status='visitor out' order by visit_time desc";
			
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function get_visitors_full()
	{
		$company_id = $this->session->userdata('userid');
		$sql = "select visits.visitor_id as visitor_id,visits.fullname as visitor_name,visits.visit_time as visit_time,company_staff.firstname as whom_to_see_fname,company_staff.lastname as whom_to_see_lname from visits inner join company_staff on visits.whom_to_see = company_staff.id where visits.company_id='$company_id' order by visits.id asc";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function get_visitor_details($visitor_id)
	{
		$company_id = $this->session->userdata('userid');
		$sql = "select * from visitors where company_id='$company_id' and id='$visitor_id' order by id asc";	
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function get_visits_history($visitor_id)
	{
		$company_id = $this->session->userdata('userid');
		$sql = "select * from visits where company_id='$company_id' and visitor_id='$visitor_id' order by visit_time desc";	
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function searchv($table)
	{
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$keyword = $this->input->post('keyword');
		$company_id = $this->session->userdata('userid');
		
		if(empty($start_date) && empty($end_date) && empty($keyword))
		{
			$sql = "select visits.visitor_id as visitor_id,visits.fullname as visitor_name,visits.visit_time as visit_time,company_staff.firstname as whom_to_see_fname,company_staff.lastname as whom_to_see_lname from ".$table." inner join company_staff on visits.whom_to_see = company_staff.id where visits.company_id='$company_id' order by visits.id asc";
		}
		if(empty($start_date) && empty($end_date) && !empty($keyword))
		{
			$sql = "select visits.visitor_id as visitor_id,visits.fullname as visitor_name,visits.visit_time as visit_time,company_staff.firstname as whom_to_see_fname,company_staff.lastname as whom_to_see_lname from ".$table." inner join company_staff on visits.whom_to_see = company_staff.id where (visits.fullname like '%$keyword%') and visits.company_id='$company_id'";
		}
		else if(!empty($start_date) && empty($end_date) && empty($keyword))
		{
			$sql = "select visits.visitor_id as visitor_id,visits.fullname as visitor_name,visits.visit_time as visit_time,company_staff.firstname as whom_to_see_fname,company_staff.lastname as whom_to_see_lname from ".$table." inner join company_staff on visits.whom_to_see = company_staff.id where visits.visit_date>='$start_date' and visits.company_id='$company_id'";
		}
		else if(empty($start_date) && !empty($end_date) && empty($keyword))
		{
			$sql = "select visits.visitor_id as visitor_id,visits.fullname as visitor_name,visits.visit_time as visit_time,company_staff.firstname as whom_to_see_fname,company_staff.lastname as whom_to_see_lname from ".$table." inner join company_staff on visits.whom_to_see = company_staff.id where visits.visit_date<='$end_date' and visits.company_id='$company_id'";
		}
		else if(!empty($start_date) && empty($end_date) && !empty($keyword))
		{
			$sql = "select visits.visitor_id as visitor_id,visits.fullname as visitor_name,visits.visit_time as visit_time,company_staff.firstname as whom_to_see_fname,company_staff.lastname as whom_to_see_lname from ".$table." inner join company_staff on visits.whom_to_see = company_staff.id where visits.visit_date>='$start_date' and (visits.fullname like '%$keyword%') and visits.company_id='$company_id'";
		}
		else if(empty($start_date) && !empty($end_date) && !empty($keyword))
		{
			$sql = "select visits.visitor_id as visitor_id,visits.fullname as visitor_name,visits.visit_time as visit_time,company_staff.firstname as whom_to_see_fname,company_staff.lastname as whom_to_see_lname from ".$table." inner join company_staff on visits.whom_to_see = company_staff.id where visits.visit_date<='$end_date' and (visits.fullname like '%$keyword%') and visits.company_id='$company_id'";
		}
		else if(!empty($start_date) && !empty($end_date) && empty($keyword))
		{
			$sql = "select visits.visitor_id as visitor_id,visits.fullname as visitor_name,visits.visit_time as visit_time,company_staff.firstname as whom_to_see_fname,company_staff.lastname as whom_to_see_lname from ".$table." inner join company_staff on visits.whom_to_see = company_staff.id where visits.visit_date>='$start_date' and visits.visit_date<='$end_date' and visits.company_id='$company_id'";
		}
		else if(empty(!$start_date) && !empty($end_date) && !empty($keyword))
		{
			$sql = "select visits.visitor_id as visitor_id,visits.fullname as visitor_name,visits.visit_time as visit_time,company_staff.firstname as whom_to_see_fname,company_staff.lastname as whom_to_see_lname from ".$table." inner join company_staff on visits.whom_to_see = company_staff.id where visits.visit_date>='$start_date' and visits.visit_date<='$end_date' and (visits.fullname like '%$keyword%') and visits.company_id='$company_id'";
		}
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function spoolv($table)
	{
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$keyword = $this->input->post('keyword');
		$company_id = $this->session->userdata('userid');
		
		if(empty($start_date) && empty($end_date) && empty($keyword))
		{
			$sql = "select visits.fullname as visitor_name,visits.visit_time as visit_time,company_staff.firstname as whom_to_see_fname,company_staff.lastname as whom_to_see_lname from ".$table." inner join company_staff on visits.whom_to_see = company_staff.id where visits.company_id='$company_id' order by visits.id asc";
		}
		if(empty($start_date) && empty($end_date) && !empty($keyword))
		{
			$sql = "select visits.fullname as visitor_name,visits.visit_time as visit_time,company_staff.firstname as whom_to_see_fname,company_staff.lastname as whom_to_see_lname from ".$table." inner join company_staff on visits.whom_to_see = company_staff.id where (visits.fullname like '%$keyword%') and visits.company_id='$company_id'";
		}
		else if(!empty($start_date) && empty($end_date) && empty($keyword))
		{
			$sql = "select visits.fullname as visitor_name,visits.visit_time as visit_time,company_staff.firstname as whom_to_see_fname,company_staff.lastname as whom_to_see_lname from ".$table." inner join company_staff on visits.whom_to_see = company_staff.id where visits.visit_date>='$start_date' and visits.company_id='$company_id'";
		}
		else if(empty($start_date) && !empty($end_date) && empty($keyword))
		{
			$sql = "select visits.fullname as visitor_name,visits.visit_time as visit_time,company_staff.firstname as whom_to_see_fname,company_staff.lastname as whom_to_see_lname from ".$table." inner join company_staff on visits.whom_to_see = company_staff.id where visits.visit_date<='$end_date' and visits.company_id='$company_id'";
		}
		else if(!empty($start_date) && empty($end_date) && !empty($keyword))
		{
			$sql = "select visits.fullname as visitor_name,visits.visit_time as visit_time,company_staff.firstname as whom_to_see_fname,company_staff.lastname as whom_to_see_lname from ".$table." inner join company_staff on visits.whom_to_see = company_staff.id where visits.visit_date>='$start_date' and (visits.fullname like '%$keyword%') and visits.company_id='$company_id'";
		}
		else if(empty($start_date) && !empty($end_date) && !empty($keyword))
		{
			$sql = "select visits.fullname as visitor_name,visits.visit_time as visit_time,company_staff.firstname as whom_to_see_fname,company_staff.lastname as whom_to_see_lname from ".$table." inner join company_staff on visits.whom_to_see = company_staff.id where visits.visit_date<='$end_date' and (visits.fullname like '%$keyword%') and visits.company_id='$company_id'";
		}
		else if(!empty($start_date) && !empty($end_date) && empty($keyword))
		{
			$sql = "select visits.fullname as visitor_name,visits.visit_time as visit_time,company_staff.firstname as whom_to_see_fname,company_staff.lastname as whom_to_see_lname from ".$table." inner join company_staff on visits.whom_to_see = company_staff.id where visits.visit_date>='$start_date' and visits.visit_date<='$end_date' and visits.company_id='$company_id'";
		}
		else if(empty(!$start_date) && !empty($end_date) && !empty($keyword))
		{
			$sql = "select visits.fullname as visitor_name,visits.visit_time as visit_time,company_staff.firstname as whom_to_see_fname,company_staff.lastname as whom_to_see_lname from ".$table." inner join company_staff on visits.whom_to_see = company_staff.id where visits.visit_date>='$start_date' and visits.visit_date<='$end_date' and (visits.fullname like '%$keyword%') and visits.company_id='$company_id'";
		}
		$query = $this->db->query($sql);
		return $query;
	}
	
	
	/***********************visitors end********************/
	
	/***********************evacuation start********************/
	function get_visitors_in()
	{
		$company_id = $this->session->userdata('userid');
		$sql = "SELECT fullname,status from visitors where company_id='$company_id' and status='visitor in' ";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function get_employees_in()
	{
		$company_id = $this->session->userdata('userid');
		$sql = "SELECT firstname,lastname,status from company_staff where company_id='$company_id' and status='checked in' ";
		$query = $this->db->query($sql);
		return $query->result();
	}
	/***********************evacuation end********************/
	
	
	
	function get_agreement()
	{
		$company_id = $this->session->userdata('userid');
		$query = $this->db->query("SELECT agreement FROM company WHERE id='$company_id'");
		//$result = $query->result();
		foreach($query->result() as $value)
		{
			$agreement = $value->agreement ;
		}
		return $agreement;
	}
	
	function get_agreement_status()
	{
		$company_id = $this->session->userdata('userid');
		$query = $this->db->query("SELECT agreement_status FROM company WHERE id='$company_id'");
		//$result = $query->result();
		foreach($query->result() as $value)
		{
			$agreement_status = $value->agreement_status ;
		}
		return $agreement_status;
	}
	
	/***********************prereg start********************/
	function get_prereg()
	{
		$company_id = $this->session->userdata('userid');
		$sql = "select * from visitors where company_id='$company_id' and status='prereg' order by id desc";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function insert_prereg()
	{
			$data2 = array(
			'visitor_type'=>$this->input->post('visitor_type'),
			'fullname'=>$this->input->post('fullname'),
			'phone'=>$this->input->post('phone'),
			'email'=>$this->input->post('email'),
			'address'=>$this->input->post('address'),
			'whom_to_see'=>$this->input->post('whom_to_see'),
			'type_of_visit'=>$this->input->post('type_of_visit'),
			'reason_for_visit'=>$this->input->post('reason_for_visit'),
			'visit_date'=>$this->input->post('visit_date'),
			'status'=>'prereg',
			'company_id'=>$this->session->userdata('userid')
			);
			$this->db->insert('visitors',$data2);
	
	}
	
	function get_prereg_count() 
	{
		$company_id = $this->session->userdata('userid');
		$query = $this->db->query("SELECT * FROM visitors WHERE company_id='$company_id' and status='prereg'");
		return $query->num_rows();
	}
	/***********************prereg end********************/
}

ob_clean();
?>
  