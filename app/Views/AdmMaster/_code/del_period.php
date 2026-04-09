<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/lib.inc.php"; 

mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "START TRANSACTION");

if (!isset($_POST['code_idx'])) exit("NO");

$code_idx = $_POST['code_idx'];

$sql = "DELETE FROM tbl_period WHERE code_idx = '".$code_idx."'";
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
