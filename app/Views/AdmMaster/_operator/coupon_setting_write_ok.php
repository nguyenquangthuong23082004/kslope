<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 


	$idx			= updateSQ($_POST["idx"]);
	$coupon_name	= updateSQ($_POST["coupon_name"]);
	$publish_type	= updateSQ($_POST["publish_type"]);
	$dc_type		= updateSQ($_POST["dc_type"]);
	$coupon_pe		= updateSQ($_POST["coupon_pe"]);
	$coupon_price	= updateSQ($_POST["coupon_price"]);
	$dex_price_pe	= updateSQ($_POST["dex_price_pe"]);
	$exp_days		= updateSQ($_POST["exp_days"]);
	$etc_memo		= updateSQ($_POST["etc_memo"]);
	$state			= updateSQ($_POST["state"]);
	$nobrand		= updateSQ($_POST["nobrand"]);



if ($idx)
{
	
		$sql = "
			update tbl_coupon_setting SET 
				coupon_name			= '".$coupon_name."'	
				,publish_type		= '".$publish_type."'
				,dc_type			= '".$dc_type."'
				,coupon_pe			= '".$coupon_pe."'
				,coupon_price		= '".$coupon_price."'
				,dex_price_pe		= '".$dex_price_pe."'
				,exp_days			= '".$exp_days."'
				,etc_memo			= '".$etc_memo."'
				,state				= '".$state."'
				,nobrand			= '".$nobrand."'
			where idx = '".$idx."'
		";
		
		mysqli_query($connect, $sql) or die (mysql_error());
	
} else {
	
	$sql = "
		insert into tbl_coupon_setting SET 
			 coupon_name		= '".$coupon_name."'	
			,publish_type		= '".$publish_type."'	
			,dc_type			= '".$dc_type."'
			,coupon_pe			= '".$coupon_pe."'
			,coupon_price		= '".$coupon_price."'
			,dex_price_pe		= '".$dex_price_pe."'
			,exp_days			= '".$exp_days."'
			,etc_memo			= '".$etc_memo."'
			,state				= '".$state."'
			,nobrand			= '".$nobrand."'
			,regdate			= now()
	";
	
	mysqli_query($connect, $sql) or die (mysql_error());
}
?>
<script>
	<? if ($idx)	{ ?>
		parent.location.reload();
	<? } else { ?>
		parent.location.href="/AdmMaster/_operator/coupon_setting.php";
	<? }?>
</script>