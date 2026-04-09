<? include "../_include/_header.php"; ?>
<script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js"></script>
<script type="text/javascript" src="./write.js"></script>
<?
	$idx				= updateSQ($_GET["idx"]);  
	$pg					= updateSQ($_GET["pg"]);
	$search_name		= updateSQ($_GET["search_name"]);
	$search_category	= updateSQ($_GET["search_category"]);
	$s_product_code_1	= updateSQ($_GET["s_product_code_1"]);
	$s_product_code_2	= updateSQ($_GET["s_product_code_2"]);
	
	if ($idx)
	{
		$sql					= " select * from tbl_goods where idx = '".$idx."'";
		$result					= mysqli_query($connect, $sql) or die (mysql_error($connect));
		$row					= mysqli_fetch_array($result);

		$product_code_1			= $row["product_code_1"];
		$product_code_2			= $row["product_code_2"];	
		$goods_name_ko			= $row["goods_name_ko"];	
		$goods_name_en			= $row["goods_name_en"];
		$oneinfo_ko				= $row["oneinfo_ko"];
		$oneinfo_en				= $row["oneinfo_en"];
		$info1_ko				= $row["info1_ko"];
		$info1_en				= $row["info1_en"];
		$info2_ko				= $row["info2_ko"];
		$info2_en				= $row["info2_en"];
		$info3_ko				= $row["info3_ko"];
		$info3_en				= $row["info3_en"];
		$ufile1					= $row["ufile1"];
		$rfile1					= $row["rfile1"];	
		$ufile2					= $row["ufile2"];
		$rfile2					= $row["rfile2"];
		$ufile3					= $row["ufile3"];
		$rfile3					= $row["rfile3"];
		$ufile4					= $row["ufile4"];
		$rfile4					= $row["rfile4"];
		$ufile5					= $row["ufile5"];
		$rfile5					= $row["rfile5"];
		$ufile6					= $row["ufile6"];
		$rfile6					= $row["rfile6"];
		$useYN					= $row["useYN"];
		$regdate				= $row["regdate"];

	}

	$titleStr = "상품정보 수정";
	$links = "list.php";

?>



