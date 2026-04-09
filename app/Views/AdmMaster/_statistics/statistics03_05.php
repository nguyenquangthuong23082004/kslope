<? include "../_include/_header.php"; ?>
<?

$sWhere = "";
if($pay_device == "P"){
	$sWhere = " login_type_P ";
}else if($pay_device == "M"){
	$sWhere = " login_type_M ";
}else{
	$sWhere = " login_type_P + login_type_M ";
	
}


	$sql = "
		select sum(A) as '일'
		, sum(B) as '월' 
		, sum(C) as '화' 
		, sum(D) as '수' 
		, sum(E) as '목' 
		, sum(F) as '금' 
		, sum(G) as '토' 
		from (
		select 
		case when DAYOFWEEK(regdate) = 1 then ".$sWhere." end as A
		,case when DAYOFWEEK(regdate) = 2 then ".$sWhere." end as B
		,case when DAYOFWEEK(regdate) = 3 then ".$sWhere." end as C
		,case when DAYOFWEEK(regdate) = 4 then ".$sWhere." end as D
		,case when DAYOFWEEK(regdate) = 5 then ".$sWhere." end as E
		,case when DAYOFWEEK(regdate) = 6 then ".$sWhere." end as F
		,case when DAYOFWEEK(regdate) = 7 then ".$sWhere." end as G
		from tbl_login_device as a where 1=1
		) tb
	";
	$result = mysqli_query($connect, $sql) or die (mysql_error());
	$row = mysqli_fetch_array($result);
	$a		= $row['일'];
	$b		= $row['월'];
	$c		= $row['화'];
	$d		= $row['수'];
	$e		= $row['목'];
	$f		= $row['금'];
	$g		= $row['토'];
	$total = $a + $b + $c + $d + $e + $f + $g;

	$a_av = round(($a/$total * 100),2);
	$b_av = round(($b/$total * 100),2);
	$c_av = round(($c/$total * 100),2);
	$d_av = round(($d/$total * 100),2);
	$e_av = round(($e/$total * 100),2);
	$f_av = round(($f/$total * 100),2);
	$g_av = round(($g/$total * 100),2);

?>
		<div id="container" class="gnb_statistics">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>요일별</h2>
					<div class="menus">
						<ul class="first">
							<li><a href="statistics03_05.php" class="btn btn_email01">요일별</a></li>	
							<li><a href="statistics03_04.php" class="btn btn_email01">IP별 검색</a></li>	
							<li><a href="statistics03_01.php" class="btn btn_email01">접속통계</a></li>	
							<li class="mr_10"><a href="statistics03_02.php" class="btn btn_email01">방문경로 순위</a></li>							
									
						<!-- 	<li><a href="#!" class="btn btn-success btn_dd01">등록</a></li>	
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
						
						<select id="pay_device" name="pay_device" class="input_select" style="width:112px">
							<option value="" >기기전체</option>
							<option value="P" <? if ($pay_device == "P") {echo "selected"; } ?>>PC</option>
							<option value="M" <? if ($pay_device == "M") {echo "selected"; } ?>>MOBILE</option>
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

				<div class="listWrap statis03_02">
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
						<col width="30%" />
						<col width="30%" />
						<col width="*" />
						</colgroup>
						<thead>
							<tr>
								<th>요일별</th>
								<th>접속자</th>
								<th></th>
							</tr>
						</thead>	
						<tbody>
							<tr style="background-color:#fff;">
								<th style="background-color:#fff;">월</th>
								<td><?=number_format($a)?></td>
								<td>
									<div data-percent="<?=$a_av?>%" class="graph01"></div>
									<span><?=$a_av?>%</span>	
								</td>
							</tr>
							<tr>
								<th style="background-color:#fff;">화</th>
								<td><?=number_format($b)?></td>
								<td>
									<div data-percent="<?=$b_av?>%" class="graph01"></div>
									<span><?=$b_av?>%</span>	
								</td>
							</tr>
							<tr>
								<th style="background-color:#fff;">수</th>
								<td><?=number_format($c)?></td>
								<td>
									<div data-percent="<?=$c_av?>%" class="graph01"></div>
									<span><?=$c_av?>%</span>	
								</td>
							</tr>
							<tr>
								<th style="background-color:#fff;">목</th>
								<td><?=number_format($d)?></td>
								<td>
									<div data-percent="<?=$d_av?>%" class="graph01"></div>
									<span><?=$d_av?>%</span>	
								</td>
							</tr>
							<tr>
								<th style="background-color:#fff;">금</th>
								<td><?=number_format($e)?></td>
								<td>
									<div data-percent="<?=$e_av?>%" class="graph01"></div>
									<span><?=$e_av?>%</span>	
								</td>
							</tr>
							<tr>
								<th style="background-color:#fff;">토</th>
								<td><?=number_format($f)?></td>
								<td>
									<div data-percent="<?=$f_av?>%" class="graph01"></div>
									<span><?=$f_av?>%</span>	
								</td>
							</tr>
							<tr>
								<th style="background-color:#fff;">일</th>
								<td><?=number_format($g)?></td>
								<td>
									<div data-percent="<?=$g_av?>%" class="graph01"></div>
									<span><?=$g_av?>%</span>	
								</td>
							</tr>
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
					<!-- 			<ul class="first">
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