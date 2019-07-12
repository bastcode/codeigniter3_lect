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
			autoSize: false, //오토리사이즈(body등 상위태그의 설정에 따른다)
			changeMonth: true, //월변경가능
			changeYear: true, //년변경가능
			yearRange: '1990:2020',
			yearSuffix: 'Year'
		};
		$.datepicker.setDefaults($.datepicker.regional['en']);
		$("#sdate").datepicker();
		$("#edate").datepicker();
		
		onCate();

		partner_list();
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
					
					$("#company_name").append("<option value="+value['cp_coupon_group_code']+" data-id='"+value['cp_code']+"'>"+value['cp_name']+"</option>");
				});
			}
		});
	}

	$(document).on('change','#company_name',function(e){
		var option = $(this).find("option:selected").text();		
		var value = $(this).find("option:selected").val();
		var cp_code = $(this).find("option:selected").data("id");
		$("#company_coupon_code").val(value);
		$("#company_id").val(cp_code);

	});

	//sac_all
	$(document).on('click','.sac_all',function(e){
		
		e.preventDefault(); //이벤트 전파 금지
	});

	//카테고리 선택하면 추가
	$(document).on('change','#categoryId',function(e){
		e.preventDefault(); //이벤트 전파 금지
		
		var option = $(this).find("option:selected").text();		
		var value = $(this).find("option:selected").val();
		var init = $("#span_apply_category").text();




		if(value == 0){
			$("#span_apply_category > button").remove();
			$("#span_apply_category").html("<button class='btn btn-success sac_all' item=''>전체</button>");
			$("#categoryId > option").prop("disabled",false);
			$("#apply_category").val("");
		}else{
			$(this).find("option:selected").attr("disabled",true);
			var apply_category = $("#apply_category").val();
			
			//console.log(apply_category.match(","+value) + ","+value);
			//console.log(apply_category.match(value+",") + value+ ",");

			if(apply_category.match(","+value) || apply_category.match(value+",")){
				return false;
			}

			
			$("#span_apply_category > .sac_all").remove();
			$("#span_apply_category").append("<button class='btn btn-success remove_btn' item='"+value+"'>"+option+"</button>");

			if(apply_category){
				apply_category = apply_category + "," + value;
			}else{
				apply_category = apply_category + value;
			}
			$("#apply_category").val(apply_category);

		}
	});

	//카테고리 버튼 누르면 제거
	$(document).on('click','.remove_btn',function(e){
		e.preventDefault(); //이벤트 전파 금지
		var item = $(this).attr("item");
		var option_index = $("#categoryId").val(item).prop('selectedIndex');
		$("#categoryId option:eq("+option_index+") ").val(item).prop("disabled",false);
		$(this).remove();
		var apply_category = $("#apply_category").val();

		if(apply_category != item){			
			if(apply_category.match(','+item ) ){				
				$("#apply_category").val(apply_category.replace(","+item,""));
			}else{
				$("#apply_category").val(apply_category.replace(item+",",""));
			}
		}else{
			$("#apply_category").val("");
			check_remove_cate();
		}
		//$("#apply_category").val(apply_category.replace(","+item,""));
		
	});

	


	//카테고리가 0개이면 전체로 초기화
	function check_remove_cate(){		
		
			$("#categoryId option:eq(0)").prop("selected",true);
			$("#span_apply_category > button").remove();
			$("#span_apply_category").html("<button class='btn btn-success sac_all' item='0'>전체</button>");
			$("#categoryId > option").prop("disabled",false);
			$("#apply_category").val();
		
		
	}


	//상품검색 모달... 데이터를 넣는다
	$(document).on('click','.search_product',function(e){
		e.preventDefault(); //이벤트 전파 금지
		var popUrl = "/admin/coupon/coupon_pop_search/popup"
     	var popOption = "width=500, height=360, resizable=no, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
          window.open(popUrl,"상품검색",popOption);
	});


	//상품제거
	$(document).on('click','.remove_p_btn',function(e){
		var item = $(this).attr("item"); //상품번호
		$(this).remove(); //내꺼지움
		var exption_product = $("#exption_product").val();//상품번호들
		if(exption_product != item){			
			if(exption_product.match(','+item ) ){				
				$("#exption_product").val(exption_product.replace(","+item,""));
			}else{
				$("#exption_product").val(exption_product.replace(item+",",""));
			}
		}else{				
			$("#exption_product").val("");
		}
	});

</script>

