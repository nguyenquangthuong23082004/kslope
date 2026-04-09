<? include "../_include/_header.php"; ?>
<script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js"></script>

<?
	$order_code = updateSQ($_GET["order_code"]);

	

	if ($order_code == "") {
		alert_msg("주문번호가 누락되었습니다.","");
		exit();
	}


	$sql_t = " select * 
					  from tbl_order
					 where order_code = '".$order_code."'
				 ";
	$result_t = mysqli_query($connect, $sql_t) or die (mysql_error($connect));
	$row_t = mysqli_fetch_array($result_t);



	$sql_s = " select sum(ori_price * cnts) as sumprice
	                , sum( coupon_dc_price ) as dcprice
				from tbl_order_sub
				where order_code = '".$order_code."'
				 ";
	$result_s = mysqli_query($connect, $sql_s) or die (mysqli_error($connect));
	$row_s = mysqli_fetch_array($result_s);


	$sql_m = " select * from tbl_member where user_id = '".$row_t['user_id']."' ";
	$result_m = mysqli_query($connect, $sql_m) or die (mysqli_error($connect));
	$row_m = mysqli_fetch_array($result_m);


	$sql_u = " select count(*) as t_cnt, sum(total_price) as t_price from tbl_order where user_id = '".$row_t['user_id']."'  and status = 'M' ";
	$result_u = mysqli_query($connect, $sql_u) or die (mysqli_error($connect));
	$row_u = mysqli_fetch_array($result_u);
?>



