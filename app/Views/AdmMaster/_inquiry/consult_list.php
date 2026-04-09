<? include "../_include/_header.php"; ?>
<?

	$status			= $_GET["status"];

	$type			= $_GET["type"];
	
	$g_list_rows = 50;

	if ($search_name)
	{
		$strSql = $strSql." and replace(".$search_category.",'-','') like '%".str_replace("-","",$search_name)."%' ";
	}

	if ($s_status == "") {
		$s_status = "Y";
	}

	if ($status !=''){
		$status_val = '';
		$status_pg = '';
		$num = 1;
		foreach($status as $keys => $vals){
			$status_val .= "'".$vals."' ,";
			$status_pg .= "&status[".$num."]=".$vals;
			$num = $num +1;
		}
		$status_val = substr($status_val,0,-1);
		$status_Sql = " and status in (".$status_val.")";
	}

	if ($type !=''){
		$type_Sql = " and type = '".$type."' ";
	}

	$dateSql = '';
	if($s_date){
		$dateSql = $dateSql." and date_format(r_date, '%Y-%m-%d') >= date_format('".$s_date."', '%Y-%m-%d')";
	}

	if($e_date){
		$dateSql = $dateSql." and date_format(r_date, '%Y-%m-%d') <= date_format('".$e_date."', '%Y-%m-%d')";
	}


	//$strSql = $strSql." and status != 0 and user_level > 1 ";
	$total_sql = " select *		
						from tbl_consult where 1=1 $strSql $dateSql $status_Sql $type_Sql";
	
	//echo $total_sql;
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$nTotalCount = mysqli_num_rows($result);
?>
		<div class="page-heading mb-4">
			
			<div class="d-flex justify-content-between align-items-center">
				<header class="d-block d-xl-none pb-2">
					<a href="#" class="d-block burger-btn d-xl-none">
						<i class="bi bi-justify fs-3"></i>
					</a>
				</header>
				<h4 class="text-center">제품상담신청</h4>
			</div>
		</div>
		<div id="container" class="gnb_inquiry">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<div id="contents">
				<form name="search" id="search">		
				<input type="hidden" name="gubun" value="<?=$gubun?>">
				<header id="listBottom">

					<!-- 시작 -->

					<table cellpadding="0" cellspacing="0" summary="" class="listTable01" style="table-layout:fixed;">
						<colgroup>
							<col width="150">
							<col width="*">
							<col width="150">
							<col width="*">
						</colgroup>
						<thead>
							<tr>
								<th colspan="2"></th>
							</tr>
						</thead>
						<tbody>
							
							<tr>
								<td class="label">기간검색</td>
								<td class="inbox" colspan="3">

									<p style="margin-bottom: 0">
										<select name="date_chker" id="date_chker" class="form-select" style="height: 39px">
											<option value="regdate" <?if($date_chker=="regdate")echo"selected";?> >등록일</option>
										</select>
									</p>

									<div class="contact_btn_box">
										<div>
											<button type="button" rel="<?=date('Y-m-d')?>" class="contact_btn" title="today" style="height: 39px">오늘</button>
											<button type="button" rel="<?=date('Y-m-d', strtotime('-1 week'));?>" class="contact_btn" title="week" style="height: 39px">1주일</button>
											<button type="button" rel="<?=date('Y-m-d', strtotime('-1 month'));?>" class="contact_btn" title="1month" style="height: 39px">1개월</button>
											<button type="button" rel="<?=date('Y-m-d', strtotime('-6 month'));?>" class="contact_btn" title="6month" style="height: 39px">6개월</button>
											<button type="button" rel="<?=date('Y-m-d', strtotime('-1 year'));?>" class="contact_btn" title="year" style="height: 39px">1년</button>
											<input type="text" name="s_date" id="s_date" value="<?=$s_date?>" class="form-control datepicker" style="height: 39px"><span>~</span><input type="text" name="e_date" id="e_date" value="<?=$e_date?>" class="form-control datepicker" style="height: 39px" >
											<div id="time_layer" style="float: left; display: <?= (trim($s_time) == "" && trim($e_time) == "" ? "none" : "") ?>;">
												<select id="s_time" name="s_time" class="form-select" style="height: 39px">
													<option value="">선택</option>
													<?php for($t=1; $t<=23; $t++) { ?>
														<option value="<?=$t?>" <?=((int)($s_time) == $t ? "selected" : "")?> ><?=((int)($t) < 10 ? "0" . (int)($t) : (int)($t))?></option>
													<?php } ?>
												</select> ~
												<select id="e_time" name="e_time" class="form-select" style="height: 39px">
													<option value="">선택</option>
													<?php for($t=1; $t<=23; $t++) { ?>
														<option value="<?=$t?>" <?=((int)($e_time) == $t ? "selected" : "")?> ><?=((int)($t) < 10 ? "0" . (int)($t) : (int)($t))?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
								</td>
							</tr>
							
							<tr>
								<td class="label">상태값</td>
								<td class="inbox">
									<input type="checkbox" name="status[]" id="status1" value='1' <?=(in_array('1',$status) == true ? "checked" : "")?>><label for="status1">확인 중</label>&nbsp;&nbsp;&nbsp;
									<input type="checkbox" name="status[]" id="status2" value='2' <?=(in_array('2',$status) == true ? "checked" : "")?>><label for="status2">확인완료</label>&nbsp;&nbsp;&nbsp;
									<input type="checkbox" name="status[]" id="status3" value='3' <?=(in_array('3',$status) == true ? "checked" : "")?>><label for="status3">보류</label>
								</td>
								<td class="label">관리타입 
									<!-- <button type='button' class="btn btn-secondary" onclick='type_cancel();'>초기화</button> -->
								</td>
								<td class="inbox">
									<input type="radio" name="type" id="type1" value='self' <?=($type == 'self' ? "checked" : "")?>><label for="type1">셀프관리</label>&nbsp;&nbsp;&nbsp;
									<input type="radio" name="type" id="type2" value='visit' <?=($type == 'visit' ? "checked" : "")?>><label for="type2">방문관리</label>
								</td>
							</tr>
							
							<tr>
								<td class="label">검색어</td>
								<td class="inbox" colspan="3">
									
									<div class="r_box d-flex" style="gap: 10px;">
										<select id="" name="search_category" class="form-select" style="width:112px; height: 39px">
											<!-- <option value="" >전체검색</option> -->
											<option value="user_name" <?if($search_category=="user_name")echo"selected";?> >고객명</option>
											<option value="tel" <?if($search_category=="tel")echo"selected";?> >연락처</option>
										</select>
										<div class="input-group">
											<input type="text" id="search_name" name="search_name" value="<?=$search_name?>" class="form-control placeHolder" placeholder="검색어 입력" style="width:240px" onkeyDown="if(event.keyCode==13)search_it();" />
											<!-- <input type="text" class="form-control" name="search_txt" placeholder="Search" aria-label="Search" value=""> -->
											<button class="btn btn-light" onclick="search_it()"><i class="bi bi-search"></i></button>
										</div>
										<!-- <input type="text" id="search_name" name="search_name" value="<?=$search_name?>" class="input_txt placeHolder" placeholder="검색어 입력" style="width:240px" onkeyDown="if(event.keyCode==13)search_it();" />

										<a href="javascript:search_it()" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> <span class="txt">검색</span></a> -->
									</div>
								</td>
							</tr>

						</tbody>
					</table>
				</header><!-- // headerContents -->
				</form>
				<script>
				function search_it()
				{
					var frm = document.search;
					if (frm.search_name.value == "검색어 입력")
					{
						frm.search_name.value = "";
					}
					frm.submit();
				}
				</script>

				<div class="listWrap">
					<!-- 안내 문구 필요시 구성 //-->

				
				
		

					
					<div class="listTop d-flex justify-content-between gap-2 w-100" style="margin-bottom: 30px">
						<div class="left">
							<p class="schTxt">■ 총 <?= number_format($nTotalCount) ?>개의 목록이 있습니다.</p>
						</div>

						<ul class="last d-flex flex-wrap gap-2">
								<li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), true)" class="btn btn-success">전체선택</a></li>
								<li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), false)" class="btn btn-success">선택해체</a></li>
								<li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li>
								<!-- <li><a href="javascript:status_chg()" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span class="txt">상태값 변경</span></a></li> -->
							</ul>

					</div><!-- // listTop -->
					
					
					



					<form name="frm" id="frm">				
					<div class="listBottom">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable">
						<caption></caption>
						<colgroup>
						<col width="60px" />
						<col width="60px" />
						<col width="100px" />
						<col width="100px" />
						<col width="*" />
						<col width="200px" />
						<col width="150px" />
						<col width="150px" />
						<col width="150px" />
						</colgroup>
						<thead>
							<tr>
								<th>선택</th>
								<th>번호</th>
								<th>관리타입</th>
								<th>약정기간</th>
								<th>이름</th>	
								<th>연락처</th>
								<th>등록일</th>
								<th>상태값</th>
								<th>관리</th>
							</tr>
						</thead>	
						<tbody>
							<?
								$nPage = ceil($nTotalCount / $g_list_rows);
								if ($pg == "") $pg = 1;
								$nFrom = ($pg - 1) * $g_list_rows;

								$sql    = $total_sql . " order by idx desc limit $nFrom, $g_list_rows ";
								$result = mysqli_query($connect, $sql) or die (mysql_error());
								$num = $nTotalCount - $nFrom;
								if ($nTotalCount == 0) {
							?>
							<tr>
								<td colspan=8 style="text-align:center;height:100px">검색된 결과가 없습니다.</td>
							</tr>
							<?
								}
								while($row=mysqli_fetch_array($result)){
									$p_sql = "select code_name from tbl_period where code_no = '".$row['period']."' ";
									$p_result = mysqli_query($connect, $p_sql);
									$p_row = mysqli_fetch_array($p_result);
							?>
							<tr style="height:50px">
								<td><input type="checkbox" name="idx[]" class="idx" value="<?=$row['idx']?>"  /></td>
								<td><?=$num--?></td>
								<td class="tac"><?=($row["type"]=="self" ? "셀프관리" : ($row["type"] == "visit" ? "방문관리" : "") )?></td>
								<td class="tac"><?=$p_row['code_name']?></td>
								<td class="tac"><a href="consult_write.php?idx=<?=$row['idx']?>"><?=$row["user_name"]?></a></td>
								
								<td class="tac"><?=$row["tel"]?></td>
								<td class="tac"><?=$row["r_date"]?></td>
								<td class="tac">
									<select name="status" id="status" onchange="status_chg('<?=$row['idx']?>', this.value)">
										<option value="1" <?=($row['status'] == '1' ? "selected" : "")?>>확인 중</option>
										<option value="2" <?=($row['status'] == '2' ? "selected" : "")?>>확인완료</option>
										<option value="3" <?=($row['status'] == '3' ? "selected" : "")?>>보류</option>
									</select>
								</td>
								<td scope="row" class="text-center">
									<a href="consult_write.php?idx=<?=$row['idx']?>"
										class="btn btn-primary"><i class="bi bi-pencil"></i></a>
									<a href="javascript:del_it(<?= $row['idx'] ?>)" class="btn btn-danger"><i
											class="bi bi-trash"></i></a>
								</td>
								<!-- <td class="tac">
									<a href="consult_write.php?idx=<?=$row['idx']?>"><img src="/AdmMaster/_images/common/ico_setting2.png"></a>
									<a href="javascript:del_it('<?=$row['idx']?>');"><img src="/AdmMaster/_images/common/ico_error.png" alt="에러" /></a>
								</td> -->
								
							</tr>
							<?  } ?>




							
						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

					<?echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF]."?s_status=$s_status&search_category=$search_category&search_name=$search_name".$status_pg."&type=$type&pg=")?>


					<div id="headerContainer">
						
						<div class="inner">
							<div class="menus">
								<ul class="first">
									<!-- <li><a href="javascript:CheckAll(document.getElementsByName('m_idx[]'), true)" class="btn btn-success">전체선택</a></li>
									<li><a href="javascript:CheckAll(document.getElementsByName('m_idx[]'), false)" class="btn btn-success">선택해체</a></li>
									<li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li> -->
								</ul>

								<ul class="last">
								</ul>
								
							</div>

						</div><!-- // inner -->

					</div><!-- // headerContainer -->
				</div><!-- // listWrap -->

			</div><!-- // contents -->





		</span><!-- 인쇄 영역 끝 //-->
		</div><!-- // container -->




