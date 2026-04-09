<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 

//error_reporting(E_ALL);
//ini_set("display_errors", 1);


	$members		= updateSQ($_POST["members"]);
	$minfo1			= updateSQ($_POST["minfo1"]);
	$minfo2			= updateSQ($_POST["minfo2"]);
	$minfo3			= updateSQ($_POST["minfo3"]);
	$trans			= updateSQ($_POST["trans"]);
	$emails			= updateSQ($_POST["emails"]);


		$sql = "
			UPDATE tbl_policy SET 
				   members		= '".$members."'
				 , minfo1		= '".$minfo1."'
				 , minfo2		= '".$minfo2."'
				 , minfo3		= '".$minfo3."'
				 , trans		= '".$trans."'
				 , emails		= '".$emails."'
			 WHERE p_idx = '1'
		";
		

		//echo $sql . "<br/>";
		mysqli_query($connect, $sql) or die (mysqli_error($connect));

?>
<script>
	alert("수정하였습니다.");
	location.href="/AdmMaster/_adminrator/policy.php";
</script>