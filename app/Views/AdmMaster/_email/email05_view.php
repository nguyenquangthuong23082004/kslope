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
					<h2>매일발송내역</h2>

				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents" class="email_container email_container06">
				<form name="search" id="search">		
				<input type="hidden" name="gubun" value="<?=$gubun?>">
					<header id="">
						<div>
							<div>
								<div>
									<input type="text">
									<a href="javascript:search_it()" class="btn btn-default btn_email03"><span class="txt">테스트메일 전송</span></a>
									<a href="javascript:search_it()" class="btn btn-default btn_email03"><span class="txt">미리보기</span></a>

									<a href="javascript:search_it()" class="btn btn-default btn_email03"><span class="txt">저장</span></a>

									<a href="javascript:search_it()" class="btn btn-default btn_email03"><span class="txt">목록</span></a>
								</div>
							</div>
						</div>
						<table cellpadding="0" cellspacing="0" summary="" class="listTable01 email_form01" style="table-layout:fixed;">
							<colgroup>
								<col width="130px">
								<col width="*">
							</colgroup>
							<tbody>
								<tr>
									<td class="label">메일제목</td>
									<td class="lnbox"><input type="text"></td>
								</tr>
								<tr>
									<td class="label">발송대상</td>
									<td class="inbox">
										<select name="" id="">
											<option value="">전체발송</option>
											<option value="">수신동의</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="label">예약일시</td>
									<td class="inbox">
										<select name="" id="">
											<option value="">2018년</option>
											<option value="">2017년</option>
											<option value="">2016년</option>
											<option value="">2015년</option>
											<option value="">2014년</option>
										</select>
										<select name="" id="">
											<option value="">01월</option>
											<option value="">02월</option>
											<option value="">03월</option>
											<option value="">04월</option>
											<option value="">05월</option>
											<option value="">06월</option>
											<option value="">07월</option>
											<option value="">08월</option>
											<option value="">09월</option>
											<option value="">10월</option>
											<option value="">11월</option>
											<option value="">12월</option>
										</select>
										<select name="" id="">
											<option value="">01일</option>
											<option value="">02일</option>
											<option value="">03일</option>
											<option value="">04일</option>
											<option value="">05일</option>
											<option value="">06일</option>
											<option value="">07일</option>
											<option value="">08일</option>
											<option value="">09일</option>
											<option value="">10일</option>
											<option value="">11일</option>
											<option value="">12일</option>
											<option value="">13일</option>
											<option value="">14일</option>
											<option value="">15일</option>
											<option value="">16일</option>
											<option value="">17일</option>
											<option value="">18일</option>
											<option value="">19일</option>
											<option value="">20일</option>
											<option value="">21일</option>
											<option value="">22일</option>
											<option value="">23일</option>
											<option value="">24일</option>
											<option value="">25일</option>
											<option value="">26일</option>
											<option value="">27일</option>
											<option value="">28일</option>
											<option value="">29일</option>
											<option value="">30일</option>
											<option value="">31일</option>
										</select>
										<select name="" id="">
											<option value="">00시</option>
											<option value="">01시</option>
											<option value="">02시</option>
											<option value="">03시</option>
											<option value="">04시</option>
											<option value="">05시</option>
											<option value="">06시</option>
											<option value="">07시</option>
											<option value="">08시</option>
											<option value="">09시</option>
											<option value="">10시</option>
											<option value="">11시</option>
											<option value="">12시</option>
											<option value="">13시</option>
											<option value="">14시</option>
											<option value="">15시</option>
											<option value="">16시</option>
											<option value="">17시</option>
											<option value="">18시</option>
											<option value="">19시</option>
											<option value="">20시</option>
											<option value="">21시</option>
											<option value="">22시</option>
											<option value="">23시</option>
										</select>
										<select name="" id="">
											<option value="">00분</option>	
											<option value="">01분</option>	
											<option value="">02분</option>	
											<option value="">03분</option>	
											<option value="">04분</option>	
											<option value="">05분</option>	
											<option value="">06분</option>	
											<option value="">07분</option>	
											<option value="">08분</option>	
											<option value="">09분</option>	
											<option value="">10분</option>	
											<option value="">11분</option>	
											<option value="">12분</option>	
											<option value="">13분</option>	
											<option value="">14분</option>	
											<option value="">15분</option>	
											<option value="">16분</option>	
											<option value="">17분</option>	
											<option value="">18분</option>	
											<option value="">19분</option>	
											<option value="">20분</option>	
											<option value="">21분</option>	
											<option value="">22분</option>	
											<option value="">23분</option>	
											<option value="">24분</option>	
											<option value="">25분</option>	
											<option value="">26분</option>	
											<option value="">27분</option>	
											<option value="">28분</option>	
											<option value="">29분</option>	
											<option value="">30분</option>	
											<option value="">31분</option>	
											<option value="">32분</option>	
											<option value="">33분</option>	
											<option value="">34분</option>	
											<option value="">35분</option>	
											<option value="">36분</option>	
											<option value="">37분</option>	
											<option value="">38분</option>	
											<option value="">39분</option>	
											<option value="">40분</option>	
											<option value="">41분</option>	
											<option value="">42분</option>	
											<option value="">43분</option>	
											<option value="">44분</option>	
											<option value="">45분</option>	
											<option value="">46분</option>	
											<option value="">47분</option>	
											<option value="">48분</option>	
											<option value="">49분</option>	
											<option value="">50분</option>	
											<option value="">51분</option>	
											<option value="">52분</option>	
											<option value="">53분</option>	
											<option value="">54분</option>	
											<option value="">55분</option>	
											<option value="">56분</option>	
											<option value="">57분</option>	
											<option value="">58분</option>	
											<option value="">59분</option>	
										</select>
									</td>
								</tr>	
								<tr>
									<td class="label">상태설정</td>
									<td class="inbox">
										<select name="" id="">
											<option value="">사용</option>
											<option value="">중지</option>
										</select>
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
					<div class="listBottom email_container06">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable">
						<caption></caption>
						
						<tbody>
							<tr>
								<td><textarea name="" id="" cols="30" rows="10"></textarea></td>
								
							</tr>
						</tbody>
						</table>
						<div style="float:right;">
							<a href="javascript:search_it()" class="btn btn-default btn_email03"><span class="txt">저장</span></a>

							<a href="javascript:search_it()" class="btn btn-default btn_email03"><span class="txt">목록</span></a>
						</div>
					</div><!-- // listBottom -->

						
					</form>
					
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