<div class="col-md-12">
<div class="row">
<div class="container">
		<div class="content-inner">
			<!-- main content -->

			<div class="header-wrap well">
				<header class="list-page-header">
					<h1 class="member-id text-center">쿠폰 수정   </h1>				
					<p class="pull-left"><a class="btn btn-info" href="<?php echo $this->urilink;?>coupon_list/"><i class="icon-list-alt icon-white"></i>쿠폰리스트</a></p>
					<div>
						<p class="pull-right"><a class="btn btn-primary saveBtn" href="#"><i class="icon-ok icon-white"></i>저장</a></p>
					</div>
				</header>
			</div>
			<!-- .header-wrap -->
			
			<form method="post" accept-charset="utf-8" enctype="multipart/form-data" action="/admin/coupon/coupon_proc/update" class="form_post">
				<input type="hidden" name="coupon_id" id="coupon_id" value="<?php echo $info['id'];?>" /> 
		
				<section class="ri-reg-visual">
					<h3>쿠폰 등록</h3>
					<table class="table table-bordered table-condensed">
						<tbody>	
											
							<tr>
								<th>사용횟수 / 전체갯수</th>
								<td colspan="3">
									<span><?php echo $total_use_count;?></span> / <span><?php echo $total_count;?></span>
									
								</td>
							</tr
							<tr>
								<th>쿠폰 발급 코드</th>
								<td colspan="3">
									<input id="company_coupon_code" name="company_coupon_code" class="span12" size="30" type="text" value="<?php echo $info['company_coupon_code'];?>" readonly required />
									<span class="red">* 변경불가능. </span>
								</td>
							</tr>
							<tr>
								<th>쿠폰 이름</th>
								<td colspan="3">
									<input id="coupon_name" name="coupon_name" class="span12" type="text" size="30" value="<?php echo $info['coupon_name'];?>"  required />
									<span>고객에게 보여지는 이름입니다.</span>
								</td>
							</tr>
							<tr>
								<th>쿠폰 설명</th>
								<td colspan="3">
									<input id="coupon_descript" name="coupon_descript" class="span12" type="text" size="30" value="<?php echo $info['coupon_descript'];?>"  />
									<span>관리자만 확인가능한 이름입니다.</span>
								</td>
							</tr>
							<tr>
								<th>쿠폰 할인율</th>
								<td colspan="3">
									<input id="coupon_discount" name="coupon_discount" class="span12" type="text" value="<?php echo $info['coupon_discount'];?>" required  />%
								</td>
							</tr>
							<tr>
								<th>추가 쿠폰 발급</th>								
								
								<td class="form-inline">
									<input type="number" name="conpon_count"  min="0" max="100" value="0"  >개  
									<span>※ 기존 쿠폰에 추가로 쿠폰이 늘어납니다. <br> 0개 일시 추가되지 않습니다.</span>
								</td>								
							</tr>
							<tr>
								<th>쿠폰 시작일</th>
								<td>
									<input id="sdate" name="coupon_sdate" size="20" class="span12" type="text" value="<?php echo $info['coupon_sdate'];?>"  required />
								</td>
								<th>쿠폰 종료일</th>
								<td>
									<input id="edate" name="coupon_edate" class="span12" type="text" value="<?php echo $info['coupon_edate'];?>" required  />
									자동으로 종료일에 23:59이 붙습니다.
								</td>
							</tr>
							
						</tbody>
					</table>
				</section>
				<!-- .ri-reg-visual -->

				<section class="ri-set-info">
					<h3>적용될 상품 선택 </h3>
					<h5>*아무런 설정 하지 않을 경우 모든 상품이 사용 가능입니다.</h5>
					<table class="ri-pi-table table table-bordered table-condensed">
						<thead>
							<tr>
								<th>상품 선택</th>								
								<th>적용할 상품</th>
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
											foreach($info['setProduct'] as $key => $val){
												echo '<button class="btn btn-success remove_p_btn" item="'.$val["id"].'">'.$val["name"].'</button>';
											}
										?>
									</div>
									<input  name="exption_product" id="exption_product" class="span3 text-right" type="hidden" value="<?php echo $info['exption_product'];?>" readonly  />
								</td>								
							</tr>
						</tbody>
					</table>
				</section>

				<section class="ri-set-info">
					<h3>쿠폰 적용 카테고리 </h3>
					<h5>*아무런 설정 하지 않을 경우 기본은 전체 카테고리 적용.. 즉 모든 상품 사용 가능입니다.</h5>
					<table class="ri-pi-table table table-bordered table-condensed">
						<thead>
							<tr>
								<th>카테고리 선택</th>								
								<th>적용 카테고리</th>								
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="form-inline">									
									<select  id="categoryId">
										<option value="" >전체</option>										
									</select>
								</td>								
								<td class="evt-price-td form-inline">
									<div id="span_apply_category">
									<?php 										
											foreach($info['setCategory'] as $key => $val){
												echo '<button class="btn btn-success remove_btn" item="'.$val["id"].'">'.$val["title"].'</button>';
											}

											if(count($info['setCategory']) < 1){ ?>
										

										<button class="btn btn-success sac_all" item="">전체</button>
											<?php } ?>
									</div>
									<input  name="apply_category" id="apply_category" class="span3 text-right" type="hidden" value="<?php echo $info['apply_category'];?>" readonly />
								</td>								
							</tr>
						</tbody>
					</table>
				</section>
				
				<div class="content-box-large">
					사용예 : 상품이 1개만 적용 되는 경우는 적용 상품을 1개 선택. 
					<br>카테고리 를 추가로 선택시 +@ 로 해당 카테고리 상품들이 추가가 됩니다.
					<br>추가 되어있는 카테고리를 선택할 경우 중복을 제거하고 나타납니다.
				</div>


				<!-- .ri-price-info -->
				<div class="ri-footer text-center">
					<button type="button" class="btn btn-primary btn-large input-large saveBtn"><i class="icon-ok icon-white"></i> 수정하기</button>
				</div>

			</div>
			<!-- .register-item -->
			</form>

		</div>
		<!-- /container -->

	</div>
	<!-- End .content-wrapper -->
	<div class="clearfix"></div>
</div>
<!-- End #content -->
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">상품검색</h5>
       
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
