<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 


	function Unescape($str) // UnescapeFunc는 아래에 정의되어 있음
	{
	   return urldecode(preg_replace_callback('/%u([[:alnum:]]{4})/', 'UnescapeFunc', $str));
	}
	  
	function UnescapeFunc($str){
	   return iconv('UTF-16LE', 'UTF-8', chr(hexdec(substr($str[1], 2, 2))).chr(hexdec(substr($str[1],0,2))));
	}

	$user_id = Unescape($_GET['user_id']);


	$sql = " SELECT * FROM tbl_member where user_level > '1' and status='1' and (user_id like '%".$user_id."%' or user_name  like '%".$user_id."%' ) order by user_id asc ";
//	echo $sql;
	$result = mysqli_query($connect, $sql) or die (mysql_error());
	$nTotalCount = mysqli_num_rows($result);

	if($nTotalCount < 1){
	?>
		<tr>
			<th colspan="2">일치하는 회원이 없습니다.</th>
		</tr>
	<?
	}
	
	while ($row = mysqli_fetch_array($result)) {
	?>

		<tr onclick="sel_user_id('<?=$row['user_id']?>');">
			<th><?=$row['user_name']?></th>
			<td><?=$row['user_id']?></td>
		</tr>
	
	<?
	
	}
	?>
