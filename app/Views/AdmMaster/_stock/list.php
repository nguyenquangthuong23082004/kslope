<? include "../_include/_header.php"; ?>

<script type="text/javascript" src="./list.js"></script>


		<div id="container">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer" >
				
				<div class="inner">
					<h2>재고관리</h2>
				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents">
						
					<header id="headerContents" class="edit1">
						<div class="srock_select fl">

							<a href="javascript:fnOptionUpdate();" class="btn btn-primary fr" style="margin-right:10px;"><span class="txt">재고등록</span></a>
							<div style="float:right;margin-right:30px;">
								<select id="product_group_1" name="product_group_1" class="input_select edit4" onchange="javascript:get_group(this.value, 2)">
									<option value="">1차분류</option>
									<?
										$fsql    = "select * from tbl_group where depth='1' and status='Y' order by onum desc, code_idx desc";
										$fresult = mysqli_query($connect, $fsql) or die (mysql_error());
										while($frow=mysqli_fetch_array($fresult)){
											$status_txt = "";
											if ($frow["status"] == "Y")
											{
												$status_txt = "";
											} elseif ($frow["status"] == "N") {
												$status_txt = "[삭제]";
											} elseif ($frow["status"] == "C") {
												$status_txt = "[마감]";
											}

									?>
									<option value="<?=$frow["code_no"]?>" ><?=$frow["code_name"]?> <?=$status_txt?></option>
									<? } ?>
								</select>

								<select id="product_group_2" name="product_group_2" class="input_select edit5" onchange="javascript:get_group(this.value, 3)" >
									<option value="">2차분류</option>
								</select>
								<select id="product_group_3" name="product_group_3" class="input_select edit5" onchange="javascript:get_group(this.value, 4)" >
									<option value="">3차분류</option>
								</select>
								<select id="product_group_4" name="product_group_4" class="input_select edit5" onchange="javascript:get_group(this.value, 5)">
									<option value="">4차분류</option>
								</select>
							</div>
							<div style="float:left;margin-left:30px;">
								<input type="text" id="search_keyword" name="search_keyword" value=""  class="input_txt placeHolder" placeholder="상품 검색"/>

								<a href="javascript:fncSerchKeyword()" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> <span class="txt" >검색하기</span></a>
							</div>
						</div>
						
						<div class="srock_select fr">
							<select id="selectMarket" name="selectMarket" class="input_select edit4 fl" onchange="javascript:fncMarketSelectClick(this.value)">
								<option value="">대리점 검색</option>
								<?
									$fsql    = "select m_idx, shop_name from tbl_market where status='Y'";
									$fresult = mysqli_query($connect, $fsql) or die (mysql_error());
									while($frow=mysqli_fetch_array($fresult)){
								?>
								<option value="<?=$frow["m_idx"]?>" ><?=$frow["shop_name"]?> <?=$status_txt?></option>
								<? } ?>
							</select>
							
							<a href="javascript:fnMarketOptionUpdateChk();" class="btn btn-primary fr"><span class="txt">재고등록</span></a>
							
						</div>
						
					</header><!-- // headerContents -->
				

				<div class="listWrap edit2">
					<!-- 안내 문구 필요시 구성 //-->

					<div class="srock_list fl">
						<div class="fl">
										
								<div class="listBottom">
									<table cellpadding="0" cellspacing="0" summary="" class="listTable">
										<caption>브랜드 상품, 이미지 제목</caption>
										<colgroup>
											<col width="121px" />
											<col width="*" />
											<col width="17px" />
										</colgroup>
										<thead>
											<tr>
												<th>제품코드</th>
												<th>이미지</th>
												<th></th>
											</tr>
										</thead>	
									</table>
									<div class="table_overflow" id="item_1_scroll">
										<table cellpadding="0" cellspacing="0" summary="" class="listTable">
											<caption>브랜드 상품, 이미지 내용</caption>
											<colgroup>
												<col width="42.5%" />
												<col width="*" />
											</colgroup>
											<tbody id="ITEM_LIST">
												<!-- ######### 전체 상품 출력 ######### -->
											</tbody>
										</table>
									</div>
								</div><!-- // listBottom -->
						
						</div>
						<div class="fr">
							<form name="frmOption" id="frmOption" method="post" >		
								<input type="hidden" name="item_m_idx" id="item_m_idx" >
								<div class="listBottom">
									<table cellpadding="0" cellspacing="0" summary="" class="listTable">
										<caption>색상 및 사이즈별 재고 제목 내용</caption>
										<colgroup>
											<col width="197px" />
											<col width="136px" />
											<col width="*" />
											<!-- <col width="40px" /> -->
											<col width="17px" />
										</colgroup>
										<thead>
											<tr>
												<th>컬러명</th>
												<th>사이즈명</th>
												<th>재고</th>
												<!-- <th>관리</th>	 -->
												<th></th>	
											</tr>
										</thead>	
									</table>
									<div class="table_overflow" >
										<div style="min-height:500px;">
											<table cellpadding="0" cellspacing="0" summary="" class="listTable">
												<caption>색상 및 사이즈별 재고</caption>
												<colgroup>
													<col width="197px" />
													<col width="136px" />
													<col width="*" />
													<col width="17px" />
													
												</colgroup>
												<tbody id="ITEM_OPTION_LIST">																				
												</tbody>
											</table>
										</div>
									</div>
								</div><!-- // listBottom -->
								<div>
									<table cellpadding="0" cellspacing="0" summary="" class="listTable resulteTable">
										<caption>합계</caption>
										<colgroup>
											<col width="28.8%" />
											<col width="19.9%" />
											<col width="*" />
											<col width="17px" />
														
										</colgroup>
										<tbody id="">
										<tr style="text-align:center;">
											<td></td>
											<td></td>
											<td><div id="item_total_sum"></div></td>
											<td></td>
										</tr>
												
									</tbody>
									</table>
								</div>
						</div>
					</div>

					<div class="srock_list fr">
						<div class="fl">
							<form name="" id="">				
								<div class="listBottom">
									<table cellpadding="0" cellspacing="0" summary="" class="listTable">
										<caption>대리점명</caption>
										<colgroup>
											<col width="*" />
											<col width="20px" />
										</colgroup>
										<thead>
											<tr>
												<th>대리점</th>
												
											</tr>
										</thead>	
									</table>
									<div class="table_overflow">
										
										<table cellpadding="0" cellspacing="0" summary="" class="listTable">
											<caption>대리점명</caption>
											<colgroup>
												<col width="100%" />
											</colgroup>
											<thead>
											<tbody id="MARKET_LIST" >

											</tbody>
										</table>
										
									</div>
								</div><!-- // listBottom -->
							</form>
						</div>
						<div class="fr">
							<form name="frmMarketOption" id="frmMarketOption" method="post" >	
								<div class="listBottom">
									<table cellpadding="0" cellspacing="0" summary="" class="listTable">
										<caption>색상 및 사이즈별 재고</caption>
										<colgroup>
											<col width="141px" />
											<col width="112px" />
											<col width="226px" />
											<col width="*" />
											<col width="17px" />
										</colgroup>
										<thead>
											<tr>
												<th>컬러명</th>
												<th>사이즈명</th>
												<th>재고</th>
												<th>관리</th>
												<th></th>
											</tr>
										</thead>	
									</table>
									<div class="table_overflow">
										<div style="min-height:500px;">
											<table cellpadding="0" cellspacing="0" summary="" class="listTable">
												<caption>색상 및 사이즈별 재고</caption>
												<colgroup>
													<col width="141px" />
													<col width="112px" />
													<col width="226px" />
													<col width="*" />
													<col width="17px" />
												</colgroup>
												<tbody id="MARKET_OPTION_LIST">
		
												</tbody>
											</table>
										</div>
										
									</div>
								</div><!-- // listBottom -->
							</form>
						</div>
						<div>
							<table cellpadding="0" cellspacing="0" summary="" class="listTable resulteTable">
								<caption>합계</caption>
									<colgroup>
										<col width="25.5%" />
										<col width="20.5%" />
										<col width="14.8%" />
										<col width="29%" />
										<col width="*" />
										<col width="17px" />
			
									</colgroup>
									<tbody id="">
										<tr style="text-align:center;">
											<td></td>
											<td></td>
											<td></td>
											<td><div id="item_market_total_sum"></div></td>
											<td></td>
											<td></td>
										</tr>
												
									</tbody>
							</table>
						</div>
					</div>

				</div><!-- // listWrap -->

			</div><!-- // contents -->
		</span><!-- 인쇄 영역 끝 //-->
		</div><!-- // container -->



