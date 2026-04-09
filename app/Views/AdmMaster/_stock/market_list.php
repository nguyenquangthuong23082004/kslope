<?
include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";


$goods_code	= updateSQ($_GET["goods_code"]);
$product_option	= updateSQ($_GET["product_option"]);
$m_idx	= updateSQ($_GET["m_idx"]);


if($m_idx != ""){
	$shere = " and m_idx=".$m_idx."";
}

//$sql = " select a.m_idx, a.shop_name, b.a_idx from tbl_market as a  inner join tbl_goods_agency as b on a.m_idx = b.m_idx where b.goods_code = '".$goods_code."' $shere ";

$sql = " select m_idx, shop_name from tbl_market where 1=1 $shere ";

$result = mysqli_query($connect, $sql) or die (mysql_error($connect));

	$num = 1;
	while($row = mysqli_fetch_array($result)){
?>		
		<tr>
			<td id="td_item_market_<?=$row["m_idx"]?>_<?=$goods_code?>" style="cursor:pointer;"  onclick="fncMarketClick('<?=$row["m_idx"]?>');" >
				<p class="categore"><?=$row["shop_name"]?></p>
			</td>
		</tr>
<?

	if($num == 1){
		$m_idx = $row['m_idx'];
	}

	$num = $num + 1;
	}
?>



<script>
	function fncMarketClick(m_idx){
		
		var product_option = $("#product_option").val();
		var goods_code = $("#goods_code").val();

		$("td[id^=td_item_market_]").removeClass("active");
		$("td[id=td_item_market_"+m_idx+"_"+goods_code+"]").addClass("active");
		

		if(m_idx ==""){
			$("#MARKET_OPTION_LIST").html("");
			return false;
		}
		var params = "m_idx="+m_idx;
			params += "&goods_code="+goods_code;
			params += "&product_market_option="+product_option;

		$.ajax({
			type: "GET",
			url: "./market_option_list.php",
			data: params,
			cache: false,
			success: function (sHtml) {
				$("#MARKET_OPTION_LIST").html(sHtml); 
			}
			, beforeSend: function () {
				// 로딩중....      
			}
			, complete: function () {                    
				// 로딩 완료시 
			}
		});	
	}

	//첫번째 행 선택 
	fncMarketClick("<?=$m_idx?>");
</script>