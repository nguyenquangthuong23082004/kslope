<?php
set_time_limit(0);

include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 

$send_mobile  = updateSQ($_POST["send_mobile"]);
$send_name	  = updateSQ($_POST["send_name"]);
$send_hp	  = updateSQ($_POST["send_hp"]);
//$msg	      = updateSQ($_POST["msg"]);
$msg	      = $_POST["msg"];
//echo  $msg;





//-- 로그 기록 남기기
	$fsql		= " select IFNULL( max(idx), 0) + 1 as idx from tbl_sms_log ";
	$fresult	= mysqli_query($connect, $fsql) or die (mysqli_error($connect));
	$frow		= mysqli_fetch_array($fresult);
	$last_idx = $frow['idx'];
	$code = "S".$last_idx;


	$fsql = " insert into tbl_sms_log set
				  types		= 'P'
				, code		= '".$code."'
				, content	= '".$msg."'
				, to_hp		= '".$send_mobile."'
				, regdate	= now()
			 ";
	mysqli_query($connect, $fsql) or die (mysqli_error($connect));





$send_arr = explode(",", $send_mobile);


for($i=0;$i<count($send_arr);$i++) 
{
		sleep(1);
		$to_hp = str_replace("-", "", $send_arr[$i]);

		if($send_arr[$i]){
			sms_send($to_hp, $send_hp, $msg, $code, $opt3="", $opt4="");
			sleep(1);
		}

}

//alert_msg("문자가 발송되었습니다.","/AdmMaster/_member/sms03.php");

?>

<script>
function MUNJANOTE_CallBack(obj) {
	if (obj.rslt=="true") { // 발송성공!!
		// 이곳에 다음 페이지 이동등의 처리를 넣어 주세요.
	} else {
		var failMsg = (obj.msg)?obj.msg:"";
		alert("발송실패 : "+failMsg);
		// 실패시 처리를 넣어 주세요.
	}
}
</script>