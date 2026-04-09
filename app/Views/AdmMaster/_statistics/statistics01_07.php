<? include "../_include/_header.php"; ?>
<?

$sWhere = "";
if($pay_device == "P"){
	$sWhere = " and b.pay_device in('P') ";
}else if($pay_device == "M"){
	$sWhere = " and b.pay_device in('M') ";
}


$sWhere2 = "";
if($sDate != "" && $eDate != ""){
	$sWhere2 = " AND (DATE(b.regdate) >= '".$sDate."' AND DATE(b.regdate) <= '".$eDate."')";
}

$sql = "
		select * from (

					SELECT
					 'M' as gender
					, SUM(IFNULL((CASE WHEN agNum >= 10 AND agNum < 20 THEN 1 END),0)) AS '1' 
					, SUM(IFNULL((CASE WHEN agNum >= 20 AND agNum < 30 THEN 1 END),0)) AS '2' 
					, SUM(IFNULL((CASE WHEN agNum >= 30 AND agNum < 40 THEN 1 END),0)) AS '3' 
					, SUM(IFNULL((CASE WHEN agNum >= 40 AND agNum < 50 THEN 1 END),0)) AS '4' 
					, SUM(IFNULL((CASE WHEN agNum >= 50 AND agNum < 60 THEN 1 END),0)) AS '5' 
					, SUM(IFNULL((CASE WHEN agNum >= 60 THEN 1 END),0)) AS '6' 			
					, SUM(IFNULL((CASE WHEN agNum >= 10 AND agNum < 20 THEN total_price END),0)) AS 'price_1' 
					, SUM(IFNULL((CASE WHEN agNum >= 20 AND agNum < 30 THEN total_price END),0)) AS 'price_2' 
					, SUM(IFNULL((CASE WHEN agNum >= 30 AND agNum < 40 THEN total_price END),0)) AS 'price_3' 
					, SUM(IFNULL((CASE WHEN agNum >= 40 AND agNum < 50 THEN total_price END),0)) AS 'price_4' 
					, SUM(IFNULL((CASE WHEN agNum >= 50 AND agNum < 60 THEN total_price END),0)) AS 'price_5' 
					, SUM(IFNULL((CASE WHEN agNum >= 60 THEN total_price END),0)) AS 'price_6' 
								
					FROM ( 
						SELECT	
							TRUNCATE(((TO_DAYS(now())-(TO_DAYS(birthday)))/365),0) AS agNum
							, b.total_price
						FROM tbl_member as a inner join tbl_order as b 
							on a.user_id = b.user_id				
						WHERE a.birthday != '' 
							and a.birthday != '--'
							and b.status='M'
							and b.user_id != ''
							and a.gender = 'M'
							".$sWhere2.$sWhere."
					) T WHERE agNum > 0
					
				union all
				
					SELECT
					 'W' as gender  
					, SUM(IFNULL((CASE WHEN agNum >= 10 AND agNum < 20 THEN 1 END),0)) AS '1' 
					, SUM(IFNULL((CASE WHEN agNum >= 20 AND agNum < 30 THEN 1 END),0)) AS '2' 
					, SUM(IFNULL((CASE WHEN agNum >= 30 AND agNum < 40 THEN 1 END),0)) AS '3' 
					, SUM(IFNULL((CASE WHEN agNum >= 40 AND agNum < 50 THEN 1 END),0)) AS '4' 
					, SUM(IFNULL((CASE WHEN agNum >= 50 AND agNum < 60 THEN 1 END),0)) AS '5' 
					, SUM(IFNULL((CASE WHEN agNum >= 60 THEN 1 END),0)) AS '6' 			
					, SUM(IFNULL((CASE WHEN agNum >= 10 AND agNum < 20 THEN total_price END),0)) AS 'price_1' 
					, SUM(IFNULL((CASE WHEN agNum >= 20 AND agNum < 30 THEN total_price END),0)) AS 'price_2' 
					, SUM(IFNULL((CASE WHEN agNum >= 30 AND agNum < 40 THEN total_price END),0)) AS 'price_3' 
					, SUM(IFNULL((CASE WHEN agNum >= 40 AND agNum < 50 THEN total_price END),0)) AS 'price_4' 
					, SUM(IFNULL((CASE WHEN agNum >= 50 AND agNum < 60 THEN total_price END),0)) AS 'price_5' 
					, SUM(IFNULL((CASE WHEN agNum >= 60 THEN total_price END),0)) AS 'price_6' 
								
					FROM ( 
						SELECT	
							TRUNCATE(((TO_DAYS(now())-(TO_DAYS(birthday)))/365),0) AS agNum
							, b.total_price
						FROM tbl_member as a inner join tbl_order as b 
							on a.user_id = b.user_id				
						WHERE a.birthday != '' 
							and a.birthday != '--'
							and b.user_id != ''
							and b.status='M'
							and a.gender = 'W'	
							".$sWhere2.$sWhere."
					) T WHERE agNum > 0		
		) tb			
	";
	$result = mysqli_query($connect, $sql) or die (mysql_error());
