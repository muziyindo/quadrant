<?php
/**
Author			: 	Dauda Musideen Ayinde
Initiated		: 	27th August, 2017
Last Modified	:	27th August, 2017
Description		: Displays the home/landing Page
**/
ob_start();
error_reporting(E_ERROR|E_WARNING);

class Home extends CI_Controller 
{

   public function __construct()
   {
		parent::__construct();
   }
   
   function index()
	{
		$data['title'] = 'Quadrant Network Services';
		$this->load->view('site/header/site_header',$data);
		$this->load->view('site/content/homev');
		$this->load->view('site/footer/site_footer');
	}
	
}//end controller class


ob_clean();
?>