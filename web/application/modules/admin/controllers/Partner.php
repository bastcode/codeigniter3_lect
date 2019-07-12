<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Partner extends MY_Controller 
{
	function __construct()	{
		parent::__construct();

		$this->load-> library('session'); //세선사용
		$this->load-> library('pagination_custom_v3');
		$this->load-> library('admin_util');
		
		//$this->segs = $this->uri->segment_array();
		//$this->output->enable_profiler(true);
	}
	public function _remap($method){

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
	
	public function index()
	{
		$this->load->helper("url");
		redirect("/admin/partner/partner_list"); //자동으로 리스트로 보낸다
		
	}

	/** 협력업체 리스트 */
	public function partner_list()
	{

		$data = array();
		$input = $this->input->get(null, true);
		$input["table"] = "tb_company"; //타겟 테이블 설정
		if(!isset($input["page"])) $input["page"] = 1;  //페이지네이션 설정
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;  //페이지네이션 값 설정
		
		// 로드할 모델, 해당 모델의 함수명, 넘기는 파라메터,   메소드타입설정 [get or segment]
		$data = $this->_temp_pagen("partner_model","partner_list", $input, "get");
		$data['input'] = $input;
		
		$this->load->view("/partner/partner_list_v",$data);

	}

	/** 협력업체 등록 */
	public function partner_form()
	{
		$data = array();
		$this->load->view("/partner/partner_form_v",$data);

	}

	/** 협력업체 수정 */
	public function partner_modify()
	{		
		$data = array();
		$input = $this->input->get(NULL,true);
		if(!isset($input["id"])) $input["id"] = 1;

		$partner = $this->_temp_get("partner_model","partner_detail", $input); //core 에 있음
		$data["partner"] = $partner;
		$this->load->view("/partner/partner_modify_v",$data);
	}

	/** 협력업체 프로세스 */
	public function partner_proc()
	{
		
		$input = $this->input->post(NULL,true);
		$method = $this->uri->segment(4);
		//print_r($input);

		//modify

		if($method){
			if($method == "add"){
				$db = $this->_temp_get("partner_model","partner_insert", $input); //core 에 있음
				
			}

			if($method == "modify"){
				$db = $this->_temp_get("partner_model","partner_modify", $input); //core 에 있음
			}
		}
		$this->index();

	}



	 
	 

	 

 	
}

	
