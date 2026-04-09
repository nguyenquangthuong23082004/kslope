<? include "../_include/_header.php"; 
	$g_list_rows = 10;
	$s_cate		= updateSQ($s_cate);
	$s_status	= updateSQ($s_status);
	$strSql = "";
	if ($s_cate)
	{
		$strSql = $strSql." and cate = '".$s_cate."' ";
	}
	if ($s_status)
	{
		$strSql = $strSql." and status = '".$s_status."' ";
	}
	if ($search_name)
	{
		if ($search_category) {
			$strSql = $strSql." and ".$search_category." like '%".$search_name."%' ";
		} else {
			$strSql = $strSql." and (title like '%".$search_name."%' or contents like '%".$search_name."%' or user_name like '%".$search_name."%') ";
		}
	}
	echo $strSql;
	if ($pg == "") $pg = 1;
	$sql    = "select ifnull(count(*),0) as cnt
				from ".TBL_ALLIANCE." where 1=1 $strSql";

	$result = mysql_query($sql) or die (mysql_error());
	$row=mysql_fetch_array($result);
	$nTotalCount = $row[cnt];
?>

<div id="container"> <span id="print_this"><!-- 인쇄영역 시작 //-->
	
	<header id="headerContainer">
		<div class="inner">
			<h2>제휴/광고 문의</h2>
			<div class="menus">
				<ul class="first">
					<li><a href="javascript:CheckAll(document.getElementsByName('ta_idx[]'), true)" class="btn btn-success">전체선택</a></li>
					<li><a href="javascript:CheckAll(document.getElementsByName('ta_idx[]'), false)" class="btn btn-success">선택해체</a></li>
					<li><a href="javascript:del_it()" class="btn btn-danger">선택삭제</a></li>
				</ul>
				<ul class="last">
					<li><a href="#"  onClick="pp();" style='cursor:pointer; cursor:hand;' class="btn btn-default"><span class="glyphicon glyphicon-print"></span><span class="txt">인쇄</span></a></li>
				</ul>
			</div>
		</div>
		<!-- // inner --> 
		
	</header>
	<!-- // headerContainer -->
	
	<div id="contents">
		<form name="search" id="search">
		<header id="headerContents">
			<p>
				<input type="radio" name="search_category" value="" <? if ($search_category == "") {echo "checked";} ?>>
				전체  &nbsp; &nbsp;
				<input type="radio" name="search_category" value="title" <? if ($search_category == "title") {echo "checked";} ?>>
				제목  &nbsp; &nbsp;
				<input type="radio" name="search_category" value="contents" <? if ($search_category == "contents") {echo "checked";} ?>>
				내용  &nbsp; &nbsp;
				<input type="radio" name="search_category" value="user_name" <? if ($search_category == "user_name") {echo "checked";} ?>>
				작성자 &nbsp; &nbsp;
				<select id="" name="s_cate" class="input_select">
					<option value="" >전체</option>
					<option value="C" <? if ($s_cate == "C") {echo "selected"; } ?>>제휴 문의</option>
					<option value="A" <? if ($s_cate == "A") {echo "selected"; } ?>>광고 문의</option>
					<option value="E" <? if ($s_cate == "E") {echo "selected"; } ?>>기타</option>
				</select>
				<select id="" name="s_status" class="input_select">
					<option value="" selected="selected">전체</option>
					<option value="W" <? if ($s_status == "W") {echo "selected"; } ?>>확인중 (대기)</option>
					<option value="Y" <? if ($s_status == "Y") {echo "selected"; } ?>>답변 완료</option>
					<option value="N" <? if ($s_status == "N") {echo "selected"; } ?>>보류</option>
				</select>
				<input type="text" id="" name="search_name" value="<?=$search_name?>" class="input_txt placeHolder" rel="검색어 입력" style="width:240px" />
				<a href="javascript:search_it();" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> <span class="txt">검색하기</span></a> </p>
		</header>
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
		<!-- // headerContents -->
		
		<div class="listWrap">
		<form name="frm" id="frm">
			<div class="listTop">
				<div class="left">
					<p class="schTxt">■ 총 <?=$nTotalCount?>개의 목록이 있습니다.</p>
				</div>
				<div class="right">
					<ul>
						<li <? if ($s_cate == "") { ?>class="on" <? } ?>><a href="propose_list.php">전체</a></li>
						<li <? if ($s_cate == "C") { ?>class="on" <? } ?>><a href="propose_list.php?s_cate=C">제휴 문의</a></li>
						<li <? if ($s_cate == "A") { ?>class="on" <? } ?>><a href="propose_list.php?s_cate=A">광고 문의</a></li>
						<li <? if ($s_cate == "E") { ?>class="on" <? } ?>><a href="propose_list.php?s_cate=E">기타</a></li>
					</ul>
				</div>
			</div>
			<!-- // listTop -->
			
			<div class="listBottom">
				<table cellpadding="0" cellspacing="0" summary="" class="listTable schedule">
					<caption>
					</caption>
					<colgroup>
					<col width="5%" />
					<col width="5%" />
					<col width="5%" />
					<col width="*" />
					<col width="10%" />
					<col width="15%" />
					<col width="8%" />
					<col width="10%" />
					<col width="8%" />
					<col width="5%" />
					</colgroup>
					<thead>
						<tr>
							<th>선택</th>
							<th>번호</th>
							<th>구분</th>
							<th>제목</th>
							<th>작성자</th>
							<th>이메일</th>
							<th>연락처</th>
							<th>작성일</th>
							<th>확인</th>
							<th>관리</th>
						</tr>
					</thead>
					<tbody>
						<?

							$nPage = ceil($nTotalCount / $g_list_rows);
							$nFrom = ($pg - 1) * $g_list_rows;

							$sql    = "select *
										from ".TBL_ALLIANCE." where 1=1 $strSql order by ta_idx desc limit $nFrom, $g_list_rows ";
							$result = mysql_query($sql) or die (mysql_error());
							$num = $nTotalCount - $nFrom;
							while($row=mysql_fetch_array($result)) 
							{
								$cateStr = "";
								if ($row[cate] == "C") {
									$cateStr = "제휴";
								} elseif ($row[cate] == "A") {
									$cateStr = "광고";
								} elseif ($row[cate] == "E") {
									$cateStr = "기타";
								}

								$statusStr = "";
								if ($row[status] == "W") {
									$statusStr = "확인중(대기) ";
								} elseif ($row[status] == "Y") {
									$statusStr = "답변완료 ";
								} elseif ($row[status] == "N") {
									$statusStr = "보류 ";
								}
						?>
						<tr>
							<td><input type="checkbox" id="" name="ta_idx[]" value="<?=$row[ta_idx]?>" class="ta_idx input_check" /></td>
							<td><?=$num--?></td>
							<td><?=$cateStr?></td>
							<td class="tal bold txt_black"><a href="propose_write.php?search_category=<?=$search_category?>&s_cate=<?=$s_cate?>&s_status=<?=$s_status?>&search_name=<?=$search_name?>&ta_idx=<?=$row[ta_idx]?>"><?=$row[title]?></a></td>
							<td class="bold"><?=$row[user_name]?></td>
							<td><?=$row[user_email]?></td>
							<td><?=$row[phone]?></td>
							<td><?=$row[r_date]?></td>
							<td>
								<select name="status" onchange="javascrpit:chk_status('<?=$row[ta_idx]?>', this.value);" class="input_select">
									<option value="W" <? if ($row[status] == "W") {echo "selected"; } ?>>확인중(대기)</option>
									<option value="Y" <? if ($row[status] == "Y") {echo "selected"; } ?>>답변완료</option>
									<option value="N" <? if ($row[status] == "N") {echo "selected"; } ?>>보류</option>
								</select>
							</td>
							<td><a href="propose_write.php?search_category=<?=$search_category?>&s_cate=<?=$s_cate?>&s_status=<?=$s_status?>&search_name=<?=$search_name?>&ta_idx=<?=$row[ta_idx]?>"><img src="/AdmMaster/_images/common/ico_setting2.png" alt="설정" /></a> &nbsp; <a href="javascript:del_chk(<?=$row[ta_idx]?>)"><img src="/AdmMaster/_images/common/ico_error.png" alt="에러" /></a></td>
						</tr>
						<? } ?>
					</tbody>
				</table>
			</div>
			<!-- // listBottom -->
			
			<?echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF]."?s_status=$s_status&search_category=$search_category&search_name=$search_name&pg=")?>
			<div id="headerContainer">
				<div class="inner">
					<h2>제휴/광고 문의</h2>
					<div class="menus">
						<ul class="first">
							<li><a href="javascript:CheckAll(document.getElementsByName('ta_idx[]'), true)" class="btn btn-success">전체선택</a></li>
							<li><a href="javascript:CheckAll(document.getElementsByName('ta_idx[]'), false)" class="btn btn-success">선택해체</a></li>
							<li><a href="javascript:del_it()" class="btn btn-danger">선택삭제</a></li>
						</ul>
						<ul class="last">
							<li><a href="#"  onClick="pp();" style='cursor:pointer; cursor:hand;' class="btn btn-default"><span class="glyphicon glyphicon-print"></span><span class="txt">인쇄</span></a></li>
						</ul>
					</div>
				</div>
				<!-- // inner --> 
				
			</div>
		</div>
		</form>
		<!-- // listWrap --> 
		
	</div>
	<!-- // contents --> 
	
	</span><!-- 인쇄 영역 끝 //--> 
</div>
<!-- // container --> 

<script>
function chk_status(ta_idx, status)
{
	$.ajax({
		url: "/AdmMaster/ajax/alliance_status.ajax.php",
		type: "POST",
		data: "ta_idx[]="+ta_idx+"&status="+status,
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
<script>


	function del_it()
	{
		if ($(".ta_idx").is(":checked") == false)
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
			url: "/AdmMaster/ajax/alliance_list_del.ajax.php",
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

	function del_chk(ta_idx)
	{
		if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false)
		{
			return;
		}
		$.ajax({
			url: "/AdmMaster/ajax/alliance_list_del.ajax.php",
			type: "POST",
			data: "ta_idx[]="+ta_idx,
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
</script>
<? include "../_include/_footer.php"; ?>
