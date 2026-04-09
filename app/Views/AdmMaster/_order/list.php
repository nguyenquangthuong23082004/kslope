<? include "../_include/_header.php"; ?>
<script src="./order_list.js"></script>
<?
	alert_msg($msg, "/AdmMaster/_inquiry/list_join.php");
	$arrays_paging = "";

	// 배송 업체 배열로 미리 받기
	$sql_d = " select *	from tbl_transcom where status = 'Y' $strSql ";
	$result_d = mysqli_query($connect, $sql_d) or die (mysqli_error($connect));
	while( $row_d = mysqli_fetch_array($result_d) ){
		$_arr_invo_corp[$row_d["code_idx"]] = $row_d["code_name"];
	}


	$g_list_rows		= 15;
	$pg					= updateSQ($_GET["pg"]);
	$search_name		= updateSQ($_GET["search_name"]);
	$search_category	= updateSQ($_GET["search_category"]);
	$date_chker			= updateSQ($_GET["date_chker"]);
	$s_date				= updateSQ($_GET["s_date"]);
	$e_date				= updateSQ($_GET["e_date"]);
	$s_time				= updateSQ($_GET["s_time"]);
	$e_time				= updateSQ($_GET["e_time"]);

	
	$type_chker			= $_GET["type_chker"];
	$state_chker = $_GET["state_chker"];


	if( sizeof($type_chker) > 0){
		
		$strSql = $strSql." and payMethod in (";
		$_tmp_cnt = 0;
		foreach($type_chker as $vals){
			if($_tmp_cnt>0){
				$strSql = $strSql.",";
			}
			$strSql = $strSql." '".$vals."' ";
			$_tmp_cnt++;

			$arrays_paging .= "&type_chker[]=".$vals;
		}
		//'Card') ";

		$strSql = $strSql." ) ";
	}

	if( sizeof($state_chker) > 0){
		
		$strSql = $strSql." and o.status in (";
		$_tmp_cnt = 0;
		foreach($state_chker as $vals){
			if($_tmp_cnt>0){
				$strSql = $strSql.",";
			}
			$strSql = $strSql." '".$vals."' ";
			$_tmp_cnt++;
			$arrays_paging .= "&state_chker[]=".$vals;
		}
		//'Card') ";

		$strSql = $strSql." ) ";
	}



	if($s_date){
		if($s_time) {
			$strSql = $strSql . " and date_format($date_chker,'%Y-%m-%d %H') >= '$s_date $s_time' ";
		} else {
			$strSql = $strSql . " and date_format($date_chker,'%Y-%m-%d') >= '$s_date' ";
		}
	}

	if($e_date){
		if($e_time) {
			$strSql = $strSql . " and date_format($date_chker,'%Y-%m-%d %H') >= '$e_date $e_time' ";
		} else {
			$strSql = $strSql . " and date_format($date_chker,'%Y-%m-%d') >= '$e_date' ";
		}
	}

	

	
	$strSql_g = "";
	if ($search_name!='' && $search_category != '')
	{
		if( $search_category == 'no_id'){
			$strSql = $strSql." and user_id = '' ";
		}else if( $search_category == 'oc'){
			//echo "search_category : " . $search_category . "<br/>";
			$strSql = $strSql." and o.order_code like '%" . $search_name."%' ";
		}else if( $search_category == 'goods_name_front'){
			$strSql_g = " where goods_name_front like '%" . $search_name."%' ";

		}else{
			$strSql = $strSql." and replace(".$search_category.",'-','') like '%".str_replace("-","",$search_name)."%' ";
		}
	}else if ($search_name!='' && $search_category == '')	// 전체검색
	{
		
		$strSql_g = " where goods_name_front like '%" . $search_name."%' ";
		

		
		$strsql_all = "or receive_name like '%".str_replace("-","",$search_name)."%' ";
		$strsql_all = $strsql_all." or order_code like '%" . $search_name."%' ";
		$strsql_all = $strsql_all." or user_id like '%".str_replace("-","",$search_name)."%' ";
		$strsql_all = $strsql_all." or invoice like '%".str_replace("-","",$search_name)."%' ";
		$strsql_all = $strsql_all." or hp like '%".str_replace("-","",$search_name)."%' ";
		$strsql_all = $strsql_all." ";
		
		
		

	}


	if ($s_product_code_1)
	{
		$strSql = $strSql." and product_code_1 = '".$s_product_code_1."' ";
	}
	if ($s_product_code_2)
	{
		$strSql = $strSql." and product_code_2 = '".$s_product_code_2."' ";
	}
	if ($s_product_code_3)
	{
		$strSql = $strSql." and product_code_3 = '".$s_product_code_3."' ";
	}



	// 상품조회
	$total_sql = " select o.*, t.code_name, t.code_idx
					  from (
							select * from tbl_order where order_code in (
							  select distinct order_code from tbl_order_sub where g_idx in (select g_idx from tbl_goods $strSql_g )
													) $strsql_all
							   ) 
						  o					  
					  left outer join tbl_transcom t
					    on o.invo_corp = t.code_idx
					 where o.status not in ('D','')  
					   $strSql
				 ";   // not in D
	//echo $total_sql . "<br/>";
	$result = mysqli_query($connect, $total_sql) or die (mysqli_error($connect));
	$nTotalCount = mysqli_num_rows($result);
	//echo $total_sql;
