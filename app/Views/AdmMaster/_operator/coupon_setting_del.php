<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 


	if(!isset($_GET['idx'])) exit;

	for ($i=0;$i < count($idx) ; $i++) {
		$sql1	= " update tbl_coupon_setting set state = 'C' where idx = '".$idx[$i]."' ";
		$db1	= mysqli_query($connect, $sql1);
		
	}


?>
<script>
	parent.location.href="/AdmMaster/_operator/coupon_setting.php";
</script>