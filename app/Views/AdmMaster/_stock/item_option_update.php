<?
include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";
$product_option	= updateSQ($_POST["product_option"]);
$product_option_re = substr($product_option,1,strlen($product_option)-2);
$product_option_ar = explode("||",$product_option_re);
$m_idx	= updateSQ($_POST["item_m_idx"]);


	//$sql = " delete from tbl_goods_adm_option where goods_code = '".$goods_code."' ";
	//mysqli_query($connect, $sql) or die (mysqli_error($connect));

	foreach($product_option_ar as $arr1){
		//echo $arr1 . "<br/>";

		$_tmp_arr = explode(":", $arr1);

		$_tmp_color = $_tmp_arr[0];
		$_tmp_size = $_tmp_arr[1];

		$goods_cnt = ${"option_cnt_".$_tmp_color."_".$_tmp_size};
		$use_yn = ${"option_use_".$_tmp_color."_".$_tmp_size};
		
		

		$sql_g = " select * from tbl_goods_adm_option where goods_code='".$goods_code."' 
					and goods_color='".$_tmp_color."' 
					and goods_size='".$_tmp_size."'
					and m_idx='".$m_idx."'
					;";
		//echo $sql_g."<br>";
		$result_g = mysqli_query($connect, $sql_g) or die (mysql_error());
		$row_good = mysqli_fetch_array($result_g);
		$g_code = $row_good["goods_code"];
	
		if($g_code == ""){
			$sql_su = "
				insert into tbl_goods_adm_option SET
					 goods_code		= '".$goods_code."'
					,goods_color	= '".$_tmp_color."'
					,goods_size		= '".$_tmp_size."'
					,goods_cnt		= '".$goods_cnt."'
					,use_yn			= '".$use_yn."'
					,m_idx			='".$m_idx."'
			";
			mysqli_query($connect, $sql_su) or die (mysqli_error($connect));	
		}else{
			
			$sql_su = "
				update tbl_goods_adm_option SET goods_cnt = '".$goods_cnt."'
					where goods_code		= '".$goods_code."'
						 and goods_color	= '".$_tmp_color."'
						 and goods_size		= '".$_tmp_size."'
						 and m_idx='".$m_idx."'
						
			";
			mysqli_query($connect, $sql_su) or die (mysqli_error($connect));				
		}	
	

	}
echo "ok";
?>