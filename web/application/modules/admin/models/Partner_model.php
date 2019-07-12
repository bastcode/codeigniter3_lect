<?php
class Partner_model extends MY_Model {
	function __construct(){
        parent::__construct();
    }

    function partner_list($input)
    {
        if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];
		
		$this->db->select('SQL_CALC_FOUND_ROWS T1.*, M.auth_lv as auth, M.role as role  ',false);
        $this->db->from($input['table']." as T1");
        $this->db->join("tb_member as M","T1.cp_member_id = M.id","inner");
		
		//검색 조건 추가
		if(isset($input["sfl"]) && $input["sfl"] && $input["stx"] && $input["stx"]){			
			if($input["sfl"] == "cp_name") $this->db->like("T1.cp_name", $input["stx"]);           		 
		}	

		
		if(isset($input["sdate"]) && $input["sdate"]) $this->db->where("T1.create_datetime >=", $input["sdate"]);
		if(isset($input["edate"]) && $input["edate"]) $this->db->where("T1.create_datetime <=", date('Y-m-d', strtotime($input["edate"].'+1 day')));
		
		$this->db->order_by("T1.cp_code","desc");		
		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		//echo $this->db->last_query(); //마지막에 실행된 쿼리 출력
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;
    }

    function partner_detail($input)
    {
        $this->db->select("C.*, M.email, M.password, M.auth_lv, M.role, M.first_name, M.last_name, M.yomi_first_name, M.yomi_last_name ");
        $this->db->from("tb_company as C");
        $this->db->join("tb_member as M","C.cp_member_id = M.id","inner");
        $this->db->where("cp_code",$input["id"]);
        $sql = $this->db->get();
        if($sql->num_rows() > 0 ){
            return $sql->row_array();
        }else{
            return false;
        }

    }

    function partner_insert($input)
    {
        $member = array();
        $partner = array();
        $this->db->trans_start();
        //일반 회원 테이블에 생성 하고 company 에 넣는다        
        $member['first_name'] = $input['first_name'];
        $member['last_name'] = $input['last_name'];
        $member['yomi_first_name'] = $input['yomi_first_name'];
        $member['yomi_last_name'] = $input['yomi_last_name'];


        $member['userId'] = "";
        $member['password'] = hash("sha512",$input['member_password']);
        
        $member['role'] = $input['member_role'];
        $member['mobile'] = "";
        $member['email'] = $input['member_email'];
        $member['isExit'] = null;
        $member['exitDatetime'] = null;
        $member['auth_lv'] = $input['member_auth'];
        $member['sns_type'] = "MT";        
        $this->db->set("createDatetime","now()",false);
        $this->db->insert("tb_member",$member);

        $member_id = $this->db->insert_id();
        

        $cp_api_key = null;
        if($input['cp_api_key']){
            $cp_api_key = hash("sha512",$input['cp_api_key']);
        }
        
        $partner['cp_coupon_group_code'] = $input['cp_coupon_group_code'];
        $partner['cp_name'] = $input['cp_name'];
        $partner['cp_auth'] = '1';
        $partner['cp_rut'] = '';
        $partner['cp_http'] = '';
        $partner['cp_member_id'] = $member_id;
        $partner['cp_type'] = $input['cp_type'];
        $partner['cp_memo'] = $input['cp_memo'];
        $partner['cp_api_key'] = $cp_api_key;
        $this->db->set("create_datetime","now()" ,false);
        $this->db->insert("tb_company",$partner);        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    function partner_modify($input)
    {

        $member = array();
        $partner = array();

        $partner["cp_name"] = $input['cp_name'];
        $partner["cp_type"] = $input['cp_type'];
        $partner["cp_memo"] = $input['cp_memo'];

        //있으면 변경
        if($input['cp_api_key']){            
            $partner["cp_api_key"] = hash("sha512",$input['cp_api_key']);
        }

        $this->db->trans_start();
        $this->db->where("cp_code",$input['cp_code']);
        $this->db->update("tb_company",$partner);


        $member['first_name'] = $input['first_name'];
        $member['last_name'] = $input['last_name'];
        $member['yomi_first_name'] = $input['yomi_first_name'];
        $member['yomi_last_name'] = $input['yomi_last_name'];
        $member['email'] = $input['member_email'];
        if($input['member_password']) $member['password'] = hash("sha512",$input['member_password']);

        $this->db->where("id",$input['cp_member_id']); //회원 번호
        $this->db->update("tb_member",$member);

        $this->db->trans_complete();
        return $this->db->trans_status();


        //echo $this->db->last_query();

    }
	

}
