
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
		


		//저장
		$(".saveBtn").click(function(){
			if(!$("#exption_product").val()){
				alert("셋트상품을 구성해주십시오!");
				return false;
			}
			//$(".form_post").submit();
		});


		//상품검색 모달... 데이터를 넣는다
		$(document).on('click','.search_product',function(e){

			e.stopPropagation();
			e.preventDefault(); //이벤트 전파 금지

			var popUrl = "/admin/coupon/coupon_pop_search/popup"
			var popOption = "width=720, height=360, resizable=no, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
			window.open(popUrl,"상품검색",popOption);
		});


		$(document).on('click','.remove_p_btn',function(e){
			var item = $(this).attr("item"); //상품번호
			var price = $(this).data("price");
			var ex_price = $("#price").val();//토탈
			var discount = 15;
			var total_sum = $("#total_price");
			if(ex_price) ex_price = parseInt(ex_price);
			if(total_sum) total_sum = parseInt(total_sum);
			price = parseInt(price);

			

			var total = $("#div_exption_product").find("button").length-1;
			if(total <=2) discount = 15;
			if(total == 3) discount = 20;
			if(total == 4) discount = 25;
			if(total >= 5) discount = 30;


			ex_price = ex_price - price;
			$("#price").val(ex_price);
			ex_price = ex_price - (ex_price *  (discount / 100));
			$("#eventPrice").val(ex_price);
			$("#setDiscountPer").val(discount+"%");

			$(this).remove(); //내꺼지움
			var exption_product = $("#exption_product").val();//상품번호들
			if(exption_product != item){			
				if(exption_product.match(','+item ) ){				
					$("#exption_product").val(exption_product.replace(","+item,""));
				}else{
					$("#exption_product").val(exption_product.replace(item+",",""));
				}
			}else{				
				$("#price").val(0);	
				$("#exption_product").val("");
			}
		});
	
	
	
	
	
	});
	
	

</script>

