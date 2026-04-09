<? include "../_include/_header.php"; ?>
<?
	$g_list_rows = 10;
	if ($search_name)
	{
		$strSql = $strSql." and replace(".$search_category.",'-','') like '%".str_replace("-","",$search_name)."%' ";
	}

	if ($s_status == "") {
		$s_status = "Y";
	}


	
	$total_sql = " select d.*, g.goods_name_front
	                 from tbl_counsel_deal d 
					 left outer join tbl_goods g
					   on d.sel_goods = g.g_idx
					where 1=1 $strSql ";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$nTotalCount = mysqli_num_rows($result);
?>
		<div id="container">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>개별메일발송</h2>

				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents email_container email_container03">
				<form name="search" id="search">		
				<input type="hidden" name="gubun" value="<?=$gubun?>">
					<header id="">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable01 email_form01" style="table-layout:fixed;">
							<colgroup>
								<col width="130px">
								<col width="*">
							</colgroup>
							<tbody>
								<tr>
									<td class="label">회원등급</td>
									<td class="inbox">
										<select name="" id="">
											<option value="">전체</option>
											<option value="">일반회원</option>
										</select>
										<select name="" id="">
											<option value="">전체</option>
											<option value="">수신동의</option>
											<option value="">수신거부</option>
										</select>
										<select name="" id="">
											<option value="">회원명</option>
											<option value="">회원아이디</option>
											<option value="">휴드폰</option>
										</select>
										<input type="text">
										<a href="javascript:search_it()" class="btn btn-default btn_email03"><span class="glyphicon glyphicon-search"></span> <span class="txt">검색</span></a>
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

				<div class="listWrap sms_container sms_container03">
					<!-- 안내 문구 필요시 구성 //-->
		
					<div class="listTop">
						<div class="left">
							<p class="schTxt"> 총 <?=$nTotalCount?>명 발송대상</p>
						</div>

					</div><!-- // listTop -->
					
					<form name="frm" id="frm">				
					<div class="listBottom email01">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable">
						<caption></caption>
						<colgroup>
						<col width="5%" />
						<col width="5%" />
						<col width="5%" />
						<col width="5%" />
						<col width="5%" />
						<col width="5%" />
						<col width="5%" />
						<col width="5%" />
						<col width="30%" />
						<col width="15%" />
						<col width="5%" />
						<col width="5%" />
						<col width="*" />
						</colgroup>
						<thead>
							<tr>
								<th><button type="button">전체</button></th>
								<th>번호</th>
								<th>등급</th>
								<th>아이디</th>
								<th>성명</th>
								<th>성별</th>
								<th>연령</th>
								<th>접속수</th>
								<th>최근접속일</th>
								<th>가입일</th>
								<th>적립금</th>
								<th>총구매금액</th>				
								<th>SMS수신</th>				
							</tr>
						</thead>	
						<tbody>
							<tr>
								<td><input type="checkbox"></td>
								<td>35883</td>
								<td>USER</td>
								<td>test01</td>
								<td>배금희</td>
								<td>여</td>
								<td>41</td>
								<td>3</td>
								<td>2018-04-26 17:23:16</td>
								<td>2018-04-26</td>
								<td>-</td>
								<td>-</td>
								<td>거부</td>
							</tr>

							
						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

					<div id="headerContainer">
						
						<div class="inner">		
								<button type="button" class="btn_save02">선택한 회원 추가</button>

						</div><!-- // inner -->

					</div><!-- // headerContainer -->
					<div class="listBottom sms03">
					<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail">
						<caption></caption>
						<colgroup>
							<col width="150px">
							<col width="*">
						</colgroup>

						<tbody>
							<tr style="height:45px;">
								<th>수신대상</th>
								<td>0 명</td>
							</tr>
							<tr style="height:45px;">
								<th>수신번호<br>(직접입력)</th>
								<td><textarea name="" id="" cols="30" rows="10"></textarea></td>
							</tr>
							<tr style="height:45px;">
								<th>발신자</th>
								<td><input type="text"></td>
							</tr>
							<tr style="height:45px;">
								<th>발신자</th>
								<td><input type="text"></td>
							</tr>
							<tr style="height:45px;">
								<th>메일제목</th>
								<td><input type="text"></td>
							</tr>
							<tr>
								<th>내용</th>
								<td><textarea name="" id="" cols="30" rows="10"></textarea></td>
							</tr>
						</tbody>
					</table>
					<div>
						<button type="button" class="btn_save03">발송하기</button>
					</div>
				</div>
				<!-- // listBottom -->
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

<? include "../_include/_footer.php"; ?>