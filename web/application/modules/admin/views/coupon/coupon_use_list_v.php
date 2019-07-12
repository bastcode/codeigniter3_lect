<style type="text/css"></style>
<script>
	$(document).ready(function() {
		$(".pagination a").click(function(event) {
			event.stopPropagation();
			//alert($(this).data("num"));
			$("#page").val($(this).data("num"));
			$("#page_form").submit();

		});

		$("#form_post").click(function(event) {
			$("#page_form").submit();
		});
		$("#reset").click(function(event) {
			$("#page").val("1");
			$("#sfl").val("");
			$("#stx").val("");
			$("#sdate").val("");
			$("#edate").val("");
			$("#page_form > div > input:checkbox").prop("checked",false);
			$("#use_coupon").val("");
			$("#page_form").submit();
			
		});


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

		partner_list();

		$(".excel_down").click(function (event){
			//alert();
			event.stopPropagation();
			event.preventDefault(); //이벤트 전파 금지
			//var params = $("#page_form" ).serializeArray();

			$("#page_form").attr("target","#excel");
			$("#page_form").attr("action", "/admin/coupon_excel_down");
			$("#page_form").submit();
			$("#page_form").attr("target","");
			$("#page_form").attr("action","");
		});
	});

	function partner_list(){
		$.ajax({
			type: "POST",
			data: {},
			cache: false,
			async: false,
			url: "/api/partner_list",
			dataType: "json",
			success: function(data){
				$.each( data.partnerlist, function( key, value ) {
					
					$("#company_name").append("<option value="+value['cp_code']+" data-id='"+value['cp_code']+"'>"+value['cp_name']+"</option>");
				});
				chk_partner();
			}
		});
	}

	function chk_partner(){

		var vars = [], hash;
		var query = document.URL.split('?')[1];

		if(query != undefined){
			query = query.split('&');
			//console.log(query);
			for(var i = 0; i < query.length; i++){
				hash = query[i].split('=');		

				if(hash[0] == "company_name"){
					//alert(hash[0]);
					//console.log(hash);
					$("#company_name").val(hash[1]).prop("selected",true);
				}
			}
			
		};

	}

</script>


<ifream id="excel"></ifream>

<div class="col-md-12">
<div class="row">
<div class="container">


		<!-- Start .content-inner -->
		<div class="content-inner">
			<form action="" id="page_form" method="get" class="form-horizontal">
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">검색타입</label>
						<div class="col-sm-8">
							<input type="hidden" name="page" id="page" value="<?php echo (isset($input['page']) && $input['page']>=1)? $input['page'] : 1 ?>" />
							<select name="sfl" id="sfl" class="form-control">
							<option value 	<?php if(!isset($input[ 'sfl']) || !$input[ 'sfl']) echo "selected";?>>전체</option>
								<option value="coupon_number" <?php  if(isset($input[ 'sfl']) && $input[ 'sfl']=="coupon_number" ) echo "selected";?> >쿠폰번호</option>
								<option value="coupon_name" <?php  if(isset($input[ 'sfl']) && $input[ 'sfl']=="coupon_name" ) echo "selected";?> >쿠폰이름</option>
								<option value="coupon_descript" <?php  if(isset($input[ 'sfl']) && $input[ 'sfl']=="coupon_descript" ) echo "selected";?> >쿠폰설명</option>
								
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">검색문구</label>
						<div class="col-sm-8">
							<input type="text" name="stx" class="form-control" id="stx" value="<?php echo (isset($input['stx']) )? $input['stx'] : "" ?>" placeholder="검색문구를넣어주세요" />
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">쿠폰 상태</label>
						<div class="col-sm-8">
							<select name="use_coupon" id="use_coupon" class="form-control">
								<option value="" <?php  if(isset($input[ 'use_coupon']) && $input[ 'use_coupon']=="" ) echo "selected";?> >전체</option>
								<option value="not_use" <?php  if(isset($input[ 'use_coupon']) && $input[ 'use_coupon']=="not_use" ) echo "selected";?> >미사용쿠폰</option>
								<option value="is_use" <?php  if(isset($input[ 'use_coupon']) && $input[ 'use_coupon']=="is_use" ) echo "selected";?> >사용한쿠폰</option>								
							</select>
						</div>
					</div>


					<div class="form-group">
						<label class="control-label col-sm-2">쿠폰 발급 회사</label>
						<div class="col-sm-8">
							<select name="company_name" id="company_name" class="form-control">
								<option value="">전체</option>
							</select>
						</div>
					</div>

					

					<div class="form-group">
						<label class="control-label col-sm-2" for="sdate">쿠폰사용일</label>
						
						<div class="col-sm-3">
							<input type="text" name="sdate" class="form-control" id="sdate" value="<?php echo (isset($input['sdate']) )? $input['sdate'] : "" ?>" placeholder="시작일"  />
						</div>
						<div class="col-sm-3">
							<input type="text" name="edate" class="form-control" id="edate" value="<?php echo (isset($input['edate']) )? $input['edate'] : "" ?>" placeholder="종료일"  />
						</div>
					</div>

					<input type="hidden" name="type" id="type" value="<?php echo (isset($input['type']) )? $input['type'] : " " ?>" />
					
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						<a href="javascript:;" id="reset" class="btn btn-info">검색 초기화</a>
						<button type="submit" id="form_post" class="btn btn-default">검색 </button>
						<button class="btn btn-success excel_down">엑셀다운로드</button>
						</div>
					</div>
				</form>

				
			<div class="table-responsive" style="overflow: hidden; width: 100%; height: auto;">
				<table class="table  table-headered">
					<thead>
						<th>num</th>
						<th>발급회사</th>
						<th>쿠폰명</th>
						<th>쿠폰설명</th>
						<th>쿠폰번호</th>
						<th>등록자</th>
						<th>사용여부</th>
						<th>남은사용일</th>
					</thead>
					<?php
						$page = $input["page"];
						$pagelist = $input["pagelist"];
						if(is_numeric($page) == false) $page = 1;
						if($page < 0) $page = 1;

						$total_count = $total_count - (($page -1) * $pagelist);
					
						foreach ($lists as $key => $val): 
							$startDate = date_create(date('Y-m-d')); // 오늘 날짜입니다.
							$targetDate = date_create($val['coupon_edate']); // 타겟 날짜를 지정합니다.
							$interval = date_diff($startDate, $targetDate);	
							$endDay = $interval->days;
					?>
						<tr>
							<td>
								<?php echo $total_count--;?>
							</td>	
							<td>							
								<?php echo$val['cp_name'];?>
							</td>
							<td>							
								<?php echo$val['coupon_name'];?>
							</td>
							<td>							
								<?php echo$val['coupon_descript'];?>
							</td>
							
							<td>							
								<?php echo$val['coupon'];?>
							</td>	
							<td>							
								<?php echo$val['memberEmail'];?>
							</td>							
							<td>							
								<?php echo ($val['is_use'])?"사용":"미사용";?>
							</td>
							<td>							
								<?php echo $endDay;?>
							</td>
						</tr>
						<?php endforeach;  ?>
				</table>
			</div>
			<!-- Start .row -->
			<div class="page-nation">
				<ul class="pagination">
					<?php echo $page_nation; ?>
				</ul>
			</div>

		</div>
	</div>
	<!-- End .content-wrapper -->
	<div class="clearfix"></div>
</div>
<!-- End #content -->

						</div>
						</div>
