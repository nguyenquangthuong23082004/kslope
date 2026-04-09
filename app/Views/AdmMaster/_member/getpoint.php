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
			<col width="100px">
			<col width="100px">
			<col width="190px">
			<col width="*">
			<col width="150px">
			<col width="150px">
		</colgroup>
		<thead>
			<tr>
				<th>번호</th>
				<th>아이디</th>
				<th>지급사유</th>	
				<th>적용포인트</th>
				<th>누적포인트</th>
				<th>최종적용일</th>
			</tr>
		</thead>	
		<tbody>
<?
	$total_sql = " select *
					 from tbl_point
					where user_id ='".$user_id."' ";
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
		<td class="tac"><?=$row["msg"]?></td>
		<td class="tac"><?=$row["point"]?></td>
		<td class="tac"><?=number_format(accPoint($row["user_id"],$row["idx"]))?></td>
		<td class="tac"><?=$row["regdate"]?></td>
	</tr>
<?
	}
?>
		</tbody>
	</table>
	<?echo ipagelisting_ajax($pg, $nPage, $g_list_rows, $user_id, "view_m")?>