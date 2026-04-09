<? include "../_include/_header.php"; ?>
<?

	$g_list_rows		= 10;
	$pg					= updateSQ($_GET["pg"]);
	$search_name		= updateSQ($_GET["search_name"]);
	$search_category	= updateSQ($_GET["search_category"]);
	$s_product_code_1	= updateSQ($_GET["s_product_code_1"]);
	$s_product_code_2	= updateSQ($_GET["s_product_code_2"]);
	$s_product_code_3	= updateSQ($_GET["s_product_code_3"]);

	$state_chker		= $_GET['state_chker'];
	$type_chker			= $_GET['type_chker'];
	$dis_chker			= $_GET['dis_chker'];

	if($type_chker){
		
		for($i=0; $i < count($type_chker); $i++){
			$type_arr = $type_arr." product_code like '%|".$type_chker[$i]."%' or";
		}
		$typeSql = " and (".substr($type_arr,0,-3).") ";
		//echo $typeSql;
	}

	if($state_chker){
		
		for($i=0; $i < count($state_chker); $i++){
			$state_arr = $state_arr." '".$state_chker[$i]."',";
		}
		$stateSql = " and item_state in (".substr($state_arr,0,-1).")";
		//echo $stateSql;
	}

	if($dis_chker){
		
		for($i=0; $i < count($dis_chker); $i++){
			$dis_chker_arr = $dis_chker_arr." '".$dis_chker[$i]."',";
		}
		$disSql = " and goods_dis1 in (".substr($dis_chker_arr,0,-1).")";
		//echo $disSql;
	}

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

	$total_sql = " select * from tbl_goods where item_state != 'dele' $strSql $typeSql $stateSql $disSql";
	//echo $total_sql;
	$result = mysqli_query($connect, $total_sql) or die (mysql_error($connect));
	$nTotalCount = mysqli_num_rows($result);
