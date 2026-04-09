<?
  include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 

//error_reporting(E_ALL);
//ini_set("display_errors", 1);

  $file_name = date('Y-m-d')." 주문관리";
  $file_name = iconv('UTF-8','EUC-KR',$file_name);

  header("Content-type: application/vnd.ms-excel; charset=UTF-8"); 
  Header("Content-type: charset=utf-8");
  header("Content-Disposition: attachment; filename=".$file_name.".xls");
  Header("Content-Description: PHP3 Generated Data");
  Header("Pragma: no-cache");
  Header("Expires: 0");



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

	
	$limits				= updateSQ($_GET["limits"]);
	
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


	
	if($limits){
		$strlimit = " limit 0, ". $limits;
	}
	
	
	


	if ($search_name)
	{
		$strSql = $strSql." and replace(".$search_category.",'-','') like '%".str_replace("-","",$search_name)."%' ";
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
	$total_sql = " select o.*, t.code_name, t.code_idx, m.user_id, m.user_name
					  from (select * from tbl_order order by regdate desc $strlimit) o
					  left outer join tbl_transcom t
					    on o.invo_corp = t.code_idx
					  left outer join tbl_member m
					    on o.user_id = m.user_id
					 where 1=1
						and o.status not in ('D')
					   $strSql
				 ";
	$result = mysqli_query($connect, $total_sql) or die (mysqli_error($connect));
?>

	<table border="2">
	
		<thead>
			<tr>
				<th>주문일시</th>
				<th>결제일시</th>
				<th>결제수단</th>
				<th>주문번호</th>
				<th>회원그룹</th>
				<th>주문자명</th>
				<th>수취인</th>
				<th>송장번호</th>
				<th>수취인주소</th>
				<th>수취인상세주소</th>
				<th>휴대전화</th>
				<th>추가연락처</th>
				<th>배송메모</th>
				<th>카테고리</th>
				<th>브랜드</th>
				<th>제품명</th>
				<th>옵션</th>
				<th>실제구매수량</th>
				<th>판매가</th>
				<th>결제금액</th>
				<th>사용포인트</th>
<!-- 				<th>쿠폰번호</th> -->
<!-- 				<th>쿠폰번호 할인율/할인금액</th> -->
				<th>배송비</th>

			</tr>
		</thead>	
		<tbody>
			<?
				$sql    = $total_sql . " order by o.regdate desc ". $strlimit;
				$result = mysqli_query($connect, $sql) or die (mysqli_error($connect));
				

				while($row = mysqli_fetch_array($result)){
					
					$sql_s = "select s.ori_price
									,s.last_price
									,s.nocoupon_price
									,s.cnts
									,s.coupons
									,s.options
					                ,g.goods_name_front
									,g.product_code
									,g.g_idx
									,c.code_name as catename
									,b.code_name as brand_name
									
									,o.goods_cnt
									,o.goods_name
									,o.goods_price
									,o.option_type
									,s.coupons
									,s.coupon_dc_price
									,cp.coupon_num
									,cp.types
					            from tbl_order_sub s
								left outer join tbl_goods g
								  on s.g_idx = g.g_idx
								left outer join tbl_goods_option o
								  on s.options = o.idx
								left outer join tbl_brand b
								  on g.goods_brand = b.code_no

								left outer join tbl_coupon cp
								  on s.coupons = cp.c_idx

								left outer join tbl_code c
								  on SUBSTRING_INDEX( mid(g.product_code,2,CHAR_LENGTH(g.product_code)-2 ) , '||', 1) = c.code_idx

							   where s.order_code = '".$row['order_code']."' 
							   order by s.idx asc ";
					$result_s = mysqli_query($connect, $sql_s) or die (mysqli_error($connect));
					
					$_sub_total = mysqli_num_rows($result_s);

					$order_no_cnt = 0;

					while($row_s = mysqli_fetch_array($result_s)){
					$order_no_cnt++;
					
					if($row_s['options'] == 0){
						$_tmp_se_price = (viewGoodsPay($row_s['g_idx']) * $row_s['cnts']);
					}else{
											

					//필수 옵션일 때는 상품 가격을 더해줌.
					if($row_s['option_type'] == "M"){					
						$_tmp_se_price = (viewGoodsPay($row_s['g_idx']) + $row_s['goods_price'] * $row_s['cnts']);
					}else{
						$_tmp_se_price = ($row_s['goods_price'] * $row_s['cnts']);
						}
					}
			?>

						<tr>
							<td><?=$row['regdate']?></td>

							<td>
								<?if($row['applDate']){?>
								<?=substr($row['applDate'],0,4)."-".substr($row['applDate'],4,2)."-".substr($row['applDate'],6,2)?> <?=substr($row['applTime'],0,2).":".substr($row['applTime'],2,2).":".substr($row['applTime'],4,2)?>
								<?}?>
							</td>
							<td><?=$_pg_Method[$row['payMethod']]?></td>
							<td><?=$row['order_code']?></td>
							<td>
								<?
								if($row['user_id']){
									echo "일반회원";
								}else{
									echo "비회원";
								}
								?>
							</td>
							<td><?=$row['user_name']?></td>
							<td><?=$row['receive_name']?></td>
							<td><?=$row['invoice']?></td>
							<td><?=$row['addr1']?></td>
							<td><?=$row['addr2']?></td>
							<td><?=$row['hp']?></td>
							<td><?=$row['tel']?></td>
							<td><?=$row['memo']?></td>
							<td><?=$row_s['catename']?></td>
							<td><?=$row_s['brand_name']?></td>
							<td><?=$row_s['goods_name_front']?></td>
							<td><?=$row_s['goods_name']?></td>


							
							<td><?=number_format($row_s['cnts'])?></td>
							<td><?=number_format($_tmp_se_price)?></td>
							<?if($order_no_cnt == 1){?>
							<td rowspan="<?=$_sub_total?>">
								<?=number_format($row['total_price'])?>
							</td>
							<td rowspan="<?=$_sub_total?>">
								<?=number_format($row['usecash'])?>
							</td>
							<?}?>
							<!--<td>
							<?
							if($row_s['coupons']>0){
								echo $_set_coupon_type[$row_s['types']]."<br/>";
								echo $row_s['coupon_num'];
							}
							?>
							</td>-->
<!-- 							<td><?=number_format($row_s['coupon_dc_price'])?></td> -->
							<td><?=number_format($row['delivery_price'])?></td>
						</tr>

			<?  
					}
				}
			?>
			
		</tbody>
	</table>
	