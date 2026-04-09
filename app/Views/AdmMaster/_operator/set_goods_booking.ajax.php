<?
	include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php"; 

	
	$g_idx		= $_GET['g_idx'];



	$fsql = "
		insert into tbl_booking SET 
			 g_idx		= '".$g_idx."'
			,regdate	= now()
	";



	$fresult = mysqli_query($connect, $fsql) or die (mysqli_error($connect));
	if($fresult){
		echo "ok";
	}else{
		echo "Error : 등록에 실패하였습니다.";
	}
?>