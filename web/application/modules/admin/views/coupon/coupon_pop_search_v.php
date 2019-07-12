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

		$(".pop_alt_close").click(function (){
			alert("적용되었습니다.");		
			window.close();
			self.close();
			close();			
		});
		$(".pop_close").click(function (){
			
			window.close();
			self.close();
			close();			
		});
	});

	function onCate(){
		$.ajax({
		type: "POST",
		data: {},
		cache: false,
		async: false,
		url: "/api/catelistN",
		dataType: "json",
		success: function(data){
			var sel = "<?php echo (isset($input['categoryId']))?$input['categoryId']:0;?>";			
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
	$(document).on('click','.p_id',function(e){
		var p_id = $(this).data("id");
		var name = $(this).data("name");

		var ex_id =  $(opener.document).find("#exption_product").val();

		var price = $(this).data("price");
		var ex_price = $(opener.document).find("#price").val();//토탈

		var discount = 15;
		
		


		if(ex_price) ex_price = parseInt(ex_price);
		
		price = parseInt(price);

		//alert(ex_id.match(p_id) + "---" + p_id);
		if(ex_id.match(p_id) == p_id){
			alert(name + "-동일한 상품이 있습니다!!");
		}else{

			if(ex_id){
				ex_id = ex_id + "," + p_id;
			}else{
				ex_id = ex_id + p_id;
			}


			var total = $(opener.document).find("#div_exption_product").find("button").length+1;
			if(total <=2) discount = 15;
			if(total == 3) discount = 20;
			if(total == 4) discount = 25;
			if(total >= 5) discount = 30;

			ex_price = ex_price + price;
			$(opener.document).find("#price").val(ex_price);//토탈
			ex_price = ex_price - (ex_price *  (discount / 100));
			$(opener.document).find("#eventPrice").val(ex_price);
			$(opener.document).find("#setDiscountPer").val(discount+"%");

			
			$(opener.document).find("#exption_product").val(ex_id);
			$(opener.document).find("#div_exption_product").append("<button class='btn btn-success remove_p_btn' item='"+p_id+"'  data-price="+price+">"+name+"</button>");
		}

	});
	

</script>

<div class="col-md-10">
<div class="row">


		<!-- Start .content-inner -->
		<div class="content-inner">
			<form action="" id="page_form" method="get" class="form-horizontal">

			<!--
				<div class="form-group">
					<label class="control-label col-sm-2" for="email">검색타입</label>
					<div class="col-sm-8">
						<input type="hidden" name="page" id="page" value="<?php echo(isset($input['page']) && $input['page']>=1)? $input['page'] : 1 ?>" />
						<select name="sfl" id="sfl" class="form-control">
							<option value="productName" <?php if(isset($input[ 'sfl']) && $input[ 'sfl']=="productName" ) echo "selected";?> >상품이름</option>							
						</select>
					</div>
				</div>
			-->

				
				<div class="form-group">
				<input type="hidden" name="sfl" value="productName" >
				<input type="hidden" name="page" id="page" value="<?php echo(isset($input['page']) && $input['page']>=1)? $input['page'] : 1 ?>" />
					<label class="control-label col-sm-2" for="email">검색문구 *상품이름</label>
					<div class="col-sm-8">

						<input type="text" name="stx" id="stx" class="form-control" value="<?php echo(isset($input['stx']) )? $input['stx'] : '' ?>" placeholder="상품명을 넣어주세요" />
					</div>
				</div>

				<!-- 
				<div class="form-group">
					<label class="control-label col-sm-2" for="sdate">등록일</label>
					<div class="col-sm-3">
						<input type="text" name="sdate" id="sdate" class="form-control" value="<?php echo(isset($input['sdate']) )? $input['sdate'] : '' ?>" placeholder="시작일"  />
					</div>
					<div class="col-sm-3">
						<input type="text" name="edate" id="edate" class="form-control" value="<?php echo(isset($input['edate']) )? $input['edate'] : '' ?>" placeholder="종료일"  />
					</div>
				</div>
				-->

				<div class="form-group">
					<label class="control-label col-sm-2" for="sdcategoryIdate">category</label>
					<div class="col-sm-8">
						<select name="categoryId" id="categoryId" class="form-control">
							<!-- option value="">전체</option -->
				
						</select>
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
							<th>선택</th>
							<th>상품이미지</th>							
							<th>가격</th>
							<th>카테고리</th>
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
									<button class="p_id" data-name="<?php echo $val['name']?>" data-id="<?php echo $val['id'];?>"  data-price=<?php echo $val['price'];?>>선택</button>
								</td>
								<td>
									<img src='<?php echo S3_IMG_PATH.$val["imageLFile"]?>' width="100">
									<br />
									<?php echo $val['name']?>
								</td>
								
								<td>
									<?php echo number_format($val['price'])?>
								</td>
								<td>
									<?php echo$val['cate_name']?>
								</td>
						
							</tr>
							<?php endforeach;  ?>
					</table>
					
			</div>
			<center><button class="btn btn-info pop_alt_close">적용하기</button> &nbsp;&nbsp;&nbsp;<button class="btn btn-danger pop_close">닫기</button></center>
			
			<!-- Start .row -->
			<div class="page-nation">
				<ul class="pagination">
					<?php echo$page_nation?>
				</ul>
			</div>

			

		</div>
	</div>
	<!-- End .content-wrapper -->
	<div class="clearfix"></div>
</div>
<!-- End #content -->
</div></div>


