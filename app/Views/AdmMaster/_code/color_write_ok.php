<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 


	$code_idx				= updateSQ($_POST["code_idx"]);
	$code_gubun				= updateSQ($_POST["code_gubun"]);
	$code_no				= updateSQ($_POST["code_no"]);
	$code_name				= updateSQ($_POST["code_name"]);
	$code_name_en			= updateSQ($_POST["code_name_en"]);
	$parent_code_no			= updateSQ($_POST["parent_code_no"]);
	$depth					= updateSQ($_POST["depth"]);
	$status					= updateSQ($_POST["status"]);
	$onum					= updateSQ($_POST["onum"]);


if ($code_idx)
{
	
		$sql = "
			update tbl_color SET 
				code_name			= '".$code_name."'	
				,status				= '".$status."'
				,onum				= '".$onum."'
			where	code_idx = '".$code_idx."'
		";
		
		mysqli_query($connect, $sql) or die (mysql_error());
	//}
} else {
	
	$sql = "
		insert into tbl_color SET 
			 code_no			= '".$code_no."'	
			,code_name			= '".$code_name."'	
			,onum				= '".$onum."'	
			,status				= '".$status."'
	";
	
	mysqli_query($connect, $sql) or die (mysql_error());
}
?>
<script>
	<? if ($b_idx)	{ ?>
	parent.location.reload();
	<? } else { ?>
	parent.location.href="color_list.php";
	<? }?>
</script>