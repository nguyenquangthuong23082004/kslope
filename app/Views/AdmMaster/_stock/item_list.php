<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";

	$g_list_rows		= 20;
	$pg					= updateSQ($_GET["pg"]);
	$product_group		= updateSQ($_GET["product_group"]);
	$search_keyword		= updateSQ($_GET["search_keyword"]);


	if ($product_group != "")
	{
		$strSql = $strSql." and product_group like '".$product_group."%' ";
	}


	if ($search_keyword != "")
	{
		$strSql = $strSql." and (goods_code like '%".$search_keyword."%' OR goods_name_front like '%".$search_keyword."%' ) ";
	}


	$total_sql = " select * from tbl_goods where item_state != 'dele' $strSql ";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error($connect));
	$nTotalCount = mysqli_num_rows($result);



	$nPage = ceil($nTotalCount / $g_list_rows);
	if ($pg == "") $pg = 1;
	$nFrom = ($pg - 1) * $g_list_rows;
	
	$sql    = $total_sql . " order by g_idx desc limit $nFrom, $g_list_rows ";
	$result = mysqli_query($connect, $sql) or die (mysql_error($connect));
	$num = $nTotalCount - $nFrom;

	
		if ($nTotalCount == 0) {
	?>
		<tr>
			<td colspan=2 style="text-align:center;height:50px">검색된 결과가 없습니다.</td>
		</tr>
	<?
		}
	?>

		<?
			$num = 1;
			while($row = mysqli_fetch_array($result)){
		?>
			<tr>
				<td id="td_item_<?=$row["g_idx"]?>" >
					<p class="categore"><?=$row['goods_name_front']?></p>
					<p class="categore"><?=$row['goods_code']?></p>
					<p class="product_view"><a href="/AdmMaster/_goods/write.php?g_idx=<?=$row['g_idx']?>">[<span>상품정보</span>]</a></p>
				</td>
				<td class="images">
				<?if($row["ufile1"]){?>
					<img src="/data/product/<?=$row["ufile1"]?>" alt="<?=$row["goods_code"]?>" onclick="fncItemClick('<?=$row['g_idx']?>', '<?=$row['product_option']?>','<?=$row["goods_code"]?>');" style="cursor:pointer;" />
				<?}?>				
				
				
				</td>
			</tr>

	<?  
			if($num == 1){
				$g_idx_ = $row['g_idx'];
				$product_option_ = $row['product_option'];
				$goods_code_ = $row['goods_code'];
			}

			$num = $num + 1;
		} 
	?>

<input type="hidden" name="hid_Item_nTotalCount" id="hid_Item_nTotalCount" value="<?=$nTotalCount?>">
<input type="hidden" name="hid_Item_nPageSize" id="hid_Item_nPageSize" value="<?=$g_list_rows?>">

<script>
	function fncItemClick(g_idx, product_opt, goods_code){

		$("td[id^=td_item_]").removeClass("active");
		$("td[id=td_item_"+g_idx+"]").addClass("active");
		
		var params = "product_option="+product_opt;
			params += "&goods_code="+goods_code;
		
		$.ajax({
			type: "GET",
			url: "./item_option_list.php",
			data: params,
			cache: false,
			success: function (sHtml) {
				$("#ITEM_OPTION_LIST").html(sHtml); 
			}
			, beforeSend: function () {
				// 로딩중....      
			}
			, complete: function () {                    
				// 로딩 완료시 
				//대리점 리스트 
				$("#selectMarket").val("");
				fncMarketList(product_opt, goods_code, "");
			}
		});

	}
	
	
	function fncMarketList(product_opt, goods_code, m_idx){
		
		var params = "goods_code="+goods_code;
			params += "&product_option="+product_opt;
			params += "&m_idx="+m_idx;

		$.ajax({
			type: "GET",
			url: "./market_list.php",
			data: params,
			cache: false,
			success: function (sHtml) {
			
				$("#MARKET_LIST").html(sHtml); 
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
	fncItemClick("<?=$g_idx_?>","<?=$product_option_?>","<?=$goods_code_?>");
</script>