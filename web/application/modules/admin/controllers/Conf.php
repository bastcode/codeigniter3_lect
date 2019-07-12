<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Conf extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this->load-> library('pagination_custom_v3');
		$this->load->model("conf_model");
		$this->load-> library('admin_util');
		$this->load->helper("url");
	}

	public function _remap($method) 
	{
		$this->segs($method); //core 에서 로드 세그먼트 관련 유틸
		$this->admin_util->auth_check(); //권한 관련

		$data =array();
		$data['admin_lang'] = 'ko';

		

		if ($this->input->is_ajax_request()) {			
			if (method_exists($this, $method)) {
				$this -> {"{$method}"}();
			}
		} else if(isset($this->segs[4]) && $this->segs[4] =="excel"){
			if (method_exists($this, $method))  $this -> {"{$method}"}();
		} else {//ajax가 아니면
			
			$this->load->view("/admin/common/header_admin",$data);
			//$this->load->view("/admin/common/aside_left_admin",$data);
			if( method_exists($this, $method) ){
				$this->{"{$method}"}();
			}
			$this->load->view("/admin/common/footer_admin",$data);
			//$this->output->enable_profiler(true);
		}
	}

	//모바일용 키워드 설정
	function mobile_keyword()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$input["table"] = "zd_main_product_keyword";
		$data = $this->_temp_pagen("conf_model","mobile_keyword", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/conf/mobile_keyword_v",$data);
		
	}


	function one_one_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 10;

		$input["table"] = "tb_inquiry";		
		$data = $this->_temp_pagen("conf_model","one_one_list", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/conf/one_one_list_v",$data);
	}

	function one_one_detail()
	{
		$input = array();
		$data = array();
		$id = $this->uri->segment(4);
		$input["id"] = $id;

		$one = $this->_temp_get("conf_model","one_one_detail", $input); //core 에 있음
		$data["one"] = $one["one"];

		//print_r($one);


		$data['input'] = $input;
		$this->load->view("/conf/one_one_detail_v",$data);
	}

	function one_one_proc()
	{


		$input = array();
		$input = $this->input->post(NULL, TRUE);
		$action = $this->uri->segment(4);
		/**  //별도의 xss 필터 추가.. 좀더 디테일 하게 필터 가능 http://htmlpurifier.org/  */
		/** 헬퍼에서 third_party 를 불러오고 있다 참고 */
		$this->load->helper('html_purify');		
		$input['content'] = html_purify($this->input->post("content",false));
		$input['Rcontent'] = html_purify($this->input->post("Rcontent",false));

		

		if($action){			
			if($action == "update"){

				$this->db->set("content",$input["content"]);
				$this->db->set("title",$input["title"]);
				$this->db->where("id", $input["id"]);
				$this->db->update("tb_inquiry");

				if($input['Rcontent']){					
					if($input["R_id"]){
						//update
						$this->db->set("inquiryId",$input["id"]);
						$this->db->set("adminId", 1);
						$this->db->set("content", $input['Rcontent']);
						$this->db->where("id", $input["R_id"]);
						$this->db->update("tb_inquiry_reply");
					}else{
						//insert
						$this->db->set("inquiryId",$input["id"]);
						$this->db->set("adminId", 1);
						$this->db->set("content", $input['Rcontent']);
						$this->db->set("createDatetime","NOW()",false);
						$this->db->insert("tb_inquiry_reply");
					}
						
				}


				redirect("/admin/conf/one_one_list");
				exit;
			}
			if($action == "delete"){
				$this->db->where("id", $input["id"]);
				$this->db->delete("tb_review");
				redirect("/admin/conf/one_one_list");
				exit;
			}
		}
		redirect("/admin/conf/one_one_list");

		

	}
	

	function partner_offer_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;

		$input["table"] = "tb_partner_offer";		
		$data = $this->_temp_pagen("conf_model","partner_offer_list", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/conf/partner_offer_v",$data);
	}

	function partner_offer_detail()
	{
		$input = array();
		$data = array();
		$id = $this->uri->segment(4);
		$input["id"] = $id;

		$review = $this->_temp_get("conf_model","partner_offer_detail", $input); //core 에 있음
		$data["info"] = $review["info"];


		$data['input'] = $input;
		$this->load->view("/conf/partner_offer_detail_v",$data);
	}

	

	/** 리뷰 */
	function review_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;

		$input["table"] = "tb_review";		
		$data = $this->_temp_pagen("conf_model","review_list", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/conf/review_list_v",$data);
	}

	function review_detail()
	{
		$input = array();
		$data = array();
		$id = $this->uri->segment(4);
		$input["id"] = $id;

		$review = $this->_temp_get("conf_model","review_detail", $input); //core 에 있음
		$data["review"] = $review["review"];


		$data['input'] = $input;
		$this->load->view("/conf/review_detail_v",$data);
	}

	function review_proc()
	{


		$input = array();
		$input = $this->input->post(NULL, TRUE);
		$action = $this->uri->segment(4);
		/**  //별도의 xss 필터 추가.. 좀더 디테일 하게 필터 가능 http://htmlpurifier.org/  */
		/** 헬퍼에서 third_party 를 불러오고 있다 참고 */

		$this->load->helper("html_purify");
		$input['content'] = html_purify($this->input->post("content",false));

		

		if($action){			
			if($action == "update"){

				$this->db->set("content",$input["content"]);
				$this->db->set("title",$input["title"]);
				$this->db->where("id", $input["id"]);
				$this->db->update("tb_review");
				redirect("/admin/conf/review_list");
				exit;
			}
			if($action == "delete"){
				$this->db->where("id", $input["id"]);
				$this->db->delete("tb_review");
				redirect("/admin/conf/review_list");
			}
		}
		redirect("/admin/conf/review_list");

		

	}

	/** 제작게시판 */
	

	function making_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 10;

		$input["table"] = "tb_making"; //주 사용 테이블
		$input["method"] =  null;
		$pageing = $this->_temp_pagen("api_model","making_list", $input, $linkCnt=3); //core에 있음  모델, 해당모델의 메소드, 파라메터[배열값] , 세그먼트타입일시 page 있는 위치
		$data = $pageing;
		$data['input'] = $input;
		$this->load->view("/conf/making_list_v",$data);
	}

	function making_form()
	{
		$data = array();
		$this->load->view("/conf/making_form_v",$data);
	}

	function making_detail()
	{
		
		$input = array();
		$data = array();
		$id = $this->uri->segment(4);
		$input["id"] = $id;

		$making = $this->_temp_get("conf_model","making_detail", $input); //core 에 있음
		$data["info"] = $making["info"];

		$this->load->view("/conf/making_detail_v",$data);
	}

	function making_proc()
	{
		$data = array();
		$input = array();
		$input = $this->input->post(NULL, false);
		$action = $this->uri->segment(4);
		/**  //별도의 xss 필터 추가.. 좀더 디테일 하게 필터 가능 http://htmlpurifier.org/  */
		/** 헬퍼에서 third_party 를 불러오고 있다 참고 */
		$this->load->helper('html_purify');		
		//$input['content'] = html_purify($this->input->post("content",false));
		$input['content'] = $this->input->post("content",false);

		

		if($action){			

			if($action == "insert"){
				$this->db->set("content",$input["content"]);
				$this->db->set("contentM",$input["contentM"]);
				$this->db->set("title",$input["title"]);
				$this->db->set("type",$input["type"]);
				$this->db->insert("tb_making");
			}


			if($action == "update"){

				$this->db->set("content",$input["content"]);
				$this->db->set("contentM",$input["contentM"]);
				$this->db->set("title",$input["title"]);
				$this->db->set("type",$input["type"]);
				$this->db->where("id", $input["id"]);
				$this->db->update("tb_making");

				
				
			}
			if($action == "delete"){
				$this->db->where("id", $input["id"]);
				$this->db->delete("tb_making");
				
			}
		}
		//echo		$this->db->last_query();
		redirect("/admin/conf/making_list");
		
	}

	
	/**  이벤트 */

	function event_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 10;

		$input["table"] = "tb_event"; //주 사용 테이블
		$input["method"] =  null;
		$pageing = $this->_temp_pagen("api_model","event_list", $input, $linkCnt=3); //core에 있음  모델, 해당모델의 메소드, 파라메터[배열값] , 세그먼트타입일시 page 있는 위치
		$data = $pageing;
		$data['input'] = $input;
		$this->load->view("/conf/event_list_v",$data);
	}

	function event_form()
	{
		$input = array();
		$data = array();
		$data['input'] = $input;
		$this->load->view("/conf/event_form_v",$data);
	}

	function event_detail()
	{
		$input = array();
		$data = array();
		$id = $this->uri->segment(4);
		$input["id"] = $id;
		$input["table"] = "tb_event"; //주 사용 테이블

		$info = $this->_temp_get("api_model","event_detail", $input);  //core에 있음  모델, 해당모델의 메소드, 파라메터[배열값]
		$data["info"] = $info["info"];

		//print_r($info);


		$data['input'] = $input;
		$this->load->view("/conf/event_detail_v",$data);
	}

	function event_proc()
	{
		$input = array();
		$input = $this->input->post(NULL, false);
		$action = $this->uri->segment(4);
		/**  //별도의 xss 필터 추가.. 좀더 디테일 하게 필터 가능 http://htmlpurifier.org/  */
		/** 헬퍼에서 third_party 를 불러오고 있다 참고 */
		$this->load->helper('html_purify');		
		//$input['content'] = html_purify($this->input->post("content",false));

		

		if($action){
			if($action == "insert"){

				$this->db->set("content",$input["content"]);
				$this->db->set("title",$input["title"]);
				$this->db->set("startDate",$input["startDate"]);
				$this->db->set("endDate",$input["endDate"]);

				$this->db->set("coupon_group_code",$input["coupon_group_code"]); //idx 들어있음

				if($_FILES ){

					$file=$this->_do_upload_multi('couponImage1');
					$file2=$this->_do_upload_multi('couponImage2');
					$file3=$this->_do_upload_multi('eventTitleImage');
					

					if($file['status']) {
						$this->db->set("couponImage1",$file["ObjectURL"]);
					}
					if($file2['status']) {
						$this->db->set("couponImage2",$file2["ObjectURL"]);
					}
					if($file3['status']) {
						$this->db->set("tit_img",$file3["ObjectURL"]);
					}				
				}

				//print_r($_FILES);
				//$this->db->where("id", $input["id"]);
				$this->db->insert("tb_event");
				$insert_id =  $this->db->insert_id();


				

				redirect("/admin/conf/event_list");
				exit;
			}

			if($action == "update"){

				$this->db->set("content",$input["content"]);
				$this->db->set("title",$input["title"]);

				$this->db->set("startDate",$input["startDate"]);
				$this->db->set("endDate",$input["endDate"]);
				$this->db->set("coupon_group_code",$input["coupon_group_code"]); //idx 들어있음
				
				if($_FILES ){

					$file=$this->_do_upload_multi('couponImage1');
					$file2=$this->_do_upload_multi('couponImage2');
					$file3=$this->_do_upload_multi('eventTitleImage');
					

					if($file['status']) {
						$this->db->set("couponImage1",$file["ObjectURL"]);
					}
					if($file2['status']) {
						$this->db->set("couponImage2",$file2["ObjectURL"]);
					}
					if($file3['status']) {
						$this->db->set("tit_img",$file3["ObjectURL"]);
					}

				
				}

				$this->db->where("id", $input["id"]);
				$this->db->update("tb_event");

				//echo $this->db->last_query();
				redirect("/admin/conf/event_list");
				exit;
			}
			if($action == "delete"){
				$this->db->where("id", $input["id"]);
				$this->db->delete("tb_event");
				redirect("/admin/conf/event_list");
			}
		}
		redirect("/admin/conf/event_list");
	}




	function event_win_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 10;

		$input["table"] = "tb_event_winner"; //주 사용 테이블
		$input["method"] =  null;
		$pageing = $this->_temp_pagen("api_model","event_win_list", $input, $linkCnt=3); //core에 있음  모델, 해당모델의 메소드, 파라메터[배열값] , 세그먼트타입일시 page 있는 위치
		$data = $pageing;
		$data['input'] = $input;
		$this->load->view("/conf/event_win_list_v",$data);
	}

	function event_win_proc()
	{
		$this->load->library("Secretlib");
		$input = array();
		$input = $this->input->post(NULL, false);
		$action = $this->uri->segment(4);

		//print_r($input);

		if($action == "coupon"){
			//echo "??co";
			$re = $this->conf_model->event_win_update($input);
			//print_r($re);
		}


	}


	/** 메타 config 데이터 */
	function meta()
	{
		
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;

		$input["table"] = "tb_config_meta"; //주 사용 테이블		
		$pageing = $this->_temp_pagen("conf_model","meta_list", $input, $linkCnt=3); //core에 있음  모델, 해당모델의 메소드, 파라메터[배열값] , 세그먼트타입일시 page 있는 위치
		$data = $pageing;
		$data['input'] = $input;
		$this->load->view("/conf/meta_list_v",$data);


	}

	/** 메타 config file 데이터 */
	function files()
	{
		
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;

		$input["table"] = "tb_config_meta_files"; //주 사용 테이블		
		$pageing = $this->_temp_pagen("conf_model","meta_file_list", $input, $linkCnt=3); //core에 있음  모델, 해당모델의 메소드, 파라메터[배열값] , 세그먼트타입일시 page 있는 위치
		$data = $pageing;
		$data['input'] = $input;
		$this->load->view("/conf/meta_file_list_v",$data);


	}

	function meta_file_proc()
	{
		$input = array();

		$input = $this->input->post(NULL, TRUE);

		$action = $this->uri->segment(4);
		//print_r($input);

		if($action == "insert" ){

			if($_FILES ){

				//print_r($_FILES );
				$this->load->library('upload');
				$this->load-> library('aws');
				$files = $_FILES;
				$s3 = null;
				$config = array();
				$config['upload_path']   = FCPATH . 'uploads/files/temp/';	
				$config['allowed_types'] = '*';
				$config['max_size']      = '20480';
				$config['overwrite']     = false;
				$this->upload->initialize($config);

				$target_file = "Ufiles";
			
				if ( !$this->upload->do_upload($target_file)) {
					$error = array('error' => $this->upload->display_errors());
					print_r($error);
				
				
				} else {		
					$data = array('upload_data' => $this->upload->data());
					//echo "<pre>";print_r($data);				
					$s3path = 'uploads/files/';	
								
		
					$s3 = $this->aws->s3_upload($data["upload_data"]["file_name"],$s3path,$data["upload_data"]["file_path"]); //field name, s3path, filepath
					//unlink("/uploads/files/temp/" .$data['upload_data']['file_name']); //file delete
					//echo $s3["ObjectURL"]; //실제 저장된 주소
					//echo $config['upload_path'] .$data['upload_data']['file_name'];

					$this->load->helper('file');
					delete_files($config['upload_path']);							
				}
			
				//print_r($s3);
				if(isset($s3["status"]) && $s3["status"] ){

					$this->db->set("type",$data["upload_data"]["file_type"]);
					$this->db->set("meta","file");
					$this->db->set("value",$s3["ObjectURL"]);
					$this->db->set("discript",$input["discript"]);
					$this->db->insert("tb_config_meta_files");
					alert("업로드 ok","/admin/conf/files");
				}else{
					//alert("업로드 실패하였습니다. 다시시도해주십시오.","/admin/conf/files");
				}

			}
			exit;
		}

		if($action == "delete" ){
			$this->db->where("idx",$input["id"]);
			$this->db->delete("tb_config_meta_files");
			$this->load->helper('file');
			$config['upload_path']   = FCPATH . 'uploads/files/temp/';	
			delete_files($config['upload_path']);
			alert("파일을 삭제하였습니다. ok","/admin/conf/files");
			exit;
		}
		alert("잘못된 접근입니다","/admin/conf/files");
	}

	function _do_upload_multi($target_file, $insertId = null)
	{       
		$this->load->library('upload');
		$this->load-> library('aws');
		$files = $_FILES;
		//echo "tt="; echo "'$target_file'"."<br>";		
		$cpt = count($_FILES["$target_file"]['name']);
		$target_file_temp = $target_file."_temp";
		for($i=0; $i<$cpt; $i++) {
			$s3 = null;
			$_FILES["$target_file_temp"]['name']   =	$files["$target_file"]['name'][$i];
			$_FILES["$target_file_temp"]['type'] = 		$files["$target_file"]['type'][$i];
			$_FILES["$target_file_temp"]['tmp_name'] = 	$files["$target_file"]['tmp_name'][$i];
			$_FILES["$target_file_temp"]['error'] =		$files["$target_file"]['error'][$i];
			$_FILES["$target_file_temp"]['size'] = 		$files["$target_file"]['size'][$i];
			
			//print_r($_FILES);
			//print_r($this->_set_upload_options());
			$upload_config = $this->_set_upload_options();
			$this->upload->initialize($this->_set_upload_options());						
			if ( !$this->upload->do_upload($target_file_temp)) {
				$error = array('error' => $this->upload->display_errors());
				//print_r($error);
				return false;
			
			} else {		
				$data = array('upload_data' => $this->upload->data());
				//print_r($data);				
				$s3path = 'uploads/event/couponImage/';				
	
				$s3 = $this->aws->s3_upload($data["upload_data"]["file_name"],$s3path,$data["upload_data"]["file_path"]); //field name, s3path, filepath
				@unlink($data['upload_data']['full_path']); //file delete
				//echo $s3["ObjectURL"]; //실제 저장된 주소
							
			}
		}
		return $s3;
	}

	function _set_upload_options()
	{   
		//upload an image options
		$config = array();
		$config['upload_path']   = FCPATH . 'uploads/event/couponImage/';
		//$config['upload_path']   = FCPATH . 'uploads/product/temp/';
		///product/temp/
		$config['allowed_types'] = '*';
		$config['max_size']      = '20480';
		$config['overwrite']     = false;
		return $config;
	}

}