?>
		<div id="container" class="gnb_order">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>주문관리</h2>
					<div class="menus">
						<ul class="first">
						</ul>
					</div>
				</div><!-- // inner -->
			</header><!-- // headerContainer -->
			<div id="contents">
				<form name="search" id="search">
					<input type="hidden" name="limits" id="limits" />
				<header id="listBottom">

					<!-- 시작 -->

					<table cellpadding="0" cellspacing="0" summary="" class="listTable01" style="table-layout:fixed;">
						<colgroup>
							<col width="150">
							<col width="*">
						</colgroup>
						<thead>
							<tr>
								<th colspan="2"></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="label">결제방법</td>
								<td class="inbox">
								<p>
									<span><input name="type_chker[]" type="checkbox" value="Card" <?if(in_array("Card", $type_chker))echo"checked";?> ></span>
									<span>카드결제</span>
									&nbsp;&nbsp;
								</p>
								<p>
									<span><input name="type_chker[]" type="checkbox" value="VBank" <?if(in_array("VBank", $type_chker))echo"checked";?> ></span>
									<span>무통장(가상계좌)</span>
									&nbsp;&nbsp;
								</p>
								<p>
									<span><input name="type_chker[]" type="checkbox" value="Dbank" <?if(in_array("Dbank", $type_chker))echo"checked";?> ></span>
									<span>무통장(일반)</span>
									&nbsp;&nbsp;
								</p>
								<p>
									<span><input name="type_chker[]" type="checkbox" value="DirectBank" <?if(in_array("DirectBank", $type_chker))echo"checked";?> ></span>
									<span>실시간 계좌이체</span>
									&nbsp;&nbsp;
								</p>
								</td>
							</tr>
							<tr>
								<td class="label">주문상품상태 <input id="chk_all_order_item_state" type="checkbox"></td>
								<td class="inbox">
									<p>
										<span>
										<?
										foreach($_deli_type as $key => $value ){ 
											if($key == "D")
												continue;
										?>
											<p>	
												<input name="state_chker[]" class="state_chker" type="checkbox" value="<?=$key?>"  <?if(in_array($key, $state_chker))echo"checked";?> > <?=$value?>&nbsp;&nbsp;
											</p>
										<?}?>
										</span>
									</p>
								</td>
							</tr>
							<tr>
								<td class="label">기간검색</td>
								<td class="inbox">

									<p>
										<select name="date_chker" id="date_chker" class="select_02" >
											<option value="regdate" <?if($date_chker=="regdate")echo"selected";?> >주문일</option>
											<option value="applDate" <?if($date_chker=="applDate")echo"selected";?> >결제일</option>
											<option value="return_date" <?if($date_chker=="return_date")echo"selected";?> >반품접수일</option>
											<option value="complete_date" <?if($date_chker=="complete_date")echo"selected";?> >배송완료일</option>
										</select>&nbsp;	
									</p>

									<div class="contact_btn_box">
										<div>
											<button type="button" rel="<?=date('Y-m-d')?>" class="contact_btn" title="today">오늘</button>
											<button type="button" rel="<?=date('Y-m-d', strtotime('-1 week'));?>" class="contact_btn" title="week">1주일</button>
											<button type="button" rel="<?=date('Y-m-d', strtotime('-1 month'));?>" class="contact_btn" title="1month">1개월</button>
											<button type="button" rel="<?=date('Y-m-d', strtotime('-6 month'));?>" class="contact_btn" title="6month">6개월</button>
											<button type="button" rel="<?=date('Y-m-d', strtotime('-1 year'));?>" class="contact_btn" title="year">1년</button>
											<input type="text" name="s_date" id="s_date" value="<?=$s_date?>" class="date_form" ><span>~</span><input type="text" name="e_date" id="e_date" value="<?=$e_date?>" class="date_form" >
											<div id="time_layer" style="float: left; display: <?= (trim($s_time) == "" && trim($e_time) == "" ? "none" : "") ?>;">
												<select id="s_time" name="s_time">
													<option value="">선택</option>
													<?php for($t=1; $t<=23; $t++) { ?>
														<option value="<?=$t?>" <?=((int)($s_time) == $t ? "selected" : "")?> ><?=((int)($t) < 10 ? "0" . (int)($t) : (int)($t))?></option>
													<?php } ?>
												</select> ~
												<select id="e_time" name="e_time">
													<option value="">선택</option>
													<?php for($t=1; $t<=23; $t++) { ?>
														<option value="<?=$t?>" <?=((int)($e_time) == $t ? "selected" : "")?> ><?=((int)($t) < 10 ? "0" . (int)($t) : (int)($t))?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
								</td>
							</tr>
							

							
							<tr>
								<td class="label">검색어</td>
								<td class="inbox">
									
									<div class="r_box">
										<select id="" name="search_category" class="input_select" style="width:112px">
											<option value="" >전체검색</option>
											<option value="receive_name" <?if($search_category=="receive_name")echo"selected";?> >수취인 이름</option>
											<option value="oc" <?if($search_category=="oc")echo"selected";?> >주문번호</option>
											<option value="user_id" <?if($search_category=="user_id")echo"selected";?> >주문자 ID</option>
											<option value="no_id" <?if($search_category=="no_id")echo"selected";?> >비회원</option>
											<option value="invoice" <?if($search_category=="invoice")echo"selected";?> >운송장번호</option>
											<option value="hp" <?if($search_category=="hp")echo"selected";?> >수취인 휴대폰</option>
											
											<option value="goods_name_front" <?if($search_category=="goods_name_front")echo"selected";?> >제품명</option>
										</select>
										<input type="text" id="search_name" name="search_name" value="<?=$search_name?>" class="input_txt placeHolder" placeholder="검색어 입력" style="width:240px" onkeyDown="if(event.keyCode==13)search_it();" />

										<a href="javascript:search_it()" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> <span class="txt">검색</span></a>
									</div>
								</td>
							</tr>
							<tr>
								<td class="label">엑셀받기</td>
								<td class="inbox">
									
									<a id="btn_change_order_state2" href="javascript:get_excel(500);" class="change_btn01">다운(최근 500건)</a>
									<a id="btn_change_order_state3" href="javascript:get_excel_chk();" class="change_btn01" style="margin-left:10px;">다운(선택받기)</a>
									<!--
									<a id="btn_change_order_state" href="javascript:get_excel();" class="change_btn01">다운</a>
									-->
								</td>
							</tr>

						</tbody>
					</table>
				</header><!-- // headerContents -->
				</form>


				<script>
				function search_it()
				{
					var frm = document.search;
					if (frm.search_name.value == "검색어 입력")
					{
						frm.search_name.value = "";
					}
					frm.action = "";
					frm.submit();
				}
				</script>

				<div class="listWrap">
					<!-- 안내 문구 필요시 구성 //-->

				
				
		

					
					<div class="listTop">
						<div class="left">
							<p class="schTxt">■ 총 <?=number_format($nTotalCount)?>개의 목록이 있습니다.</p>
						</div>

					</div><!-- // listTop -->
					
					
					



					<form name="frm" id="frm">
						<input type="hidden" name="chg_type" id="chg_type" />

					<div class="listBottom">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable" style="table-layout:fixed;">
						<caption></caption>
						<colgroup>
						<col width="3%" />
						<col width="6%" />
						<col width="8%" />
						<col width="5%" />
						<col width="*" />
						<col width="8%" />
						<col width="8%" />
						<col width="3%" />
						<col width="5%" />
						<col width="5%" />
						<col width="8%" />
						<col width="8%" />
						<col width="8%" />
						<col width="7%" />
						<col width="6%" />
						<col width="5%" />
						</colgroup>
						<thead>
							<tr>
								<th><input class="cb1" type="checkbox" onclick="CheckAll($('input[name=\'idx[]\']'),this.checked );" ></th>
								<th>상세보기</th>
								<th>주문번호</th>
								<th>이미지</th>
								<th>운송장번호</th>
								<th>주문자</th>
								<th>옵션</th>
								<th>수량</th>
								<th>단가</th>
								<th>쿠폰할인</th>
								<th>결제금액</th>
								<th>사용포인트</th>
								<th>결제방법</th>
								<th>상태</th>
								<th>주문일자<br/>결제일자</th>
								<th>수정</th>
							</tr>
						</thead>	
						<tbody>
							<?
								$nPage = ceil($nTotalCount / $g_list_rows);
								if ($pg == "") $pg = 1;
								$nFrom = ($pg - 1) * $g_list_rows;
								
								$sql    = $total_sql . " order by o.regdate desc limit $nFrom, $g_list_rows ";
								//echo $sql."<br/>";
								$result = mysqli_query($connect, $sql) or die (mysql_error($connect));
								$num = $nTotalCount - $nFrom;
								
								
								if ($nTotalCount == 0) {
							?>
								<tr>
									<td colspan="14" style="text-align:center;height:100px">검색된 결과가 없습니다.</td>
								</tr>
							<?
								}
							?>


							<?
								while($row = mysqli_fetch_array($result)){

									if($row['user_id']){
										$sql_me = "select * from tbl_member where user_id = '".$row['user_id']."' ";
										$result_me = mysqli_query($connect, $sql_me) or die (mysql_error($connect));
										$row_me = mysqli_fetch_array($result_me);
										$jumun_name = $row_me['user_name'];
									}else{
										$jumun_name = $row['receive_name'];
									}


									$sql_sub = " select b.options, b.cnts, b.coupons, b.ori_price, b.coupon_dc_price, go.goods_name, go.goods_price, go.bfile, go.option_type, g.*
												  from tbl_order_sub b
												  left outer join tbl_goods g
													on b.g_idx = g.g_idx
												  left outer join tbl_goods_option go
													on b.options = go.idx
												 where b.order_code = '".$row['order_code']."'
												 ";
									$result_sub = mysqli_query($connect, $sql_sub) or die (mysql_error($connect));

									
									$_sub_total = mysqli_num_rows($result_sub);
									
									$order_no_cnt = 0;
									while( $row_sub = mysqli_fetch_array($result_sub) ){
										$order_no_cnt++;
										
										$_tmp_se_price = ($row_sub['ori_price'] * $row_sub['cnts']);
										$_tmp_dc_price = $row_sub['coupon_dc_price'];


										$goods_name = $row_sub['goods_name'];
										/*
										if($goods_name == ""){
											$goods_name = "기본";

											$ufile1 = $row_sub["ufile1"];
										}else{
											$ufile1 = $row_sub['bfile'];
										}
										*/
										if($row_sub['option_type'] == "M"){
											$ufile1 = $row_sub["ufile1"];
										}else{
											$ufile1 = $row_sub['bfile'];
										}
																		
							?>

										<tr>
											<?if($order_no_cnt == 1){?>

											<td rowspan="<?=$_sub_total?>"><input type="checkbox" name="idx[]" class="idx code_idx" value="<?=$row['idx']?>"  /></td>
											<td rowspan="<?=$_sub_total?>"><a href="view.php?order_code=<?=$row['order_code']?>"><span class="edit_btn">VIEW</span></a></td>
											<td rowspan="<?=$_sub_total?>">
												<p class="categore"><?=$row['order_code']?></p>
											</td>

											<?}?>


											<td>
												<p class="categore">
													<img src="/data/product/<?=$ufile1?>" alt="<?=$row_sub['goods_name_front']?>">
												</p>
											</td>

											<?if($order_no_cnt == 1){?>
											<td rowspan="<?=$_sub_total?>">
												<?=$_arr_invo_corp[$row['code_idx']]?> <?=$row['invoice']?><br/>
												<button type="button" class="btn btn-default val02" onclick="#de_pop" rel="<?=$row['idx']?>" >운송장번호등록</button>
												<!--
												<select name="invo_corp" >
													<option value="">선택안함</option>
													<?
													foreach($_arr_invo_corp as $keys => $values){
													?>
														<option value="<?=$keys?>" <?if($keys==$row['code_idx'])echo"selected"; ?> ><?=$values?></option>
													<?}?>
												</select>
												<input type="text" class="onlynump" name="invoice" id="invoice" value="<?=$row['invoice']?>" style="width:200px;" />
												-->
												
											</td>
											<td rowspan="<?=$_sub_total?>">
												<?=$jumun_name?><br/>
												<?
													if($row['user_id'] == ""){
														echo "비회원";
													}else{
														echo $row['user_id'];
													}
												?>
											</td>
											<?}?>


											<td>
												<p class="item_tit"><?=$row_sub['goods_name_front']?></p>
												<ul class="item_option">
													<li><strong>옵션</strong> : <?=$goods_name?></li>
												</ul>
											</td>
											<td>
												<?=number_format($row_sub['cnts'])?>
											</td>
											<td>
												<?=number_format($_tmp_se_price)?>원
											</td>
											<td>
												<?=number_format($_tmp_dc_price)?>원
											</td>

											<?if($order_no_cnt == 1){?>

											<td class="price" rowspan="<?=$_sub_total?>">
												<p><span><?=number_format($row['total_price'])?>원</span></p>
											</td>
											<td rowspan="<?=$_sub_total?>">
												<?if($row['usecash']){?>
												<?=number_format($row['usecash'])?>P
												<?}?>
											</td>

											<td rowspan="<?=$_sub_total?>">
												<?=$_pg_Method[$row['payMethod']]?>
											</td>
											<td rowspan="<?=$_sub_total?>">
												<?//=$_deli_type[$row['status']]?>
												
												

												<select name="status" id="status" <?if($row_t['status'] == "C")echo "disabled=disabled";?> >
												<? foreach($_deli_type as $key => $value ){ ?>
													<option value="<?=$key?>" <?if($key == $row['status'] )echo "selected";?> ><?=$value?></option>
												<?}?>
												</select>

												
												

												<?if($row['status']=="P"){?>
												<button type="button" class="open_exchange" onclick="fn_chg_option('<?=$row['order_code']?>')">교환</button>
												<?}?>
											</td>
											<td class="date" rowspan="<?=$_sub_total?>">
												<?=substr($row['regdate'],0,10)?> / <?=substr($row['regdate'],11,8)?>
												<?if($row['applDate']){?>
												<br/>
												<?=substr($row['applDate'],0,4)."-".substr($row['applDate'],4,2)."-".substr($row['applDate'],6,2)?> / <?=substr($row['applTime'],0,2).":".substr($row['applTime'],2,2).":".substr($row['applTime'],4,2)?>
												<?}?>
											</td>
											<td rowspan="<?=$_sub_total?>">
												<img src="/AdmMaster/_images/common/ico_setting2.png" alt="설정" onclick="fn_mod('<?=$row['idx']?>', this);" style="cursor:pointer;" />
											</td>

											<?}?>
										</tr>

							<? 
									}
								} 
							?>
							
						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

					<?
					/*
					."&type_chker=".$type_chker."&state_chker=".$state_chker
					*/

					
					echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF]."?s_date=".$s_date."&e_date=".$e_date."&date_chker=".$date_chker."&search_category=".$search_category."&search_name=".$search_name.$arrays_paging."&pg=");
					
					?>


					<div id="headerContainer">
						
						<div class="inner">
							<div class="menus">
								<ul class="first">
								</ul>

								
							</div>

						</div><!-- // inner -->

					</div><!-- // headerContainer -->
				</div><!-- // listWrap -->

			</div><!-- // contents -->





		</span><!-- 인쇄 영역 끝 //-->
		</div><!-- // container -->


		<form name="frm_os" id="frm_os" method="post" action="./chg_option_ajax.php" target="hiddenFrame22" >
		<div class="exchange_popup">
			<div class="popup" style="display:block;">
				<h3>주문번호 : <span id="pop_ordernum"></span></h3>
				<div class="chg_orders">
					<!--
					<div>
						<input type="checkbox">
						<img src="/data/product/20180131150107.gif" alt="">
						<ul>
							<li><strong>상품명 : </strong> <span>써니스톰제타</span></li>
							<li>
								<strong>색상 : </strong> 
								<select name="" id="">
									<option value="">레드</option>
									<option value="">블루</option>
								</select>
							</li>
							<li>
								<strong>사이즈 : </strong> 
								<select name="" id="">
									<option value="">220</option>
									<option value="">225</option>
								</select>
							</li>
						</ul>
					</div>
					-->
				</div>
				
				<div class="btn_box">
					<button type="button" class="close_exchange">취소</button>
					<button type="button" onclick="fn_chg_goods()" >교환</button>
				</div>
				<a href="return:void(0);" class="close_exchange"><img src="/img/btn/btn_close_basket01.png" alt=""></a>
			</div>
		</div>
		</form>



		<div class="coupon_pop" id="de_pop">
			<div>
				<form action="invo_update.php">
					<input type="hidden" name="idx" id="invos_idx" value="" />

					<div class="search_box">
					<h2>운송장번호등록</h2>
						
						<select id="invo_corp" name="invo_corp" class="input_select" >
							<option value="">선택안함</option>
							<?
							foreach($_arr_invo_corp as $keys => $values){
							?>
								<option value="<?=$keys?>" <?if($keys==$row['code_idx'])echo"selected"; ?> ><?=$values?></option>
							<?}?>
						</select>

						<input type="text" name="invoice" id="invoice" style="margin-top:10px;" ><button type="button" onclick="fn_mod2(this);" class="search" style="margin-top:10px;" >등록</button>
					</div>
					<!--<div class="table_box">
						<table>
						<caption>상품찾기</caption>
							<tbody id="id_contents">

							</tbody>
						</table>
					</div>		-->		
					<div class="sel_box">
						<div>
							<button type="button" class="close">취소</button>
						</div>		
					</div>
				</form>	
			</div>			
		</div>









