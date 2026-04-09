<?
  include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 


	if(!isset($_POST['idx'])) exit;

	$_in_idx = "";
	
	if( sizeof($idx) > 0 ){

		foreach($idx as $value){
			if($_in_idx != ""){
				$_in_idx .= ", ";
			}

			$_in_idx .= "'" . $value . "'";
		}
	}

$file_name = date('Y-m-d')." 선택 리뷰관리";
$file_name = iconv('UTF-8','EUC-KR',$file_name);

  header("Content-type: application/vnd.ms-excel; charset=UTF-8"); 
  Header("Content-type: charset=utf-8");
  header("Content-Disposition: attachment; filename=".$file_name.".xls");
  Header("Content-Description: PHP3 Generated Data");
  Header("Pragma: no-cache");
  Header("Expires: 0");


	// 리뷰조회
	$total_sql = " 
		select * from tbl_review2 
			where idx in (".$_in_idx.")
	";
	//echo "aa : " . $total_sql;
	//exit;
	$result = mysqli_query($connect, $total_sql) or die (mysql_error($connect));
?>

	<table border="2">
	
		<thead>
			<tr>
				<th>순서</th>
				<th>카테고리</th>
				<th>모델명</th>
				<th>약정기간</th>
				<th>고객명</th>
				<th>명의자연락처</th>
				<th>수령자연락처</th>
				<th>제목</th>
				<th>우편번호</th>
				<th>수령주소1</th>
				<th>수령주소2</th>
				<th>사은품</th>
				<th>메모</th>
				<th>상태</th>
				<th>발송여부</th>
				<th>등록일</th>
			</tr>
		</thead>	
		<tbody>
			<?
				$sql    = $total_sql . " order by regdate desc ". $strlimit;
				$result = mysqli_query($connect, $sql) or die (mysql_error($connect));

				$num = 1;
				while($row = mysqli_fetch_array($result)){

					//카테고리명 구하기
					$g_sql = "select * from tbl_goods where g_idx = '".$row['g_idx']."' ";
					$g_result = mysqli_query($connect, $g_sql);
					$g_row = mysqli_fetch_array($g_result);
					$goods_name = $g_row['goods_name_front'];
					if($goods_name == ""){
						$goods_name = "기본";
					}
					$goods_code_show = $g_row['goods_code_show'];

					$g_code_sql = "select * from tbl_code where code_no = '".substr($g_row['product_code'], 1, -1)."' ";
					$g_code_result = mysqli_query($connect, $g_code_sql);
					$g_code_row = mysqli_fetch_array($g_code_result);
					if ( $g_code_row['parent_code_no'] == '0'){
						$g_code_name = $g_code_row['code_name'];
					}else{
						$gcode_sql = "select * from tbl_code where code_no = '".$g_code_row['parent_code_no']."' ";
						$gcode_result = mysqli_query($connect, $gcode_sql);
						$gcode_row = mysqli_fetch_array($gcode_result);
						$g_code_name = $gcode_row['code_name'];
					}

					//약정기간 구하기
					$p_sql = "
						select * from tbl_period where code_no = '".$row['period']."'
					";
					$p_result = mysqli_query($connect, $p_sql);
					$p_row = mysqli_fetch_array($p_result);

					//사은품정보 구하기
					$gift_arr = explode("||", substr($row['gift'],1,-1) );
					$nums = 1;
					$gift_name = '';
					$gift_category = '';
					if(count(array_filter($gift_arr)) < 1){
				?>
						<tr>
							<td><?=$num?></td>

							<td><?=$g_code_name?></td>
							<td><?=$goods_code_show?></td>
							<td><?=$p_row['code_name']?></td>
							<td><?=$row['user_name']?></td>
							<td style="mso-number-format:\@"><?=$row['tel1']?></td>
							<td style="mso-number-format:\@"><?=$row['tel2']?></td>
							<td><?=$row['subject']?></td>
							<td><?=$row['zipcode']?></td>
							<td><?=$row['addr1']?></td>
							<td><?=$row['addr2']?></td>
							<td>
							<?
							if($gift_category != ''){
								echo "[".$gift_category."]";
							}
							echo $gift_name;
							?>
							</td>
							<td><?=$row['comment']?></td>
							<td>
							<?
								if($row['status'] == 'Y'){
									echo "승인";
								}elseif($row['status'] == 'N'){
									echo "미승인";
								}elseif($row['status'] == 'R'){
									echo "승인거부";
								}
							?>
							</td>
							<td>
							<?
								if($row['deli_status'] == '1'){
									echo "미확인";
								}elseif($row['deli_status'] == '2'){
									echo "발송";
								}elseif($row['deli_status'] == '3'){
									echo "보류";
								}
							?>
							</td>
							
							<td><?=$row['regdate']?></td>

						</tr>
				<?
					}else{
						foreach($gift_arr as $key => $val){
							$f_sql = "
								select * from tbl_freebies a
									left outer join tbl_freebies_code b
										on a.category = b.code_no
									where a.idx in ('".$val."')
							";
							$f_result = mysqli_query($connect, $f_sql);
							$f_row = mysqli_fetch_array($f_result);
							$gift_name = $f_row['subject'];
							$gift_category = $f_row['code_name'];
						
			?>
						<tr>
							<td><?=$num?></td>

							<td><?=$g_code_name?></td>
							<td><?=$goods_code_show?></td>
							<td><?=$p_row['code_name']?></td>
							<td><?=$row['user_name']?></td>
							<td style="mso-number-format:\@"><?=$row['tel1']?></td>
							<td style="mso-number-format:\@"><?=$row['tel2']?></td>
							<td><?=$row['subject']?></td>
							<td><?=$row['zipcode']?></td>
							<td><?=$row['addr1']?></td>
							<td><?=$row['addr2']?></td>
							<td>
							<?
							if($gift_category != ''){
								echo "[".$gift_category."]";
							}
							echo $gift_name;
							?>
							</td>
							<td><?=$row['comment']?></td>
							<td>
							<?
								if($row['status'] == 'Y'){
									echo "승인";
								}elseif($row['status'] == 'N'){
									echo "미승인";
								}elseif($row['status'] == 'R'){
									echo "승인거부";
								}
							?>
							</td>
							<td>
							<?
								if($row['deli_status'] == '1'){
									echo "미확인";
								}elseif($row['deli_status'] == '2'){
									echo "발송";
								}elseif($row['deli_status'] == '3'){
									echo "보류";
								}
							?>
							</td>
							
							<td><?=$row['regdate']?></td>

						</tr>

			<?  
							}
						}
				$num = $num + 1;
					}
				
			?>
			
		</tbody>
	</table>
	
