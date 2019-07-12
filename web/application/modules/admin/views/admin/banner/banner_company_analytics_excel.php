<!html>
<head>
	<!-- Import google fonts - Heading first/ text second -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,700' rel='stylesheet' type='text/css'>
	<script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>

</head>
<body class="ovh">

<!-- Start #right-sidebar -->
<!-- Start #content -->
<div id="content">


	<!-- Start .content-wrapper -->
	<div class="content-wrapper">

			<h4 class="panel-title">배너 총 노출 수 : <?=number_format($ccnt)?> </h4>
			<table class="table" cellpadding="5" cellspacing="0" border="1" align="center" style="border-collapse:collapse; border:1px gray solid;">
				<thead>
					<th>상품명</th><th>노출수</th><th>비율</th>
				</thead>
				<tbody>
				<? 
					$sum = 0;
					foreach($clists as $key => $val) : 
						$tct = ($val['cnt'] / $ccnt) *100; 						
						$sum = $sum + $val['cnt'];
						$tct = round($tct, 2);
				?>
					<tr><td><?=$val['pname']?></td><td><?=number_format($val['cnt'])?></td><td><?=$tct?> %</td></tr>
				<? endforeach; ?>
				<?
					$ect = $ccnt-$sum; 	$tect = ($ect / $ccnt) * 100;  $tect = round($tect,2);
				?>
					<tr><td>기타</td><td><?=number_format($ect)?></td><td><?=$tect?> %</td></tr>					
				</tbody>
			</table>
			<br />


			<h4 class="panel-title">배너 총 클릭 수 : <?=number_format($acnt)?> </h4>
			<table class="table" cellpadding="5" cellspacing="0" border="1" align="center" style="border-collapse:collapse; border:1px gray solid;">
				<thead>
					<th>상품명</th><th>클릭수</th><th>비율</th>
				</thead>
				<tbody>
				<? 
					$sum = 0;
					foreach($alists as $key => $val) : 
						$tct = ($val['cnt'] / $acnt) *100; 
						$sum = $sum + $val['cnt'];
						$tct = round($tct,2);
				?>
					<tr><td><?=$val['pname']?></td><td><?=number_format($val['cnt'])?></td><td><?=$tct?> %</td></tr>
				<? endforeach; ?>
				<?
					$ect = $acnt-$sum; 	$tect = ($ect / $acnt) * 100;  $tect = round($tect,2);
				?>
					<tr><td>기타</td><td><?=number_format($ect)?></td><td><?=$tect?> %</td></tr>
					
				</tbody>
			</table>
			<br />

			<h4 class="panel-title">배너 클릭 리스트</h4>

			<div class="table-responsive" style="overflow: hidden; width: 100%; height: auto;">
				<table class="table" cellpadding="5" cellspacing="0" border="1" align="center" style="border-collapse:collapse; border:1px gray solid;">
				<thead>
					<th>id</th>
					<th>배너명</th>
					<th>상품명</th>
					<!--th>회원번호</th -->

					<th>ip</th>
					<th>브라우저</th>
					<th>최종방문시간</th>
					<!--th>총 횟수</th -->

				</thead>
				<tbody>
						<?php						
						//page set
						$page = $input["page"];
						$pagelist = $input["pagelist"];
						if(is_numeric($page) == false) $page = 1;
						if($page < 0) $page = 1;

						$total_count = $total_count - (($page -1) * $pagelist);



						foreach ($lists as $key => $val):
						?>
							<tr>
								<td><? echo $total_count--;?></td>
								<td><?=$val['alt']?></td>
								<td><?=$val['pname']?></td>
								<!-- td><? echo ($val['memberId'])? $val['memberId'] : "비회원";?></td -->

								<td><?=$val['ip']?></td>
								<td><?=$val['bro']?></td>
								<td><?=$val['createDatetime']?></td>
								<!--td><?=$val['cnt']?></td -->
								
							</tr>
							<? endforeach;  ?>
					</tbody>
				</table>
			</div>
			<!-- Start .row -->
		</div>
	</div>
	<!-- End .content-wrapper -->
	<div class="clearfix"></div>
</div>
<!-- End #content -->
