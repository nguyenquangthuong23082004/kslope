<? include "../_include/_header.php"; ?>
<?
		
	$sWhere = "";
	if($pay_device == "P"){
		$sWhere = " and o.order_code in (select s.order_code from tbl_order as s where s.pay_device = 'P' )";
	}else if($pay_device == "M"){
		$sWhere = " and o.order_code in (select s.order_code from tbl_order as s where s.pay_device = 'M' )";
	}


	$sWhere2 = "";
	if($sDate != "" && $eDate != ""){
		$sWhere2 = " AND (DATE(o.regdate) >= '".$sDate."' AND DATE(o.regdate) <= '".$eDate."')";
	}

	
	if($s_product_code_1 != ""){
		$strSql = $strSql." and a.product_code like '|".$s_product_code_1."%' ";		
	}

	if($s_product_code_2 != ""){
		$strSql = $strSql." and a.goods_brand = '".$s_product_code_2."' ";		
	}
	

	$total_sql = "
				select sum(nocoupon_price) as nocoupon_price
					,sum(last_price) as last_price
					,sum(nCount) as nCount	
				 from (
					
					select 	
						  b.nocoupon_price
						, b.last_price	
						, b.nCount	
					from tbl_goods as a 
						inner join (select o.g_idx
							, sum(o.nocoupon_price) as nocoupon_price
							, sum(o.last_price) as last_price
							, count(o.g_idx) as nCount 
							, o.options
							, o.order_code
							from tbl_order_sub as o
							where 
							o.order_code in(select order_code from tbl_order where status='M' group by order_code)
							".$sWhere.$sWhere2." 
							group by o.g_idx) as b
							on a.g_idx = b.g_idx
						left outer join tbl_brand as c 
							on a.goods_brand = c.code_no										
						left outer join tbl_goods_view_cnt as d
							on a.g_idx=d.g_idx
					where 1=1 ".$strSql."
					
				) tb		
	";		
	$result = mysqli_query($connect, $total_sql) or die (mysqli_error($connect));
	$row = mysqli_fetch_array($result);
	$nocoupon_price_sum		= $row[nocoupon_price];
	$last_price_sum			= $row[last_price];	
	$nCount_sum				= $row[nCount];


	$sql ="
			select 
			a.g_idx, a.product_code, a.goods_brand
				, a.goods_code, a.goods_name_front
				, a.goods_name_back, a.goods_color
				, b.nocoupon_price
				, b.last_price	
				, b.nCount
				, b.options
				, c.code_name	
				, d.cnt as pageCnt	
			from tbl_goods as a 
				inner join (select o.g_idx
					, sum(o.nocoupon_price) as nocoupon_price
					, sum(o.last_price) as last_price
					, count(o.g_idx) as nCount 
					, o.options
					from tbl_order_sub as o 
					where 
					o.order_code in(select order_code from tbl_order where status='M' group by order_code)
					".$sWhere.$sWhere2." 
					group by o.g_idx) as b
					on a.g_idx = b.g_idx
				left outer join tbl_brand as c 
					on a.goods_brand = c.code_no
				left outer join tbl_goods_view_cnt as d
					on a.g_idx=d.g_idx
				where 1=1 ".$strSql." order by pageCnt desc
	";

	$result = mysqli_query($connect, $sql) or die (mysqli_error($connect));

