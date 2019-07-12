

<div class="col-md-12">
<div class="row">
	<div class="container">
		<div class="content">

			<div class="header-wrap well">
				<header class="list-page-header">
					<h1 class="member-id text-center">회원 수정</h1>
					<p class="pull-left"><a class="btn btn-info" href="/admin/member/member_list"><i class="icon-list-alt icon-white"></i>회원 리스트</a></p>
					<div>
						<p class="pull-right"><a class="btn btn-primary member_save" href="#"><i class="icon-ok icon-white"></i>저장</a></p>
					</div>
				</header>
			</div>
			<!-- .header-wrap -->


			<form method="post" accept-charset="utf-8" enctype="multipart/form-data" action="/admin/member/member_crud/modify" class="form_post">
				<input type="hidden" name="memberId" value="<?php echo $member['id']?>" />
				<input type="hidden" class="form_url" name="form_url" value="/admin/member/member_crud/modify" />
				<div>
					<table class="table table-headered table-condensed">
						<tbody>
							<tr>
								<th>이름</th>
								<td>
								<div class="form-group">
									<div class="col-xs-2">
										<input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo$member['first_name']?>" />
									</div>
									<div class="col-xs-2">
										<input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo$member['last_name']?>" />
									</div>
									
								</div>									
								</td>
							</tr>
							<tr>
								<th>후리가나</th>
								<td>
								<div class="form-group">
									<div class="col-xs-2">
										<input type="text" name="yomi_first_name" id="yomi_first_name" class="form-control" value="<?php echo $member['yomi_first_name']?>" />
									</div>
									<div class="col-xs-2">
										<input type="text" name="yomi_last_name" id="yomi_last_name" class="form-control" value="<?php echo $member['yomi_last_name']?>" />
									</div>
									
								</div>
								</td>
							</tr>
							<tr>
								<th>아이디</th>
								<td>
									<input type="text" name="userId" id="userId" class="form-control" value="<?php echo$member['userId']?>" disabled /><span>*아이디는 변경 불가능 합니다.</span></td>
							</tr>
							<tr>
								<th>이메일</th>
								<td>
									<input type="text" name="email" id="email" class="form-control" value="<?php echo$member['email']?>" disabled /><span>*이메일은 변경 불가능 합니다.</span></td>
							</tr>
							<tr>
								<th>패스워드</th>
								<td>
									<input type="password" name="password" class="form-control" id="" value="" /> <span>*패스워드 변경시에만 넣어주세요.</span></td>
							</tr>
							<tr>
								<th>권한수정</th>
								<td>
									<select name="auth_lv" class="form-control">
										<option value="99" <?php echo($member[ 'auth_lv']==99)? "selected": ""?>>슈퍼관리자</option>
										<option value="10" <?php echo($member[ 'auth_lv']==10)? "selected": ""?>>슈퍼오퍼레이션</option>
										<option value="9" <?php echo($member[ 'auth_lv']==9)? "selected": ""?>>운영관리자</option>
										<option value="8" <?php echo($member[ 'auth_lv']==8)? "selected": ""?>>운영매니저</option>
										<option value="7" <?php echo($member[ 'auth_lv']==7)? "selected": ""?>>운영자</option>
										<option value="6" <?php echo($member[ 'auth_lv']==6)? "selected": ""?>>협력업체</option>
										<option value="5" <?php echo($member[ 'auth_lv']==5)? "selected": ""?>>매니저</option>
										<option value="4" <?php echo($member[ 'auth_lv']==4)? "selected": ""?>>일반회원</option>

										<option value="3" <?php echo($member[ 'auth_lv']==3)? "selected": ""?>>SNS회원</option>
										<option value="2" <?php echo($member[ 'auth_lv']==2)? "selected": ""?>>비회원</option>
										<option value="1" <?php echo($member[ 'auth_lv']==1)? "selected": ""?>>탈퇴회원</option>
										<option value="0" <?php echo($member[ 'auth_lv']==0)? "selected": ""?>>미가입</option>
										
									</select>
									<br />
									<span>* 관리자 페이지는 최소 운영자 이상 부터 접근 가능 합니다.</span>
								</td>
							</tr>
							
							<tr>
								<th>휴대번호</th>
								<td>
									<input type="text" name="mobile"  class="form-control" value="<?php echo$member['mobile']?>" />
								</td>
							</tr>
							<tr>
								<th>가입일</th>
								<td>
									<?php echo$member['createDatetime']?>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="form-group">
						<button type="submit" class="btn btn-default form-control">save</button>
					</div>
				</div>

				<!-- .register-item -->
			</form>
			

			<section class="hr">
				<table class="table table-headered table-condensed">
					<thead>
						<th>쿠폰이름</th><th>쿠폰시작일</th><th>쿠폰종료일</th><th>쿠폰사용일</th><th>쿠폰등록일</th></th>
					</thead>
					<tbody>
						<?php foreach($mycoupon['lists'] as $key => $val) : ?>
							<tr>
								<td>
									<?php echo$val['coupon_name']?>
								</td>
								
								<td>
									<?php echo($val['startDatetime'])? $val['startDatetime'] : "무제한"; ?>
								</td>
								<td>
									<?php echo($val['endDatetime'])? $val['endDatetime'] : "무제한"; ?>
								</td>
								<td>
									<?php echo($val['useDatetime'])? $val['endDatetime'] : "미사용"; ?>
								</td>
								<td>
									<?php echo$val['createDatetime']?>
								</td>
								

							</tr>
						<?php endforeach; ?>
						<?php if($mycoupon['total_count'] == 0) echo "<tr><td>보유 쿠폰이 없습니다.</td></tr>"; ?>
						
					</tbody>
				</table>
				<div class="page-nation">
					<ul class="pagination">
						<?php echo$mycoupon['page_nation']?>
					</ul>
				</div>
			</section>



		</div>
		<!-- /container -->

	</div>
	<!-- End .content-wrapper -->
	<div class="clearfix"></div>

<!-- End #content -->
</div></div>
</div></div>
