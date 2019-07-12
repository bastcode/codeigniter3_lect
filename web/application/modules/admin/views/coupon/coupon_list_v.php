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


		$(".excel_down_singe").click(function (event){
			//alert();
			//event.stopPropagation();
			event.preventDefault(); //이벤트 전파 금지
			//var params = $("#page_form" ).serializeArray();

			$("#hide_id").val($(this).data("id"));
			$("#form_excel").attr("target","#excel");
			$("#form_excel").attr("action", "/admin/coupon_list_excel_down");
			$("#form_excel").submit();

		});
	});

	

</script>

<form action="" method="get" id="form_excel">
<input type="hidden" id="hide_id" name="id" >
</form>

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
								<option value="coupon_name" <?php  if(isset($input[ 'sfl']) && $input[ 'sfl']=="coupon_name" ) echo "selected";?> >쿠폰이름</option>
								<option value="coupon_descript" <?php  if(isset($input[ 'sfl']) && $input[ 'sfl']=="coupon_descript" ) echo "selected";?> >쿠폰설명</option>
								<option value="company_name" <?php  if(isset($input[ 'sfl']) && $input[ 'sfl']=="company_name" ) echo "selected";?> >쿠폰발급회사</option>

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
						<label class="control-label col-sm-2" for="sdate">쿠폰사용일</label>
						
						<div class="col-sm-3">
							<input type="text" name="sdate" class="form-control" id="sdate" value="<?php echo (isset($input['sdate']) )? $input['sdate'] : "" ?>" placeholder="시작일"  />
						</div>
						<div class="col-sm-3">
							<input type="text" name="edate" class="form-control" id="edate" value="<?php echo (isset($input['edate']) )? $input['edate'] : "" ?>" placeholder="종료일"  />
						</div>
					</div>

					<input type="hidden" name="type" id="type" value="<?php echo (isset($input['type']) )? $input['type'] : "" ?>" />
					
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						<a href="javascript:;" id="reset" class="btn btn-info">검색 초기화</a>
						<button type="submit" id="form_post" class="btn btn-default">검색 </button>
						</div>
					</div>
				</form>

				
			<div class="table-responsive" style="overflow: hidden; width: 100%; height: auto;">
				<table class="table  table-headered">
					<thead>
						<th>num</th>
						<th>쿠폰발급회사</th>
						<th>쿠폰이름</th>
						<th>쿠폰설명</th>
						<th>할인율</th>
						<th>쿠폰타입</th>
						<th>쿠폰시작~쿠폰종료일</th>
						<th>수정 / 엑셀다운로드</th>
					</thead>
					<?php
						$page = $input["page"];
						$pagelist = $input["pagelist"];
						if(is_numeric($page) == false) $page = 1;
						if($page < 0) $page = 1;

						$total_count = $total_count - (($page -1) * $pagelist);
					
						foreach ($lists as $key => $val): 
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
								<?php echo$val['coupon_discount'];?>
							</td>
							<td>							
								<?php echo $val['coupon_type'];?>
							</td>
							<td>							
								<?php echo date("Y-m-d",strtotime($val['coupon_sdate']));?> ~ <?php echo $val['coupon_edate'];?>
							</td>
							<td>							
								<a href="<?php echo $this->urilink."coupon_detail/".$val['id'];?>" class="btn btn-info" >수정</a>
								<a href="javascript:;" class="btn btn-success excel_down_singe" data-id="<?php echo $val['id'];?>">엑셀</a>
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
