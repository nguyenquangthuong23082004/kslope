<? include "../_include/_header.php"; ?>
<link rel="stylesheet" href="/AdmMaster/_common/css/sms_contents.css" type="text/css" />

<style type="text/css">
	.radio_sel span{margin-right:15px;}
</style>
<div class="page-heading mb-4">
    
    <div class="d-flex justify-content-between align-items-center">
        <header class="d-block d-xl-none pb-2">
            <a href="#" class="d-block burger-btn d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <h4 class="text-center">정책 설정</h4>
    </div>
</div>
<div id="container" class="gnb_setting"> <span id="print_this"><!-- 인쇄영역 시작 //-->
	
	<header id="headerContainer">
		<div class="inner">
			<div class="menus">
				<ul >
					<li><a href="javascript:send_its()" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">수정</span></a></li>
				</ul>
			</div>
		</div>
		<!-- // inner --> 
		
	</header>
	<!-- // headerContainer -->
	
	<div id="contents">
		<div class="listWrap_noline">
			<form name="frm" id="frm" action="stock_update.php" method="post"enctype="multipart/form-data" >


			
			<?
				$total_sql = " select * from tbl_define where idx='1' ";
				$result = mysqli_query($connect, $total_sql) or die (mysqli_error($connect));
				$row=mysqli_fetch_array($result);	
			?>
			
			
			<div class="listTop">
				<div class="left">
					<p class="schTxt">■ 자동 주문취소</p>
				</div>
			</div>
			
			
			<div class="listBottom">

				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail">
					<caption>
					</caption>
					<colgroup>
						<col width="200px" />
						<col width="*" />
					</colgroup>
					<tbody>


						<tr>
							<th>자동 주문취소일</th>
							<td>
								<input type="text" name="order_delay_days" id="order_delay_days" class="onlynum" style="width:40px;text-align:right;" maxlength="2" value="<?=$row['order_delay_days']?>" /> 일 동안 입금하지 않은 무통장입금 주문을 자동으로 주문취소합니다.
							</td>
						</tr>

						<tr style="display:none;">
							<th>자동복원 설정</th>
							<td>
								<p>
									<input type="radio" name="order_stock_repair" id="stock_repair1" value="Y" <?if($row['order_stock_repair'] == "Y")echo"checked=checked";?> /> <label for="stock_repair1">재고량 자동으로 복원</label>
									<input type="radio" name="order_stock_repair" id="stock_repair2" value="N" <?if($row['order_stock_repair'] == "N")echo"checked=checked";?> /> <label for="stock_repair2">개별 수정</label>
								</p>
								<p>
									<input type="radio" name="order_point_repair" id="point_repair1" value="Y" <?if($row['order_point_repair'] == "Y")echo"checked=checked";?> /> <label for="point_repair1">적립금 자동으로 복원</label>
									<input type="radio" name="order_point_repair" id="point_repair2" value="N" <?if($row['order_point_repair'] == "N")echo"checked=checked";?> /> <label for="point_repair2">복원 안됨</label>
								</p>
								<p>
									<input type="radio" name="order_coupon_repair" id="coupon_repair1" value="Y" <?if($row['order_coupon_repair'] == "Y")echo"checked=checked";?> /> <label for="coupon_repair1">쿠폰 자동으로 복원</label>
									<input type="radio" name="order_coupon_repair" id="coupon_repair2" value="N" <?if($row['order_coupon_repair'] == "N")echo"checked=checked";?> /> <label for="coupon_repair2">복원 안됨</label>
								</p>
							</td>
						</tr>

						

					</tbody>
				</table>
			</div>



			<div class="listTop">
				<div class="left">
					<p class="schTxt">■ 적립금 정책</p>
				</div>
			</div>
			
			
			<div class="listBottom">

				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail">
					<caption>
					</caption>
					<colgroup>
						<col width="200px" />
						<col width="*" />
					</colgroup>
					<tbody>

						<tr>
							<th>적립금 적립 사용</th>
							<td>
								<input type="radio" name="point_give_use" id="give_use1" value="Y" <?if($row['point_give_use'] == "Y")echo"checked=checked";?> /> <label for="give_use1">적립금 지급함</label>
								<input type="radio" name="point_give_use" id="give_use2" value="N" <?if($row['point_give_use'] == "N")echo"checked=checked";?> /> <label for="give_use2">복원 안됨</label>
							</td>
						</tr>


						<tr>
							<th>주문합계 기준</th>
							<td>
								주문총액이 <input type="text" name="point_use_order_total" id="point_use_order_total" class="onlynum" style="width:100px;text-align:right;" value="<?=$row['point_use_order_total']?>" /> 원 이상일때만 적립금을 사용 할 수 있습니다.
							</td>
						</tr>

						<tr>
							<th>적립금 최소 사용금액</th>
							<td>
								적립금이 최소 <input type="text" name="point_use_minimum_point" id="point_use_minimum_point" class="onlynum" style="width:100px;text-align:right;" value="<?=$row['point_use_minimum_point']?>" /> 원 이상일때 사용 할 수 있습니다.
							</td>
						</tr>

						<tr>
							<th>적립금 최대 사용금액</th>
							<td>
								 적립금은 최대 <input type="text" name="point_use_maximum_point" id="point_use_maximum_point" class="onlynum" style="width:100px;text-align:right;" value="<?=$row['point_use_maximum_point']?>" /> 원 까지 사용 할 수 있습니다.
							</td>
						</tr>

						<tr>
							<th>회원가입 포인트</th>
							<td>
								 <input type="text" name="member_agree_point" id="member_agree_point" class="onlynum" style="width:100px;text-align:right;" value="<?=$row['member_agree_point']?>" /> 원
							</td>
						</tr>

						<tr>
							<th>적립금 포인트</th>
							<td>
								 <input type="text" name="goods_point" id="goods_point" class="onlynum" style="width:100px;text-align:right;" value="<?=$row['goods_point']?>" /> %
							</td>
						</tr>

						

					</tbody>
				</table>
			</div>



			<div class="listTop">
				<div class="left">
					<p class="schTxt">■ 배송비 기본 정책</p>
				</div>
			</div>


			<div class="listBottom">

				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail">
					<caption>
					</caption>
					<colgroup>
						<col width="200px" />
						<col width="*" />
					</colgroup>
					<tbody>

						<tr>
							<th>기본배송 정책</th>
							<td>
								총구매금액이 <input type="text" name="transfer_pay_free_total" id="transfer_pay_free_total" class="onlynum" style="width:100px;text-align:right;" value="<?=$row['transfer_pay_free_total']?>" /> 이상일때 무료, 미만일 때 
								<select name="transfer_pay_type" >
									<option value="BEFORE"  <?if($row['transfer_pay_type'] == "BEFORE")echo"selected=selected";?>  >선불</option>
									<option value="AFTER"   <?if($row['transfer_pay_type'] == "AFTER")echo"selected=selected";?>  >착불</option>
								</select> <input type="text" name="transfer_pay_price" id="transfer_pay_price" class="onlynum" style="width:100px;text-align:right;" value="<?=$row['transfer_pay_price']?>" /> 원 배송비 부과.
							</td>
						</tr>


						<tr>
							<th>배송비 적용기준</th>
							<td>
								<input type="radio" name="transfer_pay_standard" id="pay_standard1" value="Y" <?if($row['transfer_pay_standard'] == "Y")echo"checked=checked";?> /> <label for="pay_standard1">주문상품의 결제가 기준</label>
								<input type="radio" name="transfer_pay_standard" id="pay_standard2" value="N" <?if($row['transfer_pay_standard'] == "N")echo"checked=checked";?> /> <label for="pay_standard2">주문상품의 정상가 기준 </label>
							</td>
						</tr>


					</tbody>
				</table>
			</div>

			
			</form>
			
				
				
				
			
		</div>
		<!-- // listWrap --> 


		
		
	</div>
	<!-- // contents --> 
	
	</span><!-- 인쇄 영역 끝 //--> 
</div>
<!-- // container --> 

<script>
	function send_its()
	{
		
		$("#frm").submit();
	}



	




</script>

<? include "../_include/_footer.php"; ?>
