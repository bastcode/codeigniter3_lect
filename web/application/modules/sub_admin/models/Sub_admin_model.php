<?php
class Sub_admin_model extends CI_Model {
	function __construct(){
        parent::__construct();
    }

	function page_list_m($page=1,$pagelist = 20){
		if(is_numeric($page) == false) $page = 1;
		if($page < 0) $page = 1;
		$limit_ofset = ($page-1) * $pagelist;

		$this->db->select('SQL_CALC_FOUND_ROWS *',false);
		$this->db->from('test');
		$this->db->limit($pagelist,$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;

	}

	//어드민 메인 페이지 용도
	function analytics(){
		$query ="
		SELECT
			(SELECT SUM(price) FROM tb_order WHERE DATE_FORMAT(createDatetime, '%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d' )) AS todayPrice
			,(SELECT COUNT(*) FROM tb_product WHERE isDisplay=TRUE LIMIT 1) AS todayCnt
			,(SELECT COUNT(*) FROM tb_member WHERE DATE_FORMAT(createDatetime, '%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d' )) AS todayNewMember
			,(SELECT COUNT(*) FROM tb_member WHERE isExit is false ) AS allMember
			,(SELECT SUM(money) FROM tb_member_saved_money WHERE money > 0 LIMIT 1 ) AS allPoint
			,(SELECT SUM(price) FROM tb_order where status ='02' or status ='03' or status ='10' or status ='11'  ) AS allPrice
			,(SELECT COUNT(*) FROM tb_member_coupon WHERE DATE_FORMAT(useDatetime, '%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d' )  ) AS todayCoupon
		";
		return $this->db->query($query)->row_array();
	}

	function analytics_list($input){

		//if(!isset($input["page"])) $input["page"] = 1;
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;
		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];


		if(!isset($input["type"]) || !$input["type"]) 
			$table = "bms_product_hit"; //상품 히트 수 검색
		else
			$table = "bms_movie_maker"; //샘플 히트 수 검색
		
		$this->db->select('SQL_CALC_FOUND_ROWS BP.*, M.name, P.name AS pname, DATE_FORMAT(BP.createDatetime, "%Y-%m-%d") AS cdate,  COUNT(*) AS cnt ',false);
		$this->db->from($table." as BP");
		$this->db->join("tb_member as M","BP.memberId = M.id","left");
		$this->db->join("tb_product as P","BP.productId = P.id","left");
		
		
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			if($input["sfl"] == "pname") $this->db->like("P.name", $input["stx"]);
			if($input["sfl"] == "mname") $this->db->like("M.name", $input["stx"]);			
		}
		
		if(isset($input["sdate"]) && $input["sdate"]) $this->db->where("BP.createDatetime >=", $input["sdate"]);
		if(isset($input["edate"]) && $input["edate"]) $this->db->where("BP.createDatetime <=", date('Y-m-d', strtotime($input["edate"].'+1 day')));
		
		if(!isset($input["groupby"])) $this->db->group_by("cdate");
		if(!isset($input["groupby"])) $this->db->group_by("BP.memberId");
		
		
		
