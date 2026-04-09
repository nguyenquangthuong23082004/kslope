<? include "../_include/_header.php"; ?>
<?

if($sYear == ""){
	$sYear = date("Y");
}

if($sMonth == ""){
	$sMonth = date("n");
}

$sWhere2 = "";
if($sDate != "" && $eDate != ""){
	$sWhere2 = " AND (DATE(regdate) >= '".$sDate."' AND DATE(regdate) <= '".$eDate."')";
}


$total_sql = " 	
	select 
	sum(login_type_P) as login_type_P 
	,sum(login_type_M) as login_type_M 
	,sum(itemCnt_P) as itemCnt_P 
	,sum(itemCnt_M) as itemCnt_M 
	from (
		select 			
			 login_type_P, login_type_M, itemCnt_P, itemCnt_M			
			 from (
			select DATE(regdate) as regdate, login_type_P, login_type_M, itemCnt_P, itemCnt_M  from tbl_login_device 
			where 1=1 
				and YEAR(regdate) = '".$sYear."' 
				and MONTH(regdate) ='".$sMonth."'
			group by DATE(regdate) 
			) t 
	)tt
";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$row = mysqli_fetch_array($result);
	$login_type_P_		= $row[login_type_P];
	$login_type_M_		= $row[login_type_M];
	$itemCnt_P_		= $row[itemCnt_P];
	$itemCnt_M_		= $row[itemCnt_M];
	
	$itemCnt_PM_total = $itemCnt_P_ + $itemCnt_M_;

$sql = " 
		select 
				regdate
				,CASE DAYOFWEEK(regdate) 
						WHEN 1 THEN '일'
						WHEN 2 THEN '월'	
						WHEN 3 THEN '화'
						WHEN 4 THEN '수'
						WHEN 5 THEN '목'
						WHEN 6 THEN '금'
						WHEN 7 THEN '토'
					END AS week	
		, login_type_P, login_type_M, itemCnt_P, itemCnt_M			
		 from (
		select DATE(regdate) as regdate, login_type_P, login_type_M, itemCnt_P, itemCnt_M  from tbl_login_device 
			where 1=1 
				and YEAR(regdate) = '".$sYear."' 
				and MONTH(regdate) ='".$sMonth."'
		group by DATE(regdate) 
		) t order by regdate asc
	";
	$result = mysqli_query($connect, $sql) or die (mysql_error());

?>
		<div id="container" class="gnb_statistics">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>접속통계</h2>
					<div class="menus">
						<ul class="first">
							<li><a href="statistics03_05.php" class="btn btn_email01">요일별</a></li>	
							<li><a href="statistics03_04.php" class="btn btn_email01">IP별 검색</a></li>	
							<li><a href="statistics03_01.php" class="btn btn_email01">접속통계</a></li>	
							<li class="mr_10"><a href="statistics03_02.php" class="btn btn_email01">방문경로 순위</a></li>	
									
							<!-- <li><a href="#!" class="btn btn-success btn_dd01">등록</a></li>	
							<li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), true)" class="btn btn-success">전체선택</a></li>
							<li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), false)" class="btn btn-success">선택해체</a></li>
							<li><a href="javascript:SELECT_DELETE()" class="btn btn-danger btn_dd01">선택삭제</a></li> -->
						</ul>
					</div>
				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents" class="statis03_01">
				<form name="search" id="search">		
				<input type="hidden" name="gubun" value="<?=$gubun?>">
				
				<header id="headerContents" class="statis_floatR">

					<select name="sYear" id="sYear" >
						<?
							$inDate = date("Y");
							for($i = $inDate; $i >= 2015; $i--){
						?>
								<option value="<?=$i?>" <? if($sYear == $i){ echo "selected"; }?>><?=$i?>년</option>
						<?
							}

						?>
						
						
					</select>

					<select name="sMonth" id="sMonth" >
						<option value="1" <? if($sMonth == "1"){ echo "selected"; }?>>01월</option>
						<option value="2" <? if($sMonth == "2"){ echo "selected"; }?>>02월</option>
						<option value="3" <? if($sMonth == "3"){ echo "selected"; }?>>03월</option>
						<option value="4" <? if($sMonth == "4"){ echo "selected"; }?>>04월</option>
						<option value="5" <? if($sMonth == "5"){ echo "selected"; }?>>05월</option>
						<option value="6" <? if($sMonth == "6"){ echo "selected"; }?>>06월</option>
						<option value="7" <? if($sMonth == "7"){ echo "selected"; }?>>07월</option>
						<option value="8" <? if($sMonth == "8"){ echo "selected"; }?>>08월</option>
						<option value="9" <? if($sMonth == "9"){ echo "selected"; }?>>09월</option>
						<option value="10" <? if($sMonth == "10"){ echo "selected"; }?>>10월</option>
						<option value="11" <? if($sMonth == "11"){ echo "selected"; }?>>11월</option>
						<option value="12" <? if($sMonth == "12"){ echo "selected"; }?>>12월</option>
					</select>
				
					<a href="javascript:search_it()" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> <span class="txt">검색하기</span></a>
				</header><!-- // headerContents -->
				</form>
				<script>
				function search_it()
				{
					var frm = document.search;
					frm.submit();
				}
				</script>

				<div class="listWrap statis01">
					<!-- 안내 문구 필요시 구성 //-->

					
					<!--<div class="listTop">
						<div class="left">
							<p class="schTxt">■ 총 </*?=$nTotalCount*/?>개의 목록이 있습니다.</p>
						</div>

					</div><!-- // listTop -->
					

					<form name="frm" id="frm">				
					<div class="listBottom" style="margin-top:-10px;">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable statisTable">
						<caption></caption>
						<colgroup>
						<col width="10%" />
						<col width="10%" />
						<col width="10%" />
						<col width="*" />
						<col width="10%" />
						<col width="10%" />
						<col width="*" />
						</colgroup>
						<thead>
							<tr>
								<th>일자</th>
								<th>PC</th>
								<th>MOBILE</th>
								<th>방문자수(합계)</th>
								<th>PC</th>
								<th>MOBILE</th>
								<th>페이지뷰(합계)</th>
							</tr>
						</thead>	
						<tbody>

							<tr>
								<td>합계</td>
								<td id="login_type_P_Sum"></td>
								<td id="login_type_M_Sum"></td>
								<td id="login_type_PM_Sum"></td>
								<td id="itemCnt_P_Sum"></td>
								<td id="itemCnt_M_Sum"></td>
								<td id="itemCnt_PM_Sum"></td>
							</tr>

