<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 

//error_reporting(E_ALL);
//ini_set("display_errors", 1);


	$order_delay_days			= updateSQ($_POST["order_delay_days"]);
	$order_stock_repair			= updateSQ($_POST["order_stock_repair"]);
	$order_point_repair			= updateSQ($_POST["order_point_repair"]);
	$order_coupon_repair		= updateSQ($_POST["order_coupon_repair"]);
	$point_give_use				= updateSQ($_POST["point_give_use"]);
	$point_use_order_total		= updateSQ($_POST["point_use_order_total"]);
	$point_use_minimum_point	= updateSQ($_POST["point_use_minimum_point"]);
	$point_use_maximum_point	= updateSQ($_POST["point_use_maximum_point"]);
	$member_agree_point			= updateSQ($_POST["member_agree_point"]);
	$goods_point				= updateSQ($_POST["goods_point"]);

	$transfer_pay_free_total	= updateSQ($_POST["transfer_pay_free_total"]);
	$transfer_pay_type			= updateSQ($_POST["transfer_pay_type"]);
	$transfer_pay_price			= updateSQ($_POST["transfer_pay_price"]);
	$transfer_pay_standard		= updateSQ($_POST["transfer_pay_standard"]);


		$sql = "
			UPDATE tbl_define SET 
				   order_delay_days			= '".$order_delay_days."'
				 , order_stock_repair		= '".$order_stock_repair."'
				 , order_point_repair		= '".$order_point_repair."'
				 , order_coupon_repair		= '".$order_coupon_repair."'
				 , point_give_use			= '".$point_give_use."'
				 , point_use_order_total	= '".$point_use_order_total."'
				 , point_use_minimum_point	= '".$point_use_minimum_point."'
				 , point_use_maximum_point	= '".$point_use_maximum_point."'
				 , member_agree_point		= '".$member_agree_point."'
				 , goods_point				= '".$goods_point."'
				 , transfer_pay_free_total	= '".$transfer_pay_free_total."'
				 , transfer_pay_type		= '".$transfer_pay_type."'
				 , transfer_pay_price		= '".$transfer_pay_price."'
				 , transfer_pay_standard	= '".$transfer_pay_standard."'
			 WHERE idx = '1'
		";
		

		//echo $sql . "<br/>";
		mysqli_query($connect, $sql) or die (mysqli_error($connect));

?>
<script>
	alert("수정하였습니다.");
	location.href="/AdmMaster/_adminrator/stock_list.php";
</script>