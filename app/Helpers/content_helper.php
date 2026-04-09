<?php

if (!function_exists('viewSQ')) {
    function viewSQ($textToFilter)
    {
        $textToFilter = str_replace('ins&#101rt', 'insert', $textToFilter);
        $textToFilter = str_replace('s&#101lect', 'select', $textToFilter);
        $textToFilter = str_replace('valu&#101s', 'values', $textToFilter);
        $textToFilter = str_replace('wher&#101', 'where', $textToFilter);
        $textToFilter = str_replace('ord&#101r', 'order', $textToFilter);
        $textToFilter = str_replace('int&#111', 'into', $textToFilter);
        $textToFilter = str_replace('dr&#111p', 'drop', $textToFilter);
        $textToFilter = str_replace('delet&#101', 'delete', $textToFilter);
        $textToFilter = str_replace('updat&#101', 'update', $textToFilter);
        $textToFilter = str_replace('s&#101t', 'set', $textToFilter);
        $textToFilter = str_replace('fl&#117sh', 'flush', $textToFilter);
        $textToFilter = str_replace('&amp;', "&", $textToFilter);
        $textToFilter = str_replace('&#59', ";", $textToFilter);
        $textToFilter = str_replace('&gt;', ">", $textToFilter);
        $textToFilter = str_replace('&lt;', "<", $textToFilter);
        $textToFilter = str_replace('&#39', "'", $textToFilter);
        $textToFilter = str_replace('&#34', "\"", $textToFilter);
        $textToFilter = str_replace('&amp;', "&", $textToFilter);
        $textToFilter = str_replace('&amp;', "&", $textToFilter);
        $textToFilter = str_replace('scr&#105pt', " ", $textToFilter);

        return $textToFilter;
    }
}

function strAsterisk($string) {

	$string = trim($string);
	$length = mb_strlen($string, 'utf-8');
	$string_changed = $string;
	if ($length <= 2) {
		// 한두 글자면 그냥 뒤에 별표 붙여서 내보낸다.
		$string_changed = mb_substr($string, 0, 1, 'utf-8') . '*';
	}
	if ($length >= 3) {
		// 3으로 나눠서 앞뒤.
		$leave_length = floor($length/3); // 남겨 둘 길이. 반올림하니 너무 많이 남기게 돼, 내림으로 해서 남기는 걸 줄였다.
		$asterisk_length = $length - ($leave_length * 2);
		$offset = $leave_length + $asterisk_length;
		$head = mb_substr($string, 0, $leave_length, 'utf-8');
		$tail = mb_substr($string, $offset, $leave_length, 'utf-8');
		$string_changed = $head . implode('', array_fill(0, $asterisk_length, '*')) . $tail;
	}
	return $string_changed;
}

