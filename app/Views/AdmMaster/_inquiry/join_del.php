<?
	include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php";

	$idx = $_GET['idx'];

	if(isset($idx) == false){exit;}

	$sql = "
		delete from tbl_join
			where idx = '".$idx."'
	";
	$db = mysqli_query($connect, $sql);

	if ($db){
		echo "OK";
	}else{
		echo "NO";
	}
?>