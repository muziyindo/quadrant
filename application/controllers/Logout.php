<?php
/**
Author			: 	Dauda Musideen Ayinde
Initiated		: 	3rd September, 2017
Last Modified	:	3rd September, 2017
Description		: 	Unset all session and logs the user out
**/
ob_start();
error_reporting(E_ERROR|E_WARNING);

class Logout extends CI_Controller 
{

   public function __construct()
   {
		parent::__construct();
		$this->load->helper('string');
		$this->load->library('session');
		$this->load->database();
   }
   
	function index()
	{
		$this->session->unset_userdata('userid');
		$this->session->unset_userdata('uname');
		$this->session->unset_userdata('name');
		redirect('login','refresh');
	}
	
}//end controller class


ob_clean();
?>