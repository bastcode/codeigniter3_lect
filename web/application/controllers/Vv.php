<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Vv extends CI_Controller
{
    //생성자 구성
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url'); 			//url 관련 보통 자주 사용됨
        $this->load->helper('form'); 			//form 관련 유틸 보통 자주 사용됨
        
        $this->output->enable_profiler(true); 	//프로파일 확인 디버깅 용도로 좋음  사용하지 않는다면 false 혹은 주석
    }

    public function index()
    {
        $this->load->view('up_test');
    }

    public function lite_sel()
    {
        $lite3 = $this->load->database('sqlite3');
        $db = $lite3->db->from('ci_sessions');
        $row = $db->get()->result_array();
        print_r($row);

        $tables = $lite3->db->list_tables();
        foreach ($tables as $table) {
            echo $table;
        }
    }

    public function table()
    {
        $this->load->view('crazy_table');
    }

    public function img()
    {
        $this->load->library('Favicon_lib');
        $this->favicon_lib->makeFavicon();
        $favicon_lib = new favicon_lib();
        $favicon_lib->makeFavicon();

        //$this->favicon_lib->makeFavicon();
    }
}
