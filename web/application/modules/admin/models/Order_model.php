<?php
class Order_model extends MY_Model {
	function __construct(){
		parent::__construct();
		$this->load->database(); //데이터베이스 호출
    }
	

	function orderitems($order_id){
		$this->db->from('tb_order_item');
		$this -> db -> where('orderId', $order_id);
		$result = $this -> db -> get() -> row_array();
		return $result;
	}

		
	function order_list($input)
	{
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;
		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		
		$this->db->select('SQL_CALC_FOUND_ROWS T1.id, I.productName, M.email  ',false);
		
		$this->db->from($input['table']." as T1");
		$this->db->join("tb_order_item as I","T1.id = I.orderId","inner");
		$this->db->join("tb_member as M","T1.memberId = M.id","left");

		//$this->db->where("T1.status >=","01");
		//$this->db->join("tb_member as M","T1.memberId = M.id","left");
		//$this->db->join("tb_product as P","T1.productId = P.id","left");
		


		
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			if($input["sfl"] == "productName") $this->db->like("I.productName", $input["stx"]);
			if($input["sfl"] == "orderId") $this->db->like("T1.id", $input["stx"]);
			if($input["sfl"] == "memberEmail") $this->db->like("T1.memberEmail", $input["stx"]);
		}
		
		if(isset($input["guest"])) $this->db->where("T1.memberId IS NULL");
		//if(isset($input["open_market"])) $this->db->where("T1.open_market IS NOT NULL");

		if(isset($input["sdate"]) && $input["sdate"]) $this->db->where("T1.createDatetime >=", $input["sdate"]);
		if(isset($input["edate"]) && $input["edate"]) $this->db->where("T1.createDatetime <=", date('Y-m-d', strtotime($input["edate"].'+1 day')));
		
		//if(!isset($input["groupby"])) $this->db->group_by("cdate");
		//if(!isset($input["groupby"])) $this->db->group_by("T1.memberId");
		$this->db->group_by("T1.id");
		$this->db->group_by("I.productName");
		$this->db->group_by("M.email");
		$this->db->order_by("T1.createDatetime","desc");
		
		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		// echo $this->db->last_query();exit;
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;
	}

	function order_detail($input)
	{
		$this->db->select("T1.*, M.first_name, M.last_name, M.yomi_first_name, M.yomi_last_name, M.email, M.mobile ",false);
		$this->db->from("tb_order as T1");
		$this->db->join("tb_member as M","T1.memberId = M.id","left");
		$this->db->where("T1.id", $input["id"]);
		$sql = $this->db->get();
		
		$result = array();
		if($sql->num_rows() > 0 ){
			$result["order"] = $sql->row_array();			
			$result['status'] = true;
		}else{
			$result['status'] = false;
		}
		return $result;
	}

	function movie_list($input)
	{
		$this->db->select("T1.*, P.imagePath, P.imageSFile, P.imageLFile, P.name as productName ",false);
		$this->db->from("tb_movie_maker as T1");
		$this->db->join("tb_order_item as I","T1.orderItemId = I.id","inner");
		$this->db->join("tb_product as P","P.id = I.productId","left");
		$this->db->where("T1.orderId", $input["id"]);
		$this->db->order_by("I.id", "ASC");
		$sql = $this->db->get();
		$result = array();
		if($sql->num_rows() > 0 ){
			$result['movie'] = $sql->result_array();			
			$result['status'] = true;
		}else{
			$result['status'] = false;
		}
		return $result;
	}

	function orderDetailList($input)
	{
		$this->db->select("I.*, C.coupon_group_code, (select coupon_name from tb_coupon_group where  tb_coupon_group.id = C.coupon_group_code) as couponName, M.id as makeId ",false);
		$this->db->from("tb_order as T1");
		$this->db->join("tb_order_item as I","I.orderId = T1.id","inner");
		$this->db->join("tb_movie_maker as M","I.id = M.orderItemId","inner");
		$this->db->join("tb_coupon as C","C.id = I.couponId","left");
		$this->db->where("T1.id", $input["id"]);
		$this->db->order_by("I.id", "ASC");
		$sql = $this->db->get();
		//echo $this->db->last_query();
		$result = array();
		if($sql->num_rows() > 0 ){
			$result['orderDetailList'] = $sql->result_array();			
			$result['status'] = true;
		}else{
			$result['status'] = false;
		}
		return $result;
		
	}
	/*
	환불 아이템 리스트를 가져올것...
	환불은 동일한 페이지에서 환불 처리할것
	
	*/
	function refund_list($input)
	{
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;
		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		
		$this->db->select('SQL_CALC_FOUND_ROWS T1.*
		
		, (SELECT productName FROM tb_order_item AS I WHERE I.orderId = T1.id  LIMIT 1) AS productName
		
		',false);
		$this->db->from($input['table']." as T1");
		//$this->db->join("tb_order_payment as PT","T1.id = PT.orderId","inner");
		//$this->db->join("tb_order_refund as R","T1.id = R.orderId","inner");

		
		//40 환불요청 42 환불대기 44 환불 완료
		if(isset($input["refund"]) && $input["refund"]){
			$this->db->where("T1.status =", $input["refund"]); //값이 있으면 해당 값만 나옴
		}else{
			$this->db->where("T1.status >=", "40");
			$this->db->where("T1.status <=", "49");
		}
		
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			//if($input["sfl"] == "productName") $this->db->like("P.productName", $input["stx"]);
			if($input["sfl"] == "memberName") $this->db->like("T1.memberName", $input["stx"]);
			if($input["sfl"] == "memberEamil") $this->db->like("T1.memberEamil", $input["stx"]);
		}
		
		if(isset($input["sdate"]) && $input["sdate"]) $this->db->where("T1.createDatetime >=", $input["sdate"]);
		if(isset($input["edate"]) && $input["edate"]) $this->db->where("T1.createDatetime <=", date('Y-m-d', strtotime($input["edate"].'+1 day')));
		
		//if(!isset($input["groupby"])) $this->db->group_by("cdate");
		//if(!isset($input["groupby"])) $this->db->group_by("T1.memberId");
		$this->db->order_by("T1.createDatetime","desc");
		
		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		//echo $this->db->last_query();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;
	}

}
