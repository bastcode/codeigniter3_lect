<div class="col-md-12">
	<div class="row">
		<div class="container">
			<div class="content">
			
				<!-- main content -->
				
					<header class="list-page-header content-box-large">
						
					<section class="sec_detail">					
					<table class="table  ">
						<thead>
							<tr>
								<th>전체가입자</th>
								<th>오늘가입자</th>
								<th>전체주문수</th>
								<th>오늘주문수</th>								
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo $member_total_cnt;?></td>
								<td><?php echo $now_day_member_cnt;?></td>
								<td><?php echo $order_total_cnt;?></td>
								<td><?php echo $now_day_order_cnt;?></td>
							</tr>
						</tbody>
					</table>
				</section>
				</header>
				
				<!-- .header-wrap -->
				<div class="content-box-large">
					<div class="panel-heading">
						<div class="panel-title">Q&A 리스트</div>							
						<div class="panel-options">							
							<a href="/admin/conf/one_one_list" data-rel="reload"><i class="glyphicon glyphicon-cog">더보기</i></a>
						</div>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-headered table-condensed">
								<thead>
								<tr>
									<th>#</th>
									<th>질문타입</th>
									<th>질문제목</th>
									<th>이메일</th>
									<th>답변여부</th>
								</tr>
								</thead>
								<tbody>
								<?php 
									$i = 1;
									//var_dump($qna_list);
									foreach($qna_list as $key=>$val) : ?>
								<tr>
									<td><?php echo $i++;?></td>
									<td><a href="/admin/conf/one_one_detail/<?php echo $val["id"]; ?>"><?php echo $val["type"]; ?></a></td>
									<td><a href="/admin/conf/one_one_detail/<?php echo $val["id"]; ?>"><?php echo $val["title"]; ?></a></td>
									<td><?php echo $val["memberEmail"]; ?></td>
									<td><?php echo ($val['R_id'])?"답변완료":"답변대기";?></td>
								</tr>
								<?php endforeach; ?>

								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="content-box-large">
					<div class="panel-heading">
						<div class="panel-title">리뷰 리스트</div>							
						<div class="panel-options">							
							<a href="/admin/conf/review_list" data-rel="reload"><i class="glyphicon glyphicon-cog">더보기</i></a>
						</div>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-headered table-condensed">
								<thead>
								<tr>
									<th>#</th>
									<th>상품명</th>
									<th>리뷰내용</th>
									<th>이메일</th>
									
								</tr>
								</thead>
								<tbody>
								<?php 
									$i = 1;
									//var_dump($qna_list);
									foreach($review_list as $key=>$val) : ?>
								<tr>
									<td><?php echo $i++;?></td>
									<td><a href="/admin/conf/review_detail/<?php echo $val["id"]; ?>"><?php echo $val["name"]; ?></a></td>
									<td><a href="/admin/conf/review_detail/<?php echo $val["id"]; ?>"><?php echo $val["content"]; ?></a></td>
									<td><?php echo $val["memberEmail"]; ?></td>
								
								</tr>
								<?php endforeach; ?>

								</tbody>
							</table>
						</div>
					</div>
				</div>

			

				<div class="content-box-large">
					<div class="panel-heading">
						<div class="panel-title">협력요청 리스트</div>							
						<div class="panel-options">							
							<a href="/admin/conf/partner_offer_list" data-rel="reload"><i class="glyphicon glyphicon-cog">더보기</i></a>
						</div>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-headered table-condensed">
								<thead>
								<tr>
									<th>#</th>
									<th>요청내용</th>
									<th>회사명</th>
									<th>이메일</th>									
								</tr>
								</thead>
								<tbody>
								<?php 
									$i = 1;									
									foreach($partner_in_list as $key=>$val) : ?>
								<tr>
									<td><?php echo $i++;?></td>
									<td><a href="/admin/conf/partner_offer_detail/<?php echo $val["id"]; ?>"><?php echo $val["content"]; ?></a></td>
									<td><?php echo $val["company"]; ?></td>
									<td><?php echo $val["email"]; ?></td>									
								</tr>
								<?php endforeach; ?>

								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>