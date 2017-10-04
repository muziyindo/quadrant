<?php
ob_start();

class Site_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->database();
		
		date_default_timezone_set("Africa/Lagos");
	}
	
	function insert_user($tab_code)
	{
			$role = $this->input->post('role');
			$amount = $this->input->post('amount');
			
			$agreement = '<b>Welcome To Our Workplace</b><br><br>
Visitors are welcome to visit during hours of operations. For your safety & security we have the following guidelines:<br><br>
(a) Agree to follow the divisions rules before entry is permitted into the building.
(b) All visitors must sign in and out through the main entrance lobby.
(c) All visitors are required to read and acknowledge the Non-Disclosure and Waiver Agreement.
(d) Smoking/tobacco use is prohibited in our facility. Please use designated outside areas.
(e) Firearms/weapons are prohibited in our facility.
(f) In the event of an emergency. Follow signage to the designated muster point.
<br><br>
<b>Thank you</b>';
			
			
			$password1 = $this->input->post('password1');
			$encrypted_password = $this->encrypt->encode($password1);
			$data = array(
			'firstname'=>$this->input->post('fname'),
			'lastname'=>$this->input->post('lname'),
			'company_name'=>$this->input->post('company_name'),
			'email'=>$this->input->post('email'),
			'password'=>$encrypted_password,
			'package'=>'starter',
			'subscribed'=>'trial',
			'date_added'=>date('Y-m-d'),
			'agreement'=>$agreement,
			'agreement_status'=>'enabled'
			);
		
		$this->db->insert('company',$data);
		$company_id = $this->db->insert_id();
		$this->add_tab_code($company_id,$tab_code);
		
		return $company_id ;
	}
	
	/**called to register a tab code for a company**/
	function add_tab_code($company_id,$tab_code)
	{
		
			$data = array(
			'tab_code'=>$tab_code,
			'company_id'=>$company_id,
			'branch'=>'head office',
			'cookie_id'=>0,
			'date_added'=>date('Y-m-d')
			);
			$this->db->insert('tablet',$data);
	}
	
	function download_template()
	{
		$sql= "select firstname,lastname,email,phone from template";
		$query=$this->db->query($sql);
		return $query->result_array() ;
	}
	
		
	
  
}

ob_clean();
?>
  