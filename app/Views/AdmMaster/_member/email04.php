<? include "../_include/_header.php"; ?>
<?
	$g_list_rows = 10;
	$s_date	= updateSQ($_GET["s_date"]);
	$e_date	= updateSQ($_GET["e_date"]);
	$title	= updateSQ($_GET["title"]);

	$strSql = "";

	if ($title) {
		$strSql .= " and title like '%".$title."%' ";
	}

	if ($s_date) {
		$strSql .= " and regdate >= '".$s_date."' ";
	}

	if ($e_date) {
		$strSql .= " and regdate <= '".$e_date." 23:59:59' ";
	}


	
	$total_sql = " select *
	                 from tbl_email_top_log
					where 1=1 $strSql ";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$nTotalCount = mysqli_num_rows($result);
?>
		<div id="container" class="gnb_member">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>매일발송내역</h2>
					<div class="menus">
						<ul class="first">
							<? include "./email_menu.php"; ?>
							
						</ul>
					</div>
				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents" class="email_container email_container04">
				
				<form name="search" id="search">
					<header id="">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable01 email_form01" style="table-layout:fixed;">
							<colgroup>
								<col width="130px">
								<col width="*">
								<col width="130px">
								<col width="*">
							</colgroup>
							<tbody>
								<tr>
									
									<td class="label">발송일시</td>
									<td class="inbox" colspan="3">
										<div class="contact_btn_box">
											<div>
												<button type="button" rel="<?=date('Y-m-d', strtotime('-1 week'));?>" class="contact_btn" title="week">1주일</button>
												<button type="button" rel="<?=date('Y-m-d', strtotime('-1 month'));?>" class="contact_btn" title="1month">1개월</button>
												<button type="button" rel="<?=date('Y-m-d', strtotime('-3 month'));?>" class="contact_btn" title="3month">3개월</button>
												<input type="text" name="s_date" id="s_date" value="<?=$s_date?>" class="date_form" readonly style="width:100px;" ><span>~</span><input type="text" name="e_date" id="e_date" value="<?=$e_date?>" class="date_form" readonly style="width:100px;" >
											</div>
										</div>
									</td>
								</tr>	
								<tr>
									<td class="label">메일제목</td>
									<td class="inbox" colspan="3"><input type="text" name="title" value="<?=$title?>" style="width:100%;"></td>
								</tr>
							</tbody>
						</table>
						
					</header><!-- // headerContents -->
					<div style="text-align:center;margin-bottom:10px;">
						<button type="submit" class="btn_save03">조회</button>
					</div>


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
					<div class="listBottom">
						<table cellpadding="0" cellspacing="0" style="table-layout:fixed;" summary="" class="listTable">
						<caption></caption>
						<colgroup>
						<col width="150px;" />
						<col width="30%" />
						<col width="*" />
						<col width="150px;" />
						</colgroup>
						<thead>
							<tr>
								<th>번호</th>
								<th>제목</th>
								<th>수신</th>
								<th>발송일시</th>
							</tr>
						</thead>	
						<tbody>

						<?
							$nPage = ceil($nTotalCount / $g_list_rows);
							if ($pg == "") $pg = 1;
							$nFrom = ($pg - 1) * $g_list_rows;

							$sql    = $total_sql . " order by idx desc limit $nFrom, $g_list_rows ";	//페이징 제거
							//$sql    = $total_sql . " order by idx desc  ";
							$result = mysqli_query($connect, $sql) or die (mysql_error());
							$num = $nTotalCount - $nFrom;
							
						
							
							if ($nTotalCount == 0) {
						?>
							<tr>
								<td colspan="4" style="text-align:center;height:100px">검색된 결과가 없습니다.</td>
							</tr>


						<?
							}
							while($row = mysqli_fetch_array($result)){
								$row_num = $num--;
						?>

							<tr>
							
								<td><?=$row_num?></td>
								<td><a href="email_send.php?code=<?=$row['code']?>"><?=$row['title']?></a></td>
								<td style="word-break:break-all;"><?=$row['tomail']?></td>
								<td><?=$row['regdate']?></td>
							</tr>

						<?  } ?>

						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

				

					
					<?echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF]."?s_date=$s_date&e_date=$e_date&title=$title&pg=")?>
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
		if ($(".m_idx").is(":checked") == false)
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
			url: "del_deal.php",
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
			url: "del_deal.php",
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

function chg_it(idx, vals){
	
	
		$("#ajax_loader").removeClass("display-none");
        $.ajax({
			url: "chg_deal.php",
			type: "POST",
			data: "idx="+idx+"&vals="+vals,
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


</script>
<script>
$(function() {
	$( ".date_form" ).datepicker({
		showOn: "both",
		dateFormat: 'yy-mm-dd',
		buttonImageOnly: false,
		showButtonPanel: false,
		changeMonth: false, // 월을 바꿀수 있는 셀렉트 박스를 표시한다.
		changeYear: false, // 년을 바꿀수 있는 셀렉트 박스를 표시한다.
		dayNames: ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'],
		dayNamesMin: ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT']
	});
});


$(document).ready(function(){

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

	$("#chk_all_order_item_state").click(function(){
		var chk_bool = $(this).prop("checked");
		
		$(".state_chker").each(function(){
			$(this).prop("checked", chk_bool);
		});


	});
});
	

</script>


<? include "../_include/_footer.php"; ?>