<?php
/**
Author			: 	Dauda Musideen Ayinde
Initiated		: 	30th August, 2017
Last Modified	:	30th August, 2017
Description		: Verifies client email
**/
ob_start();
error_reporting(E_ERROR|E_WARNING);

class Verify extends CI_Controller 
{

   public function __construct()
   {
		parent::__construct($client_link);
		$this->load->helper('string');
		$this->load->library('session');
		$this->load->helper('email');
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->library('encrypt');
		$this->load->database();
		
   }
   
	function index($client_link)
	{
		$sql = "select * from client_info where verification_code ='$client_link' and verified='no'";
		$query = $this->db->query($sql);
		if($query->num_rows()== 1)
		{
			$this->db->query("update client_info set verified='yes' where verification_code='$client_link'");
			$data['title'] = 'Pre registeration';
			$this->load->view('site/header/site_header',$data);
			$this->load->view('site/content/verifiedv',$data);
			$this->load->view('site/footer/site_footer');
		}
		else
		{
			echo '<center><p><span style="color:red; font-weight:bold">ERROR<span><p>';
			echo '<p><span style="color:red; font-weight:bold">Invalid Verification link<span><p></center>';
			
		}
	}
	
	function _remap($client_link) {
        $this->index($client_link);
    }
	
	
}//end controller class


ob_clean();
?>