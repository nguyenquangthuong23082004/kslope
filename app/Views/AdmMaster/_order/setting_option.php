<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 
	$goodcode	= $_POST['goodcode'];
	$option1	= $_POST['option1'];
	$option2	= $_POST['option2'];

	// 상품정보 가지고 옴

	$sql_g = " SELECT * 
			     FROM tbl_goods
			    WHERE goods_code='$goodcode'
			    ORDER BY g_idx asc
			    LIMIT 1
		   ";
	$result_g = mysqli_query($connect, $sql_g);
	$row_g = mysqli_fetch_array($result_g);

	//$goods_price = $row_g['price_se'];
	$goods_price = viewGoodsPay($row_g['g_idx']);

	// 색상정보 가지고 옴

	$sql_c = " SELECT * 
			     FROM tbl_color
			    WHERE code_no='$option1'
			    ORDER BY onum asc
			    LIMIT 1
		   ";
	$result_c = mysqli_query($connect, $sql_c);
	$row_c = mysqli_fetch_array($result_c);

	$color_name = $row_c['code_name'];


	// 사이즈정보 가지고 옴

	$sql_s = " SELECT * 
			     FROM tbl_size
			    WHERE code_no='$option2'
			    ORDER BY onum asc
			    LIMIT 1
		   ";
	$result_s = mysqli_query($connect, $sql_s);
	$row_s = mysqli_fetch_array($result_s);

	$size_name = $row_s['code_name'];


	$sql  = "SELECT *					";
	$sql .= "  FROM tbl_goods_option	";
	$sql .= " WHERE goods_code  = '".$goodcode."' 	";
	$sql .= "   AND	goods_color = '".$option1."'	";
	$sql .= "   AND	goods_size  = '".$option2."'	";
	$sql .= " ORDER BY idx desc						";
	$sql .= " LIMIT 1								";
	$sql .= "  	";

	$result = mysqli_query($connect, $sql);
	$row = mysqli_fetch_array($result);


	if($row['use_yn']=="Y" && $row['goods_cnt']>0){
		echo "Y";
	}


//--  이 밑으로는 아무것도 없어야 해요! ?>