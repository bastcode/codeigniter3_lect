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

		onCate();
	});

	function onCate(){
		$.ajax({
		type: "POST",
		data: {},
		cache: false,
		async: false,
		url: "/api/catelist",
		dataType: "json",
		success: function(data){
			var sel = "";			
			$.each( data.catelist, function( key, value ) {
				if(value['id'] == sel) {

					$("#categoryId").append("<option value="+value['id']+" selected>"+value['title']+"</option>");
				} else {
			   		$("#categoryId").append("<option value="+value['id']+">"+value['title']+"</option>");
			   	}
				
			});
		}
		});    
	}

</script>
<div class="col-md-12">
<div class="row">
<div class="container">


		<!-- Start .content-inner -->
		<div class="content-inner">
			<form action="" id="page_form" method="get" class="form-horizontal">
				

				<div class="form-group">
					<label class="control-label col-sm-2" for="sdcategoryIdate">category</label>
					<div class="col-sm-8">
						<select name="categoryId" id="categoryId" class="form-control">
							<option value="">전체</option>
						
						</select>
					</div>
				</div>

				<input type="hidden" name="type" id="type" value="<?php echo(isset($input['type']) )? $input['type'] : " " ?>" />
				
			</form>

			<div class="table-responsive" style="overflow: hidden; width: 100%; height: auto;">
			
					<table class="table table-headered table-condensed">
						<thead>
							<th>num</th>
							<th>카테고리명</th>
							<th>생성일</th>
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
									<?php echo $val['id']?>
								</td>
                                <td>
									<?php echo $val['title']?>
								</td>
								<td>
									<?php echo $val['createDatetime']?>
								</td>
								<td><button class="btn btn-info">수정</button></td>
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
<!-- End #content -->
						</div></div>