if (!function_exists('simple_convert_to_webp')) {
    /**
     * @param string $sourcePath -
     * @param int $quality - 
     */
    function simple_convert_to_webp($sourcePath, $quality = 80)
    {
        if (!file_exists($sourcePath)) {
            return false;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $sourcePath);
        finfo_close($finfo);

        $pathInfo = pathinfo($sourcePath);
        $webpFilename = $pathInfo['filename'] . '.webp';
        $webpPath = $pathInfo['dirname'] . '/' . $webpFilename;

        if ($mimeType === 'image/webp') {
            if (rename($sourcePath, $webpPath)) {
                return $webpFilename;
            }
            return false;
        }

        $supportedMimes = [
            'image/jpeg',
            'image/jpg', 
            'image/png',
            'image/gif',
            'image/pjpeg',
            'image/x-jfif'
        ];
        
        if (!in_array($mimeType, $supportedMimes)) {
            return false;
        }

        $oldMemory = ini_get('memory_limit');
        $oldMaxExecution = ini_get('max_execution_time');
        ini_set('memory_limit', '1G'); 
        ini_set('max_execution_time', '600'); 

        $image = null;
        switch ($mimeType) {
            case 'image/jpeg':
            case 'image/jpg':
            case 'image/pjpeg':
            case 'image/x-jfif':
                $image = @imagecreatefromjpeg($sourcePath);
                if (!$image) {
                    error_log("Failed to create JPEG image from: $sourcePath");
                    ini_set('memory_limit', $oldMemory);
                    ini_set('max_execution_time', $oldMaxExecution);
                    return false;
                }
                break;
            case 'image/png':
                $image = @imagecreatefrompng($sourcePath);
                if ($image) {
                    imagealphablending($image, false);
                    imagesavealpha($image, true);
                } else {
                    error_log("Failed to create PNG image from: $sourcePath");
                    ini_set('memory_limit', $oldMemory);
                    ini_set('max_execution_time', $oldMaxExecution);
                    return false;
                }
                break;
            case 'image/gif':
                $image = @imagecreatefromgif($sourcePath);
                if (!$image) {
                    error_log("Failed to create GIF image from: $sourcePath");
                    ini_set('memory_limit', $oldMemory);
                    ini_set('max_execution_time', $oldMaxExecution);
                    return false;
                }
                break;
        }

        if (!$image) {
            ini_set('memory_limit', $oldMemory);
            ini_set('max_execution_time', $oldMaxExecution);
            return false;
        }


        $qualities = [$quality, 75, 60, 50];
        $success = false;

        foreach ($qualities as $q) {
            $success = @imagewebp($image, $webpPath, $q);
            if ($success) {
                break;
            }
        }

        imagedestroy($image);
        
        ini_set('memory_limit', $oldMemory);
        ini_set('max_execution_time', $oldMaxExecution);

        if ($success) {
            @unlink($sourcePath);
            return $webpFilename;
        }

        return false;
    }
}

if (!function_exists('simple_upload_and_convert_to_webp')) {
    /**
     * @param object 
     * @param string 
     * @param int 
     */
    function simple_upload_and_convert_to_webp($file, $uploadPath, $quality = 80)
    {
        $result = [
            'success' => false,
            'filename' => '',
            'error' => '',
            'resized' => false  
        ];

        if (!$file || !$file->isValid()) {
            $result['error'] = '유효하지 않은 파일입니다';
            return $result;
        }

        $allowedMimes = [
            'image/jpeg', 
            'image/jpg', 
            'image/png', 
            'image/gif',
            'image/webp',
            'image/jfif',
            'image/pjpeg',
            'image/x-jfif'
        ];
        
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            $result['error'] = '이미지 파일만 업로드 가능합니다 (JPG, PNG, GIF, WEBP, JFIF)';
            return $result;
        }

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $tempName = $file->getRandomName();
        $file->move($uploadPath, $tempName);

        $tempPath = $uploadPath . $tempName;


        $webpFilename = simple_convert_to_webp($tempPath, $quality);

        if ($webpFilename) {
            $result['success'] = true;
            $result['filename'] = $webpFilename;
        } else {
            $result['error'] = 'WebP 변환에 실패했습니다. 원본 파일로 저장됩니다.';
            $result['success'] = true;
            $result['filename'] = $tempName;
        }

        return $result;
    }
}

