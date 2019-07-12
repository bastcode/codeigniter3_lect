<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller 
{
	//생성자 구성
	function __construct()	
	{
		parent::__construct();
		$this->load->helper('url'); 			//url 관련 보통 자주 사용됨
		$this->load->helper('form'); 			//form 관련 유틸 보통 자주 사용됨
		
		$this->output->enable_profiler(true); 	//프로파일 확인 디버깅 용도로 좋음  사용하지 않는다면 false 혹은 주석
	}

	public function index() 
	{
		
		$this->load->view('test_html');
	}

	public function arr()
	{
		echo '<xmp>';
		//print_r($this->input->post(null));
		

		$delivery_cnt_terms = $this->input->post('delivery_cnt_terms');
		$delivery_price_terms = $this->input->post('delivery_price_terms');

		
        
        $k = 0;
        $kk = 0;
        foreach($delivery_cnt_terms as $v){            
            foreach($delivery_price_terms as $vv){ 
                if($k == $kk){
					echo $vv;
					echo '<br>';
					$arr[$k]['cnt'] = $v;
					$arr[$k]['price'] = $vv;
					break;
                }
                $kk++;
            }
            $k++;
            $kk=0;
		}
		print_r($arr);

		foreach($arr as $key => $val){
			var_dump($key, $val);
			
			echo '<br>';
		}
		
		echo '</xmp>';
		
	}

}