?>
<style>
    .image-wrapper {
        position: relative;
        display: inline-block;
    }

    .image_product {
        width: 100%;
        height: auto;
        object-fit: cover;
        cursor: zoom-in;
        transition: transform 0.3s ease;
    }

    .zoom-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.7);
        z-index: 9998;
    }

    .zoom-preview {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        width: 30vw;
        max-height: 50vh;
        transform: translate(-50%, -50%);
        z-index: 9999;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        background: #fff;
    }

    /* Khi hover vào wrapper (bao gồm overlay hoặc ảnh phóng to) */
    .image-wrapper:hover .zoom-preview {
        display: block;
    }

    form .form-select {
        max-width: 12rem;
    }

    .search-input {
        display: block;
        width: 100%;
        padding: .375rem 8.75rem .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #607080;
        -webkit-appearance: none;
        appearance: none;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #dce7f1;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
</style>
<div class="page-heading mb-4">
    
    <div class="d-flex justify-content-between align-items-center">
        <header class="d-block d-xl-none pb-2">
            <a href="#" class="d-block burger-btn d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <h4 class="text-center">상품정보 리스트</h4>
    </div>
</div>
		<div id="container" class="gnb_goods page-content card shadow p-2">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<div class="menus">
						<ul class="first">
							<li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), true)" class="btn btn-success">전체선택</a></li>
							<li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), false)" class="btn btn-success">선택해체</a></li>
							<li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li>
						</ul>

						<ul class="last">
							<li><a href="javascript:change_it()" class="btn btn-success">순위변경</a></li>
							<li><a href="write.php" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span class="txt">상품 등록</span></a></li>
						</ul>
						
					</div>

				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents">
				<form name="search" id="search">		
				<header id="listBottom">

					<!-- 시작 -->

					<table cellpadding="0" cellspacing="0" summary="" class="listTable01" style="table-layout:fixed;">
						<colgroup>
							<col width="150">
							<col width="*">
						</colgroup>
						<thead>
							<tr>
								<th colspan="2"></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="label">카테고리</td>
								<td class="inbox">
								<?
									$code_sql = "select * from tbl_code where status = 'Y' and parent_code_no = '0' order by onum desc, code_idx desc";
									
									$code_result = mysqli_query($connect, $code_sql);
									while( $code_row = mysqli_fetch_array($code_result) ){
								?>
								<p>
									<span><input name="type_chker[]" type="checkbox" class="form-check-input" value="<?=$code_row['code_no']?>" <?if(in_array($code_row['code_no'], $type_chker))echo"checked";?> ></span>
									<span><?=$code_row['code_name']?></span>
									&nbsp;&nbsp;
								</p>
								<?}?>
								
								</td>
							</tr>
							<tr>
								<td class='label'>메인노출</td>
								<td class="inbox">
								<?
									$code_sql = "select * from tbl_code where status = 'Y' and parent_code_no = '0' and bestYN = 'Y' order by onum desc, code_idx desc";
									
									$code_result = mysqli_query($connect, $code_sql);
									while( $code_row = mysqli_fetch_array($code_result) ){
								?>
								<p>
									<span><input name="dis_chker[]" type="checkbox" class="form-check-input" value="<?=$code_row['code_no']?>" <?if(in_array($code_row['code_no'], $dis_chker))echo"checked";?> ></span>
									<span><?=$code_row['code_name']?></span>
									&nbsp;&nbsp;
								</p>
								<?}?>
								</td>
							</tr>
							<tr>
								<td class="label">판매 상태<input id="chk_all_order_item_state" type="checkbox" class="form-check-input"></td>
								<td class="inbox">
									<p>
												<input name="state_chker[]" class="state_chker form-check-input" type="checkbox" value="sale"  <?if(in_array('sale', $state_chker))echo"checked";?> > 판매중&nbsp;&nbsp;
									</p>
									<p>
												<input name="state_chker[]" class="state_chker form-check-input" type="checkbox" value="stop"  <?if(in_array('stop', $state_chker))echo"checked";?> > 판매중지&nbsp;&nbsp;
									</p>
								</td>
							</tr>
							
							<tr>
								<td class="label">검색어</td>
								<td class="inbox">
									
									<div class="r_box d-flex" style="gap: 10px;">
										<select id="" name="search_category" class="form-select" style="width:112px; height: 39px">
											<!-- <option value="" >전체검색</option> -->
											<option value="goods_name_front" <?if($search_category=="goods_name_front")echo"selected";?> >제품명</option>
											<option value="goods_code" <?if($search_category=="goods_code")echo"selected";?> >상품코드(모델명)</option>
										</select>
										<div class="input-group">
											<input type="text" id="search_name" name="search_name" value="<?=$search_name?>" class="form-control placeHolder" placeholder="검색어 입력" style="width:240px" onkeyDown="if(event.keyCode==13)search_it();" />
											<!-- <input type="text" class="form-control" name="search_txt" placeholder="Search" aria-label="Search" value=""> -->
											<button class="btn btn-light" onclick="search_it()"><i class="bi bi-search"></i></button>
										</div>
										<!-- <a href="javascript:search_it()" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> <span class="txt">검색</span></a> -->
									</div>
								</td>
							</tr>

						</tbody>
					</table>
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
					<div class="table-responsive mt-3">
						<table cellpadding="0" cellspacing="0" summary="" class="table table-hover table-bordered border-light listTable " style="table-layout:fixed;">
						<colgroup>
						<col width="4%" />
						<col width="9%" />
						<col width="10%" />
						<col width="*" />
						<col width="18%" />
						<!-- <col width="7%" /> -->
						<col width="5%" />
						<col width="5%" />
						<col width="15%" />
						<col width="14%" />
						</colgroup>
						<thead>
							<tr class="table-dark">
								<th>선택</th>
								<th>제품코드</th>
								<th>이미지</th>
								<th>제품명</th>
								<th>판매가격</th>
								<!-- <th>재고</th> -->
								<th>우선순위</th>
								<th>상태</th>
								<th>등록일시</th>
								<th>관리</th>
							</tr>
						</thead>	
						<tbody>
							<?
								$nPage = ceil($nTotalCount / $g_list_rows);
								if ($pg == "") $pg = 1;
								$nFrom = ($pg - 1) * $g_list_rows;
								
								$sql    = $total_sql . " order by onum desc, g_idx desc limit $nFrom, $g_list_rows ";
								$result = mysqli_query($connect, $sql) or die (mysql_error($connect));
								$num = $nTotalCount - $nFrom;
								
								
								if ($nTotalCount == 0) {
							?>
								<tr>
									<td colspan=10 style="text-align:center;height:100px">검색된 결과가 없습니다.</td>
								</tr>
							<?
								}
							?>
							







							<?
								while($row = mysqli_fetch_array($result)){
									// 등록된 정보 체크함
									if($row['content']			== ""){ $li_content_yn = "off";		}else{ $li_content_yn = "on";	}
									if($row['use_month']		== ""){ $li_use_month_yn = "off";	}else{ $li_use_month_yn = "on";	}
									if($row['md_comment']		== ""){ $li_md_comment_yn = "off";	}else{ $li_md_comment_yn = "on";}
									if($row['goods_make_date']	== ""){ $li_make_date_yn = "off";	}else{ $li_make_date_yn = "on";	}
									if($row['goods_keyword']	== ""){ $li_keyword_yn = "off";		}else{ $li_keyword_yn = "on";	}
									if($row['item_weight']		== ""){ $li_weight_yn = "off";		}else{ $li_weight_yn = "on";	}

							?>

								<tr>
									<td>
										<div class="form-check d-flex justify-content-center">
											<input type="checkbox" name="idx[]" class="idx form-check-input" value="<?=$row['g_idx']?>"  />
										</div>
									</td>
									<td>
										<p class="categore"><?=$row['goods_code']?></p>
										<p class="product_view"><a href="/item/item_view.php?gcode=<?=$row['g_idx']?>" target="_blank">[<span>상품상세</span>]</a></p>
									</td>
									<td class="images">
										 <div class="image-wrapper">
											<img src="<?= !empty($row['ufile1']) ? '/data/product/' . $row['ufile1'] : '/img/sub/noimg.png' ?>" alt="" class="image_product">
											<div class="zoom-overlay"></div>
											<img src="<?= !empty($row['ufile1']) ? '/data/product/' . $row['ufile1'] : '/img/sub/noimg.png' ?>" alt="" class="zoom-preview">
										</div>
										<!-- <div>
											<?if($row["ufile1"]){?>
												<img src="/data/product/<?=$row["ufile1"]?>" alt="제품 이미지">
												<?}?>
											</div> -->
										</td>
										<td class="product_name">
											<p><strong>상품명</strong> : <span><?=$row['goods_name_front']?></span></p>
											<!-- <p><strong>간략설명</strong> : <span><?=$row['goods_name_back']?></span></p> -->
											<p><strong>상품명(컬러)</strong> : <span><?=$row['goods_color']?></span></p>
											<?
										// 현재 등록된 코드를 통해 전체 코드를 알아보자
										$product_code = getCodeSlice( $row['product_code'] );
										$product_code_ar = explode("||",$product_code);
										?>
										<p><strong>상품카테고리</strong> : <span><?=get_cate_text($product_code_ar[0])?></span></p>
									</td>
									<td class="price">
										<p><strong>리스트 표시가</strong> : <span><?=number_format($row['price_mk'])?>원</span></p>
										<p><strong>리스트 제휴적용가</strong> : <span><?=number_format($row['price_se'])?>원</span></p>
										<!--
											<p><strong>할인율</strong> : <span><?=round(($row['price_mk']-$row['price_se'])/$row['price_mk']*100,1)?>%</span></p>
											-->
										</td>
										<!-- <td><?=number_format($row['good_cnt'])?></td> -->
										<td>
											
											<input type="text" name="onum[]" value="<?=$row["onum"]?>" class="form-control input_txt" />
											<input type="hidden" name="g_idx[]" value="<?=$row["g_idx"]?>" class="form-control input_txt"/>						
										</td>
										<td>
											<?
										switch($row['item_state']){
											case "sale" :
												echo "게시중";
												break;
												
												case "stop" :
													echo "게시중지";
													break;
													
													case "plan" :
														echo "등록예정";
														break;
													}
													?>
									</td>
									<td class="date">
										<ul>
											<li><strong>등록 : 관리자</strong><span><?=substr($row['reg_date'],0,16)?></span></li>
											<li><strong>수정 : 관리자</strong><span><?=substr($row['mod_date'],0,16)?></span></li>
										</ul>
									</td>
									<td scope="row" class="text-center">
										<a href="javascript:prod_copy('<?=$row["g_idx"]?>')" class="btn btn-success">복사하기</a>
										<a href="javascript:del_it(<?=$row["g_idx"]?>)" class="btn btn-danger"><i class="bi bi-trash"></i></a>
										<a href="write.php?g_idx=<?=$row['g_idx']?>"
											class="btn btn-primary"><i class="bi bi-pencil"></i></a>
									</td>
								</tr>

							<?  } ?>
							
						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

					<?echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF]."?s_product_code_1=".$s_product_code_1."&s_product_code_2=".$s_product_code_2."&search_category=".$search_category."&search_name=".$search_name."&pg=")?>


					<div id="headerContainer">
						
						<div class="inner">
							<div class="menus">
							

								<ul class="last">
									<li><a href="javascript:change_it()" class="btn btn-success">순위변경</a></li>
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
	    function prod_copy(idx)
    {
                if (!confirm("선택한 상품을 복사 하시겠습니까?"))
                    return false;

                var message = "";
                $.ajax({

                    url: "./ajax.prod_copy.php",
                    type: "POST",
                    data: {
                        "product_idx": idx
                    },
                    dataType: "json",
                    async: false,
                    cache: false,
                    success: function(data, textStatus) {
                        message = data.message;
                        alert(message);
                        location.reload();
                    },
                    error:function(request,status,error){
                        alert("code = "+ request.status + " message = " + request.responseText + " error = " + error); // 실패 시 처리
                    }
                });
    }

