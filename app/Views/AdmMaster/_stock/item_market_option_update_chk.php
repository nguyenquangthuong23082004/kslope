<?
include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";


$m_idx	= updateSQ($_POST["m_idx"]);



$product_option	= updateSQ($_POST["product_market_option"]);
$product_option_re = substr($product_option,1,strlen($product_option)-2);
$product_option_ar = explode("||",$product_option_re);

$goods_code	= updateSQ($_POST["goods_market_code"]);
$_tmp_market_color	= updateSQ($_POST["_tmp_market_color"]);
$_tmp_market_size	= updateSQ($_POST["_tmp_market_size"]);


$option_market_cnt = $_REQUEST[option_market_cnt];



$num = 0;
foreach($product_option_ar as $arr1){

	$_tmp_arr = explode(":", $arr1);

	$_tmp_color = $_tmp_arr[0];
	$_tmp_size = $_tmp_arr[1];

	$goods_cnt = $option_market_cnt[$num];
	

$fsql3    = "select * from tbl_goods_adm_option where goods_code='".$goods_code."' 
					AND goods_color = '".$_tmp_color."' 
					AND goods_size = '".$_tmp_size."'  
					limit 1 ";
$fresult3 = mysqli_query($connect, $fsql3) or die (mysql_error());
$frow3 = mysqli_fetch_array($fresult3);


$num_total = $frow3['goods_cnt'];



$sql_all    = "select sum(goods_cnt) AS cnt from tbl_goods_agency_option where m_idx !=".$m_idx." 
	AND  goods_code='".$goods_code."' 
	AND goods_color = '".$_tmp_color."' 
	AND goods_size = '".$_tmp_size."'  
";

$fresult_all = mysqli_query($connect, $sql_all) or die (mysql_error());
$frow_all = mysqli_fetch_array($fresult_all);

$cnt_other = $frow_all["cnt"];
$cnt = $option_market_cnt[$num];


$itemSum = (int)$cnt_other + (int)$cnt;

$num = $num + 1;

}




if((int)$num_total < (int)$itemSum){
	echo "-1";
}else{
	echo "1";
}
?>