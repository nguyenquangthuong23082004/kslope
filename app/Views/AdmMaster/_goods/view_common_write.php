<? include "../_include/_header.php"; ?>
<script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js"></script>
<script type="text/javascript" src="./write.js"></script>
<?

$sql                    = " select * from tbl_goods_banner limit 0, 1";
$result                    = mysqli_query($connect, $sql) or die(mysql_error($connect));
$row                    = mysqli_fetch_object($result);

foreach ($row as $keys => $vals) {
    //echo $keys . " => " . $vals . "<br/>";
    ${$keys} = $vals;
}


$titleStr = "상품상세배너 수정";
//$links = "list.php";

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
<div id="container" class="gnb_goods"> <span id="print_this"><!-- 인쇄영역 시작 //-->

        <header id="headerContainer">
            <div class="inner">
                <div class="menus">
                    <ul>
                        <!--
					<li><a href="<?= $links ?>?search_gubun=<?= $search_gubun ?>&search_category=<?= $search_category ?>&search_name=<?= $search_name ?>&pg=<?= $pg ?>" class="btn btn-secondary"><i class="bi bi-list"></i><span class="txt">리스트</span></a></li>
					-->
                        <!-- <li><a href="javascript:history.go(-1);" class="btn btn-secondary"><i class="bi bi-list"></i><span class="txt">리스트</span></a></li> -->


                        <? if ($idx) { ?>
                            <li><a href="javascript:send_it()" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">수정</span></a></li>
                            <!-- <li><a href="javascript:del_it()" class="btn btn-danger"><i class="bi bi-trash"></i><span class="txt">삭제</span></a></li> -->
                        <? } else { ?>
                            <li><a href="javascript:send_it()" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">등록</span></a></li>
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
                <form name="frm" id="frm" action="view_common_write_ok.php" method="post" enctype="multipart/form-data" target="hiddenFrame22"> <!--  -->
                    <input type="hidden" name="idx" value='<?= $idx ?>'>
                    <div class="listBottom">
                        <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail" style="table-layout:fixed;">
                            <caption>
                            </caption>
                            <colgroup>
                                <col width="20%" />
                                <col width="80%" />
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>사용유무</th>
                                    <td>
                                        <input type="radio" name='useYN1' id='b_use_1' value='Y' <?= ($useYN1 == 'Y' || $useYN1 == '' ? "checked" : "") ?>>
                                        <label for="b_use_1">사용</label>
                                        <input type="radio" name="useYN1" id="b_use_2" value='N' <?= ($useYN1 == 'N' ? "checked" : "") ?>>
                                        <label for="b_use_2">사용안함</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>PC이미지</th>
                                    <td>
                                        <input type="file" name='ufile1' id="ufile1" value='<?= $ufile1 ?>'>
                                        <? if ($ufile1) { ?>
                                            <p class="martop"><input type=checkbox name="del_1" value="Y" class="input_check">
                                                삭제
                                                <a href="/data/goods_banner/<?= $ufile1 ?>" class="imgpop">
                                                    <img src="/data/goods_banner/<?= $ufile1 ?>" class="programlist">
                                                </a>
                                                <button type="button" class="btn-preview" data-img="/data/goods_banner/<?= $ufile1 ?>">
                                                    미리보기
                                                </button>
                                            </p>
                                        <? } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>모바일이미지</th>
                                    <td>
                                        <input type="file" name='ufile2' id="ufile2" value='<?= $ufile2 ?>'>
                                        <? if ($ufile2) { ?>
                                            <p class="martop"><input type=checkbox name="del_2" value="Y" class="input_check">
                                                삭제
                                                <a href="/data/goods_banner/<?= $ufile2 ?>" class="imgpop">
                                                    <img src="/data/goods_banner/<?= $ufile2 ?>" class="programlist">
                                                </a>
                                                <button type="button" class="btn-preview" data-img="/data/goods_banner/<?= $ufile2 ?>">
                                                    미리보기
                                                </button>
                                            </p>
                                        <? } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>사은품공통배너</th>
                                    <td>
                                        <input type="radio" name='useYN2' id="f_use_1" value='Y' <?= ($useYN2 == 'Y' || $useYN2 == '' ? "checked" : "") ?>>
                                        <label for="f_use_1">사용</label>
                                        <input type="radio" name="useYN2" id="f_use_2" value='N' <?= ($useYN2 == 'N' ? "checked" : "") ?>>
                                        <label for="f_use_2">사용안함</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>PC이미지</th>
                                    <td>
                                        <input type="file" name='ufile3' id="ufile3" value='<?= $ufile3 ?>'>
                                        <? if ($ufile3) { ?>
                                            <p class="martop"><input type=checkbox name="del_3" value="Y" class="input_check">
                                                삭제
                                                <a href="/data/goods_banner/<?= $ufile3 ?>" class="imgpop">
                                                    <img src="/data/goods_banner/<?= $ufile3 ?>" class="programlist">
                                                </a>
                                                <button type="button" class="btn-preview" data-img="/data/goods_banner/<?= $ufile3 ?>">
                                                    미리보기
                                                </button>
                                            </p>
                                        <? } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>모바일이미지</th>
                                    <td>
                                        <input type="file" name='ufile4' id="ufile4" value='<?= $ufile4 ?>'>
                                        <? if ($ufile4) { ?>
                                            <p class="martop"><input type=checkbox name="del_4" value="Y" class="input_check">
                                                삭제
                                                <a href="/data/goods_banner/<?= $ufile4 ?>" class="imgpop">
                                                    <img src="/data/goods_banner/<?= $ufile4 ?>" class="programlist">
                                                </a>
                                                <button type="button" class="btn-preview" data-img="/data/goods_banner/<?= $ufile4 ?>">
                                                    미리보기
                                                </button>
                                            </p>
                                        <? } ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>





                        <div class="tail_menu">
                            <ul>
                                <li class="left"></li>
                                <li class="right_sub">
                                    <!--
						<a href="<?= $links ?>?search_gubun=<?= $search_gubun ?>&search_category=<?= $search_category ?>&search_name=<?= $search_name ?>&pg=<?= $pg ?>" class="btn btn-secondary"><i class="bi bi-list"></i><span class="txt">리스트</span></a>
						-->
                                    <!-- <a href="javascript:history.go(-1);" class="btn btn-secondary"><i class="bi bi-list"></i><span class="txt">리스트</span></a> -->
                                    <? if ($idx == "") { ?>
                                        <a href="javascript:send_it()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">등록</span></a>
                                    <? } else { ?>
                                        <a href="javascript:send_it()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a>
                                        <!-- <a href="javascript:del_it()" class="btn btn-danger"><i class="bi bi-trash"></i><span class="txt">삭제</span></a> -->
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
<div id="imgPreviewModal" class="preview-modal" style="display:none;">
    <div class="preview-modal-bg"></div>

    <div class="preview-modal-content">

        <button type="button" class="close-preview-x">✕</button>

        <img id="previewImage" src="" alt="미리보기" />
    </div>
</div>



<iframe width="0" height="0" name="hiddenFrame22" id="hiddenFrame22" style="display:none;"></iframe>

<? include "../_include/_footer.php"; ?>

<!--

oEditors1.getById["info1_ko"].exec("UPDATE_CONTENTS_FIELD", []);
oEditors2.getById["info1_ko"].exec("UPDATE_CONTENTS_FIELD", []);

-->
<script type="text/javascript">
    function send_it() {
        var frm = document.frm;

        frm.submit();
    }
</script>

<style>
    .preview-modal {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .preview-modal-bg {
        position: absolute;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
    }

    .preview-modal-content {
        position: relative;
        background: #fff;
        padding: 10px;
        border-radius: 8px;
        max-width: 80%;
        max-height: 80%;
        text-align: center;
    }

    .preview-modal-content img {
        max-width: 100%;
        max-height: 70vh;
        display: block;
        margin: 0 auto;
    }

    .close-preview-x {
        position: absolute;
        right: 10px;
        top: 10px;
        background: #000;
        color: #fff;
        border: none;
        width: 28px;
        height: 28px;
        font-size: 18px;
        line-height: 28px;
        border-radius: 4px;
        cursor: pointer;
        opacity: 0.7;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .close-preview-x:hover {
        opacity: 1;
    }

    .btn-preview {
        background: #ffffff;
        border: 1px solid #cccccc;
    }

    .martop {
        margin-top: 18px;
    }

    img.programlist {
        padding-right: 8px;
        padding-left: 8px;
    }

    input[type=file] {
        line-height: unset;
    }
</style>

<script>
    $(document).ready(function() {

        $(".btn-preview").on("click", function() {
            var imgSrc = $(this).data("img");
            $("#previewImage").attr("src", imgSrc);
            $("#imgPreviewModal").fadeIn(200);
        });

        $(".close-preview-x").on("click", function() {
            $("#imgPreviewModal").fadeOut(200);
        });

        $(".preview-modal-bg").on("click", function() {
            $("#imgPreviewModal").fadeOut(200);
        });

    });
</script>