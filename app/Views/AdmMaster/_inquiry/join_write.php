<? include "../_include/_header.php"; ?>
<?
$idx = updateSQ($_GET["idx"]);

if ($idx == "") {

} else {


    $sql = " select * from tbl_join where idx = '" . $idx . "'";
    $result = mysqli_query($connect, $sql) or die (mysql_error($connect));
    $row = mysqli_fetch_object($result);

    foreach ($row as $keys => $vals) {
        //echo $keys . " => " . $vals . "<br/>";
        ${$keys} = $vals;

    }

    $sql_d = "SELECT   AES_DECRYPT(UNHEX('{$row->card_name}'),  '$private_key') AS card_name
							   , AES_DECRYPT(UNHEX('{$row->card_num}'),   '$private_key') AS card_num 
							   , AES_DECRYPT(UNHEX('{$row->card_month}'),   '$private_key') AS card_month 
							   , AES_DECRYPT(UNHEX('{$row->card_year}'), '$private_key') AS card_year ";
    $result_d = mysqli_query($connect, $sql_d) or die(mysqli_error($connect));
    $row_d = mysqli_fetch_array($result_d);

    //echo "status = ".$status;

    $card_name = $row_d['card_name'];
    $card_num = $row_d['card_num'];
    $card_month = $row_d['card_month'];
    $card_year = $row_d['card_year'];

    $p_sql = "select code_name from tbl_period where code_no = '" . $period . "' ";
    $p_result = mysqli_query($connect, $p_sql);
    $p_row = mysqli_fetch_array($p_result);

    $g_sql = "select * from tbl_goods where g_idx = '" . $g_idx . "' ";
    $g_result = mysqli_query($connect, $g_sql);
    $g_row = mysqli_fetch_array($g_result);
}
$titleStr = "제품상담신청 상세";
$links = "list.php";

$t_str = "";
if ($user_name != '') {
    $t_str .= $user_name . "\n";
}
if ($tel != '') {
    $t_str .= $tel . "\n";
}
if ($tel2 != '') {
    $t_str .= '설치시 ' . $tel2 . "\n";
}
if ($type == 'self') {
    $typeStr = "셀프관리";
} elseif ($type == 'visit') {
    $typeStr = "방문관리";
} elseif ($type == 'etc') {
    $typeStr = "기타";
}
if ($join_type == '1') {
    $t_str .= $g_row['goods_name_front'] . "(" . $g_row['goods_code_show'] . ") " . $typeStr . "\n";
} else {
    $t_str .= $goods_name . " " . $typeStr . "\n";
}

if ($addr1 != '' || $addr2 != '') {
    if ($addr1 != '') {
        $t_str .= $addr1;
        if ($addr2 != '') {
            $t_str .= " ";
        } else {
            $t_str .= "\n";
        }
    }
    if ($addr2 != '') {
        $t_str .= $addr2 . "\n";
    }
}

if ($birth != '' || $gender != '') {
    if ($birth != '') {
        $t_str .= $birth;
        if ($gender != '') {
            $t_str .= " ";
        } else {
            $t_str .= "\n";
        }
    }
    if ($gender != '') {
        if ($gender == 'M') {
            $t_str .= "남성\n";
        } else {
            $t_str .= "여성\n";
        }

    }
}

if ($payment == 'card') {
    if ($card_code) {
        $t_str .= $_pg_Card[$card_code] . "\n";
    } else {
        $t_str .= $card_name . "\n";
    }
    if ($card_num) {
        $t_str .= $card_num . "\n";
    }
    if ($card_month != '' || $card_year != '') {
        if ($card_month != '') {
            //업체요청으로 1~9일시 앞에 0붙임
            if (strlen($card_month) < 2) {
                $card_month = "0" . $card_month;
            }
            $t_str .= $card_month;
            if ($card_year != '') {
                $t_str .= " ";
            } else {
                $t_str .= "\n";
            }
        }
        if ($card_year != '') {
            $t_str .= substr($card_year, 2, 2) . "\n";
        }
    }
} else if ($payment == 'bank') {
    if ($bank != '') {
        $t_str .= $_pg_Bank[$bank] . "\n";
    } else {
        $t_str .= $bank_name . "\n";
    }
    if ($bank_num != '') {
        $t_str .= $bank_num . "\n";
    }
}

