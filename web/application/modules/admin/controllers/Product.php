<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('product_model');
		$this->load-> library('pagination_custom_v3');
		$this->load-> library('session');
		//$this->load-> library('aws');
		$this->load->helper(array('form', 'url'));
		$this->load-> library('admin_util');
		
		
	}

	public function _remap($method) {		
		$this->segs($method); //core 에서 로드 세그먼트 관련 유틸
		$this->admin_util->auth_check(); //권한 관련

		$data =array();
		$data['admin_lang'] = 'ko';

		$this->load->view("/admin/common/header_admin",$data);
		//$this->load->view("/admin/common/aside_left_admin",$data);		
		if( method_exists($this, $method) ){
			$this->{"{$method}"}();
		}
		$this->load->view("/admin/common/footer_admin",$data);
	}

	function index(){}//end index
		
	//상품리스트
	function product_list()
	{
		$input = array();
		//foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		$input = $this->input->get(null, true);
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$input["table"] = "tb_product";
		$data = $this->_temp_pagen("product_model","product_list", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/product/product_list_v",$data);
	}
	
	//미진열 상품리스트
	function product_hidden_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$input["table"] = "tb_product";
		$data = $this->_temp_pagen("product_model","product_hidden_list", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/product/product_hidden_list_v",$data);
	}
	
	//상품 추가 페이지
	function product_add()
	{
		$data = array();
		$this->load->view("/product/product_add_v",$data);
	}

	//상품 추가 페이지
	function product_set_add()
	{
		$data = array();
		$this->load->view("/product/product_set_add_v",$data);
	}
	
	//상품 수정 페이지
	function product_edit()
	{
		$input = array();
		$data = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["no"])) alert('not select product Id');
		
		$db = $this->product_model->select_one("tb_product", array("id"=>$input["no"]));
		//print_r($db);
		//$db_img = $this->product_model->select_get("tb_product_content", array("productId"=>$input["no"], "meta"=>"L")); //스몰사이즈로
		$db_img = $this->product_model->select_get("tb_product_content", array("productId"=>$input["no"])); //스몰사이즈로



		$input["key"] = "mk"; // key 필드 where 조건
		$input["sec"] = null; //sec  where 조건 없으면 조건에 들어가지 않음 //기본으로 sec 기준으로 ASC orderby 한다		
		$data["mata_mk"]= $this->_temp_get("product_model","product_mete", $input); //result_array 리턴
		
		$input["key"] = "add";
		$data["mata_add"]= $this->_temp_get("product_model","product_mete", $input); //result_array 리턴
		
		$input["key"] = "add2";
		$data["mata_add2"] = $this->_temp_get("product_model","product_mete", $input); //result_array 리턴
		
		$input["key"] = "cmp";
		$data["mata_cmp"] = $this->_temp_get("product_model","product_mete", $input); //result_array 리턴

		$input["key"] = "alt";
		$data["mata_alt"] = $this->_temp_get("product_model","product_mete", $input); //result_array 리턴


		$data['input'] = $input;
		$data['product'] = $db['rows'];
		$data['product_content'] = $db_img->result_array();
		$this->load->view("/product/product_edit_v",$data);
	}

	//상품 수정 페이지
	function product_set_edit()
	{
		$input = array();
		$data = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["no"])) alert('not select product Id');
		
		$db = $this->product_model->select_one("tb_product", array("id"=>$input["no"]));

		$setProduct = array();
		if($db['rows']){
			$set = explode(",",$db['rows']['setProductId']);
			$setProduct = $this->product_model->select_in("tb_product", "id",$set);
			//echo $this->db->last_query();
		}

		//print_r($setProduct);

		$data['input'] = $input;
		$data['product'] = $db['rows'];
		$data['product']['setProduct'] = $setProduct;
		
		$this->load->view("/product/product_set_edit_v",$data);
	}
	
	//셋트 상품상품 crud
	function product_set_crud()
	{
		$input = array();
		$file = array();
		foreach($this->input->post(NULL, false) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input['imagePath'])) $input['imagePath'] = null;
		$mode = $this->uri->segment(4);
		
		//생성
		if($mode == "add"){
			//insert mode
			$this->db->set("name", $input["productName"]);
			$this->db->set("price", $input["price"]);
			$this->db->set("eventPrice", $input["eventPrice"]);
			$this->db->set("setDiscountPer", $input["setDiscountPer"]);
			$this->db->set("usd", $input["usd"]);
			$this->db->set("isDisplay", $input["isDisplay"]);
			$this->db->set("sort", $input["sort"]);
			$this->db->set("pCode", $input["pCode"]);
			$this->db->set("setsType", 1); //셋트임
			$this->db->set("categoryId", 6);
			$this->db->set("setProductId", $input["setProductId"]);
			$this->db->set("createDatetime", "NOW()",false);

			
			$db = $this->db->insert('tb_product');

			//print_r($db );


			$insert_id = null;
			if($db) $insert_id = $this->db->insert_id();
			


			//이미지 등록
			if($db && $_FILES){

				if($_FILES['uploadMainImage1']) {
					$file=$this->_do_upload_multi('uploadMainImage1', $insert_id);
					//$img = $file['ObjectURL'];
				}
				if($_FILES['uploadMainImage5']) {
					$file=$this->_do_upload_multi('uploadMainImage5', $insert_id);
					//$img = $file['ObjectURL'];
				}
				if($_FILES['uploadMainImage6']) {
					$file=$this->_do_upload_multi('uploadMainImage6', $insert_id);
					//$img = $file['ObjectURL'];
				}
			}

					

		}

		//수정
		if($mode == "modify"){

			$this->db->set("setProductId", $input["setProductId"]);
			$this->db->set("name", $input["productName"]);
			$this->db->set("price", $input["price"]);
			$this->db->set("eventPrice", $input["eventPrice"]);
			$this->db->set("setDiscountPer", $input["setDiscountPer"]);
			$this->db->set("usd", $input["usd"]);
			$this->db->set("isDisplay", $input["isDisplay"]);
			$this->db->set("sort", $input["sort"]);
			$this->db->set("pCode", $input["pCode"]);
			$this->db->where("id",$input["productId"]); 
			$db = $this->db->update('tb_product');


			//이미지 등록
			if($db && $_FILES){

				if($_FILES['uploadMainImage1']) {
					$file=$this->_do_upload_multi('uploadMainImage1', $input["productId"]);
					//$img = $file['ObjectURL'];
				}
				if($_FILES['uploadMainImage5']) {
					$file=$this->_do_upload_multi('uploadMainImage5', $input["productId"]);
					//$img = $file['ObjectURL'];
				}
				if($_FILES['uploadMainImage6']) {
					$file=$this->_do_upload_multi('uploadMainImage6', $input["productId"]);
					//$img = $file['ObjectURL'];
				}
			}		
		}
		redirect("/admin/product/product_list");

		
		
	}

	//상품 crud
	function product_crud()
	{
		$input = array();
		$file = array();
		$input = $this->input->post(NULL, false);
		//foreach($this->input->post(NULL, false) as $key => $val) $input["{$key}"]  = $val;
		
		
		if(!isset($input['imagePath'])) $input['imagePath'] = null;
		//print_r($this->uri);
		//print_r( $CI->uri->segment(4));
		$mode = $this->uri->segment(4);

		
		/**  //별도의 xss 필터 추가.. 좀더 디테일 하게 필터 가능 http://htmlpurifier.org/  */
		/** 헬퍼에서 third_party 를 불러오고 있다 참고 */
		$this->load->helper('html_purify');
		//$exText = $this->input->post("exText",false);
		//$input['exText'] = html_purify($exText);

		$input['exText'] = $this->input->post("exText",false);
		
		//print_r($input);		exit;




		if($mode == "add"){
			//insert mode
			$insert = array(
				'categoryId'=>$input['categoryId'], 
				'name'=>$input['productName'],
				'runtime'=>$input['runtime'], 
				'imageText'=>$input['imageText'], 
				'pCode'=>$input['pCode'],
				
				'production'=>null, 
				'originalMusic'=>$input['originalMusic'], 
				'recommendMusic'=>$input['recommendMusic'], 
				
				'price'=>$input['price'], 
				'eventPrice'=>$input['eventPrice'], 
				'isDisplay'=>$input['isDisplay'], 
				'sort'=>$input['sort'],
				'movieVimeoId'=>$input['movieVimeoId'],
				'imagePath'=>'/uploads/product/image/', 
				
				'preset'=>$input['preset'],
				'exText'=>$input['exText'] , 

				'filetype'=>$input['filetype'] ,
				'textchange'=>$input['textchange'] ,
				'bgmchange'=>$input['bgmchange'] ,
				'edit'=>$input['edit'] ,
				'preview'=>$input['preview'] ,
				'quality'=>$input['quality'] ,
				'dvd'=>$input['dvd'] ,
				
				'listinfo'=>$input['listinfo'] ,
				'createDatetime'=>date('Y-m-d H:i:s')
			);


			
			$db = $this->product_model->insert('tb_product',$insert); //모델에 들어가서 찾지마라. MY 에서 상속된거다
			$insert_id = null;
			if($db) $insert_id = $this->db->insert_id();

			if($db && $_FILES){

				if($_FILES['uploadMainImage1']) {
					$file=$this->_do_upload_multi('uploadMainImage1', $db['insert_id']);
					//$img = $file['ObjectURL'];
				}
				
				if($_FILES['uploadMainImage3']) {
					$file=$this->_do_upload_multi('uploadMainImage3',$db['insert_id']);
				}

				//return true;
			}

			//상세 설명 추가 
			
			if($db){
				//정상 등록 이라면
				$this->_product_meta($input,$insert_id);
			}
			//exit;
			redirect("/admin/product/product_list");
		}
		
		if($mode == "modify"){
			//modify
			//print_r($input);
			$update = array();
	
			if(!isset($input['productId']) || !$input['productId']) {
				alert("상품번호가 없습니다. 다시 시도해 주십시오.","/admin/product/product_list");
			}
			if(isset($input['categoryId'])) $update['categoryId'] = $input['categoryId'];
			if(isset($input['name'])) $update['name'] = $input['name'];
			if(isset($input['runtime'])) $update['runtime'] = $input['runtime'];
			if(isset($input['imageText'])) $update['imageText'] = $input['imageText'];
			
			if(isset($input['production'])) $update['production'] = $input['production'];
			if(isset($input['originalMusic'])) $update['originalMusic'] = $input['originalMusic'];
			if(isset($input['recommendMusic'])) $update['recommendMusic'] = $input['recommendMusic'];
			if(isset($input['price'])) $update['price'] = $input['price'];
			if(isset($input['eventPrice'])) $update['eventPrice'] = $input['eventPrice'];
			if(isset($input['usd'])) $update['usd'] = $input['usd'];
			if(isset($input['pCode'])) $update['pCode'] = $input['pCode'];

			if(isset($input['listinfo'])) $update['listinfo'] = $input['listinfo'];
			
			if(isset($input['isDisplay'])) {
				if($input['isDisplay']){
					$update['isDisplay'] = 1;
				}else{
					$update['isDisplay'] = 0;
				}
				
			}
			if(isset($input['sort'])) $update['sort'] = $input['sort'];
			if(isset($input['movieVimeoId'])) $update['movieVimeoId'] = $input['movieVimeoId'];
			if(isset($input['preset'])) $update['preset'] = $input['preset'];
			if(isset($input['exText'])) $update['exText'] = $input['exText'];
			if(isset($input['keyword'])) $update['keyword'] = $input['keyword'];

			
			
			if(isset($input['filetype'])) $update['filetype'] = $input['filetype'];
			if(isset($input['textchange'])) $update['textchange'] = $input['textchange'];
			if(isset($input['bgmchange'])) $update['bgmchange'] = $input['bgmchange'];
			if(isset($input['edit'])) $update['edit'] = $input['edit'];
			if(isset($input['preview'])) $update['preview'] = $input['preview'];
			if(isset($input['quality'])) $update['quality'] = $input['quality'];
			if(isset($input['dvd'])) $update['dvd'] = $input['dvd'];
			


			$insert_id = $input["productId"];
			//$table, $where_set, $data
			$db = $this->product_model->update('tb_product',array("field"=>"id","id"=>$input["productId"]),$update); //모델에 들어가서 찾지마라. MY 에서 상속된거다
			//echo $this->db->last_query();
			if($db && $_FILES){
				//echo "<pre>";print_r($_FILES);echo "</pre>";

				//대표이미지
				if(isset($_FILES['uploadMainImage1']) && $_FILES['uploadMainImage1'] ) {
					$file=$this->_do_upload_multi('uploadMainImage1', $input['productId']);
					//$img = $file['ObjectURL'];
				}
				
				if($_FILES['uploadMainImage3']) {
					$file=$this->_do_upload_multi('uploadMainImage3',$input['productId']);
				}

				//alert('Product Data Update!','/admin/product/product_list');
				

				

				//return true;
			}

			if($db){
				//정상 등록 이라면
				$this->_product_meta($input,$insert_id, "update");
			}

			redirect("/admin/product/product_list");
			
		}
		if($mode == "del"){}
	}

	/** 멀티 형태 업로드 */
	function _do_upload_multi($target_file, $insertId = null)
	{       
		$this->load->library('upload');
		$this->load->library('aws');
		$files = $_FILES;
		//echo "tt="; echo "'$target_file'"."<br>";		
		$cpt = count($_FILES["$target_file"]['name']);
		$target_file_temp = $target_file."_temp";
		for($i=0; $i<$cpt; $i++) {
			$_FILES["$target_file_temp"]['name']   =	$files["$target_file"]['name'][$i];
			$_FILES["$target_file_temp"]['type'] = 		$files["$target_file"]['type'][$i];
			$_FILES["$target_file_temp"]['tmp_name'] = 	$files["$target_file"]['tmp_name'][$i];
			$_FILES["$target_file_temp"]['error'] =		$files["$target_file"]['error'][$i];
			$_FILES["$target_file_temp"]['size'] = 		$files["$target_file"]['size'][$i];

			//print_r($_FILES);
			
			$this->upload->initialize($this->set_upload_options());						
			if ( !$this->upload->do_upload($target_file_temp)) {
			  	$error = array('error' => $this->upload->display_errors());
				print_r($error);
				return false;
			
			} else {
				//echo "<br><br><br><br><br><br>ok";
				$data = array('upload_data' => $this->upload->data());
				//print_r($data);
				$s3 = $this->aws->s3_upload($data["upload_data"]["file_name"],null,null); //field name, s3path, filepath
				//unlink($data['upload_data']['full_path']); //file delete
				//print_r($s3);
				
				//대표이미지 저장- 업데이트
				if($s3['status'] == true && ($target_file == 'uploadMainImage1') ) {
					//how to use...  table, where_set, data
					$this->product_model->update('tb_product', array("field"=>"id", "id"=>$insertId), array('imageLFile'=>$data["upload_data"]["file_name"]));
					$this->product_model->update('tb_product', array("field"=>"id", "id"=>$insertId), array('imageSFile'=>$data["upload_data"]["file_name"]));
				}
				//슬라이드 이미지 저장
				if($s3['status'] == true && ($target_file == 'uploadMainImage3' || $target_file == 'uploadMainImage4') ) {

					$insert = array('id'=>null,'productId'=>$insertId,'sort'=>$i,'meta'=>'slide','image'=>$data["upload_data"]["file_name"], 'createDatetime'=>date('Y-m-d H:i:s'));
					$this->product_model->insert('tb_product_content',$insert);
				}

				//셋트상품 가격 이미지 PC
				if($s3['status'] == true && ($target_file == 'uploadMainImage5') ) {
					//how to use...  table, where_set, data
					$this->product_model->update('tb_product', array("field"=>"id", "id"=>$insertId), array('setImageP'=>$data["upload_data"]["file_name"]));
					
				}
				//셋트상품 가격 이미지 Mobile
				if($s3['status'] == true && ($target_file == 'uploadMainImage6') ) {
					//how to use...  table, where_set, data
					$this->product_model->update('tb_product', array("field"=>"id", "id"=>$insertId), array('setImageM'=>$data["upload_data"]["file_name"]));
					
				}
				
			}
		}
		return $s3;
	}
 
	/** 업로드 옵션 */
	function set_upload_options()
	{   
		//upload an image options
		$config = array();
		$config['upload_path']   = FCPATH . 'uploads/product/temp/';
		//$config['allowed_types'] = 'gif|jpg|png';
		$config['allowed_types'] = '*';
		$config['max_size']      = '51200'; //50MB  ... 단위는 KB
		$config['overwrite']     = false;
		$config['max_width']   = 0; //무제한
		$config['max_height']  = 0; //0 무제한
		return $config;
	}


	/** 카테고리 추가 */
	function category_add()
	{
		$data = array();		
		$this->load->view("/product/category_add_v",$data);

	}

	/** 카테고리 리스트... 일단 보류 */
	function category_list()
	{
		$input = array();
		foreach($this->input->post_get(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;
		if(!isset($input["page"])) $input["page"] = 1;
		if(!isset($input["pagelist"])) $input["pagelist"] = 30;
		$input["table"] = "tb_category";
		$data = $this->_temp_pagen("product_model","category_list", $input, $linkCnt=3);
		$data['input'] = $input;
		$this->load->view("/product/category_list_v",$data);
	}

	/** 카테고리 컨트롤 */
	function categody_crud()
	{
		$input = array();
		$file = array();
		foreach($this->input->post(NULL, TRUE) as $key => $val) $input["{$key}"]  = $val;		
		$action = $this->uri->segment(4);

		if($action){
			if($action == "add"){
				$this->_temp_get("product_model","categody_add", $input); //core 에 있음
			}
		}else{

		}
		redirect("/admin/product/product_list");


	}


	function _product_setProduct_meta($input, $insert_id, $action = "insert"){

		if( $action == "update"){
			$this->db->where("meta", $insert_id);
			$this->db->where("key", "set");		//셋트상품만 삭제
			$this->db->delete("tb_product_meta");
		}

		//갯수는 정해진게 없음
		for($i=1; 1 == $i; $i++){
			$this->db->set("meta", $insert_id); //meta  = productId
			$this->db->set("key", "set");
			$this->db->set("sec", "set-".$i);
			$this->db->set("value", $product); //상품 번호
			$this->db->set("valueTitle",null);
			$this->db->set("valueText",null);
			$this->db->set("seq", $i); //seq 
			//$this->db->insert("tb_product_meta");
		}
	}

	/*** 상품의 메타정보 등록... FAQ 스타일로 상세 정보 안내 쪽 */
	function _product_meta($input, $insert_id, $action = "insert")
	{

		if(!$insert_id){
			//미진행
		}else{
			if( $action == "update"){
				//$this->db->where("meta", $insert_id);
				//$this->db->or_where("key", "mk");
				//$this->db->or_where("key", "add");
				//$this->db->or_where("key", "add2");
				//$this->db->or_where("key", "cmp");
				//$this->db->or_where("key", "alt");
				//$this->db->delete("tb_product_meta");

				//관련된 데이터만 삭제
				$query = "delete from tb_product_meta 
							where tb_product_meta.meta = ?  AND 
							(tb_product_meta.key = ? OR tb_product_meta.key = ? OR tb_product_meta.key = ? OR tb_product_meta.key = ?  OR tb_product_meta.key = ?  ); ";
				$bind = array();
				array_push($bind, $insert_id);
				array_push($bind, "mk");
				array_push($bind, "add");
				array_push($bind, "add2");
				array_push($bind, "cmp");
				array_push($bind, "alt");				
				$this->db->query($query, $bind);				
				//echo $this->db->last_query();
			}
			//1 무비메이크				
			for($i=1; 1 == $i; $i++){

				if(!isset($input["mk-title-1"]))  $input["mk-title-1"] = "";
				if(!isset($input["mk-text-1"]))  $input["mk-text-1"] = "";
				$this->db->set("meta", $insert_id); //meta  = productId
				$this->db->set("key", "mk"); //key  = metakey is Group
				$this->db->set("sec", "mk-1"); //sec  = section is P KEY
				$this->db->set("valueTitle",$input["mk-title-1"]); //valueTitle  = title
				$this->db->set("valueText",$input["mk-text-1"]); //valueText  = value
				$this->db->set("seq", $i); //seq 
				$this->db->insert("tb_product_meta");
				
			}


			//5 만들기1				
			for($i=1; 5 >= $i; $i++){
				//없으면 빈값이라도 자동 생성해서 에러 방지
				if(!isset($input["add-title-{$i}"]))  $input["add-title-{$i}"] ="";
				if(!isset($input["add-text-{$i}"]))  $input["add-text-{$i}"] ="";
				$this->db->set("meta", $insert_id); //meta  = productId
				$this->db->set("key", "add"); //key  = metakey is Group
				$this->db->set("sec", "add-{$i}"); //sec  = section is P KEY
				$this->db->set("valueTitle",$input["add-title-{$i}"]); //valueTitle  = title
				$this->db->set("valueText",$input["add-text-{$i}"]); //valueText  = value
				$this->db->set("seq", $i); //seq 
				$this->db->insert("tb_product_meta");
			}

			//7 만들기2
			for($i=1; 7 >= $i; $i++){
				//없으면 빈값이라도 자동 생성해서 에러 방지
				if(!isset($input["add2-title-{$i}"]))  $input["add2-title-{$i}"] ="";
				if(!isset($input["add2-text-{$i}"]))  $input["add2-text-{$i}"] ="";

				$this->db->set("meta", $insert_id); //meta  = productId
				$this->db->set("key", "add2"); //key  = metakey is Group
				$this->db->set("sec", "add2-{$i}"); //sec  = section is P KEY
				$this->db->set("valueTitle",$input["add2-title-{$i}"]); //valueTitle  = title
				$this->db->set("valueText",$input["add2-text-{$i}"]); //valueText  = value
				$this->db->set("seq", $i); //seq 
				$this->db->insert("tb_product_meta");			
			}
			

			//4 완성 -- 1개 줄어듬
			for($i=1; 3 >= $i; $i++){
				if(!isset($input["cmp-title-{$i}"]))  $input["cmp-title-{$i}"] ="";
				if(!isset($input["cmp-text-{$i}"]))   $input["cmp-text-{$i}"] ="";

				$this->db->set("meta", $insert_id); //meta  = productId
				$this->db->set("key", "cmp"); //key  = metakey is Group
				$this->db->set("sec", "cmp-{$i}"); //sec  = section is P KEY
				$this->db->set("valueTitle",$input["cmp-title-{$i}"]); //valueTitle  = title
				$this->db->set("valueText",$input["cmp-text-{$i}"]); //valueText  = value
				$this->db->set("seq", $i); //seq 
				$this->db->insert("tb_product_meta");
				
			}

			//8 주의
			for($i=1; 8 >= $i; $i++){
				if(!isset($input["alt-title-{$i}"]))  $input["alt-title-{$i}"] ="";
				if(!isset($input["alt-text-{$i}"]))  $input["alt-text-{$i}"] ="";
				
				$this->db->set("meta", $insert_id); //meta  = productId
				$this->db->set("key", "alt"); //key  = metakey is Group
				$this->db->set("sec", "alt-{$i}"); //sec  = section is P KEY
				$this->db->set("valueTitle",$input["alt-title-{$i}"]); //valueTitle  = title
				$this->db->set("valueText",$input["alt-text-{$i}"]); //valueText  = value
				$this->db->set("seq", $i); //seq 
				$this->db->insert("tb_product_meta");
				
			}			
		}
	}




}
