<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 

	$state = updateSQ($_GET['state']);
	$idx = updateSQ($_GET['idx']);
	
	if(!isset($_GET['idx'])) exit;

	
	$sql1	= " update tbl_review set displays = '".$state."' where idx = '".$idx."' ";
	$db1	= mysqli_query($connect, $sql1);


	if ($db1) {
		echo "OK";
	
	} else {        
		
		echo "NO";
	}
	
?>