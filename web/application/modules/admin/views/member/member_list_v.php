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
			$("#page_form").submit();
		});



		$.datepicker.regional['en'] = {
			         closeText: '닫기',
			        prevText: '이전달',
			         nextText: '다음달',
			         currentText: '오늘',
			         monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
			         monthNamesShort: ['1월','2월','3월','4월','5월','6월', '7월','8월','9월','10월','11월','12월'],
			         dayNames: ['일','월','화','수','목','금','토'],
			         dayNamesShort: ['일','월','화','수','목','금','토'],
			         dayNamesMin: ['일','월','화','수','목','금','토'],
			         weekHeader: 'Wk',
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


		$(".excel_down").click(function (event){
			event.stopPropagation();
			event.preventDefault(); //이벤트 전파 금지
			//var params = $("#page_form" ).serializeArray();

			$("#page_form").attr("target","#excel");
			$("#page_form").attr("action", "/admin/member_excel_down");
			$("#page_form").submit();
			$("#page_form").attr("target","");
			$("#page_form").attr("action","");
		});
	});
	

</script>


<ifream id="excel"></ifream>

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
							<option value 	<?php if(!isset($input[ 'sfl']) || !$input[ 'sfl']) echo "selected";?>>전체</option>
								<option value="memberName" <?php  if(isset($input[ 'sfl']) && $input[ 'sfl']=="memberName" ) echo "selected";?> >회원이름</option>
								<option value="yomiName" <?php  if(isset($input[ 'sfl']) && $input[ 'sfl']=="yomiName" ) echo "selected";?> >요미이름</option>
								<option value="memberEmail" <?php if(isset($input[ 'sfl']) && $input[ 'sfl']=="memberEmail" ) echo "selected";?> >회원이메일</option>
								
								<option value="mobile" <?php if(isset($input[ 'sfl']) && $input[ 'sfl']=="mobile" ) echo "selected";?> >연락처</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">검색문구</label>
						<div class="col-sm-8">
							<input type="text" name="stx" class="form-control" id="stx" value="<?php echo (isset($input['stx']) )? $input['stx'] : "" ?>" placeholder="검색문구를 넣어주세요" />
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" for="sdate">가입일</label>
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

					<table class="table table-headered table-condensed">
						<thead>
							<th>num</th>							
							<th>회원이름</th>
							<th>email</th>
							<th>연락처</th>
							<th>권한레벨</th>
							<th>가입타입</th>

							<th>가입일</th>
							<th>수정</th>
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
									<?php echo $val['first_name']." ".$val['last_name'];?>
									<br>
									<?php echo $val['yomi_first_name']." ".$val['yomi_last_name'];?>
								</td>
								<td>
									<?php echo $val['email'];?>
								</td>
								<td>
									<?php echo $val['mobile'];?>
								</td>
								<td>
									
									<?php echo $this->admin_util->auth_lv($val['auth_lv']);?>
									<?php echo "(".$val['auth_lv'].")"; ?>
								</td>
								<td>
									<?php echo $this->admin_util->sns_type($val['sns_type']);?>
								</td>

								<td>
									<?php echo $val['createDatetime'];?>
								</td>
								<td>
									<a href="/admin/member/member_modify/<?php echo $val['id']?>" class="btn btn-info">수정</a>
								</td>
							</tr>
							<?php endforeach;  ?>
					</table>
				</div>
				<!-- Start .row -->
				<div class="page-nation">
					<ul class="pagination">
						<?php echo $page_nation?>
					</ul>
				</div>

			</div>
		</div>
			<!-- End .content-wrapper -->
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
