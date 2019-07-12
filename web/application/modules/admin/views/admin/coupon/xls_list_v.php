<style type="text/css">
</style>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,700' rel='stylesheet' type='text/css'>
<script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
<script>
	$(document).ready(function (){
		$(".pagination a").click(function (event){
		  	event.stopPropagation ();
			//alert($(this).data("num"));
			$("#page").val($(this).data("num"));
			$("#page_form").submit();
			
		});
		
		$("#form_post").click(function (event){
			$("#page_form").submit();			
		});
		$("#reset").click(function (event){			
			$("#page").val("1");
			$("#sfl").val("");
			$("#stx").val("");
			$("#sdate").val("");
			$("#edate").val("");			
			$("#page_form").submit();			
		});
		
		
		$.datepicker.regional['ko'] = {
                         closeText: '닫기',
                         prevText: '이전달',
                         nextText: '다음달',
                         currentText: '오늘',
                         monthNames: ['1월','2월','3월','4월','5월','6월',
                         '7월','8월','9월','10월','11월','12월'],
                         monthNamesShort: ['1월','2월','3월','4월','5월','6월',
                         '7월','8월','9월','10월','11월','12월'],
                         dayNames: ['일','월','화','수','목','금','토'],
                         dayNamesShort: ['일','월','화','수','목','금','토'],
                         dayNamesMin: ['일','월','화','수','목','금','토'],
               //          weekHeader: 'Wk',
                         dateFormat: 'yy-mm-dd',
                         firstDay: 0,
                         isRTL: false,
                         duration:200,
                         showMonthAfterYear: true,
                         autoSize: false, //오토리사이즈(body등 상위태그의 설정에 따른다)
                         changeMonth: true, //월변경가능
                         changeYear: true, //년변경가능
                         yearRange: '1990:2020',
                         yearSuffix: '년'
                    };
                    $.datepicker.setDefaults($.datepicker.regional['ko']);
                    $("#sdate").datepicker();
                    $("#edate").datepicker();               
	});
</script>
<!-- Start #right-sidebar -->
<!-- Start #content -->
<div id="content">
	
	<!-- Start .content-wrapper -->
	<div class="content-wrapper">

		<!-- Start .content-inner -->
		<div class="content-inner">			
			<div class="table-responsive" style="overflow: hidden; width: 100%; height: auto;">
				<table class="table table-headered table-condensed">
				<thead>

					<th>num</th>
					<th>쿠폰설명</th>
					<th>사용기간</th>
					<th>발급수량</th>
					<th>공급가액</th>
					<th>발급총액</th>

					<th>1월</th>
					<th>2월</th>
					<th>3월</th>
					<th>4월</th>
					<th>5월</th>
					<th>6월</th>
					<th>7월</th>
					<th>8월</th>
					<th>9월</th>
					<th>10월</th>
					<th>11월</th>
					<th>12월</th>
					<th>누계</th>
					<th>판매율</th>

				</thead>
				<tbody>
				
						<?php				
						
						//print_r($xls);
						$page = $input["page"];
						$pagelist = $input["pagelist"];
						if(is_numeric($page) == false) $page = 1;
						if($page < 0) $page = 1;
						$total_count = $total_count - (($page -1) * $pagelist);
					
						foreach ($xls as $key => $val):

						$total_use_cnt = $val['date1'] +$val['date2'] +$val['date3'] +$val['date4'] +$val['date5'] +$val['date6'] +$val['date7'] +$val['date8'] +$val['date9'] +$val['date10'] +$val['date11'] +$val['date12'];

						
						?>
							<tr>
								<td><? echo $total_count--;?></td>								
								<td><?=$val['description']?></td>
								<td><?=date_format(date_create($val['startDatetime']), "Y-m-d")?>~<?=date_format(date_create($val['endDatetime']),"Y-m-d")?></td>

								<td><?=number_format($total_use_cnt)?>/<?=number_format($val['useMount'])?></td>
								<td></td>
								<td></td>


								<td><?=$val['date1']?>
								<td><?=$val['date2']?>
								<td><?=$val['date3']?>
								<td><?=$val['date4']?>
								<td><?=$val['date5']?>
								<td><?=$val['date6']?>
								<td><?=$val['date7']?>
								<td><?=$val['date8']?>
								<td><?=$val['date9']?>
								<td><?=$val['date10']?>
								<td><?=$val['date11']?>
								<td><?=$val['date12']?>
								<td><?=number_format($total_use_cnt)?></td>
								<td><?=round(( $total_use_cnt / $val['useMount'] )*100,2) ?> %</td>
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
