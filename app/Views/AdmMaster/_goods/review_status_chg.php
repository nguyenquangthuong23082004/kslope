<?
	include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php";

	$idx = $_POST['idx'];
	$status = $_POST['status'];

	$sql = "
		update tbl_review2 set
			status = '".$status."'
		where idx = '".$idx."'
	";
	$db = mysqli_query($connect, $sql);

	if($db){
		echo "OK";
	}else{
		echo "NO";
	}
?>