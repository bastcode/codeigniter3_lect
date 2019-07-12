<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
	$(document).ready(function() {
		onCate();
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
			$("#page_form").submit();
		});
		
		$(".saveBtn").click(function(){			
			//form_auto_complet();			
			$(".form_post").submit();
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
	
	function form_auto_complet(){
		$("#runtime").val($("#runtime1").val()+":"+$("#runtime2").val()); //runtime
		$("#imageText").val($("#imageText1").val()+"/"+$("#imageText2").val()); //img
		$("#movieText").val($("#movieText1").val()+"/"+$("#movieText2").val()); //movie
	}
	function onCate(){
		$.ajax({
		type: "POST",
		data: {},
		cache: false,
		async: false,
		url: "/api/catelist",
		dataType: "json",
		success: function(data){
			var sel = "<?php  echo $product['categoryId']?>";			
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
							<h1 class="member-id text-center">상품수정</h1>
							<p class="pull-left"><a class="btn btn-info" href="<?php echo $this->urilink;?>product_list"><i class="icon-list-alt icon-white"></i> 상품 리스트</a></p>
							<div>
								<p class="pull-right"><a class="btn btn-primary saveBtn" href="#"><i class="icon-ok icon-white"></i>저장</a></p>
							</div>
						</header>
					</div>
					<!-- .header-wrap -->
					
					
					<form method="post" accept-charset="utf-8" enctype="multipart/form-data" action="/admin/product/product_crud/modify" class="form_post">
					<input id="productId" name="productId" class="span5" type="hidden" value="<?php  echo $product['id']?>" />
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

						<section class="sec_detail">
							<h3>상품 정보</h3>
							<table class="table table-bordered table-condensed">
								<tbody>
									<tr>
										<th>상품 이름</th>
										<td class="form-inline">
											<input id="productName" name="name" class="span5" type="text" value="<?php  echo $product['name']?>" />
										</td>
										<th>상품 등록일</th>
										<td class="form-inline"><span class="span2 uneditable-input" id="createDatetime"><?php  echo $product['createDatetime']?></span></td>
									</tr>
								
									<tr>
									
										<th>음악</th>
										<td>
											<div class="form-inline vertical-control">
												<label for="">원본음악 </label>
												<span> : </span>
												<input id="originalMusic" name="originalMusic" class="span4" type="text" value="<?php  echo $product['originalMusic']?>" />
											</div>
											<div class="form-inline vertical-control">
												<label for="">추천음악 </label>
												<span> : </span>
												<input id="recommendMusic" name="recommendMusic" class="span4" type="text" value="<?php  echo $product['recommendMusic']?>" />
											</div>
										</td>
									</tr>
									

								</tbody>
							</table>
						</section>
						<!-- .ri-basic-info -->

						<section class="ri-price-info">
							<h3>가격</h3>
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
											<input id="price" name="price" class="span3 text-right" type="text" value="<?php  echo $product['price']?>" />
										</td>								
										<td class="evt-price-td form-inline">
											<input id="eventPrice" name="eventPrice" class="span3 text-right" type="text" value="<?php  echo $product['eventPrice']?>" />
										</td>
										<td class="evt-price-td form-inline">
											<input id="usd" name="usd" class="span3 text-right" type="text" value="<?php  echo $product['usd']?>" />
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
										<th>상품순서</th>

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
											<input id="sort" name="sort" class="span3 text-right" type="text" value="<?php  echo $product['sort']?>" />
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
											<input id="movieVimeoId" name="movieVimeoId" type="text" value="<?php  echo $product['movieVimeoId']?>" />
										</td>
										
									</tr>
									<tr>
										<th>프리셋</th>
										<td colspan="3">
											<input id="preset" name="preset" class="span12" type="text" value="<?php  echo $product['preset']?>" />
										</td>
									</tr>
									<tr>
										<th>상품코드[pCode]</th>
										<td colspan="3">
											<input id="pCode" name="pCode" class="span12" type="text" value="<?php  echo $product['pCode']?>" />
											<span class="red">* 담당자 외 건들지 말것.</span>
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
															<input type="file" name="uploadMainImage1[]" ><br />
															
															<div class="files">
															<button class=" btn-danger glyphicon glyphicon-minus minus_file" data-id="<?php echo $product['id'];?>" data-type="p"></button>
															<a href="<?php  echo S3_IMG_PATH?><?php  echo $product['imageLFile']?>" target="_blank"><?php  echo $product['imageLFile']?></a>
															</div>
														</td>												
														<td>													
															<input type="file" name="uploadMainImage3[]" multiple><br>
															<?php  foreach($product_content as $key => $val) : ?>

															<div class="files">
															<button class=" btn-danger glyphicon glyphicon-minus minus_file" data-id="<?php echo $val['id'];?>" data-type="silde"></button>
															<a href="<?php  echo S3_IMG_PATH?><?php  echo $val['image']?>" target="_blank"><?php  echo $val['image']?></a>
															</div>
															
															<?php  endforeach;?>
																												
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
								<textarea name="listinfo" id="listinfo" style="width: 100%; height: 400px;"><?php echo $product['listinfo'];?></textarea>								
							</div>
						</section>

						<section class="view-info row">
							<div class="col-sm-2 col-xs-12"><h3>INFO</h3></div>
							<div class="col-sm-10">
								<textarea name="exText" id="exText" style="width: 100%; height: 400px;"><?php echo $product['exText'];?></textarea>
								
							</div>
						</section>

						<label><h3>FEATURES</h3></label> <input type="checkbox" data-toggle="toggle" class="t1">
						<section class="view-info row row9" style="display:none;">
							<div class="col-sm-2 col-xs-12"><h3>FEATURES</h3></div>
							<div class="col-sm-10">
								<ul class="view-features row">
									<li class="col-sm-4 col-xs-6">
										<i class="icon-view"></i>
										<h4>필요사진</h4>
										<strong><input id="imageText" name="imageText" type="text" value="<?php  echo $product['imageText']?>"/></strong>
									</li>
									<li class="col-sm-4 col-xs-6">
										<i class="icon-view"></i>
										<h4>완성형식</h4>
										<strong><input id="filetype" name="filetype" type="text" value="<?php  echo $product['filetype']?>"/></strong>
									</li>
									<li class="col-sm-4 col-xs-6">
										<i class="icon-view"></i>
										<h4>런닝타임</h4>
										<strong><input id="runtime" name="runtime" type="text" value="<?php  echo $product['runtime']?>" /></strong>
									</li>
									<li class="col-sm-4 col-xs-6">
										<i class="icon-view-4"></i>
										<h4>문장변경</h4>
										<strong><input id="textchange" name="textchange" type="text" value="<?php  echo $product['textchange']?>" /></strong>
									</li>
									<li class="col-sm-4 col-xs-6">
										<i class="icon-view-5"></i>
										<h4>BGM변경</h4>
										<strong><input id="bgmchange" name="bgmchange" type="text" value="<?php  echo $product['bgmchange']?>" /></strong>
									</li>
									<li class="col-sm-4 col-xs-6">
										<i class="icon-view-6"></i>
										<h4>완성 후 수정</h4>
										<strong><input id="edit" name="edit" type="text" value="<?php  echo $product['edit']?>" /></strong>
									</li>
									<li class="col-sm-4 col-xs-6">
										<i class="icon-view-3"></i>
										<h4>미리보기</h4>
										<strong><input id="preview" name="preview" type="text" value="<?php  echo $product['preview']?>" /></strong>
									</li>
									<li class="col-sm-4 col-xs-6">
										<i class="icon-view-3"></i>
										<h4>화질</h4>
										<strong><input id="quality" name="quality" type="text" value="<?php  echo $product['quality']?>" /></strong>
									</li>
									<li class="col-sm-4 col-xs-6">
										<i class="icon-view-2"></i>
										<h4>DVD제작</h4>
										<strong><input id="dvd" name="dvd" type="text" value="<?php  echo $product['dvd']?>" /></strong>
									</li>
									
								</ul>
							</div>
						</section>


						<div><label><h3>모멘또 무비메이커</h3></label> <input type="checkbox" data-toggle="toggle" class="e1"></div>
						<div class="content-box-large edit1" style="display:none;">						
							<div class="col-xs-12"><h3>모멘또 무비메이커</h3></div>
								<table class="table">
									<tbody>
										
										<?php $i=0; foreach($mata_mk as $key => $val ) : 	 $i++; ?>
										<tr>
											<th>*<input type="hidden" class='key' value="mk-<?php echo $i;?>"></th> 
											<td><input type="text" class="valuetitle" name="mk-title-<?php echo $i;?>" value="<?php echo $val["valueTitle"];?>"></td>
											<td>
											<textarea class="valuetext" name="mk-text-<?php echo $i;?>" ><?php echo $val["valueText"];?></textarea>
											</td>
										</tr>
										<?php endforeach;?>

									</tbody>
								</table>
						</div>
						

						<div><label><h3>만들기1</h3></label> <input type="checkbox" data-toggle="toggle" class="e2"></div>
						<div class="content-box-large edit2" style="display:none;">						
						<div class="col-xs-12"><h3>만들기1</h3></div>
							<table class="table">
								<tbody>
								<?php $i=0; foreach($mata_add as $key => $val ) : 	 $i++; ?>
										<tr>
											<th>*<input type="hidden" class='key' value="add-<?php echo $i;?>"></th> 
											<td><input type="text" class="valuetitle" name="add-title-<?php echo $i;?>" value="<?php echo $val["valueTitle"];?>"></td>
											<td>
											<textarea class="valuetext" name="add-text-<?php echo $i;?>" ><?php echo $val["valueText"];?></textarea>
											</td>
										</tr>
								<?php endforeach;?>
								</tbody>
							</table>
						</div>


						<div><label><h3>만들기2</h3></label> <input type="checkbox" data-toggle="toggle" class="e3"></div>
						<div class="content-box-large edit3" style="display:none;">						
						<div class="col-xs-12"><h3>만들기2</h3></div>
							<table class="table">
								<tbody>
								<?php  $i=0; foreach($mata_add2 as $key => $val ) : 	 $i++; ?>
										<tr>
											<th>*<input type="hidden" class='key' value="add2-<?php echo $i;?>"></th> 
											<td><input type="text" class="valuetitle" name="add2-title-<?php echo $i;?>" value="<?php echo $val["valueTitle"];?>"></td>
											<td>
											<textarea class="valuetext" name="add2-text-<?php echo $i;?>" ><?php echo $val["valueText"];?></textarea>
											</td>
										</tr>
								<?php endforeach;?>
								</tbody>
							</table>
						</div>

						<div><label><h3>완성된 상품</h3></label> <input type="checkbox" data-toggle="toggle" class="e4"></div>
						<div class="content-box-large edit4" style="display:none;">						
						<div class="col-xs-12"><h3>완성된 상품</h3></div>
							<table class="table">
								<tbody>
								<?php $i=0; foreach($mata_cmp as $key => $val ) : 	 $i++; ?>
										<tr>
											<th>*<input type="hidden" class='key' value="cmp-<?php echo $i;?>"></th> 
											<td><input type="text" class="valuetitle" name="cmp-title-<?php echo $i;?>" value="<?php echo $val["valueTitle"];?>"></td>
											<td>
											<textarea class="valuetext" name="cmp-text-<?php echo $i;?>" ><?php echo $val["valueText"];?></textarea>
											</td>
										</tr>
								<?php endforeach;?>
								</tbody>
							</table>
						</div>


						<div><label><h3>주의사항</h3></label> <input type="checkbox" data-toggle="toggle" class="e5"></div>
						<div class="content-box-large edit5" style="display:none;">						
						<div class="col-xs-12"><h3>주의사항</h3></div>
							<table class="table">
								<tbody>
								<?php $i=0; foreach($mata_alt as $key => $val ) :  $i++; ?>
										<tr>
											<th>*<input type="hidden" class='key' value="alt-<?php echo $i;?>"></th> 
											<td><input type="text" class="valuetitle" name="alt-title-<?php echo $i;?>" value="<?php echo $val["valueTitle"];?>"></td>
											<td>
											<textarea class="valuetext" name="alt-text-<?php echo $i;?>" ><?php echo $val["valueText"];?></textarea>
											</td>
										</tr>
								<?php endforeach;?>
								</tbody>
							</table>
						</div>


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
		</div>
	</div>
</div>



<script>
$(window).load(function(){
	//onDefine();
	CKEDITOR.replace( 'listinfo' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});

	//info
	CKEDITOR.replace( 'exText' , {			
		filebrowserUploadUrl : '/upload/ckedit',
		//language 			:'ja'
	});

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