

<div class="col-md-12">
	<div class="row">
		<div class="container">
			<div class="content">
			
				<!-- main content -->
				<div class="header-wrap well">
					<header class="list-page-header">
						<h1 class="member-id text-center"> 협력요청  </h1>
						<p class="pull-left"><a class="btn btn-info" href="<?php echo $this->urilink;?>partner_offer_list/"><i class="icon-list-alt icon-white"></i>협력요청리스트</a></p>
						<div>
							
						</div>
					</header>
				</div>
				<!-- .header-wrap -->
				
				<input type="hidden" name="id" value="<?php echo $info['id'];?>" >

				<section class="sec_detail">
					
					<h3>업체정보</h3>
					<table class="table table-headered table-condensed ">
						<thead>
							<tr>
								<th>업종</th>
								<th>종류</th>								
								<th>회사명</th>
								<th>회사URL</th>
								<th>파일</th>
								<th>담당자명</th>
								<th>이메일</th>
								<th>회사번호</th>
								<th>휴대번호</th>
								
								
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo $info['type'];?></td>
								<td><?php echo $info['department'];?></td>
								<td><?php echo $info['company'];?></td>
								<td><?php echo $info['homepage'];?></td>								

								<td><?php echo ($info['fileName'])?"<a href='/'>".$info['fileName']."</a>":"없음";?></td>
								<td><?php echo $info['name'];?></td>
								<td><?php echo $info['email'];?></td>
								<td><?php echo $info['tel'];?></td>
								<td><?php echo $info['mobile'];?></td>
								
								
							</tr>
						</tbody>
					</table>
				</section>

				<section class="sec_detail">
					<h3>제휴종류</h3>
					<textarea name="content" id="content" style="width: 100%; height: 400px;"><?php  echo $info['content']?></textarea>
				</section>

				<section class="sec_detail">
					<h3>기타코멘트</h3>					
					<textarea name="etc" id="etc" style="width: 100%; height: 400px;"><?php  echo $info['etc']?></textarea>
				</section>

				

				
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>

<script>CKEDITOR.replace( 'content' );</script>
<script>CKEDITOR.replace( 'Rcontent' );</script>