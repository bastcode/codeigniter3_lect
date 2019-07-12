<div class="col-md-12">
	<div class="row">
		<div class="container">
			<div class="content">
			
				<!-- main content -->
				<div class="header-wrap well">
					<header class="list-page-header">
						<h1 class="member-id text-center"> 주문정보 (   ) </h1>
						<p class="pull-left"><a class="btn btn-info" href="<?php echo $this->urilink;?>order_list/"><i class="icon-list-alt icon-white"></i>주문리스트</a></p>
						<div>
							<p class="pull-right"><a class="btn btn-primary saveBtn" href="#"><i class="icon-ok icon-white"></i>저장</a></p>
						</div>
					</header>
				</div>
				<!-- .header-wrap -->
				<form method="post" accept-charset="utf-8" enctype="multipart/form-data" action="/admin/conf/upload_proc/add" class="form_post">
				<section class="sec_detail">
					<h3>이미지</h3>
					<table class="table table-bordered table-condensed">
					<tbody>						
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
				</form>

				<button class="btn glyphicon glyphicon-minus minus_file"></button>


				<div class="bord-top pad-ver">
					            <!-- The fileinput-button span is used to style the file input field as button -->
					            <span class="btn btn-success fileinput-button dz-clickable">
					                <i class="fa fa-plus"></i>
					                <span>Add files...</span>
					            </span>
					
					            <div class="btn-group pull-right">
					                <button id="dz-upload-btn" class="btn btn-primary" type="submit" disabled="">
					                    <i class="fa fa-upload-cloud"></i> Upload
					                </button>
					                <button id="dz-remove-btn" class="btn btn-danger cancel" type="reset" disabled="">
					                    <i class="demo-psi-trash"></i>
					                </button>
					            </div>
					        </div>
							<div id="dz-previews">
					            
					        </div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>