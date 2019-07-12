<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Movie extends MY_Controller {
	function __construct() {
		parent::__construct();
		//$this->load->model('order_model');
		//$this->load->helper('common');
		$this->load-> library('pagination_custom_v3');
		$this->load-> library('session');
		$this->load-> library('admin_util');
	}

	public function _remap($method) {
		
		$this->segs($method); //core 에서 로드 세그먼트 관련 유틸
		$this->admin_util->auth_check(); //권한 관련


		$data =array();
		$data['admin_lang'] = 'ko';

		$this->load->view("/admin/common/header_admin",$data);
		//$this->load->view("/admin/common/aside_left_admin",$data);
		if( method_exists($this, $method) ){
			$this->{"{$method}"}();
		}
		$this->load->view("/admin/common/footer_admin",$data);
	}

	function index(){}//end index

	function maker_list()
	{
		$input = array();
		//foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		$input = $this->input->get(NULL, TRUE);
		//print_r($input);

		if(!isset($input['conditions'])) $input['conditions'] = array();
		//print_r( $input['conditions']);




		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$input["table"] = "tb_movie_maker";
		$data = $this->_temp_pagen("movie_model","maker_list", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/movie/maker_list_v",$data);
	}

	public function movie_detail()
	{
		$input = array();
		$data = array();
		//foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		$input = $this->input->get(NULL, TRUE);

		

		
		$input["id"] = $this->segs[4]; //ID
		//if(!isset($input["no"])) alert('not select product Id');
		
		$movie = $this->_temp_get("movie_model","movie_detail", $input); //core 에 있음
		$data = $movie;

		//print_r($movie);
		$data['input'] = $input;	
		
		
		$this->load->view("/movie/movie_detail_v",$data);
	}
	
	function store_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$input["table"] = "tb_movie_store";
		$data = $this->_temp_pagen("movie_model","store_list", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/movie/store_list_v",$data);
	}
	
	
	

}//end
