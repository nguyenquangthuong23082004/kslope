<? include "../_include/_header.php"; ?>
<!-- <script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js"></script> -->
<script type="text/javascript" src="./write.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="/summernote/upload.js"></script>
<?
$g_idx = updateSQ($_GET["g_idx"]);
$pg = updateSQ($_GET["pg"]);
$search_name = updateSQ($_GET["search_name"]);
$search_category = updateSQ($_GET["search_category"]);
$s_product_code_1 = updateSQ($_GET["s_product_code_1"]);
$s_product_code_2 = updateSQ($_GET["s_product_code_2"]);

if ($g_idx) {
    $sql = " select * from tbl_goods where g_idx = '" . $g_idx . "'";
    $result = mysqli_query($connect, $sql) or die (mysql_error($connect));
    $row = mysqli_fetch_object($result);

    foreach ($row as $keys => $vals) {
        //echo $keys . " => " . $vals . "<br/>";
        ${$keys} = $vals;

    }


}

$titleStr = "상품정보 수정";
$links = "list.php";

?>

<style>
    div.listBottom table.listTable tbody td button.btn_03 {
        display: inline-block;
        width: 70px;
        height: 25px;
        margin: 0 5px;
        border: 1px solid rgb(204, 204, 204);
    }
    .add_row {
        width: 30px;
        height: 30px;
        background: linear-gradient(90deg, #009BD2 1%, #3AC2F5 100%);
        color: #fff;
        margin-left: 15px;
        font-size: 16px;
    }

    .del_row {
        width: 30px;
        height: 30px;
        background: #d03a3e;
        color: #fff;
        margin-left: 15px;
        font-size: 16px;
    }
</style>
<div class="page-heading mb-4">

    <div class="d-flex justify-content-between align-items-center">
        <header class="d-block d-xl-none pb-2">
            <a href="#" class="d-block burger-btn d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <h4 class="text-center"><?= $titleStr ?></h4>
    </div>
</div>
<div id="container" class="gnb_goods">
    <div id="print_this"><!-- 인쇄영역 시작 //-->

        <header id="headerContainer">
            <div class="inner">
                <div class="menus">
                    <ul>
                        <!--
					<li><a href="<?= $links ?>?search_gubun=<?= $search_gubun ?>&search_category=<?= $search_category ?>&search_name=<?= $search_name ?>&pg=<?= $pg ?>" class="btn btn-secondary"><i class="bi bi-list"></i><span class="txt">리스트</span></a></li>
					-->
                        <li><a href="javascript:history.go(-1);" class="btn btn-secondary"><i
                                        class="bi bi-list"></i><span
                                        class="txt">리스트</span></a></li>


                        <? if ($g_idx) { ?>
                            <li><a href="javascript:prod_copy('<?=$g_idx?>')" class="btn btn-success"><i class="bi bi-gear"></i><span
                                            class="txt">상품복사</span></a></li>
                            <li><a href="javascript:send_it()" class="btn btn-primary"><i class="bi bi-gear"></i><span
                            class="txt">수정</span></a></li>
                            <!-- <li><a href="javascript:del_it()" class="btn btn-danger"><i class="bi bi-trash"></i><span
                                            class="txt">삭제</span></a></li> -->
                        <? } else { ?>
                            <li><a href="javascript:send_it()" class="btn btn-primary"><i class="bi bi-gear"></i><span
                                            class="txt">등록</span></a></li>
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
                <form name="frm" id="frm" action="write_ok.php" method="post" enctype="multipart/form-data"
                      target="hiddenFrame22"> <!--  -->
                    <!-- 상품 고유 번호 -->
                    <input type="hidden" name="g_idx" id="g_idx" value='<?= $g_idx ?>'/>
                    <!-- 상품 카테고리 -->
                    <input type="hidden" name="product_code" id="product_code" value='<?= $product_code ?>'/>

                    <!-- 상품 분류 -->
                    <input type="hidden" name="product_group" id="product_group" value='<?= $product_group ?>'>

                    <!-- 대표 색상 -->
                    <input type="hidden" name="product_dbcolor" id="product_dbcolor" value='<?= $product_dbcolor ?>'>
                    <!-- 상품 색상 -->
                    <input type="hidden" name="product_color" id="product_color" value='<?= $product_color ?>'/>
                    <!-- 상품 사이즈 -->
                    <input type="hidden" name="product_size" id="product_size" value='<?= $product_size ?>'/>
                    <!-- 상품 옵션 -->
                    <input type="hidden" name="product_option" id="product_option" value='<?= $product_option ?>'
                           style="width:500px;">
                    <!-- 실측사이즈 차이 -->
                    <? if ($realsize_dif == "") $realsize_dif = 0; ?>
                    <input type="hidden" name="realsize_dif" id="realsize_dif" value='<?= $realsize_dif ?>'>
                    <!-- 사용권장시기 -->
                    <input type="hidden" name="use_month" id="use_month" value='<?= $use_month ?>'>
                    <!-- db에 있는 goods_code -->
                    <input type="hidden" name="old_goods_code" id="old_goods_code" value='<?= $goods_code ?>'>


                    <div class="listBottom">
                        <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail"
                               style="table-layout:fixed;">
                            <caption>
                            </caption>
                            <colgroup>
                                <col width="10%"/>
                                <col width="40%"/>
                                <col width="10%"/>
                                <col width="40%"/>
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

                                    <select id="product_code_1" name="product_code_1" class="input_select"
                                            onchange="javascript:get_code(this.value, 2)">
                                        <option value="">1차분류</option>
                                        <?
                                        $fsql = "select * from tbl_code where depth='1' and status='Y' order by onum desc, code_idx desc";
                                        $fresult = mysqli_query($connect, $fsql) or die (mysql_error());
                                        while ($frow = mysqli_fetch_array($fresult)) {
                                            $status_txt = "";
                                            if ($frow["status"] == "Y") {
                                                $status_txt = "";
                                            } elseif ($frow["status"] == "N") {
                                                $status_txt = "[삭제]";
                                            } elseif ($frow["status"] == "C") {
                                                $status_txt = "[마감]";
                                            }

                                            ?>
                                            <option value="<?= $frow["code_no"] ?>"><?= $frow["code_name"] ?> <?= $status_txt ?></option>
                                        <? } ?>

                                    </select>
                                    <select id="product_code_2" name="product_code_2" class="input_select"
                                            onchange="javascript:get_code(this.value, 3)">
                                        <option value="">2차분류</option>
                                    </select>
                                    <!--
                                    <select id="product_code_3" name="product_code_3" class="input_select" onchange="javascript:get_code(this.value, 4)" >
                                        <option value="">3차분류</option>
                                    </select>
                                    <select id="product_code_4" name="product_code_4" class="input_select" >
                                        <option value="">4차분류</option>
                                    </select>
                                -->

                                    <button type="button" id="btn_reg_cate" class="btn_01">등록</button>
                                </td>

                            </tr>
                            <?
                            $_product_code_arr = explode("||", getCodeSlice($product_code));
                            ?>
                            <tr height="48">
                                <th>등록된 카테고리</th>
                                <td colspan="3">
                                    <ul id="reg_cate">
                                        <?
                                        if ($product_code) {
                                            foreach ($_product_code_arr as $_tmp_code) {
                                                ?>

                                                <li>[<?= $_tmp_code ?>] <?= get_cate_text($_tmp_code) ?> <span
                                                            onclick="delCategory('<?= $_tmp_code ?>', this);">삭제</span>
                                                </li>
                                                <?
                                            }
                                        }
                                        ?>
                                    </ul>
                                </td>
                            </tr>

                            <tr height="45">
                                <th>상품코드(모델명)</th>
                                <td colspan='3'>
                                     <input type="text" name="goods_code" id="goods_code" 
                                        value="<?= $goods_code ?>"
                                        <?= strpos($goods_code, '[복사]') !== false ? '' : 'readonly="readonly"' ?>
                                        class="text" style="width:200px">
                                    <? if ($g_idx == "") { ?>
                                        <button type="button" class="btn_01" onclick="fn_pop('code');">코드입력</button>
                                    <? } else { ?>
                                        <span style="color:red;">상품코드는 수정이 불가능합니다.</span>
                                    <? } ?>

                                </td>
                            </tr>
                            <tr height="45">
                                <th>상품코드(홈페이지)</th>
                                <td colspan='3'>
                                    <input type="text" name="goods_code_show" id="goods_code_show"
                                           value='<?= $goods_code_show ?>' class='text' style='width:200px'>
                                    <span style="color:blue;">홈페이지에서 보여주는 상품코드 입니다.(수정가능)</span>
                                </td>
                            </tr>
                            <!--                            <tr height="45">-->
                            <!--                                <th>제품 유형</th>-->
                            <!--                                <td colspan='3'>-->
                            <!--                                    <select name="product_type" id="product_type">-->
                            <!--                                        --><?php
                            //                                        $sql_pa = "select * from tbl_third_party where depth = 1 and status = 'Y' order by onum";
                            //                                        $result_pa = mysqli_query($connect, $sql_pa) or die (mysql_error());
                            //                                        while ($row_pa = mysqli_fetch_array($result_pa)) {
                            //                                            ?>
                            <!--                                            <option --><?php //= $row_pa['code_no'] == $product_type ? "selected" : "" ?>
                            <!--                                                    value="-->
                            <?php //= $row_pa['code_no'] ?><!--">--><?php //= $row_pa['code_name'] ?><!--</option>-->
                            <!--                                        --><?php //} ?>
                            <!--                                    </select>-->
                            <!--                                </td>-->
                            <!--                            </tr>-->

                            <tr height="45">
                                <th>상품명</th>
                                <td>
                                    <input type="text" name="goods_name_front" value="<?= $goods_name_front ?>"
                                           class="text"
                                           style="width:300px" maxlength="50"/>
                                </td>
                                <th>간략설명</th>
                                <td>
                                    <input type="text" name="goods_name_back" value="<?= $goods_name_back ?>"
                                           class="text"
                                           style="width:300px" maxlength="50"/>
                                </td>
                            </tr>

                            <tr height=45>
                                <th>프로모션 안내</th>
                                <td colspan='3'>
                                    <input type="text" name="promotion_txt1" id="promotion_txt1" value="<?= $promotion_txt1?>" class="text"
                                           style="width:90%"> <br>
                                    <textarea name="promotion_txt2" id="promotion_txt2" style="width:90%;height:100px; margin-top: 10px"><?= $promotion_txt2?></textarea>
                                </td>
                            </tr>


                            <!-- <tr height=45>
                                <th>컬러</th>
                                <td colspan='3'>
                                   <?php
                                        $sql = "SELECT code_no, code_name FROM tbl_code 
                                                WHERE parent_code_no = 11 AND status = 'Y' 
                                                ORDER BY onum DESC";
                                        $res = mysqli_query($connect, $sql);

                                        $selected = explode(',', $goods_color);

                                        while ($row = mysqli_fetch_assoc($res)) {
                                            $checked = in_array($row['code_no'], $selected) ? 'checked' : '';
                                        ?>
                                            <label style="margin-right:15px;">
                                                <input type="checkbox" name="goods_color[]" 
                                                    value="<?= $row['code_no'] ?>" <?= $checked?>>
                                                <?= $row['code_name'] ?>
                                            </label>
                                        <?php
                                        }
                                        ?>


                                </td>

                            </tr> -->
                                <?php
                                $color_saved = [];
                                $color_notes = [];

                                $sql = "SELECT color, name_color 
                                        FROM tbl_goods_color 
                                        WHERE g_idx = '$g_idx'
                                        ORDER BY idx ASC";

                                $res = mysqli_query($connect, $sql);

                                while($row = mysqli_fetch_assoc($res)){
                                    $color_saved[] = $row['color'];            
                                    $color_notes[$row['color']] = $row['name_color']; 
                                }
                                ?>

                            <tr height="45">
                                <th>컬러</th>
                                <td colspan="3">

                                    <input type="color" id="colorPicker" value="#000000" style="height: 30px">
                                    <button type="button" onclick="addColor()" style="color: #fff;background: #4F728A;border: 1px solid #2b3f4c; padding: 5px 10px; line-height: 1.5">색상 추가</button>

                                    <hr>

                                    <div id="selectedColors"></div>

                                    <input type="hidden" name="goods_color" id="goods_color">

                                </td>
                            </tr>

                            <script>
                            let colorList = <?php echo json_encode($color_saved); ?>;
                            let colorNotes = <?php echo json_encode($color_notes); ?>;

                            function addColor() {
                                let color = document.getElementById("colorPicker").value;

                                if (colorList.includes(color)) {
                                    alert("색상이 이미 추가되었습니다!");
                                    return;
                                }

                                colorList.forEach(c => {
                                    let input = document.querySelector(`input[name='color_note_${c.replace('#','')}']`);
                                    if (input) {
                                        colorNotes[c] = input.value;
                                    }
                                });

                                colorList.push(color);
                                colorNotes[color] = "";

                                renderColors();
                            }

                            function renderColors() {
                                let area = document.getElementById("selectedColors");
                                area.innerHTML = "";

                                colorList.forEach(color => {
                                    let note = colorNotes[color] ?? "";

                                    area.innerHTML += `
                                        <div style="margin-bottom:10px; border:1px solid #ccc; padding:10px; margin-top: 10px">
                                            <div style="display:flex; align-items:center;">
                                                <div style="width:25px; height:25px; background:${color}; border:1px solid #000;"></div>
                                                <span style="margin-left:10px;">${color}</span>

                                                <button type="button"
                                                    style="margin-left:15px; padding:5px 7px; color:#fff; background:#d03a3e; border:1px solid #ba1212; font-size:12px;"
                                                    onclick="removeColor('${color}')">삭제</button>
                                            </div>

                                            <input type="text" 
                                                name="color_note_${color.replace('#','')}" 
                                                value="${note}"
                                                placeholder="색상 코드"
                                                style="margin-top:5px; width:250px;">
                                        </div>
                                    `;
                                });

                                document.getElementById("goods_color").value = colorList.join(",");
                            }

                            function removeColor(color) {
                                colorList = colorList.filter(c => c !== color);
                                delete colorNotes[color];
                                renderColors();
                            }

                            renderColors();
                            </script>



                            <tr height="45">
                                <th>검색어</th>
                                <td colspan="3">
                                    <input type="text" name="goods_keyword" id="goods_keyword"
                                           value="<?= $goods_keyword ?>"
                                           class="text" style="width:90%;" maxlength="100"/><br/>
                                    <span style="color:red;">검색어는 콤마(,)로 구분하셔서 입력하세요. 입력예)자켓,방풍자켓,기능성자켓</span>
                                </td>
                            </tr>

                            <!-- <tr height='45'>
                                <th>제품로고 선택</th>
                                <td colspan='3'>
                                    <?
                                    $i_logo_sql = "
									select * from tbl_item_logo
										where status = 'Y'
										order by onum desc, code_no desc
								";
                                    $i_logo_result = mysqli_query($connect, $i_logo_sql);
                                    $num = 1;
                                    while ($i_logo_row = mysqli_fetch_array($i_logo_result)) {
                                        ?>
                                        <input type="checkbox" name="item_logo" id="item_logo<?= $num ?>"
                                               value="<?= $i_logo_row['code_no'] ?>" <? if ($item_logo == $i_logo_row['code_no']) echo "checked=checked"; ?> >
                                        <label for="item_logo<?= $num ?>"
                                               style="max-height:200px;margin-right:20px;"><?= $i_logo_row['code_name'] ?></label>
                                        <?
                                        $num = $num + 1;
                                    }
                                    ?>
                                </td>
                            </tr> -->

                            <tr height="45">
                                <th>레드벳지</th>
                                <td colspan='3'>
                                    <input type="text" name="badge1" id="badge_red" value='<?= $badge1 ?>' class="text"
                                           style="width:300px;" maxlength="50">
                                </td>
                            </tr>
                            <tr height="45">
                                <th>블루벳지</th>
                                <td colspan='3'>
                                    <input type="text" name="badge2" id="badge_blue" value='<?= $badge2 ?>' class="text"
                                           style="width:300px;" maxlength="50">
                                </td>
                            </tr>

                            <tr height="45">
                                <!-- <th>성별</th>
							<td>
								<select name="gender" id="gender" >
								<? foreach ($_adm_gender as $key => $gender_val) { ?>
									<option value="<?= $key ?>" <? if ($gender == $key) {
                                    echo "selected";
                                } ?> ><?= $gender_val ?></option>
								<? } ?>
								</select>
							</td> -->
                                <!-- <th>병행수입여부</th>
							<td>
								<input type="checkbox" name="parallel" id="parallel" value="Y" <? if ($parallel == "Y") {
                                    echo "checked=checked";
                                } ?> > 병행수입
							</td> -->
                            </tr>


                            <!-- <tr height="45">
							<th>아이콘</th>
							<td colspan="3">
								<?
                            $_icon_arr = explode("||", getCodeSlice($goods_icon));
                            $fsql = "select * from tbl_icon where status='Y' order by onum asc, code_idx desc";
                            $fresult = mysqli_query($connect, $fsql) or die (mysql_error());
                            while ($frow = mysqli_fetch_array($fresult)) {

                                ?>
						
						
										<input type="checkbox" name="goods_icon[]" id="goods_icon<?= $frow["code_no"] ?>" value="<?= $frow["code_no"] ?>" <? if (in_array($frow["code_no"], $_icon_arr)) echo "checked=checked"; ?> > <label for="goods_icon<?= $frow["code_no"] ?>"><img src="/data/icon/<?= $frow["iconimg"] ?>" style="max-height:200px;margin-right:20px;"></label>
								<? } ?>
							</td>
						
						</tr> -->

                            <tr height="45">
                                <th>베스트코웨이 노출</th>
                                <td colspan="3">
                                    <?
                                    $dis_sql = "
								select * from tbl_code 
									where status = 'Y' 
									 and bestYN = 'Y'
									 and parent_code_no = '0'
									order by onum desc, code_idx desc
							";
                                    $dis_result = mysqli_query($connect, $dis_sql);
                                    $num = 1;
                                    while ($dis_row = mysqli_fetch_array($dis_result)) {
                                        ?>
                                        <input type="checkbox" name="goods_dis1" id="goods_dis<?= $num ?>"
                                               value="<?= $dis_row['code_no'] ?>" <? if ($goods_dis1 == $dis_row['code_no']) echo "checked=checked"; ?> >
                                        <label for="goods_dis<?= $num ?>"
                                               style="max-height:200px;margin-right:20px;"><?= $dis_row['code_name'] ?></label>
                                        <?
                                        $num = $num + 1;
                                    }
                                    ?>
                                    <!-- <input type="checkbox" name="goods_dis2" id="goods_dis2" value="Y" <? if ($goods_dis2 == "Y") echo "checked=checked"; ?> > <label for="goods_dis2" style="max-height:200px;margin-right:20px;">추천베스트</label> -->

                                    <!-- <input type="checkbox" name="goods_dis3" id="goods_dis3" value="Y" <? if ($goods_dis3 == "Y") echo "checked=checked"; ?> > <label for="goods_dis3" style="max-height:200px;margin-right:20px;">타임특가</label> -->
                                    <!--
								<input type="checkbox" name="goods_dis4" id="goods_dis4" value="Y" <? if ($goods_dis4 == "Y") echo "checked=checked"; ?> > <label for="goods_dis4" style="max-height:200px;margin-right:20px;">9장 DEAL</label>

								<input type="checkbox" name="goods_dis5" id="goods_dis5" value="Y" <? if ($goods_dis5 == "Y") echo "checked=checked"; ?> > <label for="goods_dis5" style="max-height:200px;margin-right:20px;">예약판매</label>
								-->

                                </td>

                            </tr>

                            <tr height="45">
                                <?
                                $_icon_arr = explode("||", getCodeSlice($goods_icon));
                                ?>
                                <th>아이콘</th>
                                <td colspan='3'>
                                    <input type="checkbox" name="goods_icon[]" id="icon1"
                                           value='N' <?= (in_array('N', $_icon_arr) == true ? "checked" : "") ?>>
                                    <label for="icon1" style="max-height:200px;margin-right:20px;">NEW</label>
                                    <input type="checkbox" name="goods_icon[]" id="icon2"
                                           value='P' <?= (in_array('P', $_icon_arr) == true ? "checked" : "") ?>>
                                    <label for="icon2" style="max-height:200px;margin-right:20px;">인기</label>
                                </td>
                            </tr>

                            <tr height="45">
                                <th>판매상태결정</th>
                                <td colspan="3">
                                    <select name="item_state" id="item_state">
                                        <option value="sale" <? if ($item_state == "sale") {
                                            echo "selected";
                                        } ?> >판매중
                                        </option>
                                        <option value="stop" <? if ($item_state == "stop") {
                                            echo "selected";
                                        } ?> >판매중지
                                        </option>
                                        <!-- <option value="plan" <? if ($item_state == "plan") {
                                            echo "selected";
                                        } ?> >등록예정</option> -->
                                    </select>
                                </td>
                            </tr>


                            <!-- <tr height="45">
                                <th>특징요약</th>
                                <td colspan="3">
								<textarea name="md_comment" id="md_comment"
                                          style="width:90%;height:150px;"><?= $md_comment ?></textarea>
                                    <p style="color:red;">슬러쉬( / ) 기호로 구분 표시됩니다. ex)검정/파랑/노랑 </p>
                                </td>
                            </tr> -->


                            <!-- <tr height="45">
							<th>무료배송</th>
							<td colspan="3">
								<input type="checkbox" name="freeb" id="freeb" value="Y" <? if ($freeb == "Y") echo "checked=checked"; ?> > <label for="freeb" style="max-height:200px;margin-right:20px;">사용</label>
							</td>
						</tr>
						
						<tr height="45">
							<th>재고</th>
							<td colspan="3">
								<input type="text" name="good_cnt" id="good_cnt" class="onlynum" value="<?= $good_cnt ?>"   >
							</td>
						</tr> -->


                            <tr height="45">
                                <th>관리자메모</th>
                                <td colspan="3">
								<textarea name="admin_memo" id="admin_memo"
                                          style="width:90%;height:100px;"><?= $admin_memo ?></textarea>
                                </td>
                            </tr>

                            </tbody>
                        </table>


                        <? /*?>
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
			<?*/ ?>


                        <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail"
                               style="margin-top:50px;">
                            <caption>
                            </caption>
                            <colgroup>
                                <col width="10%"/>
                                <col width="40%"/>
                                <col width="10%"/>
                                <col width="40%"/>
                            </colgroup>
                            <tbody>
                            <tr height="45">
                               <th colspan='2' style="background: #fff; color: #757575">렌탄가격</th>
                               <th colspan='2' style="background: #fff; color: #757575">일시불 가격</th>
                            </tr>
                            <tr height="45">
                                <th>리스트 가격</th>
                                <td>
                                    <input type="text" name="price_mk" id="price_mk" class="onlynum"
                                           style="text-align:right;" value="<?= $price_mk ?>"/> 원
                                </td>

                                <th>리스트 가격</th>
                                <td>
                                    <input type="text" name="price_mk_buy" id="price_mk_buy" class="onlynum"
                                           style="text-align:right;" value="<?= $price_mk_buy ?>"/> 원
                                </td>

                            </tr>
                           
                            <tr height="45">
                                <th>프로모션</th>
                                <td>
                                    <input type="text" name="price_dc" id="price_dc" class="onlynum"
                                           style="text-align:right;" value="<?= $price_dc ?>"/> 원
                                </td>

                                <th>프로모션</th>
                                <td>
                                    <input type="text" name="price_dc_buy" id="price_dc_buy" class="onlynum"
                                           style="text-align:right;" value="<?= $price_dc_buy ?>"/> 원
                                </td>

                            </tr>

                             <tr height="45">
                                <th>리스트 제휴카드 가격</th>
                                <td>
                                    <input type="text" name="price_se" id="price_se" class="onlynum"
                                           style="text-align:right;" value="<?= $price_se ?>"/> 원
                                </td>

                                <th>리스트 제휴카드 가격</th>
                                <td>
                                    <input type="text" name="price_se_buy" id="price_se_buy" class="onlynum"
                                           style="text-align:right;" value="<?= $price_se_buy ?>"/> 원
                                </td>

                            </tr>
                            </tbody>
                        </table>

                        <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail"
                               style="margin-top:50px;">
                            <caption>
                            </caption>
                            <colgroup>
                                <col width="10%"/>
                                <col width="90%"/>
                            </colgroup>
                            <tbody>
                            <tr height="45">
                                <th>기본 약정값</th>
                                <td>
                                    <select name='default_period' id='default_period'>
                                        <option value="">선택</option>
                                        <?
                                        $default_period_sql = "select * from tbl_period where status = 'Y' order by onum desc, code_idx desc";
                                        $default_period_result = mysqli_query($connect, $default_period_sql);
                                        while ($default_period_row = mysqli_fetch_array($default_period_result)) {
                                            ?>
                                            <option value="<?= $default_period_row['code_no'] ?>" <?= ($default_period == $default_period_row['code_no'] ? "selected" : "") ?>><?= $default_period_row['code_name'] ?></option>
                                        <? } ?>
                                    </select>
                                </td>
                            </tr>
                            <!-- <tr height="45">
                                <th>기본 관리유형</th>
                                <td>
                                    <?php ?>
                                    <input type="radio" name="default_type" id="default_type1"
                                           value='self' <?= ($default_type == 'self' || $default_type == '' ? "checked" : "") ?>><label
                                            for="default_type1">셀프관리</label>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="default_type" id="default_type2"
                                           value='visit' <?= ($default_type == 'visit' ? "checked" : "") ?>><label
                                            for="default_type2">방문관리</label>
                                </td>
                            </tr> -->

                            <tr height="45">
                                <th>총계약기간</th>
                                <td>
                                    <input type="text" name="total_p_txt" id="total_p_txt" value="<?= $total_p_txt ?>">
                                </td>
                            </tr>
                            <tr height="45">
                                <th>추가정보</th>
                                <td>
                                    <?php 

                                    $goods_additional_arr = [];

                                    if (!empty($goods_additional)) {
                                        $goods_additional_arr = explode(",", $goods_additional);
                                    }


                                        $child_map = [];

                                        $child_sql = "
                                            SELECT *
                                            FROM tbl_code
                                            WHERE status = 'Y'
                                            AND parent_code_no IN (
                                                SELECT code_no
                                                FROM tbl_code
                                                WHERE parent_code_no = '14'
                                            )
                                            ORDER BY parent_code_no, onum DESC, code_idx DESC
                                        ";

                                        $child_res = mysqli_query($connect, $child_sql);

                                        while ($row = mysqli_fetch_array($child_res)) {
                                            $child_map[$row['parent_code_no']][] = $row;
                                        }

                                        $parent_sql = "
                                            SELECT *
                                            FROM tbl_code
                                            WHERE status = 'Y'
                                            AND parent_code_no = '14'
                                            ORDER BY onum DESC, code_idx DESC
                                        ";
                                        $parent_res = mysqli_query($connect, $parent_sql);

                                    ?>

                                    <?php while ($parent = mysqli_fetch_array($parent_res)) {
                                        $pval = $parent['code_no'];
                                        $p_checked = in_array($pval, $goods_additional_arr);
                                    ?>
                                        <label style="margin-right:15px;">
                                            <input type="checkbox"
                                                name="goods_additional[]"
                                                value="<?= $pval ?>"
                                                <?= $p_checked ? 'checked' : '' ?>
                                                onchange="toggleChild(<?= $pval ?>)">
                                            <?= $parent['code_name'] ?>
                                        </label>

                                        <div id="child_<?= $pval ?>"
                                            style="margin-left:25px;<?= $p_checked ? '' : 'display:none;' ?>">

                                            <?php if (!empty($child_map[$pval])) {
                                                foreach ($child_map[$pval] as $child) {
                                                    $cval = $child['code_no'];
                                                    $c_checked = in_array($cval, $goods_additional_arr);
                                            ?>
                                                    <label style="margin-right:15px;">
                                                        <input type="checkbox"
                                                            name="goods_additional[]"
                                                            value="<?= $cval ?>"
                                                            <?= $c_checked ? 'checked' : '' ?>>
                                                        <?= $child['code_name'] ?>
                                                    </label>
                                            <?php
                                                }
                                            } ?>
                                        </div>
                                        <br>
                                    <?php } ?>
                                </td>
                            </tr>

                            <script>
                            function toggleChild(parentCode) {
                                const box = document.querySelector(
                                    'input[type="checkbox"][value="' + parentCode + '"]'
                                );
                                const childDiv = document.getElementById("child_" + parentCode);

                                if (box.checked) {
                                    childDiv.style.display = "block";
                                } else {
                                    childDiv.style.display = "none";
                                    childDiv.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                                        cb.checked = false;
                                    });
                                }
                            }
                            </script>


                            <tr height="45" style="display: none">
                                <th>탑퍼옵션</th>
                                <td>
                                    <?php 
                                    
                                    $topper_sql = "
                                        SELECT * FROM tbl_code
                                        WHERE status = 'Y'
                                        AND parent_code_no = '1403'
                                        ORDER BY onum DESC, code_idx DESC
                                    ";
                                    $topper_result = mysqli_query($connect, $topper_sql);
                                     ?>
                                    <?php                                     
                                        while ($topper_row = mysqli_fetch_array($topper_result)) {
                                        $topper_value = $topper_row['code_no'];
                                    ?>
                                    <input type="radio" name="goods_topper" id="goods_topper_<?= $topper_value?>"
                                           value='<?= $topper_value?>' <?= ($goods_topper == $topper_value ? "checked" : "") ?>><label
                                            for="goods_topper_<?= $topper_value?>"><?= $topper_row['code_name']?></label>&nbsp;&nbsp;&nbsp;
                                    <?php }?>
                                </td>
                            </tr>
                            <tr height="45">
                                <th>관리유형</th>
                               <?php
                                    $type_array = explode("||", substr($type, 1, -1));

                                    $type_sql = "
                                        SELECT * FROM tbl_code
                                        WHERE status = 'Y'
                                        AND parent_code_no = '13'
                                        ORDER BY onum DESC, code_idx DESC
                                    ";
                                    $type_result = mysqli_query($connect, $type_sql);

                                    ?>
                                        <td>
                                            <?php                                     
                                            while ($type_row = mysqli_fetch_array($type_result)) {
                                            $type_value = $type_row['code_no'];
                                            $checked = in_array($type_value, $type_array) ? "checked" : "";
                                            ?>
                                            <input type="checkbox"
                                                name="type_chk[]"
                                                id="type_<?= $type_value ?>"
                                                data-type="<?= $type_value ?>"
                                                value="<?= $type_value ?>"
                                                <?= $checked ?>  class="type_selector">
                                            <label for="type_<?= $type_value ?>">
                                                <?= $type_row['code_name'] ?>
                                            </label>
                                            &nbsp;&nbsp;&nbsp;
                                            <?php } ?>
                                        </td>
                            </tr>
                            <?php
                                $type_res = mysqli_query($connect, "
                                    SELECT * FROM tbl_code 
                                    WHERE status='Y' AND parent_code_no='13'
                                    ORDER BY onum DESC, code_idx DESC
                                ");

                                while ($type_row = mysqli_fetch_array($type_res)) {
                                    $typeName  = $type_row['code_no'];    
                                    $typeLabel = $type_row['code_name']; 
                                ?>
                                <tr class="<?= $typeName ?>_wrap type_block" data-type="<?= $typeName ?>" style="display:none;">
                                    <th><?= $typeLabel ?></th>
                                    <td>
                                        <div class="<?= $typeName ?>_table">
                                            <table>
                                                <colgroup>
                                                    <col width="10%"/>
                                                    <col width="90%"/>
                                                </colgroup>

                                                <tr>
                                                    <th><?= $typeLabel ?> text</th>
                                                    <?php 
                                                        $sqlT = mysqli_query($connect,"
                                                            SELECT * FROM tbl_goods_type_text 
                                                            WHERE g_code = '$goods_code' 
                                                            AND type = '$typeName'
                                                        ");

                                                        $txt1 = "";
                                                        $txt2 = "";

                                                        if($rowT = mysqli_fetch_array($sqlT)){
                                                            $txt1 = $rowT['txt1'];
                                                            $txt2 = $rowT['txt2'];
                                                        }
                                                    ?>
                                                    <td>
                                                        <input type="text" 
                                                            name="<?= $typeName ?>_txt1"
                                                            id="<?= $typeName ?>_txt1"
                                                            value="<?= htmlspecialchars($txt1) ?>"
                                                            style="width:450px;margin-bottom:5px"><br>

                                                        <input type="text"
                                                            name="<?= $typeName ?>_txt2"
                                                            id="<?= $typeName ?>_txt2"
                                                            value="<?= htmlspecialchars($txt2) ?>"
                                                            style="width:450px">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th style="background: #67aad8; color: #fff;">방문주기</th>
                                                    <td>
                                                        <div class="table">
                                                        <table>
                                                            <colgroup>
                                                                <col width="20%"/>
                                                                <col width="80%"/>
                                                            </colgroup>
                                                            <?php 
                                                            $manageRes = mysqli_query($connect, "
                                                                SELECT * 
                                                                FROM tbl_goods_manage 
                                                                WHERE g_code='$goods_code' 
                                                                AND type='$typeName'
                                                                AND visit_type = 'cycle'
                                                                ORDER BY gubun ASC
                                                            ");

                                                            $manageCnt = mysqli_num_rows($manageRes);
                                                            ?>

                                                            <?php if ($manageCnt > 0) { ?>

                                                                <?php
                                                                $idx = 0;
                                                                while ($mRow = mysqli_fetch_array($manageRes)) {
                                                                    $idx++;
                                                                    $gubun = $mRow['gubun'];

                                                                    $d1 = mysqli_fetch_array(mysqli_query($connect, "
                                                                        SELECT * FROM tbl_goods_manage_detail 
                                                                        WHERE type='$typeName'
                                                                        AND g_code='$goods_code'
                                                                        AND gubun='$gubun'
                                                                        AND gubun2='1'
                                                                        AND visit_type = 'cycle'
                                                                    "));
                                                                ?>
                                                                <tr class="manage_row" data-visit-type="cycle">
                                                                    <th style="background: #67aad8;">
                                                                        <input type="hidden" name="<?= $typeName ?>_gubun[]" value="<?= $idx ?>">
                                                                        <input type="hidden" name="<?= $typeName ?>_visit_type[]" value="cycle">
                                                                        사용:
                                                                        <input type="hidden" name="<?= $typeName ?>_use_hidden[]" value="<?= ($mRow['useYN']=='Y' ? 'Y' : 'N') ?>">
                                                                        <input type="checkbox"
                                                                            class="use_checkbox"
                                                                            data-type="<?= $typeName ?>"
                                                                            value="Y"
                                                                            <?= ($mRow['useYN']=='Y' ? 'checked' : '') ?>>

                                                                        <select name="<?= $typeName ?>_period[]">
                                                                            <option value="">선택</option>
                                                                            <?php
                                                                            $pRes = mysqli_query($connect, "
                                                                                SELECT * FROM tbl_code 
                                                                                WHERE status='Y' AND parent_code_no='$typeName'
                                                                                ORDER BY onum DESC, code_idx DESC
                                                                            ");
                                                                            while ($p = mysqli_fetch_array($pRes)) { ?>
                                                                                <option value="<?= $p['code_no'] ?>"
                                                                                    <?= ($mRow['period']==$p['code_no'] ? 'selected' : '') ?>>
                                                                                    <?= $p['code_name'] ?>
                                                                                </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </th>

                                                                    <td>
                                                                        <input type="hidden" name="<?= $typeName ?>_detail_visit_type[]" value="cycle">
                                                                        <input type="hidden" name="<?= $typeName ?>_price_chk_hidden[]" value="<?= ($d1['price_chk']=='Y' ? 'Y' : 'N') ?>">
                                                                        <input type="checkbox"
                                                                            class="price_chk_checkbox"
                                                                            data-type="<?= $typeName ?>"
                                                                            value="Y"
                                                                            <?= ($d1['price_chk']=='Y' ? 'checked' : '') ?>>
                                                                        가격적용 |

                                                                        표 머리글:
                                                                        <input type="text"
                                                                            name="<?= $typeName ?>_subject[]"
                                                                            value="<?= htmlspecialchars($d1['subject']) ?>">

                                                                        가격:
                                                                        <input type="text"
                                                                            name="<?= $typeName ?>_price[]"
                                                                            value="<?= htmlspecialchars($d1['price']) ?>"
                                                                            numberOnly>

                                                                        | 결합할인 적용( - 표기 )
                                                                        <input type="hidden" name="<?= $typeName ?>_cmbind_discnt_hidden[]" value="<?= ($d1['cmbind_discnt']=='Y' ? 'Y' : 'N') ?>">
                                                                        <input type="checkbox"
                                                                            class="cmbind_checkbox"
                                                                            data-type="<?= $typeName ?>"
                                                                            value="Y"
                                                                            <?= ($d1['cmbind_discnt']=='Y' ? 'checked' : '') ?>>

                                                                        <?php if ($idx == 1) { ?>
                                                                            <button type="button" class="add_row">+</button>
                                                                        <?php } else { ?>
                                                                            <button type="button" class="del_row">-</button>
                                                                        <?php } ?>
                                                                    </td>
                                                                </tr>
                                                                <?php } ?>

                                                            <?php } else { ?>

                                                                <tr class="manage_row" data-visit-type="cycle">
                                                                    <th style="background: #67aad8;">
                                                                        <input type="hidden" name="<?= $typeName ?>_gubun[]" value="1">
                                                                        <input type="hidden" name="<?= $typeName ?>_visit_type[]" value="cycle">
                                                                        사용:
                                                                        <input type="hidden" name="<?= $typeName ?>_use_hidden[]" value="N">
                                                                        <input type="checkbox" class="use_checkbox" data-type="<?= $typeName ?>" value="Y">

                                                                        <select name="<?= $typeName ?>_period[]">
                                                                            <option value="">선택</option>
                                                                            <?php
                                                                            $pRes = mysqli_query($connect, "
                                                                                SELECT * FROM tbl_code 
                                                                                WHERE status='Y' AND parent_code_no='$typeName'
                                                                                ORDER BY onum DESC, code_idx DESC
                                                                            ");
                                                                            while ($p = mysqli_fetch_array($pRes)) { ?>
                                                                                <option value="<?= $p['code_no'] ?>">
                                                                                    <?= $p['code_name'] ?>
                                                                                </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </th>

                                                                    <td>
                                                                        <input type="hidden" name="<?= $typeName ?>_detail_visit_type[]" value="cycle">
                                                                        <input type="hidden" name="<?= $typeName ?>_price_chk_hidden[]" value="N">
                                                                        <input type="checkbox" class="price_chk_checkbox" data-type="<?= $typeName ?>" value="Y">
                                                                        가격적용 |

                                                                        표 머리글:
                                                                        <input type="text" name="<?= $typeName ?>_subject[]">

                                                                        가격:
                                                                        <input type="text" name="<?= $typeName ?>_price[]" numberOnly>

                                                                        | 결합할인 적용( - 표기 )
                                                                        <input type="hidden" name="<?= $typeName ?>_cmbind_discnt_hidden[]" value="N">
                                                                        <input type="checkbox" class="cmbind_checkbox" data-type="<?= $typeName ?>" value="Y">

                                                                        <button type="button" class="add_row">+</button>
                                                                    </td>
                                                                </tr>

                                                            <?php } ?>
                                                        </table>
                                                        </td>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th style="background: #4ed396; color: #fff;">의무사용기간</th>
                                                    <td>
                                                        <div class="table">
                                                        <table>
                                                            <colgroup>
                                                                <col width="20%"/>
                                                                <col width="80%"/>
                                                            </colgroup>
                                                            <?php 
                                                            $manageRes = mysqli_query($connect, "
                                                                SELECT * 
                                                                FROM tbl_goods_manage 
                                                                WHERE g_code='$goods_code' 
                                                                AND type='$typeName'
                                                                AND visit_type = 'time'
                                                                ORDER BY gubun ASC
                                                            ");

                                                            $manageCnt = mysqli_num_rows($manageRes);
                                                            ?>

                                                            <?php if ($manageCnt > 0) { ?>

                                                                <?php
                                                                $idx = 0;
                                                                while ($mRow = mysqli_fetch_array($manageRes)) {
                                                                    $idx++;
                                                                    $gubun = $mRow['gubun'];

                                                                    $d1 = mysqli_fetch_array(mysqli_query($connect, "
                                                                        SELECT * FROM tbl_goods_manage_detail 
                                                                        WHERE type='$typeName'
                                                                        AND g_code='$goods_code'
                                                                        AND gubun='$gubun'
                                                                        AND gubun2='1'
                                                                        AND visit_type = 'time'
                                                                    "));
                                                                ?>
                                                                <tr class="manage_row" data-visit-type="time">
                                                                    <th style="background: #4ed396;">
                                                                        <input type="hidden" name="<?= $typeName ?>_gubun[]" value="<?= $idx ?>">
                                                                        <input type="hidden" name="<?= $typeName ?>_visit_type[]" value="time">
                                                                        사용:
                                                                        <input type="hidden" name="<?= $typeName ?>_use_hidden[]" value="<?= ($mRow['useYN']=='Y' ? 'Y' : 'N') ?>">
                                                                        <input type="checkbox"
                                                                            class="use_checkbox"
                                                                            data-type="<?= $typeName ?>"
                                                                            value="Y"
                                                                            <?= ($mRow['useYN']=='Y' ? 'checked' : '') ?>>

                                                                        <select name="<?= $typeName ?>_period[]">
                                                                            <option value="">선택</option>
                                                                            <?php
                                                                            $pRes = mysqli_query($connect, "
                                                                                SELECT * FROM tbl_code 
                                                                                WHERE status='Y' AND parent_code_no='$typeName'
                                                                                ORDER BY onum DESC, code_idx DESC
                                                                            ");
                                                                            while ($p = mysqli_fetch_array($pRes)) { ?>
                                                                                <option value="<?= $p['code_no'] ?>"
                                                                                    <?= ($mRow['period']==$p['code_no'] ? 'selected' : '') ?>>
                                                                                    <?= $p['code_name'] ?>
                                                                                </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </th>

                                                                    <td>
                                                                        <input type="hidden" name="<?= $typeName ?>_detail_visit_type[]" value="time">
                                                                        <input type="hidden" name="<?= $typeName ?>_price_chk_hidden[]" value="<?= ($d1['price_chk']=='Y' ? 'Y' : 'N') ?>">
                                                                        <input type="checkbox"
                                                                            class="price_chk_checkbox"
                                                                            data-type="<?= $typeName ?>"
                                                                            value="Y"
                                                                            <?= ($d1['price_chk']=='Y' ? 'checked' : '') ?>>
                                                                        가격적용 |

                                                                        표 머리글:
                                                                        <input type="text"
                                                                            name="<?= $typeName ?>_subject[]"
                                                                            value="<?= htmlspecialchars($d1['subject']) ?>">

                                                                        가격:
                                                                        <input type="text"
                                                                            name="<?= $typeName ?>_price[]"
                                                                            value="<?= htmlspecialchars($d1['price']) ?>"
                                                                            numberOnly>

                                                                        | 결합할인 적용( - 표기 )
                                                                        <input type="hidden" name="<?= $typeName ?>_cmbind_discnt_hidden[]" value="<?= ($d1['cmbind_discnt']=='Y' ? 'Y' : 'N') ?>">
                                                                        <input type="checkbox"
                                                                            class="cmbind_checkbox"
                                                                            data-type="<?= $typeName ?>"
                                                                            value="Y"
                                                                            <?= ($d1['cmbind_discnt']=='Y' ? 'checked' : '') ?>>

                                                                        <?php if ($idx == 1) { ?>
                                                                            <button type="button" class="add_row">+</button>
                                                                        <?php } else { ?>
                                                                            <button type="button" class="del_row">-</button>
                                                                        <?php } ?>
                                                                    </td>
                                                                </tr>
                                                                <?php } ?>

                                                            <?php } else { ?>

                                                                <tr class="manage_row" data-visit-type="time">
                                                                    <th style="background: #4ed396;">
                                                                        <input type="hidden" name="<?= $typeName ?>_gubun[]" value="1">
                                                                        <input type="hidden" name="<?= $typeName ?>_visit_type[]" value="time">
                                                                        사용:
                                                                        <input type="hidden" name="<?= $typeName ?>_use_hidden[]" value="N">
                                                                        <input type="checkbox" class="use_checkbox" data-type="<?= $typeName ?>" value="Y">

                                                                        <select name="<?= $typeName ?>_period[]">
                                                                            <option value="">선택</option>
                                                                            <?php
                                                                            $pRes = mysqli_query($connect, "
                                                                                SELECT * FROM tbl_code 
                                                                                WHERE status='Y' AND parent_code_no='$typeName'
                                                                                ORDER BY onum DESC, code_idx DESC
                                                                            ");
                                                                            while ($p = mysqli_fetch_array($pRes)) { ?>
                                                                                <option value="<?= $p['code_no'] ?>">
                                                                                    <?= $p['code_name'] ?>
                                                                                </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </th>

                                                                    <td>
                                                                        <input type="hidden" name="<?= $typeName ?>_detail_visit_type[]" value="time">
                                                                        <input type="hidden" name="<?= $typeName ?>_price_chk_hidden[]" value="N">
                                                                        <input type="checkbox" class="price_chk_checkbox" data-type="<?= $typeName ?>" value="Y">
                                                                        가격적용 |

                                                                        표 머리글:
                                                                        <input type="text" name="<?= $typeName ?>_subject[]">

                                                                        가격:
                                                                        <input type="text" name="<?= $typeName ?>_price[]" numberOnly>

                                                                        | 결합할인 적용( - 표기 )
                                                                        <input type="hidden" name="<?= $typeName ?>_cmbind_discnt_hidden[]" value="N">
                                                                        <input type="checkbox" class="cmbind_checkbox" data-type="<?= $typeName ?>" value="Y">

                                                                        <button type="button" class="add_row">+</button>
                                                                    </td>
                                                                </tr>

                                                            <?php } ?>
                                                        </table>
                                                        </td>
                                                    </td>
                                                </tr>

                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>

                                <script>
                                document.querySelectorAll(".type_selector").forEach(chk=>{
                                    chk.addEventListener("change", ()=>{
                                        let type = chk.dataset.type;
                                        let block = document.querySelector(`.type_block[data-type="${type}"]`);
                                        block.style.display = chk.checked ? "table-row" : "none";
                                    });
                                });

                                window.addEventListener("load", ()=>{
                                    document.querySelectorAll(".type_selector:checked").forEach(chk=>{
                                        let type = chk.dataset.type;
                                        let block = document.querySelector(`.type_block[data-type="${type}"]`);
                                        block.style.display = "table-row";
                                    });
                                });

                                document.addEventListener("change", function(e){
                                    if(e.target.classList.contains("use_checkbox")){
                                        let hiddenInput = e.target.parentElement.querySelector('input[name*="_use_hidden"]');
                                        if(hiddenInput){
                                            hiddenInput.value = e.target.checked ? 'Y' : 'N';
                                        }
                                    }
                                    
                                    if(e.target.classList.contains("price_chk_checkbox")){
                                        let hiddenInput = e.target.parentElement.querySelector('input[name*="_price_chk_hidden"]');
                                        if(hiddenInput){
                                            hiddenInput.value = e.target.checked ? 'Y' : 'N';
                                        }
                                    }
                                    
                                    if(e.target.classList.contains("cmbind_checkbox")){
                                        let hiddenInput = e.target.parentElement.querySelector('input[name*="_cmbind_discnt_hidden"]');
                                        if(hiddenInput){
                                            hiddenInput.value = e.target.checked ? 'Y' : 'N';
                                        }
                                    }
                                });

                                document.addEventListener("click", function(e){
                                    if(e.target.classList.contains("add_row")){
                                    let tr = e.target.closest("tr");
                                    let table = tr.closest("table");
                                    let visitType = tr.getAttribute("data-visit-type");
                                    let rows = table.querySelectorAll(`tr[data-visit-type="${visitType}"]`);
                                    let newGubun = rows.length + 1;
                                    
                                    let lastRow = rows[rows.length - 1];
                                    
                                    let clone = tr.cloneNode(true);
                                    clone.setAttribute("data-visit-type", visitType);
                                    
                                    let gubunInput = clone.querySelector('input[name*="_gubun"]');
                                    if(gubunInput) gubunInput.value = newGubun;
                                    
                                    clone.querySelectorAll("input").forEach(el=>{
                                        if(el.type==="checkbox") {
                                            el.checked = false;
                                        } else if(el.type==="text") {
                                            el.value = "";
                                        } else if(el.name && (el.name.includes("_use_hidden") || el.name.includes("_price_chk_hidden") || el.name.includes("_cmbind_discnt_hidden"))) {
                                            el.value = "N";
                                        }
                                    });
                                    
                                    clone.querySelectorAll("select").forEach(el=>{
                                        el.selectedIndex = 0;
                                    });
                                    
                                    clone.querySelector(".add_row").outerHTML = '<button type="button" class="del_row">-</button>';
                                    
                                    lastRow.after(clone);
                                }

                                    if(e.target.classList.contains("del_row")){
                                        let tr = e.target.closest("tr");
                                        let table = tr.closest("table");
                                        let visitType = tr.getAttribute("data-visit-type");
                                        
                                        tr.remove();
                                        
                                        let rows = table.querySelectorAll(`tr[data-visit-type="${visitType}"]`);
                                        rows.forEach((row, index) => {
                                            let gubunInput = row.querySelector('input[name*="_gubun"]');
                                            if(gubunInput) gubunInput.value = index + 1;
                                        });
                                    }
                                });
                                </script>



                                <script>
                                // document.querySelectorAll(".type_selector").forEach(chk=>{
                                //     chk.addEventListener("change", ()=>{
                                //         let type = chk.dataset.type;
                                //         let block = document.querySelector(`.type_block[data-type="${type}"]`);
                                //         block.style.display = chk.checked ? "table-row" : "none";
                                //     });
                                // });

                                // window.addEventListener("load", ()=>{
                                //     document.querySelectorAll(".type_selector:checked").forEach(chk=>{
                                //         let type = chk.dataset.type;
                                //         let block = document.querySelector(`.type_block[data-type="${type}"]`);
                                //         block.style.display = "table-row";
                                //     });
                                // });

                                // document.addEventListener("click", function(e){

                                //     // 추가
                                //     if(e.target.classList.contains("add_row")){
                                //         let tr = e.target.closest("tr");
                                //         let clone = tr.cloneNode(true);

                                //         clone.querySelector(".add_row").outerHTML =
                                //             '<button type="button" class="del_row">-</button>';

                                //         clone.querySelectorAll("input").forEach(el=>{
                                //             if(el.type==="checkbox") el.checked = false;
                                //             else el.value = "";
                                //         });

                                //         tr.after(clone);
                                //     }

                                //     // 삭제
                                //     if(e.target.classList.contains("del_row")){
                                //         e.target.closest("tr").remove();
                                //     }
                                // });

                                </script>


                            <tr>
                                <th>사은품선택</th>
                                <td>
                                    <table>
                                        <colgroup>
                                            <col width="10%"/>
                                            <col width="90%"/>
                                        </colgroup>
                                        <tbody>
                                        <?
                                        for ($i = 1; $i <= 4; $i++) {
                                            $fb_sql = "select * from tbl_goods_fb where g_idx = '" . $g_idx . "' and fb_idx = '" . $i . "' ";
                                            $fb_result = mysqli_query($connect, $fb_sql);
                                            $fb_row = mysqli_fetch_array($fb_result);
                                            ?>
                                            <tr>
                                                <th>
                                                    <input type="hidden" name="fb_idx<?= $i ?>" value='<?= $i ?>'>
                                                    사용 : <input type="checkbox" name="f_p_use<?= $i ?>"
                                                                id="f_p_use<?= $i ?>"
                                                                value='Y' <?= ($fb_row['fb_use'] == 'Y' ? "checked" : "") ?>>
                                                    <select name="f_p_sel<?= $i ?>" id="f_p_sel<?= $i ?>">
                                                        <option value="">선택</option>
                                                        <?
                                                        $p_sql = "select * from tbl_period where status = 'Y' order by onum desc, code_no desc";
                                                        $p_result = mysqli_query($connect, $p_sql);
                                                        while ($p_row = mysqli_fetch_array($p_result)) {
                                                            ?>
                                                            <option value="<?= $p_row['code_no'] ?>" <?= ($fb_row["fb_sel"] == $p_row['code_no'] ? "selected" : "") ?>><?= $p_row['code_name'] ?></option>
                                                        <? } ?>
                                                    </select>
                                                </th>
                                                <td>
                                                    <?
                                                    $fb_val_arr = explode('||', substr($fb_row["fb_val"], 1, -1));

                                                    $f_sql = "select * from tbl_freebies_code where status = 'Y' order by onum desc, code_no desc";
                                                    $f_result = mysqli_query($connect, $f_sql);
                                                    while ($f_row = mysqli_fetch_array($f_result)) {
                                                        ?>
                                                        <input type="checkbox" name="freebies<?= $i ?>[]"
                                                               id="freebies<?= $i ?>_<?= $f_row['code_no'] ?>"
                                                               value='<?= $f_row['code_no'] ?>' <? if (in_array($f_row['code_no'], $fb_val_arr) == true) {
                                                            echo "checked";
                                                        } ?>><label
                                                                for="freebies<?= $i ?>_<?= $f_row['code_no'] ?>"><?= $f_row['code_name'] ?></label>
                                                    <? } ?>
                                                </td>
                                            </tr>
                                        <? } ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>


                            </tbody>
                        </table>

                        <!-- <div class="listBottom">
                            <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail">
                                <caption>
                                </caption>
                                <colgroup>
                                <col width="10%">
                                <col width="90%">
                                </colgroup>
                                <tbody>
                                    
                                    <tr height=45>
                                        <th>옵션추가</th>
                                        <td>
                                            <input type='text'   name='moption_name' id='moption_name' value=""  style="width:550px" />
                                            <button type="button" class="btn_01" onclick="add_moption();">추가</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> -->
                        <?php if(!empty($g_idx)) {?>
                        <?php 
                            $sql_option       = "select * from tbl_goods_moption where g_idx = '". $g_idx ."' and type = 'M' order by onum desc ";
                            $result_option    = mysqli_query($connect, $sql_option) or die (mysqli_error($connect));
                            $row_option = mysqli_fetch_array($result_option);
                        ?> 		
                        <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail" style="margin-top:50px;">
                            <caption>
                            </caption>
                            <colgroup>
                            <col width="10%">
                            <col width="90%">
                            </colgroup>
                            <tbody>

                                <tr height="45">
                                    <th colspan="5">
                                        옵션 <input type='text' name='moption_name' id='moption_name' value="<?=$row_option['moption_name']?>" style="width:550px" />
                                        <input type="hidden" name="moption_type[<?=$row_option['code_idx']?>]" value="M">
                                        <button type="button" class="btn_01" onclick="upd_moption('<?=$row_option['code_idx']?>', '<?= $g_idx?>');">수정</button>
                                        <button type="button" class="btn_01" onclick="del_moption('<?=$row_option['code_idx']?>');">삭제</button>
                                    </th>
                                </tr> 	
                                <tr height="45">
                                    <th>
                                        추가 옵션등록
                                        <p style="display:block;margin-top:10px;">
                                            <button type="button" id="btn_add_option" onclick="add_option('<?=$row_option['code_idx']?>');" class="btn_01">추가</button>
                                            <button type="button" id="btn_upd_option" onclick="upd_option('<?=$row_option['code_idx']?>');" class="btn_01">등록</button>
                                        </p>
                                    </th>
                                    <td>
                                        <span  style="color:red;">※ 옵션 삭제 시에 해당 옵션과 연동된 주문, 결제내역에 영향을 미치니 반드시 확인 후에 삭제바랍니다.</span>
                                        <div>
                                            <table>
                                                <colgroup>
                                                    <col width="*"></col>
                                                    <col width="20%"></col>
                                                    <col width="20%"></col>
                                                </colgroup>
                                                <thead>
                                                    <tr>
                                                        <th>옵션명</th>
                                                        <th>순서</th>
                                                        <th>삭제</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="settingBody_<?=$row_option['code_idx']?>"
                                                        data-code-idx="<?=$row_option['code_idx']?>"
                                                        data-g-idx="<?=$g_idx?>"
                                                        data-option-type="<?=$row_option['type']?>">

                                                <?php
                                                // 옵션 조회
                                                $fsql3    = "select * from tbl_goods_option where g_idx = '".$g_idx."' and code_idx = '". $row_option['code_idx'] ."' and option_type = 'M' order by onum desc ";
                                                $fresult3    = mysqli_query($connect, $fsql3) or die (mysqli_error($connect));
                                                while($frow3 = mysqli_fetch_array($fresult3)){
                                                                
                                                ?>

                                                    <tr color='<?=$_tmp_color?>' size='<?=$frow2['type']?>' >
                                                        <input type="hidden" name="o_idx[]" value="<?=$frow3['idx']?>">
                                                        <input type="hidden" name="option_type[<?=$frow3['idx']?>]" value="M" class='option_type'>
                                                        <td>
                                                            <input type='text' class="opt_name" name='o_name[]' id='o_name_<?=$frow3['idx']?>' value="<?=$frow3['goods_name']?>" style="width: 100%" />
                                                        </td>
                                                        <!-- <td>
                                                            <select class="opt_use" name="use_yn[]" id="use_yn_<?=$frow3['idx']?>">
                                                            <option value="Y" <?php if($frow3['use_yn'] == "Y") echo "selected";?> >판매중</option>
                                                            <option value="N" <?php if($frow3['use_yn'] != "Y") echo "selected";?> >중지</option>
                                                            </select>
                                                        </td> -->
                                                        <td>
                                                            <div style="display: flex; justify-content: center;">
                                                                <input type='text' class='opt_num onlynum' name='o_num[]' id='o_num_<?=$frow3['idx']?>' value="<?=$frow3['onum']?>" />
                                                            </div>
                                                        </td>
                                                        <td align="center">
                                                            <div style="display: flex; justify-content: center;">
                                                                <button type="button" onclick="updOption('<?=$frow3['idx']?>')" class="btn_03">수정</button>
                                                                <button type="button" onclick="delOption('<?=$frow3['idx']?>')" class="btn_03">삭제</button>
                                                            </div>
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
                            </tbody>
                            </table>

                        <?php 
                            $sql_option       = "select * from tbl_goods_moption where g_idx = '". $g_idx ."' and type = 'S' order by onum desc ";
                            $result_option    = mysqli_query($connect, $sql_option) or die (mysqli_error($connect));
                            $row_option = mysqli_fetch_array($result_option);
                        ?> 		
                        <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail" style="margin-top:50px;">
                            <caption>
                            </caption>
                            <colgroup>
                            <col width="10%">
                            <col width="90%">
                            </colgroup>
                            <tbody>

                                <tr height="45">
                                    <th colspan="5">
                                        옵션 <input type='text' name='moption_name' id='moption_name_s' value="<?=$row_option['moption_name']?>" style="width:550px" />
                                        <input type="hidden" name="moption_type[<?=$row_option['code_idx']?>]" value="S">
                                        <button type="button" class="btn_01" onclick="upd_moption_s('<?=$row_option['code_idx']?>', '<?= $g_idx?>');">수정</button>
                                        <button type="button" class="btn_01" onclick="del_moption('<?=$row_option['code_idx']?>');">삭제</button>
                                    </th>
                                </tr> 	
                                <tr height="45">
                                    <th>
                                        추가 옵션등록
                                        <p style="display:block;margin-top:10px;">
                                            <button type="button" id="btn_add_option" onclick="add_option_s('<?=$row_option['code_idx']?>');" class="btn_01">추가</button>
                                            <button type="button" id="btn_upd_option" onclick="upd_option('<?=$row_option['code_idx']?>');" class="btn_01">등록</button>
                                        </p>
                                    </th>
                                    <td>
                                        <span  style="color:red;">※ 옵션 삭제 시에 해당 옵션과 연동된 주문, 결제내역에 영향을 미치니 반드시 확인 후에 삭제바랍니다.</span>
                                        <div>
                                            <table>
                                                <colgroup>
                                                    <col width="*"></col>
                                                    <col width="20%"></col>
                                                    <col width="20%"></col>
                                                </colgroup>
                                                <thead>
                                                    <tr>
                                                        <th>옵션명</th>
                                                        <th>순서</th>
                                                        <th>삭제</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="settingBody_<?=$row_option['code_idx']?>"
                                                        data-code-idx="<?=$row_option['code_idx']?>"
                                                        data-g-idx="<?=$g_idx?>">

                                                <?php
                                                // 옵션 조회
                                                $fsql3    = "select * from tbl_goods_option where g_idx = '".$g_idx."' and code_idx = '". $row_option['code_idx'] ."' and option_type = 'S' order by onum desc ";
                                                $fresult3    = mysqli_query($connect, $fsql3) or die (mysqli_error($connect));
                                                while($frow3 = mysqli_fetch_array($fresult3)){
                                                                
                                                ?>

                                                    <tr color='<?=$_tmp_color?>' size='<?=$frow2['type']?>' >
                                                        <input type="hidden" name="o_idx[]" value="<?=$frow3['idx']?>">
                                                        <input type="hidden" name="option_type[<?=$frow3['idx']?>]" value="S">
                                                        <td>
                                                            <input type='text' class="opt_name" name='o_name[]' id='o_name_<?=$frow3['idx']?>' value="<?=$frow3['goods_name']?>" style="width: 100%" />
                                                        </td>
                                                        <!-- <td>
                                                            <select class="opt_use" name="use_yn[]" id="use_yn_<?=$frow3['idx']?>">
                                                            <option value="Y" <?php if($frow3['use_yn'] == "Y") echo "selected";?> >판매중</option>
                                                            <option value="N" <?php if($frow3['use_yn'] != "Y") echo "selected";?> >중지</option>
                                                            </select>
                                                        </td> -->
                                                        <td>
                                                            <div style="display: flex; justify-content: center;">
                                                                <input type='text' class='opt_num onlynum' name='o_num[]' id='o_num_<?=$frow3['idx']?>' value="<?=$frow3['onum']?>" />
                                                            </div>
                                                        </td>
                                                        <td align="center">
                                                            <div style="display: flex; justify-content: center;">
                                                                <button type="button" onclick="updOption('<?=$frow3['idx']?>')" class="btn_03">수정</button>
                                                                <button type="button" onclick="delOption('<?=$frow3['idx']?>')" class="btn_03">삭제</button>
                                                            </div>
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
                            </tbody>
                        </table>
                        <?php }?>

                        <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail"
                               style="margin-top:50px;">
                            <caption>
                            </caption>
                            <colgroup>
                                <col width="10%"/>
                                <col width="90%"/>
                            </colgroup>
                            <tbody>

                            <tr height="45">
                                <th>상세검색 조건 선택</th>
                                <td>
                                    <select name="detail_cate" id="detail_cate">
                                        <option value="">선택</option>
                                        <?
                                        $code_cate_sql = "select * from tbl_code_cate where status = 'Y' and parent_code_no = 0 order by onum desc, code_idx desc";
                                        $code_cate_result = mysqli_query($connect, $code_cate_sql);
                                        while ($code_cate_row = mysqli_fetch_array($code_cate_result)) {
                                            ?>
                                            <option value="<?= $code_cate_row['code_no'] ?>" <?= ($detail_cate == $code_cate_row['code_no'] ? "selected" : "") ?>><?= $code_cate_row['code_name'] ?></option>
                                        <? } ?>
                                    </select>

                                </td>
                            </tr>

                            <tr height="45">
                                <th>상세조건체크</th>
                                <td>
                                    <div class='detail_wrap'>
                                        <table>
                                            <colgroup>
                                                <col width="10%"/>
                                                <col width="90%"/>
                                            </colgroup>
                                            <tbody>
                                            <tr>
                                                <th></th>
                                                <td></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>


                            </tbody>
                        </table>


                        <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail"
                               style="margin-top:50px;">
                            <caption>
                            </caption>
                            <colgroup>
                                <col width="10%"/>
                                <col width="90%"/>
                            </colgroup>
                            <tbody>
                            <tr>
                            <tr height="45">
                                <td colspan="2">
                                    이미지 등록
                                </td>
                            </tr>
                            <th>이미지(600X600)</th>
                            <td colspan="3">
                                <div class="img_add">
                                    <div class="file_input <?= ($ufile1 != '' ? "applied" : "") ?>">
                                        <input type="file" name='file' id="file_add01">
                                        <label for="file_add01" id="file_img01"
                                               style='background-image:url(/data/product/<?= $ufile1 ?>)'></label>
                                        <input type="hidden" id="ufile_chk">
                                        <input type="hidden" class='file_num' value='1'>
                                        <input type="hidden" name="ufile1" id="ufile1" value='<?= $ufile1 ?>'>
                                        <input type="hidden" name="rfile1" id="rfile1" value='<?= $rfile1 ?>'>
                                        <button type="button" class="remove_btn"></button>
                                        <span class="img_txt">대표 이미지 / 리스트 이미지  필수*</span>
                                    </div>
                                    <? for ($i = 2; $i <= 5; $i++) { ?>
                                        <div class="file_input <?= (${'ufile' . $i} != '' ? "applied" : "") ?>">
                                            <input type="file" name='file' id="file_add0<?= $i ?>">
                                            <label for="file_add0<?= $i ?>" id="file_img0<?= $i ?>"
                                                   style='background-image:url(/data/product/<?= ${"ufile" . $i} ?>)'></label>
                                            <input type="hidden" class='file_num' value='<?= $i ?>'>
                                            <input type="hidden" name="ufile<?= $i ?>" id="ufile<?= $i ?>"
                                                   value='<?= ${"ufile" . $i} ?>'>
                                            <input type="hidden" name="rfile<?= $i ?>" id="rfile<?= $i ?>"
                                                   value='<?= ${"rfile" . $i} ?>'>
                                            <button type="button" class="remove_btn"></button>
                                            <span class="img_txt">추가이미지</span>
                                        </div>
                                    <? } ?>

                                </div>
                            </td>
                            </tr>

                            </tbody>
                        </table>


                        <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail"
                               style="margin-top:50px;">
                            <caption>
                            </caption>
                            <colgroup>
                                <col width="10%"/>
                                <col width="90%"/>
                            </colgroup>
                            <tbody>

                            <tr height="45">
                                <td colspan="2">
                                    상품 상세설명
                                </td>
                            </tr>

                            <tr height="45">
                                <td colspan="2">

								<textarea name="content" id="content" rows="10" cols="100" class="input_txt"
                                          style="width:100%; height:400px; display:none;"><?= viewSQ($content); ?></textarea>

                                    <script type="text/javascript">
                                        summerContent.push = $('#content').summernote({

                                            toolbar: [
                                                ['style', ['style']],
                                                ['font', ['bold', 'italic', 'underline', 'clear']],
                                                ['font', ['strikethrough', 'superscript', 'subscript']],
                                                ['font', ['fontsize', 'color']],
                                                ['font', ['fontname']],
                                                ['para', ['ul', 'ol', 'listStyles', 'paragraph']],
                                                ['height', ['height']],
                                                ['table', ['table']],
                                                ['insert', ['link', 'picture', 'video'/*, 'hr', 'doc', 'readmore', 'lorem', 'emoji'*/]],
                                                ['history', ['undo', 'redo']],
                                                ['view', ['codeview', 'findnreplace']],
                                                ['help', ['help']]
                                            ]
                                            ,
                                            height: 400                 // set editor height
                                            ,
                                            minHeight: null             // set minimum height of editor
                                            ,
                                            maxHeight: null             // set maximum height of editor
                                            //focus: true     
                                            ,
                                            lang: 'ko-KR' // default: 'en-US'
                                            ,
                                            fontNames: ['맑은고딕', '굴림', '굴림체', '궁서', '궁서체', '돋움', '돋움체', '바탕', '바탕체', '휴먼엽서체', 'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Garamond', 'Georgia', 'Impact', 'Modem',]
                                            ,
                                            fontNamesIgnoreCheck: ['맑은고딕']
                                            ,
                                            fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '22', '24', '28', '30', '36', '50', '72']

                                            ,
                                            callbacks: {
                                                onImageUpload: function (files, editor, $editable) {
                                                    sendFile(files[0], this);
                                                }
                                            }
                                        });


                                    </script>


                                </td>
                            </tr>


                            </tbody>
                        </table>


                        <? /*?>
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
								summerContent.push = $('#caution').summernote({

										 toolbar: [
											 ['style', ['style']],
											['font', ['bold', 'italic', 'underline', 'clear']],
											['font', ['strikethrough', 'superscript', 'subscript']],
											['font', ['fontsize', 'color']],
											['font', ['fontname']],
											['para',['ul','ol', 'listStyles','paragraph']],
											['height',['height']],
											['table', ['table']],
											['insert', ['link', 'picture', 'video']],
											['history', ['undo', 'redo']],
											['view', ['codeview', 'findnreplace']],
											['help',['help']]
										]
										,height: 400                 // set editor height
										,minHeight: null             // set minimum height of editor
										,maxHeight: null             // set maximum height of editor
										//focus: true     
										,lang: 'ko-KR' // default: 'en-US'
										,fontNames : [ '맑은고딕','굴림','굴림체','궁서','궁서체','돋움','돋움체','바탕','바탕체','휴먼엽서체', 'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New','Garamond','Georgia','Impact','Modem', ]
										,fontNamesIgnoreCheck : [ '맑은고딕' ]
										,fontSizes: ['8','9','10','11','12','14','16','18','20','22','24','28','30','36','50','72']

										,callbacks: {
											onImageUpload: function(files, editor, $editable) {
												sendFile(files[0],this);
											}
										 }
									});



								</script>


							</td>
						</tr>


					</tbody>
				</table>
			<?*/ ?>

                    </div>
                </form>


                <!-- 중복체크 팝업 -->
                <div id="pooup_01" class="popup">
                    <div class="pooup_bg"></div>
                    <div class="popup_con">
                        <input type="hidden" name="chk_codeType" id="chk_codeType">
                        <input type="hidden" name="chk_codeCnt" id="chk_codeCnt">
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
						<a href="<?= $links ?>?search_gubun=<?= $search_gubun ?>&search_category=<?= $search_category ?>&search_name=<?= $search_name ?>&pg=<?= $pg ?>" class="btn btn-secondary"><i class="bi bi-list"></i><span class="txt">리스트</span></a>
						-->
                            <a href="javascript:history.go(-1);" class="btn btn-secondary"><i
                                        class="bi bi-list"></i><span
                                        class="txt">리스트</span></a>
                            <? if ($idx == "") { ?>
                                <a href="javascript:send_it()" class="btn btn-primary"><i class="bi bi-gear"></i><span
                                            class="txt">등록</span></a>
                            <? } else { ?>
                                <a href="javascript:send_it()" class="btn btn-primary"><i class="bi bi-gear"></i><span
                                            class="txt">수정</span></a>
                                <a href="javascript:del_it()" class="btn btn-danger"><i class="bi bi-trash"></i><span
                                            class="txt">삭제</span></a>
                            <? } ?>
                        </li>
                    </ul>
                </div>


            </div>
            <!-- // listWrap -->

        </div>
        <!-- // contents -->

    </div><!-- 인쇄 영역 끝 //-->
</div>


<iframe width="0" height="0" name="hiddenFrame22" id="hiddenFrame22" style="display:none;"></iframe>

<? include "../_include/_footer.php"; ?>


<!--

oEditors1.getById["info1_ko"].exec("UPDATE_CONTENTS_FIELD", []);
oEditors2.getById["info1_ko"].exec("UPDATE_CONTENTS_FIELD", []);

-->

<script>
	$("#btn_add_optionx").click(function(){

		var addOption = "";
		addOption += "<tr color='' size='' >												  ";

		addOption += "	<td>																  ";
		addOption += "		<input type='hidden' name='o_idx[]'  value='' />	  ";
		addOption += "		<input type='hidden' name='option_type[]'  value='M' />	  ";
		addOption += "		<input type='file' name='a_file[]'  value='' style='display:none;' />					  ";
		addOption += "		<input type='text' name='o_name[]'  value='' style='width: 100%' />	  ";
		addOption += "	</td>																  ";
		addOption += "	<td>																  ";
		addOption += "		<select name='ues_yn[]'>	                                      ";
		addOption += "		<option value='Y'>판매</option>    	                              ";
		addOption += "		<option value='N'>중지</option>    	                              ";
		addOption += "		</select>	                                                      ";
		addOption += "	</td>																  ";
//		addOption += "	<td>																  ";
//		addOption += "		<input type='text' class='onlynum' name='o_jaego[]'  value='' />	  ";
//		addOption += "	</td>																  ";
		
		

		addOption += "	<td>																  ";
		addOption += '		<button type="button" onclick="delOption(\'\',this)" class="btn_03">삭제</button>	  ';
		addOption += "	</td>																  ";
		addOption += "</tr>																	  ";
	
		$("#settingBody").append(addOption);

	});

function add_option(code_idx)
{
		var addOption = "";
		addOption += "<tr color='' size='' >												  ";

		addOption += "	<td>																  ";
		addOption += "		<input type='hidden' name='o_idx[]'  value='' />	  ";
		addOption += "		<input type='hidden' name='option_type[]'  value='M' class='option_type'/>	  ";
		addOption += "		<input type='file' name='a_file[]'  value='' style='display:none;' />					  ";
		addOption += "		<input type='text' class='opt_name' name='o_name[]'  value='' style='width: 100%' />	  ";
		addOption += "	</td>																  ";
		// addOption += "	<td>																  ";
		// addOption += "		<select  class='opt_use' name='ues_yn[]'>	                                      ";
		// addOption += "		<option value='Y'>판매</option>    	                              ";
		// addOption += "		<option value='N'>중지</option>    	                              ";
		// addOption += "		</select/>	                                                      ";
		// addOption += "	</td>																  ";
		addOption += "	<td>	                                                                   ";
        addOption += "		<div style='display: flex; justify-content: center;'>				  ";
		addOption += "		<input type='text' class='opt_num onlynum' name='o_num[]'  value='' />	  ";
        addOption += "		</div>											  ";
		addOption += "	</td>																  ";
		
		

		addOption += "	<td>																  ";
        addOption += "		<div style='display: flex; justify-content: center;'>				  ";
		addOption += '		<button type="button" onclick="delOption(\'\',this)" class="btn_03">삭제</button>	  ';
        addOption += "		</div>											  ";
		addOption += "	</td>																  ";
		addOption += "</tr>																	  ";
	
		$("#settingBody_"+code_idx).append(addOption);
}

function add_option_s(code_idx)
{
		var addOption = "";
		addOption += "<tr color='' size='' >												  ";

		addOption += "	<td>																  ";
		addOption += "		<input type='hidden' name='o_idx[]'  value='' />	  ";
		addOption += "		<input type='hidden' name='option_type[]'  value='S' class='option_type'/>	  ";
		addOption += "		<input type='file' name='a_file[]'  value='' style='display:none;' />					  ";
		addOption += "		<input type='text' class='opt_name' name='o_name[]'  value='' style='width: 100%' />	  ";
		addOption += "	</td>																  ";
		// addOption += "	<td>																  ";
		// addOption += "		<select  class='opt_use' name='ues_yn[]'>	                                      ";
		// addOption += "		<option value='Y'>판매</option>    	                              ";
		// addOption += "		<option value='N'>중지</option>    	                              ";
		// addOption += "		</select/>	                                                      ";
		// addOption += "	</td>																  ";
		addOption += "	<td>																  ";
        addOption += "		<div style='display: flex; justify-content: center;'>				  ";
		addOption += "		<input type='text' class='opt_num onlynum' name='o_num[]'  value='' />	  ";
        addOption += "		</div>											  ";
		addOption += "	</td>																  ";
		addOption += "	<td>																  ";
        addOption += "		<div style='display: flex; justify-content: center;'>				  ";
		addOption += '		<button type="button" onclick="delOption(\'\',this)" class="btn_03">삭제</button>	  ';
        addOption += "		</div>											  ";
		addOption += "	</td>																  ";
		addOption += "</tr>																	  ";
	
		$("#settingBody_"+code_idx).append(addOption);
}

function upd_moption(code_idx, g_idx)

{
	    var message = "";
		$.ajax({

			url: "/ajax/ajax.upd_moption.php",
			type: "POST",
			data: {
				"code_idx"      : code_idx,
				"g_idx"         : g_idx,
				"moption_name"  : $("#moption_name").val()
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

function upd_moption_s(code_idx, g_idx)

{
	    var message = "";
		$.ajax({

			url: "/ajax/ajax.upd_moption_s.php",
			type: "POST",
			data: {
				"code_idx"      : code_idx,
                "g_idx"         : g_idx,
				"moption_name"  : $("#moption_name_s").val()
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

function add_moption()
{
	    var message = "";
		$.ajax({

			url: "/ajax/ajax.add_moption.php",
			type: "POST",
			data: {
				"g_idx"  : '<?=$g_idx?>',
				"moption_name" : $("#moption_name").val()
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

function del_moption(code_idx)
{
        if (!confirm("선택한 옵션을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다."))
                return false;

	    var message = "";
		$.ajax({

			url: "/ajax/ajax.del_moption.php",
			type: "POST",
			data: {
				"code_idx"  : code_idx
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

function upd_option(code_idx) {

    var $tbody = $('#settingBody_' + code_idx);

    var formData = new FormData();
    formData.append('code_idx', $tbody.data('code-idx'));
    formData.append('g_idx', $tbody.data('g-idx'));

    $tbody.find('tr').each(function () {
        var o_idx = $(this).find('input[name="o_idx[]"]').val();
        var o_name = $(this).find('.opt_name').val();
        var use_yn = $(this).find('.opt_use').val();
        var o_num  = $(this).find('.opt_num').val();
        var option_type  = $(this).find('.option_type').val();

        if (o_name) {
            formData.append('o_idx[]', o_idx);
            formData.append('o_name[]', o_name);
            formData.append('use_yn[]', use_yn);
            formData.append('o_num[]', o_num);
            formData.append('option_type[]', option_type);
        }
    });

    $.ajax({
        type: 'POST',
        url: '/ajax/ajax.add_option.php',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (res) {
            alert(res.message);
            location.reload();
        },
        error: function (xhr) {
            alert(xhr.responseText);
        }
    });
}


// 옵션 삭제 함수
function delOption(idx, obj){

            if (!confirm("선택한 옵션을 삭제 하시겠습니까?"))
                return false;

			var message = "";
			$.ajax({

				url: "/ajax/ajax.del_option.php",
				type: "POST",
				data: {
					"idx": idx
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


// 옵션 수정 함수
function updOption(idx){

            if (!confirm("선택한 옵션을 수정 하시겠습니까?"))
                return false;

			var message = "";
			$.ajax({

				url: "/ajax/ajax.upd_option.php",
				type: "POST",
				data: {
					"idx"          : idx,
					"option_name"  : $("#o_name_"+idx).val(),
					"use_yn"       : $("#use_yn_"+idx).val(),
					"onum"         : $("#o_num_"+idx).val()
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
</script>
<script type="text/javascript">

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

    //------- 분류 수정 관련 ---------
    <?
    for($n = 1; $n <= 4; $n++){
    if($tmp_ar[1]){
    ?>
    var group<?=$n?> = "<?=$tmp_ar[$n]?>";
    <?
    }
    }
    ?>
    $("input[name='goods_dis1']").on('click', function () {
        var len = $("input[name='goods_dis1']:checked").length;
        if (len > 1) {
            $("input[name='goods_dis1']").prop('checked', false);
            $(this).prop('checked', true);
        }
    });
    $("input[name='item_logo']").on('click', function () {
        var len = $("input[name='item_logo']:checked").length;
        if (len > 1) {
            $("input[name='item_logo']").prop('checked', false);
            $(this).prop('checked', true);
        }
    });
    if (group1 != "") {
        $("#product_group_1").val(group1);
        get_group(group1, 2);
        console.log("2");

        if (group2 != "") {
            $("#product_group_2").val(group2);
            get_group(group2, 3);
            console.log("3");

            if (group3 != "") {
                $("#product_group_3").val(group3);
                get_group(group3, 4);
                console.log("4");

                if (group4 != "") {
                    $("#product_group_4").val(group4);
                }
            }
        }

    }

    function setGroupVal() {
        $("#product_group_1").val(group1);
        $("#product_group_2").val(group2);
        $("#product_group_3").val(group3);
        $("#product_group_4").val(group4);
    }

    setTimeout("setGroupVal();", 1500);

    function period_option() {
        var option = '';
        <?
        $period_cate_sql = "select * from tbl_period where status = 'Y' order by onum desc, code_idx desc";
        $period_cate_result = mysqli_query($connect, $period_cate_sql);
        while($period_cate_row = mysqli_fetch_array($period_cate_result) ){
        ?>
        option += "<option value='<?=$period_cate_row['code_no']?>'><?=$period_cate_row['code_name']?></option>";
        <?}?>

        return option;
    }

    function sf_price_chk(i, j) {
        if ($("#self_price_chk" + i + "_" + j).is(":checked")) {
            $('.self_price_chk' + i).prop("checked", false);
            $("#self_price_chk" + i + "_" + j).prop("checked", true)
        }
    }

    function sf_discnt_chk(i, j) {
        if ($("#self_cmbind_discnt" + i + "_" + j).is(":checked")) {
            $('.self_cmbind_discnt' + i).prop("checked", false);
            $("#self_cmbind_discnt" + i + "_" + j).prop("checked", true)
        }
    }

    function vt_price_chk(i, j) {
        if ($("#visit_price_chk" + i + "_" + j).is(":checked")) {
            $('.visit_price_chk' + i).prop("checked", false);
            $("#visit_price_chk" + i + "_" + j).prop("checked", true);
        }
    }

    function vt_discnt_chk(i, j) {
        if ($("#visit_cmbind_discnt" + i + "_" + j).is(":checked")) {
            $('.visit_cmbind_discnt' + i).prop("checked", false);
            $("#visit_cmbind_discnt" + i + "_" + j).prop("checked", true)
        }
    }
</script>

