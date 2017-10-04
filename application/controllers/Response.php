<?php
/**
Author			: 	Dauda Musideen Ayinde
Initiated		: 	27th August, 2017
Last Modified	:	27th August, 2017
Description		: Displays response, success/failure
**/
ob_start();
error_reporting(E_ERROR|E_WARNING);

class Response extends CI_Controller 
{

   public function __construct()
   {
		parent::__construct();
		$this->load->helper('string');
		$this->load->library('session');
   }
   
   function index()
	{
		
		$captcha = random_string('alnum',5);
		$this->session->set_userdata('captcha', $captcha);
		$data['captcha'] = $captcha;
		$data['title'] = 'Preregisteration';
		$this->load->view('site/header/site_header',$data);
		$this->load->view('site/content/responsev',$data);
		$this->load->view('site/footer/site_footer');
	}
	
}//end controller class


ob_clean();
?>