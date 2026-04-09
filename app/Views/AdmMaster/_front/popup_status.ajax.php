<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 

	mysqli_query("SET AUTOCOMMIT=0");
	mysqli_query("START TRANSACTION");

	if(!isset($_POST['idx'])) exit;
	if(!isset($_POST['status'])) exit;

	$status			= updateSQ(trim($_POST[status]));
	
	for ($i=0; $i < count($idx); $i++)
	{
		$sql = "update tbl_popup set status = '$status' where idx = ".$idx[$i]."";
		$db1 = mysqli_query($connect,$sql);
		if (!$db1) {
			//rollback
			mysqli_query($connect,"ROLLBACK");
			echo "NO";
		}
	}


	if ($db1) {
		echo "OK";
		mysqli_query($connect,"COMMIT");
	} else {        
		//rollback
		mysqli_query($connect,"ROLLBACK");
		echo "NO";
	}
	mysqli_close($connect);
?>
