<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";


	$product_option		=  $_GET["product_option"];
	$goods_code		=  $_GET["goods_code"];

	$_product_option_arr = explode("||", getCodeSlice($product_option) );

	$goods_cnt_sum = 0;
	$price_normal_sum = 0;
	$price_margin = 0;
	$price_one = 0;

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


			$fsql3    = "select price_normal, price_margin, price_one, sum(goods_cnt) as goods_cnt from tbl_goods_adm_option where goods_code='".$goods_code."' AND goods_color = '".$_tmp_color."' AND goods_size = '".$_tmp_size."'   ";
			

			$fresult3 = mysqli_query($connect, $fsql3) or die (mysql_error());
			$frow3 = mysqli_fetch_array($fresult3);

			
			$goods_cnt = $frow3['goods_cnt'];
			$price_normal = $frow3['price_normal'];
			$price_margin = $frow3['price_margin'];
			$price_one = $frow3['price_one'];
	?>
		<tr>
			<td><?=$frow1["code_name"]?></td>
			<td><?=$frow2["code_name"]?></td>
			<td>
				<input type="hidden" name="hid_goods_cnt" id="hid_goods_cnt_<?=$frow3['idx']?>" value="<?=$frow3['goods_cnt']?>" />
				<div id="div_goods_cnt_<?=$frow3['idx']?>" ><?=$frow3['goods_cnt']?></div>
			</td>
			<td><input type="text" name="goods_cnt" id="goods_cnt_<?=$frow3['idx']?>" value="" class="input_txt" onkeydown="onlyNumber(this)" /></td>
			<td>
			<input type="text" name="price_normal" id="price_normal_<?=$frow3['idx']?>" class="input_txt" value="<?=number_format($frow3['price_normal'])?>" onkeyup="inputNumberFormat(this)" />
			</td>
			<td>
			<input type="text" name="price_margin" id="price_margin_<?=$frow3['idx']?>" class="input_txt" value="<?=number_format($frow3['price_margin'])?>" onkeyup="inputNumberFormat(this)" />
			</td>
			<td>
			<input type="text" name="price_one" id="price_one_<?=$frow3['idx']?>" class="input_txt" value="<?=number_format($frow3['price_one'])?>" onkeyup="inputNumberFormat(this)" />
			</td>
			<td><a href="javascript:fnGoodsCnt('<?=$frow3["idx"]?>')"><img src="/AdmMaster/_images/common/ico_setting2.png"></a></td>
		</tr>

	<?

		$goods_cnt_sum = $goods_cnt_sum + $goods_cnt;
		$price_normal_sum = $price_normal_sum + $price_normal;
		$price_margin_sum = $price_margin_sum + $price_margin;
		$price_one_sum = $price_one_sum + $price_one;
		}
	}
	?>


<input type="hidden" name="product_option" id="product_option" value="<?=$product_option?>" />
<input type="hidden" name="goods_code" id="goods_code" value="<?=$goods_code?>" />

<script>

	function fnGoodsCnt(idx){
		
		var g_cnt = Number($("#hid_goods_cnt_"+idx).val());
		var g_n_cnt = Number($("#goods_cnt_"+idx).val());
		var price_normal = uncomma($("#price_normal_"+idx).val());
		var price_margin= uncomma($("#price_margin_"+idx).val());
		var price_one= uncomma($("#price_one_"+idx).val());
		
		var goods_cnt = g_cnt + g_n_cnt;
		//if(g_n_cnt == 0){
		//	alert("추가할 재고를 입력해주세요.");	
		//	return false;
		//}
		
		var params = "idx="+idx+"&goods_cnt=" +goods_cnt;
			params +="&price_normal=" + price_normal;
			params +="&price_margin=" + price_margin;
			params +="&price_one=" + price_one;

		$.ajax({
			type: "POST",
			url: "./head_office_item_option_update.php",
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

	function fnOptionUpdate(){
		
		if(!confirm("재고를 등록하시겠습니까?")){
			return false;
		}

		var params = $("form[name=frmOption]").serialize() ;

		$.ajax({
			type: "POST",
			url: "./item_option_update.php",
			data: params,
			cache: false,
			success: function (rData) {

				if(rData == "ok"){
					//alert("등록되었습니다.");
				}else{
					alert("등록 오류입니다. 다시 시도해주세요..");	
					location.reload();
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




//콤마찍기
function comma(str) {
    str = String(str);
    return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
}
 
//콤마풀기
function uncomma(str) {
    str = String(str);
    return str.replace(/[^\d]+/g, '');
}
 
//값 입력시 콤마찍기
function inputNumberFormat(obj) {
    obj.value = comma(uncomma(obj.value));
}
</script>


<script>
	$("#item_total_sum").html("합계 ( <?=$goods_cnt_sum?> )");
	$("#price_normal_sum").html("합계 ( <?=number_format($price_normal_sum)?> 원)");
	$("#price_margin").html("합계 ( <?=number_format($price_margin_sum)?>원 )");
	$("#price_one").html("합계 ( <?=number_format($price_one_sum)?> 원)");
</script>