<div id="container" class="gnb_order"> <span id="print_this"><!-- 인쇄영역 시작 //-->

	<header id="headerContainer">
		<div class="inner">
			<h2>주문상세 <span>(주문번호 <?=$order_code?>)</span></h2>
			<div class="menus">
				<ul >
					<li><a href="javascript:history.go(-1);" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a></li>
					<? if ($order_code) { ?>
					<!--
					<li><a href="javascript:send_it()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a></li>
					-->
					<? }?>
					

				</ul>
			</div>
		</div>
		<!-- // inner -->

	</header>
	<!-- // headerContainer -->


	<div id="contents">
		<div class="listWrap_noline">
			<!--  target="hiddenFrame22"  -->
			


			<div class="listBottom">
			
				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail" style="table-layout:fixed;">
					<caption>
					</caption>
					<colgroup>
						<col width="10%" />
						<col width="40%" />
						<col width="10%" />
						<col width="40%" />
					</colgroup>
					<tbody>

						<tr height="45">
							<td colspan="4">
								결제정보
							</td>
						</tr>
						<tr height="45">
							<th>주문번호</th>
							<td><?=$order_code?></td>
							<th>상태</th>
							<td>
								<form name="r_frm" method="post" action="./order_update.php" target="hiddenFrame22"  >
									<input type="hidden" name="order_code" id="order_code" value="<?=$order_code?>" />

									<select name="status" id="status" <?if($row_t['status'] == "C")echo "disabled=disabled";?> >
									<? foreach($_deli_type as $key => $value ){ ?>
										<option value="<?=$key?>" <?if($key == $row_t['status'] )echo "selected";?> ><?=$value?></option>
									<?}?>
									</select>

									<? if ($order_code) { ?>
									<a href="javascript:send_it()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a>
									<? }?>

								</form>
							</td>
						</tr>
						<tr height="45">
							<th>주문금액</th>
							<td>
								<?=number_format($row_s['sumprice'])?> - <?=number_format($row_s['dcprice'])?> (할인) + <?=number_format($row_t['delivery_price'])?> (배송비)
							</td>
							<th>총 결제금액</th>
							<td>
								<?=number_format($row_t['total_price'])?> 원
								<?if($row_t['usecash']){?>
								(캐쉬사용 : <?=number_format($row_t['usecash'])?>P)
								<?}?>
							</td>
						</tr>
						
						
						<tr height="45">

							<th>결제방법</th>
							<td>
								<?=$_pg_Method[$row_t['payMethod']]?>
								<?
									if($row_t['pg_del'] == ""){
										if( $row_t['payMethod'] == "Card" && $row_t['tid'] != "" ){
								?>
										&nbsp;<button type="button" onclick="fn_paydel('<?=$order_code?>')" >결제취소</button>
								<?
										}
										echo '<span style="color:red;margin-left:20px;">(PG사 결제취소는 카드 결제만 가능합니다.)</span>';
									}else{
										echo '<span style="color:red;margin-left:20px;">(PG 결제취소 되었습니다.)</span>';
									}
								?>
								
							</td>
							<th>결제정보</th>
							<td>
								<p>승인번호 : <?=$row_t['moid']?></p>
								<p>상세정보 : <?=$row_t['payText']?></p>
								<p>결제일자 : <?=pg_app_convert($row_t['applDate'],$row_t['applTime'])?></p>
							</td>

						</tr>

						


						<tr height="45">

							<th>송장정보</th>
							<td colspan="3">
								<form name="r_frm2" method="post" action="./order_update2.php" target="hiddenFrame22"  >
									<input type="hidden" name="order_code" id="order_code" value="<?=$order_code?>" />

									<select name="invo_corp" id="invo_corp" >
										<option value="">선택안함</option>
										<?
										$sql_d = " select *	from tbl_transcom where status = 'Y' $strSql ";
										$result_d = mysqli_query($connect, $sql_d) or die (mysqli_error($connect));
										while( $row_d = mysqli_fetch_array($result_d) ){
										?>
											<option value="<?=$row_d["code_idx"]?>" <?if($row_t['invo_corp']==$row_d["code_idx"])echo"selected"; ?> ><?=$row_d["code_name"]?></option>
										<?}?>
									</select>
									<input type="text" name="invoice" id="invoice" value="<?=$row_t['invoice']?>" style="width:300px;" />
								<? if ($order_code) { ?>
									<a href="javascript:send_it2()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a>
									<? }?>

								</form>
							</td>

						</tr>

						<tr height="45">

							<th>반품 송장정보</th>
							<td colspan="3">
								<form name="r_frm3" method="post" action="./order_update3.php" target="hiddenFrame22"  >
									<input type="hidden" name="order_code" id="order_code" value="<?=$order_code?>" />

									<select name="invo_corp2" id="invo_corp2" >
										<option value="">선택안함</option>
										<?
										$sql_d = " select *	from tbl_transcom where status = 'Y' $strSql ";
										$result_d = mysqli_query($connect, $sql_d) or die (mysqli_error($connect));
										while( $row_d = mysqli_fetch_array($result_d) ){
										?>
											<option value="<?=$row_d["code_idx"]?>" <?if($row_t['invo_corp2']==$row_d["code_idx"])echo"selected"; ?> ><?=$row_d["code_name"]?></option>
										<?}?>
									</select>
									<input type="text" name="invoice2" id="invoice2" value="<?=$row_t['invoice2']?>" style="width:300px;" />
									
									<? if ($order_code) { ?>
									<a href="javascript:send_it3()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a>
									<? }?>

								</form>
							</td>

						</tr>

					</tbody>
				</table>
			
				
				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail" style="margin-top:50px;">
					<caption>
					</caption>
					<colgroup>
						<col width="12%" />
						<col width="*" />
					</colgroup>
					<tbody>

						<tr height="45">
							<td colspan="2">
								주문로그
							</td>
						</tr>

						<?
						$sql_l = " select * from tbl_order_log where order_code = '".$row_t['order_code']."' order by idx desc ";
						$result_l = mysqli_query($connect, $sql_l) or die (mysqli_error($connect));
						while( $row_l = mysqli_fetch_array($result_l) ){
						?>
						<tr height="45">
							<th><?=$row_l['regdate']?></th>
							<td><?=$row_l['order_log']?></td>
						</tr>
						<?
						}
						?>
					</tbody>
				</table>


			<form name="m_frm" method="post" action="./order_memo.php" target="hiddenFrame22"  >
				<input type="hidden" name="order_code" id="order_code" value="<?=$order_code?>" />

				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail" style="margin-top:50px;">
					<caption>주문 상품 정보</caption>
					<colgroup>
						<col width="12%" />
						<col width="*" />
						<col width="12%" />
					</colgroup>
					<thead>
						<tr>
							<th class="ol_money od_border">관리자명</th>
							<th class="ol_money od_border">내용</th>
							<th class="ol_item od_border">등록일시</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="ol_money" colspan="2">
								<textarea name="memos" id="memos" style="width:95%;height:70px;" ></textarea>
							</td>
							<td class="ol_money"><button type="button" onclick="fn_memo();" style="width:120px;height:50px;" />등록</button></td>
							

						</tr>
					<?
					$sql_j = " select * from tbl_order_memo where order_code = '".$row_t['order_code']."' order by idx desc ";
					$result_j = mysqli_query($connect, $sql_j) or die (mysql_error($connect));
					while( $row_j = mysqli_fetch_array($result_j) ){
					?>
						<tr height="45">
							<th ><?=$row_j['user_id']?></th>
							<td ><?=nl2br($row_j['order_memo'])?></td>
							<td ><?=$row_j['regdate']?></td>

						


						</tr>
					<?
						}
					
					?>

					</tbody>
				</table>
			</form>


			

				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail" style="margin-top:50px;">
					<caption>
					</caption>
					<colgroup>
						<col width="10%" />
						<col width="40%" />
						<col width="10%" />
						<col width="40%" />
					</colgroup>
					<tbody>

						<tr height="45">
							<td colspan="4">
								고객 정보
							</td>
						</tr>

						<tr height="45">
							<th>회원명(아이디)</th>
							<td><?=$row_m['user_name']?> (<?=$row_t['user_id']?>)</td>
							<th>회원연락처</th>
							<td><?=$row_m['user_mobile']?></td>
						</tr>

						<tr height="45">
							<th>환불 계좌정보</th>
							<td colspan="3"><p><?=$_pg_Bank[$row_m['bank']]?> <?=$row_m['account_num']?> <span class="block"></span> (예금주: <?=$row_m['account_name']?>)</p></td>
							
						</tr>

						<tr height="45">
							<th>누적 구매횟수</th>
							<td><?=number_format($row_u['t_cnt'])?> 건</td>
							<th>누적 구매금액</th>
							<td><?=number_format($row_u['t_price'])?> 원</td>
						</tr>


						
						
					</tbody>
				</table>


				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail" style="margin-top:50px;">
					<caption>
					</caption>
					<colgroup>
						<col width="10%" />
						<col width="*" />
					</colgroup>
					<tbody>

						<tr height="45">
							<td colspan="2">
								배송지 정보
							</td>
						</tr>

						<tr height="45">
							<th>받는분</th>
							<td><?=$row_t['receive_name']?></td>
						</tr>

						<tr height="45">
							<th>배송방법</th>
							<td><?=$row_t['delivery_way']?></td>
						</tr>

						<?if($row_t['delivery_way']!="직접수령"){?>
						<tr height="45">
							<th>주소</th>
							<td>
								(<?=$row_t['zipcode']?>) <?=$row_t['addr1']?> <?=$row_t['addr2']?>
							</td>
							
						</tr>
						<?}?>

						


						<tr height="45">
							<th>연락처</th>
							<td>
								<?=$row_t['hp']?>
							</td>
							
						</tr>


						<tr height="45">
							<th>요청사항</th>
							<td >
								<?=nl2br($row_t['deli_content'])?>
							</td>
						</tr>

						
					</tbody>
				</table>


				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail" style="margin-top:50px;">
					<caption>주문 상품 정보</caption>
					<colgroup>
						<col width="85%" />
						<col width="*" />
					</colgroup>
					<thead>
						<tr>
							<th class="ol_item od_border">상품/옵션정보</th>
							<th class="ol_money od_border">상품금액/수량</th>
						</tr>
					</thead>
					<tbody>
					<?
					$total_sql = " select b.options, b.cnts, b.coupons, b.ori_price, go.goods_name, go.goods_price, go.bfile, go.option_type, g.*
									  from tbl_order_sub b
									  left outer join tbl_goods g
										on b.g_idx = g.g_idx
									  left outer join tbl_goods_option go
										on b.options = go.idx
									 where b.order_code = '".$row_t['order_code']."'
								 ";

					$result = mysqli_query($connect, $total_sql) or die (mysql_error($connect));
					$tmp_cnt = mysqli_num_rows($result);

					$sql    = $total_sql . " order by b.idx desc ";
					$result = mysqli_query($connect, $sql) or die (mysql_error($connect));

					
					$order_no_cnt = 0;
					while( $row = mysqli_fetch_array($result) ){
						$order_no_cnt++;

					
						
						$price_se = $row['ori_price'] * $row['cnts'];


						$goods_name = $row['goods_name'];
						/*
						if($goods_name == ""){
							$goods_name = "기본";

							$ufile1 = $row["ufile1"];
						}else{
							$ufile1 = $row['bfile'];
						}
						*/
						if($row['option_type'] == "M"){
							$ufile1 = $row["ufile1"];
						}else{
							$ufile1 = $row['bfile'];
						}

					?>
						<tr>
							<td class="ol_item">
								<div class="ol_item_box">
									<a href="javascript:void(0)" class="img_thurm"><span style="background-image: url(/data/product/<?=$ufile1?>);"><img src="/data/product/<?=$ufile1?>" alt="<?=$row['goods_name_front']?>"></span></a><!-- 이미지 사이즈 90x90 -->
									<p class="item_tit"><?=$row['goods_name_front']?></p>
									<ul class="item_option">
										<li><strong>옵션</strong> : <?=$goods_name?></li>
									</ul>
								</div>
							</td>
							<td class="ol_money"><strong><?=number_format($price_se)?></strong>원<p>(<?=number_format($row['cnts'])?>개)</p></td>

						


						</tr>
					<?
						}
					
					?>

					</tbody>
				</table>

			

				


			</div>
		

			




			<div class="tail_menu">
				<ul>
					<li class="left"></li>
					<li class="right_sub">
						
						<a href="javascript:history.go(-1);" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a>
						<? if ($order_code) { ?>
						<!--
						<a href="javascript:send_it()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a>
						-->
						<? }?>
					</li>
				</ul>
			</div>






		</div>
		<!-- // listWrap -->

	</div>
	<!-- // contents -->

	</span><!-- 인쇄 영역 끝 //-->
