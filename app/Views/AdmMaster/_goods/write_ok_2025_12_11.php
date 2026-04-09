<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";
//	mysql_query("SET AUTOCOMMIT=0");
//	mysql_query("START TRANSACTION");
	/*
	echo "a : ";
	foreach ($_FILES['a_file']['name'] as $key => $file) {

		//do your upload stuff here
		echo $key . " => " .  $file;

	}

	echo "<br/>=================<br/>";
	echo $_FILES['a_file']['name'][0];
	*/
	
	

	/* 추후 사용하지 않을 경우 제거 예정
	$pg					= updateSQ($_POST["pg"]);
	$search_name		= updateSQ($_POST["search_name"]);
	$search_category	= updateSQ($_POST["search_category"]);
	*/
	$upload="../../data/product/";


	$g_idx					= updateSQ($_POST["g_idx"]);
	$product_code			= updateSQ($_POST["product_code"]);
	$product_dbcolor		= updateSQ($_POST["product_dbcolor"]);
	$product_color			= updateSQ($_POST["product_color"]);
	$product_size			= updateSQ($_POST["product_size"]);
	$product_option			= updateSQ($_POST["product_option"]);
	$realsize_dif			= updateSQ($_POST["realsize_dif"]);
	$use_month				= updateSQ($_POST["use_month"]);

	$goods_code				= updateSQ($_POST["goods_code"]);
	$goods_code_show		= updateSQ($_POST["goods_code_show"]);
	$goods_erp				= updateSQ($_POST["goods_erp"]);
	$goods_seoson			= updateSQ($_POST["goods_seoson"]);
	$goods_name_front		= updateSQ($_POST["goods_name_front"]);
	$goods_name_back		= updateSQ($_POST["goods_name_back"]);
	$goods_name_en			= updateSQ($_POST["goods_name_en"]);
	// $goods_color = isset($_POST["goods_color"]) 
    // ? updateSQ(implode(",", $_POST["goods_color"])) 
    // : "";
	$goods_erp_name			= updateSQ($_POST["goods_erp_name"]);
	$goods_keyword			= updateSQ($_POST["goods_keyword"]);
	$goods_brand			= updateSQ($_POST["goods_brand"]);
	$goods_make_date		= updateSQ($_POST["goods_make_date"]);
	$goods_country			= updateSQ($_POST["goods_country"]);
	$make_co				= updateSQ($_POST["make_co"]);
	$gender					= updateSQ($_POST["gender"]);
	$reg_type				= updateSQ($_POST["reg_type"]);
	$nocoupon				= updateSQ($_POST["nocoupon"]);
	$parallel				= updateSQ($_POST["parallel"]);
	$md_comment				= updateSQ($_POST["md_comment"]);
	$item_state				= updateSQ($_POST["item_state"]);
	$admin_memo				= updateSQ($_POST["admin_memo"]);
	$price_mk				= updateSQ($_POST["price_mk"]);
	$price_dc				= updateSQ($_POST["price_dc"]);
	$price_se				= updateSQ($_POST["price_se"]);
	$item_tax				= updateSQ($_POST["item_tax"]);
	$price_fs				= updateSQ($_POST["price_fs"]);
	$point_more				= updateSQ($_POST["point_more"]);
	$item_min_order			= updateSQ($_POST["item_min_order"]);
	$item_max_order			= updateSQ($_POST["item_max_order"]);
	$unit_uid				= updateSQ($_POST["unit_uid"]);
	$dis_date_use			= updateSQ($_POST["dis_date_use"]);
	$dis_date_s				= updateSQ($_POST["dis_date_s"]);
	$dis_date_e				= updateSQ($_POST["dis_date_e"]);
	$price_ds				= updateSQ($_POST["price_ds"]);
	$real_size_code			= updateSQ($_POST["real_size_code"]);
	$item_weight			= updateSQ($_POST["item_weight"]);
	$content				= updateSQ($_POST["content"]);
	$caution				= updateSQ($_POST["caution"]);
	$good_cnt				= updateSQ($_POST["good_cnt"]);
	//$option_YN				= updateSQ($_POST["option_YN"]);

	$product_group_1		= updateSQ($_POST["product_group_1"]);
	$product_group_2		= updateSQ($_POST["product_group_2"]);
	$product_group_3		= updateSQ($_POST["product_group_3"]);
	$product_group_4		= updateSQ($_POST["product_group_4"]);

	$goods_dis1				= updateSQ($_POST["goods_dis1"]);
	$goods_dis2				= updateSQ($_POST["goods_dis2"]);
	$goods_dis3				= updateSQ($_POST["goods_dis3"]);
	$goods_dis4				= updateSQ($_POST["goods_dis4"]);
	$goods_dis5				= updateSQ($_POST["goods_dis5"]);

	$freeb					= updateSQ($_POST["freeb"]);
	$product_type			= updateSQ($_POST["product_type"]);

	$goods_icon				= $_POST['goods_icon'];
	$item_logo				= $_POST['item_logo'];

    $badge1                 = updateSQ($_POST['badge1']);
    $badge2                 = updateSQ($_POST['badge2']);

	$self_txt1                 = updateSQ($_POST['self_txt1']);
    $self_txt2                 = updateSQ($_POST['self_txt2']);
	$visit_txt1                = updateSQ($_POST['visit_txt1']);
    $visit_txt2                = updateSQ($_POST['visit_txt2']);

	$total_p_txt			= updateSQ($_POST['total_p_txt']);
	//관리유형 값
	$type_chk_arr			= $_POST['type_chk'];
	$type_chk = '';
	for( $i=0; $i < count($type_chk_arr); $i++){
		$type_chk = $type_chk."|".$type_chk_arr[$i]."|";
	}

	$period_cnt				 = updateSQ($_POST['period_cnt']);

	$default_period			 = updateSQ($_POST['default_period']);
	$default_type			 = updateSQ($_POST['default_type']);

	for($i=1; $i<=4; $i++){
        ${"self_gubun".$i}		= updateSQ($_POST["self_gubun".$i]);
		${"self_use".$i}		= updateSQ($_POST["self_use".$i]);
        ${"self_period".$i}		= updateSQ($_POST["self_period".$i]);
        ${"visit_gubun".$i}		= updateSQ($_POST["visit_gubun".$i]);
        ${"visit_use".$i}		= updateSQ($_POST["visit_use".$i]);
        ${"visit_period".$i}	= updateSQ($_POST["visit_period".$i]);

		${"fb_idx".$i}			= updateSQ($_POST['fb_idx'.$i]);
		${"f_p_use".$i}			= updateSQ($_POST["f_p_use".$i]);
		${"f_p_sel".$i}			= updateSQ($_POST["f_p_sel".$i]);
		${"freebies_arr".$i}	= $_POST["freebies".$i];

		for($j=1; $j<=4; $j++){
			${"self_gubun".$i."_".$j}			= updateSQ($_POST["self_gubun".$i."_".$j]);
			${"self_subject".$i."_".$j}			= updateSQ($_POST["self_subject".$i."_".$j]);
            ${"self_price".$i."_".$j}			= updateSQ($_POST["self_price".$i."_".$j]);
            ${"self_price_chk".$i."_".$j}		= updateSQ($_POST["self_price_chk".$i."_".$j]);
			${"self_cmbind_discnt".$i."_".$j}	= updateSQ($_POST["self_cmbind_discnt".$i."_".$j]);
			${"visit_gubun".$i."_".$j}			= updateSQ($_POST["visit_gubun".$i."_".$j]);
			${"visit_subject".$i."_".$j}		= updateSQ($_POST["visit_subject".$i."_".$j]);
			${"visit_price".$i."_".$j}			= updateSQ($_POST["visit_price".$i."_".$j]);
            ${"visit_price_chk".$i."_".$j}		= updateSQ($_POST["visit_price_chk".$i."_".$j]);
			${"visit_cmbind_discnt".$i."_".$j}	= updateSQ($_POST["visit_cmbind_discnt".$i."_".$j]);
		}
    }

	//상세검색 조건
	$detail_cate			 = updateSQ($_POST['detail_cate']);
	$detail_chk_arr			 = $_POST['detail_chk'];

	$detail_chk = '';
	for($i=0; $i <count($detail_chk_arr); $i++){
		$detail_chk = $detail_chk."|".$detail_chk_arr[$i]."|";
	}

	for ($i=1; $i <= 6; $i++){
		${'ufile'.$i}		= updateSQ($_POST['ufile'.$i]);
		${'rfile'.$i}		= updateSQ($_POST['rfile'.$i]);
	}

	for($i=1; $i<=4; $i++){
		${"freebies".$i} = '';
		for($j=0; $j<count(${"freebies_arr".$i}); $j++){
			${"freebies".$i} = ${"freebies".$i}."|".${"freebies_arr".$i}[$j]."|";
		}
	}
