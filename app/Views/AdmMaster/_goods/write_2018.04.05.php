<? include "../_include/_header.php"; ?>
<script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js"></script>
<script type="text/javascript" src="./write.js"></script>
<?
	$g_idx				= updateSQ($_GET["g_idx"]);
	$pg					= updateSQ($_GET["pg"]);
	$search_name		= updateSQ($_GET["search_name"]);
	$search_category	= updateSQ($_GET["search_category"]);
	$s_product_code_1	= updateSQ($_GET["s_product_code_1"]);
	$s_product_code_2	= updateSQ($_GET["s_product_code_2"]);

	if ($g_idx)
	{
		$sql					= " select * from tbl_goods where g_idx = '".$g_idx."'";
		$result					= mysqli_query($connect, $sql) or die (mysql_error($connect));
		$row					= mysqli_fetch_object($result);

		foreach($row as $keys => $vals){
			//echo $keys . " => " . $vals . "<br/>";
			${$keys} = $vals;

		}




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
			<!--  target="hiddenFrame22"  -->
			<form name="frm" id="frm" action="write_ok.php" method="post"  enctype="multipart/form-data" target="hiddenFrame22" >
				<!-- 상품 고유 번호 -->
				<input type="hidden" name="g_idx" id="g_idx" value='<?=$g_idx?>' />
				<!-- 상품 카테고리 -->
				<input type="hidden" name="product_code" id="product_code" value='<?=$product_code?>' />

				<!-- 상품 분류 -->
				<input type="hidden" name="product_group" id="product_group" value='<?=$product_group?>'>

				<!-- 대표 색상 -->
				<input type="hidden" name="product_dbcolor" id="product_dbcolor" value='<?=$product_dbcolor?>'>
				<!-- 상품 색상 -->
				<input type="hidden" name="product_color" id="product_color" value='<?=$product_color?>' />
				<!-- 상품 사이즈 -->
				<input type="hidden" name="product_size" id="product_size" value='<?=$product_size?>' />
				<!-- 상품 옵션 -->
				<input type="hidden" name="product_option" id="product_option" value='<?=$product_option?>' style="width:500px;" >
				<!-- 실측사이즈 차이 -->
				<?if($realsize_dif=="") $realsize_dif=0;?>
				<input type="hidden" name="realsize_dif" id="realsize_dif" value='<?=$realsize_dif?>' >
				<!-- 사용권장시기 -->
				<input type="hidden" name="use_month" id="use_month" value='<?=$use_month?>' >
				<!-- db에 있는 goods_code -->
				<input type="hidden" name="old_goods_code" id="old_goods_code" value='<?=$goods_code?>' >




			<div class="listBottom">
				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail" style="table-layout:fixed;">
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
									<option value="<?=$frow["code_no"]?>" ><?=$frow["code_name"]?> <?=$status_txt?></option>
									<? } ?>

								</select>
								<select id="product_code_2" name="product_code_2" class="input_select" onchange="javascript:get_code(this.value, 3)" >
									<option value="">2차분류</option>
								</select>
								<select id="product_code_3" name="product_code_3" class="input_select" onchange="javascript:get_code(this.value, 4)" >
									<option value="">3차분류</option>
								</select>
								<select id="product_code_4" name="product_code_4" class="input_select" >
									<option value="">4차분류</option>
								</select>

								<button type="button" id="btn_reg_cate" class="btn_01">등록</button>
							</td>

						</tr>
						<?
						$_product_code_arr = explode("||", getCodeSlice($product_code) );
						?>
						<tr height="48">
							<th>등록된 카테고리</th>
							<td colspan="3">
								<ul id="reg_cate">
								<?
								if($product_code){
									foreach($_product_code_arr as $_tmp_code){
								?>

										<li>[<?=$_tmp_code?>] <?=get_cate_text($_tmp_code)?> <span onclick="delCategory('<?=$_tmp_code?>', this);" >삭제</span></li>
								<?
									}
								}
								?>
								</ul>
							</td>
						</tr>


						<tr height="45">
							<th>분류</th>
							<td colspan="3">
							<?
							$tmp_ar = get_group_array($product_group);

							?>

								<select id="product_group_1" name="product_group_1" class="input_select" onchange="javascript:get_group(this.value, 2)">
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
								<select id="product_group_2" name="product_group_2" class="input_select" onchange="javascript:get_group(this.value, 3)" >
									<option value="">2차분류</option>
								</select>
								<select id="product_group_3" name="product_group_3" class="input_select" onchange="javascript:get_group(this.value, 4)" >
									<option value="">3차분류</option>
								</select>
								<select id="product_group_4" name="product_group_4" class="input_select" >
									<option value="">4차분류</option>
								</select>


							</td>

						</tr>

						<tr height="45">
							<th>상품코드</th>
							<td>
								<input type="text" name="goods_code" id="goods_code" value="<?=$goods_code?>" readonly="readonly" class="text" style="width:200px">
								<?if($g_idx==""){?>
								<button type="button" class="btn_01" onclick="fn_pop('code');">코드입력</button>
								<?}else{?>
								<span style="color:red;">상품코드는 수정이 불가능합니다.</span>
								<?}?>

							</td>
							<th>ERP 코드</th>
							<td>
								<input type="text" name="goods_erp" id="goods_erp" value="<?=$goods_erp?>" readonly="readonly" class="text" style="width:200px">
								<?if($g_idx==""){?>
								<button type="button" class="btn_01" onclick="fn_pop('erp');">코드입력</button>
								<?}else{?>
								<span style="color:red;">ERP 코드는 수정이 불가능합니다.</span>
								<?}?>
							</td>
						</tr>

						<tr height="45">
							<th>시즌</th>
							<td>
								<select name="goods_seoson" id="goods_seoson">
								<?foreach($_adm_season as $key => $seoson_val){?>
									<option value="<?=$key?>" <? if ($goods_seoson == $key) {echo "selected"; } ?> ><?=$seoson_val?></option>
								<?}?>
								</select>
							</td>
							<th>상품명(영문)</th>
							<td>
								<input type="text" name="goods_name_en" value="<?=$goods_name_en?>" class="text" style="width:300px" maxlength="50" />
							</td>
						</tr>

						<tr height="45">
							<th>상품명(앞)</th>
							<td>
								<input type="text" name="goods_name_front" value="<?=$goods_name_front?>" class="text" style="width:300px" maxlength="50" />
							</td>
							<th>상품명(뒤)</th>
							<td>
								<input type="text" name="goods_name_back" value="<?=$goods_name_back?>" class="text" style="width:300px" maxlength="50" />
							</td>
						</tr>


						<tr height=45>
							<th>상품명(컬러)</th>
							<td>
								<input type="text" name="goods_color" value="<?=$goods_color?>" class="text" style="width:300px" maxlength="50" />
							</td>
							<th>ERP 상품명</th>
							<td>
								<input type="text" name="goods_erp_name" value="<?=$goods_erp_name?>" class="text" style="width:300px" maxlength="50" />
							</td>
						</tr>

						<tr height="45">
							<th>검색어</th>
							<td colspan="3">
								<input type="text" name="goods_keyword" id="goods_keyword" value="<?=$goods_keyword?>" class="text" style="width:90%;" maxlength="100" /><br/>
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
									<option value="<?=$frow["code_no"]?>" <? if ($goods_brand == $frow["code_no"]) {echo "selected"; } ?>><?=$frow["code_name"]?> <?=$status_txt?></option>
									<? } ?>

								</select>
							</td>
							<th>제조년월</th>
							<td>
								<input type="text" name="goods_make_date" id="goods_make_date" value="<?=$goods_make_date?>" class="datepicker input_txt" readonly >
							</td>
						</tr>

						<tr height="45">
							<th>제조국가(원산지)</th>
							<td>

								<select id="goods_country" name="goods_country" class="input_select" >
								<?
									$fsql    = "select * from tbl_country where status='Y' order by onum desc, code_idx desc";
									$fresult = mysqli_query($connect, $fsql) or die (mysql_error());
									while($frow=mysqli_fetch_array($fresult)){
								?>
										<option value="<?=$frow["code_no"]?>" <? if ($goods_country == $frow["code_no"]) {echo "selected"; } ?>><?=$frow["code_name"]?></option>
								<? } ?>
								</select>
							</td>
							<th>성별</th>
							<td>
								<select name="gender" id="gender" >
								<?foreach($_adm_gender as $key => $gender_val){?>
									<option value="<?=$key?>" <? if ($gender == $key) {echo "selected"; } ?> ><?=$gender_val?></option>
								<?}?>
								</select>
							</td>
						</tr>

						<tr height="45">
							<th>등록구분</th>
							<td>
								<!--
								<select name="reg_type" id="reg_type" >
								<?foreach($_adm_regist as $key => $regist_val){?>
									<option value="<?=$key?>" <? if ($reg_type == $key) {echo "selected"; } ?> ><?=$regist_val?></option>
								<?}?>
								</select>
								-->
							</td>
							<th>병행수입여부</th>
							<td>
								<input type="checkbox" name="parallel" id="parallel" value="Y" <? if ($parallel == "Y") {echo "checked=checked"; } ?> > 병행수입
							</td>
						</tr>


						<tr height="45">
							<th>아이콘</th>
							<td colspan="3">
								<?
									$_icon_arr = explode("||", getCodeSlice($goods_icon) );
									$fsql    = "select * from tbl_icon where status='Y' order by onum asc, code_idx desc";
									$fresult = mysqli_query($connect, $fsql) or die (mysql_error());
									while($frow=mysqli_fetch_array($fresult)){

								?>


										<input type="checkbox" name="goods_icon[]" id="goods_icon<?=$frow["code_no"]?>" value="<?=$frow["code_no"]?>" <?if( in_array($frow["code_no"], $_icon_arr) ) echo "checked=checked";?> > <label for="goods_icon<?=$frow["code_no"]?>"><img src="/data/icon/<?=$frow["iconimg"]?>" style="max-height:200px;margin-right:20px;"></label>
								<? } ?>
							</td>

						</tr>

						<tr height="45">
							<th>대표색상</th>
							<td colspan="3">

								<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail" style="table-layout:fixed;">
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
										<?
										$_color_arr = explode("||", getCodeSlice($product_dbcolor) );
										if($product_dbcolor){
											foreach($_color_arr as $_tmp_color){
												$fsql    = "select * from tbl_dbcolor where color_code='".$_tmp_color."' limit 1 ";
												$fresult = mysqli_query($connect, $fsql) or die (mysql_error());
												$frow = mysqli_fetch_array($fresult);
										?>
												<span title='<?=$frow['code_name']?>' style='border: 1px solid rgb(204, 204, 204); border-image: none; background:<?=$_tmp_color?>;margin-right:10px;cursor:pointer;' ondblclick='delDbColor("<?=$_tmp_color?>",this)' >&nbsp;&nbsp;&nbsp;&nbsp;</span>
										<?
											}
										}
										?>
										</td>
									</tr>

								</table>

								<span style="color:red;">선택된 색상을 제거하시려면 해당 색상박스를 더블클릭하시면 제거됩니다</span>

							</td>
						</tr>

						<tr height="45">
							<th>특징요약</th>
							<td colspan="3">
								<textarea name="md_comment" id="md_comment" style="width:90%;height:150px;"><?=$md_comment?></textarea>
								<p style="color:red;">슬러쉬( / ) 기호로 구분 표시됩니다. ex)검정/파랑/노랑 </p>
							</td>
						</tr>

						<tr height="45">
							<th>판매상태결정</th>
							<td colspan="3">
								<select name="item_state" id="item_state">
									<option value="sale" <? if ($item_state == "sale") {echo "selected"; } ?> >판매중</option>
									<option value="stop" <? if ($item_state == "stop") {echo "selected"; } ?> >판매중지</option>
									<option value="plan" <? if ($item_state == "plan") {echo "selected"; } ?> >등록예정</option>
								</select>
							</td>
						</tr>

						<tr height="45">
							<th>관리자메모</th>
							<td colspan="3">
								<textarea name="admin_memo" id="admin_memo" style="width:90%;height:100px;"><?=$admin_memo?></textarea>
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
								<input type="text" name="price_mk" id="price_mk" class="onlynum" style="text-align:right;" value="<?=$price_mk?>" /> 원
							</td>
							<th>즉시할인금액</th>
							<td>
								<input type="text" name="price_dc" id="price_dc" class="onlynum" style="text-align:right;" value="<?=$price_dc?>" /> 원
							</td>
						</tr>


						<tr height="45">
							<th>판매가격</th>
							<td>
								<input type="text" name="price_se" id="price_se" class="onlynum" style="text-align:right;" value="<?=$price_se?>" /> 원
							</td>
							<th>과세유형</th>
							<td>

								<select name="item_tax" id="item_tax" >
								<?foreach($_adm_item_tax as $key => $item_val){?>
									<option value="<?=$key?>" <? if ($item_tax == $key) {echo "selected"; } ?> ><?=$item_val?></option>
								<?}?>
								</select>

							</td>
						</tr>

						<tr height="45">
							<th>신규고객 할인금액</th>
							<td>
								<input type="text" name="price_fs" id="price_fs" class="onlynum" style="text-align:right;" value="<?=$price_fs?>"  /> 원
							</td>
							<th>추가 적립금</th>
							<td>
								<input type="text" name="point_more" id="point_more" class="onlynum" style="text-align:right;" value="<?=$point_more?>"  /> 원
							</td>
						</tr>


						<tr height="45">
							<th>주문최소수량</th>
							<td>
								<input type="text" name="item_min_order" id="item_min_order" class="onlynum" style="text-align:right;" value="<?=$item_min_order?>"  />
								<span>주문시 설정된 수량이상부터 주문이 가능합니다.</span>
							</td>
							<th>주문최대수량</th>
							<td>
								<input type="text" name="item_max_order" id="item_max_order" class="onlynum" style="text-align:right;" value="<?=$item_max_order?>"  />
								<span>0으로 설정시 주문제한수량은 무제한 입니다.</span>
							</td>
						</tr>


						<tr height="45">
							<th>주문단위표시</th>
							<td colspan="3">
								<select name="unit_uid" id="unit_uid" >
									<option value="개" <? if ($unit_uid == "개") {echo "selected"; } ?> >개</option>
								</select>
							</td>
						</tr>

						<tr height="45">
							<th>기간한정할인</th>
							<td colspan="3">
								<select name="dis_date_use" id="dis_date_use" >
									<option value="Y" <? if ($dis_date_use == "Y") {echo "selected"; } ?> >사용</option>
									<option value="N" <? if ($dis_date_use == "N") {echo "selected"; } ?> >중지</option>
								</select>
								<input type="text" name="dis_date_s" value="<?=$dis_date_s?>" class="datepicker input_txt" > ~
								<input type="text" name="dis_date_e" value="<?=$dis_date_e?>" class="datepicker input_txt" > 까지
								<input type="text" name="price_ds" value="<?=$price_ds?>" class="onlynum" style="text-align:right;" /> 원 할인적용
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

						<tr height="45">
							<td colspan="2">
								옵션
							</td>
						</tr>

						<tr height="45">
							<th>상품컬러등록</th>
							<td>
								<select id="product_color1" name="product_color1" class="input_select" >
									<option value="">색상추가</option>
									<?
										$fsql    = "select * from tbl_color where status='Y' order by onum desc, code_idx desc";
										$fresult = mysqli_query($connect, $fsql) or die (mysql_error());
										while($frow=mysqli_fetch_array($fresult)){


									?>
									<option value="<?=$frow["code_no"]?>" ><?=$frow["code_name"]?></option>
									<? } ?>

								</select>

								<button type="button" id="btn_reg_color" class="btn_01">등록</button>
								<span  style="color:red;">※ 상태 변경 시에 재고 내역이 일괄 변경됩니다. 판매재고는 상품재고 임시 저장 후 반영됩니다.</span>
								<div>
									<table>
										<colgroup>
											<col width="*"></col>
											<col width="15%;"></col>
											<col width="15%;"></col>
											<col width="15%;"></col>
										</colgroup>
										<thead>
											<tr>
												<th>컬러명</th>
												<th>상태</th>
												<th>판매재고</th>
												<th>삭제</th>
											</tr>
										</thead>
										<tbody id="color_body">
										<?
										$_product_color_arr = explode("||", getCodeSlice($product_color) );

										if($product_color){
											foreach($_product_color_arr as $_tmp_color){
												$fsql    = "select * from tbl_color where code_no='".$_tmp_color."' limit 1 ";
												$fresult = mysqli_query($connect, $fsql) or die (mysql_error());
												$frow = mysqli_fetch_array($fresult);

												if($goods_code){
													$_tmp_goods_cnt = get_option_color_cnt($goods_code, $_tmp_color);
												}else{
													$_tmp_goods_cnt = "";
												}
										?>


											<tr rel='<?=$_tmp_color?>'>
												<td><?=$frow['code_name']?></td>
												<td>
													<select name='color<?=$_tmp_color?>' id='color<?=$_tmp_color?>' onchange='fn_color(this)' >
														<option value='Y'>사용</option>
														<option value='N'>중지</option>
													</select>
												</td>
												<td>
													<input type='text' name='' id='' value="<?=$_tmp_goods_cnt?>" readonly>
												</td>
												<td>
													<button class='btn_02' type='button' onclick='delColor("<?=$_tmp_color?>" , this)' >삭제</button>
												</td>
											</tr>
										<?
											}
										}
										?>

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


									?>
									<option value="<?=$frow["code_no"]?>" ><?=$frow["code_name"]?></option>
									<? } ?>

								</select>
								<button type="button" id="btn_reg_size" class="btn_01">등록</button>
								<span  style="color:red;">※ 상태 변경 시에 재고 내역이 일괄 변경됩니다. 판매재고는 상품재고 임시 저장 후 반영됩니다.</span>
								<div>
									<table>
										<colgroup>
											<col width="*"></col>
											<col width="15%;"></col>
											<col width="15%;"></col>
											<col width="15%;"></col>
										</colgroup>
										<thead>
											<tr>
												<th>사이즈명</th>
												<th>상태</th>
												<th>재고</th>
												<th>삭제</th>
											</tr>
										</thead>
										<tbody id="size_body">

										<?
										$_product_size_arr = explode("||", getCodeSlice($product_size) );

										if($product_size){
											foreach($_product_size_arr as $_tmp_size){
												$fsql    = "select * from tbl_size_type where code_no='".$_tmp_size."' limit 1 ";
												$fresult = mysqli_query($connect, $fsql) or die (mysql_error());
												$frow = mysqli_fetch_array($fresult);


												if($goods_code){
													$_tmp_goods_cnt = get_option_size_cnt($goods_code, $_tmp_size);
												}else{
													$_tmp_goods_cnt = "";
												}
										?>

											<tr rel='<?=$_tmp_size?>'>
												<td><?=$frow['code_name']?></td>
												<td>
													<select name='size<?=$_tmp_size?>' id='size<?=$_tmp_size?>' onchange='fn_size(this)' >
														<option value='Y'>사용</option>
														<option value='N'>중지</option>
													</select>
												</td>
												<td>
													<input type='text' name='' id='' value='<?=$_tmp_goods_cnt?>' readonly>
												</td>
												<td>
													<button class='btn_02' type='button' onclick='delSize("<?=$_tmp_size?>" , this)' >삭제</button>
												</td>
											</tr>

										<?
											}
										}
										?>

										</tbody>
									</table>
								</div>
							</td>
						</tr>

						<tr height="45">
							<th>
								상품재고등록
								<?if($g_idx!=""){?>
								<p style="display:block;margin-top:10px;">
									<button type="button" id="btn_tmp_option" class="btn_01">임시 저장</button>
								</p>
								<?}?>
							</th>
							<td>
								<span  style="color:red;">※ 옵션 삭제 시에 해당 옵션과 연동된 주문, 결제내역에 영향을 미치니 반드시 확인 후에 삭제바랍니다.</span>
								<div>
									<table>
										<colgroup>
											<col width="*"></col>
											<col width="15%;"></col>
											<col width="15%;"></col>
											<col width="15%;"></col>
											<col width="15%;"></col>
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


										<?
										//echo $product_option;
										$_product_option_arr = explode("||", getCodeSlice($product_option) );
										if($product_option){
											foreach($_product_option_arr as $_tmp_options){

												$_tmp_size_ar = explode(":",$_tmp_options);

												$_tmp_color = $_tmp_size_ar[0];
												$_tmp_size = $_tmp_size_ar[1];

												// 색상 조회
												$fsql1    = "select * from tbl_color where code_no='".$_tmp_color."' limit 1 ";
												$fresult1 = mysqli_query($connect, $fsql1) or die (mysql_error());
												$frow1 = mysqli_fetch_array($fresult1);
												
										
												// 사이즈 조회
												$fsql2    = "select * from tbl_size where code_no='".$_tmp_size."' limit 1 ";
												$fresult2 = mysqli_query($connect, $fsql2) or die (mysql_error());
												$frow2 = mysqli_fetch_array($fresult2);

												// 옵션 조회
												$fsql3    = "select * from tbl_goods_option where goods_code='".$goods_code."' AND goods_color = '".$_tmp_color."' AND goods_size = '".$_tmp_size."'  limit 1 ";

												$fresult3 = mysqli_query($connect, $fsql3) or die (mysql_error());
												$frow3 = mysqli_fetch_array($fresult3);
														
										?>

											<tr color='<?=$_tmp_color?>' size='<?=$frow2['type']?>' >
												<td><?=$frow1['code_name']?></td>
												<td><?=$frow2['code_name']?></td>
												<td>
													<input type='text' class='onlynum' name='option_cnt_<?=$_tmp_color?>_<?=$_tmp_size?>'  id='' value="<?=$frow3['goods_cnt']?>" />
												</td>
												<td >
													<select name='option_use_<?=$_tmp_color?>_<?=$_tmp_size?>' >
														<option value='Y' <?if($frow3['use_yn'] == "Y")echo"selected=selected";?> >사용</option>
														<option value='N' <?if($frow3['use_yn'] == "N")echo"selected=selected";?> >중지</option>
													</select>
												</td>
												<td>
													<button type='button' onclick='delOption("<?=$_tmp_options?>",this)' >삭제</button>
												</td>
											</tr>

										<?
											}
										}
										?>

										</tbody>
									</table>
								</div>
							</td>
						</tr>

						<tr height="45">
							<th>실측사이즈 차이</th>
							<td colspan="3">
							<?

							?>
								<ul class="realsize">
									<li rel="-10" <?if($realsize_dif=="-10")echo"class='on'";?> >-10</li>
									<li rel="-8" <?if($realsize_dif=="-8")echo"class='on'";?> >-8</li>
									<li rel="-5" <?if($realsize_dif=="-5")echo"class='on'";?> >-5</li>
									<li rel="-4" <?if($realsize_dif=="-4")echo"class='on'";?> >-4</li>
									<li rel="-3" <?if($realsize_dif=="-3")echo"class='on'";?> >-3</li>
									<li rel="-2" <?if($realsize_dif=="-2")echo"class='on'";?> >-2</li>
									<li rel="-1" <?if($realsize_dif=="-1")echo"class='on'";?> >-1</li>
									<li rel="0"  <?if($realsize_dif=="0")echo"class='on'";?> >0</li>
									<li rel="1" <?if($realsize_dif=="1")echo"class='on'";?> >1</li>
									<li rel="2" <?if($realsize_dif=="2")echo"class='on'";?> >2</li>
									<li rel="3" <?if($realsize_dif=="3")echo"class='on'";?> >3</li>
									<li rel="4" <?if($realsize_dif=="4")echo"class='on'";?> >4</li>
									<li rel="5" <?if($realsize_dif=="5")echo"class='on'";?> >5</li>
									<li rel="8" <?if($realsize_dif=="8")echo"class='on'";?> >8</li>
									<li rel="10" class="last  <?if($realsize_dif=="10")echo"on";?> ">10</li>
								</ul>
							</td>
						</tr>


						<tr height="45">
							<th>실측 제품사이즈</th>
							<td colspan="3">
								<select name="real_size_code" >
									<option value=""  <?if($real_size_code=="")echo"selected=selected";?>  >실측 제품 사이즈</option>
								</select>
							</td>
						</tr>

						<tr height="45">
							<th>제품 무게</th>
							<td colspan="3">
								<input type="text" name="item_weight" id="item_weight" value="<?=$item_weight?>" class="onlynum" style="text-align:right;" maxlength="5" /> g
							</td>
						</tr>

						<tr height="45">
							<th>사용권장시기</th>
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
								<?
								$_use_month_arr = explode("||", getCodeSlice($use_month) );
								?>

								<ul class="monthchk">
									<li rel="1" <?if( in_array("1", $_use_month_arr) ) echo "class='on'";?> >01월</li>
									<li rel="2" <?if( in_array("2", $_use_month_arr) ) echo "class='on'";?> >02월</li>
									<li rel="3" <?if( in_array("3", $_use_month_arr) ) echo "class='on'";?> >03월</li>
									<li rel="4" <?if( in_array("4", $_use_month_arr) ) echo "class='on'";?> >04월</li>
									<li rel="5" <?if( in_array("5", $_use_month_arr) ) echo "class='on'";?> >05월</li>
									<li rel="6" <?if( in_array("6", $_use_month_arr) ) echo "class='on'";?> >06월</li>
									<li rel="7" <?if( in_array("7", $_use_month_arr) ) echo "class='on'";?> >07월</li>
									<li rel="8" <?if( in_array("8", $_use_month_arr) ) echo "class='on'";?> >08월</li>
									<li rel="9" <?if( in_array("9", $_use_month_arr) ) echo "class='on'";?> >09월</li>
									<li rel="10" <?if( in_array("10", $_use_month_arr) ) echo "class='on'";?> >10월</li>
									<li rel="11" <?if( in_array("11", $_use_month_arr) ) echo "class='on'";?> >11월</li>
									<li rel="12" <?if( in_array("12", $_use_month_arr) ) echo "class='on'";?> >12월</li>
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

						<tr height="45">
							<td colspan="2">
								이미지 등록
							</td>
						</tr>

						<tr>
							<th>대표이미지</th>
							<td colspan="3">

								<input type="file" name="ufile1"  class="bbs_inputbox_pixel" style="width:500px;margin-bottom:10px" />
								<? if ($ufile1 != "") { ?><br>파일삭제:<input type=checkbox name="del_1" value='Y'><a href="/data/product/<?=$ufile1?>" class="imgpop"><?=$rfile1?></a><br><br>
								<?$imgs = get_img($ufile1,"/data/product/","200","200");?>
								<img src="<?=$imgs?>"/>
								<? } ?>

							</td>
						</tr>


						<? for ($i=2;$i<=6;$i++) { ?>
						<tr>
							<th>서브이미지 <?=$i-1?></th>
							<td colspan="3">

									<input type="file" name="ufile<?=$i?>"  class="bbs_inputbox_pixel" style="width:500px;margin-bottom:10px" />
									<? if (${"ufile".$i} != "") { ?><br>파일삭제:<input type=checkbox name="del_<?=$i?>" value='Y'><a href="/data/product/<?=${"ufile".$i}?>" class="imgpop"><?=${"rfile".$i}?></a><br><br>
									<?$imgs = get_img(${"ufile".$i},"/data/product/","200","200");?>
									<img src="<?=$imgs?>"/>
									<? } ?>

							</td>
						</tr>
						<? } ?>



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

						<tr height="45">
							<td colspan="2">
								상품 상세설명
							</td>
						</tr>

						<tr height="45">
							<td colspan="2">

								<textarea name="content" id="content" rows="10" cols="100" class="input_txt" style="width:100%; height:400px; display:none;"><?=viewSQ($content);?></textarea>

								<script type="text/javascript">
								var oEditors1 = [];

								// 추가 글꼴 목록
								//var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];

								nhn.husky.EZCreator.createInIFrame({
									oAppRef: oEditors1,
									elPlaceHolder: "content",
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

								<textarea name="caution" id="caution" rows="10" cols="100" class="input_txt" style="width:100%; height:400px; display:none;"><?=viewSQ($caution);?></textarea>

								<script type="text/javascript">
								var oEditors2 = [];

								// 추가 글꼴 목록
								//var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];

								nhn.husky.EZCreator.createInIFrame({
									oAppRef: oEditors2,
									elPlaceHolder: "caution",
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


			</div>
			</form>


			<!-- 중복체크 팝업 -->
			<div id="pooup_01" class="popup" >
				<div class="pooup_bg"></div>
				<div class="popup_con">
					<input type="hidden" name="chk_codeType" id="chk_codeType" >
					<input type="hidden" name="chk_codeCnt" id="chk_codeCnt" >
					<h2 class="tit"><span class="code_text"></span>코드 중복 체크</h2>
					<p class="text">- 고객님이 요청하신 <span class="code_text"></span>코드 중복 체크</p>
					<input type="text" name="pop_search" id="pop_search" class="box nothangul">


					<label for="" class="name_search">조회</label>
					<p class="result_text"><strong>코드</strong>를 입력하신 후 조회해주세요.</p>
					<!--
					<p class="result_text">요청하신 <strong>상품코드</strong>는 사용 <span>가능</span> 합니다.</p>
					-->
					<div class="btn_box">
						<p class="ok_btn">사용</p><span>|</span>
						<p class="close_btn">닫기</p>
					</div>
				</div>
			</div>




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


<iframe width="0" height="0" name="hiddenFrame22" id="hiddenFrame22" style="display:none;"></iframe>

<? include "../_include/_footer.php"; ?>



<!--

oEditors1.getById["info1_ko"].exec("UPDATE_CONTENTS_FIELD", []);
oEditors2.getById["info1_ko"].exec("UPDATE_CONTENTS_FIELD", []);

-->
<script type="text/javascript">

//------- 분류 수정 관련 ---------
<?
for($n = 1; $n<=4; $n++){
	if($tmp_ar[1]){
?>
var group<?=$n?> = "<?=$tmp_ar[$n]?>";
<?
	}
}
?>


if(group1 != ""){
	$("#product_group_1").val(group1);
	get_group(group1, 2);
	console.log("2");

	if(group2 != ""){
		$("#product_group_2").val(group2);
		get_group(group2, 3);
		console.log("3");

		if(group3 != ""){
			$("#product_group_3").val(group3);
			get_group(group3, 4);
			console.log("4");

			if(group4 != ""){
				$("#product_group_4").val(group4);
			}
		}
	}

}

function setGroupVal(){
	$("#product_group_1").val(group1);
	$("#product_group_2").val(group2);
	$("#product_group_3").val(group3);
	$("#product_group_4").val(group4);
}

setTimeout("setGroupVal();", 1500);



</script>

