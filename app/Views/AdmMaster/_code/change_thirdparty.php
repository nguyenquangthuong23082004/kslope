<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 

	$tot=count($code_idx);
	for ($j=0;$j<$tot;$j++){

		$sql = " update tbl_third_party set onum='".$onum[$j]."' where code_idx='".$code_idx[$j]."'";
		mysqli_query($connect, $sql);
	}

	echo "OK";
?>