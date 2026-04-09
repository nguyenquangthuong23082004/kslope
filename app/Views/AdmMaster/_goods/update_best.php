<?php
include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php";

$id = $_POST['id'];
$is_best = $_POST['is_best'];

$sql = "UPDATE tbl_freebies SET is_best = '$is_best' WHERE idx = '$id'";
mysqli_query($connect, $sql);

echo "OK";
?>
