<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends MY_Controller 
{
	function __construct()	{
		parent::__construct();

		$this->load-> library('session'); //세선사용
		$this->load-> library('pagination_custom_v3');
		$this->load->model('member_model'); //모델호출		
		//$this->output->enable_profiler(true);
		$this->load-> library('admin_util');
	}
	public function _remap($method){

		$this->segs($method); //core 에서 로드 세그먼트 관련 유틸
		$this->admin_util->auth_check(); //권한 관련

		$data =array();
		$data['admin_lang'] = 'ko';

		if($this->input->is_ajax_request()){
			if( method_exists($this, $method) ){
				$this->{"{$method}"}();
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
		
	
		
	 }
	 
	 public function member_list() {
		$input = $this->input->get(null, true);
		$input["table"] = "tb_member"; //타겟 테이블 설정
		if(!isset($input["page"])) $input["page"] = 1;  //페이지네이션 설정
		if(!isset($input["pagelist"])) $input["pagelist"] = 15;  //페이지네이션 값 설정
		//휴대전화로 넘어오면 자동으로 -  제거
		if(isset($input["sfl"]) && $input["sfl"] == "mobile") $input["stx"] = str_replace(" ","",str_replace("-","",$input["stx"]));

		// 로드할 모델, 해당 모델의 함수명, 넘기는 파라메터,   메소드타입설정 [get or segment]
		$data = $this->_temp_pagen("member_model","member_list", $input, "get");
		$data['input'] = $input;
		$this->load->view("/member/member_list_v",$data);

	 }

	 public function member_modify()
	 {
		
		 $input = array();
		 if(!isset($input["page"])) $input["page"] = 1;
		 if(!isset($input["pagelist"])) $input["pagelist"] = 5;
		 //foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		 //$this->segs[4]; 회원아이디
		 $data = array("id"=>$this->segs[4]);
		 $input["table"] = "tb_member";
		 $input["memberId"] = $this->segs[4];
		 
		 $db = $this->member_model->select_one($input["table"],array("id"=>$this->segs[4]));
		 $data['member'] = $db['rows'];
		 //$data['money'] = $this->member_model->select_sum("tb_member_saved_money", array("memberId"=>$this->segs[4]), "money");
		 
		 $input["table"] = "tb_member_coupon";	 
		 //$db_coupon = $this->member_model->mycoupon($input); //memberId 만 넘김
		 
		 $data['mycoupon'] = $this->_temp_pagen("member_model","mycoupon", $input, "get");
		 
		 //print_r($data['mycoupon']);
		 
		 //$db_coupon = $this->member_model->mycoupon($this->segs[4]); //memberId 만 넘김
		 
		 $this->load->view("/member/member_modify_v",$data);
	 }
	 
	 function member_crud()
	 {


		$input = array();
		$input = $this->input->post(NULL, TRUE);
		if(!isset($input['action']))  $input["action"] = "noAction";

		 //일단 수정만..
		 if($this->segs[4] == "modify" && $input["action"] == "update")
		 {
			 
			 //foreach($this->input->post(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
			 //print_r($input);
 
			 $update = array();
			 if(isset($input['first_name'])) $update['first_name'] = $input['first_name'];
			 if(isset($input['last_name'])) $update['last_name'] = $input['last_name'];
			 if(isset($input['yomi_first_name'])) $update['yomi_first_name'] = $input['yomi_first_name'];
			 if(isset($input['yomi_last_name'])) $update['yomi_last_name'] = $input['yomi_last_name'];

			 if(isset($input['password']) && $input['password']) $update['password'] = hash("512",$input['password']); //값이 있을때만 업데이트
			 if(isset($input['auth_lv'])) $update['auth_lv'] = $input['auth_lv'];
			 if(isset($input['mobile'])) $update['mobile'] = $input['mobile'];
			 //$table, $where_set, $data
 
			 //if($update['password']) $update['password'] = md5($update['password']);
			 $db = $this->member_model->update('tb_member',array("field"=>"id","id"=>$input["memberId"]),$update); //모델에 들어가서 찾지마라. MY 에서 상속된거다
			 $result = array();
			 $result['status'] = $db;
			 $result['message'] = "edit ok";
			 print_r( json_encode($result));
			 //alert("수정되었습니다.","/admin/member/member_list");
		 }else{
			$result = array();
			$result['status'] = false;
			$result['message'] = "no action";
			print_r( json_encode($result));
 
		 }
	 }
  	
}

	
