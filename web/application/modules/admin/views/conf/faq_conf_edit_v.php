<script>
	$(document).ready(function() {

		$(".modify").click(function(){
			var base_action = "/admin/conf/faq_conf_crud/";
			var action = base_action+$("#mode").val();
			$("#page_form").attr("action", action);
			$("#page_form").submit();
		});




	});

</script>
<!-- Start #right-sidebar -->
<!-- Start #content -->
<div id="content">


	<!-- Start .content-wrapper -->
	<div class="content-wrapper">
		<div class="container">
			<!-- Start .content-inner -->
			<div class="content-inner">
				<input type="hidden" id="mode" value="<?=$mode?>" />
				<form action="" id="page_form" method="post" class="form-horizontal">
					<input type="hidden" id="id" name="id" value="<?=$id?>" />
					<div class="form-group">
						<div class="col-sm-8">
							<span>제목</span><input type="text" name="title" class="form-control" value="<?=$title?>" placeholder=" 제목을 넣어주세요" />
							<span>순서</span><input type="text" name="seq" class="form-control" value="<?=$seq?>" placeholder="노출 순서(숫자를 넣어주세요)" />
							<textarea name="content" id="exText" class="form-control" style="width: 100%; height: 400px;"><?=$content?></textarea>
							<script>CKEDITOR.replace( 'exText' );</script>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8">
							<a href="javascript:;" class="btn btn-info modify" >submit</a>
							<a href="/admin/conf/faq_conf_list" class="btn btn-danger cancle" >cancle</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- End .content-wrapper -->
	<div class="clearfix"></div>
</div>
<!-- End #content -->
