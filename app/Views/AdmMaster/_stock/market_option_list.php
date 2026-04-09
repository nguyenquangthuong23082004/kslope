<?
include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";


$m_idx	= updateSQ($_GET["m_idx"]);
$goods_code	= updateSQ($_GET["goods_code"]);
$product_market_option	= updateSQ($_GET["product_market_option"]);



$_product_option_arr = explode("||", getCodeSlice($product_market_option) );


if($m_idx == ""){
	$m_idx = 0;
}

if($product_market_option){

	$i = 0;
	$num_sum = 0;
	foreach($_product_option_arr as $_tmp_market_options){
	
		$_tmp_size_market_ar = explode(":",$_tmp_market_options);

		$_tmp_market_color = $_tmp_size_market_ar[0];
		$_tmp_market_size = $_tmp_size_market_ar[1];

		// 색상 조회
		$fsql1    = "select * from tbl_color where code_no='".$_tmp_market_color."' limit 1 ";
		
		$fresult1 = mysqli_query($connect, $fsql1) or die (mysql_error());
		$frow1 = mysqli_fetch_array($fresult1);
		

		// 사이즈 조회
		$fsql2    = "select * from tbl_size where code_no='".$_tmp_market_size."' limit 1 ";
		$fresult2 = mysqli_query($connect, $fsql2) or die (mysql_error());
		$frow2 = mysqli_fetch_array($fresult2);

		// 옵션 조회
		$fsql3    = "select * from tbl_goods_agency_option where m_idx=".$m_idx." AND  goods_code='".$goods_code."' AND goods_color = '".$_tmp_market_color."' AND goods_size = '".$_tmp_market_size."'  limit 1 ";

		//echo $fsql3;
		//exit;
		$fresult3 = mysqli_query($connect, $fsql3) or die (mysql_error());
		$frow3 = mysqli_fetch_array($fresult3);

		$num_ = $frow3['goods_cnt'];
?>		
	<tr>
		<td><?=$frow1["code_name"]?></td>
		<td><?=$frow2["code_name"]?></td>
		<td><input type="text" class="onlynum" name="option_market_cnt[]"  id="" value="<?=$frow3['goods_cnt']?>" onkeydown="onlyNumber(this)" /></td>
		<td><a href="javascript:fnMarketOptionUpdateChk('<?=$i?>');"><img src="/AdmMaster/_images/common/ico_setting2.png"></a></td>
	</tr>


<?
		$i = $i + 1;
		$num_sum = $num_sum + $num_;
	}
}
?>

<input type="hidden" name="product_market_option" id="product_market_option" value="<?=$product_market_option?>" />
<input type="hidden" name="goods_market_code" id="goods_market_code" value="<?=$goods_code?>" />
<input type="hidden" name="m_idx" id="m_idx" value="<?=$m_idx?>" />



<script>
	

	function fnMarketOptionUpdateChk(){

		var params = $("form[name=frmMarketOption]").serialize() ;

		$.ajax({
			type: "POST",
			url: "./item_market_option_update_chk.php",
			data: params,
			cache: false,
			success: function (rData) {

				//alert(rData);
				
				if(rData == "-1"){
					alert("상품 재고 수량을 초과하였습니다. \n다시 등록해 주세요.");
					return false;
				}else if(rData == "1"){
					fnMarketOptionUpdate();
				}else{
					alert("등록중 오류가 발생되었습니다.");
					return false;
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

	function fnMarketOptionUpdate(){
		
		if(!confirm("대리점 재고를 등록하시겠습니까?")){
			return false;
		}

		var params = $("form[name=frmMarketOption]").serialize() ;

		$.ajax({
			type: "POST",
			url: "./item_market_option_update.php",
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

</script>


<script>
	$("#item_market_total_sum").html("합계 ( <?=$num_sum?> )");
</script>