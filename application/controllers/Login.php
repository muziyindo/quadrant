<?php
/**
Author			: 	Dauda Musideen Ayinde
Initiated		: 	27th August, 2017
Last Modified	:	27th August, 2017
Description		: Displays pre-registration Page
**/
ob_start();
error_reporting(E_ERROR|E_WARNING);

class Login extends CI_Controller 
{

   public function __construct()
   {
		parent::__construct();
		$this->load->helper('string');
		$this->load->library('session');
   }
   
   function index()
	{
		$data['title'] = 'Login';
		$this->load->view('site/header/site_header',$data);
		$this->load->view('site/content/loginv',$data);
		$this->load->view('site/footer/site_footer');
	}
	
}//end controller class


ob_clean();
?>