<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";


	$product_option		=  $_GET["product_option"];
	$goods_code		=  $_GET["goods_code"];
	$m_idx		=  $_GET["m_idx"];

	$goods_cnt_sum = 0;
	$_product_option_arr = explode("||", getCodeSlice($product_option) );
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


			// 옵션 조회
			$fsql3    = "select * from tbl_goods_agency_option where m_idx=".$m_idx." AND  goods_code='".$goods_code."' AND goods_color = '".$_tmp_color."' AND goods_size = '".$_tmp_size."'  limit 1 ";


			$fresult3 = mysqli_query($connect, $fsql3) or die (mysql_error());
			$frow3 = mysqli_fetch_array($fresult3);
			

			$goods_cnt = $frow3['goods_cnt'];
?>

		<tr>
				<td>
				<input type="hidden" name="hid_tmp_size" id="hid_tmp_size_<?=$frow3['idx']?>" value="<?=$_tmp_size?>" />
				<input type="hidden" name="hid_tmp_color" id="hid_tmp_color_<?=$frow3['idx']?>" value="<?=$_tmp_color?>" />
				<input type="hidden" name="hid_goods_cnt" id="hid_goods_cnt_<?=$frow3['idx']?>" value="<?=$frow3['goods_cnt']?>" />

				<?=$frow1["code_name"]?>
				
				</td>
				<td><?=$frow2["code_name"]?></td>
				<td>
				
				<div id="div_goods_cnt_<?=$frow3['idx']?>" ><?=$frow3['goods_cnt']?></div>
				</td>
				<!-- <td><input type="text" name="goods_cnt" id="goods_cnt_<?=$frow3['idx']?>" value="" class="input_txt" onkeydown="onlyNumber(this)" /></td>
				<td><a href="javascript:fnGoodsCnt('<?=$frow3["idx"]?>')"><img src="/AdmMaster/_images/common/ico_setting2.png"></a></td> -->
				<td>
					<select id="s_m_idx_<?=$frow3["idx"]?>" name="s_m_idx" class="input_select edit4" >
						<?
							$fsql    = "select m_idx, shop_name from tbl_market where status='Y' and m_idx <> $m_idx ";
							$fresult = mysqli_query($connect, $fsql) or die (mysql_error());
							while($frow=mysqli_fetch_array($fresult)){
							if($m_idx == $frow["m_idx"]){
								$sel = "selected";
							}else{
								$sel = "";
							}
						?>
						<option value="<?=$frow["m_idx"]?>" <?=$sel?> ><?=$frow["shop_name"]?> <?=$status_txt?></option>
						<? } ?>
					</select>	
				</td>
				<td><input type="text" name="goods_out_cnt" id="goods_out_cnt_<?=$frow3['idx']?>" value="" class="input_txt" onkeydown="onlyNumber(this)" /></td>
				<td><a href="javascript:fnGoodsOutCnt('<?=$frow3["idx"]?>')"><img src="/AdmMaster/_images/common/ico_setting2.png"></a></td>
				
			</tr>


<?
		$goods_cnt_sum = $goods_cnt_sum + $goods_cnt;
	}
}
?>

<input type="hidden" name="product_market_option" id="product_market_option" value="<?=$product_market_option?>" />
<input type="hidden" name="goods_market_code" id="goods_market_code" value="<?=$goods_code?>" />
<input type="hidden" name="m_idx" id="m_idx" value="<?=$m_idx?>" />

<script>


	function fnGoodsCnt(idx){
		
		var g_cnt = Number($("#hid_goods_cnt_"+idx).val());
		var g_n_cnt = Number($("#goods_cnt_"+idx).val());
		var goods_cnt = g_cnt + g_n_cnt;
		//if(g_n_cnt == 0){
		//	alert("추가할 재고를 입력해주세요.");	
		//	return false;
		//}
		
		var params = "idx="+idx+"&goods_cnt=" +goods_cnt;
		
		$.ajax({
			type: "POST",
			url: "./agency_option_count_update.php",
			data: params,
			cache: false,
			success: function (rData) {
	
				if(rData == "ok"){
					alert("등록되었습니다.");	
					$("#goods_cnt_" +idx).val("");
					$("#hid_goods_cnt_" +idx).val(goods_cnt);
					$("#div_goods_cnt_" +idx).html(goods_cnt);
				}
				                
			}
			, beforeSend: function () {
				// 로딩중....      
			}
			, complete: function () {                    
				// 로딩 완료시    
			}
		});
	}

	function fnGoodsOutCnt(idx){

		var m_idx_1 = "<?=$m_idx?>";
		var m_idx_2 = Number($("#s_m_idx_"+idx).val());
		var g_cnt = Number($("#hid_goods_cnt_"+idx).val());
		var out_cnt = Number($("#goods_out_cnt_"+idx).val());
	
		var tmp_size = Number($("#hid_tmp_size_"+idx).val());
		var tmp_color = Number($("#hid_tmp_color_"+idx).val());



		if(g_cnt < out_cnt){
			alert("현재 재고 수량보다 많습니다.");	
			return false;
		}
		
		var goods_cnt = g_cnt - out_cnt;

		//if(g_n_cnt == 0){
		//	alert("추가할 재고를 입력해주세요.");	
		//	return false;
		//}
		
		var params = "idx="+idx;
		params += "&m_idx_1="+m_idx_1;
		params += "&m_idx_2="+m_idx_2;
		params += "&g_cnt="+g_cnt;
		params += "&out_cnt="+out_cnt;
		params += "&goods_cnt="+goods_cnt;
		params += "&goods_code=<?=$goods_code?>";
		params += "&tmp_size="+tmp_size;
		params += "&tmp_color="+tmp_color;

		$.ajax({
			type: "POST",
			url: "./agency_option_count_other_update.php",
			data: params,
			cache: false,
			success: function (rData) {
				
				if(rData == "ok"){
					alert("등록되었습니다.");	
					$("#goods_out_cnt_" +idx).val("");
					$("#hid_goods_cnt_" +idx).val(goods_cnt);
					$("#div_goods_cnt_" +idx).html(goods_cnt);
				}else if(rData == "-1"){
					alert("해당 대리점에 돌일 상품이 등록되어있지 않습니다.");
				}
				                
			}
			, beforeSend: function () {
				// 로딩중....      
			}
			, complete: function () {                    
				// 로딩 완료시    
			}
		});	
	}

</script>


<script>
	$("#item_total_sum").html("합계 ( <?=$goods_cnt_sum?> )");
</script>
