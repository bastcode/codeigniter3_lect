<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coupon extends MY_Controller 
{
	function __construct()	{
		parent::__construct();

		$this->load-> library('session'); //세선사용
		$this->load-> library('pagination_custom_v3');
		$this->load->model('coupon_model');
		$this->load-> library('admin_util');
		$this->load->helper("url");
		$this->load->helper("alert");


		//$this->output->enable_profiler(true);
	}
	public function _remap($method){

		$this->segs($method); //core 에서 로드 세그먼트 관련 유틸
		$this->admin_util->auth_check(); //권한 관련

		$data =array();
		$data['admin_lang'] = 'ko';


		if(isset($this->segs[4]) && $this->segs[4] =="popup"){
			
			if( method_exists($this, $method) ){
				$this->load->view("/admin/common/header_pop_admin",$data);
				$this->{"{$method}"}();
				$this->load->view("/admin/common/footer_pop_admin",$data);
			}
			
		}else{

			$this->load->view("/admin/common/header_admin",$data);
			//$this->load->view("/admin/common/aside_left_admin",$data);
			if( method_exists($this, $method) ){
				$this->{"{$method}"}();
			}
			$this->load->view("/admin/common/footer_admin",$data);
		}
		
	}
	
	public function index()
	{
		
		redirect("/admin/coupon/coupon_list"); //자동으로 리스트로 보낸다
	}

	/** 발급한 쿠폰 리스트 */
	public function coupon_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$input["table"] = "tb_coupon_group";
		$data = $this->_temp_pagen("coupon_model","coupon_list", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/coupon/coupon_list_v",$data);
	}

	/** 쿠폰 생성 폼*/
	public function coupon_form()
	{
		$data = array();
		$this->load->view("/coupon/coupon_form_v",$data);

	}

	/** 쿠폰 그룹 상세 */
	public function coupon_detail()
	{
		$input = array();
		$data = array();
		$id = $this->uri->segment(4);
		$input["id"] = $id;

		$coupon = $this->_temp_get("coupon_model","coupon_detail", $input); //core 에 있음


		$setProduct = array();
		if($coupon['coupon_group']){
			$set = explode(",",$coupon['coupon_group']['exption_product']);
			$setProduct = $this->coupon_model->select_in("tb_product", "id",$set);
			//echo $this->db->last_query();
		}

		$setCategory = array();
		if($coupon['coupon_group']){
			$set = explode(",",$coupon['coupon_group']['apply_category']);
			$setCategory = $this->coupon_model->select_in("tb_category", "id",$set);
			//echo $this->db->last_query();
		}


		//print_r($coupon);
		$data["info"] = $coupon["coupon_group"];
		$data["total_count"] = $coupon["total_count"];
		$data["total_use_count"] = $coupon["total_use_count"];
		$data["info"]["setProduct"] = $setProduct;
		$data["info"]["setCategory"] = $setCategory;
		//print_r($data['info']);
		$this->load->view("/coupon/coupon_detail_v",$data);
	}

	public function coupon_pop_search()
	{
		$input = array();
		$data = array();
		$id = $this->uri->segment(4);

		//foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		$input = $this->input->get(null, true);
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$input["table"] = "tb_product";
		$input["notset"] = true;
		$input["cateOrder"] = true;
		$data = $this->_temp_pagen("product_model","product_list", $input, $linkCnt=3);
		$data['input'] = $input;
		
		$this->load->view("/coupon/coupon_pop_search_v",$data);
	}

	/** 쿠폰 처리 프로세스 */
	public function coupon_proc()
	{
		$input = $this->input->post();
		$action = $this->uri->segment(4);
		$this->load->library("Secretlib");

		//print_r($input);	exit;
		if($action){
			if($action == "create"){				
				$this->_temp_get("coupon_model","coupon_create", $input); //core 에 있음
			}
			if($action == "add"){
				$this->_temp_get("coupon_model","coupon_add", $input); //core 에 있음
			}

			//수정
			if($action == "update"){
				$this->_temp_get("coupon_model","coupon_update", $input); //core 에 있음

			}
		}

		//alert();
		redirect("/admin/coupon/coupon_list"); //자동으로 리스트로 보낸다
	}

	/** 사용한 쿠폰 리스트 */
	public function coupon_use_list()
	{

		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$input["table"] = "tb_coupon";
		$data = $this->_temp_pagen("coupon_model","coupon_use_list", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/coupon/coupon_use_list_v",$data);
	}
	


	 
	 

	 

 	
}

	
