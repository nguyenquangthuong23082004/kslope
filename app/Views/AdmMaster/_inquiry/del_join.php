<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/lib.inc.php"; 

mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "START TRANSACTION");

if (!isset($_POST['idx'])) exit("NO");

$idx_list = $_POST['idx'];

if (!is_array($idx_list)) {
    $idx_list = array($idx_list);
}

$escaped = array_map(function($v) use ($connect) {
    return "'" . mysqli_real_escape_string($connect, $v) . "'";
}, $idx_list);

$in_query = implode(",", $escaped);

$sql = "DELETE FROM tbl_join WHERE idx IN ($in_query)";
$db = mysqli_query($connect, $sql);

if ($db) {
    mysqli_query($connect, "COMMIT");
    echo "OK";
} else {
    mysqli_query($connect, "ROLLBACK");
    echo "NO";
}

mysqli_close($connect);
?>
