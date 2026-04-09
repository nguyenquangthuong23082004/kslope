<? include "../_include/_header.php"; ?>
<?

	$g_list_rows		= 10;
	$pg					= updateSQ($_GET["pg"]);
	$search_name		= updateSQ($_GET["search_name"]);
	$search_category	= updateSQ($_GET["search_category"]);
	$s_product_code_1	= updateSQ($_GET["s_product_code_1"]);
	$s_product_code_2	= updateSQ($_GET["s_product_code_2"]);
	$s_product_code_3	= updateSQ($_GET["s_product_code_3"]);

	if ($search_name)
	{
		$strSql = $strSql." and replace(".$search_category.",'-','') like '%".str_replace("-","",$search_name)."%' ";
	}
	if ($s_product_code_1)
	{
		$strSql = $strSql." and product_code_1 = '".$s_product_code_1."' ";
	}
	if ($s_product_code_2)
	{
		$strSql = $strSql." and product_code_2 = '".$s_product_code_2."' ";
	}
	if ($s_product_code_3)
	{
		$strSql = $strSql." and product_code_3 = '".$s_product_code_3."' ";
	}
	
	
?>
		<div id="container">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>상품정보 리스트</h2>
					<div class="menus">
						<ul class="first">
						</ul>

						<ul class="last">
							<li><a href="write.php" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span class="txt">상품 등록</span></a></li>
						</ul>
						
					</div>

				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents">
				<form name="search" id="search">		
				<header id="headerContents">
						<select id="product_code_1" name="s_product_code_1" class="input_select" onchange="javascript:document.search.submit();" style="display:none">
							<option value="">1차분류</option>
							<?
								$fsql    = "select * from tbl_code where depth='1' order by onum desc, code_idx desc";
								$fresult = mysqli_query($connect, $fsql) or die (mysql_error($connect));
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
							<option value="<?=$frow["code_no"]?>" <? if ($s_product_code_1 == $frow["code_no"]) {echo "selected"; } ?>><?=$frow["code_name"]?> <?=$status_txt?></option>
							<? } ?>
							
						</select> 
						<select id="product_code_2" name="s_product_code_2" class="input_select" onchange="javascript:document.search.submit();" style="display:none">
							<option value="">2차분류</option>
							<?
								$fsql    = "select * from tbl_code where depth='2' and parent_code_no='".$s_product_code_1."' order by onum desc, code_idx desc";
								$fresult = mysqli_query($connect, $fsql) or die (mysql_error($connect));
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
							<option value="<?=$frow["code_no"]?>" <? if ($s_product_code_2 == $frow["code_no"]) {echo "selected"; } ?>><?=$frow["code_name"]?> <?=$status_txt?></option>
							<? } ?>
						</select> 
						
									
						<select id="" name="search_category" class="input_select" style="width:112px">
							<option value="product_name" <? if ($search_category == "product_name") {echo "selected"; } ?>>상품명</option>
							<option value="product_air" <? if ($search_category == "product_air") {echo "selected"; } ?>>이용항공</option>
							<option value="product_manager" <? if ($search_category == "product_manager") {echo "selected"; } ?>>담당자</option>
							<option value="product_code_name_4" <? if ($search_category == "product_code_name_4") {echo "selected"; } ?>>코스명</option>
							<option value="product_code_name_1" <? if ($search_category == "product_code_name_1") {echo "selected"; } ?>>여행분류</option>
							<option value="product_code_name_2" <? if ($search_category == "product_code_name_2") {echo "selected"; } ?>>지역분류</option>
							<option value="product_code" <? if ($search_category == "product_code") {echo "selected"; } ?>>코드검색</option>
						</select>


						<input type="text" id="" name="search_name" value="<?=$search_name?>" class="input_txt placeHolder" placeholder="검색어 입력" style="width:240px" />

						<a href="javascript:search_it()" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> <span class="txt">검색하기</span></a>
						</header><!-- // headerContents -->
				</form>
				<script>
				function search_it()
				{
					var frm = document.search;
					if (frm.search_name.value == "검색어 입력")
					{
						frm.search_name.value = "";
					}
					frm.submit();
				}
				</script>

				<div class="listWrap">
					<!-- 안내 문구 필요시 구성 //-->

				
				
		

					
					<div class="listTop">
						<div class="left">
							<p class="schTxt">■ 총 <?=$nTotalCount?>개의 목록이 있습니다.</p>
						</div>

					</div><!-- // listTop -->
					
					
					



					<form name="frm" id="frm">				
					<div class="listBottom">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable">
						<caption></caption>
						<colgroup>
						<col width="100px" />
						<col width="250px" />
						<col width="10%" />						
						<col width="*" />
						<col width="100px" />
						<col width="200px" />
						</colgroup>
						<thead>
							<tr>
								<th>번호</th>
								<th>카테고리</th>
								<th>썸네일이미지</th>
								<th>타이틀</th>
								<th>사용유무</th>
								<th>등록일</th>
							</tr>
						</thead>	
						<tbody>
							<?
								$nPage = ceil($nTotalCount / $g_list_rows);
								if ($pg == "") $pg = 1;
								$nFrom = ($pg - 1) * $g_list_rows;

								$sql    = $total_sql . " order by idx desc limit $nFrom, $g_list_rows ";
								$result = mysqli_query($connect, $sql) or die (mysql_error($connect));
								$num = $nTotalCount - $nFrom;
								if ($nTotalCount == 0) {
							?>
							<tr>
								<td colspan=10 style="text-align:center;height:100px">검색된 결과가 없습니다.</td>
							</tr>
							<?
								}
								while($row=mysqli_fetch_array($result)){

							?>
							<tr style="height:50px">
								<td rowspan="2"><?=$num--?></td>
								<td rowspan="2" class="tac">
									<a href="write.php?s_product_code_1=<?=$s_product_code_1?>&s_product_code_2=<?=$s_product_code_2?>&s_product_code_2=<?=$s_product_code_3?>&search_category=<?=$search_category?>&search_name=<?=$search_name?>&pg=<?=$pg?>&idx=<?=$row["idx"]?>"><?=$row["product_code_name_1"]?> / <?=$row["product_code_name_2"]?></a>
								</td>
								
								<td class="tac">
									<? if ($row["ufile1"] != "") { ?>
									<a href="/data/product/<?=$row["ufile1"]?>" class="imgpop"><img src="/data/product/<?=$row["ufile1"]?>" style="max-width:150px;max-height:100px"></a>
									<? } ?>
								</td>
								<td class="tal" style="font-weight:bold">
									<a href="write.php?s_product_code_1=<?=$s_product_code_1?>&s_product_code_2=<?=$s_product_code_2?>&s_product_code_2=<?=$s_product_code_3?>&search_category=<?=$search_category?>&search_name=<?=$search_name?>&pg=<?=$pg?>&idx=<?=$row["idx"]?>">
									<?=$row["goods_name_ko"]?> / <?=$row["goods_name_en"]?>
									</a>

								</td>
								
								<td class="tac">
									<? 
									if ($row["useYN"] == "Y") {
										echo "<font color='blue'>사용</font>";
									} elseif ($row["useYN"] == "N") {
										echo "<font color='red'>사용안함</font>";
									}
									?>
									
								</td>
								
								<td>
									<?=$row["regdate"]?>
								</td>
							</tr>
							<tr style="height:45px">
								<th style="background:#fafafa;border:1px solid #dddddd;padding:10px 0;font-size:14px;font-weight:bold;color:#464646;text-align:center;">
									한줄설명
								</th>
								<td colspan="3" style="background:#fafafa;;text-align:left;padding-left:15px;font-weight:bold">
									<?=$row["oneinfo_ko"]?>
								</td>
							</tr>
							<?  } ?>




							
						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

					<?echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF]."?s_product_code_1=".$s_product_code_1."&s_product_code_2=".$s_product_code_2."&s_product_code_2=".$s_product_code_3."&search_category=".$search_category."&search_name=".$search_name."&pg=")?>


					<div id="headerContainer">
						
						<div class="inner">
							<div class="menus">
								<ul class="first">
								</ul>

								<ul class="last">
									<li><a href="write.php" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span class="txt">상품 등록</span></a></li>
								</ul>
								
							</div>

						</div><!-- // inner -->

					</div><!-- // headerContainer -->
				</div><!-- // listWrap -->

			</div><!-- // contents -->





		</span><!-- 인쇄 영역 끝 //-->
		</div><!-- // container -->





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