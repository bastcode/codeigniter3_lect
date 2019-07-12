<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Order extends MY_Controller {
	function __construct() {
		parent::__construct();
		//$this->load->model('order_model');
		$this->load-> library('pagination_custom_v3');
		$this->load-> library('admin_util');
		$this->load-> library('user_agent');
		
	}

	public function _remap($method) {			
		$this->segs($method); //core 에서 로드 세그먼트 관련 유틸
		$this->admin_util->auth_check(); //권한 관련
		

		//echo ($this->agent->is_mobile() ?"m":"p");


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
	
	//주문리스트
	function order_list()
	{		
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 10;
		$input["table"] = "tb_order";
		$data = $this->_temp_pagen("order_model","order_list", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/order/order_list_v",$data);
	}

	function order_detail()
	{
		$input = array();
		$data = array();
		
		$input["id"] = $this->segs[4]; //ID
		
		$data = $this->_temp_get("order_model","order_detail", $input); //core 에 있음
		$movie = $this->_temp_get("order_model","movie_list", $input); //core 에 있음
		$orderDetailList = $this->_temp_get("order_model","orderDetailList", $input); //core 에 있음
		$data['movie'] = $movie['movie'];
		$data['orderDetailList'] = $orderDetailList['orderDetailList'];
		
		//print_r($data["movie"]);
		//print_r($data);
		$this->load->view("/order/order_detail_v",$data);
	}

	
	
	//환불 신청 리스트
	function refund_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$input["table"] = "tb_order";
		$data = $this->_temp_pagen("order_model","refund_list", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/order/refund_list_v",$data);
	}

	//환불 완료 리스트
	function refund_appy_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$input["table"] = "tb_order";
		$data = $this->_temp_pagen("order_model","refund_appy_list", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/order/refund_list_v",$data);
	}
	
	//충전 [결제] 리스트
	function charge_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$input["table"] = "tb_point_log";
		$data = $this->_temp_pagen("order_model","charge_list", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/order/charge_list_v",$data);
	}
	
	function movie_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$data['input'] = $input;
		$input["table"] = "tb_order";
		
		$data = $this->_temp_pagen("order_model","order_list", $input, $linkCnt=3);
		$this->load->view("/order/order_list_v",$data);
	}
	
	

	function email_send_list(){
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 10;
		$data['input'] = $input;

		$db_data = $this->common_model->email_send_list($input);

		$link_url = "/".$this->segs[1]."/".$this->segs[2]."/".$this->segs[3]."/";
		$total_count = $db_data['total_cnt'];
		$data['total_count'] = $total_count;

		$config = $this->pagination_custom2->pagenation_b($input["page"], $total_count, $input["pagelist"], $link_url, $segment=4, $num_link=3);
		$config['base_url'] = BASE_URL.$link_url;
		$config['page_query_string'] = true; //쿼리 스트링
		$config['query_string_segment'] = 'page';
		$config['display_always'] = TRUE;
		$config['use_fixed_page'] = TRUE;
		$config['fixed_page_num'] = 10;
		$this->pagination_custom2->initialize($config);

		$data['page_nation'] = $this->pagination_custom2->create_links();
		$data['lists'] = $db_data['page_list_m'];
		$this->load->view("/admin/email/list_v",$data);
	}

	function xls_coupon(){
		$input = array();
		foreach($this->input->get (NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		foreach($this->input->post(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$data['input'] = $input;

		$db_data = $this->common_model->xls_coupon($input);
		$data['xls'] = $db_data['xls'];
		$data['total_count'] = $db_data['total_cnt'];
		$this->load->view("/admin/coupon/xls_list_v",$data);
	}

	function fake_order()
	{

		//트랜잭션 시작
		$this->db->trans_start();
		
		/** 주문정보서 */
		$order = array();
		$order["price"] = "10000"; //결정된 주문 가격 
		$order["couponPrice"] = ""; //쿠폰의 가격 % 단위도 포함
		$order["device"] = ($this->agent->is_mobile() ?"M":"PC"); 
		$order["memberId"] = "1";
		$order["memberUserId"] = ""; //특별히 안쓰지만 일단 남겨둠 비회원 구매 필드
		$order["memberPassword"] = "";  //특별히 안쓰지만 일단 남겨둠 비회원 구매 필드
		$order["memberName"] = "관리자"; //회원정보
		$order["memberMobile"] = ""; //연락처
		$order["memberEmail"] = "cs@momentto.jp";	 //이메일	
		$order["ip"] = $this->input->ip_address();
		//$order["modifyDatetime"] = ""; // 수정된 시간
		$order["p_oid"] = "";    //인보이스 아이디
		$order["status"] = "20"; //결제 스테이터스
		$order["payment"] = "paypal"; //결제종류
		
		$this->db->set("createDatetime","NOW()",false);
		$this->db->set("modifyDatetime","NOW()",false);
		$this->db->set("paymentDatetime","NOW()",false);
		$this->db->insert("tb_order",$order);
		$order_id = $this->db->insert_id();
		/** 주문 정보서 종료 */


		for($i=1; 1>=$i; $i++)
		{
			/** 주문 상세  */
			$order_item = array();
			$order_item["orderId"] = $order_id;
			$order_item["productName"] = "LOVE Story"; //상품이름
			$order_item["productId"] = "201"; //상품번호
			$order_item["memberId"] = "1"; //회원번호
			$order_item["couponId"] = null; //쿠폰 아이디 . 사용안하면 없음
			$order_item["discount"] = "0"; //쿠폰 할인가격
			$order_item["itemPrice"] = 10000; //상세가격
			$order_item["itemStatus"] = 20; //상세 스테이터스

			$this->db->insert("tb_order_item",$order_item);
			$order_item_id = $this->db->insert_id();
			/** 주문 상세 종료 */

			//date('Y-m-d', strtotime($input["edate"].'+1 day'))
			$edate = date('Y-m-d 23:59:59');
			/** 무비메이크 생성 */
			$movie = array();
			$movie["orderId"] = $order_id;			//주문서 번호
			$movie["orderItemId"] = $order_item_id;		//주문 상세 번호
			$movie["memberId"] = null;		//회원번호
			$movie["saveData"] = null;		//업로드한 파일 이름
			//$movie["modifyDatetime"] = "";   //수정된 시간
			//$movie["storeDatetime"] = "";    //스토어에 저장된 시간
			$movie["completeDatetime"] = null; //랜더 완료시간		
			$movie["isBgmChange"] = 0;     	//음악변경 여부
			$movie["startDatetime"] = null;    //무비메이커 시작시간
			$movie["endDatetime"] = date('Y-m-d 23:59:59', strtotime($edate.'+180 day'));    //무비메이커 시작시간
			$movie["renderServerName"] = null; //무비메이커 랜더 랜더서버 이름
			$movie["renderStartDate"] = null;  //무비메이커 랜더 시작일
			$movie["status"] = "10";
			$this->db->set("createDatetime","NOW()",false);
			$this->db->insert("tb_movie_maker",$movie);
			/** 무비메이크 종료 */
		}
		

		//트랜잭션 종료
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			//트랜잭션 에러 
		}else{
			//성공
			echo "성공!";
		}

		


	}

}
