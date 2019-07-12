<script>




</script>
<div class="col-md-12">
	<div class="row">
		<div class="container">
			<div class="content">
			
				<!-- main content -->
				<div class="header-wrap well">
					<header class="list-page-header">
						<h1 class="member-id text-center"> 주문정보 ( <?php echo $order['id'];?>  ) </h1>
						<p class="pull-left"><a class="btn btn-info" href="<?php echo $this->urilink;?>order_list/"><i class="icon-list-alt icon-white"></i>주문리스트</a></p>
						<div>
							<p class="pull-right"><a class="btn btn-primary " href="#"><i class="icon-ok icon-white"></i>저장</a></p>
						</div>
					</header>
				</div>
				<!-- .header-wrap -->

				
				<section class="sec_detail">
					<h3>주문정보</h3>
					<table class="table table-headered table-condensed ">
						<thead>
							<tr>
								<th>주문번호</th>
								<th>주문일시</th>
								<th>주문자</th>
								<th>결제수단</th>
								<th>최종결제금액(판매가)</th>								
								<th>결제일시</th>
								<th>주문상태</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo $order['id'];?></td>
								<td><?php echo $order['createDatetime'];?></td>
								<td>
									<?php echo $order['first_name']." ".$order['last_name'];?><br>									
								</td>
								<td><?php echo $order['payment'];?></td>
								<td><?php echo number_format($order['price']);?></td>
								<td><?php echo $order['paymentDatetime'];?></td>
								<td><?php echo $this->admin_util->order_status($order['status']);?></td>
								
							</tr>
						</tbody>
					</table>
				</section>

				<section class="sec_detail">
					<h3>무비 제작 내역</h3>
					<table class="table table-headered table-condensed ">
						<thead>
							<tr>
								<th>제작번호</th>
								<th>제작상태</th>
								<th>주문상품</th>
								<th>제작 잔여 일수</th>
								<th>미리보기횟수</th>
								<th>제작완료 일</th>
								
							</tr>
						</thead>
						<tbody>
							<?php  foreach($movie as $key => $val) :
								$startDate = date_create(date('Y-m-d')); // 오늘 날짜입니다.
								$targetDate = date_create($val['endDatetime']); // 타겟 날짜를 지정합니다.
								$interval = date_diff($startDate, $targetDate);	
								$endDay = $interval->days;



								$movie_start = null;
								$movie_restart = null;
								//$middle_down = null;
								$final_down = null;
								
								

								if($val['status'] >= 10 &&  $val['status'] < 20 ){
									//아직 실행전 단계									
									$movie_restart = "disabled";
									//$middle_down = "disabled";
									$final_down = "disabled";
								}
								if($val['status'] >= 20 &&  $val['status'] < 30 ){
									//진행중
									$final_down = "disabled";
								}
								if($val['status'] >= 30 &&  $val['status'] < 40 ){
									//랜더 요청 및 랜더링중
									$final_down = "disabled";
								}

								if($val['status'] >= 40 &&  $val['status'] < 50 ){
									//완료
									//딱히 걸린게 없다...
								}
							?>
							<tr>
								<td><a href="/admin/movie/movie_detail/<?php echo $val['id'];?>"><?php echo $val['id'];?></a> </td>
								<td><?php echo $this->admin_util->movie_status($val['status']);?></td>
								<td><img src='<?php echo S3_IMG_PATH.$val["imageSFile"];?>' width="100px" ><br><?php echo $val['productName'];?> </td>
								<td><?php echo $endDay;?></td>
								<td><?php echo $val['previewCount'];?></td>
								<td><?php echo $val['completeDatetime'];?></td>
							</tr>

							<tr>
								<td colspan="6">
									<div class="btn-align">									
										<button class="btn btn-danger  movie_start" data-orderid="<?php echo $val['orderId'];?>" data-makeid="<?php echo $val['id'];?>">무비메이커 실행</button>									
										<button class="btn btn-danger  movie_restart" data-makeid="<?php echo $val['id'];?>" <?php echo $movie_restart;?> >재 랜더링</button>
										<button class="btn btn-danger  movie_clear" data-makeid="<?php echo $val['id'];?>"  <?php echo $movie_restart;?>>재수정</button>
										<button class="btn btn-danger  movie_plus_ten" data-makeid="<?php echo $val['id'];?>">제작일수 +10일</button>
										<button class="btn btn-danger  moviePlay" data-makeid="<?php echo $val['id'];?>" <?php echo  $final_down;?>>영상재생</button>
										<button class="btn btn-danger  movie_final_down"  data-makeid="<?php echo $val['id'];?>" <?php echo $final_down;?>>완성 파일 다운로드</button>
									</div>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</section>

				<section class="sec_detail">
					<h3>주문 상세 내역</h3>
					<table class="table table-headered table-condensed ">
						<thead>
							<tr>
								<th>제작번호</th>
								<th>주문상태</th>
								<th>가격</th>
								<th>쿠폰가격/쿠폰명</th>
								<th>상태처리</th>
								
							</tr>
						</thead>
						<tbody>
							<?php  
								foreach($orderDetailList as $key => $val) :
								$btn_disabled = null;
								if($val['itemStatus'] == "44") $btn_disabled = "disabled";
							?>
							<tr>
								<td><?php echo $val['makeId'];?></td>
								<td><?php echo $this->admin_util->order_dateil_status($val['itemStatus']);?></td>
								<td><?php echo number_format($val['itemPrice']);?></td>
								<td><?php echo $val['discount']."<br>".$val['couponName'];?></td>
								<td><button class="btn btn-danger refund_proc" <?php echo $btn_disabled;?> data-id="<?php echo $val['id'];?>">환불완료</button></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</section>


				<section class="sec_detail">
					<h3>회원정보</h3>
					<table class="table table-headered table-condensed ">
						<thead>
							<tr>
								
								
								<th>주문자(후리가나)</th>
								<th>연락처</th>
								<th>이메일</th>
								
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<?php echo $order['first_name']." ".$order['last_name'];?><br>
									<?php echo $order['yomi_first_name']." ".$order['yomi_last_name'];?>
								</td>
								<td><?php echo $order['mobile'];?></td>
								<td><?php echo $order['email'];?></td>
							</tr>
						</tbody>
					</table>
				</section>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>