<?php

function generateRandomString($length): string
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuyvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateRandomNumber($length): string
{
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function homeSetInfo()
{
    $site = model("HomeSetModel");
    try {
        $infoData = $site->getSiteConfig(1);
        if (!$infoData) {
            throw new Exception("");
        }
        $resultArr = $infoData;
    } catch (Exception $err) {

        $resultArr = [];
    } finally {
        return $resultArr;
    }
}

function getPolicy($filed)
{
    $policyModel = model("PolicyModel");
    $policy = $policyModel->find(1);
    if (!$policy) return "";
    return $policy[$filed] ?? "";
}

function getLocale($request = null)
{
    $supportedLangs = config('App')->supportedLocales;

    if ($request) {
        $lang = $request->uri->getSegment(1);
        if (in_array($lang, $supportedLangs)) {
            return $lang;
        }

        $lang = $request->getGet('lang') ?? $request->getPost('lang');
        if (in_array($lang, $supportedLangs)) {
            return $lang;
        }

        $lang = $request->getHeaderLine('Accept-Language');
        $lang = substr($lang, 0, 2);
        if (in_array($lang, $supportedLangs)) {
            return $lang;
        }
    }
    return Locale::getDefault();
}

function updateSQ($textToFilter)
{
    //a = &#97;
    //e = &#101;
    //i = &#105;
    //o = &#111;
    //u  = &#117;

    //A = &#65;
    //E = &#69;
    //I = &#73;
    //O = &#79;
    //U = &#85;
    if ($textToFilter != null) {
        $textToFilter = str_replace('insert', 'ins&#101rt', $textToFilter);
        $textToFilter = str_replace('select', 's&#101lect', $textToFilter);
        $textToFilter = str_replace('values', 'valu&#101s', $textToFilter);
        $textToFilter = str_replace('where', 'wher&#101', $textToFilter);
        $textToFilter = str_replace('order', 'ord&#101r', $textToFilter);
        $textToFilter = str_replace('into', 'int&#111', $textToFilter);
        $textToFilter = str_replace('drop', 'dr&#111p', $textToFilter);
        $textToFilter = str_replace('delete', 'delet&#101', $textToFilter);
        $textToFilter = str_replace('update', 'updat&#101', $textToFilter);
        $textToFilter = str_replace('set', 's&#101t', $textToFilter);
        $textToFilter = str_replace('flush', 'fl&#117sh', $textToFilter);
        $textToFilter = str_replace("'", "&#39", $textToFilter);
        $textToFilter = str_replace('"', "&#34", $textToFilter);
        $textToFilter = str_replace('>', "&gt;", $textToFilter);
        $textToFilter = str_replace('<', "&lt;", $textToFilter);
        $textToFilter = str_replace('script', 'scr&#105pt', $textToFilter);
        //	$textToFilter = nl2br($textToFilter);
        $filterInputOutput = $textToFilter;
        return trim($filterInputOutput);
    }
    return '';
}

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

function write_log($message)
{
    $dir = WRITEPATH . "logs/";

    if (!file_exists($dir)) {
        if (!mkdir($dir, 0755, true)) {
            log_message('error', "로그 디렉토리 생성 실패: $dir");
            return;
        }
    }

    $filePath = $dir . date("Ymd") . ".txt";
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'CLI';
    $txt = PHP_EOL . date("Y.m.d G:i:s") . " ($ip): " . PHP_EOL . $message . PHP_EOL;

    if (file_put_contents($filePath, $txt, FILE_APPEND) === false) {
        log_message('error', "로그 파일 기록 실패: $filePath");
    }
}

function phone_chk($to_phone)
{

    $_chk_no = mt_rand(100000, 999999);

    $member = session()->get('member');
    $member['phone_chk'] = $_chk_no;

    session()->set("member", $member);

    $code = "S01";
    $_tmp_fir_array = ['NO' => $_chk_no];
    autoSms($code, $to_phone, $_tmp_fir_array);
    return true;
}

function phone_id($to_phone, $user_id)
{
    $code = "S04";
    $_tmp_fir_array = ['ID' => $user_id];
    autoSms($code, $to_phone, $_tmp_fir_array);
    return true;
}

function phone_pw($to_phone, $pw)
{
    $code = "S05";
    $_tmp_fir_array = ['PASSWORD' => $pw];
    autoSms($code, $to_phone, $_tmp_fir_array);
    return true;
}

function autoSms($code, $to_phone, $_tmp_fir_array)
{
    $smsModel = model("SmsModel");

    $row = $smsModel->where('code', $code)->first();

    // 해당 코드가 자동 발송이 가능한가?
    if ($row['autosend'] != "Y") {
        return false;
    }

    // 문자 보낼 내역이 없다면
    if ($row['content'] == "") {
        return false;
    }

    // 문자 보낼 내역
    $_tmp_content = viewSQ($row['content']);

    $_tmp_content = replacePatternsSms($_tmp_content, $_tmp_fir_array);

    return send_aligo($_tmp_content, $to_phone, "");
}

function alimTalkSend($tmpCode, $allim_replace)
{
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

function send_aligo($msg, $to_phone, $title = "")
{

    $setting = homeSetInfo();
    $to_phone = str_replace("-", "", $to_phone);

    /****************** 인증정보 시작 ******************/
    $sms_url = "https://apis.aligo.in/send/"; // 전송요청 URL
    $sms['user_id'] = $setting['allim_userid']; // SMS 아이디
    $sms['key'] = $setting['allim_apikey']; // 인증키

    $_POST['msg'] = $msg; // 메세지 내용 : euc-kr로 치환이 가능한 문자열만 사용하실 수 있습니다. (이모지 사용불가능)
    $_POST['receiver'] = $to_phone; // 수신번호  01111111111, 01111111112
    $_POST['destination'] = ''; // 수신인 %고객명% 치환  01111111111|담당자,01111111112|홍길동
    $_POST['sender'] = ''; // 발신번호
    $_POST['rdate'] = ''; // 예약일자 - 20161004 : 2016-10-04일기준
    $_POST['rtime'] = ''; // 예약시간 - 1930 : 오후 7시30분
    $_POST['testmode_yn'] = 'Y'; // Y 인경우 실제문자 전송X , 자동취소(환불) 처리
    $_POST['subject'] = '한국급경사지안전협회.'; //  LMS, MMS 제목 (미입력시 본문중 44Byte 또는 엔터 구분자 첫라인)
    //$_POST['image']        = '../data/brand/20210314140356.png'; // MMS 이미지 파일 위치 (저장된 경로)
    $_POST['msg_type'] = 'SMS'; //  SMS, LMS, MMS등 메세지 타입을 지정
    // ※ msg_type 미지정시 글자수/그림유무가 판단되어 자동변환됩니다. 단, 개행문자/특수문자등이 2Byte로 처리되어 SMS 가 LMS로 처리될 가능성이 존재하므로 반드시 msg_type을 지정하여 사용하시기 바랍니다.

    /****************** 전송정보 설정끝 ***************/
    $sms['msg'] = stripslashes($_POST['msg']);
    $sms['receiver'] = $_POST['receiver'];
    $sms['destination'] = $_POST['destination'];
    $sms['sender'] = $_POST['sender'];
    $sms['rdate'] = $_POST['rdate'];
    $sms['rtime'] = $_POST['rtime'];
    //$sms['testmode_yn']	= empty($_POST['testmode_yn']) ? '' : $_POST['testmode_yn'];
    $sms['testmode_yn'] = 'N';
    $sms['title'] = $_POST['subject'];
    $sms['msg_type'] = $_POST['msg_type'];

    $oCurl = curl_init();
    // 이미지 전송 설정
    if (!empty($_POST['image'])) {
        if (file_exists($_POST['image'])) {
            $tmpFile = explode('/', $_POST['image']);
            $str_filename = $tmpFile[sizeof($tmpFile) - 1];
            $tmp_filetype = mime_content_type($_POST['image']);
            if ((version_compare(PHP_VERSION, '5.5') >= 0)) { // PHP 5.5버전 이상부터 적용
                $sms['image'] = new CURLFile($_POST['image'], $tmp_filetype, $str_filename);
                curl_setopt($oCurl, CURLOPT_SAFE_UPLOAD, true);
            } else {
                $sms['image'] = '@' . $_POST['image'] . ';filename=' . $str_filename . ';type=' . $tmp_filetype;
            }
        }
    }

    $host_info = explode("/", $sms_url);
    $port = $host_info[0] == 'https:' ? 443 : 80;

    $oCurl = curl_init();
    curl_setopt($oCurl, CURLOPT_PORT, $port);
    curl_setopt($oCurl, CURLOPT_URL, $sms_url);
    curl_setopt($oCurl, CURLOPT_POST, 1);
    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($oCurl, CURLOPT_POSTFIELDS, $sms);
    curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
    $ret = curl_exec($oCurl);
    curl_close($oCurl);

    //echo $ret;
    $retArr = json_decode($ret); // 결과배열
//    print_r($retArr);
//    die();
    //print_r($retArr); // Response 출력 (연동작업시 확인용)
    return true;
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
    if (!$row || $row['autosend'] != "Y") {
        return false;
    }

    // 메일 보낼 내역이 없다면
    if ($row['content'] == "") {
        return false;
    }

    // 메일 보낼 내역
    $_tmp_content = viewSQ($row['content']);
    $subject = $row['mail_title'];

    $nameFrom = $infoRow['site_name'];
    $mailFrom = $infoRow['smtp_id'];
    $to_name = $user_mail;
    $to_email = $user_mail;

    $_tmp_content = replacePatternsEmail($_tmp_content, $_tmp_fir_array);
    
    // Lấy attachment path từ template data
    $attachment_path = $_tmp_fir_array['r_file'] ?? '';

    $err = send_mail($nameFrom, $mailFrom, $to_name, $to_email, $subject, $_tmp_content, '', $attachment_path);
    
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

function send_mail($from_name, $from_email, $to_name, $to_email, $subject, $message, $ext_header = "", $attachment_path = "")
{
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

    $from_email = 'trenvl.mg@trenvl.com'; 

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

    // Xử lý attachment
    if ($attachment_path && file_exists($attachment_path)) {
        $boundary = "----=_Part_" . md5(uniqid());
        $filename = basename($attachment_path);
        
        // Đọc file attachment
        $file_size = filesize($attachment_path);
        $handle = fopen($attachment_path, "r");
        $file_content = fread($handle, $file_size);
        fclose($handle);
        
        $encoded_content = chunk_split(base64_encode($file_content));
        
        // Header với multipart
        $header .= "MIME-Version: 1.0\n";
        $header .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\n";
        
        // Body với attachment
        $body = "--$boundary\n";
        $body .= "Content-Type: text/html; charset=UTF-8\n";
        $body .= "Content-Transfer-Encoding: 8bit\n\n";
        $body .= $message . "\n\n";
        
        // Attachment
        $body .= "--$boundary\n";
        $body .= "Content-Type: application/pdf; name=\"$filename\"\n";
        $body .= "Content-Transfer-Encoding: base64\n";
        $body .= "Content-Disposition: attachment; filename=\"$filename\"\n\n";
        $body .= $encoded_content . "\n\n";
        $body .= "--$boundary--";
        
        $mail_data = $header . "\n\n" . $body;
    } else {
        // Không có attachment
        $header .= "MIME-Version: 1.0\n";
        $header .= "Content-Type: TEXT/HTML; charset=UTF-8\n";
        $header .= "Content-Transfer-Encoding: 8BIT\n";

        $mail_data = $header . "\n\n" . $message;
    }
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
        $infoData = homeSetInfo();
        if (!$infoData) {
            return "Error:data - No Setting input";
        }

        $host = 'smtp.cafe24.com';
        $port = 587;
        $smtp_id = 'trenvl.mg@trenvl.com';
        $smtp_pw = 'xmfpsqmf!@12';

        $id = base64_encode($smtp_id);
        $pw = base64_encode($smtp_pw);

        $limit = 30;

        $socket = fsockopen($host, $port, $errno, $errstr, $limit);

        if (!$socket) {
            write_log("SMTP connection failed: ($errno : $errstr)");
            return "Error: fsockopen ($errno : $errstr)";
        }

        $response = fgets($socket, 1024);
        if (substr($response, 0, 3) !== "220") {
            write_log("SMTP greeting failed: $response");
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
            write_log("AUTH LOGIN failed: $response");
            return "Error: AUTH LOGIN - $response";
        }

        fwrite($socket, $id . "\r\n");
        $response = fgets($socket, 1024);
        if (substr($response, 0, 3) !== "334") {
            write_log("Username failed: $response");
            return "Error: SMTP ID - $response";
        }

        fwrite($socket, $pw . "\r\n");
        $response = fgets($socket, 1024);
        if (substr($response, 0, 3) !== "235") {
            write_log("Password failed: $response");
            return "Error: SMTP PW - $response";
        }

        fwrite($socket, "MAIL FROM:<{$from_email}>\r\n");
        $response = fgets($socket, 1024);
        if (substr($response, 0, 3) !== "250") {
            write_log("MAIL FROM failed: $response");
            return "Error: MAIL FROM - $response";
        }

        fwrite($socket, "RCPT TO:<{$to_email}>\r\n");
        $response = fgets($socket, 1024);
        if (substr($response, 0, 3) !== "250") {
            write_log("RCPT TO failed: $response");
            return "Error: RCPT TO - $response";
        }

        fwrite($socket, "DATA\r\n");
        $response = fgets($socket, 1024);
        if (substr($response, 0, 3) !== "354") {
            write_log("DATA failed: $response");
            return "Error: DATA - $response";
        }

        $mail_data = str_replace("\r\n.\r\n", "\r\n . \r\n", $mail_data);

        fwrite($socket, $mail_data . "\r\n.\r\n");
        $response = fgets($socket, 1024);
        if (substr($response, 0, 3) !== "250") {
            write_log("Mail send failed: $response");
            return "Error: mail_data - $response";
        }
        
        fwrite($socket, "QUIT\r\n");
        fclose($socket);

        write_log("SMTP connection closed successfully");
        return "";

    } catch (Exception $e) {
        write_log("SMTP exception: " . $e->getMessage());
        return $e->getMessage();
    }
}

function phone_chk_ok($chkNum)
{
    $phone_chk = session('member.phone_chk');
    if ($phone_chk == "") {
        return "인증 시간이 만료되었거나, 발급되지 않았습니다. 다시 발급해주세요.";
    }

    if ($chkNum == $phone_chk) {
        return "Y";
    } else {
        return "인증에 실패하셨습니다.";
    }
}

function email_chk_ok($chkNum)
{
    $email_chk = session('member.email_chk');

    if ($email_chk == "") {
        return "인증 시간이 만료되었거나, 발급되지 않았습니다. 다시 발급해주세요.";
    }

    if ($chkNum == $email_chk) {
        return "Y";
    } else {
        return "인증에 실패하셨습니다.";
    }
}

function getCodeCourse($idx)
{
    $courseModel = model("CourseModel");
    $codeModel = model("Code");

    $course = $courseModel->where('idx', $idx)->first();
    if (!$course) {
        return '';
    }

    $code1 = $codeModel->where('code_no', $course['course_code_1'])->first();
    $code2 = $codeModel->where('code_no', $course['course_code_2'])->first();
    $code3 = $codeModel->where('code_no', $course['course_code_3'])->first();

    $html = '';
    if ($code1) $html .= $code1['code_name'];
    if ($code2) $html .= ' > ' . $code2['code_name'];
    if ($code3) $html .= ' > ' . $code3['code_name'];

    return $html;
}

function replacePatternsSms($input, $replacementValues)
{
    $replaceCallback = function ($matches) use ($replacementValues) {
        $key = $matches[1];
        return isset($replacementValues[$key]) ? $replacementValues[$key] : $matches[0];
    };

    return preg_replace_callback('/\{{(.*?)\}}/', $replaceCallback, $input);
}

function daysBetween($startDate, $endDate)
{
    $date1 = new DateTime($startDate);
    $date2 = new DateTime($endDate);

    $diff = $date1->diff($date2);

    return $diff->days;
}

function getCodeBbs($code_no, $field)
{
    $codeModel = model("Code");
    $code = $codeModel->where('code_no', $code_no)->first();
    return $code[$field] ?? '';
}

function getUrgentBbs(string $date, int $num): bool
{
    $inputDate = new DateTime($date);
    $today = new DateTime(date('Y-m-d'));

    $diff = $today->diff($inputDate);

    if ($diff->invert === 1) {
        return false;
    }

    return $diff->days <= $num;
}

function compareDate(?string $date): int
{
    if (!$date) return -2;
    $input = new DateTime($date);
    $today = new DateTime(date('Y-m-d'));

    if ($input < $today) {
        return -1;
    } elseif ($input > $today) {
        return 1;
    }
    return 0;
}

    if (!function_exists('formatWatchTime')) {
        function formatWatchTime($seconds) {
            $hours = floor($seconds / 3600);
            $minutes = floor(($seconds % 3600) / 60);
            
            if ($hours > 0) {
                return "{$hours}시간 {$minutes}분";
            }
            return "{$minutes}분";
        }
    }

    if (!function_exists('daysBetween')) {
        function daysBetween($start, $end) {
            $startDate = new DateTime($start);
            $endDate = new DateTime($end);
            $interval = $startDate->diff($endDate);
            return $interval->days;
        }
    }

    if (!function_exists('getCodeCourse')) {
        function getCodeCourse($courseIdx) {
            return "COURSE-" . str_pad($courseIdx, 4, '0', STR_PAD_LEFT);
        }
    }