<?php
include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php";

if (!isset($_POST['bbs_idx']) || !is_array($_POST['bbs_idx'])) {
    echo "NO_BBS_IDX";
    exit;
}

$bbs_idx = $_POST['bbs_idx'];
$upload = $_SERVER['DOCUMENT_ROOT']."/data/bbs/";

mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "START TRANSACTION");

foreach ($bbs_idx as $idx) {
    $idx = intval($idx);
    $row = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM tbl_bbs_list WHERE bbs_idx = {$idx}"));
    if (!$row) continue;

    for ($a = 1; $a <= 6; $a++) {
        $file = $row['ufile'.$a];
        if ($file && file_exists($upload.$file)) {
            @unlink($upload.$file);
        }
    }

    $del = mysqli_query($connect, "DELETE FROM tbl_bbs_list WHERE bbs_idx = {$idx}");
    if (!$del) {
        mysqli_query($connect, "ROLLBACK");
        echo "NO1";
        exit;
    }
}

mysqli_query($connect, "COMMIT");
mysqli_close($connect);

echo "OK";
?>
