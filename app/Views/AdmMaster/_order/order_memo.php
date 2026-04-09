<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 
	$order_code = $_POST['order_code'];
	$memos		= $_POST['memos'];

	
	$user_id = $_SESSION['member']['id'];

	$sql = " insert tbl_order_memo
				set  order_code	= '$order_code'
				   , order_memo	= '$memos'
				   , user_id	= '$user_id'
				   , regdate	= now()
		   ";

	$db1 = mysqli_query($connect, $sql) or die (mysqli_error($connect));
	
	if($db1){
		alert_only("저장되었습니다." . $sql);
	}else{
		alert_only("오류!");
	}


	parent_reload();
?>