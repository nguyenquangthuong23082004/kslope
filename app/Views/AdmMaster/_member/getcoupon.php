<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 


	if(!isset($_POST['user_id'])) exit;

	$pg = $_POST['pg'];
	$user_id = $_POST['user_id'];

	$g_list_rows = 12;

?>
	<table cellpadding="0" cellspacing="0" summary="" class="listTable">
		<caption></caption>
		<colgroup>
			<col width="150px">
			<col width="150px">
			<col width="*">
			<col width="220px">
		</colgroup>
		<thead>
			<tr>
				<th>쿠폰명</th>
				<th>할인액(율)</th>
				<th>사용조건</th>	
				<th>유효기간</th>
			</tr>
		</thead>	
		<tbody>
<?
	$total_sql = " select c.c_idx, c.coupon_num, c.user_id, c.regdate, c.enddate, c.usedate, c.status, c.types, s.coupon_name, s.dc_type, s.coupon_pe, s.coupon_price
					from tbl_coupon c
					left outer join tbl_coupon_setting s
					  on c.coupon_type = s.idx
				   where 1=1 and c.status != 'C'
					 and user_id ='".$user_id."' ";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$nTotalCount = mysqli_num_rows($result);
			

	$nPage = ceil($nTotalCount / $g_list_rows);
	if ($pg == "") $pg = 1;
	$nFrom = ($pg - 1) * $g_list_rows;

	$sql    = $total_sql . " order by idx desc limit $nFrom, $g_list_rows ";
	$result = mysqli_query($connect, $sql) or die (mysql_error());
	$num = $nTotalCount - $nFrom;
	while($row=mysqli_fetch_array($result)){

?>
	<tr>
		<td><?=$num--?></td>
		<td class="tac"><?=$row["user_id"]?></td>
		<td class="tac">
			<?
			if( $row['types'] == "N" ){
				echo $row["coupon_name"];
			}else{
				echo $_set_coupon_type[$row['types']];
			}
			?>
		</td>
		<td class="tac"><?=$row["enddate"]?></td>		
	</tr>
<?
	}
?>
		</tbody>
	</table>
	<?echo ipagelisting_ajax($pg, $nPage, $g_list_rows, $user_id, "view_c")?>