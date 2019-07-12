<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MakeHtml extends CI_Controller 
{
	//생성자 구성
	function __construct()	
	{
		parent::__construct();
		$this->load->helper('url'); 			//url 관련 보통 자주 사용됨
		$this->load->helper('form'); 			//form 관련 유틸 보통 자주 사용됨
		
		$this->output->enable_profiler(true); 	//프로파일 확인 디버깅 용도로 좋음  사용하지 않는다면 false 혹은 주석
	}

	public function index() 
	{
	
		$data = [];
		$this->load->view('makehtml', $data);
	}
	
	public function grid()
	{
		$data = [];

		// $lo = $this->load->database('local');
		// $lo->from('shop_policy_info');
		$this->load->database();
		
		
		$this->load->view('grid', $data);
	}

}







