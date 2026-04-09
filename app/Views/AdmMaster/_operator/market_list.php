<? include "../_include/_header.php"; ?>
<?
	$g_list_rows = 10;
	$total_sql = " select * from tbl_market where 1=1 ";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$nTotalCount = mysqli_num_rows($result);
?>
		<div id="container" class="gnb_operator">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>매장관리</h2>
					<div class="menus">
						<ul class="first">
							<li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), true)" class="btn btn-success">전체선택</a></li>
							<li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), false)" class="btn btn-success">선택해체</a></li>
							<li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li>
						</ul>

						<ul class="last">
							<li><a href="market_write.php" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span class="txt">등록</span></a></li>
						</ul>
						
					</div>

				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents">
				<form name="search" id="search">				
				<header id="headerContents">
						
						<select id="" name="search_category" class="input_select" style="width:112px">
							<option value="" >전체</option>
							<option value="P_SUBJECT" <? if ($search_category == "P_SUBJECT") {echo "selected"; } ?>>제목</option>
							<option value="P_CONTENT" <? if ($search_category == "P_CONTENT") {echo "selected"; } ?>>내용</option>
						</select>


						<input type="text" id="" name="search_name" value="<?=$search_name?>" class="input_txt placeHolder" rel="검색어 입력" style="width:240px" />

						<a href="javascript:search_it()" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> <span class="txt">검색하기</span></a>
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
					
					<div class="listTop">
						<div class="left">
							<p class="schTxt">■ 총 <?=$nTotalCount?>개의 목록이 있습니다.</p>
						</div>

					</div><!-- // listTop -->
					
					
					



					<form name="frm" id="frm">				
					<div class="listBottom">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable">
						<caption></caption>
						<colgroup>
						<col width="4%" />
						<col width="4%" />
						<col width="10%" />
						<col width="12%" />
						<col width="*" />
						<col width="12%" />
						<col width="15%" />
						<col width="7%" />
						</colgroup>
						<thead>
							<tr>
								<th>선택</th>
								<th>번호</th>
								<th>사용여부</th>
								<th>지점명</th>
								<th>주소</th>	
								<th>연락처</th>	
								<th>메일주소</th>
								<th>관리</th>
							</tr>
						</thead>	
						<tbody>
							<?
								$nPage = ceil($nTotalCount / $g_list_rows);
								if ($pg == "") $pg = 1;
								$nFrom = ($pg - 1) * $g_list_rows;

								$sql    = $total_sql . " order by m_idx desc limit $nFrom, $g_list_rows ";
								$result = mysqli_query($connect, $sql) or die (mysql_error());
								$num = $nTotalCount - $nFrom;
								while($row=mysqli_fetch_array($result)){
							?>
							<tr>
								<td><input type="checkbox" name="idx[]" class="idx" value="<?=$row['m_idx']?>"  class="input_check"/></td>
								<td><?=$num--?></td>
								<td>
									<select name="status" onchange="javascrpit:chk_status('<?=$row['m_idx']?>', this.value);" class="input_select">
										<option value="Y"  <? if ($row['status'] == "Y") {echo "selected"; } ?>>사용</option>
										<option value="N"  <? if ($row['status'] == "N") {echo "selected"; } ?>>사용안함</option>
									</select>
								</td>

								<td ><a href="./market_write.php?idx=<?=$row['m_idx']?>"><?=$row['shop_name']?></a></td>
								<td>(<?=$row['zip']?>) <?=$row['addr1']?> <?=$row['addr2']?></td>
								
								<td><?=$row['phone']?></td>
								<td><?=$row['email']?></td>

								<td>
									<a href="./market_write.php?idx=<?=$row['m_idx']?>"><img src="/AdmMaster/_images/common/ico_setting2.png" alt="설정" /></a> 
									<a href="javascript:del_it('<?=$row['m_idx']?>');"><img src="/AdmMaster/_images/common/ico_error.png" alt="에러" /></a></td>
							</tr>
							<?  } ?>




							
						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

					<?echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF]."?s_status=$s_status&search_category=$search_category&search_name=$search_name&pg=")?>


					<div id="headerContainer">
						
						<div class="inner">
							<div class="menus">
								<ul class="first">
									<li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), true)" class="btn btn-success">전체선택</a></li>
									<li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), false)" class="btn btn-success">선택해체</a></li>
									<li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li>
								</ul>

								<ul class="last">
									<li><a href="market_write.php" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span class="txt">등록</span></a></li>
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
			url: "market_del.php",
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
					setTimeout(function() {
						location.reload();
					}, 1000);
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
			url: "market_del.php",
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
					setTimeout(function() {
						location.reload();
					}, 1000);
					return;
				} else {
					alert(response);
					alert_("오류가 발생하였습니다!!");
					return;
				}
			}
        });
 
}

function chk_status(idx, status)
{
	
	$.ajax({
		url: "market_status.ajax.php",
		type: "POST",
		data: "idx[]="+idx+"&status="+status,
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
				alert_("정상적으로 현황이 변경되었습니다.");
				setTimeout(function() {
					location.reload();
				}, 1000);
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


<? include "../_include/_footer.php"; ?>