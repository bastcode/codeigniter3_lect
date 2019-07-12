<div class="col-md-12">
	<div class="row">
		<div class="container">
			<div class="content">
			
				<!-- main content -->
				<div class="header-wrap well">
					<header class="list-page-header">
						<h1 class="member-id text-center"> 리뷰 </h1>
						<p class="pull-left"><a class="btn btn-info" href="<?php echo $this->urilink;?>review_list/"><i class="icon-list-alt icon-white"></i>리뷰리스트</a></p>
						<div>
							<p class="pull-right"><a class="btn btn-primary saveBtn" href="#"><i class="icon-ok icon-white"></i>저장</a></p>
						</div>
					</header>
				</div>
				<!-- .header-wrap -->
				<form class="form_post" action="/admin/conf/review_proc/update" method="post" >
				<input type="hidden" name="id" value="<?php echo $review['id'];?>" >


				<section class="sec_detail content-box-large">					
					<h3>리뷰정보</h3>
					<table class="table table-headered table-condensed table-th ">						
						<tbody>						
					
							<tr><th>상품정보</th>	<td><?php echo $review['productName'];?></td></tr>
							<tr><th>제목</th>	<td><input type="text" name="title" value="<?php echo $review['title'];?>">* 현재 노출되고있진 않는 항목. 비워도 오류는 나지 않음.</td></tr>
							<tr><th>이름</th>	<td><?php echo $review['memberName'];?></td></tr>
							<tr><th>이메일</th>	<td><?php echo $review['memberEmail'];?></td></tr>
							<tr><th>별점</th>	<td><?php echo $review['score'];?></td></tr>
							<tr><th>리뷰</th>	<td><textarea name="content" id="content" style="width: 100%; height: 200px;" readonly><?php  echo $review['content']?></textarea></td></tr>
						</tbody>
					</table>
				</section>
				

			

				<section class="sec_detail content-box-large">
					<h3>답글 </h3>
					<textarea name="Rcontent" id="Rcontent" style="width: 100%; height: 400px;"><?php  echo $review['Rcontent']?></textarea>
					

				</section>

				</form>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>

<script>CKEDITOR.replace( 'Rcontent' );</script>