if ($email != '') {
    $t_str .= $email;
}
?>

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

    <div id="container" class="gnb_inquiry">
        <div id="print_this"><!-- 인쇄영역 시작 //-->

            <header id="headerContainer">
                <div class="inner">
                    <div class="menus">
                        <ul>

                            <li><a href="javascript:history.go(-1);" class="btn btn-secondary"><i
                                            class="bi bi-list"></i><span
                                            class="txt">리스트</span></a></li>
                            <li><a href="javascript:send_it('<?= $idx ?>')" class="btn btn-primary"><i
                                            class="bi bi-gear"></i><span class="txt">수정</span></a></li>
                            <li><a href="javascript:del_it()" class="btn btn-danger"><i class="bi bi-trash"></i><span
                                            class="txt">삭제</span></a></li>
                        </ul>
                    </div>
                </div>
                <!-- // inner -->

            </header>
            <!-- // headerContainer -->


            <div id="contents">
                <div class="listWrap_noline">

                    <div class="listBottom">

                        <div class="memo_wrap clearfix">
                            <div class="textarea fl">
                                <textarea name="" id=""><?= $t_str ?></textarea>
                            </div>
                            <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail fr"
                                   style="table-layout:fixed;">
                                <colgroup>
                                    <col width="100%"/>
                                </colgroup>
                                <tbody>
                                <tr height="45">
                                    <td style="background: #f5f5f5; font-weight: 500; font-size: 16px; color: #252525">
                                        상담 메모
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 0;">
                                        <textarea name="memo" id="memo"><?= strip_tags(nl2br($memo)) ?></textarea>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

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
                                    신청 정보
                                </td>
                            </tr>

                            <tr height="45">
                                <th>신청방법</th>
                                <td colspan='3'><?= ($join_type == '1' ? "가입신청" : ($join_type == '2' ? "다이렉트신청" : "")) ?></td>
                            </tr>

                            <tr height="45">
                                <th>상담 제품</th>
                                <td colspan='3'><?= ($join_type == '1' ? $g_row['goods_name_front'] . "(" . $g_row['goods_code_show'] . ")" : ($join_type == '2' ? $goods_name : "")) ?></td>
                            </tr>

                            <tr height="45">
                                <th>관리유형</th>
                                <td>
                                    <?
                                    if ($type == 'self') {
                                        echo "셀프관리";
                                    } elseif ($type == 'visit') {
                                        echo "방문관리";
                                    }
                                    if ($type == 'etc') {
                                        echo "기타";
                                    }
                                    ?>
                                </td>
                                <th>약정기간</th>
                                <td>
                                    <?= $p_row['code_name'] ?>
                                </td>
                            </tr>

                            <tr height="45">
                                <th>상태</th>
                                <td colspan='3'>
                                    <select name="status" id="status" onchange="status_chg('<?= $idx ?>', this.value)">
                                        <option value="1" <?= ($status == '1' ? "selected" : "") ?>>확인 중</option>
                                        <option value="2" <?= ($status == '2' ? "selected" : "") ?>>확인 완료</option>
                                        <option value="3" <?= ($status == '3' ? "selected" : "") ?>>보류</option>
                                    </select>
                                </td>
                                <!--
							<th>발송여부</th>
							<td >
								<select name="status" id="status" onchange="deli_chg('<?= $idx ?>', this.value)">
									<option value="1" <?= ($deli_status == '1' ? "selected" : "") ?>>미확인</option>
									<option value="2" <?= ($deli_status == '2' ? "selected" : "") ?>>발송</option>
									<option value="3" <?= ($deli_status == '3' ? "selected" : "") ?>>보류</option>
								</select>
							</td>
						-->
                            </tr>

                            </tbody>
                        </table>
                        <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail"
                               style="table-layout:fixed;">
                            <colgroup>
                                <col width="10%"/>
                                <col width="40%"/>
                                <col width="10%"/>
                                <col width="40%"/>
                            </colgroup>
                            <tbody>
                            <tr height='45'>
                                <td colspan='4'>
                                    고객정보
                                </td>
                            </tr>

                            <tr height="45">
                                <th>고객명</th>
                                <td><?= $user_name ?></td>
                                <th>이메일</th>
                                <td><?= $email ?></td>
                            </tr>

                            <tr height="45">
                                <th>연락처</th>
                                <td><?= $tel ?></td>
                                <th>연락처2</th>
                                <td><?= $tel2 ?></td>
                            </tr>

                            <tr height="45">
                                <th>성별</th>
                                <td><?= ($gender == 'M' ? "남성" : ($gender == 'F' ? "여성" : "")) ?></td>
                                <th>생년월일</th>
                                <td><?= $birth ?></td>
                            </tr>

                            <tr height="45">
                                <th>우편번호</th>
                                <td colspan='3'><?= $zipcode ?></td>

                            </tr>
                            <tr height="45">
                                <th>주소1</th>
                                <td><?= $addr1 ?></td>
                                <th>주소2</th>
                                <td><?= $addr2 ?></td>
                            </tr>

                            <tr height="45">
                                <th>설치날짜</th>
                                <td>
                                    <?= $i_date ?>
                                </td>
                                <th>쿠쿠렌탈 사용중</th>
                                <td>
                                    <?= ($cuckoo == 'Y' ? "예" : ($cuckoo == 'N' ? "아니오" : "")) ?>
                                </td>
                            </tr>
                            <tr height='45'>
                                <th>기타</th>
                                <td colspan='3'>
                                    <?= $etc ?>
                                </td>
                            </tr>

                            </tbody>
                        </table>

                        <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail"
                               style="table-layout:fixed;">
                            <colgroup>
                                <col width="10%"/>
                                <col width="40%"/>
                                <col width="10%"/>
                                <col width="40%"/>
                            </colgroup>
                            <tbody>
                            <tr height="45">
                                <td colspan='4'>타사보상 적용</td>
                            </tr>
                            <tr height="45">
                                <th>제조사 명</th>
                                <td colspan='3'>
                                    <?php
                                    $g_sql = "select * from tbl_third_party where code_no = '" . $manufacture . "' ";
                                    $g_result = mysqli_query($connect, $g_sql);
                                    $g_row = mysqli_fetch_array($g_result);
                                    ?>
                                    <?= $g_row['code_name'] ?>
                                </td>
                            </tr>
                            <tr height="45" class=''>
                                <th>설치 년월</th>
                                <td colspan="3"><?= $installation_year ?> - <?= $installation_month ?></td>
                            </tr>
                            <tr height="45" class=''>
                                <th>제품형태</th>
                                <td colspan="3">
                                    <?php
                                    $g_sql = "select * from tbl_third_party where code_no = '" . $product_form . "' ";
                                    $g_result = mysqli_query($connect, $g_sql);
                                    $g_row = mysqli_fetch_array($g_result);
                                    ?>

                                    <?= $g_row['code_name'] ?>
                                </td>
                            </tr>
                            <tr height="45" class=''>
                                <th>보유 제품 반납 여부</th>
                                <td colspan="3">
                                    <?php
                                    $g_sql = "select * from tbl_third_party where code_no = '" . $possession . "' ";
                                    $g_result = mysqli_query($connect, $g_sql);
                                    $g_row = mysqli_fetch_array($g_result);
                                    ?>

                                    <?= $g_row['code_name'] ?>
                                </td>
                            </tr>
                            <tr height="45" class=''>
                                <th>설치형태</th>
                                <td>
                                    <?php
                                    $g_sql = "select * from tbl_third_party where code_no = '" . $installation_type . "' ";
                                    $g_result = mysqli_query($connect, $g_sql);
                                    $g_row = mysqli_fetch_array($g_result);
                                    ?>

                                    <?= $g_row['code_name'] ?>
                                </td>
                                <th>제품품종류</th>
                                <td>
                                    <?php
                                    $g_sql = "select * from tbl_third_party where code_no = '" . $product_type . "' ";
                                    $g_result = mysqli_query($connect, $g_sql);
                                    $g_row = mysqli_fetch_array($g_result);
                                    ?>

                                    <?= $g_row['code_name'] ?>
                                </td>
                            </tr>
                            <tr height="45" class=''>
                                <th>KC인증번호</th>
                                <td colspan="3"><?= $kc_number ?></td>
                            </tr>
                            </tbody>
                        </table>
                        <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail"
                               style="table-layout:fixed;">
                            <colgroup>
                                <col width="10%"/>
                                <col width="40%"/>
                                <col width="10%"/>
                                <col width="40%"/>
                            </colgroup>
                            <tbody>
                            <tr height='45'>
                                <td colspan='4'>사은품 선택</td>
                            </tr>

                            <tr height="45" class=''>
                                <th>상세페이지내의 렌탈혜택을 확인해주세요</th>
                                <td colspan='3'>
                                    <?= $gift_code ?>
                                </td>
                            </tr>

                            </tbody>
                        </table>

                        <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail"
                               style="table-layout:fixed;">
                            <colgroup>
                                <col width="10%"/>
                                <col width="40%"/>
                                <col width="10%"/>
                                <col width="40%"/>
                            </colgroup>
                            <tbody>
                            <tr height="45">
                                <td colspan='4'>결제방법</td>
                            </tr>
                            <tr height="45">
                                <th>결제방법</th>
                                <td colspan='3'>
                                    <?= ($payment == "card" ? "카드" : ($payment == "bank" ? "계좌" : "")) ?>
                                </td>
                            </tr>
                            <tr height="45" class='card_wrap'>
                                <th>카드사</th>
                                <td>
                                    <?
                                    if ($card_code) {
                                        echo $_pg_Card[$card_code];
                                    } else {
                                        echo $card_name;
                                    }
                                    ?>
                                </td>
                                <th>카드번호</th>
                                <td><?= $card_num ?></td>
                            </tr>
                            <tr height="45" class='card_wrap'>
                                <th>유효기간 월</th>
                                <td><?= str_replace('ABC', '', $card_month) ?>월</td>
                                <th>유효기간 년</th>
                                <td><?= str_replace('ABC', '', $card_year) ?>년</td>
                            </tr>
                            <tr height="45" class='bank_wrap'>
                                <th>은행명</th>
                                <td>
                                    <?
                                    if ($bank) {
                                        echo $_pg_Bank[$bank];
                                    } else {
                                        echo $bank_name;
                                    }
                                    ?>
                                </td>
                                <th>계좌번호</th>
                                <td><?= $bank_num ?></td>
                            </tr>
                            </tbody>
                        </table>
                        <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail"
                               style="table-layout:fixed;">
                            <colgroup>
                                <col width="12%"/>
                                <col width="38%"/>
                                <col width="10%"/>
                                <col width="40%"/>
                            </colgroup>
                            <tbody>
                            <tr height='45'>
                                <td colspan='4'>사업자여부</td>
                            </tr>
                            <tr height="45">
                                <th>사업자 구분</th>
                                <td colspan='3'><?= ($business == 'p' ? "개인 사업자" : ($business == 'c' ? "법인 사업자" : ($business == 'n' ? "없음" : ""))) ?></td>
                            </tr>
                            <tr height="45" class='business_wrap'>
                                <th>첨부파일1<br>사업자등록증 사본</th>
                                <td colspan='3'>
                                    <a href="/include/dn.php?mode=consult&ufile=<?= $ufile1 ?>&rfile=<?= $rfile1 ?>"><?= $rfile1 ?></a>
                                </td>
                            </tr>
                            <tr height="45" class='business_wrap'>
                                <th>첨부파일2<br>통장사본 또는 카드사본</th>
                                <td colspan='3'>
                                    <a href="/include/dn.php?mode=consult&ufile=<?= $ufile2 ?>&rfile=<?= $rfile2 ?>"><?= $rfile2 ?></a>
                                </td>
                            </tr>

                            </tbody>
                        </table>


                    </div>


                </div>
                <!-- // listWrap -->

            </div>
            <!-- // contents -->

        </div><!-- 인쇄 영역 끝 //-->
    </div>
    <script>
        function status_chg(idx, val) {
            $.ajax({
                url: "status_chg_join.php"
                , data: "idx=" + idx + "&status=" + val
                , type: "POST"
                , error: function (request, status, error) {
                    alert("CODE : " + request.status + "\r\nmessage : " + request.reponseText);
                    return false;
                }
                , success: function (response, status, request) {
                    response = response.trim();
                    if (response == "OK") {
                        alert_("상태값이 변경되었습니다.");
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else {
                        alert(response);
                        alert_("오류가 발생하였습니다.");
                        return false;
                    }
                }
            })
        }

        function deli_chg(idx, val) {
            $.ajax({
                url: "deli_chg_ajax.php"
                , data: "idx=" + idx + "&deli_status=" + val
                , type: "POST"
                , error: function (request, status, error) {
                    alert("CODE : " + request.status + "\r\nmessage : " + request.reponseText);
                    return false;
                }
                , success: function (response, status, request) {
                    response = response.trim();
                    if (response == "OK") {
                        alert_("발송여부값 변경되었습니다.");
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else {
                        alert(response);
                        alert_("오류가 발생하였습니다.");
                        return false;
                    }
                }
            })
        }

        function del_it() {
            var idx = "<?=$idx?>";

            if (confirm("삭제하시겠습니까?\r\n삭제 후에는 복구가 불가능합니다.") == false) {
                return false;
            } else {
                $.ajax({
                    url: "join_del.php"
                    , data: "idx=" + idx
                    , type: "GET"
                    , error: function (request, status, error) {
                        alert("CODE : " + request.status + "\r\nmessage : " + request.reponseText);
                        return false;
                    }
                    , success: function (response, status, request) {
                        response = response.trim();
                        if (response == "OK") {
                            alert_("삭제되었습니다.");
                            setTimeout(function () {
                                location.href = './list_join.php';
                            }, 1000);
                        } else {
                            alert(response);
                            alert_("오류가 발생하였습니다.");
                            return false;
                        }
                    }
                })
            }
        }

        $(function () {
            var payment = '<?=$payment?>';
            var business = '<?=$business?>';

            if (payment == 'card') {
                $(".card_wrap").show();
                $(".bank_wrap").hide();
            }
            if (payment == 'bank') {
                $(".bank_wrap").show();
                $(".card_wrap").hide();
            }

            if (business == 'n') {
                $('.business_wrap').hide();
            }
        })

        function send_it(idx) {

            $.ajax({
                url: "./join_write_ok.php"
                , data: "idx=" + idx + "&memo=" + $("#memo").val()
                , type: "POST"
                , error: function (request, status, error) {
                    alert("CODE : " + request.status + "\r\nmessage : " + request.responseText + "\r\nerror : " + error);
                    return false;
                }
                , success: function (response, status, request) {
                    response = response.trim();
                    if (response == "OK") {
                        alert_("수정했습니다.");
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else {
                        alert(response);
                        alert_("오류가 발생하였습니다.");
                        return false;
                    }
                }
            })
        }
    </script>

<? include "../_include/_footer.php"; ?>