<div id="container"> <span id="print_this"><!-- 인쇄영역 시작 //-->
	
	<header id="headerContainer">
		<div class="inner">
			<h2><?=$titleStr?></h2>
			<div class="menus">
				<ul >
					<li><a href="<?=$links?>?search_gubun=<?=$search_gubun?>&search_category=<?=$search_category?>&search_name=<?=$search_name?>&pg=<?=$pg?>" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a></li>
					<? if ($idx) { ?>
					<li><a href="javascript:send_it()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a></li>
					<li><a href="javascript:del_it()" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span><span class="txt">삭제</span></a></li>
					<? } else { ?>
					<li><a href="javascript:send_it()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">등록</span></a></li>
					<? } ?>
					
				</ul>
			</div>
		</div>
		<!-- // inner --> 
		
	</header>
	<!-- // headerContainer -->
	
	
	<div id="contents">
		<div class="listWrap_noline">
				
			<form name="frm" action="write_ok.php" method="post" target="hiddenFrame22"  enctype="multipart/form-data"  >
				<!-- 상품 고유 번호 -->
				<input type=hidden name="idx" value='<?=$idx?>' />
				<!-- 상품 카테고리 -->
				<input type=text name="product_code" id="product_code" value='' />
				<!-- 상품 색상 -->
				<input type=text name="product_color" id="product_color" value='' />
				<!-- 상품 사이즈 -->
				<input type=text name="product_size" id="product_size" value='' />


			<div class="listBottom">
				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail">
					<caption>
					</caption>
					<colgroup>
						<col width="10%" />
						<col width="40%" />
						<col width="10%" />
						<col width="40%" />
					</colgroup>
					<tbody>

						<tr height="45">
							<td colspan="4">
								기본정보
							</td>
						</tr>
					
						<tr height="45">
							<th>카테고리선택</th>
							<td colspan="3">

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
									<option value="<?=$frow["code_no"]?>" <? if ($row["product_code_1"] == $frow["code_no"]) {echo "selected"; } ?>><?=$frow["code_name"]?> <?=$status_txt?></option>
									<? } ?>
									
								</select> 
								<select id="product_code_2" name="product_code_2" class="input_select" onchange="javascript:get_code(this.value, 3)" >
									<option value="">2차분류</option>
									<?
										$fsql    = "select * from tbl_code where depth='2' and parent_code_no='".$row["product_code_1"]."' and status='Y'  order by onum desc, code_idx desc";
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
									<option value="<?=$frow["code_no"]?>" <? if ($row["product_code_2"] == $frow["code_no"]) {echo "selected"; } ?>><?=$frow["code_name"]?> <?=$status_txt?></option>
									<? } ?>
								</select>
								<select id="product_code_3" name="product_code_3" class="input_select" onchange="javascript:get_code(this.value, 4)" >
									<option value="">3차분류</option>
									<?
										$fsql    = "select * from tbl_code where depth='3' and parent_code_no='".$row["product_code_2"]."' and status='Y'  order by onum desc, code_idx desc";
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
									<option value="<?=$frow["code_no"]?>" <? if ($row["product_code_2"] == $frow["code_no"]) {echo "selected"; } ?>><?=$frow["code_name"]?> <?=$status_txt?></option>
									<? } ?>
								</select>
								<select id="product_code_4" name="product_code_4" class="input_select" >
									<option value="">4차분류</option>
									<?
										$fsql    = "select * from tbl_code where depth='4' and parent_code_no='".$row["product_code_3"]."' and status='Y'  order by onum desc, code_idx desc";
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
									<option value="<?=$frow["code_no"]?>" <? if ($row["product_code_2"] == $frow["code_no"]) {echo "selected"; } ?>><?=$frow["code_name"]?> <?=$status_txt?></option>
									<? } ?>
								</select>
								
								<button type="button" id="btn_reg_cate">등록</button>
							</td>
							
						</tr>

						<tr height="45">
							<th>등록된 카테고리</th>
							<td colspan="3">
								<ul id="reg_cate">
									
								</ul>
							</td>
						</tr>

						<tr height="45">
							<th>상품코드</th>
							<td>
								<input type="text" name="goods_code" value="<?=$row["goods_code"]?>" class="text" style="width:200px">
								<button type="button">중복체크</button>
								
							</td>
							<th>ERP 코드</th>
							<td>
								<input type="text" name="goods_erp" value="<?=$row["goods_erp"]?>" class="text" style="width:200px">
								<button type="button">중복체크</button>
								
							</td>
						</tr>

						<tr height="45">
							<th>시즌</th>
							<td colspan="3">
								<select name="goods_seoson" id="goods_seoson">
								<?foreach($_adm_season as $key => $seoson_val){?>
									<option value="<?=$key?>"><?=$seoson_val?></option>
								<?}?>
								</select>	
							</td>
						</tr>

						<tr height="45">
							<th>상품명(앞)</th>
							<td>
								<input type="text" name="goods_name_front" value="<?=$row["goods_name_front"]?>" class="text" style="width:300px">
							</td>
							<th>상품명(뒤)</th>
							<td>
								<input type="text" name="goods_name_back" value="<?=$row["goods_name_back"]?>" class="text" style="width:300px">
							</td>
						</tr>


						<tr height=45>
							<th>상품명(컬러)</th>
							<td>
								<input type="text" name="goods_name_ko" value="<?=$row["goods_name_ko"]?>" class="text" style="width:300px">
							</td>
							<th>ERP 상품명</th>
							<td>
								<input type="text" name="goods_name_ko" value="<?=$row["goods_name_ko"]?>" class="text" style="width:300px">
							</td>
						</tr>

						<tr height="45">
							<th>검색어</th>
							<td colspan="3">
								<input type="text" name="goods_keyword" id="goods_keyword" value="" class="text" style="width:90%;"><br/>
								<span style="color:red;">검색어는 콤마(,)로 구분하셔서 입력하세요. 입력예)자켓,방풍자켓,기능성자켓</span>
								
							</td>
						</tr>

						<tr height="45">
							<th>브랜드</th>
							<td>

								<select id="goods_brand" name="goods_brand" class="input_select" >
									<option value="">브랜드를 선택하세요.</option>
									<?
										$fsql    = "select * from tbl_brand where status='Y' order by onum desc, code_idx desc";
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
									<option value="<?=$frow["code_no"]?>" <? if ($row["goods_brand"] == $frow["code_no"]) {echo "selected"; } ?>><?=$frow["code_name"]?> <?=$status_txt?></option>
									<? } ?>
									
								</select> 
							</td>
							<th>제조년월</th>
							<td>
								<input type="text" name="goods_make_date" id="goods_make_date" value="" class="datepicker input_txt" >
							</td>
						</tr>
						
						<tr height="45">
							<th>제조국가(원산지)</th>
							<td>

								<select id="product_code_1" name="product_code_1" class="input_select" >
									<?
										$fsql    = "select * from tbl_country where status='Y' order by onum desc, code_idx desc";
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
									<option value="<?=$frow["code_no"]?>" <? if ($row["product_code_1"] == $frow["code_no"]) {echo "selected"; } ?>><?=$frow["code_name"]?> <?=$status_txt?></option>
									<? } ?>
									
								</select> 
							</td>
							<th>성별</th>
							<td>
								<select>
								<?foreach($_adm_gender as $key => $gender_val){?>
									<option value="<?=$key?>"><?=$gender_val?></option>
								<?}?>
								</select>	
							</td>
						</tr>
						
						<tr height="45">
							<th>등록구분</th>
							<td>
								<select>
								<?foreach($_adm_regist as $key => $regist_val){?>
									<option value="<?=$key?>"><?=$regist_val?></option>
								<?}?>
								</select>	
							</td>
							<th>병행수입여부</th>
							<td>
								<input type="checkbox" name="" id="" value="" > 병행수입
							</td>
						</tr>


						<tr height="45">
							<th>아이콘</th>
							<td colspan="3">
								<?
									$fsql    = "select * from tbl_icon where status='Y' order by onum asc, code_idx desc";
									$fresult = mysqli_query($connect, $fsql) or die (mysql_error());
									while($frow=mysqli_fetch_array($fresult)){
								?>


										<input type="checkbox" value="<?=$frow["code_no"]?>" > <span for=""><img src="/data/icon/<?=$frow["iconimg"]?>" style="max-height:200px;margin-right:20px;"></span>
								<? } ?>
							</td>
							
						</tr>

						<tr height="45">
							<th>대표색상</th>
							<td colspan="3">
								<input type=text name="product_dbcolor" id="product_dbcolor" value=''>
								<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail">
									<colgroup>
										<col width="150px;" />
										<col width="*" />
									</colgroup>
									<tr>
										<th>선택가능한 색상</th>
										<td>
										<?
										$fsql    = "select * from tbl_dbcolor where status='Y' order by onum asc, code_idx desc";
										$fresult = mysqli_query($connect, $fsql) or die (mysql_error());
										$dbcolor_cnt = 0;
										while($frow=mysqli_fetch_array($fresult)){
											$dbcolor_cnt++;
											if($dbcolor_cnt==10){
												//echo "<br/>";
											}
										?>
											<span title="<?=$frow["code_name"]?>" style="border: 1px solid rgb(204, 204, 204); border-image: none; background:<?=$frow["color_code"]?>;margin-right:10px;cursor:pointer;" onclick="addDbColor('<?=$frow["color_code"]?>','<?=$frow["code_name"]?>');">&nbsp;&nbsp;&nbsp;&nbsp;</span>
											
										<?
										}
										?>
											
										</td>
									</tr>

									<tr>
										<th>선택된 색상</th>
										<td id="selectColor">
										
											
										</td>
									</tr>

								</table>

								<span style="color:red;">선택된 색상을 제거하시려면 해당 색상박스를 더블클릭하시면 제거됩니다</span>
								
							</td>
						</tr>

						<tr height="45">
							<th>특징요약</th>
							<td colspan="3">
								<textarea style="width:90%;height:150px;"></textarea>
							</td>
						</tr>

						<tr height="45">
							<th>판매상태결정</th>
							<td colspan="3">
								<select name="" id="">
									<option>판매중</option>
									<option>판매중지</option>
									<option>등록예정</option>
								</select>
							</td>
						</tr>



						<tr height="45">
							<th>관리자메모</th>
							<td colspan="3">
								<textarea style="width:90%;height:100px;"></textarea>
							</td>
						</tr>


					</tbody>
				</table>




				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail" style="margin-top:50px;">
					<caption>
					</caption>
					<colgroup>
						<col width="10%" />
						<col width="40%" />
						<col width="10%" />
						<col width="40%" />
					</colgroup>
					<tbody>
				
						<tr height="45">
							<td colspan="4">
								가격/재고
							</td>
						</tr>

						<tr height="45">
							<th>최초가격(정찰가)</th>
							<td>
								<input type="text" class="onlynum" style="text-align:right;" /> 원
							</td>
							<th>즉시할인금액</th>
							<td>
								<input type="text" class="onlynum" style="text-align:right;" /> 원
							</td>
						</tr>


						<tr height="45">
							<th>판매가격</th>
							<td>
								<input type="text" class="onlynum" style="text-align:right;" /> 원
							</td>
							<th>과세유형</th>
							<td>

								<select>
								<?foreach($_adm_item_tax as $key => $gender_val){?>
									<option value="<?=$key?>"><?=$gender_val?></option>
								<?}?>
								</select>
								
							</td>
						</tr>

						<tr height="45">
							<th>신규고객 할인금액</th>
							<td>
								<input type="text" class="onlynum" style="text-align:right;" /> 원
							</td>
							<th>추가 적립금</th>
							<td>
								<input type="text" class="onlynum" style="text-align:right;" /> 원
							</td>
						</tr>


						<tr height="45">
							<th>주문최소수량</th>
							<td>
								<input type="text" class="onlynum" style="text-align:right;" /> 
								<span>주문시 설정된 수량이상부터 주문이 가능합니다.</span>
							</td>
							<th>주문최대수량</th>
							<td>
								<input type="text" class="onlynum" style="text-align:right;" /> 
								<span>0으로 설정시 주문제한수량은 무제한 입니다.</span>
							</td>
						</tr>


						<tr height="45">
							<th>주문단위표시</th>
							<td colspan="3">
								<select >
									<option>개</option>
								</select>
							</td>
						</tr>

						<tr height="45">
							<th>기간한정할인</th>
							<td colspan="3">
								<select >
									<option>사용</option>
									<option>중지</option>
								</select>
								<input type="text" name="goods_name_ko" value="" class="datepicker input_txt" > ~ 
								<input type="text" name="goods_name_ko" value="" class="datepicker input_txt" > 까지
								<input type="text" class="onlynum" style="text-align:right;" /> 원 할인적용 
								<span>(설정한 기간동안 설정된 금액만큼 할인을 합니다. 기간이 끝나면 원래가격 판매됩니다)</span>
							</td>
						</tr>

					</tbody>
				</table>


				




				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail" style="margin-top:50px;">
					<caption>
					</caption>
					<colgroup>
					<col width="10%" />
					<col width="90%" />
					</colgroup>
					<tbody>
				
						<tr height=45>
							<td colspan="2">
								옵션
							</td>
						</tr>

						<tr height=45>
							<th>상품컬러등록</th>
							<td>
								<select id="product_color1" name="product_color1" class="input_select" >
									<option value="">색상추가</option>
									<?
										$fsql    = "select * from tbl_color where status='Y' order by onum desc, code_idx desc";
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
									<option value="<?=$frow["code_no"]?>" <? if ($row["product_code_1"] == $frow["code_no"]) {echo "selected"; } ?>><?=$frow["code_name"]?> <?=$status_txt?></option>
									<? } ?>
									
								</select>

								<button type="button" id="btn_reg_color">등록</button>

								<div>
									<table>
										<colgroup>
											<col width="50%"></col>
											<col width="200px;"></col>
											<col width="200px;"></col>
											<col width="200px;"></col>
											<col width="200px;"></col>
										</colgroup>
										<thead>
											<tr>
												<th>컬러명</th>
												<th>정렬순서</th>
												<th>상태</th>
												<th>판매재고</th>
												<th>삭제</th>
											</tr>
										</thead>
										<tbody id="color_body">
											

										</tbody>
									</table>
								</div>
							</td>
						</tr>

						<tr height=45>
							<th>상품사이즈등록</th>
							<td>
								<select id="product_size1" name="product_size1" class="input_select">
									<option value="">사이즈 타입</option>
									<?
										$fsql    = "select * from tbl_size_type where status='Y' order by onum desc, code_idx desc";
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
									<option value="<?=$frow["code_no"]?>" <? if ($row["product_code_1"] == $frow["code_no"]) {echo "selected"; } ?>><?=$frow["code_name"]?> <?=$status_txt?></option>
									<? } ?>
									
								</select>
								<button type="button" id="btn_reg_size">등록</button>
								<div>
									<table>
										<colgroup>
											<col width="50%"></col>
											<col width="200px;"></col>
											<col width="200px;"></col>
											<col width="200px;"></col>
											<col width="200px;"></col>
										</colgroup>
										<thead>
											<tr>
												<th>사이즈명</th>
												<th>정렬순서</th>
												<th>상태</th>
												<th>재고</th>
												<th>삭제</th>
											</tr>
										</thead>
										<tbody id="size_body">
											

										</tbody>
									</table>
								</div>
							</td>
						</tr>

						<tr height=45>
							<th>상품재고등록</th>
							<td>
								<div>
									<table>
										<colgroup>
											<col width="50%"></col>
											<col width="200px;"></col>
											<col width="200px;"></col>
											<col width="200px;"></col>
											<col width="200px;"></col>
										</colgroup>
										<thead>
											<tr>
												<th>컬러명</th>
												<th>사이즈명</th>
												<th>재고</th>
												<th>상태</th>
												<th>삭제</th>
											</tr>
										</thead>
										<tbody id="settingBody">
											

										</tbody>
									</table>
								</div>
							</td>
						</tr>

						<tr height="45">
							<th>실측사이즈 차이</th>
							<td colspan="3">
								<ul class="realsize">
									<li rel="-10">-10</li>
									<li rel="-8">-8</li>
									<li rel="-5">-5</li>
									<li rel="-4">-4</li>
									<li rel="-3">-3</li>
									<li rel="-2">-2</li>
									<li rel="-1">-1</li>
									<li rel="0" class="on">0</li>
									<li rel="1">1</li>
									<li rel="2">2</li>
									<li rel="3">3</li>
									<li rel="4">4</li>
									<li rel="5">5</li>
									<li rel="8">8</li>
									<li rel="10" class="last">10</li>
								</ul>
							</td>
						</tr>


						<tr height="45">
							<th>실측 제품사이즈</th>
							<td colspan="3">
								<select>
									<option value="실측 제품 사이즈">실측 제품 사이즈</option>
								</select>
							</td>
						</tr>

						<tr height="45">
							<th>제품 무게</th>
							<td colspan="3">
								<input type="text" class="onlynum" style="text-align:right;" /> g
							</td>
						</tr>

						<tr height="45">
							<th>실측사이즈 차이</th>
							<td colspan="3">
								<ul class="seasonchk">
									<li rel="1">사계절</li>
									<li rel="2">봄</li>
									<li rel="3">여름</li>
									<li rel="4">가을</li>
									<li rel="5">겨울</li>
									<li rel="6">봄/여름</li>
									<li rel="7">가을/겨울</li>
									<li rel="8">봄/가을</li>
								</ul>


								<ul class="monthchk">
									<li rel="1">01월</li>
									<li rel="2">02월</li>
									<li rel="3">03월</li>
									<li rel="4">04월</li>
									<li rel="5">05월</li>
									<li rel="6">06월</li>
									<li rel="7">07월</li>
									<li rel="8">08월</li>
									<li rel="9">09월</li>
									<li rel="10">10월</li>
									<li rel="11">11월</li>
									<li rel="12">12월</li>
								</ul>
							</td>
						</tr>


					</tbody>
				</table>




				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail" style="margin-top:50px;">
					<caption>
					</caption>
					<colgroup>
						<col width="10%" />
						<col width="90%" />
					</colgroup>
					<tbody>

						<tr height=45>
							<td colspan="2">
								이미지 등록
							</td>
						</tr>

						<tr>
							<th>대표이미지</th>
							<td colspan="3">
								
								<input type="file" name="ufile1"  class="bbs_inputbox_pixel" style="width:500px;margin-bottom:10px" /> 
								<? if ($ufile1 != "") { ?><br>파일삭제:<input type=checkbox name="del_<?=$i?>" value='Y'><a href="/data/product/<?=$ufile1?>" class="imgpop"><?=$rfile?></a><br><br><? } ?>
								
							</td>
						</tr>



						<tr>
							<th>서브이미지</th>
							<td colspan="3">
								<? for ($i=2;$i<=6;$i++) { ?>
									<input type="file" name="ufile<?=$i?>"  class="bbs_inputbox_pixel" style="width:500px;margin-bottom:10px" /> 
									<? if (${"ufile".$i} != "") { ?><br>파일삭제:<input type=checkbox name="del_<?=$i?>" value='Y'><a href="/data/product/<?=${"ufile".$i}?>" class="imgpop"><?=${"rfile".$i}?></a><br><br><? } ?>
								<? } ?>
							</td>
						</tr>



						</tbody>
				</table>




				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail" style="margin-top:50px;">
					<caption>
					</caption>
					<colgroup>
						<col width="10%" />
						<col width="90%" />
					</colgroup>
					<tbody>

						<tr height=45>
							<td colspan="2">
								상품 상세설명
							</td>
						</tr>

						<tr height=45>
							<td colspan="2">
								
								<textarea name="info1_ko" id="info1_ko" rows="10" cols="100" class="input_txt" style="width:100%; height:400px; display:none;"><?=viewSQ($info1_ko);?></textarea>

								<script type="text/javascript">
								var oEditors1 = [];

								// 추가 글꼴 목록
								//var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];

								nhn.husky.EZCreator.createInIFrame({
									oAppRef: oEditors1,
									elPlaceHolder: "info1_ko",
									sSkinURI: "/smarteditor/SmartEditor2Skin.html",	
									htParams : {
										bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
										bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
										bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
										//aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
										fOnBeforeUnload : function(){
											//alert("완료!");
										}
									}, //boolean
									fOnAppLoad : function(){
										//예제 코드
										//oEditors.getById["ir1"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
									
									},
									fCreator: "createSEditor2"
								});
								

								
								</script>


							</td>
						</tr>

						
					</tbody>
				</table>




				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail" style="margin-top:50px;">
					<caption>
					</caption>
					<colgroup>
						<col width="10%" />
						<col width="90%" />
					</colgroup>
					<tbody>

						<tr height=45>
							<td colspan="2">
								주의사항
							</td>
						</tr>

						<tr height=45>
							<td colspan="2">
								
								<textarea name="info2_ko" id="info2_ko" rows="10" cols="100" class="input_txt" style="width:100%; height:400px; display:none;"><?=viewSQ($info1_ko);?></textarea>

								<script type="text/javascript">
								var oEditors2 = [];

								// 추가 글꼴 목록
								//var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];

								nhn.husky.EZCreator.createInIFrame({
									oAppRef: oEditors2,
									elPlaceHolder: "info2_ko",
									sSkinURI: "/smarteditor/SmartEditor2Skin.html",	
									htParams : {
										bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
										bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
										bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
										//aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
										fOnBeforeUnload : function(){
											//alert("완료!");
										}
									}, //boolean
									fOnAppLoad : function(){
										//예제 코드
										//oEditors.getById["ir1"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
									
									},
									fCreator: "createSEditor2"
								});
								

								
								</script>


							</td>
						</tr>

						
					</tbody>
				</table>












