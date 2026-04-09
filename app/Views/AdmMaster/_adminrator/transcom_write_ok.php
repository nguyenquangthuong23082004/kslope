<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 


	$code_idx		= updateSQ($_POST["code_idx"]);
	$code_name		= updateSQ($_POST["code_name"]);
	$t_tel			= updateSQ($_POST["t_tel"]);
	$t_url			= updateSQ($_POST["t_url"]);
	$status			= updateSQ($_POST["status"]);
	$memo			= updateSQ($_POST["memo"]);
	


if ($code_idx)
{
	
		$sql = "
			update tbl_transcom SET 
				code_name			= '".$code_name."'	
				,t_tel				= '".$t_tel."'
				,t_url				= '".$t_url."'
				,status				= '".$status."'
				,memo				= '".$memo."'
			where	code_idx = '".$code_idx."'
		";
		
		mysqli_query($connect, $sql) or die (mysql_error());
	
} else {
	
	$sql = "
		insert into tbl_transcom SET 
			 code_name			= '".$code_name."'	
			,t_tel				= '".$t_tel."'	
			,t_url				= '".$t_url."'
			,status				= '".$status."'
			,memo				= '".$memo."'
	";
	
	mysqli_query($connect, $sql) or die (mysql_error());
}
?>
<script>
	<? if ($code_idx)	{ ?>
	parent.location.reload();
	<? } else { ?>
	parent.location.href="transcom_list.php";
	<? }?>
</script>