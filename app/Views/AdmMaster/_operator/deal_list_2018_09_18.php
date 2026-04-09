<? include "../_include/_header.php"; ?>
<?
	
	$code					= updateSQ($_GET["code"]);
	$g_list_rows		= 10;
	$pg					= updateSQ($_GET["pg"]);
	$search_name		= updateSQ($_GET["search_name"]);
	$search_category	= updateSQ($_GET["search_category"]);
	$s_product_code_1	= updateSQ($_GET["s_product_code_1"]);
	$s_product_code_2	= updateSQ($_GET["s_product_code_2"]);
	$s_product_code_3	= updateSQ($_GET["s_product_code_3"]);
	

	if($code == ""){
		$code = "01";
	}

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
	
	$total_sql = " select g.*, d.idx as d_idx, d.onum as onum
					 from tbl_deal d
					 left outer join tbl_goods g
					on d.g_idx = g.g_idx 
					where code = '".$code."' $strSql ";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error($connect));
	$nTotalCount = mysqli_num_rows($result);


$code_name = "";
if($code == "01"){
	$code_name = "신선특가";
}else if($code == "02"){
	$code_name = "최대할인특가";
}else if($code == "03"){
	$code_name = "5+1특가";
}else if($code == "04"){
	$code_name = "증정특가";
}

?>
		<div id="container">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2><?=$code_name?></h2>
					<div class="menus">
						<ul class="first">
						</ul>

						<ul class="last">
							<li><a href="javascript:change_it()" class="btn btn-success">순위변경</a></li>
							<li><a href="#!" onclick="findGoods();" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span class="txt">상품 등록</span></a></li>
						</ul>
						
					</div>

				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents">
				
				<header id="headerContents">
						
				

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
						<col width="9%" />
						<col width="10%" />
						<col width="*" />
						<col width="11%" />
						<col width="5%" />
						<col width="5%" />
						<col width="10%" />
						<col width="7%" />
						</colgroup>
						<thead>
							<tr>
								<th>제품코드</th>
								<th>이미지</th>
								<th>제품명</th>
								<th>판매가격</th>
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
								
								$sql    = $total_sql . " order by d.onum desc limit $nFrom, $g_list_rows ";
								$result = mysqli_query($connect, $sql) or die (mysql_error($connect));
								$num = $nTotalCount - $nFrom;
								
								if ($nTotalCount == 0) {
							?>
								<tr>
									<td colspan="8" style="text-align:center;height:100px">검색된 결과가 없습니다.</td>
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
										<p class="categore"><?=$row['goods_code']?></p>
									</td>
									<td class="images">
										<img src="/data/product/<?=$row["ufile1"]?>" alt="제품 이미지">
									</td>
									<td class="product_name">
										<p><strong>상품명</strong> : <span><?=$row['goods_name_front']?></span></p>
										<?
										// 현재 등록된 코드를 통해 전체 코드를 알아보자
										$product_code = getCodeSlice( $row['product_code'] );
										$product_code_ar = explode("||",$product_code);
										?>
										<p><strong>상품카테고리</strong> : <span><?=get_cate_text($product_code_ar[0])?></span></p>




									
									</td>
									<td class="price">
										<p><strong>최초가</strong> : <span><?=number_format($row['price_mk'])?>원</span></p>
										<p><strong>판매가</strong> : <span><?=number_format($row['price_se'])?>원</span></p>
										<p><strong>할인율</strong> : <span><?=round(($row['price_mk']-$row['price_se'])/$row['price_mk']*100,1)?>%</span></p>
									</td>

									<td>
									
										<input type="text" name="onum[]" value="<?=$row["onum"]?>" class="input_txt" style="width:30px" />
										<input type="hidden" name="idx[]" value="<?=$row["d_idx"]?>" class="input_txt"/>						
									</td>
								
									<td>
									<?
										switch($row['item_state']){
											case "sale" :
												echo "판매중";
											break;

											case "stop" :
												echo "판매중지";
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
									<td>
										<a href="javascript:del_it('<?=$row['d_idx']?>');"><img src="/AdmMaster/_images/common/ico_error.png" alt="에러" /></a>
									</td>
								</tr>

							<?  } ?>
							
						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

					<?echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF]."?s_product_code_1=".$s_product_code_1."&s_product_code_2=".$s_product_code_2."&s_product_code_2=".$s_product_code_3."&search_category=".$search_category."&search_name=".$search_name."&pg=&code=".$code)?>


					<div id="headerContainer">
						
						<div class="inner">
							<div class="menus">
								<ul class="first">
								</ul>

								<ul class="last">
									<li><a href="javascript:change_it()" class="btn btn-success">순위변경</a></li>
									<li><a href="#!" onclick="findGoods();" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span class="txt">상품 등록</span></a></li>
								</ul>
								
							</div>

						</div><!-- // inner -->

					</div><!-- // headerContainer -->
				</div><!-- // listWrap -->

			</div><!-- // contents -->





		</span><!-- 인쇄 영역 끝 //-->
		</div><!-- // container -->

		<div class="coupon_pop" >
			<div>
				<form action="set_popular.php" onsubmit="return fn_chk_goods();">
					<input type="hidden" name="code" id="code" value="<?=$code?>" />
					<div class="search_box">
					<h2>상품찾기</h2>
						<select id="product_code_1" name="product_code_1" class="input_select" onchange="javascript:get_code(this.value, 2)">
							<option value="">1차분류</option>
							<?
								$fsql    = "select * from tbl_code where depth='1' and status='Y' order by onum desc, code_idx desc";
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
						<select id="product_code_2" name="product_code_2" class="input_select" onchange="javascript:get_code(this.value, 3)" >
							<option value="">2차분류</option>
						</select><br/>
						<select id="product_code_3" name="product_code_3" class="input_select line2" onchange="javascript:get_code(this.value, 4)" >
							<option value="">3차분류</option>
						</select>
						<select id="product_code_4" name="product_code_4" class="input_select line2" >
							<option value="">4차분류</option>
						</select>

						<input type="text" name="tmp_goods" id="tmp_goods" onkeyup="javascript:press_it()" style="margin-top:10px;" ><button type="button" onclick="fn_chk_goods();" class="search" style="margin-top:10px;" >검색</button>
					</div>
					<div class="table_box">
						<table>
						<caption>상품찾기</caption>
							<tbody id="id_contents">

							</tbody>
						</table>
					</div>			
					<div class="sel_box">
						<div>
							<button type="button" class="close">취소</button>
						</div>		
					</div>	
				</form>	
			</div>			
		</div>



