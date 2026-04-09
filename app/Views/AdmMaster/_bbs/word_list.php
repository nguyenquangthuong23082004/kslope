<? include "../_include/_header.php"; ?>
<?
		$g_list_rows = 10;
		if ($search_category) {
			$strSql = " and ".$search_category." like '%".$search_name."%'";
		}
		$total_sql = " select *, a.r_date as rdate from tbl_reply a, tbl_member b where a.m_idx=b.m_idx $strSql ";
		$result = mysql_query($total_sql) or die (mysql_error());
		$nTotalCount = mysql_num_rows($result);

		$nPage = ceil($nTotalCount / $g_list_rows);
		if ($pg == "") $pg = 1;
		$nFrom = ($pg - 1) * $g_list_rows;
?>
		<div id="container">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>칭찬한마디</h2>
					<div class="menus">
						<ul class="first">
							<li><a href="javascript:CheckAll(document.getElementsByName('r_idx[]'), true)" class="btn btn-success">전체선택</a></li>
							<li><a href="javascript:CheckAll(document.getElementsByName('r_idx[]'), false)" class="btn btn-success">선택해체</a></li>
							<li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li>
						</ul>
						
					</div>

				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents">
				<form name="search" id="search">				
				<header id="headerContents">
						<select id="" name="search_category" class="input_select" style="width:112px">
							<option value="comment" <? if ($search_category == "comment") {echo "selected"; } ?>>내용</option>
							<option value="user_name" <? if ($search_category == "user_name") {echo "selected"; } ?>>작성자</option>
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
					<!-- 안내 문구 필요시 구성 //-->
					
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
						<col width="*" />						
						<col width="12%" />
						<col width="5%" />
						</colgroup>
						<thead>
							<tr style="height:45px">
								<th>선택</th>
								<th>번호</th>
								<th>작성자</th>
								<th>내용</th>
								<th>등록일</th>	
								<th>관리</th>
							</tr>
						</thead>	
						<tbody>
							<?
							$sql    = $total_sql . " order by a.r_date desc limit $nFrom, $g_list_rows ";
							$result = mysql_query($sql) or die (mysql_error());
							$num = $nTotalCount - $nFrom;
							if ($nTotalCount == 0) {
							?>
							<tr style="height:45px">
								<td colspan=6 style="text-align:center;height:50px">
									등록된 글이 없습니다.
								</td>
							</tr>
							<?
							} else {
							while($row=mysql_fetch_array($result)){

							?>
							<tr style="height:45px">
								<td><input type="checkbox" name="r_idx[]" class="r_idx" value="<?=$row[r_idx]?>"  class="input_check"/></td>
								<td><?=$num--?></td>
								<td><?=$row[user_name]?> (<?=$row[user_id]?>)</td>
								<td class="tal"><?=nl2br($row[comment])?></td>
								<td><?=$row[rdate]?></td>
								<td><a href="javascript:del_it('<?=$row[r_idx]?>');"><img src="/AdmMaster/_images/common/ico_error.png" alt="에러" /></a></td>
							</tr>
							<?  } 
							}
							?>




							
						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

					<?echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF]."?s_status=$s_status&search_category=$search_category&search_name=$search_name&pg=")?>


					<div id="headerContainer">
						
						<div class="inner">
							<div class="menus">
								<ul class="first">
									<li><a href="javascript:CheckAll(document.getElementsByName('r_idx[]'), true)" class="btn btn-success">전체선택</a></li>
									<li><a href="javascript:CheckAll(document.getElementsByName('r_idx[]'), false)" class="btn btn-success">선택해체</a></li>
									<li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li>
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
		if ($(".r_idx").is(":checked") == false)
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
			url: "word_del.php",
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

function del_it(r_idx) {

		if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false)
		{
			return;
		}
		$("#ajax_loader").removeClass("display-none");
        $.ajax({
			url: "word_del.php",
			type: "POST",
			data: "r_idx[]="+r_idx,
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

function chk_status(r_idx, status)
{
	$.ajax({
		url: "/AdmMaster/ajax/popup_status.ajax.php",
		type: "POST",
		data: "r_idx[]="+r_idx+"&status="+status,
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