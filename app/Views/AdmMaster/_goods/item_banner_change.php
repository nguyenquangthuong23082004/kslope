<?
	include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php";

	$onum = $_POST['onum'];
	$o_idx = $_POST['o_idx'];

	if( isset($o_idx) == false ){
		exit();
	}

	for($i=0; $i < count($o_idx); $i++){
		$sql = "
			update tbl_goods_list_bnnr set
				onum = ".$onum[$i]."
			where idx = '".$o_idx[$i]."'
		";
		mysqli_query($connect, $sql);
	}
	echo "OK";
?>