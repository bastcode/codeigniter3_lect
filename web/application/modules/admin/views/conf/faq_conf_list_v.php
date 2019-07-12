<script>
	$(document).ready(function() {

		$(".delete").click(function (){

		});


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
<!-- Start #right-sidebar -->
<!-- Start #content -->
<div id="content">


	<!-- Start .content-wrapper -->
	<div class="content-wrapper">

		<div class="container">
			<!-- Start .content-inner -->
			<div class="content-inner">
				<!-- form action="" id="page_form" method="get" class="form-horizontal">
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">검색타입</label>
						<div class="col-sm-8">
							<input type="hidden" name="page" id="page" value="<?=(isset($input['page']) && $input['page']>=1)? $input['page'] : 1 ?>" />
							<select name="sfl" id="sfl" class="form-control">
								<option value="memberName" <? if(isset($input[ 'sfl']) && $input[ 'sfl']=="title" ) echo "selected";?> >title</option>
								<option value="memberEmail" <? if(isset($input[ 'sfl']) && $input[ 'sfl']=="content" ) echo "selected";?> >content</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">검색문구</label>
						<div class="col-sm-8">
							<input type="text" name="stx" class="form-control" id="stx" value="<?=(isset($input['stx']) )? $input['stx'] : " " ?>" placeholder="검색문구를 넣어주세요" />
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" for="sdate">Date</label>
						<div class="col-sm-3">
							<input type="text" name="sdate" class="form-control" id="sdate" value="<?=(isset($input['sdate']) )? $input['sdate'] : " " ?>" placeholder="시작일"  />
						</div>
						<div class="col-sm-3">
							<input type="text" name="edate" class="form-control" id="edate" value="<?=(isset($input['edate']) )? $input['edate'] : " " ?>" placeholder="종료일"  />
						</div>
					</div>

					<input type="hidden" name="type" id="type" value="<?=(isset($input['type']) )? $input['type'] : " " ?>" />
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<a href="javascript:;" id="reset" class="btn btn-info">검색 초기화</a>
							<button type="submit" id="form_post" class="btn btn-default">검색 </button>
						</div>
					</div>
				</form -->

				<div class="table-responsive" style="overflow: hidden; width: 100%; height: auto;">

					<table class="table table-headered table-condensed">
						<thead>

							<th>seq</th>
							<th>tag_name</th>
							<th>edit</th>
						</thead>
						<?
						$page = $input["page"];
						$pagelist = $input["pagelist"];
						if(is_numeric($page) == false) $page = 1;
						if($page < 0) $page = 1;

						$total_count = $total_count - (($page -1) * $pagelist);

						foreach ($lists as $key => $val):
					?>
							<tr>
								<td>
									<input type="text" name="seq" value="<?=$val['seq']?>" />
								</td>
								<td>
									<?=$val['title']?>
								</td>
								<td>
									<a href="/admin/conf/faq_conf_edit/<?=$val['id']?>" class="btn btn-info modify">수정</a>
									<a href="javascript:;" data-id="<?=$val['id']?>" class="btn btn-danger delete">삭제</a>
								</td>
							</tr>
							<? endforeach;  ?>
					</table>
					<a href="/admin/conf/faq_conf_insert" class="btn btn-success">생성</a>
				</div>
				<!-- Start .row -->
				<div class="page-nation">
					<ul class="pagination">
						<?=$page_nation?>
					</ul>
				</div>


			</div>
		</div>
		<!-- End .content-wrapper -->
		<div class="clearfix"></div>
	</div>
	<!-- End #content -->
