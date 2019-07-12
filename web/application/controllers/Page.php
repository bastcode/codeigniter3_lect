<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller 
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
		echo '<h1>CI 3.1.10에 오신것을 환영합니다.</h1>';
		echo '<br>우선 DB세션을 사용하기 위하여 <a href="/page/create_session_table">세션 테이블을 생성 하기!</a> 를 클릭 하십시오!';
		echo '<br><a href="/page/session_test">세션 확인 하기!</a>';
	}

	public function create_session_table()
	{
		$this->load->database();
		$this->load->dbforge();

		$this->dbforge->drop_table('ci_sessions', TRUE);

		$fields = array(			
			'id' => array(
					'type' => 'VARCHAR',
					'constraint' => '40',
					'unique' => TRUE,
					'null' => FALSE,
			),
			'ip_address' => array(
					'type' =>'VARCHAR',
					'constraint' => '255',
					'null' => FALSE,
					'default' => '',
			),
			'timestamp' => array(
					'type' => 'INT',
					'constraint' => 10,
					'unsigned' => TRUE,
					'null' => FALSE,
					'default' => '0',
			),
			'data' => array(
				'type' => 'BLOB',				
				'null' => FALSE,
			),
		);
		$this->dbforge->add_field($fields);

		$attributes = array('ENGINE' => 'MYISAM');
		$this->dbforge->create_table('ci_sessions', TRUE, $attributes);
		echo '<h1>아래에 실행된 쿼리를 확인하여 주십시오! [CREATE TABLE IF NOT EXISTS `ci_sessions`] 이라고 보이면 성공 한것입니다! </h1>';
		echo '<br><a href="/">처음으로 !</a>';
		echo '<br><a href="/page/session_test">세션 확인 하기!</a>';
	}

	public function session_test() 
	{
		$this->load->library('session');//세션 라이드러리 로드		
		echo '<h1>session_test page</h1>';
		echo '에러문구가 없으면 정상적으로 DataBase 세션을 사용중 이십니다!';
	}

	
}