function autoEmail($code, $user_mail, $_tmp_fir_array)
{


    $is_ssl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
    $protocol = $is_ssl ? 'https://' : 'http://';
    $domain = $_SERVER['HTTP_HOST'];
    $http_domain_url = $protocol . $domain;

    $infoRow = homeSetInfo();

    $_tmp_fir_array['home_name'] = $infoRow['home_name'] ?? '';
    $_tmp_fir_array['addr1'] = $infoRow['addr1'] ?? '';
    $_tmp_fir_array['addr2'] = $infoRow['addr2'] ?? '';
    $_tmp_fir_array['com_owner'] = $infoRow['com_owner'] ?? '';
    $_tmp_fir_array['comnum'] = $infoRow['comnum'] ?? '';
    $_tmp_fir_array['tour_no'] = $infoRow['tour_no'] ?? '';
    $_tmp_fir_array['mallOrder'] = $infoRow['mallOrder'] ?? '';
    $_tmp_fir_array['custom_phone'] = $infoRow['custom_phone'] ?? '';
    $_tmp_fir_array['qna_email'] = $infoRow['qna_email'] ?? '';
    $_tmp_fir_array['site_name'] = $infoRow['site_name'] ?? '';
    $_tmp_fir_array['admin_email'] = $infoRow['admin_email'] ?? '';
    $_tmp_fir_array['info_owner'] = $infoRow['info_owner'] ?? '';
    $_tmp_fir_array['domain_url'] = $infoRow['domain_url'] ?? '';
    $_tmp_fir_array['http_domain_url'] = $http_domain_url;

    $emailModel = model("AutoMailModel");
    $row = $emailModel->where('code', $code)->first();

    // 해당 코드가 자동 발송이 가능한가?
    if ($row['autosend'] != "Y") {
        return false;
    }

    // 메일 보낼 내역이 없다면
    if ($row['content'] == "") {
        return false;
    }

    // 메일 보낼 내역
    $_tmp_content = viewSQ($row['content']);
    $subject = $row['mail_title'];

    //$_tmp_content = "[[name]] 고객님 안녕하세요. 가입하신 아이디는 [[id]] 입니다.[[name]] 고객님 안녕하세요. 가입하신 아이디는 [[id]] 입니다.";


    // $_tmp_fir_array = explode("|||", $replace_text);

    // for ($i = 1; $i < sizeof($_tmp_fir_array); $i++) {
    //     $_tmp_sec_array = explode(":::", $_tmp_fir_array[$i]);

    //     $_f_txt = $_tmp_sec_array[0];
    //     $_s_txt = $_tmp_sec_array[1];

    //     $_tmp_content = str_replace($_f_txt, $_s_txt, $_tmp_content);
    // }

    //mailer($nameFrom, $mailFrom, $mailTo, $subject, $_tmp_content);

    $nameFrom = $infoRow['site_name'];
    $mailFrom = $infoRow['smtp_id'];
    $to_name = $user_mail;
    $to_email = $user_mail;

    $_tmp_content = replacePatternsEmail($_tmp_content, $_tmp_fir_array);

    $err = send_mail($nameFrom, $mailFrom, $to_name, $to_email, $subject, $_tmp_content);
    return $err;
}

function replacePatternsEmail($input, $replacementValues)
{
    $replaceCallback = function ($matches) use ($replacementValues) {
        $key = $matches[1];
        return isset($replacementValues[$key]) ? $replacementValues[$key] : $matches[0];
    };

    return preg_replace_callback('/\[(.*?)\]/', $replaceCallback, $input);
}

