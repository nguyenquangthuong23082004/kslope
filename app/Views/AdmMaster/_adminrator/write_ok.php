<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 


	$m_idx   		= updateSQ($_POST["m_idx"]);
	$user_id		= updateSQ($_POST["user_id"]);
	$user_pw		= updateSQ($_POST["user_pw"]);
	$user_name		= updateSQ($_POST["user_name"]);
	$user_mobile	= updateSQ($_POST["user_mobile"]);
	$status			= updateSQ($_POST["status"]);
	$auth			= $_POST['auth'];



if ($m_idx)
{
	
		$sql = "
			update tbl_member SET 
				user_name			= '".$user_name."'	
				,user_mobile		= '".$user_mobile."'	
				,status				= '".$status."'
			where	m_idx           = '".$m_idx."'
		";
		
		mysqli_query($connect, $sql) or die (mysql_error());
	//}
} else {
	
	$sql = "
		insert into tbl_member SET 
			user_id		 = '".$user_id."'
			,user_pw	 = '".sql_password($user_pw)."'
			,user_name	 = '".$user_name."'	
			,user_mobile = '".$user_mobile."'	
			,status		 = '".$status."'
			,user_level  = '2'
			,user_ip	 = '".$_SERVER['REMOTE_ADDR']."'
			,r_date		 = now() ";
	
	mysqli_query($connect, $sql) or die (mysql_error());
}
?>
<script>
	<? if ($b_idx)	{ ?>
	parent.location.reload();
	<? } else { ?>
	parent.location.href="/AdmMaster/_adminrator/store_config_admin.php";
	<? }?>
</script>