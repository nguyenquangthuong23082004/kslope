<?php
include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php";

if (!isset($_POST['product_idx']) || !is_numeric($_POST['product_idx'])) {
    echo json_encode(['success' => false, 'message' => '잘못된 접근입니다.']);
    exit;
}

$product_idx = intval($_POST['product_idx']);
$upload_path = $_SERVER['DOCUMENT_ROOT'] . "/data/product/";

function generate_numeric_filename($ext){
    return date('YmdHis') . rand(1000,9999) . '.' . $ext;
}

$sql = "SELECT * FROM tbl_goods WHERE g_idx = '$product_idx'";
$result = mysqli_query($connect, $sql);

if (!$row = mysqli_fetch_assoc($result)) {
    echo json_encode(['success' => false, 'message' => '상품을 찾을 수 없습니다.']);
    exit;
}

$new_files = [];
for ($i = 1; $i <= 6; $i++) {
    foreach (['ufile','rfile'] as $prefix) {
        $col = $prefix.$i;
        if ($row[$col] && file_exists($upload_path . $row[$col])) {
            $ext = pathinfo($row[$col], PATHINFO_EXTENSION);
            $new_name = generate_numeric_filename($ext);
            copy($upload_path . $row[$col], $upload_path . $new_name);
            $new_files[$col] = $new_name;
        } else {
            $new_files[$col] = '';
        }
    }
}

$cols = $vals = [];
foreach ($row as $key => $val) {
    if ($key == 'g_idx' || $key == 'reg_date' || $key == 'mod_date') continue;

    if (isset($new_files[$key])) {
        $cols[] = $key;
        $vals[] = "'" . mysqli_real_escape_string($connect, $new_files[$key]) . "'";
    } else if ($key == 'goods_code' || $key == 'goods_code_show') {
        $cols[] = $key;
        $vals[] = "'[복사]" . mysqli_real_escape_string($connect, $val) . "'";
    } else {
        $cols[] = $key;
        $vals[] = "'" . mysqli_real_escape_string($connect, $val) . "'";
    }
}

$cols = implode(',', $cols);
$vals = implode(',', $vals);

$sql_insert = "INSERT INTO tbl_goods ($cols, reg_date) VALUES ($vals, NOW())";
if (!mysqli_query($connect, $sql_insert)) {
    echo json_encode(['success' => false, 'message' => '상품 복사 중 오류 발생']);
    exit;
}

$new_product_idx = mysqli_insert_id($connect);

$sql_manage = "SELECT * FROM tbl_goods_manage WHERE g_code = '".mysqli_real_escape_string($connect,$row['goods_code'])."'";
$res_manage = mysqli_query($connect, $sql_manage);
while($m = mysqli_fetch_assoc($res_manage)) {
    $sql = "INSERT INTO tbl_goods_manage (g_code,type,gubun,useYN,period) VALUES (
        '[복사]".mysqli_real_escape_string($connect,$m['g_code'])."',
        '".mysqli_real_escape_string($connect,$m['type'])."',
        '".mysqli_real_escape_string($connect,$m['gubun'])."',
        '".mysqli_real_escape_string($connect,$m['useYN'])."',
        '".mysqli_real_escape_string($connect,$m['period'])."'
    )";
    mysqli_query($connect,$sql);

    $new_g_code = '[복사]' . $m['g_code'];
    $sql_detail = "SELECT * FROM tbl_goods_manage_detail WHERE g_code = '".mysqli_real_escape_string($connect,$m['g_code'])."' AND gubun='".mysqli_real_escape_string($connect,$m['gubun'])."' AND type='".mysqli_real_escape_string($connect,$m['type'])."'";
    $res_detail = mysqli_query($connect,$sql_detail);
    while($d = mysqli_fetch_assoc($res_detail)){
        $sql_d = "INSERT INTO tbl_goods_manage_detail (g_code,gubun,gubun2,type,subject,price,price_chk,cmbind_discnt) VALUES (
            '".mysqli_real_escape_string($connect,$new_g_code)."',
            '".mysqli_real_escape_string($connect,$d['gubun'])."',
            '".mysqli_real_escape_string($connect,$d['gubun2'])."',
            '".mysqli_real_escape_string($connect,$d['type'])."',
            '".mysqli_real_escape_string($connect,$d['subject'])."',
            '".mysqli_real_escape_string($connect,$d['price'])."',
            '".mysqli_real_escape_string($connect,$d['price_chk'])."',
            '".mysqli_real_escape_string($connect,$d['cmbind_discnt'])."'
        )";
        mysqli_query($connect,$sql_d);
    }
}

$sql_fb = "SELECT * FROM tbl_goods_fb WHERE g_idx = '$product_idx'";
$res_fb = mysqli_query($connect, $sql_fb);
while($fb = mysqli_fetch_assoc($res_fb)){
    $sql_f = "INSERT INTO tbl_goods_fb (g_idx, fb_idx, fb_use, fb_sel, fb_val) VALUES (
        '$new_product_idx',
        '".mysqli_real_escape_string($connect,$fb['fb_idx'])."',
        '".mysqli_real_escape_string($connect,$fb['fb_use'])."',
        '".mysqli_real_escape_string($connect,$fb['fb_sel'])."',
        '".mysqli_real_escape_string($connect,$fb['fb_val'])."'
    )";
    mysqli_query($connect,$sql_f);
}

echo json_encode(['success'=>true, 'message'=>'상품이 복사되었습니다.']);
mysqli_close($connect);
?>
