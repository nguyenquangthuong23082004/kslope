<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";

	mysqli_query($connect, "SET AUTOCOMMIT=0");
	mysqli_query($connect, "START TRANSACTION");

	if(!isset($_POST['idx'])) exit;
	if(!isset($_POST['vals'])) exit;


	$sql1	= " update tbl_bbs_list set status = '".$vals."' where bbs_idx=".$idx." ";
	$db1	= mysqli_query($connect, $sql1);
	if (!$db1) {
		mysqli_query($connect, "ROLLBACK");
		echo "NO";
		exit();
	}



	if ($db1) {
		echo "OK";
		mysqli_query($connect, "COMMIT");
	} else {
		//rollback
		mysqli_query($connect, "ROLLBACK");
		echo "NO";
	}
	mysqli_close($connect);
?>
