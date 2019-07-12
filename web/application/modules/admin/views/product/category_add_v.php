<script>


</script>

<div class="col-md-12">
	<div class="row">
		<div class="container">
			<div class="content">



					<div class="header-wrap well">
						<header class="list-page-header">
							<h1 class="member-id text-center">카테고리 등록</h1>
							
							<p class="pull-left"><a class="btn btn-info" href="<?php echo $this->urilink;?>product_list/"><i class="icon-list-alt icon-white"></i>상품리스트</a></p>
							<div>
								<p class="pull-right"><a class="btn btn-primary saveBtn" href="#"><i class="icon-ok icon-white"></i>저장하기</a></p>
							</div>
						</header>
					</div>
					<!-- .header-wrap -->
					
					<form method="post" accept-charset="utf-8" enctype="multipart/form-data" action="/admin/product/categody_crud/add" class="form_post">
						<input type="hidden" name="resolutionId" value="1" />
					<div class="register-item">
						<section class="ri-cat">					
							<table class="table table-bordered table-condensed">
								<tbody>
									<tr>
										<th>카테고리</th>
										<td class="form-inline">
											<input type="text" name="title" value="" required >
										</td>								
									</tr>
								</tbody>
							</table>
						</section>
						<!-- .ri-cat -->

						<div class="ri-footer text-center">
							<button type="button" class="btn btn-primary btn-large input-large saveBtn"><i class="icon-ok icon-white"></i> 등록하기</button>
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
