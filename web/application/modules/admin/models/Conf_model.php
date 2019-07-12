<?php
class Conf_model extends MY_Model {
	function __construct(){
        parent::__construct();
    }
	
	function one_one_list($input)
	{
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;
		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		
		$this->db->select('SQL_CALC_FOUND_ROWS T1.*, P.name as productName, R.id as R_id',false);
		$this->db->from($input['table']." as T1");
		$this->db->join('tb_inquiry_reply as R','R.inquiryId = T1.id','left');
		$this->db->join('tb_product as P','P.id = T1.productId','left');
		
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			if($input["sfl"] == "productName") $this->db->like("T1.productName", $input["stx"]);
		}
		$this->db->order_by("T1.id","desc");
		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;

		return $result;
	}

	function one_one_detail($input)
	{
		$this->db->select(' T1.*, P.name as productName, R.id as R_id, R.content as RContent, ',false);
		$this->db->from("tb_inquiry as T1");
		$this->db->join('tb_inquiry_reply as R','R.inquiryId = T1.id','left');
		$this->db->join('tb_product as P','P.id = T1.productId','left');
		$this->db->where("T1.id",$input["id"]);

		$sql = $this->db->get();
		if($sql->num_rows() > 0){
			$result["one"] = $sql->row_array();
		}else{
			$result["one"] = array();
		}
		return $result;
	}


	function partner_offer_list($input)
	{
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;
		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		
		//$this->db->select('SQL_CALC_FOUND_ROWS T1.*, C.name as cate_name',false);
		$this->db->from($input['table']." as T1");
		//$this->db->join('tb_category as C','T1.categoryid = C.id','inner');
		//$this->db->where("T1.isDisplay ", true);
		
		
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			if($input["sfl"] == "productName") $this->db->like("T1.productName", $input["stx"]);
		}
		$this->db->order_by("T1.id","ASC");
		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;

		return $result;
	}

	function review_list($input)
	{
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;
		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		
		$this->db->select('SQL_CALC_FOUND_ROWS T1.*, P.name as productName',false);
		$this->db->from($input['table']." as T1");
		$this->db->join('tb_product as P','T1.productId = P.id','inner');
		
		
		
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			if($input["sfl"] == "productName") $this->db->like("T1.productName", $input["stx"]);
			if($input["sfl"] == "content") $this->db->like("T1.content", $input["stx"]);
			if($input["sfl"] == "memberEmail") $this->db->like("T1.memberEmail", $input["stx"]);

			
		}
		$this->db->order_by("T1.id","DESC");
		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;

		return $result;
	}

	function review_detail($input)
	{
		$this->db->select(' T1.*, P.name as productName',false);
		$this->db->from("tb_review as T1");
		$this->db->join('tb_product as P','T1.productId = P.id','inner');
		$this->db->where("T1.id",$input["id"]);
		$sql = $this->db->get();
		if($sql->num_rows() > 0){
			$result["review"] = $sql->row_array();
		}else{
			$result["review"] = array();
		}
		return $result;
	}
	
	

	function now_day_member()
	{
		$this->db->select('id');
		$this->db->from("tb_member");
		$this->db->where('DATE_FORMAT(createDatetime, "%Y-%m-%d") = ',' DATE_FORMAT(NOW(), "%Y-%m-%d")',false,false);
		$sql = $this->db->get();

		
		$result = array();
		$result['total_cnt'] =$this->db->count_all('tb_member');
		if($sql->num_rows() > 0){
			//echo $sql->num_rows();
			$result["status"] = true;
			$result["now_day_member"] = $sql->result_array();
			$result["now_day_member_cnt"] = $sql->num_rows();
			
			return $result;
		}else{
			$result["status"] = false;
			$result["now_day_member_cnt"] = 0;
			return $result;
		}
	}


	function now_day_order()
	{
		$this->db->select('id');
		$this->db->from("tb_order");
		$this->db->where('DATE_FORMAT(paymentDatetime, "%Y-%m-%d") = ',' DATE_FORMAT(NOW(), "%Y-%m-%d")',false,false);
		$sql = $this->db->get();

		
		$result = array();
		$result['total_cnt'] =$this->db->count_all('tb_order');

		//echo $this->db->last_query();
		if($sql->num_rows() > 0){
			//echo $sql->num_rows();
			$result["status"] = true;
			$result["now_day_order"] = $sql->result_array();
			$result["now_day_order_cnt"] = $sql->num_rows();
			
			return $result;
		}else{
			$result["status"] = false;
			$result["now_day_order_cnt"] = 0;
			return $result;
		}
	}

	//관리자 메인 질답 리스트
	function qna_list($input)
	{
		$this->db->select('SQL_CALC_FOUND_ROWS T1.*, P.name as productName, R.id as R_id',false);
		$this->db->from("tb_inquiry as T1");
		$this->db->join('tb_inquiry_reply as R','R.inquiryId = T1.id','left');
		$this->db->join('tb_product as P','P.id = T1.productId','left');
		
		$this->db->order_by("T1.id","DESC");
		$this->db->limit(10);
		$sql = $this->db->get();
		$result["qna_list"] = $sql->result_array();
		return $result;
	}

	//관리자 메인 협력업체 리스트
	function partner_in_list($input)
	{
		$this->db->from("tb_partner_offer");
		$this->db->order_by("id","DESC");
		$this->db->limit(10);
		$sql = $this->db->get();
		$result["partner_in_list"] = $sql->result_array();
		return $result;
	}

	//관리자 메인 리뷰 리스트
	function admin_review_list()
	{
		$this->db->select("R.*, P.name, P.imageLFile as img",false);
		$this->db->from("tb_review as R");
		$this->db->join("tb_product as P","R.productId = P.id","left");
		$this->db->order_by("R.id","DESC");
		$this->db->limit(10);
		$sql = $this->db->get();
		$result["review_list"] = $sql->result_array();
		return $result;
	}

	function partner_offer_detail($input)
	{

		$this->db->select(' T1.*',false);
		$this->db->from("tb_partner_offer as T1");
		
		$this->db->where("T1.id",$input["id"]);
		$sql = $this->db->get();
		if($sql->num_rows() > 0){
			$result["info"] = $sql->row_array();
		}else{
			$result["info"] = array();
		}
		return $result;

	}


	function making_detail($input)
	{
		$result = array();
        $this->db->from("tb_making");
		$this->db->where("id",$input["id"]);
        $sql = $this->db->get();
        if($sql->num_rows() >0){
			$result["info"] = $sql->row_array();
            $result["result"] = true;
            $result["message"] = "ok";
        }else{
			$result["info"] = array();
            $result["result"] = false;
            $result["message"] = "해당하는 id가 없습니다.";
		}
		
		return $result;
	}
	

	function analytics()
	{
		//오늘 가입자수
		
		//전체 주문수

		//오늘 주문수

		//전체주문수

	}

	
	function mobile_keyword($input)
	{
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;
		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		
		//$this->db->select('SQL_CALC_FOUND_ROWS T1.*, C.name as cate_name',false);
		$this->db->from($input['table']." as T1");
		//$this->db->join('tb_category as C','T1.categoryid = C.id','inner');
		//$this->db->where("T1.isDisplay ", true);
		
		
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			if($input["sfl"] == "productName") $this->db->like("T1.productName", $input["stx"]);
		}
		$this->db->order_by("T1.seq","ASC");
		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;

		return $result;
	}
	
	function faq_conf_list($input)
	{
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;

		$limit_ofset = ($input["page"]-1) * $input["pagelist"];

		//$this->db->select('SQL_CALC_FOUND_ROWS T1.*, C.name as cate_name',false);
		$this->db->from($input['table']." as T1");
		//$this->db->join('tb_category as C','T1.categoryid = C.id','inner');
		//$this->db->where("T1.isDisplay ", true);


		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){
			if($input["sfl"] == "productName") $this->db->like("T1.productName", $input["stx"]);
		}
		$this->db->order_by("T1.seq","ASC");
		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;

		return $result;
	}


	function meta_list($input)
	{
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;
		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		
		$this->db->select('SQL_CALC_FOUND_ROWS T1.*',false);
		$this->db->from($input['table']." as T1");
		
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			if($input["sfl"] == "value") $this->db->like("T1.value", $input["stx"]);
			if($input["sfl"] == "type") $this->db->like("T1.type", $input["type"]);
			if($input["sfl"] == "meta") $this->db->like("T1.meta", $input["stx"]);
			
		}
		$this->db->order_by("T1.idx","ASC");
	
		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;

		return $result;
	}

	function meta_file_list($input)
	{
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;
		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		
		$this->db->select('SQL_CALC_FOUND_ROWS T1.*',false);
		$this->db->from($input['table']." as T1");
		
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			if($input["sfl"] == "value") $this->db->like("T1.value", $input["stx"]);
			if($input["sfl"] == "type") $this->db->like("T1.type", $input["stx"]);
			if($input["sfl"] == "discript") $this->db->like("T1.discript", $input["stx"]);
			
		}
		$this->db->order_by("T1.idx","ASC");
	
		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		//echo $this->db->last_query();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;

		return $result;
	}

	function event_win_update($input)
	{

		$this->db->from("tb_event_winner");		
		$this->db->where("is_win", false);
		$this->db->where("id", $input["id"]);
		$this->db->where("memberId", $input["memberId"]);
		$sql = $this->db->get();

		//echo $this->db->last_query();

		//당첨 사실이 없다면
		if($sql->num_rows() > 0 ){
			
			$eventId = $sql->row()->eventId;

			$this->db->set("is_win",true);
			$this->db->where("id", $input["id"]);
			$this->db->where("memberId", $input["memberId"]);
			$this->db->update("tb_event_winner");
			//자동 발급.... 쿠폰
			$this->db->select("G.*");
			$this->db->from("tb_event as E");
			$this->db->join("tb_coupon_group as G", "G.id = E.coupon_group_code" ,"inner");
			$this->db->where("E.id",$eventId);
			$sql = $this->db->get();
			$company_coupon_code = $sql->row()->company_coupon_code; //4자리 고유코드
			$company_coupon_index = $sql->row()->id; //쿠폰 그룹 아이디
			
			$gen_num =  $this->secretlib->gen_coupon();
			$coupon_num= $company_coupon_code.$gen_num;  // MMIT + 생성된쿠폰 9자리
			
			$this->db->set("coupon_group_code",$company_coupon_index);
			$this->db->set("coupon_number",$coupon_num);

			$this->db->set("use_memberId", $input["memberId"]);
			$this->db->set("use_memberEmail", $input["memberEmail"]);

			$this->db->set("is_use", false);			
			$this->db->set("use_dateTime", "NOW()",false);
			$this->db->insert("tb_coupon");
			return true;			
		}else{
			return false;
		}

	}



}
