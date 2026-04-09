<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 

	$pop_idx	= $_GET['pop_idx'];
	$g_idx		= $_GET['g_idx'];

	$fsql = " update tbl_popular set 
				  g_idx		= '$g_idx'
				, regdate	= now()
			   where idx	= '".$pop_idx."'
	";
	$fresult = mysqli_query($connect, $fsql) or die (mysqli_error($connect));
	if($fresult){
		echo "ok";
	}else{
		echo "Error : 수정에 실패하였습니다.";
	}
?>