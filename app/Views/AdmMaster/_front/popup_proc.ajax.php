<?
include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php";

/* ===== POST ===== */
$idx     = $_POST['idx'] ?? '';
$img_del = $_POST['img_del'] ?? '';

$P_SUBJECT   = $_POST['P_SUBJECT'] ?? '';
$P_STARTDAY  = $_POST['P_STARTDAY'] ?? '';
$P_START_HH  = str_pad(trim($_POST['P_START_HH'] ?? ''), 2, '0', STR_PAD_LEFT);
$P_START_MM  = str_pad(trim($_POST['P_START_MM'] ?? ''), 2, '0', STR_PAD_LEFT);
$P_ENDDAY    = $_POST['P_ENDDAY'] ?? '';
$P_END_HH    = str_pad(trim($_POST['P_END_HH'] ?? ''), 2, '0', STR_PAD_LEFT);
$P_END_MM    = str_pad(trim($_POST['P_END_MM'] ?? ''), 2, '0', STR_PAD_LEFT);

$status      = $_POST['status'] ?? '';
$is_mobile   = $_POST['is_mobile'] ?? '';
$P_MOVEURL   = $_POST['P_MOVEURL'] ?? '';
$P_WIN_WIDTH = $_POST['P_WIN_WIDTH'] ?? '';
$P_WIN_HEIGHT= $_POST['P_WIN_HEIGHT'] ?? '';
$P_WIN_TOP   = $_POST['P_WIN_TOP'] ?? '';
$P_WIN_LEFT  = $_POST['P_WIN_LEFT'] ?? '';
$P_CATE      = $_POST['P_CATE'] ?? '';
$P_STYLE     = $_POST['P_STYLE'] ?? '';
$P_CONTENT   = $_POST['P_CONTENT'] ?? '';

$week1 = isset($_POST['week1']) ? 'Y' : '';
$week2 = isset($_POST['week2']) ? 'Y' : '';
$week3 = isset($_POST['week3']) ? 'Y' : '';


/* ===== FILE ===== */
$upload  = "../../data/homepage/";
$rfile_1 = '';
$ufile_1 = '';

mysqli_query($connect, "START TRANSACTION");

/* ===== FILE DELETE ===== */
if ($img_del === "Y" && $idx) {
    mysqli_query($connect, "
        UPDATE tbl_popup 
        SET rfile='', ufile='' 
        WHERE idx='$idx'
    ");
}

/* ===== FILE UPLOAD ===== */
if (!empty($_FILES['ufile']['name'])) {

    if (no_file_ext($_FILES['ufile']['name']) != "Y") {
        echo "NF";
        exit;
    }

    $rfile_1 = $_FILES['ufile']['name'];
    $ufile_1 = file_check(
        $rfile_1,
        $_FILES['ufile']['tmp_name'],
        $upload,
        "N"
    );

    if ($idx) {
        mysqli_query($connect, "
            UPDATE tbl_popup 
            SET rfile='$rfile_1', ufile='$ufile_1'
            WHERE idx='$idx'
        ");
    }
}

/* ===== SAVE ===== */
if ($idx) {
    $sql = "
        UPDATE tbl_popup SET
            P_SUBJECT='$P_SUBJECT',
            P_STARTDAY='$P_STARTDAY',
            P_START_HH='$P_START_HH',
            P_START_MM='$P_START_MM',
            P_ENDDAY='$P_ENDDAY',
            P_END_HH='$P_END_HH',
            P_END_MM='$P_END_MM',
            week_1='$week1',
            week_2='$week2',
            week_3='$week3',
            status='$status',
            is_mobile='$is_mobile',
            P_MOVEURL='$P_MOVEURL',
            P_WIN_WIDTH='$P_WIN_WIDTH',
            P_WIN_HEIGHT='$P_WIN_HEIGHT',
            P_WIN_TOP='$P_WIN_TOP',
            P_WIN_LEFT='$P_WIN_LEFT',
            P_CATE='$P_CATE',
            P_STYLE='$P_STYLE',
            P_CONTENT='$P_CONTENT'
        WHERE idx='$idx'
    ";
} else {
    $sql = "
        INSERT INTO tbl_popup
        (P_SUBJECT,P_STARTDAY,P_START_HH,P_START_MM,P_ENDDAY,P_END_HH,P_END_MM,
         week_1,week_2,week_3,status,is_mobile,
         P_MOVEURL,P_WIN_WIDTH,P_WIN_HEIGHT,P_WIN_TOP,P_WIN_LEFT,
         P_CATE,P_STYLE,P_CONTENT,rfile,ufile,r_date)
        VALUES
        ('$P_SUBJECT','$P_STARTDAY','$P_START_HH','$P_START_MM','$P_ENDDAY',
         '$P_END_HH','$P_END_MM','$week1','$week2','$week3',
         '$status','$is_mobile','$P_MOVEURL','$P_WIN_WIDTH','$P_WIN_HEIGHT',
         '$P_WIN_TOP','$P_WIN_LEFT','$P_CATE','$P_STYLE','$P_CONTENT',
         '$rfile_1','$ufile_1',NOW())
    ";
}

if (mysqli_query($connect, $sql)) {
    mysqli_query($connect, "COMMIT");
    echo "OK";
} else {
    mysqli_query($connect, "ROLLBACK");
    echo "NO";
}

mysqli_close($connect);
?>
