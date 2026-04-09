<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 

	mysqli_query($connect, "SET AUTOCOMMIT=0");
	mysqli_query($connect, "START TRANSACTION");

	if(!isset($_POST['idx'])) exit;

	for ($i=0;$i < count($idx) ; $i++) {
		$sql1	= " delete from tbl_popup where idx=".$idx[$i]." ";
		$db1	= mysqli_query($connect, $sql1);
		if (!$db1) {
			mysqli_query($connect, "ROLLBACK");
			echo "NO";
			exit();
		}
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