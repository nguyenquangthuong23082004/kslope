<?
	include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php";

	$idx	= $_POST['idx'];
	$status	= $_POST['status'];

	if(isset($idx)==false){exit;}
	if(isset($status)==false){exit;}

	$sql = "
		update tbl_consult set
			status = '".$status."'
		where idx = '".$idx."'
	";
	$db = mysqli_query($connect, $sql);

	if ($db){
		echo "OK";
	}else{
		echo "NO";
	}
?>