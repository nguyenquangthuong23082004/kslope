<?
include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php"; 
header("Content-Type: text/html; charset=utf-8");

////////////////////////////////////////////////////////////
// register_globals = Off
////////////////////////////////////////////////////////////
	if($_GET) @extract($_GET);
	if($_POST) @extract($_POST);
	if($_COOKIE) @extract($_COOKIE);


////////////////////////////////////////////////////////////
// 파일 인클루드 / 객체 생성
////////////////////////////////////////////////////////////
		$user_id	= updateSQ($_POST[user_id]);
		$user_pw		= updateSQ($_POST[user_pw]);

		$total_sql = " select * from tbl_member where user_id='".$user_id."'";
		$result = mysqli_query($connect, $total_sql) or die (mysql_error());
		$row=mysqli_fetch_array($result);

		$auth_level = $row[manage];
		if ($row[user_id] == "") {
			//아이디가 없습니다.
			alert_msg("존재하지 않는 아이디입니다.");
			exit();
		}

		
		if ($row["user_pw"] != sql_password($user_pw)) {
			alert_msg("패스워드가 일치하지 않습니다.");
			exit();
		}
		
		
		if ($row[status] == "N") {
			//아이디가 없습니다.
			alert_msg("현재 인증대기중입니다.");
			exit();
		}

		if ($row[user_level] > 2) {				// 운영자까지 로그인이 가능하도록 운영자 레벨 2, 최고 관리자 레벨 1
			//패스워드가 일치하지 않습니다.
			alert_msg("로그인 하실 권한이 없으십니다.");
			exit();
		}


		$_SESSION[member][id]	= $row[user_id];
		$_SESSION[member][idx]	= $row[m_idx];
		$_SESSION[member][name] = $row[user_name];
		$_SESSION[member][email] = $row[user_email];
		$_SESSION[member][level] = $row[user_level];
?>
<script>	
	alert("로그인 되었습니다.");
	//location.href="/AdmMaster/_bbs/board_list.php?code=notice";
	location.href="/AdmMaster/_inquiry/list_join.php";
	
</script>