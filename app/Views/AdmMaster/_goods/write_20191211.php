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
					<!--
					<li><a href="<?=$links?>?search_gubun=<?=$search_gubun?>&search_category=<?=$search_category?>&search_name=<?=$search_name?>&pg=<?=$pg?>" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a></li>
					-->
					<li><a href="javascript:history.go(-1);" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a></li>


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
			<form name="frm" id="frm" action="write_ok.php" method="post"  enctype="multipart/form-data" target="hiddenFrame22" > <!--  -->
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
										$fsql    = "select * from tbl_group where depth='1' and status='Y' and code_no < 2 order by onum desc, code_idx desc";
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
							<!-- <th>시즌</th>
							<td>
								<select name="goods_seoson" id="goods_seoson">
								<?foreach($_adm_season as $key => $seoson_val){?>
									<option value="<?=$key?>" <? if ($goods_seoson == $key) {echo "selected"; } ?> ><?=$seoson_val?></option>
								<?}?>
								</select>
							</td> -->
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
							<th>제조국가/제조사</th>
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

								<input type="text" name="make_co" id="make_co" value="<?=$make_co?>"  >
							</td>
							<th>쿠폰사용안함</th>
							<td>
								<!--
								<select name="reg_type" id="reg_type" >
								<?foreach($_adm_regist as $key => $regist_val){?>
									<option value="<?=$key?>" <? if ($reg_type == $key) {echo "selected"; } ?> ><?=$regist_val?></option>
								<?}?>
								</select>
								-->
								<input type="checkbox" name="nocoupon" id="nocoupon" value="Y" <? if ($nocoupon == "Y") {echo "checked=checked"; } ?> />
							</td>
							
						</tr>

						<tr height="45">
							<!-- <th>성별</th>
							<td>
								<select name="gender" id="gender" >
								<?foreach($_adm_gender as $key => $gender_val){?>
									<option value="<?=$key?>" <? if ($gender == $key) {echo "selected"; } ?> ><?=$gender_val?></option>
								<?}?>
								</select>
							</td> -->
							<!-- <th>병행수입여부</th>
							<td>
								<input type="checkbox" name="parallel" id="parallel" value="Y" <? if ($parallel == "Y") {echo "checked=checked"; } ?> > 병행수입
							</td> -->
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
							<th>노출</th>
							<td colspan="3">
								<input type="checkbox" name="goods_dis1" id="goods_dis1" value="Y" <?if($goods_dis1=="Y") echo "checked=checked";?> > <label for="goods_dis1" style="max-height:200px;margin-right:20px;">BEST</label>

								<input type="checkbox" name="goods_dis2" id="goods_dis2" value="Y" <?if($goods_dis2=="Y") echo "checked=checked";?> > <label for="goods_dis2" style="max-height:200px;margin-right:20px;">추천베스트</label>

								<input type="checkbox" name="goods_dis3" id="goods_dis3" value="Y" <?if($goods_dis3=="Y") echo "checked=checked";?> > <label for="goods_dis3" style="max-height:200px;margin-right:20px;">타임특가</label>
								<!--
								<input type="checkbox" name="goods_dis4" id="goods_dis4" value="Y" <?if($goods_dis4=="Y") echo "checked=checked";?> > <label for="goods_dis4" style="max-height:200px;margin-right:20px;">9장 DEAL</label>

								<input type="checkbox" name="goods_dis5" id="goods_dis5" value="Y" <?if($goods_dis5=="Y") echo "checked=checked";?> > <label for="goods_dis5" style="max-height:200px;margin-right:20px;">예약판매</label>
								-->
								
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
							<th>무료배송</th>
							<td colspan="3">
								<input type="checkbox" name="freeb" id="freeb" value="Y" <?if($freeb=="Y") echo "checked=checked";?> > <label for="freeb" style="max-height:200px;margin-right:20px;">사용</label>
							</td>
						</tr>

						<tr height="45">
							<th>재고</th>
							<td colspan="3">
								<input type="text" name="good_cnt" id="good_cnt" class="onlynum" value="<?=$good_cnt?>"   >
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
							<td colspan="3">
								<input type="text" name="price_mk" id="price_mk" class="onlynum" style="text-align:right;" value="<?=$price_mk?>" /> 원
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
							<th>주문최소수량</th>
							<td>
								<input type="text" name="item_min_order" id="item_min_order" class="onlynum" style="text-align:right;" value="<?=$item_min_order?>"  />
								<span>주문시 설정된 수량이상부터 주문이 가능합니다.</span>
							</td>
							<th>주문최대수량</th>
							<td>
								<input type="text" name="item_max_order" id="item_max_order" class="onlynum" style="text-align:right;" value="<?=$item_max_order?>"  />
								<!--
								<span>0으로 설정시 주문제한수량은 무제한 입니다.</span>
								-->
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

						<!-- tr height="45">
							<th>기간한정할인</th>
							<td colspan="3">
								<select name="dis_date_use" id="dis_date_use" >
									<option value="N" <? if ($dis_date_use == "N") {echo "selected"; } ?> >중지</option>
									<option value="Y" <? if ($dis_date_use == "Y") {echo "selected"; } ?> >사용</option>
								</select>
								<input type="text" name="dis_date_s" value="<?=$dis_date_s?>" class="datepicker input_txt" > ~
								<input type="text" name="dis_date_e" value="<?=$dis_date_e?>" class="datepicker input_txt" > 까지
								<input type="text" name="price_ds" value="<?=$price_ds?>" class="onlynum" style="text-align:right;" /> 원 할인적용
								<span>(설정한 기간동안 설정된 금액만큼 할인을 합니다. 기간이 끝나면 원래가격 판매됩니다)</span>
							</td -->
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
								옵션 (사용 : <input type="checkbox" name="option_YN" value="Y" <?if($option_YN=="Y")echo"checked=checked";?> />)
							</td>
						</tr>




						<tr height="45">
							<th>
								필수옵션등록
								<p style="display:block;margin-top:10px;">
									<button type="button" id="btn_add_option" class="btn_01">추가</button>
								</p>
							</th>
							<td>
								<span  style="color:red;">※ 옵션 삭제 시에 해당 옵션과 연동된 주문, 결제내역에 영향을 미치니 반드시 확인 후에 삭제바랍니다.</span>
								<div>
									<table>
										<colgroup>
											<col width="*"></col>
											<col width="25%"></col>
											<col width="25%"></col>
											<col width="15%"></col>
										</colgroup>
										<thead>
											<tr>
												<th>옵션명</th>
												<th>가격</th>
												<th>재고</th>
												<th>삭제</th>
											</tr>
										</thead>
										<tbody id="settingBody">


										<?
										

										// 옵션 조회
										$fsql3    = "select * from tbl_goods_option where option_type = 'M' and goods_code='".$goods_code."' order by idx asc ";

										$fresult3 = mysqli_query($connect, $fsql3) or die (mysqli_error($connect));
										while($frow3 = mysqli_fetch_array($fresult3)){
														
										?>

											<tr color='<?=$_tmp_color?>' size='<?=$frow2['type']?>' >
												
												<td>
													<input type='hidden' name='o_idx[]'  value='<?=$frow3['idx']?>' />
													<input type='file' name='a_file[]'  value='' style="display:none;" />
													<input type='hidden' name='option_type[]'  value='<?=$frow3['option_type']?>' />
													<input type='text' name='o_name[]' id='' value="<?=$frow3['goods_name']?>" size="70" />
												</td>
												<td>
													<input type='text' class='onlynum' name='o_price[]' id='' value="<?=$frow3['goods_price']?>" />
												</td>
												<td>
													<input type='text' class='onlynum' name='o_jaego[]' id='' value="<?=$frow3['goods_cnt']?>" />
												</td>
												<td>
													<button type="button" onclick="delOption('<?=$frow3['idx']?>',this)" >삭제</button>
												</td>
											</tr>

										<?
										}
										?>

										</tbody>
									</table>
								</div>
							</td>
						</tr>


						<tr height="45">
							<th>
								추가옵션등록
								<p style="display:block;margin-top:10px;">
									<button type="button" id="btn_add_option2" class="btn_01">추가</button>
								</p>
							</th>
							<td>
								<span  style="color:red;">※ 옵션 삭제 시에 해당 옵션과 연동된 주문, 결제내역에 영향을 미치니 반드시 확인 후에 삭제바랍니다.</span>
								<div>
									<table>
										<colgroup>
											<col width="15%"></col>
											<col width="*"></col>
											<col width="25%"></col>
											<col width="25%"></col>
											<col width="15%"></col>
										</colgroup>
										<thead>
											<tr>
												<th>이미지</th>
												<th>옵션명</th>
												<th>가격</th>
												<th>재고</th>
												<th>삭제</th>
											</tr>
										</thead>
										<tbody id="settingBody2">


										<?
										

										// 옵션 조회
										$fsql3    = "select * from tbl_goods_option where option_type = 'S' and  goods_code='".$goods_code."' order by idx asc ";

										$fresult3 = mysqli_query($connect, $fsql3) or die (mysqli_error($connect));
										while($frow3 = mysqli_fetch_array($fresult3)){
														
										?>

											<tr color='<?=$_tmp_color?>' size='<?=$frow2['type']?>' >
												<td>
													<input type='file' name='a_file[]'  value='' />
													<? if ($frow3['afile'] != "") { ?><br>파일삭제:<input type=checkbox name="del_1" value='Y'><a href="/data/product/<?=$frow3['bfile']?>" class="imgpop"><?=$frow3['afile']?></a><br><br>
													<?$imgs = get_img($frow3['bfile'],"/data/product/","150","150");?>
													<img src="<?=$imgs?>"/>
													<? } ?>
												</td>
												<td>
													<input type='hidden' name='o_idx[]'  value='<?=$frow3['idx']?>' />
													<input type='hidden' name='option_type[]'  value='<?=$frow3['option_type']?>' />
													<input type='text' name='o_name[]' id='' value="<?=$frow3['goods_name']?>" size="70" />
												</td>
												<td>
													<input type='text' class='onlynum' name='o_price[]' id='' value="<?=$frow3['goods_price']?>" />
												</td>
												<td>
													<input type='text' class='onlynum' name='o_jaego[]' id='' value="<?=$frow3['goods_cnt']?>" />
												</td>
												<td>
													<button type="button" onclick="delOption('<?=$frow3['idx']?>',this)" >삭제</button>
												</td>
											</tr>

										<?
										}
										?>

										</tbody>
									</table>
								</div>
							</td>
						</tr>




						

						<tr height="45">
							<th>제품 무게</th>
							<td colspan="3">
								<input type="text" name="item_weight" id="item_weight" value="<?=$item_weight?>" class="onlynum" style="text-align:right;" maxlength="5" /> g
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
							<th>대표이미지(600X600)</th>
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
							<th>서브이미지<?=$i-1?>(600X600) </th>
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
								배송/교환/반품안내
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
						<!--
						<a href="<?=$links?>?search_gubun=<?=$search_gubun?>&search_category=<?=$search_category?>&search_name=<?=$search_name?>&pg=<?=$pg?>" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a>
						-->
						<a href="javascript:history.go(-1);" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a>
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

