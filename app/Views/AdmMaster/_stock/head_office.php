<? include "../_include/_header.php"; ?>


<script type="text/javascript" src="./head_office.js"></script>

		<div id="container">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer" >
				
				<div class="inner">
					<h2>본사 재고추가</h2>
				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents">
					
					<header id="headerContents" class="edit1">
						<div class="srock_select fl adm_f1">
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
								<input type="text" id="search_keyword" name="search_keyword" value="" class="input_txt placeHolder" placeholder="상품 검색"/>

								<a href="javascript:fncSerchKeyword()" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> <span class="txt" >검색하기</span></a>
							</div>
							
						</div>
						
					</header><!-- // headerContents -->
				

				<div class="listWrap edit2">
					<!-- 안내 문구 필요시 구성 //-->

					<div class="srock_list fl adm_f1">
						<div class="fl adm_f1">
							<form name="" id="">				
								<div class="listBottom">
									<table cellpadding="0" cellspacing="0" summary="" class="listTable">
										<caption>브랜드 상품, 이미지 제목</caption>
										<colgroup>
											<col width="118px" />
											<col width="*" />
											<col width="17px" />
										</colgroup>
										<thead>
											<tr>
												<th>상품명</th>
												<th>이미지</th>
												<th></th>
											</tr>
										</thead>	
									</table>
									<div class="table_overflow">
										<div class="table_overflow" id="item_1_scroll">
										<table cellpadding="0" cellspacing="0" summary="" class="listTable">
											<caption>브랜드 상품, 이미지 내용</caption>
											<colgroup>
												<col width="118px" />
												<col width="*" />
											</colgroup>
											<tbody id="ITEM_LIST">

											</tbody>
										</table>
										</div>
									</div>
								</div><!-- // listBottom -->
							</form>
						</div>
						<div class="fr">
							<form name="" id="">				
								<div class="listBottom">
									<table cellpadding="0" cellspacing="0" summary="" class="listTable">
										<caption>색상 및 사이즈별 재고 제목</caption>
										<colgroup>
											<col width="314px" />
											<col width="187px" />
											<col width="129px" />
											<col width="156px" />
											<col width="209px" />
											<col width="203px" />
											<col width="204px" />
											<col width="*" />
											<col width="17px" />
							
										</colgroup>
										<thead>
											<tr>
												<th>컬러명</th>
												<th>사이즈명</th>
												<th>현재재고</th>
												<th>추가할 재고</th>
												<th>정상가</th>
												<th>마진</th>
												<th>상품원가</th>
												<th>수정</th>
												<th></th>
											</tr>
										</thead>	
									</table>
									<div class="table_overflow">
										<div style="min-height:500px;">
										<table cellpadding="0" cellspacing="0" summary="" class="listTable">
											<caption>색상 및 사이즈별 재고 내용</caption>
											<colgroup>
												<col width="314px" />
												<col width="187px" />
												<col width="129px" />
												<col width="156px" />
												<col width="209px" />
												<col width="203px" />
												<col width="204px" />
												<col width="*" />
											</colgroup>
											<tbody id="ITEM_OPTION_LIST">

											</tbody>
										</table>
										</div>
									</div>
								</div><!-- // listBottom -->
							</form>
							<div>
								<table cellpadding="0" cellspacing="0" summary="" class="listTable resulteTable">
									<caption>합계</caption>
										<colgroup>
											<col width="314px" />
											<col width="187px" />
											<col width="129px" />
											<col width="156px" />
											<col width="209px" />
											<col width="203px" />
											<col width="204px" />
											<col width="*" />
											<col width="17px" />
				
										</colgroup>
										<tbody id="">
											<tr style="text-align:center;">
												<td></td>
												<td></td>
												<td><div id="item_total_sum"></div></td>
												<td></td>
												<td></td>
												<td><div id="price_normal_sum"></div></td>
												<td><div id="price_margin"></div></td>
												<td><div id="price_one"></div></td>
												<td></td>
												
											</tr>
													
										</tbody>
								</table>
							</div>
						</div>

					</div>
				</div><!-- // listWrap -->

			</div><!-- // contents -->
		</span><!-- 인쇄 영역 끝 //-->
		</div><!-- // container -->




<input type="hidden" name="hidItmPage" id="hidItmPage" value="1">
<input type="hidden" name="hidDepthe" id="hidDepthe" value="">

<script>
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