function send_mail($from_name, $from_email, $to_name, $to_email, $subject, $message, $ext_header = "")
{

    $infoRow = homeSetInfo();
    $auth_id = "";
    $param_arr = array();
    // 추가 설정
    if ($ext_header != "") {
        $arr = explode("\n", $ext_header);
        $cnt = count($arr);
        $item = "";
        for ($i = 0; $i < $cnt; $i++) {
            $str = $arr[$i];
            if (substr($str, 0, 1) == " ") { // TAB -> 이전 항목에 연결
                if ($item != "")
                    $param_arr[$item] .= $str;
                continue;
            } else {
                if (!$pos = strpos($str, ":")) {
                    if ($item != "")
                        $param_arr[$item] .= $str;
                    continue;
                }

                $item = "";
                $_item = trim(substr($str, 0, $pos));
                $_value = trim(substr($str, $pos + 1));
                if ($_item != "" && $_value != "") {
                    $param_arr[$_item] = $_value;
                    $item = $_item;
                }
            }
        }

        // 보내는 사람 = 답변 받을 사람
        if ($param_arr["Reply-To"] != "" && $param_arr["Sender"] == "")
            $param_arr["Sender"] = $param_arr["Reply-To"];
        else if ($param_arr["Sender"] != "" && $param_arr["Reply-To"] == "")
            $param_arr["Reply-To"] = $param_arr["Sender"];
    }

    $from_name = trim($from_name);
    $from_email = trim($from_email);

    $to_name = trim($to_name);
    $to_email = trim($to_email);

    $subject = trim($subject);
    $message = trim($message);

    $from_email =  $infoRow['smtp_id'];

    if ($from_email == "")
        return false;
    if ($to_email == "")
        return false;
    if ($subject == "")
        return false;
    if ($message == "")
        return false;

    // from
    $from_name = "=?UTF-8?B?" . base64_encode($from_name) . "?=";
    $from = "\"" . $from_name . "\" <" . $from_email . ">";

    // to
    $to_name = "=?UTF-8?B?" . base64_encode($to_name) . "?=";
    $to = "\"" . $to_name . "\" <" . $to_email . ">";

    // subject
    $subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";

    // --------------------------------------------
    // 1차 발송....SMTP 서버 지정 발송

    //    $boundary = "----=_Part_" . md5(uniqid());
    //    $body_html = str_replace(
    //        'https://mango-farm.com/img/main/20251010190324649.png',
    //        'cid:logo_cid',
    //        $message
    //    );
    //
    //    $logoPath = FCPATH . 'img/main/20251010190324649.png';
    //
    //    $logoData = '';
    //    if (file_exists($logoPath)) {
    //        $logoData = chunk_split(base64_encode(file_get_contents($logoPath)));
    //    }

    // 메일 헤더
    $header = "";
    $header .= "Message-ID: <" . microtime(true) . "_" . uniqid() . "@" . $_SERVER['SERVER_NAME'] . ">\n";
    $header .= "Date: " . date("D, j M Y H:i:s +0900") . "\n";
    $header .= "From: " . $from . "\n";
    $header .= "To: " . $to . "\n";
    $header .= "Subject: " . $subject . "\n";
    $header .= "Organization: " . ((isset($param_arr["Organization"]) && $param_arr["Organization"] != "") ? $param_arr["Organization"] : $_SERVER['SERVER_NAME']) . "\n";
    if (isset($param_arr["Sender"]) && $param_arr["Sender"] != "")
        $header .= "Sender: " . $param_arr["Sender"] . "\n";
    if (isset($param_arr["Reply-To"]) && (string)$param_arr["Reply-To"] != "")
        $header .= "Reply-To: " . $param_arr["Reply-To"] . "\n";
    if (isset($param_arr["Errors-To"]) && (string)$param_arr["Errors-To"] != "")
        $header .= "Errors-To: " . $param_arr["Errors-To"] . "\n";
    if (isset($param_arr["X-Priority"]) && (string)$param_arr["X-Priority"] != "")
        $header .= "X-Priority: " . (isset($param_arr["X-Priority"]) && (string)$param_arr["X-Priority"]) . "\n";
    $header .= "X-Originating-IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
    $header .= "X-Sender-IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
    $header .= "X-Sender-ID: " . $auth_id . " [" . $_SERVER['SERVER_NAME'] . "]\n";
    $header .= "X-Mailer: Excom21-Mailer\n";
    $header .= "MIME-Version: 1.0\n";
    $header .= "Content-Type: TEXT/HTML; charset=UTF-8\n";
    $header .= "Content-Transfer-Encoding: 8BIT\n";

    $mail_data = $header . "\n\n" . $message;
    $mail_data = str_replace("\r\n", "\n", $mail_data); // 1. \r\n -> \n
    $mail_data = str_replace("\r", "\n", $mail_data); // 2. \r   -> \n
    $mail_data = str_replace("\n", "\r\n", $mail_data); // 3. \n   -> \r\n

    // 메일 발송
    $err = smtp_email($from_email, $to_email, $mail_data);

    if (!$err) return false;
    //$this->log_input("******************* smtp_email (err) : ".$err, "guinee");
    return $err;

    // --------------------------------------------
    // 1차 발송 실패시....자체 발송 (localhost)
    /*if($err != "")
             {
             // ext_header
             if($ext_header == "")
             $ext_header = "From: ".$from."\nX-Mailer: JK-Mailer2\nContent-Type: text/html; charset=UTF-8";
             else
             $ext_header = "From: ".$from."\n".$ext_header;

             // 메일 발송
             $err = !mail($to, $subject, $message, $ext_header);
             //$this->log_input("******************* mail (err) : ".$err, "guinee");
             }*/

    // 메일 발송 결과
}

