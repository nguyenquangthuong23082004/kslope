<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 
//	mysql_query("SET AUTOCOMMIT=0");
//	mysql_query("START TRANSACTION");

	/* 추후 사용하지 않을 경우 제거 예정
	$pg					= updateSQ($_POST["pg"]);
	$search_name		= updateSQ($_POST["search_name"]);
	$search_category	= updateSQ($_POST["search_category"]);
	*/
	


	$idx			= updateSQ($_POST["idx"]);	
	$user_id		= updateSQ($_POST["user_id"]);	
	$point			= updateSQ($_POST["point"]);
	$msg			= updateSQ($_POST["msg"]);
	$enddate		= updateSQ($_POST["enddate"]);


	if( chk_member_id($user_id) < 1){
		alert_msg("존재하지 않는 아이디입니다.");
		exit;
	}

	

if ($idx){


	$sql = "
		update tbl_point SET 
			 user_id				= '".$user_id."'
			,msg					= '".$msg."'
			,point					= '".$point."'
			,enddate				= '".$enddate."'
		where idx = '".$idx."'
	";
	write_log("포인트수정 : ".$sql);
	mysqli_query($connect, $sql) or die (mysqli_error($connect));



}else{

	$sql = "
		insert into tbl_point SET 
			 user_id		= '".$user_id."'
			,msg			= '".$msg."'
			,point			= '".$point."'
			,enddate		= '".$enddate."'
			,regdate		= now()
	";
	write_log("포인트지급 : ".$sql);
	mysqli_query($connect, $sql) or die (mysqli_error($connect));

}

	
?>
<script>
	<?if ($idx){?>
	alert("수정되었습니다.");
	location.href="/AdmMaster/_member/member_point_write.php?idx=<?=$idx?>";
	<? } else { ?>
	alert("등록되었습니다.");
	location.href="/AdmMaster/_member/member_point.php";
	<?}?>
</script>