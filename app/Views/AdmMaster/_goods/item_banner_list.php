<? include "../_include/_header.php"; ?>
<?

	$g_list_rows		= 10;
	$pg					= updateSQ($_GET["pg"]);
	$search_name		= updateSQ($_GET["search_name"]);
	$search_category	= updateSQ($_GET["search_category"]);

	$state_chker		= $_GET['state_chker'];
	$type_chker			= $_GET['type_chker'];
	$time_chker			= $_GET['time_chker'];

	if($type_chker){
		
		for($i=0; $i < count($type_chker); $i++){
			$type_arr = $type_arr." '".$type_chker[$i]."',";
		}
		$typeSql = " and category in (".substr($type_arr,0,-1).")";
		//echo $stateSql;
	}

	if($state_chker){
		
		for($i=0; $i < count($state_chker); $i++){
			$state_arr = $state_arr." '".$state_chker[$i]."',";
		}
		$stateSql = " and status in (".substr($state_arr,0,-1).")";
		//echo $stateSql;
	}

	if($time_chker){
		$time_arr = " and (";
		for($i=0; $i < count($time_chker); $i++){
			$time_arr .= " show_cate like '%".$time_chker[$i]."%' or ";
		}
		$time_arr = substr($time_arr,0,-3);
		$time_arr .= " )";
		$timeSql = $time_arr;
		//echo $timeSql;
	}

	if ($search_name)
	{
		$strSql = $strSql." and replace(".$search_category.",'-','') like '%".str_replace("-","",$search_name)."%' ";
	}


	$total_sql = " select * from tbl_goods_list_bnnr where 1=1 $stateSql $strSql $typeSql $timeSql";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error($connect));
	$nTotalCount = mysqli_num_rows($result);

	function category_name($code_no){
		
		global $connect;

		$c_name_sql = "select code_name from tbl_freebies_code where code_no = '".$code_no."' and status != 'del' ";
		$c_name_result = mysqli_query($connect, $c_name_sql);
		$c_name_row = mysqli_fetch_array($c_name_result);
	
		return $c_name_row['code_name'];
	}
?>
<div class="page-heading mb-4">
    
    <div class="d-flex justify-content-between align-items-center">
        <header class="d-block d-xl-none pb-2">
            <a href="#" class="d-block burger-btn d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <h4 class="text-center">제품리스트배너 리스트</h4>
    </div>