function smtp_email($from_email, $to_email, $mail_data)
{
    try {
        $infoRow = homeSetInfo();
        // $host = $infoRow['smtp_host'];
        $port = 587;

        // $smtp_id = $infoRow['smtp_id'];
        // $smtp_pw = $infoRow['smtp_pass'];

        $host = 'smtp.cafe24.com';
        $smtp_id = 'mango@mango-farm.com';
        $smtp_pw = 'mango!@12';

        $id = base64_encode($smtp_id);
        $pw = base64_encode($smtp_pw);

        $limit = 30;

        $socket = fsockopen($host, $port, $errno, $errstr, $limit);
        if (!$socket) {
            return "Error: fsockopen ($errno : $errstr)";
        }

        $response = fgets($socket, 1024);
        if (substr($response, 0, 3) !== "220") {
            return "Error: connect - $response";
        }

        fwrite($socket, "EHLO {$host}\r\n");

        while (true) {
            $line = fgets($socket, 1024);
            if (!$line) break;

            if (substr($line, 0, 4) === "250 ") break;

            if (substr($line, 0, 3) !== "250") break;
        }

        fwrite($socket, "AUTH LOGIN\r\n");
        $response = fgets($socket, 1024);

        if (substr($response, 0, 3) !== "334") {
            return "Error: AUTH LOGIN - $response";
        }

        fwrite($socket, $id . "\r\n");
        $response = fgets($socket, 1024);
        if (substr($response, 0, 3) !== "334") {
            return "Error: SMTP ID - $response";
        }

        fwrite($socket, $pw . "\r\n");
        $response = fgets($socket, 1024);
        if (substr($response, 0, 3) !== "235") {
            return "Error: SMTP PW - $response";
        }

        fwrite($socket, "MAIL FROM:<{$from_email}>\r\n");
        $response = fgets($socket, 1024);
        if (substr($response, 0, 3) !== "250") {
            return "Error: MAIL FROM - $response";
        }

        fwrite($socket, "RCPT TO:<{$to_email}>\r\n");
        $response = fgets($socket, 1024);
        if (substr($response, 0, 3) !== "250") {
            return "Error: RCPT TO - $response";
        }

        fwrite($socket, "DATA\r\n");
        $response = fgets($socket, 1024);
        if (substr($response, 0, 3) !== "354") {
            return "Error: DATA - $response";
        }

        $mail_data = str_replace("\r\n.\r\n", "\r\n . \r\n", $mail_data);

        fwrite($socket, $mail_data . "\r\n.\r\n");
        $response = fgets($socket, 1024);
        if (substr($response, 0, 3) !== "250") {
            return "Error: mail_data - $response";
        }
        fwrite($socket, "QUIT\r\n");
        fclose($socket);

        return "";

    } catch (Exception $e) {
        return $e->getMessage();
    }
}

