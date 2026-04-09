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
		$strSql = $strSql." and product_code like '|".$s_product_code_1."%' ";
	}
	if ($s_product_code_2)
	{
		$strSql = $strSql." and goods_brand = '".$s_product_code_2."' ";
	}

	$sql_r_t		= " 
						select s.idx as r_idx, s.star, s.g_option, s.contents, s.displays, s.user_id, s.regdate as r_regdate, g.*  
						  from tbl_review s 
						  left outer join tbl_goods g on s.g_idx = g.g_idx 
						  left outer join tbl_goods_option go on s.g_option = go.idx 
						 where 1=1 
					  ";

					  // and s.displays = '' 

	$result_r_t		= mysqli_query($connect, $sql_r_t) or die (mysqli_error($connect));
	$nTotalCount = mysqli_num_rows($result_r_t);
	
?>
		<div id="container" class="gnb_goods">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>상품후기</h2>
					<div class="menus">
						<ul class="first">
							
						</ul>

						<ul class="last">
							<li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), true)" class="btn btn-success">전체선택</a></li>
							<li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), false)" class="btn btn-success">선택해체</a></li>
							<li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li>
						</ul>
						
					</div>

				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents">
				
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
						<table cellpadding="0" cellspacing="0" summary="" class="listTable" style="table-layout:fixed;">
						<caption></caption>
						<colgroup>
						<col width="4%" />
						<col width="9%" />
						<col width="10%" />
						<col width="17%" />
						<col width="7%" />
						<col width="*" />
						<col width="10%" />
						<col width="8%" />
						<col width="12%" />
						</colgroup>
						<thead>
							<tr>
								<th>선택</th>
								<th>제품코드</th>
								<th>이미지</th>
								<th>상품정보</th>
								<th>평가</th>
								<th>내용</th>
								<th>아이디</th>
								<th>상태</th>
								<th>등록일시</th>
							</tr>
						</thead>	
						<tbody>
							<?
								
								$nPage = ceil($nTotalCount / $g_list_rows);
								if ($pg == "") $pg = 1;
								$nFrom = ($pg - 1) * $g_list_rows;
								
								$sql    = $sql_r_t . " order by r_idx desc limit $nFrom, $g_list_rows ";
								$result = mysqli_query($connect, $sql) or die (mysqli_error($connect));
								$num = $nTotalCount - $nFrom;
								
								
								if ($nTotalCount == 0) {
							?>
								<tr>
									<td colspan=9 style="text-align:center;height:100px">검색된 결과가 없습니다.</td>
								</tr>
							<?
								}
							?>
							







							<?
								while($row = mysqli_fetch_array($result)){

								
									$goods_name = $row['goods_name'];
									if($goods_name == ""){
										$goods_name = "기본";
									}

							?>

								<tr>
									<td><input type="checkbox" name="idx[]" class="idx" value="<?=$row['r_idx']?>"  /></td>
									
									<td>
										<p class="categore"><?=$row['goods_code']?></p>
										<p class="product_view"><a href="/item/item_view.php?gcode=<?=$row['g_idx']?>" target="_blank">[<span>상품상세</span>]</a></p>
									</td>
									<td class="images">
										<?if($row["ufile1"]){?>
										<img src="/data/product/<?=$row["ufile1"]?>" alt="제품 이미지">
										<?}?>
									</td>
									<td class="product_name">
										<p><strong>상품명</strong> : <span><?=$row['goods_name_front']?></span></p>
										<ul class="item_option ver2">
											<li><strong>옵션</strong> : <span  class="it_color"><?=$goods_name?></span></li>
										</ul>
										
									</td>
									<td class="price">
										<p><strong><?for($i=1; $i<=$row['star']; $i++){?>★<?}?></strong></p>
										
									</td>
									<td class="product_name" ><?=nl2br($row['contents'])?></td>
									<td><?=$row['user_id']?></td>
									<td>
										<select onchange="fn_chg_stat('<?=$row['r_idx']?>',this.value)">
											<option value="Y" <?if($row['displays'] == "Y")echo"selected";?> >노출</option>
											<option value="N" <?if($row['displays'] == "N")echo"selected";?> >차단</option>
										</select>
									</td>
									<td class="date">
										<ul>
											<li><span><?=$row['r_regdate']?></span></li>
										</ul>
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
							

								<ul class="last">
									
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


function change_it()
{
       $.ajax({
			url: "change.php",
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
					alert_("정상적으로 변경되었습니다.");
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

function SELECT_DELETE() {
		if ($(".idx").is(":checked") == false)
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
			url: "review_del.php",
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
				response = response.trim();

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


function fn_chg_stat(idx, state){

	$.ajax({
		url: "chg_reviews.php",
		type: "GET",
		data: "idx="+idx+"&state="+state,
		error : function(request, status, error) {
		 //통신 에러 발생시 처리
			alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
			$("#ajax_loader").addClass("display-none");
		}
		,complete: function(request, status, error) {
//				$("#ajax_loader").addClass("display-none");
		}
		, success : function(response, status, request) {
			response = response.trim();

			if (response == "OK")
			{
				alert("수정되었습니다.");
					location.reload();
				return;
			} else {
				alert(response);
				alert("오류가 발생하였습니다!!");
				return;
			}
		}
	});

}
</script>


<? include "../_include/_footer.php"; ?>