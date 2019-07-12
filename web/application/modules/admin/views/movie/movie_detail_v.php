<div class="col-md-12">
	<div class="row">
		<div class="container">
			<div class="content">
			
				<!-- main content -->
				<div class="header-wrap well">
					<header class="list-page-header">
						<h1 class="member-id text-center"> 제작번호 ( <?php echo $movie["id"];?>   ) </h1>
						<p class="pull-left"><a class="btn btn-info" href="<?php echo $this->urilink;?>maker_list/"><i class="icon-list-alt icon-white"></i>무비메이커 리스트</a></p>
						<div>
							<!-- <p class="pull-right"><a class="btn btn-primary member_save" href="#"><i class="icon-ok icon-white"></i>저장</a></p> -->
						</div>
					</header>
				</div>
				<!-- .header-wrap -->

				<section class="sec_detail">
				<?php
				$startDate = date_create(date('Y-m-d')); // 오늘 날짜입니다.
				$targetDate = date_create($movie['endDatetime']); // 타겟 날짜를 지정합니다.
				$interval = date_diff($startDate, $targetDate);	
				$endDay = $interval->days;

				$movie_start = null;
				$movie_restart = null;
				//$middle_down = null;
				$final_down = null;
				

				if($movie['status'] >= 10 &&  $movie['status'] < 20 ){
					//아직 실행전 단계									
					$movie_restart = "disabled";
					//$middle_down = "disabled";
					$final_down = "disabled";
				}
				if($movie['status'] >= 20 &&  $movie['status'] < 30 ){
					//진행중
					$final_down = "disabled";
				}

				if($movie['status'] >= 40 &&  $movie['status'] < 50 ){
					//완료
					//딱히 걸린게 없다...
				}

				?>
					<h3>주문 (<?php echo $movie["orderId"];?> )의 무비 제작 상세내역</h3>
					<table class="table table-headered table-condensed ">
						<thead>
							<tr>
								<th>제작번호</th>
								<th>카테고리</th>
								<th>제작상품</th>
								<th>주문자</th>
								<th>이메일</th>
								<th>제작잔여일수</th>
								<th>무비확인</th>								
								<th>제작 시작일시</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo $movie["id"];?></td>
								<td><?php echo $movie["cate_name"];?></td>
								<td><?php echo $movie["productName"];?></td>
								<td>
									<?php echo $movie['first_name']." ".$movie['last_name'];?><br>
									<?php echo $movie['yomi_first_name']." ".$movie['yomi_last_name'];?>
								</td>
								<td><?php echo $movie["email"];?></td>
								<td><?php echo $endDay;?></td>			
								<td><?php echo $movie["previewCount"];?></td>					
								<td><?php echo ($movie['completeDatetime'] == "0000-00-00 00:00:00" || !$movie['completeDatetime'])?"":$movie['completeDatetime'];?></td>
							</tr>
							<tr>
								<td colspan="8">
								<div class="btn-align">		
									<button class="btn btn-danger  movie_start" data-orderid="<?php echo $movie['orderId'];?>" data-makeid="<?php echo $movie['id'];?>">무비메이커 실행</button>									
									<button class="btn btn-danger  movie_restart" data-makeid="<?php echo $movie['id'];?>" <?php echo $movie_restart;?>>재 랜더링</button>
									<button class="btn btn-danger  movie_clear" data-makeid="<?php echo $movie['id'];?>" <?php echo $movie_restart;?>>재수정</button>
									<button class="btn btn-danger  movie_plus_ten" data-makeid="<?php echo $movie['id'];?>">제작일수 +10일</button>
									<button class="btn btn-danger  moviePlay" data-makeid="<?php echo $movie['id'];?>" <?php echo  $final_down;?>>영상재생</button>
									<button class="btn btn-danger  movie_final_down"  data-makeid="<?php echo $movie['id'];?>" <?php echo $final_down;?>>완성 파일 다운로드</button>

								</div>
									
								</td>
							</tr>
						</tbody>
					</table>
				</section>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>