<input type=text name="product_option" id="product_option" value='' style="width:500px;" >
<input type=text name="realsize_dif" id="realsize_dif" value='0' >
<input type=text name="use_month" id="use_month" value='' >


			</div>
			</form>
			<!-- // listBottom --> 




				<div class="tail_menu">
					<ul>
						<li class="left"></li>
						<li class="right_sub">

							<a href="<?=$links?>?search_gubun=<?=$search_gubun?>&search_category=<?=$search_category?>&search_name=<?=$search_name?>&pg=<?=$pg?>" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a>
							<? if ($idx == "") { ?>	
							<a href="javascript:send_it()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">등록</span></a>
							<? } else { ?>
							<a href="javascript:send_it()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a>
							<a href="javascript:del_it()" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span><span class="txt">삭제</span></a>
							<? } ?>
						</li>
					</ul>
				</div>





			
		</div>
		<!-- // listWrap --> 
		
	</div>
	<!-- // contents --> 
	
	</span><!-- 인쇄 영역 끝 //--> 
</div>



<script type="text/javascript">



</script>

<iframe width="300" height="300" name="hiddenFrame22" id="hiddenFrame22" style="display:block;"></iframe>

<? include "../_include/_footer.php"; ?>



<!--

oEditors1.getById["info1_ko"].exec("UPDATE_CONTENTS_FIELD", []);
oEditors2.getById["info1_ko"].exec("UPDATE_CONTENTS_FIELD", []);

-->