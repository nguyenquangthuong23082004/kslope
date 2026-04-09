<?php
include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php";

$upload="../../data/product/";

$g_idx                  = updateSQ($_POST["g_idx"]);
$product_code           = updateSQ($_POST["product_code"]);
$product_dbcolor        = updateSQ($_POST["product_dbcolor"]);
$product_color          = updateSQ($_POST["product_color"]);
$product_size           = updateSQ($_POST["product_size"]);
$product_option         = updateSQ($_POST["product_option"]);
$realsize_dif           = updateSQ($_POST["realsize_dif"]);
$use_month              = updateSQ($_POST["use_month"]);

$goods_code             = updateSQ($_POST["goods_code"]);
$goods_code_show        = updateSQ($_POST["goods_code_show"]);
$goods_erp              = updateSQ($_POST["goods_erp"]);
$goods_seoson           = updateSQ($_POST["goods_seoson"]);
$goods_name_front       = updateSQ($_POST["goods_name_front"]);
$goods_name_back        = updateSQ($_POST["goods_name_back"]);
$promotion_txt1         = updateSQ($_POST["promotion_txt1"]);
$promotion_txt2         = updateSQ($_POST["promotion_txt2"]);
$goods_name_en          = updateSQ($_POST["goods_name_en"]);
$goods_erp_name         = updateSQ($_POST["goods_erp_name"]);
$goods_keyword          = updateSQ($_POST["goods_keyword"]);
$goods_brand            = updateSQ($_POST["goods_brand"]);
$goods_make_date        = updateSQ($_POST["goods_make_date"]);
$goods_country          = updateSQ($_POST["goods_country"]);
$make_co                = updateSQ($_POST["make_co"]);
$gender                 = updateSQ($_POST["gender"]);
$reg_type               = updateSQ($_POST["reg_type"]);
$nocoupon               = updateSQ($_POST["nocoupon"]);
$parallel               = updateSQ($_POST["parallel"]);
$md_comment             = updateSQ($_POST["md_comment"]);
$item_state             = updateSQ($_POST["item_state"]);
$admin_memo             = updateSQ($_POST["admin_memo"]);
$price_mk               = updateSQ($_POST["price_mk"]);
$price_dc               = updateSQ($_POST["price_dc"]);
$price_se               = updateSQ($_POST["price_se"]);
$price_mk_buy           = updateSQ($_POST["price_mk_buy"]);
$price_dc_buy           = updateSQ($_POST["price_dc_buy"]);
$price_se_buy           = updateSQ($_POST["price_se_buy"]);
$item_tax               = updateSQ($_POST["item_tax"]);
$price_fs               = updateSQ($_POST["price_fs"]);
$point_more             = updateSQ($_POST["point_more"]);
$item_min_order         = updateSQ($_POST["item_min_order"]);
$item_max_order         = updateSQ($_POST["item_max_order"]);
$unit_uid               = updateSQ($_POST["unit_uid"]);
$dis_date_use           = updateSQ($_POST["dis_date_use"]);
$dis_date_s             = updateSQ($_POST["dis_date_s"]);
$dis_date_e             = updateSQ($_POST["dis_date_e"]);
$price_ds               = updateSQ($_POST["price_ds"]);
$real_size_code         = updateSQ($_POST["real_size_code"]);
$item_weight            = updateSQ($_POST["item_weight"]);
$content                = updateSQ($_POST["content"]);
$caution                = updateSQ($_POST["caution"]);
$good_cnt               = updateSQ($_POST["good_cnt"]);

$product_group_1        = updateSQ($_POST["product_group_1"]);
$product_group_2        = updateSQ($_POST["product_group_2"]);
$product_group_3        = updateSQ($_POST["product_group_3"]);
$product_group_4        = updateSQ($_POST["product_group_4"]);

$goods_dis1             = updateSQ($_POST["goods_dis1"]);
$goods_dis2             = updateSQ($_POST["goods_dis2"]);
$goods_dis3             = updateSQ($_POST["goods_dis3"]);
$goods_dis4             = updateSQ($_POST["goods_dis4"]);
$goods_dis5             = updateSQ($_POST["goods_dis5"]);

$freeb                  = updateSQ($_POST["freeb"]);
$product_type           = updateSQ($_POST["product_type"]);

$goods_icon             = isset($_POST['goods_icon']) ? $_POST['goods_icon'] : array();
$item_logo              = isset($_POST['item_logo']) ? $_POST['item_logo'] : "";

$badge1                 = updateSQ($_POST['badge1']);
$badge2                 = updateSQ($_POST['badge2']);

$goods_size             = updateSQ($_POST['goods_size']);
$goods_hardness         = updateSQ($_POST['goods_hardness']);
$goods_topper           = updateSQ($_POST['goods_topper']);
$goods_additional_arr = $_POST['goods_additional'] ?? [];
$moption_type_arr = $_POST['moption_type'] ?? [];
$option_type_arr = $_POST['option_type'] ?? [];
$o_name_arr = $_POST['o_name'] ?? [];
$use_yn_arr = $_POST['use_yn'] ?? [];
$o_num_arr  = $_POST['o_num'] ?? [];

$goods_additional = "";
if (!empty($goods_additional_arr)) {
    $goods_additional = implode(",", $goods_additional_arr);
}

