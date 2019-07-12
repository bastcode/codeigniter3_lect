<script>
	$(document).ready(function() {


		$.datepicker.regional['en'] = {
			//         closeText: '닫기',
			//        prevText: '이전달',
			//         nextText: '다음달',
			//         currentText: '오늘',
			//         monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
			//         monthNamesShort: ['1월','2월','3월','4월','5월','6월', '7월','8월','9월','10월','11월','12월'],
			//         dayNames: ['일','월','화','수','목','금','토'],
			//         dayNamesShort: ['일','월','화','수','목','금','토'],
			//         dayNamesMin: ['일','월','화','수','목','금','토'],
			//         weekHeader: 'Wk',
			dateFormat: 'yy-mm-dd',
			firstDay: 0,
			isRTL: false,
			duration: 200,
			showMonthAfterYear: true,
			autoSize: true, //오토리사이즈(body등 상위태그의 설정에 따른다)
			changeMonth: true, //월변경가능
			changeYear: true, //년변경가능
			yearRange: '1990:2020',
			yearSuffix: 'Year'
		};
		$.datepicker.setDefaults($.datepicker.regional['en']);
		$("#sdate").datepicker();
		$("#edate").datepicker();


		coupon_list();


});
$(document).on('change','#company_name',function(e){
		var option = $(this).find("option:selected").text();		
		var value = $(this).find("option:selected").val();
		var cp_code = $(this).find("option:selected").data("id");
		$("#company_coupon_code").val(value);
		$("#company_id").val(cp_code);

	});
function coupon_list(){
		$.ajax({
			type: "POST",
			data: {},
			cache: false,
			async: false,
			url: "/api/coupon_group_list",
			dataType: "json",
			success: function(data){
				//console.log(data);
				$.each( data, function( key, value ) {
					$("#coupon_list").append("<option value="+value['id']+" >"+value['coupon_descript']+"</option>");
					
				});
			}
		});
	}
</script>
<div class="col-md-12">
	<div class="row">
		<div class="container">
			<div class="content">
			
				<!-- main content -->
				<div class="header-wrap well">
					<header class="list-page-header">
						<h1 class="member-id text-center"> 이벤트  </h1>
						<p class="pull-left"><a class="btn btn-info" href="<?php echo $this->urilink;?>event_list/"><i class="icon-list-alt icon-white"></i>이벤트리스트</a></p>
						<div>
							<p class="pull-right"><a class="btn btn-primary saveBtn" href="#"><i class="icon-ok icon-white"></i>저장</a></p>
						</div>
					</header>
				</div>
				<!-- .header-wrap -->
				<form class="form_post" accept-charset="utf-8" enctype="multipart/form-data" action="/admin/conf/event_proc/insert" method="post" >
				

				<section class="sec_detail">
					<table class="table table-headered table-condensed ">
						<thead>
							<tr>
								<th>이벤트 제목</th>								
								<th>타이틀 이미지</th>
								<th>이벤트 시작일자</th>
								<th>이벤트 종료일자</th>
								
							</tr>
						</thead>
						<tbody>
							<tr>								
								<td><input type="text" name="title" value=""></td>
								<td><input type="file" name="eventTitleImage[]"></td>
								<td><input type="text" id="sdate" name="startDate" value=""> </td>
								<td><input type="text" id="edate" name="endDate" value=""> </td>
													
							</tr>
						</tbody>
					</table>
				</section>

				<section class="sec_detail">
					<h3>SNS 쿠폰 자동 발급 설정</h3>
					<table class="table table-headered table-condensed ">
						<thead>
							<tr>
								<th>쿠폰선택</th>								
								<th>쿠폰 비당첨 이미지</th>
								<th>쿠폰 당첨 이미지</th>							
							</tr>
						</thead>
						<tbody>
							<tr>								
								<td><select name="coupon_group_code" id="coupon_list">
										<option value="">발급해줄 쿠폰을 선택해 주십시오.</option>
									</select><br>
									<span class="red">* 해당 쿠폰이 없으면 먼저 쿠폰을 생성해 주십시오.</span></td>
								<td><input type="file" name="couponimage1[]"></td>
								<td><input type="file" name="couponimage2[]"></td>			
							</tr>
						</tbody>
					</table>
				</section>


				<section class="sec_detail">
					<h3>내용 상세</h3>
					<textarea name="content" id="content" style="width: 100%; height: 400px;"></textarea>
				</section>



				</form>

				
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>

<script>



CKEDITOR.replace( 'content' , {            
            filebrowserUploadUrl : '/upload/ckedit',
            //language          :'ja'
        });

</script>
