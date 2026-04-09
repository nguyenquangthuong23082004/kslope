<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 



	if(!isset($_POST['idx'])) exit;

	$idx = $_POST['idx'];


	$sql_su = " delete from tbl_adminIP where idx = '".$idx."' ";

	$db1 = mysqli_query($connect, $sql_su) or die (mysqli_error($connect));		


	if ($db1) {
		echo "OK";
	} else {
		echo "NO";
	}
	
	mysqli_close($connect);
?>