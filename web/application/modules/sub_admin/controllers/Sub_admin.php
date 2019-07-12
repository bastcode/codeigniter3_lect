<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sub_admin extends MY_Controller 
{
	function __construct()	{
		parent::__construct();

		$this->load-> library('session'); //세선사용
		$this->load-> library('pagination_custom_v3');
		//$this->load->model('common_model');		
		//$this->output->enable_profiler(true);
		$this->load-> library('admin_util');

	}
	public function _remap($method){

		$this->segs($method); //core 에서 로드 세그먼트 관련 유틸
		

		$data =array();
		$data['admin_lang'] = 'ko';

		
		//$this->load->view("/admin/common/aside_left_admin",$data);
		if( method_exists($this, $method) ){
			$this->{"{$method}"}();
		}
		
	}
	
	function index()
	{
		$this->admin_util->auth_check(); //권한 관련
		$data = array();
		$data['admin_lang'] = 'ko';

		
		
		//$data = $this->common_model->analytics();
		//print_r($data['db']);
		$this->load->view("/admin/common/header_admin",$data);
		$this->load->view("/admin/index_v",$data);		
		$this->load->view("/admin/common/footer_admin",$data);
	 }//end index 	

	 
	 function login()
	 {
		$this->admin_util->auth_check("login"); //권한 관련
		 //ajax_post_controller	 
		$data = array();
		$data['admin_lang'] = 'ko';
		$this->load->view("/admin/common/header_not_admin",$data);
		$this->load->view("/admin/login_v",$data);
		$this->load->view("/admin/common/footer_admin",$data);
	 }

	 

	 

 	
}

	