<script>
 function CheckAll(checkBoxes,checked){
    var i;
    if(checkBoxes.length){
        for(i=0;i<checkBoxes.length;i++){
            checkBoxes[i].checked=checked;
        }
    }else{
        checkBoxes.checked=checked;
   }

}

function SELECT_DELETE() {
		if ($(".idx").is(":checked") == false)
		{
			alert_("삭제할 내용을 선택하셔야 합니다.");
			return;
		}
		if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false)
		{
			return;
		}

		$("#ajax_loader").removeClass("display-none");

        $.ajax({
			url: "del_consult.php",
			type: "POST",
			data: $("#frm").serialize(),
			error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				$("#ajax_loader").addClass("display-none");
			}
			,complete: function(request, status, error) {
//				$("#ajax_loader").addClass("display-none");
			}
			, success : function(response, status, request) {
				if (response == "OK")
				{
					alert_("정상적으로 삭제되었습니다.");
						location.reload();
					return;
				} else {
					alert(response);
					alert_("오류가 발생하였습니다!!");
					return;
				}
			}
        });
 
}

function del_it(idx) {

		if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false)
		{
			return;
		}
		$("#ajax_loader").removeClass("display-none");
        $.ajax({
			url: "del_consult.php",
			type: "POST",
			data: "idx[]="+idx,
			error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				$("#ajax_loader").addClass("display-none");
			}
			,complete: function(request, status, error) {
//				$("#ajax_loader").addClass("display-none");
			}
			, success : function(response, status, request) {
				if (response == "OK")
				{
					alert_("정상적으로 삭제되었습니다.");
					location.reload();
					return;
				} else {
					alert(response);
					alert_("오류가 발생하였습니다!!");
					return;
				}
			}
        });
 
}
$(".contact_btn_box .contact_btn").click(function(){
		resetClass();
		$(this).addClass("active");

		
		var date1 = $(this).attr("rel");
		var date2 = $.datepicker.formatDate('yy-mm-dd',new Date());

		$("#s_date").val(date1);
		$("#e_date").val(date2);

	});

	function resetClass(){
		$(".contact_btn_box .contact_btn").each(function(){
			$(this).removeClass("active");
		});
	}

