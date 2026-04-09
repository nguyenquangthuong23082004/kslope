<?php
include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php";

$bbs_idx = $_POST['bbs_idx'];
$onum    = $_POST['onum'];

foreach ($onum as $bbs_idx => $value) {
    $sql = "
        UPDATE tbl_bbs_list
        SET onum = '".$value."'
        WHERE bbs_idx = '".$bbs_idx."'
    ";
    mysqli_query($connect, $sql);
}

echo "OK";
?>
