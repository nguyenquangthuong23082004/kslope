<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 


	$idx	= updateSQ($_POST["idx"]);
	$ip1	= updateSQ($_POST["ip1"]);
	$ip2	= updateSQ($_POST["ip2"]);
	$ip3	= updateSQ($_POST["ip3"]);
	$ip4	= updateSQ($_POST["ip4"]);
	$memo	= updateSQ($_POST["memo"]);
	$use	= updateSQ($_POST["use"]);

	$ip = $ip1.".".$ip2.".".$ip3.".".$ip4;
	
	


if ($idx)
{
	
		$sql = "
			update tbl_adminIP SET 
				 ip			= '".$ip."'	
				,memo		= '".$memo."'
				,useYN		= '".$use."'
			where idx = '".$idx."'
		";
		
		mysqli_query($connect, $sql) or die (mysql_error());
	
} else {
	
	$sql = "
		insert into tbl_adminIP SET 
			 ip			= '".$ip."'	
			,memo		= '".$memo."'
			,useYN		= '".$use."'	
			,regdate	= now()
			
	";
	
	mysqli_query($connect, $sql) or die (mysql_error());
}
?>
<script>
	<? if ($idx)	{ ?>
	alert("수정되었습니다.");
	parent.location.reload();
	<? } else { ?>
	parent.location.href="admin_ip.php";
	<? }?>
</script>