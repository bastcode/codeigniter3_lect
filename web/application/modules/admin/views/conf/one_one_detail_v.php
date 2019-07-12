<div class="col-md-12">
	<div class="row">
		<div class="container">
			<div class="content">
			
				<!-- main content -->
				<div class="header-wrap well">
					<header class="list-page-header">
						<h1 class="member-id text-center"> Q&A  </h1>
						<p class="pull-left"><a class="btn btn-info" href="<?php echo $this->urilink;?>one_one_list/"><i class="icon-list-alt icon-white"></i>질문리스트</a></p>
						<div>
							<p class="pull-right"><a class="btn btn-primary saveBtn" href="#"><i class="icon-ok icon-white"></i>저장</a></p>
						</div>
					</header>
				</div>
				<!-- .header-wrap -->
				<form class="form_post" action="/admin/conf/one_one_proc/update" method="post" >
				<input type="hidden" name="id" value="<?php echo $one['id'];?>" >

				<section class="sec_detail content-box-large">					
					<h3>질문정보</h3>
					<table class="table table-headered table-condensed table-th ">						
						<tbody>						
							<tr><th>질문타입</th>	<td><?php echo $one['type'];?></td></tr>
							<tr><th>상품정보</th>	<td><?php echo $one['productName'];?></td></tr>
							<tr><th>제목</th>	<td><input type="text" name="title" value="<?php echo $one['title'];?>"></td></tr>
							<tr><th>이메일</th>	<td><?php echo $one['memberEmail'];?></td></tr>								
							<tr><th>첨부파일</th>	<td><?php echo ($one['fileName'])?"<a href='/uploads/one_one/temp/".$one['fileName']."'  target=_blink>".$one['fileName']."</a>":"없음";?></td>								
							<tr><th>질문내용</th>	<td><textarea name="content" id="content" style="width: 100%; height: 200px;" readonly><?php  echo $one['content']?></textarea></td></tr>
						</tbody>
					</table>
				</section>
				
				<section class="sec_detail content-box-large">
					<h3>답변</h3>
					<input type="hidden" name="R_id" value="<?php echo $one['R_id'];?>" />
					<textarea name="Rcontent" id="Rcontent" style="width: 100%; height: 400px;"><?php  echo $one['RContent']?></textarea>
				</section>

				</form>

				
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>

<script>//CKEDITOR.replace( 'content' );</script>
<script>CKEDITOR.replace( 'Rcontent' );</script>