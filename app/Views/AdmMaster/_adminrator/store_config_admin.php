<? include "../_include/_header.php"; ?>
<link rel="stylesheet" href="/AdmMaster/_common/css/sms_contents.css" type="text/css" />
<div class="page-heading mb-4">
    
    <div class="d-flex justify-content-between align-items-center">
        <header class="d-block d-xl-none pb-2">
            <a href="#" class="d-block burger-btn d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <h4 class="text-center">직원 리스트</h4>
    </div>
</div>
<div id="container" class="gnb_setting">

<?
	$g_list_rows = 20;
	if ($search_name)
	{
		$strSql = $strSql." and replace(".$search_category.",'-','') like '%".str_replace("-","",$search_name)."%' ";
	}


	$total_sql = " select *		
						from tbl_member where user_level = 2 $strSql ";
	
	//echo $total_sql;
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$nTotalCount = mysqli_num_rows($result);
?>

		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<div class="menus">
						<ul class="first">
							<li><a href="javascript:CheckAll(document.getElementsByName('m_idx[]'), true)" class="btn btn-success">전체선택</a></li>
							<li><a href="javascript:CheckAll(document.getElementsByName('m_idx[]'), false)" class="btn btn-success">선택해체</a></li>
							<li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li>
						</ul>

						<ul class="last">
							<li><a href="write.php" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span class="txt">직원 등록</span></a></li>
						</ul>
						
					</div>

				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents">
				<div class="listWrap">
					<!-- 안내 문구 필요시 구성 //-->

				
				
		

					
					<div class="listTop d-flex justify-content-between mb-4">
						<div class="left">
							<p class="schTxt">■ 총 <?=number_format($nTotalCount)?>개의 목록이 있습니다.</p>
						</div>
						<form name="search" id="search">		
							<input type="hidden" name="gubun" value="">
							<header id="headerContents" class="r_box d-flex" style="gap: 10px;">
								<select id="" name="search_category" class="form-select input_select">
									<option value="user_name" <? if ($search_category == "user_name") {echo "selected"; } ?>>직원성명</option>
									<option value="user_mobile" <? if ($search_category == "user_mobile") {echo "selected"; } ?>>연락처</option>
								</select>

								<div class="input-group" style="flex-wrap: nowrap">
									<input type="text" id="search_name" name="search_name" value="<?=$search_name?>" class="form-control placeHolder" placeholder="검색어 입력" style="width:240px"/>
									<!-- <input type="text" class="form-control" name="search_txt" placeholder="Search" aria-label="Search" value=""> -->
									<button class="btn btn-light" onclick="search_it()"><i class="bi bi-search"></i></button>
								</div>
								<!-- <input type="text" id="" name="search_name" value="<?=$search_name?>" class="input_txt placeHolder" rel="검색어 입력" style="width:240px">

								<a href="javascript:search_it()" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> <span class="txt">검색하기</span></a> -->
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

					</div><!-- // listTop -->
					
					
					



					<form name="frm" id="frm">				
					<div class="listBottom">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable">
						<caption></caption>
						<colgroup>
						<col width="70px">
						<col width="100px">
						<col width="100px">
						<col width="*">
						<col width="150px">
						<col width="150px">
						<col width="150px">
						<!-- <col width="120px"> -->
						<col width="100px">
						</colgroup>
						<thead>
							<tr>
								<th>선택</th>
								<th>번호</th>
								<th>현황</th>
								<th>아이디</th>
								<th>직원명</th>	
								<th>연락처</th>
								<th>가입일시</th>
								<!-- <th>구분</th> -->
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
								
								if ($nTotalCount == 0) {
							?>
							<tr>
								<td colspan=9 style="text-align:center;height:100px">검색된 결과가 없습니다.</td>
							</tr>
							<?
								}
								while($row=mysqli_fetch_array($result)){
									$statusStr = "";
									if ($row["status"] == "Y")
									{
										$statusStr = "이용중";
									} elseif ($row["status"] == "N") {
										$statusStr = "정지중";
									}

									
							?>
							<tr style="height:50px">
								<td><input type="checkbox" name="m_idx[]" class="m_idx" value="<?=$row['m_idx']?>"></td>
								<td><?=$row['m_idx']?></td>
								<td class="tac"><?=$statusStr?></td>
								<td class="tac"><a href="write.php?m_idx=<?=$row['m_idx']?>"><?=$row['user_id']?></a></td>
								<td class="tac"><a href="write.php?m_idx=<?=$row['m_idx']?>"><?=$row['user_name']?></a></td>
								<td class="tac"><?=$row['user_mobile']?></td>
								<!--
								<td class="tal">회원리스트</td>
								-->
								<td class="tac"><?=$row['r_date']?></td>
								<!-- <td class="tac"><?=$row['user_depart']?></td> -->
								<td scope="row" class="text-center">
									<a href="write.php?m_idx=<?=$row['m_idx']?>"
										class="btn btn-primary"><i class="bi bi-pencil"></i></a>
									<a href="javascript:del_it(<?= $row['m_idx'] ?>)" class="btn btn-danger"><i
											class="bi bi-trash"></i></a>
								</td>
								<!-- <td>
									<a href="write.php?m_idx=<?=$row['m_idx']?>"><img src="/AdmMaster/_images/common/ico_setting2.png"></a>
									<a href="javascript:del_it('<?=$row['m_idx']?>');"><img src="/AdmMaster/_images/common/ico_error.png" alt="에러"></a>
								</td> -->
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
									<li><a href="write.php" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span class="txt">직원 등록</span></a></li>
								</ul>
								
							</div>

						</div><!-- // inner -->

					</div><!-- // headerContainer -->
				</div><!-- // listWrap -->

			</div><!-- // contents -->





		</span><!-- 인쇄 영역 끝 //-->
		</div>

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
			url: "del.php",
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
			url: "del.php",
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