//print_r($freebies1);
//print_r($_POST);
//exit();

	$product_group = "";

	if($product_group_4 != "" ){
		$product_group = $product_group_4;
	}else if($product_group_3 != ""){
		$product_group = $product_group_3;
	}else if($product_group_2 != ""){
		$product_group = $product_group_2;
	}else if($product_group_1 != ""){
		$product_group = $product_group_1;
	}






// 아이콘
//print_r($goods_icon);
$goods_icon_txt = "";
foreach($goods_icon as $value){
	$goods_icon_txt .= "|"  . $value . "|";
}


$product_option_re = substr($product_option,1,strlen($product_option)-2);
$product_option_ar = explode("||",$product_option_re);

/*
echo $product_option . "<br/>";
echo $product_option_re . "<br/>";
*/


if($g_idx){


	foreach($type_chk_arr as $keys => $vals){
		$cnt_sql = "select * from tbl_goods_manage where g_code = '".$goods_code."' and type = '".$vals."' ";
		$cnt_result = mysqli_query($connect, $cnt_sql);
        $cnt = mysqli_num_rows($cnt_result);
        $row = mysqli_fetch_array($cnt_result);
		if( $cnt > 0 ){
            
            for ($i=1; $i<=4; $i++){
				$opt_chk_sql = "
					select * 
						from tbl_goods_manage 
							where g_code = '".$goods_code."' 
							 and type = '".$vals."'
							 and gubun = '".${$vals."_gubun".$i}."'
				";
				$opt_chk_result = mysqli_query($connect, $opt_chk_sql);
				$opt_chk_cnt = mysqli_num_rows($opt_chk_result);
				if($opt_chk_cnt < 1){
					$opt_sql = "
						insert into tbl_goods_manage set
							 g_code		= '".$goods_code."'
							,type		= '".$vals."'
							,useYN		= '".${$vals."_use".$i}."'
							,period 	= '".${$vals."_period".$i}."'
							,gubun      = '".${$vals."_gubun".$i}."'
					";
					mysqli_query($connect, $opt_sql);
				}else{
					$opt_sql = "
						update tbl_goods_manage set
							 g_code		= '".$goods_code."'
							,type		= '".$vals."'
							,useYN		= '".${$vals."_use".$i}."'
							,period 	= '".${$vals."_period".$i}."'
						where g_code = '".$goods_code."' and type = '".$vals."' and gubun = '".${$vals."_gubun".$i}."'
					";
					mysqli_query($connect, $opt_sql);
				}
                for($j=1; $j<=4; $j++){

					$opt_detail_sql = "
						update tbl_goods_manage_detail set
							 g_code			= '".$goods_code."'
							,type			= '".$vals."'
							,subject		= '".${$vals."_subject".$i."_".$j}."'
                            ,price			= '".${$vals."_price".$i."_".$j}."'
                            ,price_chk		= '".${$vals."_price_chk".$i."_".$j}."'
							,cmbind_discnt	= '".${$vals."_cmbind_discnt".$i."_".$j}."'
                        where g_code = '".$goods_code."' 
                            and type = '".$vals."' 
                            and gubun = '".${$vals."_gubun".$i}."' 
                            and gubun2 = '".${$vals."_gubun".$i."_".$j}."' 
					";
					mysqli_query($connect, $opt_detail_sql);
				}
			}
		}else{
            
            for ($i=1; $i<=4; $i++){
                $opt_sql = "
                    insert into tbl_goods_manage set
                        g_code		= '".$goods_code."'
                        ,type		= '".$vals."'
                        ,gubun      = '".${$vals."_gubun".$i}."'
                        ,useYN		= '".${$vals."_use".$i}."'
                        ,period 	= '".${$vals."_period".$i}."'
                ";
                mysqli_query($connect, $opt_sql);
				for($j=1; $j<=4; $j++){
					$opt_detail_sql = "
						insert into tbl_goods_manage_detail set
							 g_code			= '".$goods_code."'
                            ,gubun			= '".${$vals."_gubun".$i}."'
                            ,gubun2			= '".${$vals."_gubun".$i."_".$j}."'
							,type			= '".$vals."'
							,subject		= '".${$vals."_subject".$i."_".$j}."'
                            ,price			= '".${$vals."_price".$i."_".$j}."'
                            ,price_chk		= '".${$vals."_price_chk".$i."_".$j}."'
							,cmbind_discnt	= '".${$vals."_cmbind_discnt".$i."_".$j}."'
					";
					mysqli_query($connect, $opt_detail_sql);
				}
			}
		}
	}
	
	for($i=1; $i<=4; $i++){
		$fb_cnt_sql = " select * from tbl_goods_fb where g_idx = '".$g_idx."' and fb_idx = '".${"fb_idx".$i}."' ";
		$fb_cnt_result = mysqli_query($connect, $fb_cnt_sql);
		$fb_cnt = mysqli_num_rows($fb_cnt_result);

		if($fb_cnt > 0){
			$fb_sql = "
				update tbl_goods_fb set
					 fb_use		= '".${"f_p_use".$i}."'
					,fb_sel		= '".${"f_p_sel".$i}."'
					,fb_val		= '".${"freebies".$i}."'
				where g_idx = '".$g_idx."' and fb_idx = '".${"fb_idx".$i}."'
			";
			mysqli_query($connect, $fb_sql);
		}else{
			$fb_sql = "
				insert into tbl_goods_fb set
					 g_idx		= '".$g_idx."'
					,fb_idx		= '".${"fb_idx".$i}."'
					,fb_use		= '".${"f_p_use".$i}."'
					,fb_sel		= '".${"f_p_sel".$i}."'
					,fb_val		= '".${"freebies".$i}."'
			";
			mysqli_query($connect, $fb_sql);
		}
	}

	// 상품 테이블 변경

	$sql = "
		update tbl_goods SET
			 product_code			= '".$product_code."'
			,product_group			= '".$product_group."'
			,goods_seoson			= '".$goods_seoson."'
			,goods_name_front		= '".$goods_name_front."'
			,goods_name_back		= '".$goods_name_back."'
			,goods_name_en			= '".$goods_name_en."'
			,goods_code_show		= '".$goods_code_show."'
			,goods_code				= '".$goods_code."'
			,goods_color			= '".$goods_color."'
			,goods_erp_name			= '".$goods_erp_name."'
			,goods_keyword			= '".$goods_keyword."'
			,goods_brand			= '".$goods_brand."'
			,goods_make_date		= '".$goods_make_date."'
			,goods_country			= '".$goods_country."'
			,make_co				= '".$make_co."'
			,gender					= '".$gender."'
			,reg_type				= '".$reg_type."'
			,parallel				= '".$parallel."'
			,nocoupon				= '".$nocoupon."'
			,goods_icon				= '".$goods_icon_txt."'
			,product_dbcolor		= '".$product_dbcolor."'
			,md_comment				= '".$md_comment."'
			,item_state				= '".$item_state."'
			,admin_memo				= '".$admin_memo."'
			,price_mk				= '".$price_mk."'
			,price_dc				= '".$price_dc."'
			,price_se				= '".$price_se."'
			,item_tax				= '".$item_tax."'
			,price_fs				= '".$price_fs."'
			,point_more				= '".$point_more."'
			,item_min_order			= '".$item_min_order."'
			,item_max_order			= '".$item_max_order."'
			,unit_uid				= '".$unit_uid."'
			,dis_date_use			= '".$dis_date_use."'
			,dis_date_s				= '".$dis_date_s."'
			,dis_date_e				= '".$dis_date_e."'
			,price_ds				= '".$price_ds."'
			,product_color			= '".$product_color."'
			,product_size			= '".$product_size."'
			,product_option			= '".$product_option."'
			,realsize_dif			= '".$realsize_dif."'
			,real_size_code			= '".$real_size_code."'
			,item_weight			= '".$item_weight."'
			,use_month				= '".$use_month."'
			,content				= '".$content."'
			,caution				= '".$caution."'
			,good_cnt				= '".$good_cnt."'
			,goods_dis1				= '".$goods_dis1."'
			,goods_dis2				= '".$goods_dis2."'
			,goods_dis3				= '".$goods_dis3."'
			,goods_dis4				= '".$goods_dis4."'
			,goods_dis5				= '".$goods_dis5."'
			,ufile1					= '".$ufile1."'
			,ufile2					= '".$ufile2."'
			,ufile3					= '".$ufile3."'
			,ufile4					= '".$ufile4."'
			,ufile5					= '".$ufile5."'
			,ufile6					= '".$ufile6."'
			,rfile1					= '".$rfile1."'
			,rfile2					= '".$rfile2."'
			,rfile3					= '".$rfile3."'
			,rfile4					= '".$rfile4."'
			,rfile5					= '".$rfile5."'
			,rfile6					= '".$rfile6."'
			,freeb					= '".$freeb."'
			,type					= '".$type_chk."'
			,default_type			= '".$default_type."'
			,default_period			= '".$default_period."'
			,period_cnt				= '".$period_cnt."'
			,detail_cate			= '".$detail_cate."'
            ,detail_srch			= '".$detail_chk."'
            ,badge1                 = '".$badge1."'
            ,badge2                 = '".$badge2."'
			,self_txt1				= '".$self_txt1."'
			,self_txt2				= '".$self_txt2."'
			,visit_txt1				= '".$visit_txt1."'
			,visit_txt2				= '".$visit_txt2."'
			,total_p_txt			= '".$total_p_txt."'
			,item_logo				= '".$item_logo."'
			,product_type			= '".$product_type."'
			,mod_date				= now()
		where g_idx = '".$g_idx."'
	";
	write_log("상품수정 : ".$sql);
	mysqli_query($connect, $sql) or die (mysqli_error($connect));

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
			mysqli_query($connect, "DELETE FROM tbl_goods_color WHERE g_idx = '$g_idx'");
		} 
		
		else {

			$existing_colors = [];
			$res = mysqli_query($connect, "SELECT color FROM tbl_goods_color WHERE g_idx='$g_idx'");
			while ($row = mysqli_fetch_assoc($res)) {
				$existing_colors[] = $row['color'];
			}

			foreach ($existing_colors as $old_color) {
				if (!in_array($old_color, $goods_color_list)) {
					mysqli_query($connect, 
						"DELETE FROM tbl_goods_color 
						WHERE g_idx='$g_idx' 
						AND color='$old_color'"
					);
				}
			}

			foreach ($goods_color_list as $color) {

				$color_safe = updateSQ($color);
				$note_safe = isset($color_notes[$color]) ? $color_notes[$color] : "";

				$q = "
					SELECT color 
					FROM tbl_goods_color 
					WHERE g_idx='$g_idx' 
					AND color='$color_safe'
				";
				$chk = mysqli_query($connect, $q);

				if (mysqli_num_rows($chk) > 0) {
					mysqli_query(
						$connect,
						"UPDATE tbl_goods_color 
						SET name_color='$note_safe' 
						WHERE g_idx='$g_idx' 
						AND color='$color_safe'"
					);
				} 
				else {
					mysqli_query(
						$connect,
						"INSERT INTO tbl_goods_color 
						SET g_idx='$g_idx', 
							color='$color_safe', 
							name_color='$note_safe'"
					);
				}
			}
		}
	}




} else {
	foreach($type_chk_arr as $keys => $vals){
		for ($i=1; $i<=4; $i++){
			$opt_sql = "
				insert into tbl_goods_manage set
					 g_code		= '".$goods_code."'
					,type		= '".$vals."'
					,gubun      = '".${$vals."_gubun".$i}."'
					,useYN		= '".${$vals."_use".$i}."'
					,period 	= '".${$vals."_period".$i}."'
			";
			mysqli_query($connect, $opt_sql);

			for($j=1; $j<=4; $j++){
				$opt_detail_sql = "
					insert into tbl_goods_manage_detail set
						 g_code			= '".$goods_code."'
                        ,gubun			= '".${$vals."_gubun".$i}."'
                        ,gubun2			= '".${$vals."_gubun".$i."_".$j}."'
						,type			= '".$vals."'
						,subject		= '".${$vals."_subject".$i."_".$j}."'
                        ,price			= '".${$vals."_price".$i."_".$j}."'
                        ,price_chk		= '".${$vals."_price_chk".$i."_".$j}."'
						,cmbind_discnt	= '".${$vals."_cmbind_discnt".$i."_".$j}."'
				";
				mysqli_query($connect, $opt_detail_sql);
			}
		}
	}
	$g_idx_sql = "select ifnull(max(g_idx)+1,1) as g_idx from tbl_goods";
	$g_idx_result = mysqli_query($connect, $g_idx_sql);
	$g_idx_row = mysqli_fetch_array($g_idx_result);
	$in_g_idx = $g_idx_row['g_idx'];

	for($i=1; $i<=4; $i++){
		$fb_sql = "
			insert into tbl_goods_fb set
				 g_idx		= '".$in_g_idx."'
				,fb_idx		= '".${"fb_idx".$i}."'
				,fb_use		= '".${"f_p_use".$i}."'
				,fb_sel		= '".${"f_p_sel".$i}."'
				,fb_val		= '".${"freebies".$i}."'
		";
		mysqli_query($connect, $fb_sql);
	}

	$sql = "
		insert into tbl_goods SET
			 product_code			= '".$product_code."'
			,product_group			= '".$product_group."'
			,goods_code				= '".$goods_code."'
			,goods_code_show		= '".$goods_code_show."'
			,goods_erp				= '".$goods_erp."'
			,goods_seoson			= '".$goods_seoson."'
			,goods_name_front		= '".$goods_name_front."'
			,goods_name_back		= '".$goods_name_back."'
			,goods_name_en			= '".$goods_name_en."'
			,goods_color			= '".$goods_color."'
			,goods_erp_name			= '".$goods_erp_name."'
			,goods_keyword			= '".$goods_keyword."'
			,goods_brand			= '".$goods_brand."'
			,goods_make_date		= '".$goods_make_date."'
			,goods_country			= '".$goods_country."'
			,make_co				= '".$make_co."'
			,gender					= '".$gender."'
			,reg_type				= '".$reg_type."'
			,parallel				= '".$parallel."'
			,nocoupon				= '".$nocoupon."'
			,goods_icon				= '".$goods_icon_txt."'
			,product_dbcolor		= '".$product_dbcolor."'
			,md_comment				= '".$md_comment."'
			,item_state				= '".$item_state."'
			,admin_memo				= '".$admin_memo."'
			,price_mk				= '".$price_mk."'
			,price_dc				= '".$price_dc."'
			,price_se				= '".$price_se."'
			,item_tax				= '".$item_tax."'
			,price_fs				= '".$price_fs."'
			,point_more				= '".$point_more."'
			,item_min_order			= '".$item_min_order."'
			,item_max_order			= '".$item_max_order."'
			,unit_uid				= '".$unit_uid."'
			,dis_date_use			= '".$dis_date_use."'
			,dis_date_s				= '".$dis_date_s."'
			,dis_date_e				= '".$dis_date_e."'
			,price_ds				= '".$price_ds."'
			,product_color			= '".$product_color."'
			,product_size			= '".$product_size."'
			,product_option			= '".$product_option."'
			,realsize_dif			= '".$realsize_dif."'
			,real_size_code			= '".$real_size_code."'
			,item_weight			= '".$item_weight."'
			,use_month				= '".$use_month."'
			,rfile1					= '".$rfile1."'
			,rfile2					= '".$rfile2."'
			,rfile3					= '".$rfile3."'
			,rfile4					= '".$rfile4."'
			,rfile5					= '".$rfile5."'
			,rfile6					= '".$rfile6."'
			,ufile1					= '".$ufile1."'
			,ufile2					= '".$ufile2."'
			,ufile3					= '".$ufile3."'
			,ufile4					= '".$ufile4."'
			,ufile5					= '".$ufile5."'
			,ufile6					= '".$ufile6."'
			,content				= '".$content."'
			,caution				= '".$caution."'
			,good_cnt				= '".$good_cnt."'
			,goods_dis1				= '".$goods_dis1."'
			,goods_dis2				= '".$goods_dis2."'
			,goods_dis3				= '".$goods_dis3."'
			,goods_dis4				= '".$goods_dis4."'
			,goods_dis5				= '".$goods_dis5."'
			,freeb					= '".$freeb."'
			,type					= '".$type_chk."'
			,default_type			= '".$default_type."'
			,default_period			= '".$default_period."'
			,period_cnt				= '".$period_cnt."'
			,detail_cate			= '".$detail_cate."'
            ,detail_srch			= '".$detail_chk."'
            ,badge1                 = '".$badge1."'
            ,badge2                 = '".$badge2."'
			,self_txt1				= '".$self_txt1."'
			,self_txt2				= '".$self_txt2."'
			,visit_txt1				= '".$visit_txt1."'
			,visit_txt2				= '".$visit_txt2."'
			,total_p_txt			= '".$total_p_txt."'
			,item_logo				= '".$item_logo."'
			,reg_id					= '".$_SESSION[member][id]."'
			,reg_date				= now()
	";
	write_log("상품등록 : ".$sql);
	mysqli_query($connect, $sql) or die (mysqli_error($connect));

	$goods_color_list = isset($_POST['goods_color']) ? explode(",", $_POST['goods_color']) : [];
    $color_notes = [];
    foreach($_POST as $key => $val){
        if(strpos($key,"color_note_")===0){
            $color_code = "#".substr($key,11);
            $color_notes[$color_code] = updateSQ($val);
        }
    }
    foreach($goods_color_list as $color){
        $color_safe = updateSQ($color);
        $note_safe = isset($color_notes[$color])?$color_notes[$color]:"";
        mysqli_query($connect,"INSERT INTO tbl_goods_color SET g_idx='$in_g_idx', color='$color_safe', name_color='$note_safe'");
    }
}


?>
<script>
	<?if ($g_idx){?>
	alert("수정되었습니다.");
	parent.location.reload();
	<? } else { ?>
	alert("등록되었습니다.");
	parent.location.href="/AdmMaster/_goods/list.php";
	<?}?>
</script>