$(document).ready(function(){
	$("#chk_all_order_item_state").click(function(){
		var chk_bool = $(this).prop("checked");
		
		$(".state_chker").each(function(){
			$(this).prop("checked", chk_bool);
		});
	});
})
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
    if ($(".idx:checked").length === 0) {
        alert_("삭제할 내용을 선택하셔야 합니다.");
        return;
    }
    if (!confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.")) {
        return;
    }

    $("#ajax_loader").removeClass("display-none");

    var selected = $(".idx:checked").map(function() {
        return $(this).val();
    }).get();

    $.ajax({
        url: "del.php",
        type: "POST",
        data: { idx: selected },
        success: function(response) {
            response = response.trim();
            if (response === "OK") {
                alert_("정상적으로 삭제되었습니다.");
                location.reload();
            } else {
                alert(response);
                alert_("오류가 발생하였습니다!!");
                $("#ajax_loader").addClass("display-none");
            }
        },
        error: function(request, status, error) {
            alert_("code : " + request.status + "\r\nmessage : " + request.responseText);
            $("#ajax_loader").addClass("display-none");
        }
    });
}


function del_it(product_idx) {

    if (!confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.")) return;

    $("#ajax_loader").removeClass("display-none");

    $.ajax({
        url: "del.php",
        type: "POST",
        data: { idx: product_idx },
        success: function(response) {

            if (response.trim() == "OK") {
                alert("정상적으로 삭제되었습니다.");
                location.reload();
            } else {
                alert("오류가 발생하였습니다!!");
            }
        },
        error: function() {
            alert("통신 에러가 발생했습니다.");
            $("#ajax_loader").addClass("display-none");
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