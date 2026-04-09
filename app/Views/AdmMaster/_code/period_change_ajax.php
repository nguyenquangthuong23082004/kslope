<?
	include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php";

	$code_idx	= $_POST['code_idx'];
	$onum		= $_POST['onum'];

	//print_r($code_idx);
	//print_r($onum);

	if(isset($code_idx) == false){
		exit();
	}
	$tot = count($code_idx);
	for($i=0; $i < $tot; $i++){
		$sql = "
			update tbl_period set
				onum = ".$onum[$i]."
			where code_idx = ".$code_idx[$i]."
		";
		//echo $sql."<br>";
		mysqli_query($connect, $sql);
	}
	echo "OK";
?>