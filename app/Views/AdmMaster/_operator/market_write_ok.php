<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 


	$idx			= updateSQ($_POST["idx"]);
	$shop_name		= updateSQ($_POST["shop_name"]);
	$zip			= updateSQ($_POST["zip"]);
	$addr1			= updateSQ($_POST["addr1"]);
	$addr2			= updateSQ($_POST["addr2"]);
	$phone			= updateSQ($_POST["phone"]);
	$email			= updateSQ($_POST["email"]);
	



if ($idx)
{
	
		$sql = "
			update tbl_market SET 
				shop_name	= '".$shop_name."'	
				,zip		= '".$zip."'
				,addr1		= '".$addr1."'
				,addr2		= '".$addr2."'
				,phone		= '".$phone."'
				,email		= '".$email."'
			where m_idx = '".$idx."'
		";
		
		mysqli_query($connect, $sql) or die (mysql_error());
	
} else {
	
	$sql = "
		insert into tbl_market SET 
			 shop_name	= '".$shop_name."'	
			,zip		= '".$zip."'	
			,addr1		= '".$addr1."'
			,addr2		= '".$addr2."'
			,phone		= '".$phone."'
			,email		= '".$email."'
			,status		= 'Y'
			,regdate	= now()
	";
	
	mysqli_query($connect, $sql) or die (mysql_error());
}
?>

<script>
	<? if ($idx)	{ ?>
		parent.location.reload();
	<? } else { ?>
		parent.location.href="/AdmMaster/_operator/market_list.php";
	<? }?>
</script>