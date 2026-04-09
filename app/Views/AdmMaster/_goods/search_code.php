<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";

	$codeType = $_POST['codeType'];
	$searchCode = $_POST['searchCode'];

	
	if($codeType == "code"){
		$sql_re = " goods_code = '".$searchCode."' ";
	}else if($codeType == "erp"){
		$sql_re = " goods_erp = '".$searchCode."' ";
	}
	

	$sql_c = " SELECT count(*) as cnts FROM tbl_goods WHERE " . $sql_re;
	$result_c = mysqli_query($connect, $sql_c);
	$row_c = mysqli_fetch_array($result_c);

	echo $row_c['cnts'];
?>