<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 
	$upload="../data/partner/";

	$tot=count($g_idx);
	for ($j=0;$j<$tot;$j++){

		$sql = " update tbl_goods set onum='".$onum[$j]."' where g_idx='".$g_idx[$j]."'";
		mysqli_query($connect, $sql);
	}

	echo "OK";
?>