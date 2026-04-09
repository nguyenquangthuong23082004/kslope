<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 
	$upload="../data/partner/";

	$tot=count($idx);
	for ($j=0;$j<$tot;$j++){

		$sql = " update tbl_booking set onum='".$onum[$j]."' where idx='".$idx[$j]."'";
		mysqli_query($connect, $sql);
	}

	echo "OK";
?>