
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script>
	$(document).ready(function() {
		onCate();
		PromiseCall();
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
		
		$(".saveBtn").click(function(){
			//if(form_auto_complet()) $(".form_post").submit();
			$(".form_post").submit();
		});
	});
	
	function form_auto_complet(){
		$("#imageText").val($("#imageText1").val()+"/"+$("#imageText2").val()); //img
		$("#movieText").val($("#movieText1").val()+"/"+$("#movieText2").val()); //movie
		$("#runtime").val($("#runtime1").val()+":"+$("#runtime2").val()); //runtime
		return true;
	}

	function onCate(){
		$.ajax({
		type: "POST",
		data: {},
		cache: false,
		async: true,
		url: "/api/catelist",
		dataType: "json",
		success: function(data){
			var html = "";
			//alert(data);
			$.each( data.catelist, function( key, value ) {
			  	//alert( key + ": " + value );
				$("#categoryId").append("<option value="+value['id']+">"+value['title']+"</option>");	
				//$("#exText").val("text");
			});
		}
		});
	}

	//자동 완성
	function PromiseCall(){

		//무비메이커란?
		var promise25 = new Promise(function (resolve, reject) {onDefine("mk-1");});
		
		//만들기1
		var key = "add-1";
		var promise1 = new Promise(function (resolve, reject) {
			onDefine(key);
		});
		key = "add-2";
		var promise2 = new Promise(function (resolve, reject) {
			onDefine(key);
		});
		key = "add-3";
		var promise3 = new Promise(function (resolve, reject) {
			onDefine(key);
		});
		key = "add-4";
		var promise4 = new Promise(function (resolve, reject) {
			onDefine(key);
		});
		key = "add-5";
		var promise5 = new Promise(function (resolve, reject) {
			onDefine(key);
		});

		//만들기2
		var promise6 = new Promise(function (resolve, reject) {onDefine("add2-1");});
		var promise7 = new Promise(function (resolve, reject) {onDefine("add2-2");});
		var promise8 = new Promise(function (resolve, reject) {onDefine("add2-3");});
		var promise9 = new Promise(function (resolve, reject) {onDefine("add2-4");});
		var promise10 = new Promise(function (resolve, reject) {onDefine("add2-5");});
		var promise11 = new Promise(function (resolve, reject) {onDefine("add2-6");});
		var promise12 = new Promise(function (resolve, reject) {onDefine("add2-7");});
		

		//완성된상품
		var promise13 = new Promise(function (resolve, reject) {onDefine("cmp-1");});
		var promise14 = new Promise(function (resolve, reject) {onDefine("cmp-2");});
		var promise15 = new Promise(function (resolve, reject) {onDefine("cmp-3");});
		//var promise16 = new Promise(function (resolve, reject) {onDefine("cmp-4");});
		
		//주의사항
		var promise17 = new Promise(function (resolve, reject) {onDefine("alt-1");});
		var promise18 = new Promise(function (resolve, reject) {onDefine("alt-2");});
		var promise19 = new Promise(function (resolve, reject) {onDefine("alt-3");});
		var promise20 = new Promise(function (resolve, reject) {onDefine("alt-4");});
		var promise21 = new Promise(function (resolve, reject) {onDefine("alt-5");});
		var promise22 = new Promise(function (resolve, reject) {onDefine("alt-6");});
		var promise23 = new Promise(function (resolve, reject) {onDefine("alt-7");});
		var promise24 = new Promise(function (resolve, reject) {onDefine("alt-8");});

		
		
		
	}

	function onDefine(key){
		console.log(key);
		var name = "";
		$.ajax({
			type: "POST",
			data: {key:key},			
			async: true,
			url: "/api/define_product_info",
			dataType: "json",
			success: function(data){
				//console.log(data.value);				
				$("input[type=text]"+"."+key).val(data.value);
				$("textarea"+"."+key).val(data.text);
			}
		});
	}
	
	
	$(function() {
    	$('.t1').change(function() {
			//
			if( $(this).prop('checked')){
				$(".row9").show();
			}else{
				$(".row9").hide();
			}
		});

		$('.e1').change(function() {
			//
			if( $(this).prop('checked')){
				$(".edit1").show();
			}else{
				$(".edit1").hide();
			}
		});
		$('.e2').change(function() {
			//
			if( $(this).prop('checked')){
				$(".edit2").show();
			}else{
				$(".edit2").hide();
			}
		});
		$('.e3').change(function() {
			//
			if( $(this).prop('checked')){
				$(".edit3").show();
			}else{
				$(".edit3").hide();
			}
		});
		$('.e4').change(function() {
			//
			if( $(this).prop('checked')){
				$(".edit4").show();
			}else{
				$(".edit4").hide();
			}
		});
		$('.e5').change(function() {
			//
			if( $(this).prop('checked')){
				$(".edit5").show();
			}else{
				$(".edit5").hide();
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
							<h1 class="member-id text-center">상품 추가</h1>
							
							<p class="pull-left"><a class="btn btn-info" href="<?php echo $this->urilink;?>product_list/"><i class="icon-list-alt icon-white"></i>상품리스트</a></p>
							<div>
								<p class="pull-right"><a class="btn btn-primary saveBtn" href="#"><i class="icon-ok icon-white"></i>저장</a></p>
							</div>
						</header>
					</div>
					<!-- .header-wrap -->
					
					<form method="post" accept-charset="utf-8" enctype="multipart/form-data" action="/admin/product/product_crud/add" class="form_post">
						<input type="hidden" name="resolutionId" value="1" />
					<div class="register-item">
						<section class="ri-cat">					
							<table class="table table-bordered table-condensed">
								<tbody>
									<tr>
										<th>카테고리</th>
										<td class="form-inline">
											
											<select id="categoryId" name="categoryId" class="input-large">										
											</select>								
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
											<input id="productName" name="productName" class="span5" type="text" value="" />
										</td>
										<th>product add date</th>
										<td class="form-inline"><span class="span2 uneditable-input" id="createDatetime"></span></td>
									</tr>
									
									<tr>
										
										<th>음악</th>
										<td>
											<div class="form-inline vertical-control">
												<label for="">원본음악 </label>
												<span> : </span>
												<input id="originalMusic" name="originalMusic" class="span4" type="text" value="" />
											</div>
											<div class="form-inline vertical-control">
												<label for="">추천음악 </label>
												<span> : </span>
												<input id="recommendMusic" name="recommendMusic" class="span4" type="text" value="" />
											</div>
										</td>
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
											<input id="price" name="price" class="span3 text-right" type="text" value="" />
										</td>								
										<td class="evt-price-td form-inline">
											<input id="eventPrice" name="eventPrice" class="span3 text-right" type="text" value="0" />
										</td>								
										<td class="evt-price-td form-inline">
											<input id="usd" name="usd" class="span3 text-right" type="text" value="" />
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
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="form-inline">									
											<select name="isDisplay">
												<option value="1" >공개</option>
												<option value="0" selected>비공개</option>
											</select>
										</td>								
										<td class="evt-price-td form-inline">
											<input id="sort" name="sort" class="span3 text-right" type="text" value="0" />
										</td>								
									</tr>
								</tbody>
							</table>
						</section>
						<!-- .ri-price-info -->

						<section class="ri-reg-visual">
							<h3>영상/이미지 등록</h3>
							<table class="table table-bordered table-condensed">
								<tbody>
									<tr>
										<th>영상 등록(VimeoId)</th>
										<td class="form-inline">
											<input id="movieVimeoId" name="movieVimeoId" type="text" value="" />
										</td>
										
									</tr>
									<tr>
										<th>프리셋</th>
										<td colspan="3">
											<input id="preset1" name="preset" class="span12" type="text" value="" />
										</td>
									</tr>
									<tr>
										<th>상품코드[pCode] </th>
										<td colspan="3">
											<input id="pCode" name="pCode" class="span12" type="text" value="" />
											<span class="red">*담당자 외 건들지 말것.</span>
										</td>
									</tr>
									<tr>
										<th>이미지 등록</th>
										<td colspan="3" class="reg-img-td">
											<table class="reg-img-table table">
												<thead>
													<tr>
														<th>사이즈</th>
														<th>상품 대표 (L)</th>												
														<th>상품 슬라이드 썸네일 (N) multi select</th>
														
													</tr>
												</thead>
												<tbody id="contents">
													<tr>
														<th>대표이미지</th>
														<td>
															<input type="file" name="uploadMainImage1[]" >
														</td>												
														<td>
															<input type="file" name="uploadMainImage3[]" multiple>
														</td>
														
													</tr>
												</tbody>		
											</table>
											<!-- .reg-img-table -->
										</td>
									</tr>
								</tbody>
							</table>
						</section>
						<!-- .ri-reg-visual -->

						<section class="view-info row">
							<div class="col-sm-2 col-xs-12"><h3>리스트<br> 상품 소개</h3></div>
							<div class="col-sm-10">
								<textarea name="listinfo" id="listinfo" style="width: 100%; height: 400px;"></textarea>								
							</div>
						</section>

						<section class="view-info row">
							<div class="col-sm-2 col-xs-12"><h3>INFO</h3></div>
							<div class="col-sm-10">
								<textarea name="exText" id="exText"  style="width: 100%; height: 400px;">まるで一編の映画のようなお二人の思い出フィルム <p>全ての縁が「今日」につながっているように感じられるプロフィールビデオ</p></textarea>
								
							</div>
						</section>

						<label><h3>FEATURES</h3></label> <input type="checkbox" data-toggle="toggle" class="t1">
						<section class="view-info row content-box-large row9" style="display:none;">
							<div class="col-sm-2 col-xs-12"><h3></h3></div>
							<div class="col-sm-10">
								<ul class="view-features row">
									<li class="col-sm-4 col-xs-6">
										<i class="icon-view"></i>
										<h4>필요사진</h4>
										<strong><input id="imageText" name="imageText" type="text" value="40枚"/></strong>
									</li>
									<li class="col-sm-4 col-xs-6">
										<i class="icon-view"></i>
										<h4>완성형식</h4>
										<strong><input id="filetype" name="filetype" type="text" value="MP4"/></strong>
									</li>
									<li class="col-sm-4 col-xs-6">
										<i class="icon-view"></i>
										<h4>런닝타임</h4>
										<strong><input id="runtime" name="runtime" type="text" value="4分10秒" /></strong>
									</li>
									<li class="col-sm-4 col-xs-6">
										<i class="icon-view-4"></i>
										<h4>문장변경</h4>
										<strong><input id="textchange" name="textchange" type="text" value="可能" /></strong>
									</li>
									<li class="col-sm-4 col-xs-6">
										<i class="icon-view-5"></i>
										<h4>BGM변경</h4>
										<strong><input id="bgmchange" name="bgmchange" type="text" value="可能" /></strong>
									</li>
									<li class="col-sm-4 col-xs-6">
										<i class="icon-view-6"></i>
										<h4>완성 후 수정</h4>
										<strong><input id="edit" name="edit" type="text" value="1回 可能" /></strong>
									</li>
									<li class="col-sm-4 col-xs-6">
										<i class="icon-view-3"></i>
										<h4>미리보기</h4>
										<strong><input id="preview" name="preview" type="text" value="無限" /></strong>
									</li>
									<li class="col-sm-4 col-xs-6">
										<i class="icon-view-3"></i>
										<h4>화질</h4>
										<strong><input id="quality" name="quality" type="text" value="FHD(1920*1080)" /></strong>
									</li>
									<li class="col-sm-4 col-xs-6">
										<i class="icon-view-2"></i>
										<h4>DVD제작</h4>
										<strong><input id="dvd" name="dvd" type="text" value="サポートなし" /></strong>
									</li>
									
								</ul>
							</div>
						</section>


						<div><label><h3>모멘또 무비메이커</h3></label> <input type="checkbox" data-toggle="toggle" class="e1"></div>
						<div class="content-box-large edit1" style="display:none;">
							<div class="col-xs-12"><h3>모멘또 무비메이커</h3></div>
								<table class="table">
									<tbody>
										<tr>
											<th>*</th> 
											<td><input type="text" class="mk-title-1 mk-1" name="mk-title-1" value=""></td>
											<td>
											<textarea class="valuetext mk-1" name="mk-text-1" ></textarea>
											</td>
										</tr>
									</tbody>
								</table>
						</div>
						
						<div><label><h3>만들기1</h3></label> <input type="checkbox" data-toggle="toggle" class="e2"></div>
						<div class="content-box-large edit2" style="display:none;">						
						<div class="col-xs-12"><h3>만들기1</h3></div>
							<table class="table">
								<tbody>
									<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle add-1" name="add-title-1" value=""></td>
										<td>
											<textarea class=" add-1" name="add-text-1" ></textarea>
										</td>

										<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle add-2" name="add-title-2" value=""></td>
										<td>
											<textarea class=" add-2" name="add-text-2" ></textarea>
										</td>

									<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle add-3" name="add-title-3" value=""></td>
										<td>
											<textarea class="valuetext add-3" name="add-text-3" ></textarea>
										</td>
									</tr>

									<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle add-4" name="add-title-4" value=""></td>
										<td>
											<textarea class="valuetext add-4" name="add-text-4" ></textarea>
										</td>
									</tr>
									<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle add-5" name="add-title-5" value="BGM"></td>
										<td>
											<textarea class="valuetext add-5" name="add-text-5" ></textarea>
										</td>
									</tr>
								</tbody>
							</table>
						</div>

						<div><label><h3>만들기2</h3></label> <input type="checkbox" data-toggle="toggle" class="e3"></div>
						<div class="content-box-large edit3" style="display:none;">						
						<div class="col-xs-12"><h3>만들기2</h3></div>
							<table class="table">
								<tbody>
									<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle add2-1" name="add2-title-1" value="사용메뉴얼 영상 바로가기"></td>
										<td>
											<textarea class="valuetext add2-1" name="add2-text-1" ></textarea>
										</td>
									</tr>

									<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle add2-2" name="add2-title-2" value="무료 체험"></td>
										<td>
											<textarea class="valuetext add2-2" name="add2-text-2" ></textarea>
										</td>
									</tr>
									<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle add2-3" name="add2-title-3" value="무비 만들기"></td>
										<td>
											<textarea class="valuetext add2-3" name="add2-text-3" ></textarea>
										</td>
									</tr>
									<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle add2-4" name="add2-title-4" value="<미리보기>기능 활용"></td>
										<td>
											<textarea class="valuetext add2-4" name="add2-text-4" ></textarea>
										</td>
									</tr>
									<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle add2-5" name="add2-title-5" value="무비 완성 시간"></td>
										<td>
											<textarea class="valuetext add2-5" name="add2-text-5" ></textarea>
										</td>
									</tr>
									<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle add2-6" name="add2-title-6" value="무비메이커 사용기간"></td>
										<td>
											<textarea class="valuetext add2-6" name="add2-text-6" ></textarea>
										</td>
									</tr>
									<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle add2-7" name="add2-title-7" value="무비메이커 사용기간"></td>
										<td>
											<textarea class="valuetext add2-7" name="add2-text-7" ></textarea>
										</td>
									</tr>
									
								</tbody>
							</table>
						</div>

						<div><label><h3>완성된 상품</h3></label> <input type="checkbox" data-toggle="toggle" class="e4"></div>
						<div class="content-box-large edit4" style="display:none;">						
						<div class="col-xs-12"><h3>완성된 상품</h3></div>
							<table class="table">
								<tbody>
									<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle cmp-1" name="cmp-title-1" value="완성 상품 상태"></td>
										<td>
											<textarea class="valuetext cmp-1" name="cmp-text-1" ></textarea>
										</td>
									</tr>
									<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle cmp-2" name="cmp-title-2" value="BGM"></td>
										<td>
											<textarea class="valuetext cmp-2" name="cmp-text-2" ></textarea>
										</td>
									</tr>
									<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle cmp-3" name="cmp-title-3" value="다운로드 횟수 및 보관 기간"></td>
										<td>
											<textarea class="valuetext cmp-3" name="cmp-text-3" ></textarea>
										</td>
									</tr>
									
								</tbody>
							</table>
						</div>

						<div><label><h3>주의사항</h3></label> <input type="checkbox" data-toggle="toggle" class="e5"></div>
						<div class="content-box-large edit5" style="display:none;">						
						<div class="col-xs-12"><h3>주의사항</h3></div>
							<table class="table">
								<tbody>
									<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle alt-1" name="alt-title-1" value="비회원 구매"></td>
										<td>
											<textarea class="valuetext alt-1" name="alt-text-1" ></textarea>
										</td>
									</tr>
									<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle alt-2" name="alt-title-2" value="취소/환불 정책"></td>
										<td>
											<textarea class="valuetext alt-2" name="alt-text-2" ></textarea>
										</td>
									</tr>
									<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle alt-3" name="alt-title-3" value="BGM라이센스(변경예정)"></td>
										<td>
											<textarea class="valuetext alt-3" name="alt-text-3" ></textarea>
										</td>
									</tr>
									<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle alt-4" name="alt-title-4" value="무비메이커 사용기간"></td>
										<td>
											<textarea class="valuetext alt-4" name="alt-text-4" ></textarea>
										</td>
									</tr>
									<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle alt-5" name="alt-title-5" value="문제 해결이 안된다면"></td>
										<td>
											<textarea class="valuetext alt-5" name="alt-text-5" ></textarea>
										</td>
									</tr>
									<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle alt-6" name="alt-title-6" value="다운로드 횟수 및 보관 기간"></td>
										<td>
											<textarea class="valuetext alt-6" name="alt-text-6" ></textarea>
										</td>
									</tr>
									<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle alt-7" name="alt-title-7" value="완성 무비 보관"></td>
										<td>
											<textarea class="valuetext alt-7" name="alt-text-7" ></textarea>
										</td>
									</tr>
									<tr>
										<th>*</th> 
										<td><input type="text" class="valuetitle alt-8" name="alt-title-8" value="DVD 만들기"></td>
										<td>
											<textarea class="valuetext alt-8" name="alt-text-8" ></textarea>
										</td>
									</tr>
								</tbody>
							</table>
						</div>







						


						<div class="ri-footer text-center">
							<button type="button" class="btn btn-primary btn-large input-large saveBtn"><i class="icon-ok icon-white"></i> 등록하기</button>
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

<script>
$(window).load(function(){
	

	//info
	CKEDITOR.replace( 'exText' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});

	CKEDITOR.replace( 'listinfo' );


	//모멘토1
	CKEDITOR.replace( 'mk-text-1' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});

	//만들기1
	CKEDITOR.replace( 'add-text-1' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});
	//만들기1
	CKEDITOR.replace( 'add-text-2' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});
	//만들기1
	CKEDITOR.replace( 'add-text-3' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});
	//만들기1
	CKEDITOR.replace( 'add-text-4' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});
	//만들기1
	CKEDITOR.replace( 'add-text-5' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});




	//만들기2
	CKEDITOR.replace( 'add2-text-1' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});
	CKEDITOR.replace( 'add2-text-2' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});
	CKEDITOR.replace( 'add2-text-3' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});
	CKEDITOR.replace( 'add2-text-4' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});
	CKEDITOR.replace( 'add2-text-5' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});
	CKEDITOR.replace( 'add2-text-6' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});
	CKEDITOR.replace( 'add2-text-7' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});

	//완성
	CKEDITOR.replace( 'cmp-text-1' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});
	CKEDITOR.replace( 'cmp-text-2' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});
	CKEDITOR.replace( 'cmp-text-3' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});
	

	//주의사항
	CKEDITOR.replace( 'alt-text-1' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});
	CKEDITOR.replace( 'alt-text-2' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});
	CKEDITOR.replace( 'alt-text-3' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});
	CKEDITOR.replace( 'alt-text-4' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});
	CKEDITOR.replace( 'alt-text-5' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});
	CKEDITOR.replace( 'alt-text-6' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});
	CKEDITOR.replace( 'alt-text-7' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});
	CKEDITOR.replace( 'alt-text-8' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});
	

		
});
</script>