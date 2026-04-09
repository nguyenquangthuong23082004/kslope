<?
	set_time_limit(0);
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";

	//$pg	= updateSQ($_POST["pg"]);
	$to_email	= updateSQ($_POST["to_email"]);
	$send_name	= updateSQ($_POST["send_name"]);
	$send_email	= updateSQ($_POST["send_email"]);
	$mail_title	= updateSQ($_POST["mail_title"]);
	//$content	= updateSQ($_POST["content"]);
    $content = str_replace("/data","https://www.bontoshop.com/data",$content);

	$nameFrom  = $send_name;
	$mailFrom  = $send_email;
	$subject   = $mail_title;

    $email_arr = explode(",", $to_email);
	
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
			mailer($nameFrom, $mailFrom, $mailTo, $subject, $content);
    }

    alert_msg("이메일이 발송되었습니다.","/AdmMaster/_member/email03.php?pg=".$pg);

?>