?>
		<div id="container" class="gnb_statistics">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>상품 페이지뷰</h2>
					<div class="menus">
						<ul class="first">
							<li><a href="statistics04_01.php" class="btn btn_email01">상품판매 순위</a></li>	
							<li><a href="statistics04_02.php" class="btn btn_email01">상품 페이지뷰</a></li>	
							<li><a href="statistics04_03.php" class="btn btn_email01">검색어 순위</a></li>	
							<li class="mr_10"><a href="statistics04_04.php" class="btn btn_email01">관심상품 분석</a></li>	
									
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
				<div class="statis_floatL">
					<div class="select_box">
										<select id="product_code_1" name="s_product_code_1" class="input_select" onchange="javascript:document.search.submit();" >
											<option value="">카테고리 선택</option>
											<?
												$fsql    = "select * from tbl_code where depth='1' and status != 'N'  order by onum desc, code_idx desc";
												$fresult = mysqli_query($connect, $fsql) or die (mysqli_error($connect));
												while($frow=mysqli_fetch_array($fresult)){
													$status_txt = "";
													

											?>
											<option value="<?=$frow["code_no"]?>" <? if ($s_product_code_1 == $frow["code_no"]) {echo "selected"; } ?>><?=$frow["code_name"]?> <?=$status_txt?></option>
											<? } ?>
											
										</select> 
                    </div>
					<div class="select_box">
						<select id="product_code_2" name="s_product_code_2" class="input_select" onchange="javascript:document.search.submit();" >
							<option value="">브랜드</option>
							<?
								$fsql    = "select * from tbl_brand where status = 'Y'  order by onum desc, code_no desc";
								$fresult = mysqli_query($connect, $fsql) or die (mysqli_error($connect));
								while($frow=mysqli_fetch_array($fresult)){
									$status_txt = "";
									if ($frow["status"] == "Y")
									{ 
										$status_txt = "";
									} elseif ($frow["status"] == "N") {
										$status_txt = "[삭제]";
									} elseif ($frow["status"] == "C") {
										$status_txt = "[마감]";
									}

							?>
							<option value="<?=$frow["code_no"]?>" <? if ($s_product_code_2 == $frow["code_no"]) {echo "selected"; } ?>><?=$frow["code_name"]?> <?=$status_txt?></option>
							<? } ?>
						</select> 
                    </div>
				</div>
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

				<div class="listWrap statis01 statis04_02">
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
						<col width="15%" />
						<col width="10%" />
						<col width="39%" />
						<col width="8%" />
						<col width="10%" />
						<col width="10%" />
						<col width="10%" />
						</colgroup>
						<thead>
							<tr>
								<th>카테고리</th>
								<th>브랜드명</th>
								<th>제품명 / 옵션명</th>
								<th>판매가</th>
								<th>결제가합계</th>
								<th>주문수량</th>
								<th>총페이지뷰</th>
							</tr>
						</thead>	
						<tbody>
<?
				while($row=mysqli_fetch_array($result)){

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
								<td><?=$row['code_name']?></td>
								<td>[<?=$row['goods_code']?>] <?=$row['goods_name_front']?>  <? if($row['goods_name_back'] != ""){ echo "- ".$row['goods_name_back'];} ?></td>
								<td><?=number_format($row['nocoupon_price'])?>원</td>
								<td><?=number_format($row['last_price'])?>원</td>
								<td><?=number_format($row['nCount'])?>건</td>
								<td><?=number_format($row['pageCnt'])?>건</td>
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
					<?echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF]."?s_status=$s_status&search_category=$search_category&search_name=$search_name&pg=")?>


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
<script>
        //셀렉
        $(document).ready(function() {
            //셀렉 선택하기
            var check_cate = parseInt('');
            if (check_cate) {
                //check_cate =check_cate -1;
                check_cate = check_cate;
                var cate_text = $(".category_gnb li").eq(check_cate).find("a").text();
                $(".category_box ul li").eq(0).find("a").eq(0).text(cate_text);
            }
            //정렬순 선택하기
            var order_type = $("#order_by").val();
            if (order_type) {
                $(".seach_select ul li").removeClass();
                if (order_type == "print_date") {
                    $(".seach_select ul li").eq(0).addClass("active");
                } else {
                    $(".seach_select ul li").eq(1).addClass("active");
                }
            }

            $(".category_box > ul > li > a").click(function(e) {
                if ($(".category_box > ul > li ").addClass("active")) {
                    var $con = $(this).next(".category_gnb");
                    if ($con.is(":visible")) {
                        //$con.slideUp();
						  $con.css({'display':'none'});
                    } else {
                        //$(".category_gnb:visible").slideUp();
                        //$con.slideDown();
						$con.css({'display':'block'});
                    }
                    e.preventDefault();
                }
            });
        });
        //셀렉누를 시 active
        $(".category_gnb > li > a").click(function() {
            var tbc_idx = $(this).attr("tbc_idx");
            var tbc_text = $(this).text();
            $("#tbc_idx").val(tbc_idx);
            $(this).parent().parent().parent().find("a").eq(0).text(tbc_text);
            //$("#pg").val("1");
            $(".category_gnb > li > a").removeClass("active");
            $(this).addClass("active");
            //$("#frm").submit();
            //$(".category_gnb").slideUp();
            $(".category_gnb").css({'display':'none'});
        });
</script>

<? include "../_include/_footer.php"; ?>