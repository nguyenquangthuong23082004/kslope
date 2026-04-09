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
	$goods_erp				= updateSQ($_POST["goods_erp"]);
	$goods_seoson			= updateSQ($_POST["goods_seoson"]);
	$goods_name_front		= updateSQ($_POST["goods_name_front"]);
	$goods_name_back		= updateSQ($_POST["goods_name_back"]);
	$goods_name_en			= updateSQ($_POST["goods_name_en"]);
	$goods_color			= updateSQ($_POST["goods_color"]);
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
	$option_YN				= updateSQ($_POST["option_YN"]);

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



	$product_group = "";

	if($product_group_4 != ""){
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


for ($i=1;$i<=6;$i++)
{
	if (${"del_".$i} =="Y"){
		$sql = "
			UPDATE tbl_goods SET
			ufile".$i."='',
			rfile".$i."=''
			WHERE g_idx='$g_idx'
		";
		mysqli_query($connect, $sql) or die (mysqli_error($connect));

	} elseif($_FILES["ufile".$i]['name']){

		$wow=$_FILES["ufile".$i]['name'];
		if (no_file_ext($_FILES["ufile".$i]['name']) != "Y") {
			echo "NF";
			exit();
		}

		${"rfile_".$i}=$wow;
		$wow2=$_FILES["ufile".$i]['tmp_name'];//tmp 폴더의 파일
		${"ufile_".$i}=file_check($wow,$wow2,$upload,"N");

		if ($g_idx) {
				$sql = "
					UPDATE tbl_goods SET
					ufile".$i."='".${"ufile_".$i}."',
					rfile".$i."='".${"rfile_".$i}."'
					WHERE g_idx='$g_idx';
				";
				mysqli_query($connect, $sql) or die (mysqli_error($connect));
		}

	}
}

if ($g_idx){

	// 기존 옵션 삭제
	/*
	$sql = " delete from tbl_goods_option where goods_code = '".$goods_code."' ";
	mysqli_query($connect, $sql) or die (mysqli_error($connect));


	// 옵션 재등록
	
	foreach($product_option_ar as $arr1){
		//echo $arr1 . "<br/>";

		$_tmp_arr = explode(":", $arr1);

		$_tmp_color = $_tmp_arr[0];
		$_tmp_size = $_tmp_arr[1];

		$goods_cnt = ${"option_cnt_".$_tmp_color."_".$_tmp_size};
		$use_yn = ${"option_use_".$_tmp_color."_".$_tmp_size};


		$sql_su = "
			insert into tbl_goods_option SET
				 goods_code		= '".$goods_code."'
				,goods_color	= '".$_tmp_color."'
				,goods_size		= '".$_tmp_size."'
				,goods_cnt		= '".$goods_cnt."'
				,use_yn			= '".$use_yn."'
		";

		mysqli_query($connect, $sql_su) or die (mysqli_error($connect));
	}
	*/


	




	foreach($o_idx as $key => $val){

		$upload="../../data/product/";

		$sql_chk = "
					select count(*) as cnts
					  from tbl_goods_option
					 where idx	= '".$val."'
					";
		$result_chk	= mysqli_query($connect, $sql_chk) or die (mysql_error($connect));
		$row_chk	= mysqli_fetch_array($result_chk);

		$afile = "";
		$bfile = "";


		// 이미지 처리
		
		if($_FILES['a_file']['name'][$key]){

			$wow = $_FILES['a_file']['name'][$key];

			/*
			if (no_file_ext($_FILES["ufile".$i]['name']) != "Y") {
				echo "NF";
				exit();
			}
			*/

			$afile	= $wow;
			$wow2	= $_FILES["a_file"]['tmp_name'][$key];//tmp 폴더의 파일
			$bfile	= file_check($wow,$wow2,$upload,"N");
			
			// 등록된 옵션이라면... 
			if( $row_chk['cnts'] > 0){
				$sql = "
					UPDATE tbl_goods_option SET
					bfile ='".$bfile."',
					afile ='".$afile."'
					where idx	= '".$val."'
				";
				mysqli_query($connect, $sql) or die (mysqli_error($connect));
			}
		}

				
		// 이미 등록된 옵션이 아니라면...
		if( $row_chk['cnts'] < 1){
			$sql_su = "
				insert into tbl_goods_option SET
					 goods_code		= '".$goods_code."'
					,goods_name		= '".$o_name[$key]."'
					,goods_price	= '".$o_price[$key]."'
					,goods_cnt		= '".$o_jaego[$key]."'
					,afile			= '".$afile."'
					,bfile			= '".$bfile."'
					,option_type	= '".$option_type[$key]."'
			";

			mysqli_query($connect, $sql_su) or die (mysqli_error($connect));


		}else{
			$sql_su = "
				update tbl_goods_option SET 
					 goods_name		= '".$o_name[$key]."'
					,goods_price	= '".$o_price[$key]."'
					,goods_cnt		= '".$o_jaego[$key]."'
					,option_type	= '".$option_type[$key]."'
				where idx	= '".$val."'
			";

			mysqli_query($connect, $sql_su) or die (mysqli_error($connect));
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
			,option_YN				= '".$option_YN."'
			,goods_dis1				= '".$goods_dis1."'
			,goods_dis2				= '".$goods_dis2."'
			,goods_dis3				= '".$goods_dis3."'
			,goods_dis4				= '".$goods_dis4."'
			,goods_dis5				= '".$goods_dis5."'
			,freeb					= '".$freeb."'
			,mod_date				= now()
		where g_idx = '".$g_idx."'
	";
	write_log("상품등록 : ".$sql);
	mysqli_query($connect, $sql) or die (mysqli_error($connect));




} else {

	// 옵션 등록
	foreach($o_idx as $key => $val){
		//echo $val . " / " . $o_name[$key] . " / " . $o_price[$key] . " / " . $o_jaego[$key] . "<br/>";

		$afile = "";
		$bfile = "";

		// 이미지 처리
		
		if($_FILES['a_file']['name'][$key]){

			$wow = $_FILES['a_file']['name'][$key];

			/*
			if (no_file_ext($_FILES["ufile".$i]['name']) != "Y") {
				echo "NF";
				exit();
			}
			*/

			$afile	= $wow;
			$wow2	= $_FILES["a_file"]['tmp_name'][$key];//tmp 폴더의 파일
			$bfile	= file_check($wow,$wow2,$upload,"N");
			
			
		}







		$sql_su = "
			insert into tbl_goods_option SET
				 goods_code		= '".$goods_code."'
				,goods_name		= '".$o_name[$key]."'
				,goods_price	= '".$o_price[$key]."'
				,goods_cnt		= '".$o_jaego[$key]."'
				,afile			= '".$afile."'
				,bfile			= '".$bfile."'
				,option_type	= '".$option_type[$key]."'
		";

		mysqli_query($connect, $sql_su) or die (mysqli_error($connect));

	}


	$sql = "
		insert into tbl_goods SET
			 product_code			= '".$product_code."'
			,product_group			= '".$product_group."'
			,goods_code				= '".$goods_code."'
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
			,rfile1					= '".$rfile_1."'
			,rfile2					= '".$rfile_2."'
			,rfile3					= '".$rfile_3."'
			,rfile4					= '".$rfile_4."'
			,rfile5					= '".$rfile_5."'
			,rfile6					= '".$rfile_6."'
			,ufile1					= '".$ufile_1."'
			,ufile2					= '".$ufile_2."'
			,ufile3					= '".$ufile_3."'
			,ufile4					= '".$ufile_4."'
			,ufile5					= '".$ufile_5."'
			,ufile6					= '".$ufile_6."'
			,content				= '".$content."'
			,caution				= '".$caution."'
			,good_cnt				= '".$good_cnt."'
			,option_YN				= '".$option_YN."'
			,goods_dis1				= '".$goods_dis1."'
			,goods_dis2				= '".$goods_dis2."'
			,goods_dis3				= '".$goods_dis3."'
			,goods_dis4				= '".$goods_dis4."'
			,goods_dis5				= '".$goods_dis5."'
			,freeb					= '".$freeb."'
			,reg_id					= '".$_SESSION[member][id]."'
			,reg_date				= now()
	";
	write_log("상품수정 : ".$sql);
	mysqli_query($connect, $sql) or die (mysqli_error($connect));

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