</script>
<script>

	function view_m(user_id, pg=1){
		$('.mileage_popup').css({'display':'block'});
		$('html').css({'overflow': 'hidden', 'height': '100%'}); 
		$('#element').on('scroll touchmove mousewheel', function(event) {  event.preventDefault();  event.stopPropagation();   return false; });
		

		$.ajax({
			url: "getpoint.php",
			type: "POST",
			data: "user_id="+user_id+"&pg="+pg,
			error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				$("#ajax_loader").addClass("display-none");
			}
			,complete: function(request, status, error) {
//				$("#ajax_loader").addClass("display-none");
			}
			, success : function(response, status, request) {
				$("#select_cash").html(response);
			}
        });


	}


	function view_c(user_id, pg=1){
		$('.cupon_popup').css({'display':'block'});
		$('html').css({'overflow': 'hidden', 'height': '100%'}); 
		$('#element').on('scroll touchmove mousewheel', function(event) {  event.preventDefault();  event.stopPropagation();   return false; });

		$.ajax({
			url: "getcoupon.php",
			type: "POST",
			data: "user_id="+user_id+"&pg="+pg,
			error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				$("#ajax_loader").addClass("display-none");
			}
			,complete: function(request, status, error) {
//				$("#ajax_loader").addClass("display-none");
			}
			, success : function(response, status, request) {
				$("#select_coupon").html(response);
			}
        });

	}


	$(window).load(function(){
		/*
		$('.open_popup').on('click',function(){
			
			if($(this).hasClass('m_popup')){
				$('.mileage_popup').css({'display':'block'});
			}else if($(this).hasClass('c_popup')){
				$('.cupon_popup').css({'display':'block'});
			}
			$('html').css({'overflow': 'hidden', 'height': '100%'}); 
			$('#element').on('scroll touchmove mousewheel', function(event) {  event.preventDefault();  event.stopPropagation();   return false; });
			
		});
		*/


		
		$('.mc_close_popup').on('click',function(){
			$('.mc_popup').css({'display':'none'});
			$('html').css({'overflow': 'auto', 'height': '100%'}); 
			$('#element').off('scroll touchmove mousewheel');

			$("#select_cash").html("");
			$("#select_coupon").html("");

		});

		$('.mc_popup').on('click',function(e){
			
			if ($(e.target).hasClass('mc_popup')) {

				 $('.mc_popup').css({'display':'none'});
			}
			$('html').css({'overflow': 'auto', 'height': '100%'}); 
			$('#element').off('scroll touchmove mousewheel');

		});
	});

