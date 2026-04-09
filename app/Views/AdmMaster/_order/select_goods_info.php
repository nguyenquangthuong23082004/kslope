<?
include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 

$order_code		= updateSQ($_GET["order_code"]);


// 상품조회
$sql = " select b.idx as bidx, g.* 
           from tbl_order_sub b
		   left outer join tbl_goods g
			 on b.g_idx = g.g_idx
		  where b.order_code = '".$order_code."' 
		  order by b.idx asc ";
$result = mysqli_query($connect, $sql) or die (mysql_error($connect));
while($row_sub = mysqli_fetch_array($result)){

	foreach($row_sub as $keys => $vals){
		//echo $keys . " => " . $vals . "<br/>";
		${$keys} = $vals;
	}

?>
	<div rel="<?=$goods_code?>">
		<input type="checkbox" class="idx" name="idx[]" value="<?=$row_sub['bidx']?>" >
		<img src="/data/product/<?=$row_sub["ufile1"]?>" alt="<?=$row_sub['goods_name_front']?>">
		<ul rel="<?=$row_sub["goods_code"]?>" bidx="<?=$row_sub['bidx']?>" >
			<li><strong>상품명 : </strong> <span><?=$row_sub['goods_name_front']?></span></li>
			<li>
				<strong>색상 : </strong> 
				<select name="option1[<?=$row_sub['bidx']?>]" class="option1">
					<option value="">색상</option>

					<?
					$_product_color_arr = explode("||", getCodeSlice($product_color) );

					if($product_color){
						foreach($_product_color_arr as $_tmp_color){
							$fsql    = "select * from tbl_color where code_no='".$_tmp_color."' limit 1 ";
							$fresult = mysqli_query($connect, $fsql) or die (mysql_error());
							$frow = mysqli_fetch_array($fresult);

					?>
						<option value="<?=$_tmp_color?>" ><?=$frow['code_name']?></option>
					<?
						}
					}
					?>

				</select>
			</li>
			<li>
				<strong>사이즈 : </strong> 
				<select name="option2[<?=$row_sub['bidx']?>]" id="option2" class="option2"  disabled="true">
					<option value="">사이즈</option>
					
				</select>
			</li>
		</ul>
	</div>
<?	

}


?>