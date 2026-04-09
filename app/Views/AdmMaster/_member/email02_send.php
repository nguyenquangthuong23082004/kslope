<?
	set_time_limit(0);

	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";

	$to_email	= updateSQ($_POST["to_email"]);
	$send_name	= updateSQ($_POST["send_name"]);
	$send_email	= updateSQ($_POST["send_email"]);
	$mail_title	= updateSQ($_POST["mail_title"]);
	$pg			= updateSQ($_POST["pg"]);
	//$content	= updateSQ($_POST["content"]);
    //$content = str_replace("/data","https://www.bontoshop.com/data",$content);
	$content = str_replace("/data",$_IT_TOP_PROTOCOL.$_SERVER['SERVER_NAME']."/data",$content);
	

	$nameFrom  = $send_name;
	$mailFrom  = $send_email;
	$subject   = $mail_title;

    $email_arr = explode(",", $to_email);

	// 
	$fsql		= " select IFNULL( max(idx), 0) + 1 as idx from tbl_email_top_log ";
	$fresult	= mysqli_query($connect, $fsql) or die (mysqli_error($connect));
	$frow		= mysqli_fetch_array($fresult);
	$last_idx = $frow['idx'];
	$code = "C".$last_idx;


	$fsql = " insert into tbl_email_top_log set
				  code		= '".$code."'
				, title		= '".$subject."'
				, content	= '".updateSQ($content)."'
				, tomail	= '".$to_email."'
				, regdate	= now()
			 ";
	mysqli_query($connect, $fsql) or die (mysqli_error($connect));

	
	for($i=0;$i<count($email_arr)-1;$i++)
	{
			$nameTo    = "고객";
			$mailTo    =  $email_arr[$i];

			/*

			$charset   = "UTF-8";
			$nameFrom  = "=?$charset?B?".base64_encode($nameFrom)."?=";
			$nameTo    = "=?$charset?B?".base64_encode($nameTo)."?=";
			$subject   = "=?$charset?B?".base64_encode($subject)."?=";

			$header    = "Content-Type: text/html; charset=utf-8\r\n";
			$header   .= "MIME-Version: 1.0\r\n";

			$header   .= "Return-Path: <". $mailFrom .">\r\n";
			$header   .= "From: ". $nameFrom ." <". $mailFrom .">\r\n";
			$header   .= "Reply-To: <". $mailFrom .">\r\n";


			@mail($mailTo, $subject, $content, $header, $mailFrom);
			*/

			mailer($nameFrom, $mailFrom, $mailTo, $subject, $content, $code);

    }

    alert_msg("이메일이 발송되었습니다.","/AdmMaster/_member/email02.php?pg=".$pg);

?>