$goods_additional = updateSQ($goods_additional);

$total_p_txt            = updateSQ($_POST['total_p_txt']);

$type_chk_arr = isset($_POST['type_chk']) ? $_POST['type_chk'] : array();
$type_chk = '';
for ($i = 0; $i < count($type_chk_arr); $i++){
    $type_chk = $type_chk . "|" . $type_chk_arr[$i] . "|";
}

$period_cnt             = updateSQ($_POST['period_cnt']);

$default_period         = updateSQ($_POST['default_period']);
$default_type           = updateSQ($_POST['default_type']);

for ($i = 1; $i <= 6; $i++){
    ${'ufile'.$i} = updateSQ($_POST['ufile'.$i]);
    ${'rfile'.$i} = updateSQ($_POST['rfile'.$i]);
}

for ($i = 1; $i <= 4; $i++){
    ${"freebies".$i} = '';
    ${"freebies_arr".$i} = isset($_POST["freebies".$i]) ? $_POST["freebies".$i] : array();
    for ($j = 0; $j < count(${"freebies_arr".$i}); $j++){
        ${"freebies".$i} = ${"freebies".$i} . "|" . ${"freebies_arr".$i}[$j] . "|";
    }
}

$product_group = "";
if ($product_group_4 != "" ){
    $product_group = $product_group_4;
}else if ($product_group_3 != ""){
    $product_group = $product_group_3;
}else if ($product_group_2 != ""){
    $product_group = $product_group_2;
}else if ($product_group_1 != ""){
    $product_group = $product_group_1;
}

$goods_icon_txt = "";
if (is_array($goods_icon)){
    foreach ($goods_icon as $value){
        $goods_icon_txt .= "|" . $value . "|";
    }
}

$product_option_re = substr($product_option,1,strlen($product_option)-2);
$product_option_ar = explode("||",$product_option_re);


// if (!is_array($type_chk_arr)) $type_chk_arr = array();

// foreach ($type_chk_arr as $vals) {
//     for ($i = 1; $i <= 4; $i++) {
//         ${$vals . "_gubun" . $i}   = isset($_POST[$vals . "_gubun" . $i]) ? updateSQ($_POST[$vals . "_gubun" . $i]) : $i;
//         ${$vals . "_use" . $i}     = isset($_POST[$vals . "_use" . $i]) ? updateSQ($_POST[$vals . "_use" . $i]) : "";
//         ${$vals . "_period" . $i}  = isset($_POST[$vals . "_period" . $i]) ? updateSQ($_POST[$vals . "_period" . $i]) : "";

//         for ($j = 1; $j <= 4; $j++) {
//             ${$vals . "_gubun" . $i . "_" . $j}         = isset($_POST[$vals . "_gubun" . $i . "_" . $j]) ? updateSQ($_POST[$vals . "_gubun" . $i . "_" . $j]) : $j;
//             ${$vals . "_subject" . $i . "_" . $j}       = isset($_POST[$vals . "_subject" . $i . "_" . $j]) ? updateSQ($_POST[$vals . "_subject" . $i . "_" . $j]) : "";
//             ${$vals . "_price" . $i . "_" . $j}         = isset($_POST[$vals . "_price" . $i . "_" . $j]) ? updateSQ($_POST[$vals . "_price" . $i . "_" . $j]) : "";
//             ${$vals . "_price_chk" . $i . "_" . $j}     = isset($_POST[$vals . "_price_chk" . $i . "_" . $j]) ? updateSQ($_POST[$vals . "_price_chk" . $i . "_" . $j]) : "";
//             ${$vals . "_cmbind_discnt" . $i . "_" . $j} = isset($_POST[$vals . "_cmbind_discnt" . $i . "_" . $j]) ? updateSQ($_POST[$vals . "_cmbind_discnt" . $i . "_" . $j]) : "";
//         }
//     }
// }

$detail_cate			 = updateSQ($_POST['detail_cate']);

$detail_chk_arr			 = $_POST['detail_chk'];

$detail_chk = '';
for($i=0; $i <count($detail_chk_arr); $i++){
    $detail_chk = $detail_chk."|".$detail_chk_arr[$i]."|";
}

