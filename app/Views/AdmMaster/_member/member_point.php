<? include "../_include/_header.php"; ?>
<?
	$g_list_rows = 10;


	if ($search_name)
	{
		if($search_category=="user_id"){
			$strSql = $strSql." and ".$search_category." like '%".str_replace("-","",$search_name)."%' ";
		}else if($search_category=="user_name"){
			$strSql = $strSql." and user_id in (select user_id from tbl_member where user_name like '%".$search_name."%') ";

		}
	}

	
	$total_sql = " select *
						from tbl_point
						where user_id !='' $strSql ";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$nTotalCount = mysqli_num_rows($result);
?>
		<div id="container" class="gnb_member">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>회원 적립금 관리</h2>
					<div class="menus">
						<ul class="first">
							<li><a href="javascript:CheckAll(document.getElementsByName('m_idx[]'), true)" class="btn btn-success">전체선택</a></li>
							<li><a href="javascript:CheckAll(document.getElementsByName('m_idx[]'), false)" class="btn btn-success">선택해체</a></li>
							<li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li>
						</ul>

						<ul class="last">
							<li><a href="member_point_write.php" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span class="txt">등록</span></a></li>
						</ul>
						
					</div>

				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents">
				<form name="search" id="search">		
				<input type="hidden" name="gubun" value="<?=$gubun?>">
				<header id="headerContents">
						<select id="" name="search_category" class="input_select" style="width:112px">
							<option value="user_id" <? if ($search_category == "user_id") {echo "selected"; } ?>>아이디</option>
							<option value="user_name" <? if ($search_category == "user_name") {echo "selected"; } ?>>이름</option>
							<!--
							<option value="user_email" <? if ($search_category == "user_email") {echo "selected"; } ?>>이메일</option>
							<option value="user_phone" <? if ($search_category == "user_phone") {echo "selected"; } ?>>연락처</option>
							-->
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
							<col width="50px" />
							<col width="60px" />
							<col width="150px" />
							<col width="150px" />
							<col width="*" />
							<col width="150px" />
							<col width="150px" />
							<col width="150px" />
							<!--
							<col width="150px" />
							-->
							<col width="150px" />
						</colgroup>
						<thead>
							<tr>
								<th>선택</th>
								<th>번호</th>
								<th>아이디</th>
								<th>이름</th>
								<th>지급사유</th>	
								<th>적용포인트</th>
								<th>누적포인트</th>
								<th>최종적용일</th>
								<!--
								<th>소멸일자</th>
								-->
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
								
								$_genderArr['M'] = "남";
								$_genderArr['W'] = "여";
								
								if ($nTotalCount == 0) {
							?>
							<tr>
								<td colspan=10 style="text-align:center;height:100px">검색된 결과가 없습니다.</td>
							</tr>
							<?
								}
								while($row=mysqli_fetch_array($result)){
									$tr_color = "";
									
									/* 포인트 만료 없음
									if ($row["enddate"] > 0 && $row["enddate"] <= date('Y-m-d')){
										$tr_color = " background:#c9302c8c; ";
									}
									*/

									// 이름가져오기

									
							?>
							<tr style="height:50px; <?=$tr_color?> ">
								<td><input type="checkbox" name="m_idx[]" class="m_idx" value="<?=$row[idx]?>"  class="input_check"/></td>
								<td><?=$num--?></td>
								<td class="tac"><?=$row["user_id"]?></td>
								<td class="tac"><?=chk_member_col($row["user_id"],"user_name")?></td>
								<td class="tac"><?=$row["msg"]?></td>
								<td class="tac"><?=$row["point"]?></td>
								<td class="tac"><?=number_format(accPoint($row["user_id"],$row["idx"]))?></td>
								<td class="tac"><?=$row["regdate"]?></td>
								<!--
								<td class="tac"><?=$row["enddate"]?></td>
								-->
								<td>
									<a href="member_point_write.php?idx=<?=$row['idx']?>"><img src="/AdmMaster/_images/common/ico_setting2.png"></a>
									<a href="javascript:del_it('<?=$row['idx']?>');"><img src="/AdmMaster/_images/common/ico_error.png" alt="에러" /></a>
								</td>
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
									<li><a href="javascript:CheckAll(document.getElementsByName('m_idx[]'), true)" class="btn btn-success">전체선택</a></li>
									<li><a href="javascript:CheckAll(document.getElementsByName('m_idx[]'), false)" class="btn btn-success">선택해체</a></li>
									<li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li>
								</ul>

								<ul class="last">
									<li><a href="member_point_write.php" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span class="txt">등록</span></a></li>
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
			url: "point_del.php",
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

function del_it(m_idx) {


		if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false)
		{
			return;
		}
		$("#ajax_loader").removeClass("display-none");
        $.ajax({
			url: "./point_del.php",
			type: "POST",
			data: "m_idx[]="+m_idx,
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


</script>


<? include "../_include/_footer.php"; ?>