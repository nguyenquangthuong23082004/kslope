<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 

	$user_id		= $_GET['user_id'];
	$coupon_nums	= $_GET['coupon_nums'];

	echo sendCoupon($coupon_nums, $user_id);
?>