if ($g_idx) {
    foreach ($type_chk_arr as $vals) {
        mysqli_query($connect, "
            DELETE FROM tbl_goods_manage 
            WHERE g_code='".mysqli_real_escape_string($connect,$goods_code)."' 
            AND type='".mysqli_real_escape_string($connect,$vals)."'
        ");
        
        mysqli_query($connect, "
            DELETE FROM tbl_goods_manage_detail 
            WHERE g_code='".mysqli_real_escape_string($connect,$goods_code)."' 
            AND type='".mysqli_real_escape_string($connect,$vals)."'
        ");
    }
    
    foreach ($type_chk_arr as $vals) {
        
        $gubun_arr = isset($_POST[$vals . "_gubun"]) ? $_POST[$vals . "_gubun"] : [];
        $visit_type_arr = isset($_POST[$vals . "_visit_type"]) ? $_POST[$vals . "_visit_type"] : [];
        $use_hidden_arr = isset($_POST[$vals . "_use_hidden"]) ? $_POST[$vals . "_use_hidden"] : [];
        $period_arr = isset($_POST[$vals . "_period"]) ? $_POST[$vals . "_period"] : [];
        
        for ($i = 0; $i < count($gubun_arr); $i++) {
            
            $gubun = updateSQ($gubun_arr[$i]);
            $visit_type = updateSQ($visit_type_arr[$i]);
            $useYN = updateSQ($use_hidden_arr[$i]); // Lấy từ hidden input
            $period = updateSQ($period_arr[$i]);

            $ins_sql = "
                INSERT INTO tbl_goods_manage SET
                    g_code='".mysqli_real_escape_string($connect,$goods_code)."',
                    type='".mysqli_real_escape_string($connect,$vals)."',
                    gubun='".mysqli_real_escape_string($connect,$gubun)."',
                    visit_type='".mysqli_real_escape_string($connect,$visit_type)."',
                    useYN='".mysqli_real_escape_string($connect,$useYN)."',
                    period='".mysqli_real_escape_string($connect,$period)."'
            ";
            mysqli_query($connect, $ins_sql);
        }

        $detail_visit_type_arr = isset($_POST[$vals . "_detail_visit_type"]) ? $_POST[$vals . "_detail_visit_type"] : [];
        $price_chk_hidden_arr = isset($_POST[$vals . "_price_chk_hidden"]) ? $_POST[$vals . "_price_chk_hidden"] : [];
        $subject_arr = isset($_POST[$vals . "_subject"]) ? $_POST[$vals . "_subject"] : [];
        $price_arr = isset($_POST[$vals . "_price"]) ? $_POST[$vals . "_price"] : [];
        $cmbind_discnt_hidden_arr = isset($_POST[$vals . "_cmbind_discnt_hidden"]) ? $_POST[$vals . "_cmbind_discnt_hidden"] : [];
        
        for ($i = 0; $i < count($detail_visit_type_arr); $i++) {
            
            $detail_visit_type = updateSQ($detail_visit_type_arr[$i]);
            $detail_gubun = updateSQ($gubun_arr[$i]); 
            $gubun2 = 1; 
            
            $price_chk = updateSQ($price_chk_hidden_arr[$i]); // Lấy từ hidden input
            $subject = updateSQ($subject_arr[$i]);
            $price = updateSQ($price_arr[$i]);
            $cmbind = updateSQ($cmbind_discnt_hidden_arr[$i]); // Lấy từ hidden input

            $ins_d_sql = "
                INSERT INTO tbl_goods_manage_detail SET
                    g_code='".mysqli_real_escape_string($connect,$goods_code)."',
                    type='".mysqli_real_escape_string($connect,$vals)."',
                    gubun='".mysqli_real_escape_string($connect,$detail_gubun)."',
                    gubun2='".mysqli_real_escape_string($connect,$gubun2)."',
                    visit_type='".mysqli_real_escape_string($connect,$detail_visit_type)."',
                    subject='".mysqli_real_escape_string($connect,$subject)."',
                    price='".mysqli_real_escape_string($connect,$price)."',
                    price_chk='".mysqli_real_escape_string($connect,$price_chk)."',
                    cmbind_discnt='".mysqli_real_escape_string($connect,$cmbind)."'
            ";
            mysqli_query($connect, $ins_d_sql);
        }
    }

    foreach ($type_chk_arr as $vals) {
        $txt1 = isset($_POST[$vals . "_txt1"]) ? updateSQ($_POST[$vals . "_txt1"]) : "";
        $txt2 = isset($_POST[$vals . "_txt2"]) ? updateSQ($_POST[$vals . "_txt2"]) : "";

        $chk = mysqli_query($connect, "
            SELECT * FROM tbl_goods_type_text
            WHERE g_code='".mysqli_real_escape_string($connect,$goods_code)."' 
              AND type='".mysqli_real_escape_string($connect,$vals)."'
        ");

        if (mysqli_num_rows($chk) > 0) {
            mysqli_query($connect, "
                UPDATE tbl_goods_type_text SET
                    txt1='".mysqli_real_escape_string($connect,$txt1)."',
                    txt2='".mysqli_real_escape_string($connect,$txt2)."'
                WHERE g_code='".mysqli_real_escape_string($connect,$goods_code)."' 
                  AND type='".mysqli_real_escape_string($connect,$vals)."'
            ");
        } else {
            mysqli_query($connect, "
                INSERT INTO tbl_goods_type_text SET
                    g_code='".mysqli_real_escape_string($connect,$goods_code)."',
                    type='".mysqli_real_escape_string($connect,$vals)."',
                    txt1='".mysqli_real_escape_string($connect,$txt1)."',
                    txt2='".mysqli_real_escape_string($connect,$txt2)."'
            ");
        }
    }

    for ($i = 1; $i <= 4; $i++){
        $fb_cnt_sql = "SELECT * FROM tbl_goods_fb WHERE g_idx = '".mysqli_real_escape_string($connect,$g_idx)."' AND fb_idx = '".${"fb_idx".$i}."'";
        $fb_cnt_result = mysqli_query($connect, $fb_cnt_sql);
        $fb_cnt = mysqli_num_rows($fb_cnt_result);

        if ($fb_cnt > 0){
            $fb_sql = "
                UPDATE tbl_goods_fb SET
                    fb_use = '".${"f_p_use".$i}."',
                    fb_sel = '".${"f_p_sel".$i}."',
                    fb_val = '".${"freebies".$i}."'
                WHERE g_idx = '".mysqli_real_escape_string($connect,$g_idx)."' 
                  AND fb_idx = '".${"fb_idx".$i}."'
            ";
            mysqli_query($connect, $fb_sql);
        } else {
            $fb_sql = "
                INSERT INTO tbl_goods_fb SET
                    g_idx = '".mysqli_real_escape_string($connect,$g_idx)."',
                    fb_idx = '".${"fb_idx".$i}."',
                    fb_use = '".${"f_p_use".$i}."',
                    fb_sel = '".${"f_p_sel".$i}."',
                    fb_val = '".${"freebies".$i}."'
            ";
            mysqli_query($connect, $fb_sql);
        }
    }

    $sql = "
        UPDATE tbl_goods SET
             product_code            = '".mysqli_real_escape_string($connect,$product_code)."'
            ,product_group           = '".mysqli_real_escape_string($connect,$product_group)."'
            ,goods_seoson            = '".mysqli_real_escape_string($connect,$goods_seoson)."'
            ,goods_name_front        = '".mysqli_real_escape_string($connect,$goods_name_front)."'
            ,goods_name_back         = '".mysqli_real_escape_string($connect,$goods_name_back)."'
            ,promotion_txt1          = '".mysqli_real_escape_string($connect,$promotion_txt1)."'
            ,promotion_txt2          = '".mysqli_real_escape_string($connect,$promotion_txt2)."'
            ,goods_name_en           = '".mysqli_real_escape_string($connect,$goods_name_en)."'
            ,goods_code_show         = '".mysqli_real_escape_string($connect,$goods_code_show)."'
            ,goods_code              = '".mysqli_real_escape_string($connect,$goods_code)."'
            ,goods_color             = '".mysqli_real_escape_string($connect,$goods_color)."'
            ,goods_erp_name          = '".mysqli_real_escape_string($connect,$goods_erp_name)."'
            ,goods_keyword           = '".mysqli_real_escape_string($connect,$goods_keyword)."'
            ,goods_brand             = '".mysqli_real_escape_string($connect,$goods_brand)."'
            ,goods_make_date         = '".mysqli_real_escape_string($connect,$goods_make_date)."'
            ,goods_country           = '".mysqli_real_escape_string($connect,$goods_country)."'
            ,make_co                 = '".mysqli_real_escape_string($connect,$make_co)."'
            ,gender                  = '".mysqli_real_escape_string($connect,$gender)."'
            ,reg_type                = '".mysqli_real_escape_string($connect,$reg_type)."'
            ,parallel                = '".mysqli_real_escape_string($connect,$parallel)."'
            ,nocoupon                = '".mysqli_real_escape_string($connect,$nocoupon)."'
            ,goods_icon              = '".mysqli_real_escape_string($connect,$goods_icon_txt)."'
            ,product_dbcolor         = '".mysqli_real_escape_string($connect,$product_dbcolor)."'
            ,md_comment              = '".mysqli_real_escape_string($connect,$md_comment)."'
            ,item_state              = '".mysqli_real_escape_string($connect,$item_state)."'
            ,admin_memo              = '".mysqli_real_escape_string($connect,$admin_memo)."'
            ,price_mk                = '".mysqli_real_escape_string($connect,$price_mk)."'
            ,price_dc                = '".mysqli_real_escape_string($connect,$price_dc)."'
            ,price_se                = '".mysqli_real_escape_string($connect,$price_se)."'
            ,price_mk_buy            = '".mysqli_real_escape_string($connect,$price_mk_buy)."'
            ,price_dc_buy            = '".mysqli_real_escape_string($connect,$price_dc_buy)."'
            ,price_se_buy            = '".mysqli_real_escape_string($connect,$price_se_buy)."'
            ,item_tax                = '".mysqli_real_escape_string($connect,$item_tax)."'
            ,price_fs                = '".mysqli_real_escape_string($connect,$price_fs)."'
            ,point_more              = '".mysqli_real_escape_string($connect,$point_more)."'
            ,item_min_order          = '".mysqli_real_escape_string($connect,$item_min_order)."'
            ,item_max_order          = '".mysqli_real_escape_string($connect,$item_max_order)."'
            ,unit_uid                = '".mysqli_real_escape_string($connect,$unit_uid)."'
            ,dis_date_use            = '".mysqli_real_escape_string($connect,$dis_date_use)."'
            ,dis_date_s              = '".mysqli_real_escape_string($connect,$dis_date_s)."'
            ,dis_date_e              = '".mysqli_real_escape_string($connect,$dis_date_e)."'
            ,price_ds                = '".mysqli_real_escape_string($connect,$price_ds)."'
            ,product_color           = '".mysqli_real_escape_string($connect,$product_color)."'
            ,product_size            = '".mysqli_real_escape_string($connect,$product_size)."'
            ,product_option          = '".mysqli_real_escape_string($connect,$product_option)."'
            ,realsize_dif            = '".mysqli_real_escape_string($connect,$realsize_dif)."'
            ,real_size_code          = '".mysqli_real_escape_string($connect,$real_size_code)."'
            ,item_weight             = '".mysqli_real_escape_string($connect,$item_weight)."'
            ,use_month               = '".mysqli_real_escape_string($connect,$use_month)."'
            ,content                 = '".mysqli_real_escape_string($connect,$content)."'
            ,caution                 = '".mysqli_real_escape_string($connect,$caution)."'
            ,good_cnt                = '".mysqli_real_escape_string($connect,$good_cnt)."'
            ,goods_dis1              = '".mysqli_real_escape_string($connect,$goods_dis1)."'
            ,goods_dis2              = '".mysqli_real_escape_string($connect,$goods_dis2)."'
            ,goods_dis3              = '".mysqli_real_escape_string($connect,$goods_dis3)."'
            ,goods_dis4              = '".mysqli_real_escape_string($connect,$goods_dis4)."'
            ,goods_dis5              = '".mysqli_real_escape_string($connect,$goods_dis5)."'
            ,ufile1                  = '".mysqli_real_escape_string($connect,$ufile1)."'
            ,ufile2                  = '".mysqli_real_escape_string($connect,$ufile2)."'
            ,ufile3                  = '".mysqli_real_escape_string($connect,$ufile3)."'
            ,ufile4                  = '".mysqli_real_escape_string($connect,$ufile4)."'
            ,ufile5                  = '".mysqli_real_escape_string($connect,$ufile5)."'
            ,ufile6                  = '".mysqli_real_escape_string($connect,$ufile6)."'
            ,rfile1                  = '".mysqli_real_escape_string($connect,$rfile1)."'
            ,rfile2                  = '".mysqli_real_escape_string($connect,$rfile2)."'
            ,rfile3                  = '".mysqli_real_escape_string($connect,$rfile3)."'
            ,rfile4                  = '".mysqli_real_escape_string($connect,$rfile4)."'
            ,rfile5                  = '".mysqli_real_escape_string($connect,$rfile5)."'
            ,rfile6                  = '".mysqli_real_escape_string($connect,$rfile6)."'
            ,freeb                   = '".mysqli_real_escape_string($connect,$freeb)."'
            ,type                    = '".mysqli_real_escape_string($connect,$type_chk)."'
            ,default_type            = '".mysqli_real_escape_string($connect,$default_type)."'
            ,default_period          = '".mysqli_real_escape_string($connect,$default_period)."'
            ,period_cnt              = '".mysqli_real_escape_string($connect,$period_cnt)."'
            ,detail_cate             = '".mysqli_real_escape_string($connect,$detail_cate)."'
            ,detail_srch             = '".mysqli_real_escape_string($connect,$detail_chk)."'
            ,badge1                  = '".mysqli_real_escape_string($connect,$badge1)."'
            ,badge2                  = '".mysqli_real_escape_string($connect,$badge2)."'
			,goods_size              = '".mysqli_real_escape_string($connect,$goods_size)."'
            ,goods_hardness          = '".mysqli_real_escape_string($connect,$goods_hardness)."'
            ,goods_topper            = '".mysqli_real_escape_string($connect,$goods_topper)."'
            ,goods_additional        = '".mysqli_real_escape_string($connect,$goods_additional)."'
            ,total_p_txt             = '".mysqli_real_escape_string($connect,$total_p_txt)."'
            ,item_logo               = '".mysqli_real_escape_string($connect,$item_logo)."'
            ,product_type            = '".mysqli_real_escape_string($connect,$product_type)."'
            ,mod_date                = now()
        WHERE g_idx = '".mysqli_real_escape_string($connect,$g_idx)."'
    ";
    write_log("상품수정 : ".$sql);
    mysqli_query($connect, $sql) or die(mysqli_error($connect));

    $goods_color_list = [];
    if (isset($_POST['goods_color']) && trim($_POST['goods_color']) != "") {
        $goods_color_list = explode(",", $_POST['goods_color']);
    }

    $color_notes = [];
    foreach ($_POST as $key => $val) {
        if (strpos($key, "color_note_") === 0) {
            $hex = substr($key, 11);
            $color_code = "#" . $hex;
            $color_notes[$color_code] = updateSQ($val);
        }
    }

    if ($g_idx) {

        if (empty($goods_color_list)) {
            mysqli_query($connect, "DELETE FROM tbl_goods_color WHERE g_idx = '".mysqli_real_escape_string($connect,$g_idx)."'");
        } else {

            $existing_colors = [];
            $res = mysqli_query($connect, "SELECT color FROM tbl_goods_color WHERE g_idx='".mysqli_real_escape_string($connect,$g_idx)."'");
            while ($row = mysqli_fetch_assoc($res)) {
                $existing_colors[] = $row['color'];
            }

            foreach ($existing_colors as $old_color) {
                if (!in_array($old_color, $goods_color_list)) {
                    mysqli_query($connect, "
                        DELETE FROM tbl_goods_color
                        WHERE g_idx='".mysqli_real_escape_string($connect,$g_idx)."' 
                          AND color='".mysqli_real_escape_string($connect,$old_color)."'
                    ");
                }
            }

            foreach ($goods_color_list as $color) {

                $color_safe = updateSQ($color);
                $note_safe = isset($color_notes[$color]) ? $color_notes[$color] : "";

                $q = "
                    SELECT color FROM tbl_goods_color
                    WHERE g_idx='".mysqli_real_escape_string($connect,$g_idx)."' 
                      AND color='".mysqli_real_escape_string($connect,$color_safe)."'
                ";
                $chk = mysqli_query($connect, $q);

                if (mysqli_num_rows($chk) > 0) {
                    mysqli_query($connect, "
                        UPDATE tbl_goods_color
                        SET name_color='".mysqli_real_escape_string($connect,$note_safe)."'
                        WHERE g_idx='".mysqli_real_escape_string($connect,$g_idx)."' 
                          AND color='".mysqli_real_escape_string($connect,$color_safe)."'
                    ");
                } else {
                    mysqli_query($connect, "
                        INSERT INTO tbl_goods_color SET
                            g_idx='".mysqli_real_escape_string($connect,$g_idx)."',
                            color='".mysqli_real_escape_string($connect,$color_safe)."',
                            name_color='".mysqli_real_escape_string($connect,$note_safe)."'
                    ");
                }
            }
        }
    }

} else {
    foreach ($type_chk_arr as $vals) {
        
        $gubun_arr = isset($_POST[$vals . "_gubun"]) ? $_POST[$vals . "_gubun"] : [];
        $visit_type_arr = isset($_POST[$vals . "_visit_type"]) ? $_POST[$vals . "_visit_type"] : [];
        $use_hidden_arr = isset($_POST[$vals . "_use_hidden"]) ? $_POST[$vals . "_use_hidden"] : [];
        $period_arr = isset($_POST[$vals . "_period"]) ? $_POST[$vals . "_period"] : [];
        
        for ($i = 0; $i < count($gubun_arr); $i++) {
            
            $gubun = updateSQ($gubun_arr[$i]);
            $visit_type = updateSQ($visit_type_arr[$i]);
            $useYN = updateSQ($use_hidden_arr[$i]);
            $period = updateSQ($period_arr[$i]);

            $opt_sql = "
                INSERT INTO tbl_goods_manage SET
                    g_code='".mysqli_real_escape_string($connect,$goods_code)."',
                    type='".mysqli_real_escape_string($connect,$vals)."',
                    gubun='".mysqli_real_escape_string($connect,$gubun)."',
                    visit_type='".mysqli_real_escape_string($connect,$visit_type)."',
                    useYN='".mysqli_real_escape_string($connect,$useYN)."',
                    period='".mysqli_real_escape_string($connect,$period)."'
            ";
            mysqli_query($connect, $opt_sql);
        }

        $detail_visit_type_arr = isset($_POST[$vals . "_detail_visit_type"]) ? $_POST[$vals . "_detail_visit_type"] : [];
        $price_chk_hidden_arr = isset($_POST[$vals . "_price_chk_hidden"]) ? $_POST[$vals . "_price_chk_hidden"] : [];
        $subject_arr = isset($_POST[$vals . "_subject"]) ? $_POST[$vals . "_subject"] : [];
        $price_arr = isset($_POST[$vals . "_price"]) ? $_POST[$vals . "_price"] : [];
        $cmbind_discnt_hidden_arr = isset($_POST[$vals . "_cmbind_discnt_hidden"]) ? $_POST[$vals . "_cmbind_discnt_hidden"] : [];
        
        for ($i = 0; $i < count($detail_visit_type_arr); $i++) {
            
            $detail_visit_type = updateSQ($detail_visit_type_arr[$i]);
            $detail_gubun = updateSQ($gubun_arr[$i]);
            $gubun2 = 1;
            
            $price_chk = updateSQ($price_chk_hidden_arr[$i]);
            $subject = updateSQ($subject_arr[$i]);
            $price = updateSQ($price_arr[$i]);
            $cmbind = updateSQ($cmbind_discnt_hidden_arr[$i]);

            $opt_detail_sql = "
                INSERT INTO tbl_goods_manage_detail SET
                    g_code='".mysqli_real_escape_string($connect,$goods_code)."',
                    gubun='".mysqli_real_escape_string($connect,$detail_gubun)."',
                    gubun2='".mysqli_real_escape_string($connect,$gubun2)."',
                    type='".mysqli_real_escape_string($connect,$vals)."',
                    visit_type='".mysqli_real_escape_string($connect,$detail_visit_type)."',
                    subject='".mysqli_real_escape_string($connect,$subject)."',
                    price='".mysqli_real_escape_string($connect,$price)."',
                    price_chk='".mysqli_real_escape_string($connect,$price_chk)."',
                    cmbind_discnt='".mysqli_real_escape_string($connect,$cmbind)."'
            ";
            mysqli_query($connect, $opt_detail_sql);
        }
    }

    foreach ($type_chk_arr as $vals) {
        $txt1 = isset($_POST[$vals . "_txt1"]) ? updateSQ($_POST[$vals . "_txt1"]) : "";
        $txt2 = isset($_POST[$vals . "_txt2"]) ? updateSQ($_POST[$vals . "_txt2"]) : "";

        $chk = mysqli_query($connect, "
            SELECT * FROM tbl_goods_type_text
            WHERE g_code='".mysqli_real_escape_string($connect,$goods_code)."' 
              AND type='".mysqli_real_escape_string($connect,$vals)."'
        ");

        if (mysqli_num_rows($chk) > 0) {
            mysqli_query($connect, "
                UPDATE tbl_goods_type_text SET
                    txt1='".mysqli_real_escape_string($connect,$txt1)."',
                    txt2='".mysqli_real_escape_string($connect,$txt2)."'
                WHERE g_code='".mysqli_real_escape_string($connect,$goods_code)."' 
                  AND type='".mysqli_real_escape_string($connect,$vals)."'
            ");
        } else {
            mysqli_query($connect, "
                INSERT INTO tbl_goods_type_text SET
                    g_code='".mysqli_real_escape_string($connect,$goods_code)."',
                    type='".mysqli_real_escape_string($connect,$vals)."',
                    txt1='".mysqli_real_escape_string($connect,$txt1)."',
                    txt2='".mysqli_real_escape_string($connect,$txt2)."'
            ");
        }
    }


    $g_idx_sql = "SELECT IFNULL(MAX(g_idx)+1,1) AS g_idx FROM tbl_goods";
    $g_idx_result = mysqli_query($connect, $g_idx_sql);
    $g_idx_row = mysqli_fetch_array($g_idx_result);
    $in_g_idx = $g_idx_row['g_idx'];

    for ($i = 1; $i <= 4; $i++){
        $fb_sql = "
            INSERT INTO tbl_goods_fb SET
                g_idx='".mysqli_real_escape_string($connect,$in_g_idx)."',
                fb_idx='".${"fb_idx".$i}."',
                fb_use='".${"f_p_use".$i}."',
                fb_sel='".${"f_p_sel".$i}."',
                fb_val='".${"freebies".$i}."'
        ";
        mysqli_query($connect, $fb_sql);
    }


    $sql = "
        INSERT INTO tbl_goods SET
             product_code            = '".mysqli_real_escape_string($connect,$product_code)."'
            ,product_group           = '".mysqli_real_escape_string($connect,$product_group)."'
            ,goods_code              = '".mysqli_real_escape_string($connect,$goods_code)."'
            ,goods_code_show         = '".mysqli_real_escape_string($connect,$goods_code_show)."'
            ,goods_erp               = '".mysqli_real_escape_string($connect,$goods_erp)."'
            ,goods_seoson            = '".mysqli_real_escape_string($connect,$goods_seoson)."'
            ,promotion_txt1          = '".mysqli_real_escape_string($connect,$promotion_txt1)."'
            ,promotion_txt2          = '".mysqli_real_escape_string($connect,$promotion_txt2)."'
            ,goods_name_en           = '".mysqli_real_escape_string($connect,$goods_name_en)."'
            ,goods_color             = '".mysqli_real_escape_string($connect,$goods_color)."'
            ,goods_erp_name          = '".mysqli_real_escape_string($connect,$goods_erp_name)."'
            ,goods_keyword           = '".mysqli_real_escape_string($connect,$goods_keyword)."'
            ,goods_brand             = '".mysqli_real_escape_string($connect,$goods_brand)."'
            ,goods_make_date         = '".mysqli_real_escape_string($connect,$goods_make_date)."'
            ,goods_country           = '".mysqli_real_escape_string($connect,$goods_country)."'
            ,make_co                 = '".mysqli_real_escape_string($connect,$make_co)."'
            ,gender                  = '".mysqli_real_escape_string($connect,$gender)."'
            ,reg_type                = '".mysqli_real_escape_string($connect,$reg_type)."'
            ,parallel                = '".mysqli_real_escape_string($connect,$parallel)."'
            ,nocoupon                = '".mysqli_real_escape_string($connect,$nocoupon)."'
            ,goods_icon              = '".mysqli_real_escape_string($connect,$goods_icon_txt)."'
            ,product_dbcolor         = '".mysqli_real_escape_string($connect,$product_dbcolor)."'
            ,md_comment              = '".mysqli_real_escape_string($connect,$md_comment)."'
            ,item_state              = '".mysqli_real_escape_string($connect,$item_state)."'
            ,admin_memo              = '".mysqli_real_escape_string($connect,$admin_memo)."'
            ,price_mk                = '".mysqli_real_escape_string($connect,$price_mk)."'
            ,price_dc                = '".mysqli_real_escape_string($connect,$price_dc)."'
            ,price_se                = '".mysqli_real_escape_string($connect,$price_se)."'
            ,price_mk_buy            = '".mysqli_real_escape_string($connect,$price_mk_buy)."'
            ,price_dc_buy            = '".mysqli_real_escape_string($connect,$price_dc_buy)."'
            ,price_se_buy            = '".mysqli_real_escape_string($connect,$price_se_buy)."'
            ,item_tax                = '".mysqli_real_escape_string($connect,$item_tax)."'
            ,price_fs                = '".mysqli_real_escape_string($connect,$price_fs)."'
            ,point_more              = '".mysqli_real_escape_string($connect,$point_more)."'
            ,item_min_order          = '".mysqli_real_escape_string($connect,$item_min_order)."'
            ,item_max_order          = '".mysqli_real_escape_string($connect,$item_max_order)."'
            ,unit_uid                = '".mysqli_real_escape_string($connect,$unit_uid)."'
            ,dis_date_use            = '".mysqli_real_escape_string($connect,$dis_date_use)."'
            ,dis_date_s              = '".mysqli_real_escape_string($connect,$dis_date_s)."'
            ,dis_date_e              = '".mysqli_real_escape_string($connect,$dis_date_e)."'
            ,price_ds                = '".mysqli_real_escape_string($connect,$price_ds)."'
            ,product_color           = '".mysqli_real_escape_string($connect,$product_color)."'
            ,product_size            = '".mysqli_real_escape_string($connect,$product_size)."'
            ,product_option          = '".mysqli_real_escape_string($connect,$product_option)."'
            ,realsize_dif            = '".mysqli_real_escape_string($connect,$realsize_dif)."'
            ,real_size_code          = '".mysqli_real_escape_string($connect,$real_size_code)."'
            ,item_weight             = '".mysqli_real_escape_string($connect,$item_weight)."'
            ,use_month               = '".mysqli_real_escape_string($connect,$use_month)."'
            ,rfile1                  = '".mysqli_real_escape_string($connect,$rfile1)."'
            ,rfile2                  = '".mysqli_real_escape_string($connect,$rfile2)."'
            ,rfile3                  = '".mysqli_real_escape_string($connect,$rfile3)."'
            ,rfile4                  = '".mysqli_real_escape_string($connect,$rfile4)."'
            ,rfile5                  = '".mysqli_real_escape_string($connect,$rfile5)."'
            ,rfile6                  = '".mysqli_real_escape_string($connect,$rfile6)."'
            ,ufile1                  = '".mysqli_real_escape_string($connect,$ufile1)."'
            ,ufile2                  = '".mysqli_real_escape_string($connect,$ufile2)."'
            ,ufile3                  = '".mysqli_real_escape_string($connect,$ufile3)."'
            ,ufile4                  = '".mysqli_real_escape_string($connect,$ufile4)."'
            ,ufile5                  = '".mysqli_real_escape_string($connect,$ufile5)."'
            ,ufile6                  = '".mysqli_real_escape_string($connect,$ufile6)."'
            ,content                 = '".mysqli_real_escape_string($connect,$content)."'
            ,caution                 = '".mysqli_real_escape_string($connect,$caution)."'
            ,good_cnt                = '".mysqli_real_escape_string($connect,$good_cnt)."'
            ,goods_dis1              = '".mysqli_real_escape_string($connect,$goods_dis1)."'
            ,goods_dis2              = '".mysqli_real_escape_string($connect,$goods_dis2)."'
            ,goods_dis3              = '".mysqli_real_escape_string($connect,$goods_dis3)."'
            ,goods_dis4              = '".mysqli_real_escape_string($connect,$goods_dis4)."'
            ,goods_dis5              = '".mysqli_real_escape_string($connect,$goods_dis5)."'
            ,freeb                   = '".mysqli_real_escape_string($connect,$freeb)."'
            ,type                    = '".mysqli_real_escape_string($connect,$type_chk)."'
            ,default_type            = '".mysqli_real_escape_string($connect,$default_type)."'
            ,default_period          = '".mysqli_real_escape_string($connect,$default_period)."'
            ,period_cnt              = '".mysqli_real_escape_string($connect,$period_cnt)."'
            ,detail_cate             = '".mysqli_real_escape_string($connect,$detail_cate)."'
            ,detail_srch             = '".mysqli_real_escape_string($connect,$detail_chk)."'
            ,badge1                  = '".mysqli_real_escape_string($connect,$badge1)."'
            ,badge2                  = '".mysqli_real_escape_string($connect,$badge2)."'
			,goods_size              = '".mysqli_real_escape_string($connect,$goods_size)."'
            ,goods_hardness          = '".mysqli_real_escape_string($connect,$goods_hardness)."'
            ,goods_topper            = '".mysqli_real_escape_string($connect,$goods_topper)."'
            ,goods_additional        = '".mysqli_real_escape_string($connect,$goods_additional)."'
            ,total_p_txt             = '".mysqli_real_escape_string($connect,$total_p_txt)."'
            ,item_logo               = '".mysqli_real_escape_string($connect,$item_logo)."'
            ,reg_id                  = '".$_SESSION['member']['id']."'
            ,reg_date                = now()
    ";
    write_log("상품등록 : ".$sql);
    mysqli_query($connect, $sql) or die(mysqli_error($connect));

    $goods_color_list = isset($_POST['goods_color']) ? explode(",", $_POST['goods_color']) : [];
    $color_notes = [];
    foreach($_POST as $key => $val){
        if (strpos($key,"color_note_")===0){
            $color_code = "#".substr($key,11);
            $color_notes[$color_code] = updateSQ($val);
        }
    }
    foreach($goods_color_list as $color){
        $color_safe = updateSQ($color);
        $note_safe = isset($color_notes[$color])?$color_notes[$color]:"";
        mysqli_query($connect,"INSERT INTO tbl_goods_color SET g_idx='".mysqli_real_escape_string($connect,$in_g_idx)."', color='".mysqli_real_escape_string($connect,$color_safe)."', name_color='".mysqli_real_escape_string($connect,$note_safe)."'");
    }
}

?>
<script>
    <?php if ($g_idx) { ?>
        alert("수정되었습니다.");
        parent.location.reload();
    <?php } else { ?>
        alert("등록되었습니다.");
        parent.location.href="/AdmMaster/_goods/list.php";
    <?php } ?>
</script>
