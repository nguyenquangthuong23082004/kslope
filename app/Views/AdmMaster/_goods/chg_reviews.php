<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 

	//$state = $_POST['state'];
	//$deli_status = $_POST['deli_status'];
	$idx = $_POST['idx'];

	$type = $_POST['type'];
	$val = $_POST['val'];
	
	if(!isset($_POST['idx'])) exit;

	//print_R($_POST);

	//$sql1	= " update tbl_review set displays = '".$state."' where idx = '".$idx."' ";
	//$db1	= mysqli_query($connect, $sql1);

	if($type == 'S'){
		for($i=0; $i < count($idx); $i++){
			$sql = "
				update tbl_review2 set
					 status		 = '".$val."'
				where idx = '".$idx[$i]."'
			";
			mysqli_query($connect, $sql);
		}
	}else if($type == 'D'){
		for($i=0; $i < count($idx); $i++){
			$sql = "
				update tbl_review2 set
					deli_status = '".$val."'
				where idx = '".$idx[$i]."'
			";
			mysqli_query($connect, $sql);
		}
	}

		echo "OK";
	
	
	
?>