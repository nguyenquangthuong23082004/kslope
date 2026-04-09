<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 
	$upload="../data/partner/";

	$tot=count($code_idx);
	for ($j=0;$j<$tot;$j++){

		$sql = " update tbl_brand set onum='".$onum[$j]."' where code_idx='".$code_idx[$j]."'";
		mysqli_query($connect, $sql);
	}

	echo "OK";
?>