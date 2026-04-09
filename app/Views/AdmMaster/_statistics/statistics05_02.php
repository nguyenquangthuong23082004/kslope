<? include "../_include/_header.php"; ?>
<?


if($sYear == ""){
	$sYear = date("Y");
}

if($sMonth == ""){
	$sMonth = date("n");
}



	$total_sql = " 
			SELECT 
			 SUM(IFNULL((SELECT COUNT(m1.gender) FROM tbl_member AS m1 
					WHERE YEAR(m1.r_date) = '".$sYear."' 
							AND MONTH(m1.r_date) = '".$sMonth."' 
							AND DATE(m1.r_date) = TBL.r_date 
							AND m1.gender='M' 							
							GROUP BY DATE(m1.r_date) 
				),0)) AS mCnt
			, SUM(IFNULL((SELECT COUNT(m1.gender) FROM tbl_member AS m1 
					WHERE YEAR(m1.r_date) = '".$sYear."' 
							AND MONTH(m1.r_date) = '".$sMonth."' 
							AND DATE(m1.r_date) = TBL.r_date 
							AND m1.gender='W'  				
							GROUP BY DATE(m1.r_date) 
				),0)) AS wCnt

			FROM (
				SELECT DATE(r_date) AS r_date FROM tbl_member 
					WHERE YEAR(r_date) = '".$sYear."' 
					AND MONTH(r_date) = '".$sMonth."' 
					AND gender != ''
					GROUP BY DATE(r_date)	
			) TBL 	
	
	";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$row = mysqli_fetch_array($result);
	$mCnt_sum		= $row[mCnt];
	$wCnt_sum		= $row[wCnt];

	$total_sum = $mCnt_sum + $wCnt_sum;


	$sql = "
			SELECT TBL.r_date, TBL.week, TBL.cnt
			, IFNULL((SELECT COUNT(m1.gender) FROM tbl_member AS m1 
					WHERE YEAR(m1.r_date) = '".$sYear."' 
							AND MONTH(m1.r_date) ='".$sMonth."' 
							AND DATE(m1.r_date) = TBL.r_date 
							AND m1.gender='M' 							
							GROUP BY DATE(m1.r_date) 
				),0) AS mCnt
			, IFNULL((SELECT COUNT(m1.gender) FROM tbl_member AS m1 
					WHERE YEAR(m1.r_date) = '".$sYear."' 
							AND MONTH(m1.r_date) ='".$sMonth."'
							AND DATE(m1.r_date) = TBL.r_date 
							AND m1.gender='W'  				
							GROUP BY DATE(m1.r_date) 
				),0) AS wCnt

			FROM (

				SELECT DATE(r_date) AS r_date
				, CASE DAYOFWEEK(r_date) 
						WHEN 1 THEN '일'
						WHEN 2 THEN '월'	
						WHEN 3 THEN '화'
						WHEN 4 THEN '수'
						WHEN 5 THEN '목'
						WHEN 6 THEN '금'
						WHEN 7 THEN '토'
					END AS week
				, COUNT(*) AS cnt FROM tbl_member 
					WHERE YEAR(r_date) = '".$sYear."' 
					AND MONTH(r_date) ='".$sMonth."'
					AND gender != ''
					GROUP BY DATE(r_date)	
			) TBL 
	";

	$result = mysqli_query($connect, $sql) or die (mysql_error());


?>
		<div id="container" class="gnb_statistics">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>회원통계(일일/성별)</h2>
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
						<option value="user_name" <? if ($search_category == "user_name") {echo "selected"; } ?>>기기전체</option>
						<option value="user_email" <? if ($search_category == "user_email") {echo "selected"; } ?>>PC</option>
						<option value="user_phone" <? if ($search_category == "user_phone") {echo "selected"; } ?>>MOBILE</option>
					</select>

					<button type="button">이전달</button>

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

					<select name="sMonth" id="sMonth">
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

					<button type="button">다음달</button>
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

				<div class="listWrap statis01 statis05_02">
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
						<col width="15%" />
						<col width="8%" />
						<col width="8%" />
						<col width="8%" />
						<col width="*" />
						</colgroup>
						<thead>
							<tr>
								<th>일자</th>
								<th>남성</th>
								<th>여성</th>
								<th>합계</th>
								<th></th>
							</tr>
						</thead>	
						<tbody>
							<tr>
								<td>합계</td>
								<td><?=$mCnt_sum?></td>
								<td><?=$wCnt_sum?></td>
								<td><?=$total_sum?></td>
								<td></td>
							</tr>
<?
						while($row=mysqli_fetch_array($result)){
							$r_date = $row["r_date"];
							$week	= $row["week"];
							$cnt	= $row["cnt"];
							$mCnt	= $row["mCnt"];
							$wCnt	= $row["wCnt"];

							$av_count = round(($cnt / $total_sum * 100),2);

?>
							<tr>
								<td><?=$r_date?>(<?=$week?>)</td>
								<td><?=number_format($mCnt)?></td>
								<td><?=number_format($wCnt)?></td>
								<td><?=number_format($cnt)?></td>
								<td>
									<div data-percent="<?=$av_count?>%" class="graph01"></div>	
									<span><?=$av_count?>%</span>
								</td>
							</tr>
<? 

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