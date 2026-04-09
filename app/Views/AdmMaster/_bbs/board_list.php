<? include "../_include/_header.php"; ?>
<?
include $_SERVER[DOCUMENT_ROOT] . "/AdmMaster/include/bbs_info.inc.php";
$scategory = updateSQ($_GET[scategory]);
$search_word = updateSQ($_GET[search_word]);
$search_mode = updateSQ($_GET[search_mode]);
$is_category = isBoardCategory($code);
$g_list_rows = 10;

if ($search_word != "") {
    if ($search_mode != "") {
        $strSql = " and $search_mode like '%$search_word%' ";
    } else {
        $strSql = " and (subject like '%$search_word%' or contents like '%$search_word%') ";
    }
}
if ($scategory != "") {
    $strSql = $strSql . " and category = '$scategory'";
}
$strSql = $strSql . " and code = '$code'";
$total_sql = " select *, (select subject from tbl_bbs_category where tbl_bbs_category.tbc_idx=tbl_bbs_list.category) as category, (select count(*) from tbl_bbs_comment where tbl_bbs_comment.bbs_idx=tbl_bbs_list.bbs_idx) as comment_cnt  from tbl_bbs_list where 1=1 " . $strSql;
$result = mysqli_query($connect, $total_sql) or die (mysql_error());
$nTotalCount = mysqli_num_rows($result);


//카테고리가 있을때 정보 노출
if ($is_category == "Y" && $scategory != "") {
    $fsql_c = " select subject from tbl_bbs_category where code='$code' and tbc_idx = '$scategory'";
    $fresult_c = mysqli_query($connect, $fsql_c) or die (mysqli_error($connect));
    $frow_c = mysqli_fetch_array($fresult_c);
    $sel_cates = " - " . $frow_c['subject'];
}

?>
<div class="page-heading mb-4">
    
    <div class="d-flex justify-content-between align-items-center">
        <header class="d-block d-xl-none pb-2">
            <a href="#" class="d-block burger-btn d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <?php if($code == 'banner') {?>
        <h4 class="text-center">배너 이미지관리</h4>
        <?php } else {?>
            <h4 class="text-center"><?= getBoardName($code) ?><?= $sel_cates ?></h4>
        <?php }?>
    </div>
