<script>
	$(document).ready(function() {
		$(".pagination a").click(function(event) {
			event.stopPropagation();
			//alert($(this).data("num"));
			$("#page").val($(this).data("num"));
			$("#page_form").submit();

		});

		$("#form_post").click(function(event) {
			$("#page_form").submit();
		});
		$("#reset").click(function(event) {
			$("#page").val("1");
			$("#sfl").val("");
			$("#stx").val("");
			$("#sdate").val("");
			$("#edate").val("");
			$("#page_form > div > input:checkbox").prop("checked",false);
			$("#page_form").submit();
		});


		$.datepicker.regional['en'] = {
			//         closeText: '닫기',
			//        prevText: '이전달',
			//         nextText: '다음달',
			//         currentText: '오늘',
			//         monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
			//         monthNamesShort: ['1월','2월','3월','4월','5월','6월', '7월','8월','9월','10월','11월','12월'],
			//         dayNames: ['일','월','화','수','목','금','토'],
			//         dayNamesShort: ['일','월','화','수','목','금','토'],
			//         dayNamesMin: ['일','월','화','수','목','금','토'],
			//         weekHeader: 'Wk',
			dateFormat: 'yy-mm-dd',
			firstDay: 0,
			isRTL: false,
			duration: 200,
			showMonthAfterYear: true,
			autoSize: true, //오토리사이즈(body등 상위태그의 설정에 따른다)
			changeMonth: true, //월변경가능
			changeYear: true, //년변경가능
			yearRange: '1990:2020',
			yearSuffix: 'Year'
		};
		$.datepicker.setDefaults($.datepicker.regional['en']);
		$("#sdate").datepicker();
		$("#edate").datepicker();
	});

</script>

<div class="col-md-12">
	<div class="row">
		<div class="container">
			<div class="content-inner">
				<form action="" id="page_form" method="get" class="form-horizontal">
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">검색타입</label>
						<div class="col-sm-8">
							<input type="hidden" name="page" id="page" value="<?php echo (isset($input['page']) && $input['page']>=1)? $input['page'] : 1 ?>" />
							<select name="sfl" id="sfl" class="form-control">
							<option value 	<?php if(!isset($input[ 'sfl']) || !$input[ 'sfl']) echo "selected";?>>전체</option>
								<option value="title" <?php  if(isset($input[ 'sfl']) && $input[ 'sfl']=="title" ) echo "selected";?> >이벤트제목</option>
								<option value="email" <?php  if(isset($input[ 'sfl']) && $input[ 'sfl']=="content" ) echo "selected";?> >회원이메일</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">검색문구</label>
						<div class="col-sm-8">
							<input type="text" name="stx" class="form-control" id="stx" value="<?php echo (isset($input['stx']) )? $input['stx'] : "" ?>" placeholder="검색문구를넣어주세요" />
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" for="sdate">이벤트참여일</label>
						
						<div class="col-sm-3">
							<input type="text" name="sdate" class="form-control" id="sdate" value="<?php echo (isset($input['sdate']) )? $input['sdate'] : "" ?>" placeholder="시작일"  />
						</div>
						<div class="col-sm-3">
							<input type="text" name="edate" class="form-control" id="edate" value="<?php echo (isset($input['edate']) )? $input['edate'] : "" ?>" placeholder="종료일"  />
						</div>
					</div>

					<input type="hidden" name="type" id="type" value="<?php echo (isset($input['type']) )? $input['type'] : " " ?>" />
					
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						<a href="javascript:;" id="reset" class="btn btn-info">검색 초기화</a>
						<button type="submit" id="form_post" class="btn btn-default">검색 </button>
						
						</div>
					</div>
				</form>
				
				<h5>* 당첨 여부를 클릭 하면 당첨, 비당첨 변경이 가능 합니다.</h5>
				<div class="table-responsive" style="overflow: hidden; width: 100%; height: auto;">
					<table class="table table-headered table-condensed">
						<thead>
							<th>num</th>
							<th>이벤트제목</th>
							<th>SNS주소</th>
							<th>참여자이메일</th>
							<th>참여시간</th>
							<th>당첨여부</th>
						</thead>
							<?php
								$page = $input["page"];
								$pagelist = $input["pagelist"];
								if(is_numeric($page) == false) $page = 1;
								if($page < 0) $page = 1;

								$total_count = $total_count - (($page -1) * $pagelist);
							
								foreach ($lists as $key => $val): 
							?>
							<tr>
								<td>
									<?php echo $total_count--;?>
								</td>
								<td>
									<?php echo $val["eventName"];?>
								</td>
								<td>
									<a href='<?php echo $val["url"];?>'  target="_blink"><?php echo $val["url"];?></a>
								</td>
								<td>
									<?php echo $val["memberEmail"];?>
								</td>
								<td>
									<?php echo $val["createDatetime"];?>
								</td>						
								<td>
								<?php 
									if($val["is_win"]){
								?>
									<button class="btn btn-danger" disabled>당첨</button>
								<?php	}else{ ?>

									<button class="btn btn-secondary btnWinEvent" data-id="<?php echo $val['id'];?>" data-eid="<?php echo $val['eventId'];?>" data-mid="<?php echo $val['memberId'];?>" data-email="<?php echo $val['memberEmail'];?>" >이벤트참가</button>
								<?php }?>
									
								</td>
							</tr>
						<?php endforeach;  ?>
					</table>
				</div>
					
				<div class="page-nation">
					<ul class="pagination">
						<?php echo $page_nation; ?>
					</ul>
				</div>
			</div>
		</div>		
	</div>
</div>			

<form id="list_form" action="/admin/conf/event_proc/delete" method="post">
<input type="hidden" id="del_id" name="id" value="">
</form>

<script>



$(document).on('click','.btnWinEvent',function(e){
	var id = $(this).data("id");
	var eventId = $(this).data("eid");
	var memberId = $(this).data("mid");
	var memberEmail = $(this).data("email");
	$.ajax({
		type: "post",
		data: {id:id, memberId:memberId, memberEmail:memberEmail,eventId:eventId},
		async: false,
		url: "/admin/conf/event_win_proc/coupon",
		dataType: "html",
		success: function(res){


			//alert(res);
			
			$(this).css("color","#fff");
			$(this).css("background-color","#c9302c");
			$(this).css("background-image","none");
			$(this).css("border-color","#c12e2a");
			$(this).data("val",1);
			$(this).text("당첨");
			$(this).attr("disabled",true);
			alert("쿠폰이 지급되었습니다.");
		}
	});

	
});
/*
$(document).on('click','.btnWinEvent',function(e){
	var val = $(this).data("val");

	
	if(val == 0){
		$(this).css("color","#fff");
		$(this).css("background-color","#c9302c");
		$(this).css("background-image","none");
		$(this).css("border-color","#c12e2a");
		$(this).data("val",1);
		$(this).text("WIN");
	}else{
		$(this).css("color","#292b2c");
		$(this).css("background-color","#e6e6e6");
		$(this).css("background-image","none");
		$(this).css("border-color","#adadad");
		$(this).data("val",0);
		$(this).text("LOSE");
	}


});
*/
</script>