<?php
class Coupon_model extends MY_Model {
	function __construct(){
        parent::__construct();
    }
    
    

    public function coupon_list ($input)
	{
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		
		$this->db->select('SQL_CALC_FOUND_ROWS T1.*, C.cp_name ',false);
		$this->db->from($input['table']." as T1");		
		$this->db->join("tb_company as C"," C.cp_code = T1.company_id","inner");

		if(isset($input["sfl"]) && isset($input["stx"])){
			//쿠폰이름
			if($input["sfl"] == "coupon_name"){
				$this->db->like("T1.coupon_name", $input["stx"]);
			}

			//쿠폰 설명
			if($input["sfl"] == "coupon_descript"){
				$this->db->like("T1.coupon_descript", $input["stx"]);
			}

			//쿠폰 설명
			if($input["sfl"] == "company_name"){
				$this->db->like("C.cp_name", $input["stx"]);
			}
			
		}
		

		$this->db->order_by("T1.id","desc");
		$this->db->limit($input["pagelist"],$limit_ofset);
		

		$result['page_list_m']= $this->db->get()->result_array();
		//echo $this->db->last_query(); //마지막에 실행된 쿼리 출력
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;
	}

	/** 쿠폰상세 */
	public function coupon_detail($input)
	{

		$reslut = array();
        $this->db->from("tb_coupon_group");
		$this->db->where("id",$input["id"]);
		$sql = $this->db->get();
		//echo $this->db->last_query();
        if($sql->num_rows() >0){

			$reslut["coupon_group"] =  $sql->row_array();

			$this->db->select("count(*) as cnt",false);
			$this->db->from("tb_coupon");
			$this->db->where("coupon_group_code",$input["id"]);
			$reslut["total_count"] = $this->db->get()->row()->cnt;

			$this->db->select("count(*) as cnt",false);
			$this->db->from("tb_coupon");
			$this->db->where("coupon_group_code",$input["id"]);
			$this->db->where("is_use ", true);
			$reslut["total_use_count"] = $this->db->get()->row()->cnt;
			
		}else{
			$reslut["coupon_group"] = array();
			$reslut["total_use_count"] = 0;
			$reslut["total_count"] = 0;

		}
		return $reslut;
	}

	

	/** 사용한 쿠폰 리스트 */
	public function coupon_use_list($input)
	{
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
	
		//AES_DECRYPT(UNHEX(필드명), '암호화 키') 
		//AES_DECRYPT(UNHEX(T1.coupon_number), "momentto") as coupon 
		$this->db->select('SQL_CALC_FOUND_ROWS T1.*, T1.coupon_number as coupon, C.cp_name, G.coupon_name, G.coupon_edate, G.coupon_descript, T1.use_memberEmail as memberEmail ',false);
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

		$result['page_list_m']= $this->db->get()->result_array();
		//echo $this->db->last_query(); //마지막에 실행된 쿼리 출력
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;

	}

	/** 쿠폰 생성 */
	public function coupon_create($input)
	{
		
		$insert = array();
		$insert["company_id"] = $input["company_id"];
		$insert["company_coupon_code"] = $input["company_coupon_code"];
		$insert["coupon_name"] = $input["coupon_name"];
		$insert["coupon_descript"] = $input["coupon_descript"];
		$insert["coupon_discount"] = $input["coupon_discount"];
		$insert["coupon_sdate"] = date("Y-m-d 00:00:00",strtotime($input["coupon_sdate"]));
		$insert["coupon_edate"] = date("Y-m-d 23:59:59",strtotime($input["coupon_edate"]));
		$insert["apply_category"] = $input["apply_category"];
		$insert["exption_product"] = $input["exption_product"];
		$this->db->set("modifyDatetime", "now()",false);
		$this->db->set("createDatetime", "now()",false);
		$this->db->insert("tb_coupon_group",$insert);
		$cp_id = $this->db->insert_id();
		
		
		$insertCoupon = array();
		for($i=1; $input["conpon_count"]>= $i; $i++){
			$insertCoupon["coupon_group_code"] = $cp_id;
			//HEX(AES_ENCRYPT('문자열', '암호화 키'))
			$gen_num =  $this->secretlib->gen_coupon();
			$coupon_num = $input['company_coupon_code'].$gen_num;
			//$this->db->set("coupon_number","HEX(AES_ENCRYPT('".$coupon_num."', 'momentto'))",false); //암호 없애기로 함 선아 팀장 백.

			//중복체크
			if($this->_dup_coupon($coupon_num)){
				$this->db->set("coupon_number",$coupon_num);
				$this->db->insert("tb_coupon",$insertCoupon);
			}else{
				
			}
		}
	}

	/** 쿠폰수정 */
	public function coupon_update($input)
	{
		
		$this->db->set("coupon_name", $input["coupon_name"]);
		$this->db->set("coupon_descript", $input["coupon_descript"]);
		$this->db->set("coupon_discount", $input["coupon_discount"]);
		$this->db->set("coupon_sdate",date("Y-m-d 00:00:00",strtotime($input["coupon_sdate"])));
		$this->db->set("coupon_edate",date("Y-m-d 00:00:00",strtotime($input["coupon_edate"])));



		if(isset($input["apply_category"])){
			$this->db->set("apply_category", $input["apply_category"]);
		}
		if(isset($input["exption_product"])){
			$this->db->set("exption_product", $input["exption_product"]);
		}
		$this->db->set("modifyDatetime", "now()",false);
		$this->db->where("id",$input["coupon_id"]);
		$this->db->update("tb_coupon_group");

		//echo $this->db->last_query();

		if($input["conpon_count"]>0){
			$data = array();

			$data["id"] = $input["coupon_id"]; //쿠폰 아이디
			$data["coupon_group_code"] = $input["coupon_id"]; //위와 동일한것.

			$data["conpon_count"] = $input["conpon_count"];//생성숫자
			$data['company_coupon_code'] = $input['company_coupon_code'];
			$this->coupon_add($data);
			//echo "<br>";			echo $this->db->last_query();
		}
		
	}

	public function coupon_add($input)
	{
		

		$reslut = array();
        $this->db->from("tb_coupon_group");
		$this->db->where("id",$input["id"]);
        $sql = $this->db->get();
        if($sql->num_rows() >0){

            $insertCoupon = array();
            for($i=1; $input["conpon_count"]>= $i; $i++){
                $insertCoupon["coupon_group_code"] = $input["id"]; 
                $gen_num =  $this->secretlib->gen_coupon();
                $coupon_num = $input['company_coupon_code'].$gen_num;  // MMIT + 생성된쿠폰 9자리
                //$this->db->set("coupon_number","HEX(AES_ENCRYPT('".$coupon_num."', 'momentto'))",false); //암호 없애기로 함 선아 팀장 백.                
                //중복체크
                if($this->_dup_coupon($coupon_num)){
                    $this->db->set("coupon_number",$coupon_num);
                    $this->db->insert("tb_coupon",$insertCoupon);
                }else{
                    //중복시
                }
            }

            $result["result"] = true;
            $result["message"] = "ok";
        }else{
            $result["result"] = false;
            $result["message"] = "해당하는 id가 없습니다.";
        }
	}

	function _dup_coupon($coupon_num)
	{

		$this->db->from("tb_coupon");
		$this->db->where("coupon_number", $coupon_num);
		$sql = $this->db->get();

		if($sql->num_rows() >0){
			return false; //중복
		}else{
			return true; //중복아님
		}

	}


	

	
	

}
