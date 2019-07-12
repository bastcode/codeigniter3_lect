<script>
	$(document).ready(function() {


	});
</script>
<div class="col-md-12">
	<div class="row">
		<div class="container">
			<div class="content">
			
				<!-- main content -->
				<div class="header-wrap well">
					<header class="list-page-header">
						<h1 class="member-id text-center"> 영상제작배우기  </h1>
						<p class="pull-left"><a class="btn btn-info" href="<?php echo $this->urilink;?>making_list/"><i class="icon-list-alt icon-white"></i>제작 게시판 리스트</a></p>
						<div>
							<p class="pull-right"><a class="btn btn-primary saveBtn" href="#"><i class="icon-ok icon-white"></i>저장</a></p>
						</div>
					</header>
				</div>
				<!-- .header-wrap -->
				<form class="form_post" accept-charset="utf-8" enctype="multipart/form-data" action="/admin/conf/making_proc/update" method="post" >
				<input type="hidden" name="id" value="<?php echo $info['id'];?>" >

				<section class="sec_detail">
					<h5>제목</h5>					
					<input type="text" name="title" value="<?php echo $info['title'];?>" >
					<h5>분류</h5>
					<input type="text" name="type" value="<?php echo $info['type'];?>" >
				</section>

				<section class="sec_detail">
					<h3>내용 상세 PC 규격 1100px</h3>
					<textarea name="content" id="content" style="width: 1100px; height: 400px;"><?php  echo $info['content']?></textarea>
				</section>


				<section class="sec_detail">
					<h3>내용 상세 Mobile 규격 360px [영상은 300px 이하로 들어가야함]</h3>
					<textarea name="contentM" id="contentM" style="width: 360px; height: 400px;"><?php  echo $info['contentM']?></textarea>
				</section>



				</form>

				
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>

<script>



CKEDITOR.replace( 'content' , {            
filebrowserUploadUrl : '/upload/ckedit',
width : '1100px',
//language          :'ja'
});
CKEDITOR.replace( 'contentM' , {            
filebrowserUploadUrl : '/upload/ckedit',
width : '360px',
//language          :'ja'
});

</script>
