<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 
	$product_color = $_POST['product_color'];
	$product_size = $_POST['product_size'];
	$goods_code	= $_POST['goods_code'];

	/*
	$product_color = $_GET['product_color'];
	$product_size = $_GET['product_size'];
	*/

		
	// 앞뒤 껍데기 제거
	$product_color = getCodeSlice($product_color,"UTF-8");
	$product_size = getCodeSlice($product_size,"UTF-8");

	$out_txt = "";
	$out_code = "";

	
	$arr_product_color = explode("||",$product_color);
	$arr_product_size = explode("||",$product_size);

	foreach($arr_product_color as $color_key=>$color_val){

		$sql_c = " SELECT * 
				   FROM tbl_color
				  WHERE code_no='$color_val'
				  ORDER BY onum asc
			   ";
		$result_c = mysqli_query($connect, $sql_c);
		$row_c = mysqli_fetch_array($result_c);

		
		foreach($arr_product_size as $size_key=>$key_val){

			$sql = " SELECT * 
			           FROM tbl_size
					  WHERE type='$key_val'
					  ORDER BY onum asc
				   ";
			$result = mysqli_query($connect, $sql);
			while( $row = mysqli_fetch_array($result) ){
				
				$_tmp_code = $color_val . ":" . $row['code_no'];

				if($goods_code){
					$_tmp_cnt = get_option_cnt($goods_code, $row_c['code_no'], $row['code_no']);
					$_tmp_use = get_option_use($goods_code, $row_c['code_no'], $row['code_no']);

					if($_tmp_use=="N"){
						$_tmp_use1 = "";
						$_tmp_use2 = "selected=selected";
					}else{
						$_tmp_use1 = "selected=selected";
						$_tmp_use2 = "";
					}
				}
				// 




				$out_txt .=  "<tr color='".$row_c['code_no']."' size='".$row['type']."'   >";
				$out_txt .=  "	<td>";
				$out_txt .=  "		".$row_c['code_name'];
				$out_txt .=  "	</td>";
				$out_txt .=  "	<td>";
				$out_txt .=  "		".$row['code_name'];
				$out_txt .=  "	</td>";
				$out_txt .=  "	<td>";
				$out_txt .=  "		<input type='text' class='onlynum' name='option_cnt_".$row_c['code_no'] . "_" . $row['code_no'] ."'  id='' value='".$_tmp_cnt."'  >";
				$out_txt .=  "	</td>";
				$out_txt .=  "	<td >";
				$out_txt .=  "		<select name='option_use_".$row_c['code_no'] . "_" . $row['code_no'] ."' >";
				$out_txt .=  "			<option value='Y' ".$_tmp_use1." >사용</option>";
				$out_txt .=  "			<option value='N' ".$_tmp_use2." >중지</option>";
				$out_txt .=  "		</select>";
				$out_txt .=  "	</td>";
				$out_txt .=  "	<td>";
				$out_txt .=  "		<button type='button' onclick='delOption(\"".$_tmp_code."\",this)' >삭제</button>";
				$out_txt .=  "	</td>";
				$out_txt .=  "</tr>";

				$out_code .= "|" . $_tmp_code . "|";
			}
			
		}

	}

	echo $out_txt;
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#product_option").val("<?=$out_code?>");
	});
</script>