<style type="text/css">
</style>
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
	});
</script>
<!-- Start #right-sidebar -->
<!-- Start #content -->
<div id="content">
	<!-- Start .content-wrapper -->
	<div class="content-wrapper">
		<form action="" id="page_form" method="get" >
				<input type="hidden" name="page"	id="page"	value="<?=(isset($input['page']) && $input['page']>=1)? $input['page'] : 1 ?>" />				
				<input type="hidden" name="memberId" 	id="memberId" 	value="<?=(isset($input['memberId']) )? $input['memberId'] : "" ?>" />				
				<input type="hidden" name="type" 	id="type" 	value="<?=(isset($input['type']) )? $input['type'] : "" ?>" />
			</form>

		<!-- Start .content-inner -->
		<div class="content-inner">
			<div class="table-responsive" style="overflow: hidden; width: 100%; height: auto;">
				<table class="table table-headered table-condensed">
				<thead>
					<th>id</th>
					<th>상품명</th>
					<th>회원번호</th>
					<th>회원이름</th>
					<th>ip</th>
					<th>브라우저</th>
					
					<th>최종방문시간</th>
				</thead>
				<tbody>
						<?php
						$page = $input["page"];
						$pagelist = $input["pagelist"];
						if(is_numeric($page) == false) $page = 1;
						if($page < 0) $page = 1;

						$total_count = $total_count - (($page -1) * $pagelist);

					//echo"<br>view";print_r($lists);

						foreach ($lists as $key => $val):
						?>
							<tr>
								<td><? echo $total_count--;?></td>
								<td><?=$val['pname']?></td>
								<td><? echo ($val['memberId'])? $val['memberId'] : "비회원";?></td>
								<td><?=$val['name']?></td>
								<td><?=$val['ip']?></td>
								<td><?=$val['bro']?></td>
								
								<td><?=$val['createDatetime']?></td>
							</tr>
							<? endforeach;  ?>
					</tbody>
				</table>
			</div>
			<!-- Start .row -->
			<div class="page-nation">
				<ul class="pagination">
					<?=$page_nation?>
				</ul>
			</div>

		</div>
	</div>
	<!-- End .content-wrapper -->
	<div class="clearfix"></div>
</div>
<!-- End #content -->
