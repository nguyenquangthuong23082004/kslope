<? include "../_include/_header.php"; ?>
<?

	$g_list_rows		= 100;
	$pg					= updateSQ($_GET["pg"]);
	$search_name		= updateSQ($_GET["search_name"]);
	$search_category	= updateSQ($_GET["search_category"]);
	$s_product_code_1	= updateSQ($_GET["s_product_code_1"]);
	$s_product_code_2	= updateSQ($_GET["s_product_code_2"]);
	$s_product_code_3	= updateSQ($_GET["s_product_code_3"]);
	$status				= $_GET["status"];
	$deli_status		= $_GET['deli_status'];


	$strSql = " and ( r_type = 'N' or r_type is null ) ";

	if ($search_name)
	{
		$strSql = $strSql." and replace(".$search_category.",'-','') like '%".str_replace("-","",$search_name)."%' ";
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

	if ($deli_status !=''){
		$deli_val = '';
		$deli_pg = '';
		$num = 1;
		foreach($deli_status as $keys => $vals){
			$deli_val .= "'".$vals."' ,";
			$deli_pg .= "&deli_status[".$num."]=".$vals;
			$num = $num +1;
		}
		$deli_val = substr($deli_val,0,-1);
		$deli_Sql = " and deli_status in (".$deli_val.")";
	}

	$dateSql = '';
	if($s_date){
		$dateSql = $dateSql." and date_format(regdate, '%Y-%m-%d') >= date_format('".$s_date."', '%Y-%m-%d')";
	}

	if($e_date){
		$dateSql = $dateSql." and date_format(regdate, '%Y-%m-%d') <= date_format('".$e_date."', '%Y-%m-%d')";
	}

	$sql_r_t		= " 
						select * from tbl_review2
						 where 1=1 $strSql $dateSql $status_Sql $deli_Sql
					  ";

					  // and s.displays = '' 

	$result_r_t		= mysqli_query($connect, $sql_r_t) or die (mysqli_error($connect));
	$nTotalCount = mysqli_num_rows($result_r_t);
	
?>
	<div class="page-heading mb-4">
		
		<div class="d-flex justify-content-between align-items-center">
			<header class="d-block d-xl-none pb-2">
				<a href="#" class="d-block burger-btn d-xl-none">
					<i class="bi bi-justify fs-3"></i>
				</a>
			</header>
			<h4 class="text-center">상품후기</h4>
		</div>
	</div>
		<div id="container" class="gnb_goods">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<div class="menus">
						<ul class="first">
							
						</ul>

						<ul class="last">
							<li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), true)" class="btn btn-success">전체선택</a></li>
							<li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), false)" class="btn btn-success">선택해체</a></li>
							<li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li>
							<!-- <li><a href="javascript:status_chg()" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span class="txt">상태값 변경</span></a></li> -->
						</ul>
						
					</div>

				</div><!-- // inner -->

			</header><!-- // headerContainer -->

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
										<select name="date_chker" id="date_chker" class="select_02 form-select" style="height: 39px">
											<option value="regdate" <?if($date_chker=="regdate")echo"selected";?> >등록일</option>
										</select>
									</p>

									<div class="contact_btn_box">
										<div>
											<button type="button" rel="<?=date('Y-m-d')?>" class="contact_btn" title="today" style="height: 39px">오늘</button>
											<button type="button" rel="<?=date('Y-m-d', strtotime('-1 week'));?>" class="contact_btn" style="height: 39px" title="week">1주일</button>
											<button type="button" rel="<?=date('Y-m-d', strtotime('-1 month'));?>" class="contact_btn" style="height: 39px" title="1month">1개월</button>
											<button type="button" rel="<?=date('Y-m-d', strtotime('-6 month'));?>" class="contact_btn" style="height: 39px" title="6month">6개월</button>
											<button type="button" rel="<?=date('Y-m-d', strtotime('-1 year'));?>" class="contact_btn" style="height: 39px" title="year">1년</button>
											<input type="text" name="s_date" id="s_date" value="<?=$s_date?>" class="form-control datepicker" style="height: 39px" ><span>~</span><input type="text" name="e_date" id="e_date" value="<?=$e_date?>" class="datepicker form-control" style="height: 39px" >
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
									<input type="checkbox" name="status[]" id="status1" value='N' <?=(in_array('N',$status) == true ? "checked" : "")?>><label for="status1">미승인</label>&nbsp;&nbsp;&nbsp;
									<input type="checkbox" name="status[]" id="status2" value='Y' <?=(in_array('Y',$status) == true ? "checked" : "")?>><label for="status2">승인</label>&nbsp;&nbsp;&nbsp;
									<input type="checkbox" name="status[]" id="status3" value='R' <?=(in_array('R',$status) == true ? "checked" : "")?>><label for="status3">승인거부</label>
								</td>
								<td class="label">발송여부 상태값</td>
								<td class="inbox">
									<input type="checkbox" name="deli_status[]" id="deli_status1" value='1' <?=(in_array('1',$deli_status) == true ? "checked" : "")?>><label for="deli_status1">미확인</label>&nbsp;&nbsp;&nbsp;
									<input type="checkbox" name="deli_status[]" id="deli_status2" value='2' <?=(in_array('2',$deli_status) == true ? "checked" : "")?>><label for="deli_status2">발송</label>
									<input type="checkbox" name="deli_status[]" id="deli_status3" value='3' <?=(in_array('3',$deli_status) == true ? "checked" : "")?>><label for="deli_status3">보류</label>
								</td>
							</tr>

							<tr>
								<td class="label">검색어</td>
								<td class="inbox" colspan="3">
									
									<div class="r_box d-flex" style="gap: 10px;" >
										<select id="" name="search_category" class="form-select" style="width:112px; height: 39px">
											<!-- <option value="" >전체검색</option> -->
											<option value="user_name" <?if($search_category=="user_name")echo"selected";?> >고객명</option>
											<option value="tel1" <?if($search_category=="tel1")echo"selected";?> >명의자연락처</option>
											<option value="tel2" <?if($search_category=="tel2")echo"selected";?> >수령자연락처</option>
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
							<tr>
								<td class="label">엑셀받기</td>
								<td class="inbox" colspan="3">
									
									<!-- <a id="btn_change_order_state2" href="javascript:get_excel(500);" class="change_btn01">다운(최근 500건)</a> -->
									<a id="btn_change_order_state3" href="javascript:get_excel_chk();" class="change_btn01" style="margin-left:10px;">다운(선택받기)</a>
									<!--
									<a id="btn_change_order_state" href="javascript:get_excel();" class="change_btn01">다운</a>
									-->
								</td>
							</tr>
							<tr>
								<td class="label">상태값 변경</td>
								<td class="inbox" colspan="3">
									<a id="btn_change_order_state3" href="javascript:status_chg('S','N');" class="change_btn01" style="margin-left:10px;">미승인</a>
									<a id="btn_change_order_state3" href="javascript:status_chg('S','Y');" class="change_btn01" style="margin-left:10px;">승인</a>
									<a id="btn_change_order_state3" href="javascript:status_chg('S','R');" class="change_btn01" style="margin-left:10px;">승인거부</a>
								</td>
							</tr>
							<tr>
								<td class="label">발송상태 변경</td>
								<td class="inbox" colspan="3">
									<a id="btn_change_order_state3" href="javascript:status_chg('D','1');" class="change_btn01" style="margin-left:10px;">미확인</a>
									<a id="btn_change_order_state3" href="javascript:status_chg('D','2');" class="change_btn01" style="margin-left:10px;">발송</a>
									<a id="btn_change_order_state3" href="javascript:status_chg('D','3');" class="change_btn01" style="margin-left:10px;">보류</a>
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

				
				
		

					
					<div class="listTop">
						<div class="left">
							<p class="schTxt">■ 총 <?=$nTotalCount?>개의 목록이 있습니다.</p>
						</div>

					</div><!-- // listTop -->
					
					
					<form name="frm" id="frm">				
					<input type="hidden" name="type" value=''>
					<input type="hidden" name="val" value=''>
					<div class="listBottom">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable" style="table-layout:fixed;">
						<caption></caption>
						<colgroup>
						<col width="4%" />
						<col width="10%" />
						<col width="15%" />
						<col width="10%" />
						<col width="10%" />
						<col width="7%" />
						<col width="*" />
						<col width="10%" />
						<col width="8%" />
						<col width="8%" />
						<col width="10%" />
						</colgroup>
						<thead>
							<tr>
								<th>선택</th>
								<th>카테고리</th>
								<th>모델명</th>
								<th>고객명</th>
								<th>명의자연락처</th>
								<th>수령자연락처</th>
								<th>제목</th>
								<th>상태</th>
								<th>발송상태</th>
								<th>등록일</th>
								<th>관리</th>
							</tr>
						</thead>	
						<tbody>
							<?
								
								$nPage = ceil($nTotalCount / $g_list_rows);
								if ($pg == "") $pg = 1;
								$nFrom = ($pg - 1) * $g_list_rows;
								
								$sql    = $sql_r_t . " order by idx desc limit $nFrom, $g_list_rows ";
								$result = mysqli_query($connect, $sql) or die (mysqli_error($connect));
								$num = $nTotalCount - $nFrom;
								
								
								if ($nTotalCount == 0) {
							?>
								<tr>
									<td colspan=11 style="text-align:center;height:100px">검색된 결과가 없습니다.</td>
								</tr>
							<?
								}
							?>
							

							<?
								while($row = mysqli_fetch_array($result)){

									$g_sql = "select * from tbl_goods where g_idx = '".$row['g_idx']."' ";
									$g_result = mysqli_query($connect, $g_sql);
									$g_row = mysqli_fetch_array($g_result);
									$goods_name = $g_row['goods_name_front'];
									if($goods_name == ""){
										$goods_name = "기본";
									}

									 $product_code = substr($g_row['product_code'], 1, -1);

									$g_code_name = '';

									$g_code_sql = "SELECT * FROM tbl_code WHERE code_no = '$product_code'";
									$g_code_result = mysqli_query($connect, $g_code_sql);
									$g_code_row = mysqli_fetch_array($g_code_result);

									if ($g_code_row) {

										if ($g_code_row['parent_code_no'] == '0') {
											$g_code_name = $g_code_row['code_name'];
										} 
										else {
											$parent_sql = "SELECT code_name FROM tbl_code WHERE code_no = '".$g_code_row['parent_code_no']."'";
											$parent_result = mysqli_query($connect, $parent_sql);
											$parent_row = mysqli_fetch_array($parent_result);

											if ($parent_row) {
												$g_code_name = $parent_row['code_name'] . ' > ' . $g_code_row['code_name'];
											} else {
												$g_code_name = $g_code_row['code_name'];
											}
										}
									}
							?>

								<tr>
									<td><input type="checkbox" name="idx[]" class="idx" value="<?=$row['idx']?>"  /></td>
									<td>
										<p><?=$g_code_name?></p>
									</td>
									<td>
										<p><?=$g_row['goods_code']?></p>
									</td>
									<td>
										<a href="review_write.php?idx=<?=$row['idx']?>"><?=$row['user_name']?></a>
									</td>
									<td>
										<p><?=$row['tel1']?></p>
									</td>
									<td>
										<p><?=$row['tel2']?></p>
										
									</td>
									<td><?=$row['subject']?></td>
									<td>
										<select name='status[]'>
											<option value="N" <?if($row['status'] == "N")echo"selected";?> >미승인</option>
											<option value="Y" <?if($row['status'] == "Y")echo"selected";?> >승인</option>
											<option value="R" <?if($row['status'] == "R")echo"selected";?> >승인거부</option>
										</select>
									</td>
									<td class="tac">
										<select name="deli_status[]" id="deli_status" >
											<option value="1" <?=($row['deli_status'] == '1' ? "selected" : "")?>>미확인</option>
											<option value="2" <?=($row['deli_status'] == '2' ? "selected" : "")?>>발송</option>
											<option value="3" <?=($row['deli_status'] == '3' ? "selected" : "")?>>보류</option>
										</select>
									</td>
									<td class="date">
										<span><?=$row['regdate']?></span>
									</td>
									<td scope="row" class="text-center">
										<a href="review_write.php?idx=<?=$row['idx']?>"
											class="btn btn-primary"><i class="bi bi-pencil"></i></a>
										<a href="javascript:del_it(<?= $row['idx'] ?>)" class="btn btn-danger"><i
												class="bi bi-trash"></i></a>
									</td>
									<!-- <td>
										<a href="review_write.php?idx=<?=$row['idx']?>"><img src="/AdmMaster/_images/common/ico_setting2.png"></a>
										<a href="javascript:del_it('<?=$row['idx']?>');"><img src="/AdmMaster/_images/common/ico_error.png" alt="에러" /></a>
									</td> -->
								</tr>

							<?  } ?>
							
						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

					<?echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF]."?s_product_code_1=".$s_product_code_1."&s_product_code_2=".$s_product_code_2."&s_product_code_2=".$s_product_code_3."&search_category=".$search_category."&search_name=".$search_name.$status_pg.$deli_pg."&pg=")?>


					<div id="headerContainer">
						
						<div class="inner">
							<div class="menus">
							

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


