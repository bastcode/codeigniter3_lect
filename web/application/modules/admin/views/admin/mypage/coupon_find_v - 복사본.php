<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title> :: The days :: </title>
    <!--[if IE]><meta http-equiv="x-ua-compatible" content="IE=9" /><![endif]-->

    <link rel="icon" href="/assets/images/favicon.ico" type="image/png">

    <!-- Windows8 touch icon ( http://www.buildmypinnedsite.com/ )-->
    <meta name="msapplication-TileColor" content="#3399cc" />

	<link rel="stylesheet" href="/assets2/css/normalize.css">
<link rel="stylesheet" href="/assets2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="/assets2/css/jquery.bxslider.css">
<link rel="stylesheet" href="/assets2/css/common.css">
<link rel="stylesheet" href="/assets2/css/m.css">

    <script src="http://code.jquery.com/jquery-1.9.0.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script src="/assets2/js/bootstrap.min.js"></script>
	<script>
$(document).ready(function (){
		$(".find_id").click(function (){

			$("#m_id", opener.document).val($(this).data("id"));
			$("#m_email", opener.document).val($(this).data("email"));
			window.close();
		});

		$(".pagination a").click(function (event){
		  	event.stopPropagation ();
			$("#page").val($(this).data("num")); //검색 번호 유지
			$("#page_form").submit();
		});

		$("#stx").keydown(function (key) {
	        if(key.keyCode == 13) search();
		});

		$("#form_post").click(function (event){
			search();
		});

		$("#reset").click(function (){
			$("#page").val("1");
			$("#sfl").val("");
			$("#stx").val("");
			$("#sdate").val("");
			$("#edate").val("");
			$("#page_form").submit();
		});


		$.datepicker.regional['ko'] = {
			 closeText: '닫기',
			 prevText: '이전달',
			 nextText: '다음달',
			 currentText: '오늘',
			 monthNames: ['1월','2월','3월','4월','5월','6월',
			 '7월','8월','9월','10월','11월','12월'],
			 monthNamesShort: ['1월','2월','3월','4월','5월','6월',
			 '7월','8월','9월','10월','11월','12월'],
			 dayNames: ['일','월','화','수','목','금','토'],
			 dayNamesShort: ['일','월','화','수','목','금','토'],
			 dayNamesMin: ['일','월','화','수','목','금','토'],
			 //weekHeader: 'Wk',
			 dateFormat: 'yy-mm-dd',
			 firstDay: 0,
			 isRTL: false,
			 duration:200,
			 showMonthAfterYear: true,
			 autoSize: false, //오토리사이즈(body등 상위태그의 설정에 따른다)
			 changeMonth: true, //월변경가능
			 changeYear: true, //년변경가능
			 yearRange: '1990:2020',
			 yearSuffix: '년'
		};
		$.datepicker.setDefaults($.datepicker.regional['ko']);
		$("#sdate").datepicker();
		$("#edate").datepicker();
	});

	//검색 반응
	function search(){
		$("#page").val("1"); //검색시 페이지를 1로 초기화
		$("#page_form").submit();
	}
	</script>
</head>


<body>
<!-- #container -->
<div id="container" class="clearfix">

	<!-- 페이지 시작-->

	<div id="bg_company" class="bg_cover" style="min-height: 800px; ">
		<h1>쿠폰 찾기</h1>
		<div class="w1140">
			<div class="form-group">
			<form action="" id="page_form" method="get" >
				<input type="hidden" name="page"	id="page"	value="<?=(isset($input['page']) && $input['page']>=1)? $input['page'] : 1 ?>" />
				<input type="hidden" name="type" 	id="type" 	value="<?=(isset($input['type']) )? $input['type'] : "" ?>" />

				<div class="col-md-2"><input type="text" name="pin_num1" value="" /></div>
				<div class="col-md-2"><input type="text" name="pin_num2" value="" /></div>
				<div class="col-md-2"><input type="text" name="pin_num3" value="" /></div>
				<div class="col-md-2"><input type="text" name="pin_num4" value="" /></div>


				<div class="col-md-6">
				<a href="javascript:;" id="reset" class="btn">리셋</a>
				<a href="javascript:;" id="form_post" class="btn">검색</a>
				</div>
			</form>
			</div>

			<div class="table-responsive" style="overflow: hidden; width: 100%; height: auto;">
				<table class="table table-headered table-condensed">
				<thead>
					<th>번호</th>
					<th>회원번호</th>
					<th>아이디</th>
					<th>이름</th>
					<th>이메일</th>
				</thead>
				<tbody>
						<?php
						$atts = array(
								'width'       => 938,
								'height'      => 600,
								'scrollbars'  => 'no',
								'status'      => 'no',
								'resizable'   => 'no',
								'screenx'     => 0,
								'screeny'     => 0,
								'window_name' => '_blank'
						);

						//page set
						$page = $input["page"];
						$pagelist = $input["pagelist"];
						if(is_numeric($page) == false) $page = 1;
						if($page < 0) $page = 1;

						$total_count = $total_count - (($page -1) * $pagelist);
						foreach ($lists as $key => $val): ?>
							<tr>
								<td><? echo $total_count--;?></td>
								<td><a href="javascript:;" class="find_id" data-email="<?=$val['email']?>" data-id="<?=$val['id']?>"><?=$val['id']?></a></td>
								<td><?=$val['userId']?></td>
								<td><?=$val['name']?></td>
								<td><?=$val['email']?></td>
							</tr>
						<? endforeach;  ?>
					</tbody>
				</table>
			</div>

			<!-- Start .page-nation -->
			<div class="page-nation">
				<ul class="pagination">
					<?=$page_nation?>
				</ul>
			</div>
			<!-- End .page-nation-->
		</div>

			<div id="ajax"></div>
		</div>
	</div>

	<!-- //페이지 끝-->

</div>
<!-- //container -->
</body>
</html>