</div>


<iframe width="0" height="0" name="hiddenFrame22" id="hiddenFrame22" style="display:none;border:solid 1px;"></iframe>

<? include "../_include/_footer.php"; ?>



<!--

oEditors1.getById["info1_ko"].exec("UPDATE_CONTENTS_FIELD", []);
oEditors2.getById["info1_ko"].exec("UPDATE_CONTENTS_FIELD", []);

-->
<script type="text/javascript">


function send_it(){
	var frm = document.r_frm;
	if( confirm("정말 수정하시겠습니까?") ){
		frm.submit();
	}
	
}

function send_it2(){
	var frm = document.r_frm2;

	if(frm.invoice.value==""){
		alert("송장번호를 입력해주세요.");
		frm.invoice.focus();
		return false;
	}

	if( confirm("정말 수정하시겠습니까?\n수정시 상태가 배송중으로 변경됩니다.") ){
		frm.submit();
	}
	
}

function send_it3(){
	var frm = document.r_frm3;

	if(frm.invoice2.value==""){
		alert("송장번호를 입력해주세요.");
		frm.invoice2.focus();
		return false;
	}

	if( confirm("정말 수정하시겠습니까?\n수정시 상태가 배송중으로 변경됩니다.") ){
		frm.submit();
	}
	
}

function fn_memo(){
	var frm = document.m_frm;
	if(frm.memos.value == ""){
		alert("메모내용을 입력해주세요.");
		frm.memos.focus();
		return false;
	}

	frm.submit();
}


function fn_paydel(order_code){
	if(order_code == ""){
		alert("주문번호가 누락되었습니다.");
		return false;
	}
	if(confirm("정말 결제를 취소하시겠습니까?\n취소시 결제금액이 고객에게 넘어갑니다.")){
		hiddenFrame22.location.href="/inicis/INIpay50/INIStdPaySample/card_cancel.php?order_code="+order_code;
	}
}

</script>