		$this->db->order_by("BP.idx","desc");
		$this->db->order_by("BP.createDatetime","desc");
		
		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;

	}
	function analytics_detail($input){

		//if(!isset($input["page"])) $input["page"] = 1;
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;
		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];


		if(!isset($input["type"]) || !$input["type"]) 
			$table = "bms_product_hit"; //상품 히트 수 검색
		else
			$table = "bms_movie_maker"; //샘플 히트 수 검색


		$this->db->select('SQL_CALC_FOUND_ROWS BP.*, M.name, P.name AS pname, DATE_FORMAT(BP.createDatetime, "%Y-%m-%d") AS cdate',false);
		$this->db->from($table." as BP");
		$this->db->join("tb_member as M","BP.memberId = M.id","left");
		$this->db->join("tb_product as P","BP.productId = P.id","left");
		
		$this->db->where("BP.memberId =", $input["memberId"]);
		
		if(isset($input["sdate"]) && $input["sdate"]) $this->db->where("BP.createDatetime >=", $input["sdate"]);
		if(isset($input["edate"]) && $input["edate"]) $this->db->where("BP.createDatetime <=", date('Y-m-d', strtotime($input["edate"].'+1 day')));
		
		$this->db->order_by("BP.idx","desc");
		$this->db->order_by("BP.createDatetime","desc");
		
		
		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;

	}
	
	function analytics_product_sum($input){
			
		if(!isset($input["type"]) || !$input["type"]) 
			$table = "bms_product_hit"; //상품 히트 수 검색
		else
			$table = "bms_movie_maker"; //샘플 히트 수 검색
		
		
	
		$this->db->select('COUNT(*) AS cnt, P.name ',false);
		$this->db->from($table." as BP");
		$this->db->join("tb_product as P","BP.productId = P.id","left");
		
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			if($input["sfl"] == "pname") $this->db->like("P.name", $input["stx"]);
			if($input["sfl"] == "mname") $this->db->like("M.name", $input["stx"]);			
		}
		
		if(isset($input["sdate"]) && $input["sdate"]) $this->db->where("BP.createDatetime >=", $input["sdate"]);
		if(isset($input["edate"]) && $input["edate"]) $this->db->where("BP.createDatetime <=", date('Y-m-d', strtotime($input["edate"].'+1 day')));
		
		
		$this->db->order_by("cnt","desc");
		$this->db->group_by("BP.productId");
		$this->db->limit(10);		
		$result['data']= $this->db->get()->result_array();
		
		
		
		$this->db->select('COUNT(*) AS cnt',false);
		$this->db->from($table." as BP");
		$this->db->join("tb_product as P","BP.productId = P.id","left");
		
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			if($input["sfl"] == "pname") $this->db->like("P.name", $input["stx"]);
			if($input["sfl"] == "mname") $this->db->like("M.name", $input["stx"]);			
		}
		
		if(isset($input["sdate"]) && $input["sdate"]) $this->db->where("BP.createDatetime >=", $input["sdate"]);
		if(isset($input["edate"]) && $input["edate"]) $this->db->where("BP.createDatetime <=", date('Y-m-d', strtotime($input["edate"].'+1 day')));
		//$this->db->group_by("BP.productId");		
		$result['total_cnt'] = $this->db->get()->row()->cnt;
		
		return $result;
	}

	function banner_list($input){

		//if(!isset($input["page"])) $input["page"] = 1;
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;

		$limit_ofset = ($input["page"]-1) * $input["pagelist"];

		$table = "bms_banner_hit";

		$this->db->select('SQL_CALC_FOUND_ROWS BP.*, M.name, P.name AS pname, DATE_FORMAT(BP.createDatetime, "%Y-%m-%d") AS cdate, BB.id as Bid, BC.company_name,BC.company_tel,BC.company_admin, BB.alt' ,false);
		$this->db->from($table." as BP");
		$this->db->join("tb_member as M","BP.memberId = M.id","left");
		$this->db->join("tb_product as P","BP.productId = P.id","left");
		$this->db->join("bms_banner as BB","BP.bannerId = BB.id","left");
		$this->db->join("bms_company as BC","BB.cp_code = BC.id","left");

		//$this->db->join("bms_company as BC","BB.cp_code = BB.id","left");


		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){
			if($input["sfl"] == "pname") $this->db->like("P.name", $input["stx"]);
			if($input["sfl"] == "mname") $this->db->like("M.name", $input["stx"]);
		}

		if(isset($input["sdate"]) && $input["sdate"]) $this->db->where("BP.createDatetime >=", $input["sdate"]);
		if(isset($input["edate"]) && $input["edate"]) $this->db->where("BP.createDatetime <=", date('Y-m-d', strtotime($input["edate"].'+1 day')));

		$this->db->where("BB.alt IS NOT NULL",false,false);

		if(!isset($input["groupby"])) $this->db->group_by("cdate");
		if(!isset($input["groupby"])) $this->db->group_by("BP.bannerId");
		if(!isset($input["groupby"])) $this->db->group_by("BP.memberId");



		$this->db->order_by("BP.id","desc");
		$this->db->order_by("BP.createDatetime","desc");

		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;

	}

	function banner_company_list($input){

		//if(!isset($input["page"])) $input["page"] = 1;
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;

		$limit_ofset = ($input["page"]-1) * $input["pagelist"];

		$table = "bms_banner_hit";
		
		$this->db->select('SQL_CALC_FOUND_ROWS BP.*,  P.name AS pname, DATE_FORMAT(BP.createDatetime, "%Y-%m-%d") AS cdate, BB.id as Bid, BC.company_name,BC.company_tel,BC.company_admin, BB.alt' ,false);
		$this->db->from($table." as BP");
		$this->db->join("tb_product as P","BP.productId = P.id","left");
		$this->db->join("bms_banner as BB","BP.bannerId = BB.id","left");
		$this->db->join("bms_company as BC","BB.cp_code = BC.id","left");

		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){
			if($input["sfl"] == "pname") $this->db->like("P.name", $input["stx"]);
			if($input["sfl"] == "mname") $this->db->like("M.name", $input["stx"]);
		}

		if(isset($input["sdate"]) && $input["sdate"]) $this->db->where("BP.createDatetime >=", $input["sdate"]);
		if(isset($input["edate"]) && $input["edate"]) $this->db->where("BP.createDatetime <=", date('Y-m-d', strtotime($input["edate"].'+1 day')));

		$this->db->where("BB.alt IS NOT NULL",false,false);
		if(isset($input["cid"]) && $input["cid"]) $this->db->where("BC.id", $input['cid']);
		

		//if(!isset($input["groupby"])) $this->db->group_by("cdate");
		//if(!isset($input["groupby"])) $this->db->group_by("BP.bannerId");
		//if(!isset($input["groupby"])) $this->db->group_by("BP.memberId");

		$this->db->order_by("BP.id","desc");
		$this->db->order_by("BP.createDatetime","desc");

		
		if (isset($this->segs[4]) && $this->segs[4]  == "excel") {
			$result['page_list_m']= $this->db->get()->result_array();		
			$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
			return $result;
		}
	
		$this->db->limit($input["pagelist"],$limit_ofset);
		$result['page_list_m']= $this->db->get()->result_array();		
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;
	}

	function banner_detail($input){

		//if(!isset($input["page"])) $input["page"] = 1;
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;

		$limit_ofset = ($input["page"]-1) * $input["pagelist"];

		$table = "bms_banner_hit";

		$this->db->select('SQL_CALC_FOUND_ROWS BP.*, M.name, P.name AS pname, DATE_FORMAT(BP.createDatetime, "%Y-%m-%d") AS cdate, BB.id as Bid, BC.company_name,BC.company_tel,BC.company_admin' ,false);
		$this->db->from($table." as BP");
		$this->db->join("tb_member as M","BP.memberId = M.id","left");
		$this->db->join("tb_product as P","BP.productId = P.id","left");
		$this->db->join("bms_banner as BB","BP.bannerId = BB.id","left");
		$this->db->join("bms_company as BC","BB.cp_code = BC.id","left");

		$this->db->where("BP.bannerId =", $input["bannerId"]);
		$this->db->where("BP.memberId =", $input["memberId"]);


		if(isset($input["sdate"]) && $input["sdate"]) $this->db->where("BP.createDatetime >=", $input["sdate"]);
		if(isset($input["edate"]) && $input["edate"]) $this->db->where("BP.createDatetime <=", $input["edate"]);

		$this->db->order_by("BP.id","desc");
		$this->db->order_by("BP.createDatetime","desc");


		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;

	}

	function banner_list_sum($input){


		$table = "bms_banner_hit";
		$this->db->select('COUNT(*) AS cnt, BC.company_name as name , BC.id as cid',false);
		$this->db->from($table." as BP");				
		$this->db->join("bms_banner as BB","BP.bannerId = BB.id","left");
		$this->db->join("bms_company as BC","BB.cp_code = BC.id","left");

		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){
			//if($input["sfl"] == "pname") $this->db->like("P.name", $input["stx"]);
			//if($input["sfl"] == "mname") $this->db->like("M.name", $input["stx"]);
		}

		if(isset($input["sdate"]) && $input["sdate"]) $this->db->where("BP.createDatetime >=", $input["sdate"]);
		if(isset($input["edate"]) && $input["edate"]) $this->db->where("BP.createDatetime <=", $input["edate"]);

		$this->db->where("BC.company_name IS NOT NULL",false,false);
		$this->db->order_by("cnt","desc");
		$this->db->group_by("BC.id"); //회사별로
		$this->db->limit(2000);
		$result['data']= $this->db->get()->result_array();


		//total
		$this->db->select('COUNT(*) AS cnt, BC.company_name as name ',false);
		$this->db->from($table." as BP");				
		$this->db->join("bms_banner as BB","BP.bannerId = BB.id","left");
		$this->db->join("bms_company as BC","BB.cp_code = BC.id","left");
		$this->db->where("BC.company_name IS NOT NULL",false,false);

		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){
			//if($input["sfl"] == "pname") $this->db->like("P.name", $input["stx"]);
			//if($input["sfl"] == "mname") $this->db->like("M.name", $input["stx"]);
		}

		if(isset($input["sdate"]) && $input["sdate"]) $this->db->where("BP.createDatetime >=", $input["sdate"]);
		if(isset($input["edate"]) && $input["edate"]) $this->db->where("BP.createDatetime <=", $input["edate"]);
		//$this->db->group_by("BP.productId");
		$result['total_cnt'] = $this->db->get()->row()->cnt;

		return $result;
	}
	
	function banner_company_product_sum($input){

		$table = "bms_product_hit"; //상품 히트 수 검색
		$this->db->select('SQL_CALC_FOUND_ROWS BP.*, M.name, P.name AS pname, DATE_FORMAT(BP.createDatetime, "%Y-%m-%d") AS cdate,  COUNT(*) AS cnt ',false);
		$this->db->from($table." as BP");
		$this->db->join("tb_member as M","BP.memberId = M.id","left");
		$this->db->join("tb_product as P","BP.productId = P.id","left");
		
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			if($input["sfl"] == "pname") $this->db->like("P.name", $input["stx"]);
			if($input["sfl"] == "mname") $this->db->like("M.name", $input["stx"]);
		}
		
		if(isset($input["sdate"]) && $input["sdate"]) $this->db->where("BP.createDatetime >=", $input["sdate"]);
		if(isset($input["edate"]) && $input["edate"]) $this->db->where("BP.createDatetime <=", date('Y-m-d', strtotime($input["edate"].'+1 day')));

		
		$this->db->group_by("BP.productId"); //상품별로
		$this->db->order_by("cnt","desc");
		$this->db->limit(10);
		$result['data']= $this->db->get()->result_array();
		
		//토탈
		$table = "bms_product_hit"; //상품 히트 수 검색
		$this->db->select('SQL_CALC_FOUND_ROWS BP.*, M.name, P.name AS pname, DATE_FORMAT(BP.createDatetime, "%Y-%m-%d") AS cdate,  COUNT(*) AS cnt ',false);
		$this->db->from($table." as BP");
		$this->db->join("tb_member as M","BP.memberId = M.id","left");
		$this->db->join("tb_product as P","BP.productId = P.id","left");
		
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			if($input["sfl"] == "pname") $this->db->like("P.name", $input["stx"]);
			if($input["sfl"] == "mname") $this->db->like("M.name", $input["stx"]);
		}
		
		if(isset($input["sdate"]) && $input["sdate"]) $this->db->where("BP.createDatetime >=", $input["sdate"]);
		if(isset($input["edate"]) && $input["edate"]) $this->db->where("BP.createDatetime <=", date('Y-m-d', strtotime($input["edate"].'+1 day')));
		$result['total_cnt'] = $this->db->get()->row()->cnt;

		return $result;
	}

	function banner_company_list_sum($input){
		
		$table = "bms_banner_hit";
		$this->db->select('COUNT(*) AS cnt, BC.company_name as name , BC.id as cid, P.name as pname',false);
		$this->db->from($table." as BP");				
		$this->db->join("bms_banner as BB","BP.bannerId = BB.id","left");
		$this->db->join("bms_company as BC","BB.cp_code = BC.id","left");
		$this->db->join("tb_product as P","BP.productId = P.id","left");

		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){
			//if($input["sfl"] == "pname") $this->db->like("P.name", $input["stx"]);
		}

		if(isset($input["sdate"]) && $input["sdate"]) $this->db->where("BP.createDatetime >=", $input["sdate"]);
		if(isset($input["edate"]) && $input["edate"]) $this->db->where("BP.createDatetime <=", date('Y-m-d', strtotime($input["edate"].'+1 day')));

		if(isset($input["cid"]) && $input["cid"]) $this->db->where("BC.id", $input['cid']);

		
		$this->db->order_by("cnt","desc");
		$this->db->group_by("BP.productId"); //상품별로
		$this->db->limit(10);
		$result['data']= $this->db->get()->result_array();

		// total
		$this->db->select('COUNT(*) AS cnt, BC.company_name as name , BC.id as cid, P.name as pname',false);
		$this->db->from($table." as BP");				
		$this->db->join("bms_banner as BB","BP.bannerId = BB.id","left");
		$this->db->join("bms_company as BC","BB.cp_code = BC.id","left");
		$this->db->join("tb_product as P","BP.productId = P.id","left");

		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){
			//if($input["sfl"] == "pname") $this->db->like("P.name", $input["stx"]);
		}

		if(isset($input["sdate"]) && $input["sdate"]) $this->db->where("BP.createDatetime >=", $input["sdate"]);
		if(isset($input["edate"]) && $input["edate"]) $this->db->where("BP.createDatetime <=", date('Y-m-d', strtotime($input["edate"].'+1 day')));

		if(isset($input["cid"]) && $input["cid"]) $this->db->where("BC.id", $input['cid']);
		
		$this->db->order_by("cnt","desc");
		$result['total_cnt'] = $this->db->get()->row()->cnt;

		return $result;
	}

	function email_send_list($input){

		//if(!isset($input["page"])) $input["page"] = 1;
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;

		$limit_ofset = ($input["page"]-1) * $input["pagelist"];

		$table = "zd_mail_log";

		$this->db->select('SQL_CALC_FOUND_ROWS *',false);
		$this->db->from($table." as BP");
		$this->db->join("tb_member as M","BP.memberEmail = M.id","left");


		//$this->db->join("bms_company as BC","BB.cp_code = BB.id","left");


		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){
			if($input["sfl"] == "memberEmail") $this->db->like("BP.memberEmail", $input["stx"]);
			if($input["sfl"] == "mail_title") $this->db->like("BP.mail_title", $input["stx"]);
		}

		if(isset($input["sdate"]) && $input["sdate"]) $this->db->where("BP.createDatetime >=", $input["sdate"]);
		if(isset($input["edate"]) && $input["edate"]) $this->db->where("BP.createDatetime <=", $input["edate"]);

		$this->db->order_by("BP.id","desc");
		$this->db->order_by("BP.createDatetime","desc");

		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;

	}

	function ajax_find_coupon($tiket){
		$query = "
			SELECT T.*, E.* , M.name as m_name, M.id as m_id, M.email as m_email
			FROM tb_voucher_ticket AS T
 			INNER JOIN tb_voucher_episode AS E ON T.episodeId = E.id
			Left join tb_member AS M ON T.rechargeMemberId = M.id



 			WHERE T.ticketNo = HEX(AES_ENCRYPT('".$tiket."', MD5('thedays')) )
		";
		$sql = $this->db->query($query);
		return $sql->row_array();
	}

	function xls_coupon($input){
		$query = " 
				SELECT SQL_CALC_FOUND_ROWS
					C.id, C.description, C.startDatetime, C.endDatetime, C.company, DATE_FORMAT(MC.createDatetime, '%Y-%m') AS cdate, COUNT(MC.id) AS cnt
					,(SELECT COUNT(*) FROM tb_member_coupon AS MM WHERE MM.couponId = C.id AND DATE_FORMAT(MM.createDatetime, '%Y-%m') = '2016-01' ) AS date1
					,(SELECT COUNT(*) FROM tb_member_coupon AS MM WHERE MM.couponId = C.id AND DATE_FORMAT(MM.createDatetime, '%Y-%m') = '2016-02' )AS date2
					,(SELECT COUNT(*) FROM tb_member_coupon AS MM WHERE MM.couponId = C.id AND DATE_FORMAT(MM.createDatetime, '%Y-%m') = '2016-03' )AS date3
					,(SELECT COUNT(*) FROM tb_member_coupon AS MM WHERE MM.couponId = C.id AND DATE_FORMAT(MM.createDatetime, '%Y-%m') = '2016-04' )AS date4
					,(SELECT COUNT(*) FROM tb_member_coupon AS MM WHERE MM.couponId = C.id AND DATE_FORMAT(MM.createDatetime, '%Y-%m') = '2016-05' )AS date5
					,(SELECT COUNT(*) FROM tb_member_coupon AS MM WHERE MM.couponId = C.id AND DATE_FORMAT(MM.createDatetime, '%Y-%m') = '2016-06' )AS date6
					,(SELECT COUNT(*) FROM tb_member_coupon AS MM WHERE MM.couponId = C.id AND DATE_FORMAT(MM.createDatetime, '%Y-%m') = '2016-07' )AS date7
					,(SELECT COUNT(*) FROM tb_member_coupon AS MM WHERE MM.couponId = C.id AND DATE_FORMAT(MM.createDatetime, '%Y-%m') = '2016-08' )AS date8
					,(SELECT COUNT(*) FROM tb_member_coupon AS MM WHERE MM.couponId = C.id AND DATE_FORMAT(MM.createDatetime, '%Y-%m') = '2016-09' )AS date9
					,(SELECT COUNT(*) FROM tb_member_coupon AS MM WHERE MM.couponId = C.id AND DATE_FORMAT(MM.createDatetime, '%Y-%m') = '2016-10' )AS date10
					,(SELECT COUNT(*) FROM tb_member_coupon AS MM WHERE MM.couponId = C.id AND DATE_FORMAT(MM.createDatetime, '%Y-%m') = '2016-11' )AS date11
					,(SELECT COUNT(*) FROM tb_member_coupon AS MM WHERE MM.couponId = C.id AND DATE_FORMAT(MM.createDatetime, '%Y-%m') = '2016-12' )AS date12
					,(
					SELECT COUNT(*) FROM tb_coupon AS CC
					LEFT JOIN  tb_voucher_episode AS E ON CC.id = E.couponId
					LEFT JOIN `tb_voucher_ticket` AS T ON E.id = T.episodeId
					WHERE CC.id = C.id
					GROUP BY T.episodeId
					LIMIT 1) AS useMount

				FROM tb_coupon AS C
				LEFT JOIN tb_member_coupon AS MC ON C.id = MC.couponId
				WHERE C.company IS NOT NULL
				GROUP BY C.id
				HAVING  cnt >= 1
				ORDER BY  company ASC, C.id ASC, cdate ASC
				LIMIT 10000";


		$result['xls'] = $this->db->query($query)->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;

	}
}

