<?php
/**
Author			: 	Dauda Musideen Ayinde
Initiated		: 	2nd September, 2017
Last Modified	:	2nd September, 2017
Description		: Displays pre-registration Page
**/
ob_start();
error_reporting(E_ERROR|E_WARNING);

class Registeration extends CI_Controller 
{

   public function __construct()
   {
		parent::__construct();
		$this->load->helper('string');
		$this->load->library('session');
		$this->load->database();
		
		$ud = $this->session->userdata('userid');
        if ($ud < 1)
        {
              redirect('logout','refresh');
        }
   }
   
   function index()
	{
		$userid = $this->session->userdata('userid');
		$query = $this->db->query("select investment_type from client_info where id = '$userid'");
		foreach($query->result() as $value)
		{
			$investment_type = $value->investment_type ;
		}
		if($investment_type=="Binary option")
		{
			$data['title'] = 'Registeration/Binary option';
			$data['investment_type'] = $investment_type ;
			//$this->load->view('client/header/client_header',$data);
			$this->load->view('client/content/binaryOptionReg',$data);
			//$this->load->view('client/footer/client_footer');
		}
		else if($investment_type=="Cryptocurrency")
		{
			$data['title'] = 'Registeration/Cryptocurrency';
			$data['investment_type'] = $investment_type ;
			$this->load->view('client/header/client_header',$data);
			$this->load->view('client/content/cryptocurrencyReg',$data);
			$this->load->view('client/footer/client_footer');
		}
		else if($investment_type=="Swissgolden")
		{
			$data['title'] = 'Registeration/Swissgolden';
			$data['investment_type'] = $investment_type ;
			$this->load->view('client/header/client_header',$data);
			$this->load->view('client/content/swissgoldenReg',$data);
			$this->load->view('client/footer/client_footer');
		}
	}
	
}//end controller class


ob_clean();
?>