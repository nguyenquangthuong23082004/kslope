<?
	// 반품송장번호 수정
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 
	$order_code = $_POST['order_code'];
	$invo_corp2	= $_POST['invo_corp2'];
	$invoice2	= $_POST['invoice2'];




	$sql = " update tbl_order
				set  invo_corp2	= '$invo_corp2'
				   , invoice2	= '$invoice2'
				   $sql_status
			  where order_code = '$order_code'
		   ";

	$db1 = mysqli_query($connect, $sql) or die (mysqli_error($connect));


	if(!$db1){
		
		alert_only("오류!");
		parent_reload();
		exit;
	}



	if($invo_corp2){

		$sql_i = " select * from tbl_transcom where code_idx = '$invo_corp2' ";
		$result_i = mysqli_query($connect, $sql_i) or die (mysqli_error($connect));
		$row_i = mysqli_fetch_array($result_i);

		$sql_invoice2 = " , 반품송장정보 : [" . $row_i['code_name'] . "] " . $invoice2 ;
	}else{
		$sql_invoice2 = "";
	}


	$order_log = "[관리자]정보 변경 : 상태값 : " . $_deli_type[$status] . $sql_invoice . $sql_invoice2;
	$user_id = $_SESSION['member']['id'];

	$sql = " insert tbl_order_log
				set  order_code	= '$order_code'
				   , order_log	= '$order_log'
				   , user_id	= '$user_id'
				   , regdate	= now()
		   ";

	$db1 = mysqli_query($connect, $sql) or die (mysqli_error($connect));

	
	if($db1){
		alert_only("수정되었습니다." . $sql);
	}else{
		alert_only("오류!");
	}


	parent_reload();
?>