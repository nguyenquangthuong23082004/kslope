<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 


	$types			= updateSQ($_POST["types"]);
	$coupon_type	= updateSQ($_POST["coupon_type"]);
	$coupon_cnt		= updateSQ($_POST["coupon_cnt"]);
	
	echo $coupon_type . " / " . $coupon_cnt;


	$ok_cnt = 0;
	$er_cnt = 0;

	for($i=1; $i<=$coupon_cnt; $i++){

		$new_coupon = createCoupon($coupon_type);
		
		if( $new_coupon == "Error"){
			$er_cnt++;
		}else{
			$ok_cnt++;
		}


	}

?>
<script>
	alert("<?=$ok_cnt?> 개 생성, <?=$er_cnt?> 개 오류! ");
	location.href="/AdmMaster/_operator/coupon_list.php";
</script>