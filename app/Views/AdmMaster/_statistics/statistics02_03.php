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
	$sWhere2 = " AND (DATE(b.regdate) >= '".$sDate."' AND DATE(b.regdate) <= '".$eDate."')";
}

if($payMethod != ""){
	$sWhere = $sWhere." and a.payMethod='".$payMethod."'";
}



$sql = "	
				select 
					 YEAR(b.regdate) as regdate
					,a.idx
					,sum(a.usecash) as usecash 
					,sum(a.coupon) as coupon 
					,sum(a.total_price) as total_price 
					,a.order_code
					,sum(b.ori_price) as ori_price 
					,sum(b.direct_dc) as direct_dc 
					,sum(b.last_price) as last_price 
					,sum(b.coupon_dc_price) as coupon_dc_price 
					,sum(b.coupon_dc_count) as coupon_dc_count
					,b.order_code_count
					,count(b.regdate) as nCont
					,sum((case a.status when 'C' then 1 else 0 end )) as cancel 
				from tbl_order as a 
						inner join (
										select 
											order_code
											, sum(ori_price) as ori_price 
											, sum(direct_dc) as direct_dc 
											, sum(last_price) as last_price
											, sum(coupon_dc_price) as coupon_dc_price									
											, sum(case when coupon_dc_price > 0 then 1 else 0 end ) as coupon_dc_count
											, count(*) as order_code_count
											, regdate 
										from tbl_order_sub 
										where order_code in (
											select order_code 
											  from tbl_order
											where status not in ('D','B','')
										)

										group by order_code									
										) as b
							on a.order_code = b.order_code

				WHERE 1=1 ".$sWhere.$sWhere2. "
				group by YEAR(b.regdate)
				order by YEAR(b.regdate) asc
	";
$result = mysqli_query($connect, $sql) or die (mysqli_error($connect));

?>
		<div id="container" class="gnb_statistics">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>년도별 매출</h2>
					<div class="menus">
						<ul class="first">
							<li><a href="statistics02_01.php" class="btn btn_email01">일별 매출통계</a></li>	
							<li class=""><a href="statistics02_02.php" class="btn btn_email01">월별 매출통계</a></li>	
							<li class="mr_10"><a href="statistics02_03.php" class="btn btn_email01">년도별 매출통계</a></li>
						</ul>
					</div>
				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents" class="statis02_01">
			<form name="search" id="search">		
				<input type="hidden" name="gubun" value="<?=$gubun?>">
				<div class="statis_floatL">
	
				</div>
				
				<header id="headerContents" class="statis_floatR">
						<select id="pay_device" name="pay_device" class="input_select" style="width:112px">
							<option value="" >기기전체</option>
							<option value="P" <? if ($pay_device == "P") {echo "selected"; } ?>>PC</option>
							<option value="M" <? if ($pay_device == "M") {echo "selected"; } ?>>MOBILE</option>
						</select>

						<select name="payMethod" id="payMethod" class="static_select01">
							<option value="">결제수단선택</option>
							<option value="Card" <? if ($payMethod == "Card") {echo "selected"; } ?>>신용/체크카드 결제</option>
							<option value="Vbank" <? if ($payMethod == "Vbank") {echo "selected"; } ?>>무통장(가상계좌)</option>
							<option value="Dbank" <? if ($payMethod == "Dbank") {echo "selected"; } ?>>무통장입금</option>
							<option value="Point" <? if ($payMethod == "Point") {echo "selected"; } ?>>포인트</option>
							<!--<option value="DirectBank">실시간계좌이체</option>-->
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

				<div class="listWrap statis02_01">
					<!-- 안내 문구 필요시 구성 //-->

					
					<!--<div class="listTop">
						<div class="left">
							<p class="schTxt">■ 총 </*?=$nTotalCount*/?>개의 목록이 있습니다.</p>
						</div>

					</div><!-- // listTop -->
					
			
					<div class="listBottom" style="margin-top:-10px;">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable statisTable">
						<caption></caption>
						<colgroup>
						<col width="10%" />
						<col width="10%" />
						<col width="15%" />
						<col width="10%" />
						<col width="10%" />
						<col width="10%" />
						<col width="10%" />
						<col width="10%" />
						<col width="10%" />
						<col width="*" />
						</colgroup>
						<thead>
							<tr>
								<th>년도</th>
								<th>판매가</th>
								<th>할인가</th>
								<th>결제금액+포인트+쿠폰</th>
								<th>결제금액</th>
								<th>포인트사용</th>
								<th>쿠폰할인가</th>
								<th>쿠폰사용</th>
								<th>주문건수</th>
								<th>취소건</th>
							</tr>
						</thead>	
						<tbody>
							<tr>
								<td>합계</td>
								<td id="ori_price">0원</td>
								<td id="direct_dc">0원</td>
								<td id="last_price">0원</td>
								<td id="total_price">0원</td>
								<td id="usecash">0원</td>
								<td id="coupon_dc_price">0운</td>
								<td id="coupon_dc_count">0건</td>
								<td id="nCont">0건</td>
								<td id="cancel">0건</td>
							</tr>
<?
						while($row=mysqli_fetch_array($result)){
?>							
							<tr>
								<td><?=$row["regdate"]?>년</td>
								<td><?=number_format($row["ori_price"])?>원</td><!-- 판매가 -->
								<td><?=number_format($row["direct_dc"])?>원</td><!-- 할인가 -->
								<td><?=number_format($row["last_price"])?>원</td><!-- 결제금액 : 포인트 - 쿠폰 -->
								<td><?=number_format($row["total_price"])?>원</td><!-- 결제금액 -->
								<td><?=number_format($row["usecash"])?>원</td><!-- 포인트사용 -->
								<td><?=number_format($row["coupon_dc_price"])?>원</td><!-- 쿠폰할인가 -->
								<td><?=number_format($row["coupon_dc_count"])?>건</td>
								<td><?=number_format($row["nCont"])?>건</td>
								<td><?=number_format($row["cancel"])?>건</td>
							</tr>						
							
<?
						$ori_price = $ori_price + $row["ori_price"];
						$direct_dc = $direct_dc + $row["direct_dc"];
						$last_price = $last_price + $row["last_price"];
						$total_price = $total_price + $row["total_price"];
						$usecash = $usecash + $row["usecash"];
						$coupon_dc_price = $coupon_dc_price + $row["coupon_dc_price"];
						$coupon_dc_count = $coupon_dc_count + $row["coupon_dc_count"];
						$nCont = $nCont + $row["nCont"];
						$cancel = $cancel + $row["cancel"];
					}
?>							

						
						</tbody>
						</table>
					</div><!-- // listBottom -->
				
				
				
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

</script>
<script>
$(function() {

	$("#ori_price").html("<?=number_format($ori_price)?>원");
	$("#direct_dc").html("<?=number_format($direct_dc)?>원");
	$("#last_price").html("<?=number_format($last_price)?>원");
	$("#total_price").html("<?=number_format($total_price)?>원");
	$("#usecash").html("<?=number_format($usecash)?>원");
	$("#coupon_dc_price").html("<?=number_format($coupon_dc_price)?>원");
	$("#coupon_dc_count").html("<?=number_format($coupon_dc_count)?>건");
	$("#nCont").html("<?=number_format($nCont)?>건");
	$("#cancel").html("<?=number_format($cancel)?>건");



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