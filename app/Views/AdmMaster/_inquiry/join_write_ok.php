<?
	include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php";

	$idx	= $_POST['idx'];
	$memo	= $_POST['memo'];

	$sql = "
		update tbl_join set
			memo = '".$memo."'
		where idx = '".$idx."'
	";
	$result = mysqli_query($connect, $sql);

	if ($result){
		echo "OK";
	}else{
		echo "NO";
	}
?>