function change_it()
{
       $.ajax({
			url: "change.php",
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
					alert_("정상적으로 변경되었습니다.");
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
			url: "review_del.php",
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
				response = response.trim();

				if (response == "OK")
				{
					alert_("정상적으로 삭제되었습니다.");
					setTimeout(function(){
						location.reload();
					},1000);
					return;
				} else {
					alert(response);
					alert_("오류가 발생하였습니다!!");
					return;
				}
			}
        });
 
}
function status_chg(type,val) {
		if ($(".idx").is(":checked") == false)
		{
			alert_("변경할 내용을 선택하셔야 합니다.");
			return;
		}
		$('input[name="type"]').val(type);
		$('input[name="val"]').val(val);

		$("#ajax_loader").removeClass("display-none");

        $.ajax({
			url: "chg_reviews.php",
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
				response = response.trim();

				if (response == "OK")
				{
					alert_("정상적으로 변경되었습니다.");
					setTimeout(function(){
						location.reload();
					},1000);
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
		url: "review_del.php",
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
				setTimeout(function(){
					location.reload();
				},1000);
				return;
			} else {
				alert(response);
				alert_("오류가 발생하였습니다!!");
				return;
			}
		}
	});
 
}

function get_code(strs, depth)
{
		$.ajax({
			type:"GET"
			, url:"get_code.ajax.php"
			, dataType : "html" //전송받을 데이터의 타입
			, timeout : 30000 //제한시간 지정
			, cache : false  //true, false
			, data : "parent_code_no="+ encodeURI(strs) +"&depth="+depth //서버에 보낼 파라메터
			,error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert("code : " + request.status + "\r\nmessage : " + request.reponseText);
			}
			, success:function(json){
				//alert(json);
				if (depth <= 3)
				{
					$("#product_code_2").find('option').each(function() {
						$(this).remove();
					});
					$("#product_code_2").append("<option value=''>2차분류</option>");
				}
				if (depth <= 4)
				{
					$("#product_code_3").find('option').each(function() {
						$(this).remove();
					});
					$("#product_code_3").append("<option value=''>3차분류</option>");
				}
				if (depth <= 4)
				{
					$("#product_code_4").find('option').each(function() {
						$(this).remove();
					});
					$("#product_code_4").append("<option value=''>4차분류</option>");
				}
				var list = $.parseJSON(json);
				var listLen = list.length;
				var contentStr = "";
				for(var i=0; i<listLen; i++)
				{
					contentStr = "";
					if (list[i].code_status == "C")
					{
						contentStr = "[마감]";
					} else if (list[i].code_status == "N") {
						contentStr = "[사용안함]";
					}
					$("#product_code_"+(parseInt(depth)-1)).append("<option value='"+list[i].code_no+"'>"+list[i].code_name+""+contentStr+"</option>");
				}
			}
		});
}

