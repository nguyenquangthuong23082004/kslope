<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 

	mysql_query("SET AUTOCOMMIT=0");
	mysql_query("START TRANSACTION");
	
	if(!isset($_POST['r_idx'])) exit;
	for ($i=0;$i < count($r_idx) ; $i++) {
		$sql1	= $sql." delete from tbl_reply where r_idx=".$r_idx[$i]." ";
		$db1	= mysql_query($sql1);
		if (!$db1) {
			mysql_query("ROLLBACK");
			echo "NO";
			exit();
		}
	}


	if ($db1) {
		echo "OK";
		mysql_query("COMMIT");
	} else {        
		//rollback
		mysql_query("ROLLBACK");
		echo "NO";
	}
	mysql_close($connect);
?>
