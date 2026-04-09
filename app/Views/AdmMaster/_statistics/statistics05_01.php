<? include "../_include/_header.php"; ?>


<?

if($sYear == ""){
	$sYear = date("Y");
}






	$total_sql = " 
		SELECT SUM(cnt) AS nCount FROM (
			SELECT COUNT(r_date) AS cnt FROM  tbl_member 
				WHERE YEAR(r_date) = '".$sYear."'  GROUP BY MONTH(r_date)
		) T 		
	";

	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$row = mysqli_fetch_array($result);
	$nCount_sum		= $row[nCount];


$sql = "
		SELECT 
		 IFNULL(SUM((CASE r_date_m WHEN 1 THEN cnt END )),0) '1'
		,IFNULL(SUM((CASE r_date_m WHEN 2 THEN cnt END )),0) '2'
		,IFNULL(SUM((CASE r_date_m WHEN 3 THEN cnt END )),0) '3'
		,IFNULL(SUM((CASE r_date_m WHEN 4 THEN cnt END )),0) '4'
		,IFNULL(SUM((CASE r_date_m WHEN 5 THEN cnt END )),0) '5'
		,IFNULL(SUM((CASE r_date_m WHEN 6 THEN cnt END )),0) '6'
		,IFNULL(SUM((CASE r_date_m WHEN 7 THEN cnt END )),0) '7'
		,IFNULL(SUM((CASE r_date_m WHEN 8 THEN cnt END )),0) '8'
		,IFNULL(SUM((CASE r_date_m WHEN 9 THEN cnt END )),0) '9'
		,IFNULL(SUM((CASE r_date_m WHEN 10 THEN cnt END )),0) '10'
		,IFNULL(SUM((CASE r_date_m WHEN 11 THEN cnt END )),0) '11'
		,IFNULL(SUM((CASE r_date_m WHEN 12 THEN cnt END )),0) '12'
		FROM (
			SELECT MONTH(r_date) AS r_date_m, COUNT(r_date) AS cnt FROM  tbl_member 
				WHERE YEAR(r_date) = '".$sYear."'  GROUP BY MONTH(r_date)
		) T 
	";

$result = mysqli_query($connect, $sql) or die (mysql_error());




?>
		<div id="container" class="gnb_statistics">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>회원통계(월간)</h2>
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
					<select id="" name="search_category" class="input_select" style="width:112px;float:left; margin-right:5px;">
						<option value="">기기전체</option>
						<option value="">PC</option>
						<option value="">MOBILE</option>
					</select>

					<select name="sYear" id="sYear">
						<?
							$inDate = date("Y");
							for($i = $inDate; $i >= 2015; $i--){
						?>
								<option value="<?=$i?>" <? if($sYear == $i){ echo "selected"; }?>><?=$i?>년</option>
						<?
							}

						?>
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
						<col width="" />
						<col width="" />
						<col width="" />
						<col width="" />
					
						</colgroup>
						<thead>
							<tr>
								<th>1월</th>
								<th>2월</th>
								<th>3월</th>
								<th>4월</th>
								<th>5월</th>
								<th>6월</th>
								<th>7월</th>
								<th>8월</th>
								<th>9월</th>
								<th>10월</th>
								<th>11월</th>
								<th>12월</th>
								
							</tr>
						</thead>	
						<tbody>

							<tr>


<?					
					while($row=mysqli_fetch_array($result)){
					
						for($i = 0; $i<12; $i++){
							
							$total_sum = $total_sum + $row[$i];

							if($nCount_sum==0 || $nCount_sum ==""){
								$total = 0;
							}else{
								$total = round(($row[$i] / $nCount_sum * 100),2);
							}
							
								
?>
								<td>
									<p><?=number_format($row[$i])?></p>
									<div>
										<div class="graph02" data-percent="<?=$total?>%"></div>
									</div>
									<span><?=$total ?>%</span>
								</td>

<?
						}						
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