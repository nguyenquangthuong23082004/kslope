<?
include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";


$m_idx	= updateSQ($_POST["m_idx"]);
$product_option	= updateSQ($_POST["product_market_option"]);
$product_option_re = substr($product_option,1,strlen($product_option)-2);
$product_option_ar = explode("||",$product_option_re);

$goods_code	= updateSQ($_POST["goods_market_code"]);


$option_market_cnt = $_REQUEST[option_market_cnt];

$sql = " delete from tbl_goods_agency_option where m_idx=".$m_idx." AND goods_code = '".$goods_code."' ";

mysqli_query($connect, $sql) or die (mysqli_error($connect));

$num = 0;
foreach($product_option_ar as $arr1){

	$_tmp_arr = explode(":", $arr1);

	$_tmp_color = $_tmp_arr[0];
	$_tmp_size = $_tmp_arr[1];

	$goods_cnt = $option_market_cnt[$num];
	
	$sql_su = "
		insert into tbl_goods_agency_option SET
			 m_idx		= '".$m_idx."'
			,goods_code		= '".$goods_code."'
			,goods_color	= '".$_tmp_color."'
			,goods_size		= '".$_tmp_size."'
			,goods_cnt		= '".$goods_cnt."'
			,use_yn			= '".$use_yn."'
	";

	mysqli_query($connect, $sql_su) or die (mysqli_error($connect));	

	$num = $num + 1;
}
echo "ok";
?>