/*
function fn_chg_stat(idx, state){

	$.ajax({
		url: "review_status_chg.php",
		type: "POST",
		data: "idx="+idx+"&status="+state,
		error : function(request, status, error) {
		 //통신 에러 발생시 처리
			alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
			$("#ajax_loader").addClass("display-none");
		}
		,complete: function(request, status, error) {
//				$("#ajax_loader").addClass("display-none");
		}
		, success : function(response, status, request) {
			response = response.trim();

			if (response == "OK")
			{
				alert_("수정되었습니다.");
				setTimeout(function(){
					location.reload();
				},1000)
				return;
			} else {
				alert(response);
				alert_("오류가 발생하였습니다!!");
				return;
			}
		}
	});

}
*/
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
/*
function deli_chg(idx, val){
	$.ajax({
		url:"deli_chg_ajax.php"
		,data:"idx="+idx+"&deli_status="+val
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
*/
// 선택 엑셀 다운
function get_excel_chk(){

	if ($(".idx").is(":checked") == false)
	{
		alert_("다운받을 내용을 선택하셔야 합니다.");
		return;
	}
	
	var frm = document.frm;
	frm.method = "post";
	frm.action = "./excel_down_chk.php";
	frm.submit();
	
}
</script>


<? include "../_include/_footer.php"; ?>