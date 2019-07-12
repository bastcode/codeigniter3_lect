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
	});

</script>

<div class="col-md-12">
	<div class="row">
		<div class="container">
			<div class="content-inner">
				<form action="" id="page_form" method="get" class="form-horizontal">
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">검색타입</label>
						<div class="col-sm-8">
							<input type="hidden" name="page" id="page" value="<?php echo (isset($input['page']) && $input['page']>=1)? $input['page'] : 1 ?>" />
							<select name="sfl" id="sfl" class="form-control">
								<option value="meta" <?php  if(isset($input[ 'sfl']) && $input[ 'sfl']=="meta" ) echo "selected";?> >키값</option>
								<option value="type" <?php  if(isset($input[ 'sfl']) && $input[ 'sfl']=="type" ) echo "selected";?> >종류</option>
								<option value="value" <?php  if(isset($input[ 'sfl']) && $input[ 'sfl']=="value" ) echo "selected";?>> 데이터</option>
								
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">검색문구</label>
						<div class="col-sm-8">
							<input type="text" name="stx" class="form-control" id="stx" value="<?php echo (isset($input['stx']) )? $input['stx'] : "" ?>" placeholder="검색문구를넣어주세요" />
						</div>
					</div>

					

					<input type="hidden" name="type" id="type" value="<?php echo (isset($input['type']) )? $input['type'] : " " ?>" />
					
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						<a href="javascript:;" id="reset" class="btn btn-info">검색 초기화</a>
						<button type="submit" id="form_post" class="btn btn-default">검색 </button>
						</div>
					</div>
				</form>
				
				<div class="content-box-large">
					Define 설정 테이블
					<span class="red">* 담당자 외 건들지 말아주세요. 사이트 오류 납니다.</span>
				</div>
				<div class="table-responsive" style="overflow: hidden; width: 100%; height: auto;">
					<table class="table table-headered table-condensed">
						<thead>
							<th>num</th>
							<th>종류</th>
							<th>키값</th>
							<th>데이터</th>
							<th>설명</th>
							
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
									<?php echo$val['type'];?>
								</td>
								<td>
								<?php echo$val['meta'];?>
								</td>							
								<td>
									<?php echo$val['value'];?>
								</td>
								<td>
									<?php echo$val['discript'];?>
								</td>
								

							</tr>
						<?php endforeach;  ?>
					</table>
				</div>
					
				<div class="page-nation">
					<ul class="pagination">
						<?php echo $page_nation; ?>
					</ul>
				</div>
			</div>
		</div>		
	</div>
</div>			