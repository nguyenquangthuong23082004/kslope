<? include "../_include/_header.php"; ?>
<?
	
	$sWhere = "";
	if($sDate != "" && $eDate != ""){
		$sWhere = "AND (DATE(r_date) >= '".$sDate."' AND DATE(r_date) <= '".$eDate."')";
	}



	$total_sql = " 
			SELECT  
				COUNT(agNum) AS agNum
			FROM ( 
				SELECT	
					TRUNCATE(((TO_DAYS(now())-(TO_DAYS(birthday)))/365),0) AS agNum
				FROM tbl_member WHERE birthday != '' AND birthday != '--'
					".$sWhere."
			) T WHERE agNum > 0	
	
	";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$row = mysqli_fetch_array($result);
	$agNum		= $row[agNum];
	
	$total_sum = $agNum;


	$sql = "
			SELECT  
			  SUM(IFNULL((CASE WHEN agNum <= 10 THEN 1 END),0)) AS '0' 
			, SUM(IFNULL((CASE WHEN agNum >= 10 AND agNum < 20 THEN 1 END),0)) AS '1' 
			, SUM(IFNULL((CASE WHEN agNum >= 20 AND agNum < 30 THEN 1 END),0)) AS '2' 
			, SUM(IFNULL((CASE WHEN agNum >= 30 AND agNum < 40 THEN 1 END),0)) AS '3' 
			, SUM(IFNULL((CASE WHEN agNum >= 40 AND agNum < 50 THEN 1 END),0)) AS '4' 
			, SUM(IFNULL((CASE WHEN agNum >= 50 AND agNum < 60 THEN 1 END),0)) AS '5' 
			, SUM(IFNULL((CASE WHEN agNum >= 60 AND agNum < 70 THEN 1 END),0)) AS '6' 
			, SUM(IFNULL((CASE WHEN agNum >= 70 THEN 1 END),0)) AS '7' 
			FROM ( 
				SELECT	
					TRUNCATE(((TO_DAYS(now())-(TO_DAYS(birthday)))/365),0) AS agNum
				FROM tbl_member WHERE birthday != '' AND birthday != '--'
					".$sWhere."
			) T WHERE agNum > 0
	";

	$result = mysqli_query($connect, $sql) or die (mysql_error());



?>
		<div id="container" class="gnb_statistics">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>연령별 회원통계</h2>
					<div class="menus">
						<ul class="first">
							<li><a href="statistics05_01.php" class="btn btn_email01">회원통계(월간)</a></li>	
							<li><a href="statistics05_02.php" class="btn btn_email01">회원통계(일일/성별)</a></li>	
							<li><a href="statistics05_03.php" class="btn btn_email01">연령별 회원통계</a></li>	
							<!-- <li class="mr_10"><a href="statistics05_04.php" class="btn btn_email01">지역별 회원통계</a></li>	 -->
									
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

				<div class="listWrap statis07 statis05_01">
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
						<col width="" />
						
						
						</colgroup>
						<thead>
							<tr>
								<th>10대 이하</th>
								<th>10대</th>
								<th>20대</th>
								<th>30대</th>
								<th>40대</th>
								<th>50대</th>
								<th>60대</th>
								<th>70대 이상</th>		
							</tr>
						</thead>	
						<tbody>
							<tr>

<?
						while($row=mysqli_fetch_array($result)){	
						

							for($i = 0; $i<8; $i++){
								$num = $row[$i];								
								$av_count = round(($num/$total_sum * 100),2);
								
?>
								<td>
									<p><?=number_format($row[$i])?></p>
									<div>
										<div class="graph02" data-percent="<?=$av_count?>%"></div>
									</div>
									<span><?=$av_count?>%</span>
								</td>
<?
							}
?>

<?
						}	
?>
								
							</tr>
							
						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>
					<script>
						$(document).ready(function(){
							$('.graph02').each(function(){
								
								var $Height = $(this).attr('data-percent')
									//alert($Width)
								$(this).css({'height':$Height});
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