<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";


	$product_option		=  $_GET["product_option"];
	$goods_code		=  $_GET["goods_code"];

	$_product_option_arr = explode("||", getCodeSlice($product_option) );

	$num_sum = 0;

	if($product_option){
		foreach($_product_option_arr as $_tmp_options){

			$_tmp_size_ar = explode(":",$_tmp_options);

			$_tmp_color = $_tmp_size_ar[0];
			$_tmp_size = $_tmp_size_ar[1];

			// 색상 조회
			$fsql1    = "select * from tbl_color where code_no='".$_tmp_color."' limit 1 ";

			$fresult1 = mysqli_query($connect, $fsql1) or die (mysql_error());
			$frow1 = mysqli_fetch_array($fresult1);
			
	
			// 사이즈 조회
			$fsql2    = "select * from tbl_size where code_no='".$_tmp_size."' limit 1 ";
			$fresult2 = mysqli_query($connect, $fsql2) or die (mysql_error());
			$frow2 = mysqli_fetch_array($fresult2);

			// 옵션 조회
			$fsql3    = "select * from tbl_goods_option where goods_code='".$goods_code."' AND goods_color = '".$_tmp_color."' AND goods_size = '".$_tmp_size."'  limit 1 ";

			//$fresult3 = mysqli_query($connect, $fsql3) or die (mysql_error());
			//$frow3 = mysqli_fetch_array($fresult3);


			$fsql3    = "select sum(goods_cnt) goods_cnt from tbl_goods_adm_option where goods_code='".$goods_code."' 
								AND goods_color = '".$_tmp_color."' 
								AND goods_size = '".$_tmp_size."'  
								limit 1 ";
			
			//echo $fsql3."<br>";
			$fresult3 = mysqli_query($connect, $fsql3) or die (mysql_error());
			$frow3 = mysqli_fetch_array($fresult3);

			
			$num_ = $frow3['goods_cnt'];
	?>


		<tr>
			<td><?=$frow1["code_name"]?></td>
			<td><?=$frow2["code_name"]?></td>
			<td><input type="text" class="onlynum" name="option_cnt_<?=$_tmp_color?>_<?=$_tmp_size?>"  id="" value="<?=$frow3['goods_cnt']?>" onkeydown="onlyNumber(this)" />
			</td>
			<!-- <td>
				<a href="#n" onclick='fnOptionUpdate("<?=$_tmp_options?>","<?=$_tmp_size?>")' >
					<img src="/AdmMaster/_images/common/ico_setting2.png">
				</a>
			</td> -->
		</tr>



	<?
		$num_sum = $num_sum + $num_;
		}
	}
	?>


<input type="hidden" name="product_option" id="product_option" value="<?=$product_option?>" />
<input type="hidden" name="goods_code" id="goods_code" value="<?=$goods_code?>" />

<script>
	$("#item_total_sum").html("합계 ( <?=$num_sum?> )");
</script>