function status_chg(idx, val){
	$.ajax({
		url:"status_chg.php"
		,data:"idx="+idx+"&status="+val
		,type:"POST"
		,error:function(request, status, error){
			alert("CODE : "+request.status+"\r\nmessage : "+request.reponseText);
			return false;
		}
		,success:function(response, status, request){
			response = response.trim();
			if (response == "OK")
			{
				alert_("상태값이 변경되었습니다.");
				setTimeout(function(){
					location.reload();
				},1000);
			}else{
				alert(response);
				alert_("오류가 발생하였습니다.");
				return false;
			}
		}
	})
}
function type_cancel(){
	$("input[name='type']").prop("checked",false);
}
function del_it(idx){
	

	if( confirm("삭제하시겠습니까?\r\n삭제 후에는 복구가 불가능합니다.") == false){
		return false;
	}else{
		$.ajax({
			 url:"consult_del.php"
			,data:"idx="+idx
			,type:"GET"
			,error:function(request, status, error){
				alert("CODE : "+request.status+"\r\nmessage : "+request.reponseText);
				return false;
			}
			,success:function(response, status, request){
				response = response.trim();
				if (response == "OK")
				{
					alert_("삭제되었습니다.");
					setTimeout(function(){
						location.reload();
					},1000);
				}else{
					alert(response);
					alert_("오류가 발생하였습니다.");
					return false;
				}
			}
		})
	}
}
</script>


<? include "../_include/_footer.php"; ?>