<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/lib.inc.php";

$userid = $_GET['userid'];

$userid = mysqli_real_escape_string($connect, $userid);

$sql = "SELECT COUNT(*) AS cnt FROM tbl_member WHERE user_id = '{$userid}'";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

echo $row['cnt'];
?>
