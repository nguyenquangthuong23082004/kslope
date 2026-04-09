<style>
/******************* 메인팝업 *************************/
.layer_popup {
    visibility: hidden;
    position: absolute;
    /* top: 100px;
    left: 150px;
    z-index: 9999;
    background: #000; */
    top: 100px;
    left: 10px;
    z-index: 9999;
    width: 800px;
    height: 600px;
    background: url(assets/img/main/pop_bg.jpg) top center;
    background-size: contain !important;
    padding-top: 105px;
    text-align: center;
    box-sizing: border-box;
}

.layer_popup iframe {
    display: block;
    width: 745px;
    height: 420px;
    margin: 0 auto;
}

.layer_popup .close {
    height: 40px;
    line-height: 40px;
    background: #000;
    color: #fff;
    padding: 0 10px;
    font-size: 14px;
    width: 100%;
    box-sizing: border-box;
    opacity: 1;
    position: absolute;
    bottom: -40px;
}

.layer_popup .close form {
    margin: 0 !important;
    display: flex;
    align-items: center;
    justify-content: center;
}

.layer_popup .close input[type="checkbox"] {
    vertical-align: middle;
    margin-right: 5px;
}

.layer_popup .close a {
    color: #ccc;
    text-decoration: none;
    margin-left: 10px;
}

@media screen and (max-width: 850px) {
    .layer_popup {
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%);
        width: 90vw;
    }
    .layer_popup iframe {
        width: 100%;
        height: calc(90vw * 9 / 16);
    }
    .popup_pc { display: none !important; }
}
</style>

<script>
    function setCookie(cookieName, value, exdays) {
        var exdate = new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var cookieValue = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toGMTString());
        document.cookie = cookieName + "=" + cookieValue;
    }
    function getCookie(cookieName) {
        cookieName = cookieName + '=';
        var cookieData = document.cookie;
        var start = cookieData.indexOf(cookieName);
        var cookieValue = '';
        if (start != -1) {
            start += cookieName.length;
            var end = cookieData.indexOf(';', start);
            if (end == -1) end = cookieData.length;
            cookieValue = cookieData.substring(start, end);
        }
        return unescape(cookieValue);
    }

    function getYoutubeEmbedUrl(url) {
        if (!url) return '';
        var match = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\?\/]+)/);
        if (!match || !match[1]) return '';
        var videoId = match[1];
        return 'https://www.youtube.com/embed/' + videoId + '?autoplay=1&mute=1&controls=0&loop=1&playlist=' + videoId + '&rel=0';
    }

    function closeWin(saveToday, popId) {
        var iframe = document.querySelector('#' + popId + ' iframe');
        if (iframe) iframe.src = '';
        document.getElementById(popId).style.visibility = 'hidden';
        if (saveToday) {
            setCookie('todayClose_' + popId, 'Y', 1);
        }
    }

    function loadPopup(popId) {
        var popup = document.getElementById(popId);
        if (!popup) return;
        if (getCookie('todayClose_' + popId) == 'Y') return;

        var iframe = popup.querySelector('iframe');
        if (iframe) {
            var rawUrl = iframe.getAttribute('data-src');
            iframe.src = getYoutubeEmbedUrl(rawUrl);
        }
        popup.style.visibility = 'visible';
    }
</script>

<?
    $db = \Config\Database::connect();
    $now = date("Y-m-d H:i");

    $sql_pc = "
        SELECT * FROM tbl_popup
        WHERE status = 'B'
        AND CONCAT(P_STARTDAY, ' ', P_START_HH, ':', P_START_MM) <= '".$now."'
        AND CONCAT(P_ENDDAY,   ' ', P_END_HH,   ':', P_END_MM)   >= '".$now."'
        AND is_mobile = 'P'
    ";

    $sql_mo = "
        SELECT * FROM tbl_popup
        WHERE status = 'B'
        AND CONCAT(P_STARTDAY, ' ', P_START_HH, ':', P_START_MM) <= '".$now."'
        AND CONCAT(P_ENDDAY,   ' ', P_END_HH,   ':', P_END_MM)   >= '".$now."'
        AND is_mobile = 'M'
    ";

    $result    = $db->query($sql_pc)->getResultArray();
    $result_mo = $db->query($sql_mo)->getResultArray();
?>

<? foreach($result as $row) { 
    $popId = 'popup_' . $row['idx'];
?>
<div id="<?=$popId?>" class="layer_popup popup_pc"
     style="visibility:hidden; left:<?=$row['P_WIN_LEFT']?>px; top:<?=$row['P_WIN_TOP']?>px;">

    <iframe
        data-src="<?=htmlspecialchars($row['P_MOVEURL'])?>"
        src=""
        width="745" height="420"
        title="YouTube video player"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        referrerpolicy="strict-origin-when-cross-origin"
        allowfullscreen>
    </iframe>

    <div class="close">
        <form name="pop_form_<?=$row['idx']?>" style="margin-top:2px;">
            <span>
                <input type="checkbox" name="chkbox" value="<?=$popId?>"
                    onclick="closeWin(true, '<?=$popId?>');"
                    style="vertical-align:middle;">
                오늘 하루 이 창을 열지 않음
            </span>
            <a href="#" onclick="closeWin(false, '<?=$popId?>'); return false;">[닫기]</a>
        </form>
    </div>
</div>
<script>
    if ($(window).width() > 850) {
        loadPopup('<?=$popId?>');
    }
</script>
<? } ?>

<? foreach($result_mo as $row_mo) {
    $popId_mo = 'popup_' . $row_mo['idx'];
?>
<div id="<?=$popId_mo?>" class="layer_popup popup_mo"
     style="visibility:hidden;">

    <iframe
        data-src="<?=htmlspecialchars($row_mo['P_MOVEURL'])?>"
        src=""
        width="500" height="281"
        title="YouTube video player"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        referrerpolicy="strict-origin-when-cross-origin"
        allowfullscreen>
    </iframe>

    <div class="close">
        <form name="pop_form_mo_<?=$row_mo['idx']?>" style="margin-top:2px;">
            <span>
                <input type="checkbox" name="chkbox" value="<?=$popId_mo?>"
                    onclick="closeWin(true, '<?=$popId_mo?>');"
                    style="vertical-align:middle;">
                오늘 하루 이 창을 열지 않음
            </span>
            <a href="#" onclick="closeWin(false, '<?=$popId_mo?>'); return false;">[닫기]</a>
        </form>
    </div>
</div>
<script>
    if ($(window).width() <= 850) {
        loadPopup('<?=$popId_mo?>');
    }
</script>
<? } ?>

<script>
    $(window).resize(function () {
        if ($(window).width() <= 850) {
            $('.popup_pc').each(function () {
                var iframe = $(this).find('iframe')[0];
                if (iframe) iframe.src = '';
                $(this).css('visibility', 'hidden');
            });
            $('.popup_mo').each(function () {
                loadPopup($(this).attr('id'));
            });
        } else {
            $('.popup_mo').each(function () {
                var iframe = $(this).find('iframe')[0];
                if (iframe) iframe.src = '';
                $(this).css('visibility', 'hidden');
            });
            $('.popup_pc').each(function () {
                loadPopup($(this).attr('id'));
            });
        }
    });
</script>