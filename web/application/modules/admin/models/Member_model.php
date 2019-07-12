<?php
class Member_model extends MY_Model {
	function __construct(){
			parent::__construct();
			$this->load->database(); //데이터베이스 호출
	}

	public function member_list($input)
	{
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		
		$this->db->select('SQL_CALC_FOUND_ROWS T1.* ',false);
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

		$result['page_list_m']= $this->db->get()->result_array();
		//echo $this->db->last_query(); //마지막에 실행된 쿼리 출력
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;
	}

	public function mycoupon($input)
	{
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		
		$this->db->select('SQL_CALC_FOUND_ROWS T1.*, G.coupon_name ',false);
		$this->db->from($input['table']." as T1");
		$this->db->join("tb_coupon as C","T1.couponId = C.id","inner");
		$this->db->join("tb_coupon_group as G ", "G.id = C.coupon_group_code", "inner");
		$this->db->where('memberId',$input['memberId']);
		$this->db->limit($input["pagelist"],$limit_ofset);
		

		$result['page_list_m']= $this->db->get()->result_array();
		//echo $this->db->last_query(); //마지막에 실행된 쿼리 출력
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;
	}


		
}

