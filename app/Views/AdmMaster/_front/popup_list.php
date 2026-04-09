<? include "../_include/_header.php"; ?>
<?
$g_list_rows = 10;
$total_sql = " select * from tbl_popup where 1=1 ";
$result = mysqli_query($connect, $total_sql) or die (mysql_error());
$nTotalCount = mysqli_num_rows($result);
?>
<div class="page-heading mb-4">
    
    <div class="d-flex justify-content-between align-items-center">
        <header class="d-block d-xl-none pb-2">
            <a href="#" class="d-block burger-btn d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <h4 class="text-center">팝업관리</h4>
    </div>
</div>
    <div id="container" class="gnb_operator">
        <div id="print_this"><!-- 인쇄영역 시작 //-->

            <header id="headerContainer">

                <div class="inner">
                    <div class="menus">
                        <ul class="first">
                            <li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), true)"
                                   class="btn btn-success">전체선택</a></li>
                            <li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), false)"
                                   class="btn btn-success">선택해체</a></li>
                            <li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li>
                        </ul>

                        <ul class="last">
                            <li><a href="popup_detail.php" class="btn btn-primary"><span
                                            class="glyphicon glyphicon-pencil"></span> <span
                                            class="txt">팝업창 등록</span></a></li>
                        </ul>

                    </div>

                </div><!-- // inner -->

            </header><!-- // headerContainer -->

            <div id="contents">

                <div class="listWrap">
                    <!-- 안내 문구 필요시 구성 //-->
                    <div class="guide_box">
                        - 미리보기 이미지 클릭시 리스트에서 팝업창 화면을 미리 확인 하실 수 있습니다.<br/>
                        - 강제 노출/비노출 기능은 팝업창 오픈 일정과 상관없이 강제로 팝업창을 띄우거나 제거하는 기능입니다.
                    </div>


                    <div class="listTop d-flex justify-content-between mb-4">
                        <div class="left">
                            <p class="schTxt">■ 총 <?= $nTotalCount ?>개의 목록이 있습니다.</p>
                        </div>
                        <form name="search" id="search">
                            <header id="headerContents" class="r_box d-flex" style="gap: 10px;">
                                <select id="" name="s_status" class="form-select input_select" style="width:112px">
                                    <option value="" selected="selected">전체</option>
                                    <option value="A" <? if ($s_status == "A") {
                                        echo "selected";
                                    } ?>>일정별 자동노출
                                    </option>
                                    <option value="B" <? if ($s_status == "B") {
                                        echo "selected";
                                    } ?>>강제 노출
                                    </option>
                                    <option value="C" <? if ($s_status == "C") {
                                        echo "selected";
                                    } ?>>강제 비노출
                                    </option>
                                </select>

                                <select id="" name="search_category" class="form-select input_select" style="width:112px">
                                    <option value="">전체</option>
                                    <option value="P_SUBJECT" <? if ($search_category == "P_SUBJECT") {
                                        echo "selected";
                                    } ?>>제목
                                    </option>
                                    <option value="P_CONTENT" <? if ($search_category == "P_CONTENT") {
                                        echo "selected";
                                    } ?>>내용
                                    </option>
                                </select>


                                <input type="text" id="" name="search_name" value="<?= $search_name ?>"
                                    class="form-control input_txt placeHolder" rel="검색어 입력" style="width:240px; height: 30px"/>

                                <a href="javascript:search_it()" class="btn btn-sm btn-primary"><span
                                            class="glyphicon glyphicon-search"></span> <span class="txt">검색하기</span></a>
                            </header><!-- // headerContents -->
                        </form>
                        <script>
                            function search_it() {
                                var frm = document.search;
                                if (frm.search_name.value == "검색어 입력") {
                                    frm.search_name.value = "";
                                }
                                frm.submit();
                            }
                        </script>

                    </div><!-- // listTop -->


                    <form name="frm" id="frm">
                        <div class="listBottom">
                            <table cellpadding="0" cellspacing="0" summary="" class="listTable">
                                <caption></caption>
                                <colgroup>
                                    <col width="4%"/>
                                    <col width="4%"/>
                                    <col width="11%"/>
                                    <col width="*"/>
                                    <col width="12%"/>
                                    <col width="12%"/>
                                    <col width="12%"/>
                                    <col width="10%"/>
                                </colgroup>
                                <thead>
                                <tr>
                                    <th>선택</th>
                                    <th>번호</th>
                                    <th>사용여부</th>
                                    <th>팝업창 제목</th>
                                    <th>노출기기</th>
                                    <th>시작일</th>
                                    <th>종료일</th>
                                    <th>관리</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $nPage = ceil($nTotalCount / $g_list_rows);
                                if ($pg == "") $pg = 1;
                                $nFrom = ($pg - 1) * $g_list_rows;

                                $sql = $total_sql . " order by idx desc limit $nFrom, $g_list_rows ";
                                $result = mysqli_query($connect, $sql) or die (mysql_error());
                                $num = $nTotalCount - $nFrom;
                                while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" name="idx[]" class="idx" value="<?= $row[idx] ?>"
                                                   class="input_check"/></td>
                                        <td><?= $num-- ?></td>
                                        <td>
                                            <select name="status"
                                                    onchange="javascrpit:chk_status('<?= $row[idx] ?>', this.value);"
                                                    class="input_select">
                                                <option value="A" <? if ($row[status] == "A") {
                                                    echo "selected";
                                                } ?>>일정별 자동노출
                                                </option>
                                                <option value="B" <? if ($row[status] == "B") {
                                                    echo "selected";
                                                } ?>>강제 노출
                                                </option>
                                                <option value="C" <? if ($row[status] == "C") {
                                                    echo "selected";
                                                } ?>>강제 비노출
                                                </option>
                                            </select>
                                        </td>
                                        <td class="tal program_title"><a href="./popup_detail.php?idx=<?= $row[idx] ?>"><span
                                                        class="txt_blue bold"><?= $row[P_SUBJECT] ?></span></a></td>

                                        <td>
                                            <?
                                            if ($row['is_mobile'] == "P")
                                                echo "PC";
                                            else
                                                echo "MOBILE";
                                            ?>
                                        </td>
                                        <td><?= $row['P_STARTDAY'] ?> <?= $row['P_START_HH'] ?>
                                            :<?= $row['P_START_MM'] ?></td>
                                        <td><?= $row['P_ENDDAY'] ?> <?= $row['P_END_HH'] ?>:<?= $row['P_END_MM'] ?></td>
                                        <td scope="row" class="text-center">
                                            <a href="./popup_detail.php?idx=<?= $row['idx'] ?>"
                                                class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                                            <a href="javascript:del_it(<?= $row['idx'] ?>)" class="btn btn-danger"><i
                                                    class="bi bi-trash"></i></a>
                                        </td>
                                        <!-- <td>
                                            <a href="./popup_detail.php?idx=<?= $row['idx'] ?>"><img
                                                        src="/AdmMaster/_images/common/ico_setting2.png" alt="설정"/></a>
                                            <a href="javascript:del_it('<?= $row['idx'] ?>');"><img
                                                        src="/AdmMaster/_images/common/ico_error.png" alt="에러"/></a>
                                        </td> -->
                                    </tr>
                                <? } ?>


                                </tbody>
                            </table>
                        </div><!-- // listBottom -->
                    </form>

                    <? echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF] . "?s_status=$s_status&search_category=$search_category&search_name=$search_name&pg=") ?>


                    <div id="headerContainer">

                        <div class="inner">
                            <div class="menus">
                                <ul class="first">
                                    <li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), true)"
                                           class="btn btn-success">전체선택</a></li>
                                    <li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), false)"
                                           class="btn btn-success">선택해체</a></li>
                                    <li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li>
                                </ul>

                                <ul class="last">
                                    <li><a href="popup_detail.php" class="btn btn-primary"><span
                                                    class="glyphicon glyphicon-pencil"></span> <span
                                                    class="txt">팝업창 등록</span></a></li>
                                </ul>

                            </div>

                        </div><!-- // inner -->

                    </div><!-- // headerContainer -->
                </div><!-- // listWrap -->

            </div><!-- // contents -->


        </div><!-- 인쇄 영역 끝 //-->
    </div><!-- // container -->


    <script>
        function CheckAll(checkBoxes, checked) {
            var i;
            if (checkBoxes.length) {
                for (i = 0; i < checkBoxes.length; i++) {
                    checkBoxes[i].checked = checked;
                }
            } else {
                checkBoxes.checked = checked;
            }

        }

        function SELECT_DELETE() {
            if ($(".idx").is(":checked") == false) {
                alert_("삭제할 내용을 선택하셔야 합니다.");
                return;
            }
            if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false) {
                return;
            }

            $("#ajax_loader").removeClass("display-none");

            $.ajax({
                url: "popup_del.php",
                type: "POST",
                data: $("#frm").serialize(),
                error: function (request, status, error) {
                    //통신 에러 발생시 처리
                    alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
                    $("#ajax_loader").addClass("display-none");
                }
                , complete: function (request, status, error) {
//				$("#ajax_loader").addClass("display-none");
                }
                , success: function (response, status, request) {
                    if (response == "OK") {
                        alert_("정상적으로 삭제되었습니다.");
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        return;
                    } else {
                        alert(response);
                        alert_("오류가 발생하였습니다!!");
                        return;
                    }
                }
            });

        }

        function del_it(idx) {

            if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false) {
                return;
            }
            $("#ajax_loader").removeClass("display-none");
            $.ajax({
                url: "popup_del.php",
                type: "POST",
                data: "idx[]=" + idx,
                error: function (request, status, error) {
                    //통신 에러 발생시 처리
                    alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
                    $("#ajax_loader").addClass("display-none");
                }
                , complete: function (request, status, error) {
//				$("#ajax_loader").addClass("display-none");
                }
                , success: function (response, status, request) {
                    if (response == "OK") {
                        alert_("정상적으로 삭제되었습니다.");
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        return;
                    } else {
                        alert(response);
                        alert_("오류가 발생하였습니다!!");
                        return;
                    }
                }
            });

        }

        function chk_status(idx, status) {
            $.ajax({
                url: "popup_status.ajax.php",
                type: "POST",
                data: "idx[]=" + idx + "&status=" + status,
                error: function (request, status, error) {
                    //통신 에러 발생시 처리
                    alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
                    $("#ajax_loader").addClass("display-none");
                }
                , complete: function (request, status, error) {
//				$("#ajax_loader").addClass("display-none");
                }
                , success: function (response, status, request) {
                    if (response == "OK") {
                        alert_("정상적으로 현황이 변경되었습니다.");
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
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