<input type="hidden" name="hidItmPage" id="hidItmPage" value="1">
<input type="hidden" name="hidDepthe" id="hidDepthe" value="">

<script>

	function fncMarketSelectClick(m_idx){
		var product_option =  $("#product_option").val();
		var goods_code =  $("#goods_code").val();
		fncMarketList(product_option, goods_code, m_idx);
	}

//#########################################################
 function CheckAll(checkBoxes,checked){
    var i;
    if(checkBoxes.length){
        for(i=0;i<checkBoxes.length;i++){
            checkBoxes[i].checked=checked;
        }
    }else{
        checkBoxes.checked=checked;
   }

}

function SELECT_DELETE() {
		if ($(".product_idx").is(":checked") == false)
		{
			alert_("삭제할 내용을 선택하셔야 합니다.");
			return;
		}
		if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false)
		{
			return;
		}

		$("#ajax_loader").removeClass("display-none");

        $.ajax({
			url: "del.php",
			type: "POST",
			data: $("#frm").serialize(),
			error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				$("#ajax_loader").addClass("display-none");
			}
			,complete: function(request, status, error) {
//				$("#ajax_loader").addClass("display-none");
			}
			, success : function(response, status, request) {
				if (response == "OK")
				{
					alert_("정상적으로 삭제되었습니다.");
						location.reload();
					return;
				} else {
					alert(response);
					alert_("오류가 발생하였습니다!!");
					return;
				}
			}
        });
 
}

