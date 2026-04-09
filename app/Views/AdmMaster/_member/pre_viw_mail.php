<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";
	

	$idx = updateSQ($_GET["idx"]);

	$total_sql = " select *
	                 from tbl_auto_mail_skin
					where idx = '".$idx."'  ";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$row = mysqli_fetch_array($result);
	
?>
<?=viewSQ($row["content"])?>