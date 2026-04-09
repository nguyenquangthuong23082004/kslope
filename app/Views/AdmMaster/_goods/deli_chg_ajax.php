<?
	include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php";

	$idx	= $_POST['idx'];
	$deli_status	= $_POST['deli_status'];

	if(isset($idx)==false){exit;}
	if(isset($deli_status)==false){exit;}

	$sql = "
		update tbl_review2 set
			deli_status = '".$deli_status."'
		where idx = '".$idx."'
	";
	$db = mysqli_query($connect, $sql);

	if ($db){
		echo "OK";
	}else{
		echo "NO";
	}
?>