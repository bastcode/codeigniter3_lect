<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller 
{
	function __construct()	{
		parent::__construct();

		$this->load-> library('session'); //세선사용
		$this->load-> library('pagination_custom_v3');

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
	
	function mailtest()
	{
		//echo "test!";


		
		


		$this->load->library('email');
		$config = array();
		/*
		$config['useragent'] = 'thedays';
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'ssl://smtp.naver.com';
		$config['smtp_user'] = '';
		$config['smtp_pass'] = '';
		$config['smtp_port'] = 465; 
		$config['smtp_timeout'] = 50;
		$config['wordwrap'] = TRUE;
		$config['wrapchars'] = 76;
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['validate'] = FALSE;
		$config['priority'] = 3;
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		$config['bcc_batch_mode'] = FALSE;
		$config['bcc_batch_size'] = 200;
		*/

		$config['useragent'] = 'momentto';
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'ssl://smtp.googlemail.com';
		$config['smtp_user'] = 'cs@momentto.jp';
		$config['smtp_pass'] = 'thedays0211';
		$config['smtp_port'] = 465;
		$config['smtp_timeout'] = 5;
		$config['wordwrap'] = TRUE;
		$config['wrapchars'] = 76;
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['validate'] = FALSE;
		$config['priority'] = 3;
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		$config['bcc_batch_mode'] = FALSE;
		$config['bcc_batch_size'] = 200;

		$this->email->initialize($config);
		
		//$this->email->from("kudomiyu@naver.com",'thedays'); //보내는쪽
		$this->email->from("cs@momentto.jp",'momentto'); //보내는쪽
		$this->email->to("kudomiyu@naver.com"); //받는쪽


		$title = "1:1 질문 답변";
		$this->email->subject($title);
		$this->email->message("test !!!!!");
		//$this->email->message($CI->load->view($location .'/mailTemplate/order', $data, TRUE)); //메세지
		//$this->email->set_alt_message($this->load->view('email/'.$type.'-txt', $data, TRUE)); //html 메일을 못받는 경우 txt 파일로 대체

		//CC BCC 설정 시
		//		$this->email->cc('another@another-example.com'); 
		//		$this->email->bcc('them@their-example.com'); 
		
		$status = $this->email->send(); //true false return
		//if($status) echo "<br />이메일이 정상적으로 전송 되었습니다!";
		echo $this->email->print_debugger();

	}

	function pull()
	{
		exec("git pull");
	}
	
	function index()
	{
		
		$data = array();
		$data['admin_lang'] = 'ko';
		$input = array();

		
		
		//$data = $this->common_model->analytics();
		//print_r($data['db']);
		$member = $this->_temp_get("conf_model","now_day_member", $input); //core 에 있음		
		$data["member_total_cnt"] = $member["total_cnt"];
		$data["now_day_member_cnt"] = $member["now_day_member_cnt"];

		$order = $this->_temp_get("conf_model","now_day_order", $input); //core 에 있음
		$data["order_total_cnt"] = $order["total_cnt"];
		$data["now_day_order_cnt"] = $order["now_day_order_cnt"];

		$qna_list = $this->_temp_get("conf_model","qna_list", $input); //core 에 있음
		$partner_in_list = $this->_temp_get("conf_model","partner_in_list", $input); //core 에 있음
		$review_list = $this->_temp_get("conf_model","admin_review_list", $input); //core 에 있음

		$data["qna_list"] = $qna_list["qna_list"];		
		$data["partner_in_list"] = $partner_in_list["partner_in_list"];
		$data["review_list"] = $review_list["review_list"];



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

	 function logOut()
	 {
		$this->session->sess_destroy();
		$this->load->helper("url");
		redirect("/page/index"); //자동으로 리스트로 보낸다
	 }

	 function pop_playMovie()
	 {
		 $input = $this->input->get(NULL, TRUE);
		 $data = array();
		 $data['admin_lang'] = 'ko';
		 $store = $this->_temp_get("movie_model","store_detail", $input); //core 에 있음
		 $data["store"] = $store["store"];

		 $this->load->view("/admin/common/header_pop_admin",$data);
		 $this->load->view("/admin/playMovie_v",$data);
		 $this->load->view("/admin/common/footer_pop_admin",$data);
		 
	 }

	 function pop_movie_down()
	 {
		 $input = $this->input->post(NULL, TRUE);
		 $data = array();
		 $data['admin_lang'] = 'ko';
		 $store = $this->_temp_get("movie_model","store_detail", $input); //core 에 있음
		 $data["store"] = $store["store"];

		 $data["url"] = $store["store"]["filePath"]."/".$store["store"]["fileName"];

		 print_r(json_encode($data));

		 //$this->load->view("/admin/common/header_pop_admin",$data);
		 //$this->load->view("/admin/pop_movie_down_v",$data);
		 //$this->load->view("/admin/common/footer_pop_admin",$data);
		 
	 }

	 /** 쿠폰 다운로드 */
	 function coupon_excel_down()
	 {


		header( " charset=utf-8");		
		$input = $this->input->get(null, true); 
		$input["table"] = "tb_coupon"; //타겟 테이블 설정

		if(!isset($input["page"])) $input["page"] = 1;  //페이지네이션 설정
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;  //페이지네이션 값 설정

		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
	
		//AES_DECRYPT(UNHEX(필드명), '암호화 키') 
		//AES_DECRYPT(UNHEX(T1.coupon_number), "momentto") as coupon 
		$this->db->select('SQL_CALC_FOUND_ROWS T1.coupon_number, T1.use_memberEmail, 
		CASE T1.is_use WHEN 0 THEN "未使用" WHEN 1 THEN "使用" END,
		T1.use_dateTime
		 ',false);
		 $this->db->from($input['table']." as T1");
		 $this->db->join("tb_coupon_group as G","T1.coupon_group_code = G.id","inner");
		 $this->db->join("tb_company as C","G.company_id = C.cp_code ","inner");
 
 
		 if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){
			 if($input["sfl"] == "coupon_number") {
				 $stx = $input["stx"];
				 //$this->db->where("T1.coupon_number = ", "HEX(AES_ENCRYPT('".$stx."', 'momentto'))",false,false);
				 $this->db->where("T1.coupon_number ", $stx);  //암호 없애기로 함 선아 팀장 백.
			 }
		 }
 
		 if(isset($input["use_coupon"]) && $input["use_coupon"]){
 
			 if($input["use_coupon"] == "not_use") {
				 //미사용
				 $this->db->where("T1.is_use", false);
				 $this->db->where("T1.use_memberEmail is  null",false,false);
			 }
			 if($input["use_coupon"] == "is_use") {
				 //사용
				 $this->db->where("T1.is_use", true);
			 }
 
		 }
 
	 
		 if(isset($input["sfl"]) && isset($input["stx"])){
			 //쿠폰이름
			 if($input["sfl"] == "coupon_name"){
				 $this->db->like("G.coupon_name", $input["stx"]);
			 }
 
			 //쿠폰 설명
			 if($input["sfl"] == "coupon_descript"){
				 $this->db->like("G.coupon_descript", $input["stx"]);
			 }
			 
		 }
 
		 
		 
 
		 //쿠폰 회사 별로 정산
		 if(isset($input["company_name"]) && $input["company_name"]){
			 $this->db->where("G.company_id", $input["company_name"]);
		 }
 
		 //쿠폰 사용일
		 if(isset($input["sdate"]) && $input["sdate"]  && isset($input["use_coupon"]) && $input["use_coupon"] != "not_use" ) $this->db->where("T1.use_dateTime >=", $input["sdate"]);
		 if(isset($input["edate"]) && $input["edate"]  && isset($input["use_coupon"]) && $input["use_coupon"] != "not_use" ) $this->db->where("T1.use_dateTime <=", date('Y-m-d', strtotime($input["edate"].'+1 day')));
 
		 $this->db->order_by("T1.id","desc");
		 $this->db->limit($input["pagelist"],$limit_ofset);		

		//$result['page_list_m']= $this->db->get()->result_array();
		//echo $this->db->last_query(); //마지막에 실행된 쿼리 출력
		//$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;


		$this->load->library('table');
		$this->load->helper('download');
		$query = $this->db->get();
		$total = $this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;

		$name = 'coupon_list_'.date("Ymd").'.xls';
		$this->table->set_heading('쿠폰번호', '사용회원이메일', '사용상태','사용시간');
	

		$data =  $this->table->generate($query);//테이블 만듬
		
		$cell = array('data' => "총 ".$total."개", 'class' => 'highlight', 'colspan' => 3); 
		$this->table->add_row($cell); //총합 더한거 추가함
		$data .= $this->table->generate(); //데이터 더합

		//echo $data;
		force_download($name,  "\xEF\xBB\xBF" .$data); //파일 다운로드
		//echo $this->db->last_query();




	 }

	 /** 회원 엑셀 다운로드 */
	 function member_excel_down()
	 {
		header( " charset=utf-8");		
		$input = $this->input->get(null, true); 
		$input["table"] = "tb_member"; //타겟 테이블 설정

		if(!isset($input["page"])) $input["page"] = 1;  //페이지네이션 설정
		if(!isset($input["pagelist"])) $input["pagelist"] = 15;  //페이지네이션 값 설정

		
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		
		$this->db->select('SQL_CALC_FOUND_ROWS 
			CONCAT(T1.first_name," ",T1.last_name) AS memberName, CONCAT(T1.yomi_first_name," ",T1.yomi_last_name) AS memberName2,
			T1.email, T1.mobile, 
			CASE T1.auth_lv WHEN 4 THEN "일반회원" WHEN 7 THEN "운영자" WHEN 8 THEN "매니저운영자" WHEN 99 THEN "슈퍼 관리자" END,
			T1.createDatetime		
		',false);
		$this->db->from($input['table']." as T1");
		if(isset($input["sdate"]) && $input["sdate"]) $this->db->where("T1.create_datetime >=", $input["sdate"]);
		if(isset($input["edate"]) && $input["edate"]) $this->db->where("T1.create_datetime <=", date('Y-m-d', strtotime($input["edate"].'+1 day')));

		//검색 조건 추가
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			if($input["sfl"] == "memberEmail") $this->db->like("T1.email", $input["stx"]);

			//일반이름
			if($input["sfl"] == "memberName") {
				$this->db->or_like("T1.first_name", $input["stx"]);
				$this->db->or_like("T1.last_name", $input["stx"]);
			}

			//요미이름
			if($input["sfl"] == "yomiName") {
				$this->db->or_like("T1.yomi_first_name", $input["stx"]);
				$this->db->or_like("T1.yomi_last_name", $input["stx"]);

			}
			        		 
		}
		
		$this->db->order_by("T1.id","desc");		
		$this->db->limit($input["pagelist"],$limit_ofset);

		//$result['page_list_m']= $this->db->get()->result_array();
		//echo $this->db->last_query(); //마지막에 실행된 쿼리 출력
		//$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;



		/**  */

		$this->load->library('table');
		$this->load->helper('download');
		$query = $this->db->get();
		$total = $this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;

		$name = 'member_list_'.date("Ymd").'.xls';
		$this->table->set_heading('회원이름', '회원이름2', 'email','연락처','권한레벨','가입일');


		/*
		$price = 0;
		foreach($query->result_array() as $key => $val){			
			$p = str_replace(",","",$val["price"]); //스트링값으로 들어가서 일단 제거
			$price = $price + (int) $p; //총합 구하기
		}

		$price = number_format($price);
		$price = "판매액 =".$price;
		*/
		//echo $price;


		

		$data =  $this->table->generate($query);//테이블 만듬
		
		$cell = array('data' => "총 ".$total."명", 'class' => 'highlight', 'colspan' => 3); 
		$this->table->add_row($cell); //총합 더한거 추가함
		$data .= $this->table->generate(); //데이터 더합

		//echo $data;
		force_download($name,  "\xEF\xBB\xBF" .$data); //파일 다운로드
		//echo $this->db->last_query();
		



	 }


	 /** 주문 엑셀 다운로드 */
	 function order_excel_down()
	 {

		header( " charset=utf-8");		
		$input = $this->input->get(null, true);
		
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 10;
		$input["table"] = "tb_order";
		
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;
		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		
		$this->db->select('SQL_CALC_FOUND_ROWS T1.id, FORMAT(T1.price,0) as price, T1.device, I.productName, M.email, T1.paymentDatetime  ',false);
		$this->db->from($input['table']." as T1");
		$this->db->join("tb_order_item as I","T1.id = I.orderId","inner");
		$this->db->join("tb_member as M","T1.memberId = M.id","left");

		
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			if($input["sfl"] == "productName") $this->db->like("I.productName", $input["stx"]);
			if($input["sfl"] == "orderId") $this->db->like("T1.id", $input["stx"]);
			if($input["sfl"] == "memberEmail") $this->db->like("T1.memberEmail", $input["stx"]);
		}
		
		if(isset($input["guest"])) $this->db->where("T1.memberId IS NULL");
		//if(isset($input["open_market"])) $this->db->where("T1.open_market IS NOT NULL");

		if(isset($input["sdate"]) && $input["sdate"]) $this->db->where("T1.createDatetime >=", $input["sdate"]);
		if(isset($input["edate"]) && $input["edate"]) $this->db->where("T1.createDatetime <=", date('Y-m-d', strtotime($input["edate"].'+1 day')));
				
		$this->db->group_by("T1.id");
		$this->db->order_by("T1.createDatetime","desc");
		
		$this->db->limit($input["pagelist"],$limit_ofset);


		/** 다운로드  */
		$this->load->library('table');
		$this->load->helper('download');
		$query = $this->db->get();

		$name = 'order_list_'.date("Ymd").'.xls';
		$this->table->set_heading('주문번호', '가격', 'device','상품명','이메일','주문일');

		$price = 0;
		foreach($query->result_array() as $key => $val){			
			$p = str_replace(",","",$val["price"]); //스트링값으로 들어가서 일단 제거
			$price = $price + (int) $p; //총합 구하기
		}
		//echo $price;


		$price = number_format($price);
		$price = "판매액 =".$price;

		$data =  $this->table->generate($query);//테이블 만듬
		$cell = array('data' => $price, 'class' => 'highlight', 'colspan' => 3); 
		$this->table->add_row($cell); //총합 더한거 추가함
		$data .= $this->table->generate(); //데이터 더합

		//echo $data;
		force_download($name,  "\xEF\xBB\xBF" .$data); //파일 다운로드
		//echo $this->db->last_query();
	 }
	 

	 function coupon_list_excel_down()
	 {


		header( " charset=utf-8");		
		$input = $this->input->get(null, true);
		
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 10;
		$input["table"] = "tb_coupon";

		$this->db->select("SQL_CALC_FOUND_ROWS C.cp_name, G.coupon_name, T1.coupon_number, T1.use_memberEmail, T1.is_use, T1.use_datetime ",false);
		$this->db->from($input['table']." as T1");
		$this->db->join("tb_coupon_group as G","T1.coupon_group_code = G.id","inner");
		$this->db->join("tb_company as C" ,"G.company_id = C.cp_code" , "innser");
		$this->db->where("T1.coupon_group_code", $input["id"]);

		/** 다운로드  */
		$this->load->library('table');
		$this->load->helper('download');
		$query = $this->db->get();
		$total = $this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		
		//사용갯수 
		$this->db->select("count(*) as cnt", false);
		$this->db->from($input['table']." as T1");
		$this->db->where("T1.coupon_group_code", $input["id"]);
		$this->db->where("T1.is_use", "1");
		$use = $this->db->get()->row()->cnt;

		$name = 'coupon_list_'.date("Ymd").'.xls'; //파일네임
		$this->table->set_heading('발급회사', '쿠폰명', '쿠폰번호', '사용유저', '사용체크',  '사용시간'); //엑셀 타이틀

		$data =  $this->table->generate($query);//테이블 만듬
		$cell = array('data' => "총 : ".$total."개 중".$use." 사용", 'class' => 'highlight', 'colspan' => 3); 
		$this->table->add_row($cell); //총합 더한거 추가함
		$data .= $this->table->generate(); //데이터 더합

		//echo $data;
		force_download($name,  "\xEF\xBB\xBF" .$data); //파일 다운로드
		//echo $this->db->last_query();
		



	 }

	 

	 

 	
}

	