function del_it(product_idx) {

		if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false)
		{
			return;
		}
		$("#ajax_loader").removeClass("display-none");
        $.ajax({
			url: "del.php",
			type: "POST",
			data: "product_idx[]="+product_idx,
			error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				$("#ajax_loader").addClass("display-none");
			}
			,complete: function(request, status, error) {
//				$("#ajax_loader").addClass("display-none");
			}
			, success : function(response, status, request) {
				if (response == "OK")
				{
					alert_("정상적으로 삭제되었습니다.");
					location.reload();
					return;
				} else {
					alert(response);
					alert_("오류가 발생하였습니다!!");
					return;
				}
			}
        });
 
}

		function get_code(strs, depth)
		{
				$.ajax({
					type:"GET"
					, url:"get_code.ajax.php"
					, dataType : "html" //전송받을 데이터의 타입
					, timeout : 30000 //제한시간 지정
					, cache : false  //true, false
					, data : "parent_code_no="+ encodeURI(strs) +"&depth="+depth //서버에 보낼 파라메터
					,error : function(request, status, error) {
					 //통신 에러 발생시 처리
						alert("code : " + request.status + "\r\nmessage : " + request.reponseText);
					}
					, success:function(json){
						//alert(json);
						if (depth <= 3)
						{
							$("#product_code_2").find('option').each(function() {
								$(this).remove();
							});
							$("#product_code_2").append("<option value=''>2차분류</option>");
						}
						if (depth <= 4)
						{
							$("#product_code_3").find('option').each(function() {
								$(this).remove();
							});
							$("#product_code_3").append("<option value=''>3차분류</option>");
						}
						if (depth <= 4)
						{
							$("#product_code_4").find('option').each(function() {
								$(this).remove();
							});
							$("#product_code_4").append("<option value=''>4차분류</option>");
						}
						var list = $.parseJSON(json);
						var listLen = list.length;
						var contentStr = "";
						for(var i=0; i<listLen; i++)
						{
							contentStr = "";
							if (list[i].code_status == "C")
							{
								contentStr = "[마감]";
							} else if (list[i].code_status == "N") {
								contentStr = "[사용안함]";
							}
							$("#product_code_"+(parseInt(depth)-1)).append("<option value='"+list[i].code_no+"'>"+list[i].code_name+""+contentStr+"</option>");
						}
					}
				});
		}
</script>


<? include "../_include/_footer.php"; ?>