<? include "../_include/_header.php"; ?>
<?
	$g_list_rows = 10;
	
	$total_sql = " select *	
						, (select ifnull(count(*),0) as cnt from tbl_code a where a.parent_code_no=tbl_code.code_no) as cnt
						from tbl_code where 1=1 $strSql ";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$nTotalCount = mysqli_num_rows($result);
?>
		<div id="container" class="gnb_operator">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>
						TOP5
					</h2>
					<div class="menus">
						<ul class="first">
						</ul>

					</div>

				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents" style="width:50%;">

				<div class="listWrap">
								

					<form name="frm" id="frm">				
					<div class="listBottom">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable">
						<caption></caption>
						<colgroup>
							<col width="120px" />
							<col width="260px" />
							<col width="*" />
							<col width="120px" />
						</colgroup>
						<thead>
							<tr>
								<th>순위</th>
								<th>카테고리</th>
								<th>상품명</th>
								<th>관리</th>
							</tr>
						</thead>	
						<tbody>
							
							
							<?
							
							for( $i=1; $i<=5; $i++ ){
								

								$sql    = " select * from tbl_top5 where idx = '".$i."' ";
								$result = mysqli_query($connect, $sql) or die (mysql_error($connect));
								$row = mysqli_fetch_array($result);

								if( $row['g_idx'] != ""){

									$fsql		= "select * from tbl_goods where g_idx='".$row['g_idx']."' ";
									$fresult	= mysqli_query($connect, $fsql) or die (mysqli_error($connect));
									$row_g		= mysqli_fetch_array($fresult);
								}

							?>
							<tr style="height:50px">
								<td><?=$i?></td>
								<td class="tal"><?=get_group_text($row_g['product_group'])?></td>
								<td class="tal"><?=$row_g['goods_name_front']?></td>
								
								
								<td>
									
									<button type="button" class="btn btn-default" onclick="findGoods('<?=$row['idx']?>');" >등록</button>
									
								</td>
							</tr>
							<?  } ?>




							
						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>



					<!-- 중복체크 팝업 -->
					<div id="pooup_01" class="popup"  style="" >
						<div class="pooup_bg"></div>
						<div class="popup_con">
							<input type="hidden" name="chk_codeType" id="chk_codeType" >
							<input type="hidden" name="chk_codeCnt" id="chk_codeCnt" >
							<h2 class="tit"><span class="code_text"></span>상품검색</h2>
							<p class="text">- 상품명을 입력하세요.</p>
							<input type="text" name="pop_search" id="pop_search" class="box nothangul">
							

							<label for="" class="name_search">조회</label>
							
							<p class="result_text"><strong>코드</strong>를 입력하신 후 조회해주세요.</p>

							
							<div class="btn_box">
								<p class="ok_btn">사용</p><span>|</span>
								<p class="close_btn">닫기</p>
							</div>
						</div>
					</div>


					
				</div><!-- // listWrap -->

			</div><!-- // contents -->





		</span><!-- 인쇄 영역 끝 //-->
		</div><!-- // container -->
		<div class="coupon_pop" >
			<div>
				<form action="set_popular.php" onsubmit="return fn_chk_goods();">
					<input type="hidden" name="pop_idx" id="pop_idx" value="" />

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
						<select id="product_code_3" name="product_code_3" class="input_select" onchange="javascript:get_code(this.value, 4)" >
							<option value="">3차분류</option>
						</select>
						<select id="product_code_4" name="product_code_4" class="input_select" >
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
	$(document).ready(function(){


		$('.coupon_pop').find('.close').on('click',function(){
			$('.coupon_pop').css({'display':'none'});
		});
	});
</script>



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



function findGoods(order_idx){
	$("#pop_idx").val( order_idx );
	$("#tmp_goods").val("");
	$(".coupon_pop").show();
	$("#tmp_goods").focus();
}


function fn_chk_goods(){

	var pop_idx = $("#pop_idx").val();

	if( pop_idx.trim() == ""){
		alert("순위가 선택되지 않았습니다.");
		return false;
	}

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

	if( confirm("해당 상품으로 수정하시겠습니까?") ){
		
		var pop_idx = $("#pop_idx").val();

		if( pop_idx.trim() == ""){
			alert("순위가 선택되지 않았습니다.");
			return false;
		}

		
		$.ajax({
			type:"GET"
			, url:"set_goods_top5.ajax.php"
			, dataType : "html" //전송받을 데이터의 타입
			, timeout : 30000 //제한시간 지정
			, cache : false  //true, false
			, data : "pop_idx="+ pop_idx + "&g_idx=" + g_idx //서버에 보낼 파라메터
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

</script>


<? include "../_include/_footer.php"; ?>