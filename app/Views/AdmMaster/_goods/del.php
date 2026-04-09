<?php
// include $_SERVER['DOCUMENT_ROOT'] . "/include/lib.inc.php"; 

// mysqli_query($connect, "SET AUTOCOMMIT=0");
// mysqli_query($connect, "START TRANSACTION");

// if (!isset($_POST['idx'])) exit("NO");

// $idx = $_POST['idx'];

// $sql = "UPDATE tbl_goods SET item_state = 'dele' WHERE g_idx = '".$idx."'";
// $db = mysqli_query($connect, $sql);

// if ($db) {
//     mysqli_query($connect, "COMMIT");
//     echo "OK";
// } else {
//     mysqli_query($connect, "ROLLBACK");
//     echo "NO";
// }

// mysqli_close($connect);

include $_SERVER['DOCUMENT_ROOT'] . "/include/lib.inc.php";

if (!isset($_POST['idx'])) {
    exit("NO");
}

$idx = $_POST['idx'];

$ids = array();
if (is_array($idx)) {
    foreach ($idx as $i) {
        $i = intval($i);
        if ($i > 0) $ids[] = $i;
    }
} else {
    $i = intval($idx);
    if ($i > 0) $ids[] = $i;
}

if (count($ids) === 0) {
    exit("NO");
}

$inList = implode(',', $ids);

mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "START TRANSACTION");

$sql_files = "SELECT ufile1, ufile2, ufile3, ufile4, ufile5, ufile6 FROM tbl_goods WHERE g_idx IN ($inList)";
$result_files = mysqli_query($connect, $sql_files);
$upload_path = $_SERVER['DOCUMENT_ROOT'] . "/data/product/"; 

while ($row = mysqli_fetch_assoc($result_files)) {
    for ($i = 1; $i <= 6; $i++) {
        $file = $row['ufile'.$i];
        if ($file && file_exists($upload_path.$file)) {
            unlink($upload_path.$file);
        }
    }
}

$sql = "UPDATE tbl_goods SET item_state = 'dele' WHERE g_idx IN ($inList)";
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
