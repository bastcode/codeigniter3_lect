<?php
class Product_model extends MY_Model {
	function __construct(){
		parent::__construct();
		$this->load->database(); //데이터베이스 호출
    }
	
	function product_list($input)
	{
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;
		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		
		$this->db->select('SQL_CALC_FOUND_ROWS T1.*, C.title as cate_name',false);
		$this->db->from($input['table']." as T1");
		$this->db->join('tb_category as C','T1.categoryid = C.id','inner');
		$this->db->where("T1.isDisplay ", true);
		if(isset($input["categoryId"]) && $input["categoryId"] >=1 ) $this->db->where("T1.categoryId =", $input["categoryId"]);
		
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			if($input["sfl"] == "productName") $this->db->like("T1.name", $input["stx"]);
			if($input["sfl"] == "price") $this->db->where("T1.price >=", $input["stx"]);
		}
		
		if(isset($input["sdate"]) && $input["sdate"]) $this->db->where("T1.createDatetime >=", $input["sdate"]);
		if(isset($input["edate"]) && $input["edate"]) $this->db->where("T1.createDatetime <=", date('Y-m-d', strtotime($input["edate"].'+1 day')));
		
		//셋트 카테고리 상품 제외
		if(isset($input["notset"]) && $input["notset"]){
			$this->db->where("T1.setsType ", false);
		}
		//if(!isset($input["groupby"])) $this->db->group_by("cdate");
		//if(!isset($input["groupby"])) $this->db->group_by("T1.memberId");
		
		if(isset($input['cateOrder'] ) ) {
			$this->db->order_by("categoryId","asc");
		}else{
			$this->db->order_by("T1.createDatetime","desc");
		}

		
		
		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		//echo $this->db->last_query();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;

		

		return $result;
	}
	


	function product_hidden_list($input)
	{
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;
		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		
		$this->db->select('SQL_CALC_FOUND_ROWS T1.*, C.title as cate_name',false);
		$this->db->from($input['table']." as T1");
		$this->db->join('tb_category as C','T1.categoryid = C.id','inner');
		$this->db->where("T1.isDisplay ", false);
		if(isset($input["categoryId"]) && $input["categoryId"] >=1 ) $this->db->where("T1.categoryId =", $input["categoryId"]);
		
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			if($input["sfl"] == "productName") $this->db->like("T1.name", $input["stx"]);
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

	/** 카테고리 추가 */
	function categody_add($input)
	{
		$insert = array();
		
		$insert["title"] = $input["title"];
		$this->db->set("createDatetime","NOW()",false);
		$this->db->insert("tb_category",$insert);
	}

	function category_list($input)
	{
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];

		$this->db->select('SQL_CALC_FOUND_ROWS T1.*',false);
		$this->db->from("tb_category as T1");
		//$this->db->where("id != ","6"); // 셋트제외
		$this->db->order_by("T1.createDatetime","ASC");
		$result['page_list_m']= $this->db->get()->result_array();
		//echo $this->db->last_query();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;

	}

	function product_mete($input)
	{
		$this->db->from("tb_product_meta");
		$this->db->where("meta", $input["no"]); //productId
		if($input["key"]){
			$this->db->where("key", $input["key"]);
		}
		if($input["sec"]){
			$this->db->where("sec", $input["sec"]);
		}

		$this->db->order_by("sec", "ASC");

		return $this->db->get()->result_array();
		


	}
	

}
