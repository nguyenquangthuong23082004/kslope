<?
	include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php";

	$onum = $_POST['onum'];
	$idx = $_POST['idx'];

	if( isset($idx) == false ){
		exit();
	}

	for($i=0; $i < count($idx); $i++){
		$sql = "
			delete from tbl_goods_list_bnnr where idx = '".$idx[$i]."'
		";
		mysqli_query($connect, $sql);
	}
	echo "OK";
?>