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
			update tbl_group SET 
				code_name			= '".$code_name."'	
				,code_name_en		= '".$code_name_en."'	
				,status				= '".$status."'
				,onum				= '".$onum."'
			where	code_idx = '".$code_idx."'
		";
		
		mysqli_query($connect, $sql) or die (mysql_error());
	//}
} else {
	
	$sql = "
		insert into tbl_group SET 
			code_gubun			= '".$code_gubun."'
			,code_no			= '".$code_no."'	
			,code_name			= '".$code_name."'	
			,code_name_en		= '".$code_name_en."'	
			,parent_code_no		= '".$parent_code_no."'	
			,depth				= '".$depth."'
			,status				= '".$status."'
			,onum				= '".$onum."'
	";
	
	mysqli_query($connect, $sql) or die (mysql_error());
}
?>
<script>
	<? if ($b_idx)	{ ?>
	parent.location.reload();
	<? } else { ?>
	parent.location.href="group_list.php?s_parent_code_no=<?=$parent_code_no?>";
	<? }?>
</script>