<script>


function del_it(product_idx) {

	if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false)
	{
		return;
	}
	$("#ajax_loader").removeClass("display-none");
	$.ajax({
		url: "del_deal.php",
		type: "POST",
		data: "idx[]="+product_idx,
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




$(document).ready(function(){
	$('.coupon_pop').find('.close').on('click',function(){	
		$('.coupon_pop').css({'display':'none'});
	});
});


function findGoods(){
	$(".coupon_pop").show();
	$("#tmp_goods").focus();
}


function fn_chk_goods(){

	var tmp_goods = $("#tmp_goods").val();

	/*
	if( tmp_goods.trim() == ""){
		alert("상품명을 입력해주세요.");
		$("#tmp_goods").focus();
		return false;
	}
	*/

	tmp_goods = escape(tmp_goods);

	var product_code_1 = $("#product_code_1").val();
	var product_code_2 = $("#product_code_2").val();
	var product_code_3 = $("#product_code_3").val();
	var product_code_4 = $("#product_code_4").val();

	$.ajax({
		type:"GET"
		, url:"find_goods_deal.ajax.php"
		, dataType : "html" //전송받을 데이터의 타입
		, timeout : 30000 //제한시간 지정
		, cache : false  //true, false
		, data : "tmp_goods="+tmp_goods+"&product_code_1="+product_code_1+"&product_code_2="+product_code_2+"&product_code_3="+product_code_3+"&product_code_4="+product_code_4 //서버에 보낼 파라메터
		,error : function(request, status, error) {
		 //통신 에러 발생시 처리
			alert("code : " + request.status + "\r\nmessage : " + request.reponseText);
		}
		, success:function(data){
			$("#id_contents").html(data);
			
		}
	});

	return false;
}

function press_it(){
	if(event.keyCode == 13)
	{
		fn_chk_goods();
	}
}


function sel_goods(g_idx){

	if( confirm("해당 상품을 등록하시겠습니까?") ){
		
		var code = $("#code").val();
		
		$.ajax({
			type:"GET"
			, url:"set_goods_deal.ajax.php"
			, dataType : "html" //전송받을 데이터의 타입
			, timeout : 30000 //제한시간 지정
			, cache : false  //true, false
			, data : "g_idx="+ g_idx + "&code=" + code //서버에 보낼 파라메터
			,error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert("code : " + request.status + "\r\nmessage : " + request.reponseText);
			}
			, success:function(data){
				if(data.trim() == "ok"){
					alert("처리되었습니다.");
				}else{
					alert(data);	
				}

				location.reload();
				
				
			}
		});
	}
}



function get_code(strs, depth)
{
	$.ajax({
		type:"GET"
		, url:"../_goods/get_code.ajax.php"
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
			if (depth <= 2)
			{
				$("#product_code_2").find('option').each(function() {
					$(this).remove();
				});
				$("#product_code_2").append("<option value=''>2차분류</option>");
			}

			if (depth <= 3)
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
				$("#product_code_"+(parseInt(depth))).append("<option value='"+list[i].code_no+"'>"+list[i].code_name+""+contentStr+"</option>");
			}
		}
	});
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

</script>




<? include "../_include/_footer.php"; ?>