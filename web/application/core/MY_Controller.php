<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function mytest()
    {
        echo "Core Extends mytest";
    }

    public function _temp_pagen($model,$model_func, $input, $method = "get", $linkCnt = 2)
	{
		$this->load-> library('pagination_custom_v3');
		$this->segs = $this->uri->segment_array();
		$this->load->model("{$model}");
		$db_data = $this->{$model}->{$model_func}($input);
		if($linkCnt) {
			$i = 1; $link_url="";
			while($linkCnt >= $i) {
				$link_url = $link_url."/".$this->segs[$i];  
				$i++;
			}
		}
		
		$total_count = $db_data['total_cnt'];
		$data['total_count'] = $total_count;
		
		$config = $this->pagination_custom_v3->pagenation_bootstrap($input["page"], $total_count, $input["pagelist"], $link_url, $linkCnt++, $num_link=3);
		
		
		if($method == "segment") $config['page_query_string'] = false; //쿼리 스트링 on off
		$config['page_query_string'] = true;
		
		
		$this->pagination_custom_v3->initialize($config);
		$data['page_nation'] = $this->pagination_custom_v3->create_links();
		$data['lists'] = $db_data['page_list_m'];
		
		//print_r($data['page_nation']);
		return $data;
	}

	//세그멘트 관리
	//$this->segs 하면 배열로 세그먼트를 넘겨받음
	//$this->full_uri 현재 주소의 풀 세그먼트를 받음
	//$this->uri   메소드 제외 세그먼트를 받음
	public function segs($method = null)
	{
		$this->segs = $this->uri->segment_array();
		$this->full_uri = "/";
		$this->urilink = "/";

		if(count($this->segs) > 1){
			$uri = $this->segs[count($this->segs)-1];
		}else{
			$uri = $this->uri->segment(0);
		}

		foreach($this->segs as $key => $val){
			$this->full_uri .=  $val."/";		
		}

		//메소드가 있으면 메소드로
		//메소드가 없으면 강제로 -1 한 값으로 한다
		if($method) {
			foreach($this->segs as $key => $val){
				if($method == $val){				
					break;
				}
				$this->urilink = $this->urilink . $val."/";
			}
		}else{			
			foreach($this->segs as $key => $val){
				if($uri == $val){				
					break;
				}
				$this->urilink = $this->urilink . $val."/";
			}
		}
		
	}

	//단순 모델 검색 반환
	public function _temp_get($model,$model_func, $input)
	{
		$this->load->model("{$model}");		
		return $this->{$model}->{$model_func}($input);
	}

}