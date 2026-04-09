<?
include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";


$idx	= updateSQ($_POST["idx"]);
$goods_cnt	= updateSQ($_POST["goods_cnt"]);
$price_normal = updateSQ($_POST["price_normal"]);
$price_margin = updateSQ($_POST["price_margin"]);
$price_one = updateSQ($_POST["price_one"]);



	if($idx != ""){
		$sql_su = "update tbl_goods_adm_option set goods_cnt=".$goods_cnt." , price_normal='".$price_normal."', price_margin='".$price_margin."', price_one='".$price_one."' where idx=".$idx."";
		mysqli_query($connect, $sql_su) or die (mysqli_error($connect));
	}
echo "ok";
?>