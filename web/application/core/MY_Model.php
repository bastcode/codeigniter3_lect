<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

	
	//단일 테이블 단일 로우 검색
    function select_one($table,$data)
	{
        $this->db->from($table);
        $this->db->where($data);
        $result['rows']= $this->db->get()->row_array();
        return $result;
	}
	
	function select_in($table,$id,$data)
	{
        $this->db->from($table);
		$this->db->where_in($id, $data);        		
        return $this->db->get()->result_array();
    }
	

	function select_get($table, $data = false, $orderby = false, $limit = false)
	{
        $this->db->from($table);
        if($data) $this->db->where($data);
		if($orderby) $this->db->order_by(key($orderby), $orderby[key($orderby)]);
		if($limit) $this->db->limit($limit);
        return $this->db->get();
    }


	function select_sum($table, $data = false, $sum)
	{
		$this->db->select_sum($sum);
		$this->db->from($table);
		$this->db->where($data);
		return $this->db->get()->row()->{$sum};



	}




	//인서트
    function insert($table,$data)
	{
        $result['status'] =  $this->db->insert($table, $data);		
        $result['insert_id'] = $this->db->insert_id();
        return $result;
    }


    //삭제
    function delete($table,$data)
	{
		$result['status'] =  $this->db->delete($table, $data);
		return $result;
    }
    

	function update_plus($table, $where_set, $data)
	{
        $this->db->set($data["field"], $data["field"] ."+1", FALSE);
        $this->db->where($where_set["field"], $where_set["id"]);
        $result['status'] = $this->db->update($table);
		return $result;
    }


 	function update($table, $where_set, $data)
	{
        $this->db->where($where_set["field"], $where_set["id"]);
        $result['status'] = $this->db->update($table, $data);
		return $result;
    }

	//심플 insert insert_batch
	public function insert_batch($table, $data)
	{
		return $result['status'] = $this->db->insert_batch($table, $data);		
	}
	

	//심플 페이지 네이션 처리
	public function page_list_m($input)
	{
		if(is_numeric($input["page"]) == false) $input["page"] = 1;
		if($input["page"] < 0) $input["page"] = 1;
		
		$limit_ofset = ($input["page"]-1) * $input["pagelist"];

		$table = $input["table"];//테이블 명으로 받아옴
		
		$this->db->select('SQL_CALC_FOUND_ROWS T1.* ',false);
		$this->db->from($table." as T1");

		$this->db->limit($input["pagelist"],$limit_ofset);

		$result['page_list_m']= $this->db->get()->result_array();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return $result;

	}
}
