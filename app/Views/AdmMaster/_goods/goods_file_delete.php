<?php
include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";

$file = $_POST['file'];

$path = $_SERVER['DOCUMENT_ROOT'] . "/data/product/" . $file;

if ($file && file_exists($path)) {
    unlink($path);
    echo json_encode(["result" => "OK"]);
} else {
    echo json_encode(["result" => "NO_FILE"]);
}
exit;
?>
