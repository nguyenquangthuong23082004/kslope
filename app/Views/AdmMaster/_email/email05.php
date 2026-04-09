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
					<h2>단체메일 디자인/발송</h2>
					
				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents" class="email_container email_container05">
				<form name="search" id="search">		
				<input type="hidden" name="gubun" value="<?=$gubun?>">
					<header>
						<div>
							<button type="button">+ 신규등록</button>
							<div>
								<select name="" id="">
									<option value="">메일제목</option>
								</select>
								<input type="text">
								<a href="javascript:search_it()" class="btn btn-default btn_email03"><span class="glyphicon glyphicon-search"></span> <span class="txt">검색</span></a>

								<a href="javascript:search_it()" class="btn btn-default btn_email03"><span class="txt">목록</span></a>
							</div>
						</div>
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

				<div class="listWrap email_container05">
					<!-- 안내 문구 필요시 구성 //-->

					<form name="frm" id="frm">				
					<div class="listBottom">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable">
						<caption></caption>
						<colgroup>
						<col width="5%" />
						<col width="40%" />
						<col width="8%" />
						<col width="8%" />
						<col width="8%" />
						<col width="10%" />
						<col width="10%" />
						</colgroup>
						<thead>
							<tr>
								<th>EDIT</th>
								<th>제목</th>
								<th>예약일시</th>
								<th>발송구분</th>
								<th>발송현황</th>
								<th>상태</th>
								<th>읽음/발송수</th>
								<th>등록일시</th>
							</tr>
						</thead>	
						<tbody>
							<tr>
								<td><a href="email05_view.php">EDIT</a></td>
								<td>[메일테스트] 테스트입니다.</td>
								<td>
									<p>2015-10-29</p>
									<p>(22:55)</p>
								</td>
								<td>수신동의</td>
								<td>WAIT</td>
								<td>사용</td>
								<td>0명/0명</td>
								<td>2015-10-29(23:05)</td>
							</tr>
						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

					<?echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF]."?s_status=$s_status&search_category=$search_category&search_name=$search_name&pg=")?>


					
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