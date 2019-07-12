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

		var params = $("#page_form" ).serialize();
		var url = $("#url" ).val();

		var html = "<tr>";

		var input = "";
		input = $("input[name=pin_num1]").val()+"-"+$("input[name=pin_num2]").val()+"-"+$("input[name=pin_num3]").val()+"-"+$("input[name=pin_num4]").val();
		
		if(!$("input[name=pin_all]").val()){
			if(!$("input[name=pin_num1]").val()) {
				alert("1번 번호가 비어있습니다.");
				return false;
			}
			if(!$("input[name=pin_num2]").val()) {
				alert("2번 번호가 비어있습니다.");
				return false;
			}
			if(!$("input[name=pin_num3]").val()) {
				alert("3번 번호가 비어있습니다.");
				return false;
			}
			if(!$("input[name=pin_num4]").val()) {
				alert("4번 번호가 비어있습니다.");
				return false;
			}
		} else{
			input = $("input[name=pin_all]").val();
		}

		$("input[name=pin_num1]").val("");
		$("input[name=pin_num2]").val("");
		$("input[name=pin_num3]").val("");
		$("input[name=pin_num4]").val("");
		$("input[name=pin_all]").val("");

		$.ajax({
			 type: "POST",
			 data: params,
			 url: url,
			 dataType: "json",
			 success: function(data) {
				  var data2 = JSON.stringify(data);
				  //$("#ajax" ).text(data2);
				  //alert(data2);

				 if(data.status){
					 if(data.data.id){

						 var useId = data.data.m_email;
						 var useName = data.data.m_name;
						 var useDate = data.data.rechargeDatetime;

						 if(!data.data.rechargeMemberId) useId = "미사용";
						 if(!data.data.rechargeMemberId) useName = "미사용";
						 if(!data.data.rechargeDatetime) useDate = "미사용";

						 html = html+ "<td><input type='checkbox' name='chk[]' value='"+data.data.id+"' /></td>";
						 html = html+ "<td>"+input+"</td>";
						 html = html+ "<td>"+data.data.name+"</td>";
						 html = html+ "<td>"+data.data.description+"</td>";
						 html = html+ "<td>"+useId+"</td>";
						 html = html+ "<td>"+useName+"</td>";
						 html = html+ "<td>"+useDate+"</td>";
						 html = html+ "<td>"+data.data.startDatetime+"</td>";
						 html = html+ "<td>"+data.data.endDatetime+"</td>";
						 //html = html+ "<td><a href='javascript:;' class='btn'>사용</a><br><a href='javascript:;' class='btn'>비사용</a><br><a href='javascript:;' class='btn'>블럭</a></td>";
						 html = html + "</tr>";

						 $("table > tbody").prepend(html);
					 }else{
						 html = html+ "<td></td>";
						 html = html+ "<td>"+input+"</td>";
						 html = html+ "<td clospan='7'>해당 하는 쿠폰이 없습니다.</td>";
						 html = html+ "<td></td><td></td><td></td><td></td><td></td><td></td>"; //6
						 html = html + "</tr>";
						 $("table > tbody").prepend(html);

					 }
				 } else{
					 	 html = html+ "<td></td>";
					 	 html = html+ "<td>"+input+"</td>";
						 html = html+ "<td clospan='7'>입력 형식이 잘못 되었습니다.</td>";
						 html = html+ "<td></td><td></td><td></td><td></td><td></td><td></td>"; //6
						 html = html + "</tr>";
						 $("table > tbody").prepend(html);
				 }

			 }
		}) ;



	}
	</script>
</head>

<body>
<!-- #container -->
<div id="content">


	<!-- Start .content-wrapper -->
	<div class="content-wrapper">
		<h1>통합 쿠폰 조회 및 처리</h1>

		<!-- Start .content-inner -->
		<div class="content-inner">
			<div class="form-group">
			<form action="" id="page_form" method="get" >
				<input type="hidden" name="url" id="url" value="/admin/mypage/ajax_coupon_find" >
				<input type="hidden" name="page"	id="page"	value="<?=(isset($input['page']) && $input['page']>=1)? $input['page'] : 1 ?>" />
				<input type="hidden" name="type" 	id="type" 	value="<?=(isset($input['type']) )? $input['type'] : "" ?>" />

				<div class="col-md-2"><input type="text" name="pin_num1" value="" maxlength="4"  /></div>
				<div class="col-md-2"><input type="text" name="pin_num2" value="" maxlength="4" /></div>
				<div class="col-md-2"><input type="text" name="pin_num3" value="" maxlength="4" /></div>
				<div class="col-md-2"><input type="text" name="pin_num4" value="" maxlength="4" /></div>

				<div class="col-md-12"><input type="text" name="pin_all" value="" maxlength="20" style="width:70%;" placeholder="예 : PWY4-PGBC-PAW4-PYF4 (풀 넘버용)"  /></div>
				<div class="col-md-2"><a href="javascript:;" id="form_post" class="btn">검색</a></div>
			</form>
			</div>

			<div class="table-responsive" style="overflow: hidden; width: 100%; height: auto;">
				<form action="/admin/mypage/useCoupon" method="post" id="form_chk" >
				<input type="hedden" name="mode" value="used" />
				<table class="table table-headered table-condensed">
					<thead><th>[]</th><th>입력한 쿠폰번호</th><th>쿠폰이름</th><th>쿠폰설명</th><th>사용유저</th><th>사용자이름</th><th>사용시간</th><th>쿠폰시작일</th><th>쿠폰종료일</th></thead>
					<tbody></tbody>
				</table>
				<button  class="btn btn-success btn-xs">전송</button>
				</form>
			</div>

			<!-- a href="javascipt:;" id="post_btn1" >사용처리</a>
			<a href="javascipt:;" id="post_btn2" >비사용처리</a>
			<a href="javascipt:;" id="post_btn3" >블럭처리</a -->

			<!-- Start .page-nation -->
			<div class="page-nation">
				<ul class="pagination">
				</ul>
			</div>
			<!-- End .page-nation-->
		</div>

	</div>
</div>
<!-- //페이지 끝-->

</body>
</html>