?>
		<div id="container" class="gnb_statistics">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>성별/연령대별 통계</h2>
					<div class="menus">
						<ul class="first">
							<li><a href="statistics01_01.php" class="btn btn_email01">카테고리</a></li>	
							<li><a href="statistics01_03.php" class="btn btn_email01">브랜드별 통계</a></li>	
							<li><a href="statistics01_05.php" class="btn btn_email01">시간대별 주문통계</a></li>	
							<li><a href="statistics01_06.php" class="btn btn_email01">요일별 주문통계</a></li>	
							<li><a href="statistics01_07.php" class="btn btn_email01">성별/연령대별 통계</a></li>	
							<li class="mr_10"><a href="statistics01_08.php" class="btn btn_email01">지역별 주문통계</a></li>	
									
							<!-- <li><a href="#!" class="btn btn-success btn_dd01">등록</a></li>	
							<li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), true)" class="btn btn-success">전체선택</a></li>
							<li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), false)" class="btn btn-success">선택해체</a></li>
							<li><a href="javascript:SELECT_DELETE()" class="btn btn-danger btn_dd01">선택삭제</a></li> -->
						</ul>
					</div>
				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents">
				<form name="search" id="search">		
				<input type="hidden" name="gubun" value="<?=$gubun?>">
				
				<header id="headerContents" class="statis_floatR">
						<select id="pay_device" name="pay_device" class="input_select" style="width:112px">
							<option value="" >기기전체</option>
							<option value="P" <? if ($pay_device == "P") {echo "selected"; } ?>>PC</option>
							<option value="M" <? if ($pay_device == "M") {echo "selected"; } ?>>MOBILE</option>
						</select>

						
						<input type="text" id="sDate" name="sDate" class="date_form" value="<?=$sDate?>"> ~ <input type="text" class="date_form" id="eDate" name="eDate" value="<?=$eDate?>">

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
						<table cellpadding="0" cellspacing="0" summary="" class="listTable statisTable statisTable07">
						<caption></caption>
						<colgroup>
						<col width="" />
						<col width="" />
						<col width="" />
						<col width="" />
						<col width="" />
						<col width="" />
						<col width="" />
						</colgroup>
						<thead>
							<tr>
								<th>성별</th>
								<th>10대</th>
								<th>20대</th>
								<th>30대</th>
								<th>40대</th>
								<th>50대</th>
								<th>60대 이상</th>
							</tr>
						</thead>	
						<tbody>
<?
					while($row=mysqli_fetch_array($result)){
						$gender = $row["gender"];
							if($gender == "M") {
								$gender = "남";
							}else{
								$gender = "여";
							}
?>
							<tr>
								<td><?=$gender?></td>
								<td><?=$row["1"]?>건 / <?=number_format($row["price_1"])?>원</td>
								<td><?=$row["2"]?>건 / <?=number_format($row["price_2"])?>원</td>
								<td><?=$row["3"]?>건 / <?=number_format($row["price_3"])?>원</td>
								<td><?=$row["4"]?>건 / <?=number_format($row["price_4"])?>원</td>
								<td><?=$row["5"]?>건 / <?=number_format($row["price_5"])?>원</td>
								<td><?=$row["6"]?>건 / <?=number_format($row["price_6"])?>원</td>
							</tr>

<?
						$sum_1 = $sum_1 + $row["1"]; 
						$sum_2 = $sum_2 + $row["2"]; 
						$sum_3 = $sum_3 + $row["3"]; 
						$sum_4 = $sum_4 + $row["4"]; 
						$sum_5 = $sum_5 + $row["5"]; 
						$sum_6 = $sum_6 + $row["6"]; 
						$price_1_sum = $price_1_sum + $row["price_1"];
						$price_2_sum = $price_2_sum + $row["price_2"];
						$price_3_sum = $price_3_sum + $row["price_3"];
						$price_4_sum = $price_4_sum + $row["price_4"];
						$price_5_sum = $price_5_sum + $row["price_5"];
						$price_6_sum = $price_6_sum + $row["price_6"];
					}
?>

							
							<tr>
								<td>전체</td>
								<td><?=$sum_1?>건 / <?=number_format($price_1_sum)?>원</td>
								<td><?=$sum_2?>건 / <?=number_format($price_2_sum)?>원</td>
								<td><?=$sum_3?>건 / <?=number_format($price_3_sum)?>원</td>
								<td><?=$sum_4?>건 / <?=number_format($price_4_sum)?>원</td>
								<td><?=$sum_5?>건 / <?=number_format($price_5_sum)?>원</td>
								<td><?=$sum_6?>건 / <?=number_format($price_6_sum)?>원</td>
							</tr>
						</tbody>
						</table>
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