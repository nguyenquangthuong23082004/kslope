<?
	// 송장번호 수정
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 
	$order_code = $_POST['order_code'];
	$status		= "I";	// 송장번호 수정은 무조건 배송중으로 넘김
	$invo_corp	= $_POST['invo_corp'];
	$invoice	= $_POST['invoice'];
	$invo_corp2	= $_POST['invo_corp2'];
	$invoice2	= $_POST['invoice2'];


	if($status == "I"){
		// 조회
		$sql = " select * from tbl_order where order_code = '".$order_code."' ";
		$result = mysqli_query($connect, $sql) or die (mysqli_error($connect));
		$row = mysqli_fetch_array($result);



		if($row['status'] != "I"){

			// 기존 상태값이 결제대기이면서 방금 결제 완료로 돌아간 경우에
			$code = "S07";
			$to_phone = str_replace("-","",$row['hp']);
			

			/*
			구분자 ||| 
			바꾸는 단어 구분자 :::
			*/
			$replace_text = "|||{{ORDER_NAME}}:::".$row['receive_name'];

			autoSms($code, $to_phone, $replace_text);

		}
	}


	$sql = " update tbl_order
				set  invo_corp	= '$invo_corp'
				   , invoice	= '$invoice'
				   , status		= '$status'
				   $sql_status
			  where order_code = '$order_code'
		   ";

	$db1 = mysqli_query($connect, $sql) or die (mysqli_error($connect));


	if(!$db1){
		
		alert_only("오류!");
		parent_reload();
		exit;
	}


	if($invo_corp){

		$sql_i = " select * from tbl_transcom where code_idx = '$invo_corp' ";
		$result_i = mysqli_query($connect, $sql_i) or die (mysqli_error($connect));
		$row_i = mysqli_fetch_array($result_i);

		$sql_invoice = " , 송장정보 : [" . $row_i['code_name'] . "] " . $invoice ;
	}else{
		$sql_invoice = "";
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