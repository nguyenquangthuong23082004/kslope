<? include "../_include/_header.php"; ?>
<?

$sWhere = "";
if($pay_device == "P"){
	$sWhere = " and b.order_code in (select s.order_code from tbl_order as s where s.pay_device = 'P' )";
}else if($pay_device == "M"){
	$sWhere = " and b.order_code in (select s.order_code from tbl_order as s where s.pay_device = 'M' )";
}


$sWhere2 = "";
if($sDate != "" && $eDate != ""){
	$sWhere2 = " AND (DATE(b.regdate) >= '".$sDate."' AND DATE(b.regdate) <= '".$eDate."')";
}

	if($s_product_code_1 != ""){
		$strSql = $strSql." and product_code like '|".$s_product_code_1."%' ";		
	}


$total_sql = " 
		select 
			sum(price_mk) as price_mk
			, sum(price_se) as price_se
			, sum(last_price) as last_price
			, sum(nCount) as nCount
			from (
			select
			a.product_code 
			,sum(ifnull(a.price_mk,0)) as price_mk
			,sum(ifnull(a.price_se,0)) as price_se
			,sum(ifnull(b.last_price,0)) as last_price
			,count(a.product_code) as nCount
			from tbl_goods as a
				inner join tbl_order_sub as b 
				on a.g_idx = b.g_idx
				where b.g_idx > 0
				and b.order_code in(select order_code from tbl_order where status='M' group by order_code)
				".$sWhere2.$sWhere.$strSql."
			group by a.product_code
						
		) tb 
	";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$row = mysqli_fetch_array($result);
	$price_mk_sum		= $row[price_mk];
	$price_se_sum		= $row[price_se];
	$last_price_sum		= $row[last_price];
	$nCount_sum		= $row[nCount];

	$sql = " 
		select product_code, price_mk, price_se, last_price, nCount from (
			select
				a.product_code 
				,sum(ifnull(a.price_mk,0)) as price_mk
				,sum(ifnull(a.price_se,0)) as price_se
				,sum(ifnull(b.last_price,0)) as last_price
				,count(a.product_code) as nCount
			from tbl_goods as a
				inner join tbl_order_sub as b 
				on a.g_idx = b.g_idx
				where b.g_idx > 0
					and b.order_code in(select order_code from tbl_order where status='M' group by order_code)
				".$sWhere2.$sWhere.$strSql."
			group by a.product_code
					
			UNION ALL
			
			select product_code 
				,0 as price_mk
				,0 as price_se
				,0 as last_price
				,0 as nCount
			from tbl_goods where product_code not in(	
				select product_code from (
					select a.product_code from tbl_goods as a						
						inner join tbl_order_sub as b 
							on a.g_idx = b.g_idx
							where b.g_idx > 0
								and b.order_code in(select order_code from tbl_order where status='M' group by order_code)
							".$sWhere2.$sWhere."									
					group by a.product_code
				) t 
			) ".$strSql." group by product_code
		) tb order by last_price desc, product_code asc

	";
	
	$result = mysqli_query($connect, $sql) or die (mysql_error());

?>
		<div id="container" class="gnb_statistics">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>카테고리</h2>
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
				<div class="statis_floatL">
					<select id="product_code_1" name="s_product_code_1" class="input_select" onchange="javascript:document.search.submit();" >
						<option value="">카테고리 선택</option>
						<?
							$fsql    = "select * from tbl_code where depth='1' and status != 'N'  order by onum desc, code_idx desc";
							$fresult = mysqli_query($connect, $fsql) or die (mysql_error($connect));
							while($frow=mysqli_fetch_array($fresult)){
								$status_txt = "";
							
						?>
						<option value="<?=$frow["code_no"]?>" <? if ($s_product_code_1 == $frow["code_no"]) {echo "selected"; } ?>><?=$frow["code_name"]?> <?=$status_txt?></option>
						<? } ?>
						
					</select> 
				</div>
				
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
						<table cellpadding="0" cellspacing="0" summary="" class="listTable statisTable">
						<caption></caption>
						<colgroup>
						<col width="15%" />
						<col width="10%" />
						<col width="10%" />
						<col width="10%" />
						<col width="10%" />
						<col width="*" />
						</colgroup>
						<thead>
							<tr>
								<th>카테고리</th>
								<th>최초가</th>
								<th>판매가</th>
								<th>결제가</th>
								<th>상품수량</th>
								<th>그래프</th>
							</tr>
						</thead>	
						<tbody>
							<tr>
								<td>합계</td>
								<td><?=number_format($price_mk_sum)?>원</td>
								<td><?=number_format($price_se_sum)?>원</td>
								<td><?=number_format($last_price_sum)?>원</td>
								<td><?=number_format($nCount_sum)?>개</td>
								<td></td>
							</tr>

<?
					while($row=mysqli_fetch_array($result)){
						//$total = ($row["nCount"]/$nCount_sum * 100);
						
						if($last_price_sum == 0){
							$total = 0;
						}else{
							$total = ($row["last_price"]/$last_price_sum * 100);
						}

					// 현재 등록된 코드를 통해 전체 코드를 알아보자
					$product_code = getCodeSlice( $row['product_code'] );
					$product_code_ar = explode("||",$product_code);

?>
							<tr>
								<td>
								<?
									if($product_code_ar[3] != "") {
										echo get_cate_text($product_code_ar[3]);
									}else if($product_code_ar[2] != "") {
										echo get_cate_text($product_code_ar[2]);
									}else if($product_code_ar[1] != "") {
										echo get_cate_text($product_code_ar[1]);
									}else{
										echo get_cate_text($product_code_ar[0]);
									}									
								?>	
								</td>
								<td><?=number_format($row["price_mk"])?>원</td>
								<td><?=number_format($row["price_se"])?>원</td>
								<td><?=number_format($row["last_price"])?>원</td>
								<td><?=number_format($row["nCount"])?>개</td>
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