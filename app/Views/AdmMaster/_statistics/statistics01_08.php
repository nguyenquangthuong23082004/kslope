<? include "../_include/_header.php"; ?>
<?

$sWhere = "";
if($pay_device == "P"){
	$sWhere = " and a.pay_device in ('P')";
}else if($pay_device == "M"){
	$sWhere = " and a.pay_device in ('M')";
}


$sWhere2 = "";
if($sDate != "" && $eDate != ""){
	$sWhere2 = " AND (DATE(a.regdate) >= '".$sDate."' AND DATE(a.regdate) <= '".$eDate."')";
}


$total_sql = " 
		select 
			 sum(nCont) as nCount
			,sum(price_se) as price_se
			,sum(total_price) as total_price
			,sum(usecash) as usecash
		from (
				select 				 
				 count(a.addr1) as nCont
				, sum(b.price_se) as price_se
				, sum(a.total_price) as total_price
				, sum(a.usecash) as usecash
				from tbl_order as a 
						inner join (				
									select order_code, sum(b.price_se) as price_se  from tbl_order_sub as a 
										inner join tbl_goods as b 
										on a.g_idx = b.g_idx						
									 group by order_code				
								) as b
					on a.order_code = b.order_code 	
					where a.status='M' ".$sWhere.$sWhere2."
				group by substr(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(addr1, '경상남도', '경남'), '경상북도', '경북'), '충청남도', '충남'), '충청북도', '충북'), '경상남도', '경남'), '경상북도', '경북'),1, 2)		
		) tb
	";	
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$row = mysqli_fetch_array($result);
	$price_se_sum		= $row[price_se];
	$total_price		= $row[total_price];
	$usecash_sum		= $row[usecash];
	$nCount_sum		= $row[nCount];


$sql = " 
		select * from (
				select 
				  substr(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(addr1, '경상남도', '경남'), '경상북도', '경북'), '충청남도', '충남'), '충청북도', '충북'), '경상남도', '경남'), '경상북도', '경북'),1, 2) as addr
				, count(a.addr1) as nCont
				, sum(b.price_se) as price_se
				, sum(a.total_price) as total_price
				, sum(a.usecash) as usecash
				from tbl_order as a 
						inner join (				
									select order_code, sum(b.price_se) as price_se  from tbl_order_sub as a 
										inner join tbl_goods as b 
										on a.g_idx = b.g_idx						
									 group by order_code				
								) as b
					on a.order_code = b.order_code 	
					where a.status='M' ".$sWhere.$sWhere2."
				group by substr(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(addr1, '경상남도', '경남'), '경상북도', '경북'), '충청남도', '충남'), '충청북도', '충북'), '경상남도', '경남'), '경상북도', '경북'),1, 2)
				
				union all
				
				select substr(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(addr1, '경상남도', '경남'), '경상북도', '경북'), '충청남도', '충남'), '충청북도', '충북'), '경상남도', '경남'), '경상북도', '경북'),1, 2) as addr 
				, 0 as nCont
				, 0 as price_se
				, 0 as total_price
				, 0 as usecash
				from tbl_order as a 
					where substr(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(addr1, '경상남도', '경남'), '경상북도', '경북'), '충청남도', '충남'), '충청북도', '충북'), '경상남도', '경남'), '경상북도', '경북'),1, 2) not in(	
						select 
						  substr(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(addr1, '경상남도', '경남'), '경상북도', '경북'), '충청남도', '충남'), '충청북도', '충북'), '경상남도', '경남'), '경상북도', '경북'),1, 2) as addr
						from tbl_order as a 
								inner join (				
											select order_code, sum(b.price_se) as price_se  from tbl_order_sub as a 
												inner join tbl_goods as b 
												on a.g_idx = b.g_idx						
											 group by order_code				
										) as b
							on a.order_code = b.order_code 	
							where a.status='M' ".$sWhere.$sWhere2."
						group by substr(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(addr1, '경상남도', '경남'), '경상북도', '경북'), '충청남도', '충남'), '충청북도', '충북'), '경상남도', '경남'), '경상북도', '경북'),1, 2)	
					)				
				group by substr(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(addr1, '경상남도', '경남'), '경상북도', '경북'), '충청남도', '충남'), '충청북도', '충북'), '경상남도', '경남'), '경상북도', '경북'),1, 2)
				
		) tb where addr !='' order by nCont desc
";
$result = mysqli_query($connect, $sql) or die (mysql_error());

?>
		<div id="container" class="gnb_statistics">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>지역별 주문통계</h2>
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
						<table cellpadding="0" cellspacing="0" summary="" class="listTable statisTable ">
						<caption></caption>
						<colgroup>
						<col width="10%" />
						<col width="10%" />
						<col width="10%" />
						<col width="10%" />
						<col width="10%" />
						<col width="*" />
						</colgroup>
						<thead>
							<tr>
								<th>지역</th>
								<th>매출건수</th>
								<th>판매가</th>
								<th>결제가</th>
								<th>포인트사용</th>
								<th>비고</th>
							</tr>
						</thead>	
						<tbody>
							<tr>
								<td>합계</td>
								<td><?=number_format($nCount_sum)?>건</td>
								<td><?=number_format($price_se_sum)?>원</td>
								<td><?=number_format($total_price)?>원</td>
								<td><?=number_format($usecash_sum)?>원</td>
								<td></td>
							</tr>

<?
						while($row=mysqli_fetch_array($result)){
							$total = ($row["total_price"]/$total_price * 100);
?>
							<tr>
								<td><?=$row["addr"]?></td>
								<td><?=number_format($row["nCont"])?>건</td>
								<td><?=number_format($row["price_se"])?>원</td>
								<td><?=number_format($row["total_price"])?>원</td>
								<td><?=number_format($row["usecash"])?>원</td>
								<td>	
									<div data-percent="<?=round($total,3)?>%" class="graph01"></div>	
									<span><?=round($total,2)?>%</span>
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