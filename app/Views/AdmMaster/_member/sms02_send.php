<?
set_time_limit(0);

include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 

$send_hp  = updateSQ($_POST["send_num"]);
$msg	  = updateSQ($_POST["msg"]);



//-- 로그 기록 남기기
	$fsql		= " select IFNULL( max(idx), 0) + 1 as idx from tbl_sms_log ";
	$fresult	= mysqli_query($connect, $fsql) or die (mysqli_error($connect));
	$frow		= mysqli_fetch_array($fresult);
	$last_idx = $frow['idx'];
	$code = "S".$last_idx;


	$fsql = " insert into tbl_sms_log set
				  types		= 'S'
				, code		= '".$code."'
				, content	= '".$msg."'
				, regdate	= now()
			 ";
	mysqli_query($connect, $fsql) or die (mysqli_error($connect));



if($send_grp == "2") {  // 수신동의 회원
	$sql_m	= " select * from tbl_member
				 where user_level > 1
				   and user_mobile != ''
				   and user_mobile != '--' and sms_yn = 'Y' ";
} else {  // 전체회원
	$sql_m	= " select * from tbl_member
				 where user_level > 1
				   and user_mobile != ''
				   and user_mobile != '--' ";
}

$result_m = mysqli_query($connect, $sql_m) or die (mysqli_error($connect));
while($row_m = mysqli_fetch_array($result_m)){


	$to_hp = str_replace("-", "", $row_m['user_mobile']);
    $msg   = str_replace("{{MEMBER_NAME}}", $row_m['user_name'], $msg);

	sms_send($to_hp, $send_hp, $msg, $code, $opt3="", $opt4="");

}

alert_msg("문자가 발송되었습니다.","/AdmMaster/_member/sms02.php");

?>