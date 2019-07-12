<script>
	$(document).ready(function() {
		$(".pagination a").click(function(event) {
			event.stopPropagation();
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
			$("#categoryId option:eq(0)").attr("selected", "selected");

			$("#page_form > div > input:checkbox").prop("checked", false);
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
			<h3>협렵업체 리스트 </h3>
			<!-- Start .content-inner -->
			<div class="content-inner">
					<form action="" id="page_form" method="get" class="form-horizontal">
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">검색타입</label>
							<div class="col-sm-8">
								<input type="hidden" name="page" id="page" value="<?php echo(isset($input['page']) && $input['page']>=1)? $input['page'] : 1 ?>" />
								<select name="sfl" id="sfl" class="form-control">	
									<option value 	<?php if(!isset($input[ 'sfl']) || !$input[ 'sfl']) echo "selected";?>>전체</option>								
									<option value="cp_name" <?php if(isset($input[ 'sfl']) && $input[ 'sfl']=="cp_name" ) echo "selected";?>> 업체명</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">검색문구</label>
							<div class="col-sm-8">

								<input type="text" name="stx" id="stx" class="form-control" value="<?php echo(isset($input['stx']) )? $input['stx'] : '' ?>" placeholder="업체명" />
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-2" for="sdate">가입일</label>
							<div class="col-sm-3">
								<input type="text" name="sdate" id="sdate" class="form-control" value="<?php echo(isset($input['sdate']) )? $input['sdate'] : '' ?>" placeholder="시작일"  />
							</div>
							<div class="col-sm-3">
								<input type="text" name="edate" id="edate" class="form-control" value="<?php echo(isset($input['edate']) )? $input['edate'] : '' ?>" placeholder="종료일"  />
							</div>
						</div>

						<input type="hidden" name="type" id="type" value="<?php echo(isset($input['type']) )? $input['type'] : " " ?>" />
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<a href="javascript:;" id="reset" class="btn btn-info">검색 초기화</a>
								<button type="submit" id="form_post" class="btn btn-default">검색 </button>
							</div>
						</div>
					</form>

					<div class="table-responsive" style="overflow: hidden; width: 100%; height: auto;">
					
							<table class="table table-headered table-condensed">
								<thead>
									<th>num</th>
									<th>업체명</th>
									<th>업체 권한레벨</th>
									<th>업체 권한 ROLE</th>
									<th>업체 맴버 아이디</th>
									<th>업체 타입</th>
									<th>메모</th>
									<th>업체 API KEY</th>
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
											<?php echo $val['cp_name']?>
										</td>
										<td>
											<?php echo $this->admin_util->auth_lv($val['auth']);?>
										</td>
										<td>
											<?php echo $val['role']?>
										</td>
										<td>
											<a href="/admin/member/member_modify/<?php echo $val['cp_member_id']?>"><?php echo $val['cp_member_id']?></a>
										</td>
										<td>
											<?php echo $val['cp_type']?>
										</td>
										<td>
											<?php echo $val['cp_memo']?>
										</td>
										<td>
											<?php echo $val['cp_api_key']?>
										</td>
									
										<td><a href="<?php echo $this->urilink;?>partner_modify/?id=<?php echo $val['cp_code']?>" class="btn btn-info">수정</a></td>
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
