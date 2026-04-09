<?
	include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php";

	//print_r($_POST);
	$idx = $_POST['idx'];

	if(isset($idx) == false){
		exit();
	}

	for($i=0; $i < count($idx); $i++){
		$sql = "
			update tbl_freebies set
				status = 'del'
			where idx = '".$idx[$i]."'
		";
		mysqli_query($connect, $sql);
	}

	echo "OK";
?>