<script>

$(function(){
	$("div.listBottom table.listTable tbody td button.val02").click(function(){
		var idx = $(this).attr("rel");
		$("#invos_idx").val(idx);
		$(".coupon_pop").show();
	});
	$(".coupon_pop > div .sel_box div .close").click(function(){
		$("#invos_idx").val("");
		$("#invoice").val("");
		$(".coupon_pop").hide();
	});
});

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
	$(document).ready(function(){
		$('.open_exchange').on('click',function(){
			$('.exchange_popup').css({'display':'block'});
			$('body').css({'overflow': 'hidden', 'height': '100%'}); 
			$('#element').on('scroll touchmove mousewheel', function(event) {  event.preventDefault();  event.stopPropagation();   return false; })
		});
		$('.close_exchange').on('click',function(){
			$(".chg_orders").html("");
			$('.exchange_popup').css({'display':'none'});
			$('body').css({'overflow': 'auto', 'height': '100%'});
			$('#element').off('scroll touchmove mousewheel');
		});
		$('.exchange_popup').on('click',function(e){
			if ($(e.target).hasClass('exchange_popup')) {
					$('.exchange_popup').css({'display':'none'});
					$('body').css({'overflow': 'auto', 'height': '100%'});
					$('#element').off('scroll touchmove mousewheel');
			}
		});

	}); 
		
</script>

<? include "../_include/_footer.php"; ?>


<iframe width="0" height="0" name="hiddenFrame22" id="hiddenFrame22" style="display:none;"></iframe>