</div>
<div id="container"
     class="<? if (strpos($_SERVER[PHP_SELF], "/AdmMaster/_counsel/") !== false || $code == "qna" || $code == "ContactUs") { ?>gnb_inquiry<? } else if ($code == "notice" || $code == "faq" || $code == "event" || $code == "event_notice") { ?>gnb_center<? } else if ($code == "banner") { ?>gnb_banner<? } ?>">
    <div id="print_this"><!-- 인쇄영역 시작 //-->
        <?php if($code == 'banner') {?>
        <div class="d-flex justify-content-between gap-2 w-100 ps-3 pe-3">
             <form action="" method="GET">
                <input type="hidden" name="code" value="<?= $code ?>">

                <div class="input-group">
                    <input type="text" class="form-control" name="search_word" style="width: 200px;" placeholder="Search" aria-label="Search" value="<?= $search_word ?>">
                    <button class="btn btn-light"><i class="bi bi-search"></i></button>
                        <select name="scategory" id="scategory" class="form-select w-auto ms-2" style="height: 39px; width: 100px"
                            data-placeholder="수입사보기"
                            onchange="this.form.submit()">
                            <option value="">전체</option>
						    <?
                            $fsql = " select * from tbl_bbs_category where code='$code' order by onum desc";
                            $fresult = mysqli_query($connect, $fsql) or die (mysqli_error($connect));
                            while ($frow = mysqli_fetch_array($fresult)) {
                                ?>
                                <option value="<?= $frow["tbc_idx"] ?>" <? if ($frow["tbc_idx"] == $scategory) {
                                        echo "selected";
                                    } ?>><?= $frow["subject"] ?></option>
                            <?php } ?>
						</select>
                </div>
            </form>
            <header id="headerContainer" class="w-50" style="min-width: unset">
                <div class="inner">
                    <!-- <h2><?= getBoardName($code) ?><?= $sel_cates ?></h2> -->
                    <div class="menus">
                        <ul class="first">
                            <li><a href="javascript:CheckAll(document.getElementsByName('bbs_idx[]'), true)"
                                class="btn btn-success">전체선택</a></li>
                            <li><a href="javascript:CheckAll(document.getElementsByName('bbs_idx[]'), false)"
                                class="btn btn-success">선택해체</a></li>
                            <li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li>
                        </ul>
                        <ul class="last">
                            <? if ($code == "banner") { ?>
                                <li><a href="javascript:change_it()" class="btn btn-success">순위변경</a></li>
                            <? } ?>
                            <li><a href="board_write.php?code=<?= $code ?>&scategory=<?= $scategory ?>"
                                class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span
                                            class="txt">글 등록</span></a></li>
                        </ul>

                    </div>

                </div><!-- // inner -->

            </header>
        </div>
        <?php } else {?>
        <header id="headerContainer">
            <div class="inner">
                <!-- <h2><?= getBoardName($code) ?><?= $sel_cates ?></h2> -->
                <div class="menus">
                    <ul class="first">
                        <li><a href="javascript:CheckAll(document.getElementsByName('bbs_idx[]'), true)"
                               class="btn btn-success">전체선택</a></li>
                        <li><a href="javascript:CheckAll(document.getElementsByName('bbs_idx[]'), false)"
                               class="btn btn-success">선택해체</a></li>
                        <li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li>
                    </ul>
                    <ul class="last">
                        <? if ($code == "banner") { ?>
                            <li><a href="javascript:change_it()" class="btn btn-success">순위변경</a></li>
                        <? } ?>
                        <li><a href="board_write.php?code=<?= $code ?>&scategory=<?= $scategory ?>"
                               class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span
                                        class="txt">글 등록</span></a></li>
                    </ul>

                </div>

            </div><!-- // inner -->

        </header><!-- // headerContainer -->
        <?php }?>
        <div id="contents">

            <FORM NAME="frmSearch" Method="GET" class="frmsearch">
                <INPUT TYPE="hidden" NAME="code" VALUE="<?= $code ?>">
                <INPUT TYPE="hidden" NAME="scategory" VALUE="<?= $scategory ?>">
                <header id="headerContents" style="display: flex; justify-content: center;align-items: center;">
                    <p>
                        <? if ($isCategory == "Y") { ?>
                            <!--
						<select name="scategory" class="input_select">
							<option value="">선택</option>
						<?
                            $fsql = " select * from tbl_bbs_category where code='$code' order by onum desc";
                            $fresult = mysqli_query($connect, $fsql) or die (mysqli_error($connect));
                            while ($frow = mysqli_fetch_array($fresult)) {
                                ?>
							<option value="<?= $frow["tbc_idx"] ?>" <? if ($frow["tbc_idx"] == $scategory) {
                                    echo "selected";
                                } ?>><?= $frow["subject"] ?></option>
						<?
                            }
                            ?>
						</select>
						-->
                        <? } ?>


                        <input type="radio" name="search_mode" value="" <? if ($search_mode == "") {
                            echo "checked";
                        } ?>> 전체 &nbsp; &nbsp;
                        <input type="radio" name="search_mode" value="subject" <? if ($search_mode == "subject") {
                            echo "checked";
                        } ?>> 제목 &nbsp; &nbsp;
                        <input type="radio" name="search_mode" value="contents" <? if ($search_mode == "contents") {
                            echo "checked";
                        } ?>> 내용 &nbsp; &nbsp;
                        <input type="radio" name="search_mode" value="writer" <? if ($search_mode == "writer") {
                            echo "checked";
                        } ?>> 작성자 &nbsp; &nbsp;
                        <div class="input-group" style="width: unset">
                            <input type="text" id="search_word" name="search_word" value="<?=$search_word?>" class="form-control placeHolder" placeholder="검색어 입력" style="width:240px"/>
                            <!-- <input type="text" class="form-control" name="search_txt" placeholder="Search" aria-label="Search" value=""> -->
                            <a class="btn btn-light" href="javascript:document.frmSearch.submit();"><i class="bi bi-search"></i></a>
                        </div>
                        <!-- <input type="text" id="" name="search_word" value='<?= $search_word ?>'
                               class="input_txt placeHolder" rel="검색어 입력" style="width:240px"/>
                        <a href="javascript:document.frmSearch.submit();" class="btn btn-default"><span
                                    class="glyphicon glyphicon-search"></span> <span class="txt">검색하기</span></a> -->
                    </p>
                </header><!-- // headerContents -->
            </form>
            <script>
                function search_it() {
                    var frm = document.frmSearch;
                    if (frm.search_word.value == "검색어 입력") {
                        frm.search_word.value = "";
                    }
                    frm.submit();
                }
            </script>


            <div class="listWrap">


                <div class="listTop frmsearch">
                    <div class="left">
                        <p class="schTxt">■ 총 <?= $nTotalCount ?>개의 목록이 있습니다.</p>
                    </div>


                </div><!-- // listTop -->


                <?
                if ($code == "gallery" || $code == "media") {
                    include "./photo.inc.php";
                } else {
                    if ($code == "qna") {
                        include "./list2.inc.php";
                    } else if ($code == "banner") {
                        include "./list_banner.inc.php";
                    } else {
                        include "./list.inc.php";
                    }
                }
                ?>


                <? echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF] . "?scategory=$scategory&search_mode=" . $search_mode . "&search_word=" . $search_word . "&code=" . $code . "&pg=") ?></td>

                <div id="headerContainer">

                    <div class="inner">
                        <h2><?= getBoardName($code) ?></h2>
                        <div class="menus">
                            <ul class="first">
                                <li><a href="javascript:CheckAll(document.getElementsByName('bbs_idx[]'), true)"
                                       class="btn btn-success">전체선택</a></li>
                                <li><a href="javascript:CheckAll(document.getElementsByName('bbs_idx[]'), false)"
                                       class="btn btn-success">선택해체</a></li>
                                <li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li>
                            </ul>
                            <ul class="last">
                                <li><a href="board_write.php?code=<?= $code ?>&scategory=<?= $scategory ?>"
                                       class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span
                                                class="txt">글 등록</span></a></li>
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
        if ($(".bbs_idx:checked").length === 0) {
            alert_("삭제할 게시물을 선택하셔야 합니다.");
            return;
        }

        if (!confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.")) {
            return;
        }

        $("#ajax_loader").removeClass("display-none");

        $.ajax({
            url: "bbs_del.ajax.php",
            type: "POST",
            data: $("#lfrm").serialize(),
            success: function (response) {
                response = response.trim();
                if (response === "OK") {
                    alert_("정상적으로 삭제되었습니다.");
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    alert_("오류가 발생하였습니다!! " + response);
                }
            },
            error: function (request) {
                alert_("code : " + request.status + "\r\nmessage : " + request.responseText);
                $("#ajax_loader").addClass("display-none");
            }
        });
    }



    function del_chk(bbs_idx) {
        if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false) {
            return;
        }
        $("#ajax_loader").removeClass("display-none");
        $.ajax({
            url: "bbs_del.ajax.php",
            type: "POST",
            data: "bbs_idx[]=" + bbs_idx,
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


    function change_it() {
        $.ajax({
            url: "change.php",
            type: "POST",
            data: $("#lfrm").serialize(),
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
