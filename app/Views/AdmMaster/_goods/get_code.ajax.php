<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 
?>
[
	<?
	$sql = " SELECT * FROM tbl_code where depth='".$depth."' and parent_code_no='".$parent_code_no."' and status='Y' ";
//	echo $sql;
	$result = mysqli_query($connect, $sql) or die (mysql_error());
	$nTotalCount = mysqli_num_rows($result);
	$i = 1;
	while ($row = mysqli_fetch_array($result)) {
	?>
	{ "code_no" : "<?=$row[code_no]?>", "code_name" : "<?=$row[code_name]?>", "status" : "<?=$row[status]?>"}<? if ($nTotalCount != $i) {echo ",";} ?>
	<?
	$i = $i + 1;
	}
	?>
]
