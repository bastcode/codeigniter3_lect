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
		onCheckbox();
	});

function onCheckbox() {
	var vars = [], hash;
	var query = document.URL.split('?')[1];

	if(query != undefined){
		query = query.split('&');
		console.log(query);
		for(var i = 0; i < query.length; i++){
			hash = query[i].split('=');		
			//vars.push(hash[1]);
			$('input[name="conditions[]"][value="' + hash[1] + '"]').prop('checked', true);
		}
		
	};
}



</script>

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
								<option value="moviemakeId" <?php if(isset($input[ 'sfl']) && $input[ 'sfl']=="moviemakeId" ) echo "selected";?> >제작번호</option>
								<option value="memberName" <?php  if(isset($input[ 'sfl']) && $input[ 'sfl']=="memberName" ) echo "selected";?> >회원이름</option>
								<option value="memberEmail" <?php if(isset($input[ 'sfl']) && $input[ 'sfl']=="memberEmail" ) echo "selected";?> >이메일</option>
								<option value="productName" <?php if(isset($input[ 'sfl']) && $input[ 'sfl']=="productName" ) echo "selected";?> >상품명</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">검색문구</label>
						<div class="col-sm-8">
							<input type="text" name="stx" class="form-control" id="stx" value="<?php echo (isset($input['stx']) )? $input['stx'] : "" ?>" placeholder="제작번호, 상품명, 이메일, 주문자, 카테고리" />
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" for="sdate">제작일</label>
						
						<div class="col-sm-3">
							<input type="text" name="sdate" class="form-control" id="sdate" value="<?php echo (isset($input['sdate']) )? $input['sdate'] : "" ?>" placeholder="시작일"  />
						</div>
						<div class="col-sm-3">
							<input type="text" name="edate" class="form-control" id="edate" value="<?php echo (isset($input['edate']) )? $input['edate'] : "" ?>" placeholder="종료일"  />
						</div>
					</div>

					<input type="hidden" name="type" id="type" value="<?php echo (isset($input['type']) )? $input['type'] : " " ?>" />
					<div class="form-group">
						<label class="control-label col-sm-2"></label>
						<div class="col-sm-8">
						<fieldset>
								<label class="checkbox-inline"><input id="conditions1" class="conditions" name="conditions[]" type="checkbox" value="10">대기중</label>
								<label class="checkbox-inline"><input id="conditions2" class="conditions" name="conditions[]" type="checkbox" value="20">진행중</label>
								<label class="checkbox-inline"><input id="conditions3" class="conditions" name="conditions[]" type="checkbox" value="30">랜더대기</label>
								<label class="checkbox-inline"><input id="conditions4" class="conditions" name="conditions[]" type="checkbox" value="35">랜더중</label>
								<label class="checkbox-inline"><input id="conditions4" class="conditions" name="conditions[]" type="checkbox" value="40">제작완료(보관중)</label>
								<label class="checkbox-inline"><input id="conditions5" class="conditions" name="conditions[]" type="checkbox" value="50">보관만료</label>
						</fieldset>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						<a href="javascript:;" id="reset" class="btn btn-info">초기화</a>
						<button type="submit" id="form_post" class="btn btn-default">검색</button>
						</div>
					</div>
				</form>

				
			<div class="table-responsive" style="overflow: hidden; width: 100%; height: auto;">
				<table class="table table-headered table-condensed">
					<thead>
						<th>num</th>
						<th>주문번호</th>
						<th>제작번호</th>
						<th>진행상태</th>
						
						<th>제작상품</th>
						<th>이메일</th>
						<th>주문자</th>
						<th>제작완료 일시</th>
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
								<a href="<?php echo "/admin/order/order_detail/".$val['orderId'];?>">P<?php echo $val['orderId'];?></a>
							</td>

							<td>
								<a href="<?php echo $this->urilink."movie_detail/".$val['id'];?>">M<?php echo $val['id'];?></a>
							</td>
								
							
							<td>
								<?php echo $this->admin_util->movie_status($val['status']);?>
							</td>
							
							
							<td>
								<?php echo$val['productName'];?>
							</td>
							<td>
								<?php echo$val['email'];?>
							</td>
							<td>
								<?php echo $val['first_name']." ".$val['last_name'];?><br>
								<?php echo $val['yomi_first_name']." ".$val['yomi_last_name'];?>
							</td>
							
							<td>
								<?php echo ($val['completeDatetime'] == "0000-00-00 00:00:00" || !$val['completeDatetime'])?"":$val['completeDatetime'];?>
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
