<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Favicon_lib
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }
    
    /**
     *
     */
    public function makeFavicon()
    {
		//업로드 설정
        $my_config = array(
            'upload_path' => FCPATH . 'upload/favicon/',
            'allowed_types' => 'png',
            'max_size' => '10485760', //10mb
            'max_width' => '1024',    //px
            'max_height' => '768',   //px
            'encrypt_name' => true
        );
		
		//폴더 유무 확인 없으면 생성
		$dirpath = $my_config['upload_path'];		
        if (!is_dir($dirpath)) {
            @mkdir($dirpath, 0777);
		}
        
        if( count(array_keys($_FILES)) > 0)  {
            $file_key = implode(array_keys($_FILES));
        }
        
        $this->CI->load->library('upload', $my_config);
        // Upload init
        $this->CI->upload->initialize($my_config);
        // Do Upload
        if (!$this->CI->upload->do_upload($file_key)) {
			//업로드 실패
            $data = array('error' => $this->CI->upload->display_errors(), 'upload_data' => '');
        } else {
			//업로드 성공
            $data = array('upload_data' => $this->CI->upload->data(), 'error' => '');
            //터치 파비콘
            $this->imagegResize($data['upload_data']['full_path'], $data['upload_data']['file_path'] . "apple-touch-icon-36x36". $data['upload_data']['file_ext'], 36, 36); //아이폰 기본
            $this->imagegResize($data['upload_data']['full_path'], $data['upload_data']['file_path'] . "apple-touch-icon-57x57". $data['upload_data']['file_ext'], 57, 57); //iPad Touch, iPhone 3G의 1세대
            $this->imagegResize($data['upload_data']['full_path'], $data['upload_data']['file_path'] . "apple-touch-icon-60x60". $data['upload_data']['file_ext'], 60, 60);  //iPhone iOS7+
            $this->imagegResize($data['upload_data']['full_path'], $data['upload_data']['file_path'] . "apple-touch-icon-72x72". $data['upload_data']['file_ext'], 72, 72);  //아이패드 홈스크린 아이콘 (iPad non-retina)
            $this->imagegResize($data['upload_data']['full_path'], $data['upload_data']['file_path'] . "apple-touch-icon-76x76". $data['upload_data']['file_ext'], 76, 76); //아이패드 홈스크린 아이콘 (iPad non-retina iOS 7)
            $this->imagegResize($data['upload_data']['full_path'], $data['upload_data']['file_path'] . "apple-touch-icon-114x114". $data['upload_data']['file_ext'], 114, 114); //아이폰 레티나 (iOS 6 and lower
            $this->imagegResize($data['upload_data']['full_path'], $data['upload_data']['file_path'] . "apple-touch-icon-120x120". $data['upload_data']['file_ext'], 120, 120); //아이폰 레티나 터치 (iPhone retina, iOS 7 and higher)
            $this->imagegResize($data['upload_data']['full_path'], $data['upload_data']['file_path'] . "apple-touch-icon-152x152". $data['upload_data']['file_ext'], 152, 152); //아이패드 터치
            $this->imagegResize($data['upload_data']['full_path'], $data['upload_data']['file_path'] . "apple-touch-icon-167x167". $data['upload_data']['file_ext'], 167, 167); //아이패드 레티나 터치 (iPad Retina touch)
            $this->imagegResize($data['upload_data']['full_path'], $data['upload_data']['file_path'] . "apple-touch-icon-180x180". $data['upload_data']['file_ext'], 180, 180); //아아폰6 plus
            
            //일반 파비콘
            $this->imagegResize($data['upload_data']['full_path'], $data['upload_data']['file_path'] . "favicon-16". $data['upload_data']['file_ext'], 16, 16); //구 IE
            $this->imagegResize($data['upload_data']['full_path'], $data['upload_data']['file_path'] . "favicon-32". $data['upload_data']['file_ext'], 32, 32); //크롬은 16*16을 가져올수 없고 대신 32*32를 가져옴
            $this->imagegResize($data['upload_data']['full_path'], $data['upload_data']['file_path'] . "favicon-96". $data['upload_data']['file_ext'], 96, 96); //구글 Tv
            
            //안드로이드
            $this->imagegResize($data['upload_data']['full_path'], $data['upload_data']['file_path'] . "android-chrome-192x192". $data['upload_data']['file_ext'], 192, 192); //안드로이드 크롬

            //MS
            $this->imagegResize($data['upload_data']['full_path'], $data['upload_data']['file_path'] . "mstile-144x144". $data['upload_data']['file_ext'], 144, 144); //IE10 매트로 타일
            
            //오페라
            $this->imagegResize($data['upload_data']['full_path'], $data['upload_data']['file_path'] . "Opera-195x195". $data['upload_data']['file_ext'], 195, 195); //opera 스피드 다이얼 아이콘
            $this->imagegResize($data['upload_data']['full_path'], $data['upload_data']['file_path'] . "Opera-228x228". $data['upload_data']['file_ext'], 228, 228); //opera Coast 아이콘
        }
        return $data;
    }

    /**
     *
     */
    protected function imagegResize($pull_path, $path, $width, $height)
    {
        $error = null;

        $this->CI->load->library('image_lib');
        $config['image_library'] = 'gd2'; //라이브러리
        $config['source_image'] = $pull_path;  //원본소스 풀 경로 - 파일명 포함
        $config['create_thumb'] = false;  //썸네일로 생성 true일 경우 복수로 만들어도 1개의 썸네일만 만듬
        $config['maintain_ratio'] = false; //기본 비율 유지
        $config['width']         = $width;
        $config['height']       = $height;
        $config['new_image']       = $path;  //새롭게 만들 파일 경로 및 파일명
        
        $this->CI->image_lib->clear();
        $this->CI->image_lib->initialize($config);
        $this->CI->image_lib->resize();
        
        if (!$this->CI->image_lib->resize()) {
            $error = $this->CI->image_lib->display_errors();
        }
        return [
            'error' => $error
        ];
    }
}
