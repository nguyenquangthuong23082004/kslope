<?
include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";


$idx	= updateSQ($_POST["idx"]); 
$goods_cnt	= updateSQ($_POST["goods_cnt"]); 


$sql_su = "update tbl_goods_agency_option set goods_cnt=".$goods_cnt." where idx=".$idx."";
mysqli_query($connect, $sql_su) or die (mysqli_error($connect));
			

echo "ok";
?>