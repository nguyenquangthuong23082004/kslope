<?
include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 

$idx		= updateSQ($_GET["idx"]);
$invo_corp	= updateSQ($_GET["invo_corp"]);
$invoice	= updateSQ($_GET["invoice"]);
$invoice3	= updateSQ($_GET["invoice3"]);
$status		= "I";	// 송장번호 수정은 무조건 배송중으로 넘김


// 상품조회
$sql = " select * from tbl_order where idx = '".$idx."' limit 1 ";
$result = mysqli_query($connect, $sql) or die (mysql_error($connect));
$row = mysqli_fetch_array($result);

if( $row['idx'] == $idx){



	if($status == "I"){
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
				   , invoice3	= '$invoice3'
				   , status		= '$status'
			  where idx = '$idx'
		   ";
	$message = "[관리자]정보변경 : " . $sql;
	write_log_dir($message , $_SERVER['DOCUMENT_ROOT']."/AdmMaster/_order/log/");
	$db1 = mysqli_query($connect, $sql) or die (mysqli_error($connect));

	if(!$db1){
		echo "E";
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


	if($invoice3){
		$sql_invoice3 = " , 직접수령 : [" . $invoice3 . "] ";
	}else{
		$sql_invoice3 = "";
	}



	
	$order_code	= $row['order_code'];
	$order_log = "[관리자]정보 변경 : " . $sql_invoice . $sql_invoice3;
	$user_id = $_SESSION['member']['id'];

	$sql = " insert tbl_order_log
				set  order_code	= '$order_code'
				   , order_log	= '$order_log'
				   , user_id	= '$user_id'
				   , regdate	= now()
		   ";

	$db1 = mysqli_query($connect, $sql) or die (mysqli_error($connect));

	echo "L";

}else{
	echo "E";
}
?>