<?
						while($row=mysqli_fetch_array($result)){

							$login_type_P = $row["login_type_P"];
							$login_type_M = $row["login_type_M"];
							$itemCnt_P = $row["itemCnt_P"];
							$itemCnt_M = $row["itemCnt_M"];
							
							$total = (($itemCnt_P + $itemCnt_M)/$itemCnt_PM_total * 100);

?>
							<tr>
								<td><?=$row["regdate"]?>(<?=$row["week"]?>)</td>
								<td><?=number_format($login_type_P)?></td>
								<td><?=number_format($login_type_M)?></td>
								<td><?=number_format($login_type_P + $login_type_M)?></td>
								<td><?=number_format($itemCnt_P)?></td>
								<td><?=number_format($itemCnt_M)?></td>
								<td>
									<div data-percent="<?=round($total,3)?>%" class="graph01"></div>
									<span><?=round($total,2)?>%</span>	
								</td>
							</tr>
<?
							$login_type_P_Sum = $login_type_P_Sum + $login_type_P;
							$login_type_M_Sum = $login_type_M_Sum + $login_type_M;
							$itemCnt_P_Sum = $itemCnt_P_Sum + $itemCnt_P;
							$itemCnt_M_Sum = $itemCnt_M_Sum + $itemCnt_M;							
						}
?>


						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>
					<script>
						$(document).ready(function(){
							$('.graph01').each(function(){
								
								var $Width = $(this).attr('data-percent')
									//alert($Width)
								$(this).css({'width':$Width});
							});
						});
					</script>
			

					<div id="headerContainer">
						
						<div class="">
							<div class="menus">
								<!-- <ul class="first">
									<li><a href="#!" class="btn btn-success btn_dd01">등록</a></li>	
									<li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), true)" class="btn btn-success">전체선택</a></li>
									<li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), false)" class="btn btn-success">선택해체</a></li>
									<li><a href="javascript:SELECT_DELETE()" class="btn btn-danger btn_dd01">선택삭제</a></li>
								</ul> -->

							</div>

						</div><!-- // inner -->

					</div><!-- // headerContainer -->
				</div><!-- // listWrap -->

			</div><!-- // contents -->





		</span><!-- 인쇄 영역 끝 //-->
		</div><!-- // container -->
		<div class="preview_popup">
			<div class="popup_box">
				aaaaa
				<a href="javascript:void(0)" class="close_popup">CLOSE</a>
			</div>
			
		</div>
		<script>
			$(document).ready(function(){
				$('.btn_preview').on('click',function(){
					$('.preview_popup').css({'display':'block'});
				});

				$('.close_popup').on('click',function(){
					$('.preview_popup').css({'display':'none'});
				});

				$('.preview_popup').click(function(e){
					if ($(e.target).hasClass('preview_popup')) {
								//alert(33);
						$('.preview_popup').css({'display':'none'});
					}
				});
			});
		</script>



<script>

	$("#login_type_P_Sum").html("<?=number_format($login_type_P_Sum)?>");
	$("#login_type_M_Sum").html("<?=number_format($login_type_M_Sum)?>");
	$("#login_type_PM_Sum").html("<?=number_format($login_type_M_Sum + $login_type_P_Sum)?>");
	$("#itemCnt_P_Sum").html("<?=number_format($itemCnt_P_Sum)?>");
	$("#itemCnt_M_Sum").html("<?=number_format($itemCnt_M_Sum)?>");
	$("#itemCnt_PM_Sum").html("<?=number_format($itemCnt_P_Sum + $itemCnt_M_Sum)?>");

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



	

</script>


<? include "../_include/_footer.php"; ?>