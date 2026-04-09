<?php
	$fsql = " select * from tbl_bbs_config where board_code='$code' ";

	$fresult = mysqli_query($connect, $fsql) or die (mysql_error());
	$frow=mysqli_fetch_array($fresult);
	if ($frow[tbc_idx] == "") {
		alert_msg("정상적으로 이용바랍니다.");
		exit();
	} else {
		$board_name		= $frow[board_name];
		$board_code		= $frow[board_code];
		$isCategory		= $frow[is_category];	
		$isSecure		= $frow[is_secure];
		$isRight		= $frow[is_right];
		$isReply		= $frow[is_reply];
		$isComment		= $frow[is_comment];
		$isRecomm		= $frow[is_recomm];
		$isNotice		= $frow[is_notice];
		$skin			= $frow[skin];
		$is_comment		= $frow[is_comment];
	}
?>