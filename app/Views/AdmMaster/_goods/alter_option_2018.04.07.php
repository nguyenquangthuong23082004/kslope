<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 
//	mysql_query("SET AUTOCOMMIT=0");
//	mysql_query("START TRANSACTION");

	


	$g_idx					= updateSQ($_POST["g_idx"]);	
	$goods_code				= updateSQ($_POST["goods_code"]);	
	$product_color			= updateSQ($_POST["product_color"]);	
	$product_size			= updateSQ($_POST["product_size"]);	
	$product_option			= updateSQ($_POST["product_option"]);	


	$product_option_re = substr($product_option,1,strlen($product_option)-2);
	$product_option_ar = explode("||",$product_option_re);





if ($g_idx){

	// 기존 옵션 삭제
	$sql = " delete from tbl_goods_option where goods_code = '".$goods_code."' ";
	mysqli_query($connect, $sql) or die (mysqli_error($connect));


	// 옵션 재등록
	foreach($product_option_ar as $arr1){
		//echo $arr1 . "<br/>";

		$_tmp_arr = explode(":", $arr1);
		
		$_tmp_color = $_tmp_arr[0];
		$_tmp_size = $_tmp_arr[1];
		
		$goods_cnt = ${"option_cnt_".$_tmp_color."_".$_tmp_size};
		$use_yn = ${"option_use_".$_tmp_color."_".$_tmp_size};


		$sql_su = "
			insert into tbl_goods_option SET 
				 goods_code		= '".$goods_code."'
				,goods_color	= '".$_tmp_color."'
				,goods_size		= '".$_tmp_size."'
				,goods_cnt		= '".$goods_cnt."'
				,use_yn			= '".$use_yn."'		
		";
		
		mysqli_query($connect, $sql_su) or die (mysqli_error($connect));

	}

	// 상품 테이블 변경

	$sql = "
		update tbl_goods SET 
			 product_color			= '".$product_color."'
			,product_size			= '".$product_size."'
			,product_option			= '".$product_option."'
		where g_idx = '".$g_idx."'
	";

	mysqli_query($connect, $sql) or die (mysqli_error($connect));


}

?>
<script>
	alert("수정되었습니다.");
	parent.location.reload();
</script>
