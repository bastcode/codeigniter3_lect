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
		<div class="content">


			<div class="header-wrap well">
				<header class="list-page-header">
					<h1 class="member-id text-center">협력업체 수정</h1>
					
					<p class="pull-left"><a class="btn btn-info" href="<?php echo $this->urilink;?>partner_list/"><i class="icon-list-alt icon-white"></i>협력업체 리스트</a></p>
					<div>
						<p class="pull-right"><a class="btn btn-primary saveBtn" href="#"><i class="icon-ok icon-white"></i>저장</a></p>
					</div>
				</header>
			</div>
			<!-- .header-wrap -->
			
			<form method="post" accept-charset="utf-8" enctype="multipart/form-data" action="/admin/partner/partner_proc/modify" class="form_post">
				<input type="hidden" name="cp_code" value="<?php echo $partner["cp_code"];?>" /> 
				<input type="hidden" name="cp_member_id" value="<?php echo $partner["cp_member_id"];?>" />
				
				<section class="ri-reg-visual">
					
					<table class="table table-bordered table-condensed">
						<tbody>
							<tr>
								<th>업체명 *</th>
								<td colspan="3">
									<input id="cp_name" name="cp_name" class="span12" type="text" value="<?php echo $partner['cp_name'];?>" required  />
								</td>
							</tr>
							<tr>
								<th>업체쿠폰코드 <span class="red">변경되면 기존 쿠폰을 사용할수 없음</span></th>
								<td colspan="3">
									<input id="cp_coupon_group_code" name="cp_coupon_group_code" class="span12" type="text" value="<?php echo $partner['cp_coupon_group_code'];?>" readonly disabled  />
								</td>
							</tr>
							<tr>
								<th>업체 이메일 *</th>
								<td colspan="3">
									<input id="member_email" name="member_email" class="span12" type="text" value="<?php echo $partner['email'];?>"  required />
								</td>
							</tr>
							<tr>
								<th>업체 패스워드 <span class="red">값을 넣으면 변경됩니다</span></th>
								<td colspan="3">
									<input id="member_password" name="member_password" class="span12" type="password" value=""   />
								</td>
							</tr>
							
							<tr>
								<th>담당자 성</th>
								<td>
									<input id="first_name" name="first_name" class="span12" type="text" value="<?php echo $partner['first_name'];?>"  />
								</td>								
								<th>
									담당자 이름
								</th>
								<td>
									<input id="last_name" name="last_name" class="span12" type="text" value="<?php echo $partner['last_name'];?>"   />
								</td>
							</tr>

							<tr>
								<th>담당자 성(요미)</th>
								<td>
									<input id="yomi_first_name" name="yomi_first_name" class="span12" type="text" value="<?php echo $partner['yomi_first_name'];?>"  />
								</td>								
								<th>
									담당자 이름(요미)
								</th>
								<td>
									<input id="yomi_last_name" name="yomi_last_name" class="span12" type="text" value="<?php echo $partner['yomi_last_name'];?>"   />
								</td>
							</tr>

							<tr>
								<th>업체권한레벨</th>
								<td colspan="3">
									<input id="member_auth" name="member_auth" class="span12" type="text" value="<?php echo $partner['auth_lv'];?>"  />
									기본은 5 or 6 
								</td>
							</tr>

							<tr>
								<th>업체 권한 ROLE</th>
								<td colspan="3">
									<input id="member_role" name="member_role" class="span12" type="text" value="<?php echo $partner['role'];?>"  />
								</td>
							</tr>
							
							<tr>
								<th>업체타입</th>
								<td colspan="3">
									<input id="cp_type" name="cp_type" class="span12" type="text" value="<?php echo $partner['cp_type'];?>"  />
									nomal, http, banner *디폴트 nomal
								</td>
							</tr>
						
							<tr>
								<th>업체 메모</th>
								<td>
									<input id="cp_memo" name="cp_memo" class="span12" type="text" value="<?php echo $partner['cp_memo'];?>"  />
								</td>
								<th>업체 API KEY</th>
								<td>
									<input id="cp_api_key" name="cp_api_key" class="span12" type="text" value=""  />
									
									<span class="red">* 값을 넣으면 변경됩니다</span>
									
									<span class="red">* 암호하지 않은 키로 넣으세요</span>
									
								</td>
							</tr>
							
						</tbody>
					</table>
				</section>
				<!-- .ri-reg-visual -->

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
</div>
