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
					<h2>자동SMS설정</h2>

				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents" class="sms_container sms_container01">
				<form name="search" id="search">		
				<input type="hidden" name="gubun" value="<?=$gubun?>">
					<header>
						<div>		
							<div>
								<button type="button">+ 신규등록</button>
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

				<div class="listWrap sms_container01">
					<!-- 안내 문구 필요시 구성 //-->

					<form name="frm" id="frm">				
					<div class="listBottom">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable">
						<caption></caption>
						<colgroup>
						<col width="10%" />
						<col width="10%" />
						<col width="70%" />
						<col width="10%" />
						</colgroup>
						<thead>
							<tr>
								<th>코드</th>
								<th>SMS명</th>
								<th>SMS내용</th>
								<th>자동발송여부</th>
							</tr>
						</thead>	
						<tbody>
							<tr>
								<td>I_LOVE_IU</td>
								<td><a href="javascript:void(0)" class="show_under_tr">미입금 7일경과</a></td>
								<td>
									[본토] 고객님의 주문건(주문번호)이 입금기한 만료로 주문취소 처리되었습니다. 감사합니다.
								</td>
								<td>자동발송안함</td>
							</tr>
							<tr class="under_tr" style="display:none;">
								<td><input type="text"></td>
								<td><input type="text"></td>
								<td>
									<textarea name="" id="" cols="30" rows="10"></textarea>
									<div>
										<a href="javascript:search_it()" class="btn btn-default"><span class="txt">저장</span></a>

										<a href="javascript:void(0)" class="btn btn-default btn_sms01"><span class="txt">취소</span></a>
									</div>
								</td>
								<td><input type="radio">자동발송 <input type="radio">자동발송안함</td>
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
	$(document).ready(function(){
		$('.show_under_tr').on('click',function(){
			var $Show_tr = $(this).parents('tr').next('.under_tr');
			$Show_tr.attr('style','display:""');
		});
		$('.btn_sms01').on('click',function(){
			$Hide_tr = $(this).parents('tr');
			$Hide_tr.attr('style',"display:none");
		});
	});
</script>
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