function alimTalkSend($tmpCode, $allim_replace, $order_link = null, $invoice_link = null, $voucher_link = null)
{
    $connect = db_connect();
    $row_home_info = homeSetInfo();

    $apikey = $row_home_info['allim_apikey'];
    $userid = $row_home_info['allim_userid'];
    $senderkey = $row_home_info['allim_senderkey'];
    $sender = $row_home_info['sms_phone'];
    $allim_token = alim_token();

    $allim_tmpcode = $tmpCode;

    $_apiURL = 'https://kakaoapi.aligo.in/akv10/template/list/';
    $_hostInfo = parse_url($_apiURL);
    $_port = (strtolower($_hostInfo['scheme']) == 'https') ? 443 : 80;
    $_variables = array(
        'apikey' => $apikey,
        'userid' => $userid,
        'token' => $allim_token,
        'senderkey' => $senderkey,
        'tpl_code' => $allim_tmpcode
    );

    $oCurl = curl_init();
    curl_setopt($oCurl, CURLOPT_PORT, $_port);
    curl_setopt($oCurl, CURLOPT_URL, $_apiURL);
    curl_setopt($oCurl, CURLOPT_POST, 1);
    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($oCurl, CURLOPT_POSTFIELDS, http_build_query($_variables));
    curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);

    $ret = curl_exec($oCurl);
    $error_msg = curl_error($oCurl);
    curl_close($oCurl);

    $retArr = json_decode($ret);

    if ($retArr->code == 0) {
        $tmpSubject = $retArr->list[0]->templtName;
        $tmpContent = $retArr->list[0]->templtContent;
        $templtTitle = $retArr->list[0]->templtTitle;

        foreach ($allim_replace as $key => $val) {
            $tmpContent = str_replace($key, $val, $tmpContent);
        }

        $_apiURL = 'https://kakaoapi.aligo.in/akv10/alimtalk/send/'; 
        $_hostInfo = parse_url($_apiURL);
        $_port = (strtolower($_hostInfo['scheme']) == 'https') ? 443 : 80;

        $_variables = array(
            'apikey' => $apikey,
            'userid' => $userid,
            'token' => $allim_token,
            'senderkey' => $senderkey,
            'tpl_code' => $allim_tmpcode,
            'sender' => $sender,
            'receiver_1' => $allim_replace["phone"],
            'subject_1' => $tmpSubject,
            'message_1' => $tmpContent,
            'emtitle_1' => $templtTitle
        );

        if (!empty($allim_replace['button'])) {
            $_variables['button_1'] = $allim_replace['button'];
        }

        $oCurl = curl_init();
        curl_setopt($oCurl, CURLOPT_PORT, $_port);
        curl_setopt($oCurl, CURLOPT_URL, $_apiURL);
        curl_setopt($oCurl, CURLOPT_POST, 1);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, http_build_query($_variables));
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);

        $ret = curl_exec($oCurl);
        $error_msg = curl_error($oCurl);
        curl_close($oCurl);

        $retArr = json_decode($ret);

        return $retArr;
    }
    
    return $retArr;
}

function alim_token()
{

    global $allim_apikey;
    global $allim_userid;
    global $allim_senderkey;

    $allim_token = null;
    // 토큰키 생성을 위한 정보발송
    $_apiURL = 'https://kakaoapi.aligo.in/akv10/token/create/30/s/';
    $_hostInfo = parse_url($_apiURL);
    $_port = (strtolower($_hostInfo['scheme']) == 'https') ? 443 : 80;
    $_variables = array(
        'apikey' => $allim_apikey,
        'userid' => $allim_userid
    );

    $oCurl = curl_init();
    curl_setopt($oCurl, CURLOPT_PORT, $_port);
    curl_setopt($oCurl, CURLOPT_URL, $_apiURL);
    curl_setopt($oCurl, CURLOPT_POST, 1);
    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($oCurl, CURLOPT_POSTFIELDS, http_build_query($_variables));
    curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);

    $ret = curl_exec($oCurl);
    $error_msg = curl_error($oCurl);
    curl_close($oCurl);
    $retArr = json_decode($ret, true);
    // var_dump($retArr);
    // exit;
    if ($retArr['code'] == "0") {
        $allim_token = $retArr['token'];
    }

    return $allim_token;
}

function validatePhone($phone) {
    $cleanPhone = str_replace(['-', '.'], '', $phone);
    return preg_match('/^01[0-9]{8,9}$/', $cleanPhone);
}