<div class="col-md-12">
	<div class="row">
		<div class="container">
			<div class="content">



					<div class="header-wrap well">
						<header class="list-page-header">
							<h1 class="member-id text-center">셋트 상품 수정</h1>
							
							<p class="pull-left"><a class="btn btn-info" href="<?php echo $this->urilink;?>product_list/"><i class="icon-list-alt icon-white"></i>상품리스트</a></p>
							<div>
								<p class="pull-right"><a class="btn btn-primary saveBtn" href="#"><i class="icon-ok icon-white"></i>저장</a></p>
							</div>
						</header>
					</div>
					<!-- .header-wrap -->
					
					<form method="post" accept-charset="utf-8" enctype="multipart/form-data" action="/admin/product/product_set_crud/modify" class="form_post">
						<input type="hidden" name="productId" value="<?php echo $product['id'];?>" />
					<div class="register-item">
						<section class="ri-cat">					
							<table class="table table-bordered table-condensed">
								<tbody>
									<tr>
										<th>카테고리</th>
										<td class="form-inline">
											셋트상품 <span class="red"> *고정 </span>
											<input type="hidden" name="categoryId" value="6" />
										</td>								
									</tr>
								</tbody>
							</table>
						</section>
						<!-- .ri-cat -->


					

						<section class="ri-basic-info">
							<h3>상품 정보</h3>
							<table class="table table-bordered table-condensed">
								<tbody>
									<tr>
										<th>상품이름</th>
										<td class="form-inline">
											<input id="productName" name="productName" class="span5" type="text" value="<?php echo $product['name'];?>" required />
										</td>
										<th>상품 등록일</th>
										<td class="form-inline"><span class="span2 uneditable-input" id="createDatetime"><?php echo $product['createDatetime'];?></span></td>
									</tr>
								</tbody>
							</table>
						</section>
						<!-- .ri-basic-info -->

						<section class="ri-price-info">
							<h3>price info</h3>
							<table class="ri-pi-table table table-bordered table-condensed">
								<thead>
									<tr>
										<th>가격</th>								
										<th>이벤트가격</th>
										<th>달러가격</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="form-inline">
											<input id="price" name="price" class="span3 text-right" type="text" value="<?php echo $product['price'];?>" required />
										</td>								
										<td class="evt-price-td form-inline">
											<input id="eventPrice" name="eventPrice" class="span3 text-right" type="text" value="<?php echo $product['eventPrice'];?>" required />
										</td>								
										<td class="evt-price-td form-inline">
											<input id="usd" name="usd" class="span3 text-right" type="hidden" value="<?php echo $product['usd'];?>" />
											<input id="setDiscountPer" name="setDiscountPer" class="span3 text-right" type="text" value="<?php echo $product['setDiscountPer'];?>" />
										</td>
									</tr>
									
								</tbody>
							</table>
						</section>
						<!-- .ri-price-info -->
						
						<section class="ri-set-info">
							<h3>config</h3>
							<table class="ri-pi-table table table-bordered table-condensed">
								<thead>
									<tr>
										<th>공개/비공개</th>								
										<th>순서</th>
										<th>상품코드</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="form-inline">									
											<select name="isDisplay">
											<option value="1"  <?php if($product['isDisplay']) echo 'selected'; ?> >공개</option>
											<option value="0" <?php if(!$product['isDisplay']) echo 'selected'; ?>>비공개</option>
											</select>
										</td>								
										<td class="evt-price-td form-inline">
											<input id="sort" name="sort" class="span3 text-right" type="text" value="<?php echo $product['sort'];?>" />
										</td>
										<th>상품코드[pCode]</th>
										<td colspan="3">
											<input id="pCode" name="pCode" class="span12" type="text" value="<?php echo $product['pCode'];?>" />
											<span class="red">* 담당자 외 건들지 말것.</span>
										</td>
									</tr>					
									
								</tbody>
							</table>
						</section>
						<!-- .ri-price-info -->
						<section class="ri-reg-visual">
							<h3>이미지 등록</h3>
							<table class="table table-bordered table-condensed">
								<tbody>
									<tr>
										<th>대표이미지</th>
										<td>
											<input type="file" name="uploadMainImage1[]" ><br />
											<a href="<?php  echo S3_IMG_PATH?><?php  echo $product['imageLFile']?>" target="_blank"><?php  echo $product['imageLFile']?></a>
										</td>
										<th>가격이미지 PC</th>
										<td>
											<input type="file" name="uploadMainImage5[]" ><br />
											<a href="<?php  echo S3_IMG_PATH?><?php  echo $product['setImageP']?>" target="_blank"><?php  echo $product['setImageP']?></a>
										</td>
										<th>가격이미지 Mobile</th>
										<td>
											<input type="file" name="uploadMainImage6[]" ><br />
											<a href="<?php  echo S3_IMG_PATH?><?php  echo $product['setImageM']?>" target="_blank"><?php  echo $product['setImageM']?></a>
										</td>
									</tr>
								</tbody>
							</table>
						</seciton>



						<section class="ri-set-info">
						<h3>상품 선택 </h3>						
						<table class="ri-pi-table table table-bordered table-condensed">
							<thead>
								<tr>
									<th>상품 선택</th>								
									<th>셋트 구성 상품</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="form-inline">									
										<button class="btn btn-success search_product"  >상품검색</button>
									</td>								
									<td class="evt-price-td form-inline">
										<div id="div_exption_product">
										<?php 										
											foreach($product['setProduct'] as $key => $val){
												echo '<button class="btn btn-success remove_p_btn" item="'.$val["id"].'">'.$val["name"].'</button>';
											}
										?>
										</div>
										<input  name="setProductId" id="exption_product" class="span3 text-right" type="hidden" value="<?php echo $product['setProductId'];?>" readonly required />
									</td>								
								</tr>
							</tbody>
						</table>
					</section>
<!-- <td><a class="btn eventUrl" onClick="javascript:window.clipboardData.setData('Text', location.href)" href="javascript:;" style="background:#658dd2; color:#fff;">URL 복사하기</a></td>
										-->

						<div class="ri-footer text-center">
							<button type="button" class="btn btn-primary btn-large input-large saveBtn"><i class="icon-ok icon-white"></i> 저장</button>
						</div>

					</div>
					<!-- .register-item -->
					</form>
					<!-- <button class="btn text">테스트</button> -->

				</div>
				<!-- /container -->

			</div>
			<!-- End .content-wrapper -->
			<div class="clearfix"></div>


		</div>
		
	</div>
</div>
</div>
