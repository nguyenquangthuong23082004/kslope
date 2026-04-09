<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 


	function Unescape($str) // UnescapeFunc는 아래에 정의되어 있음
	{
	   return urldecode(preg_replace_callback('/%u([[:alnum:]]{4})/', 'UnescapeFunc', $str));
	}
	  
	function UnescapeFunc($str){
	   return iconv('UTF-16LE', 'UTF-8', chr(hexdec(substr($str[1], 2, 2))).chr(hexdec(substr($str[1],0,2))));
	}

	$tmp_goods = Unescape($_GET['tmp_goods']);
	$product_code_1 = $_GET['product_code_1'];
	$product_code_2 = $_GET['product_code_2'];
	$product_code_3 = $_GET['product_code_3'];
	$product_code_4 = $_GET['product_code_4'];

	$sql_detail = "";
	if($tmp_goods){
		$sql_detail .= " AND (goods_name_front like '%".$tmp_goods."%' or goods_name_back  like '%".$tmp_goods."%' or goods_code  like '%".$tmp_goods."%' )  ";
	}

	$_search_code = "";

	if($product_code_4){
		$_search_code = "|".$product_code_4;
		$sql_detail .= " AND product_code like '%".$_search_code."%' ";
	}else if($product_code_3){
		$_search_code = "|".$product_code_3;
		$sql_detail .= " AND product_code like '%".$_search_code."%' ";
	}else if($product_code_2){
		$_search_code = "|".$product_code_2;
		$sql_detail .= " AND product_code like '%".$_search_code."%' ";
	}else if($product_code_1){
		$_search_code = "|".$product_code_1;
		$sql_detail .= " AND product_code like '%".$_search_code."%' ";
	}

	$sql = " 
			 SELECT * 
			   FROM tbl_goods 
			  WHERE item_state = 'sale' 
				AND g_idx not in (select g_idx from tbl_deal) 
				$sql_detail
			  ORDER BY goods_name_front asc ";
	$result = mysqli_query($connect, $sql) or die (mysql_error());
	$nTotalCount = mysqli_num_rows($result);

	if($nTotalCount < 1){
	?>
		<tr>
			<th colspan="2">일치하는 상품이 없습니다.</th>
		</tr>
	<?
	}
	
	while ($row = mysqli_fetch_array($result)) {
	?>

		<tr onclick="sel_goods('<?=$row['g_idx']?>');">
			<th><?=$row['goods_code']?></th>
			<td><?=$row['goods_name_front']?> / <?=$row['goods_name_back']?></td>
		</tr>
	
	<?
	}
	?>
