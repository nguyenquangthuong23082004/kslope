<? include "../_include/_header.php"; ?>
<?
	$b_code = $_GET['b_code'];
	
	$total_sql = " select b.*, co.code_name as color_name, si.code_name as size_name , g.goods_name_front, g.ufile1, m.m_idx, m.status, m.visit_date, m.visit_time, ma.shop_name, ma.addr1, ma.addr2
					  from tbl_booking_goods b
					  left outer join tbl_goods g
						on b.g_idx = g.g_idx
					  left outer join tbl_goods_option o
						on b.option_code = o.idx
					  left outer join tbl_color co
						on o.goods_color = co.code_no
					  left outer join tbl_size si
						on o.goods_size = si.code_no
					  left outer join tbl_mybooking m
						on m.booking_code = b.booking_code
					  left outer join tbl_market ma
						on ma.m_idx = m.m_idx
					where b.booking_code = '".$b_code."'
				  ";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());


	$nTotalCount = mysqli_num_rows($result);
?>
		<div id="container">

		


		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				<div class="inner">
					<h2>예약판매</h2>
					<div class="menus">
						<ul >
							<li><a href="booking_list.php?search_gubun=<?=$search_gubun?>&search_category=<?=$search_category?>&search_name=<?=$search_name?>&pg=<?=$pg?>" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a></li>
						</ul>
					</div>
				</div>
				<!-- // inner --> 
				
			</header>
			<!-- // headerContainer -->

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
								<th>번호</th>
								<th>상품</th>
								<th>옵션</th>
								<th>합계금액</th>
							</tr>
						</thead>	
						<tbody>
							
						<?
							$i = 1;
							$sql    = $total_sql . " order by b.idx desc ";
							$result = mysqli_query($connect, $sql) or die (mysql_error());
							while($row=mysqli_fetch_array($result)){
							
						?>
						
							<tr style="height:50px">
								<td><?=$i?></td>
								<td class="tal">
									<p class="item_tit"><?=$row['goods_name_front']?></p>
								</td>
								<td class="tal">
									<ul class="item_option">
										<li><strong>Color</strong> : <?=$row['color_name']?></li>
										<li><strong>Size</strong> : <?=$row['size_name']?></li>
									</ul>
								</td>
								<td>
									<strong><?=number_format($row['total_price'])?></strong>원<p>(수량 : <?=number_format($row['good_cnt'])?>개)</p>
								</td>
							</tr>
						<?
							$i++;
						} 
						?>




							
						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

					
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
						<input type="text" name="tmp_goods" id="tmp_goods" onkeyup="javascript:press_it()" ><button type="button" onclick="fn_chk_goods();" class="search">검색</button>
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
		$("#pop_idx").val( "" );
		$('.coupon_pop').css({'display':'none'});
	});
});


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

	if( tmp_goods.trim() == ""){
		alert("상품명을 입력해주세요.");
		$("#tmp_goods").focus();
		return false;
	}

	tmp_goods = escape(tmp_goods);

	$.ajax({
		type:"GET"
		, url:"find_goods.ajax.php"
		, dataType : "html" //전송받을 데이터의 타입
		, timeout : 30000 //제한시간 지정
		, cache : false  //true, false
		, data : "tmp_goods="+tmp_goods //서버에 보낼 파라메터
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
			, url:"set_goods_popular.ajax.php"
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


</script>


<? include "../_include/_footer.php"; ?>