</div>
		<div id="container" class="gnb_banner">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<!-- <h2>제품리스트배너 리스트</h2> -->
					<div class="menus">
						<ul class="first">
							<li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), true)" class="btn btn-success">전체선택</a></li>
							<li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), false)" class="btn btn-success">선택해체</a></li>
							<li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li>
						</ul>

						<ul class="last">
							<li><a href="javascript:change_it()" class="btn btn-success">순위변경</a></li>
							<li><a href="item_banner_write.php" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span class="txt">배너 등록</span></a></li>
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
								<td class="label">사은품카테고리</td>
								<td class="inbox">
								<?
									$code_sql = "select * from tbl_code where status = 'Y' and parent_code_no = '0' order by onum desc, code_idx desc";
									
									$code_result = mysqli_query($connect, $code_sql);
									while( $code_row = mysqli_fetch_array($code_result) ){
								?>
								<p>
									<span><input name="type_chker[]" type="checkbox" value="<?=$code_row['code_no']?>" <?if(in_array($code_row['code_no'], $type_chker))echo"checked";?> ></span>
									<span><?=$code_row['code_name']?></span>
									&nbsp;&nbsp;
								</p>
								<?}?>
								
								</td>
							</tr>
							<tr>
								<td class="label">상태유무 <input id="chk_all_order_item_state" type="checkbox"></td>
								<td class="inbox">
									<p>
												<input name="state_chker[]" class="state_chker" type="checkbox" value="Y"  <?if(in_array('Y', $state_chker))echo"checked";?> > 게시중&nbsp;&nbsp;
									</p>
									<p>
												<input name="state_chker[]" class="state_chker" type="checkbox" value="N"  <?if(in_array('N', $state_chker))echo"checked";?> > 게시중지&nbsp;&nbsp;
									</p>
								</td>
							</tr>
							<tr>
								<td class="label">시간구별</td>
								<td>
									<p>
												<input name="time_chker[]" class="state_chker" type="checkbox" value="A"  <?if(in_array('A', $time_chker))echo"checked";?> > 주간(09:00 ~ 18:00)&nbsp;&nbsp;
									</p>
									<p>
												<input name="time_chker[]" class="state_chker" type="checkbox" value="N"  <?if(in_array('N', $time_chker))echo"checked";?> > 야간(18:00 ~ 09:00)&nbsp;&nbsp;
									</p>
									<p>
												<input name="time_chker[]" class="state_chker" type="checkbox" value="W"  <?if(in_array('W', $time_chker))echo"checked";?> > 주말(일요일)&nbsp;&nbsp;
									</p>
								</td>
							</tr>
							<tr>
								<td class="label">검색어</td>
								<td class="inbox">
									
									<div class="r_box d-flex" style="gap: 10px;" >
										<select id="" name="search_category" class="form-select" style="width:112px; height: 39px">
											<!-- <option value="" >전체검색</option> -->
											<option value="subject" <?if($search_category=="subject")echo"selected";?> >배너명</option>
										</select>
										<div class="input-group">
											<input type="text" id="search_name" name="search_name" value="<?=$search_name?>" class="form-control placeHolder" placeholder="검색어 입력" style="width:240px" onkeyDown="if(event.keyCode==13)search_it();" />
											<button class="btn btn-light" onclick="search_it()"><i class="bi bi-search"></i></button>
										</div>
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
					<div class="listBottom">
						<table cellpadding="0" cellspacing="0" summary="" class="table table-hover table-bordered border-light" style="table-layout:fixed;">
						<colgroup>
						<col width="4%" />
						<col width="9%" />
						<col width="10%" />
						<col width="*" />
						<col width="11%" />
						<!-- <col width="7%" /> -->
						<!-- <col width="5%" /> -->
						<col width="7%" />
						<col width="10%" />
						<col width="6%" />
						</colgroup>
						<thead>
							<tr class="table-dark">
								<th>선택</th>
								<th>시간구별</th>
								<th>이미지</th>
								<th>제목</th>
								<!-- <th>판매가격</th> -->
								<!-- <th>재고</th> -->
								<th>우선순위</th>
								<th>상태</th>
								<th>등록일</th>
								<th>EDIT</th>
							</tr>
						</thead>	
						<tbody>
							<?
								$nPage = ceil($nTotalCount / $g_list_rows);
								if ($pg == "") $pg = 1;
								$nFrom = ($pg - 1) * $g_list_rows;
								
								$sql    = $total_sql . " order by onum desc, idx desc limit $nFrom, $g_list_rows ";
								$result = mysqli_query($connect, $sql) or die (mysql_error($connect));
								$num = $nTotalCount - $nFrom;
								
								
								if ($nTotalCount == 0) {
							?>
								<tr>
									<td colspan=8 style="text-align:center;height:100px">검색된 결과가 없습니다.</td>
								</tr>
							<?
								}
							?>
							







							<?
								while($row = mysqli_fetch_array($result)){
									
							?>

								<tr>
									<td>
										 <div class="form-check d-flex justify-content-center" style="padding-left: 0">
											<input type="checkbox" name="idx[]" class="idx" value="<?=$row['idx']?>"  />
										</div>
									</td>
									<td class="text-center">
										<?
										$show_cate = explode('||', substr($row['show_cate'],1,-1));
										$show_cate_txt = '';
										foreach($show_cate as $key => $vals)
											{
												if($vals == 'W'){
													$show_cate_txt .= "주말";
												}
												if($vals == 'N'){
													$show_cate_txt .= "야간";
												}
												if($vals == 'A'){
													$show_cate_txt .= "주간";
												}
												$show_cate_txt .= ",";
											}
											echo substr($show_cate_txt,0,-1);
											?>
									</td>
									<td class="images text-center">
										<?if($row["ufile1"]){?>
											<img src="/data/goods_banner/<?=$row["ufile1"]?>" alt="제품 이미지">
											<?}?>
										</td>
										<td class="product_name text-center">
											<p><?=$row['subject']?></p>
										</td>
										
										<td class="text-center">
											
											<input type="text" name="onum[]" value="<?=$row["onum"]?>" class="form-control" style="width:50px" />
											<input type="hidden" name="o_idx[]" value="<?=$row["idx"]?>" class="input_txt"/>						
										</td>
										<td>
											<?
										switch($row['status']){
											case "Y" :
												echo "게시중";
												break;
												
												case "N" :
													echo "게시중지";
													break;
													
													case "plan" :
														echo "등록예정";
														break;
													}
													?>
									</td>
									<td class="date text-center">
										<ul>
											<li><span><?=substr($row['regdate'],0,16)?></span></li>
											
										</ul>
									</td>
									<td class="text-center"><a href="item_banner_write.php?idx=<?=$row['idx']?>" class="btn btn-primary"><i class="bi bi-pencil"></i></a></td>
								</tr>

							<?  } ?>
							
						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

					<?echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF]."?search_category=".$search_category."&search_name=".$search_name."&pg=")?>


					<div id="headerContainer">
						
						<div class="inner">
							<div class="menus">
							

								<ul class="last">
									<li><a href="javascript:change_it()" class="btn btn-success">순위변경</a></li>
									<li><a href="item_banner_write.php" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span class="txt">배너 등록</span></a></li>
								</ul>
								
							</div>

						</div><!-- // inner -->

					</div><!-- // headerContainer -->
				</div><!-- // listWrap -->

			</div><!-- // contents -->





		</span><!-- 인쇄 영역 끝 //-->
		</div><!-- // container -->





<script>
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
			url: "item_banner_change.php",
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
					setTimeout(function(){
						location.reload();
					},1000);
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
			url: "item_banner_del.php",
			type: "POST",
			data: $("#frm").serialize(),
			error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				//$("#ajax_loader").addClass("display-none");
			}
			,complete: function(request, status, error) {
//				$("#ajax_loader").addClass("display-none");
			}
			, success : function(response, status, request) {
				response = response.trim();

				if (response == "OK")
				{
					alert_("정상적으로 삭제되었습니다.");
					setTimeout(function(){
						location.reload();
					},1000);
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