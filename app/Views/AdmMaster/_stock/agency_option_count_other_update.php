<?
include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";


$m_idx_1	= updateSQ($_POST["m_idx_1"]); //기존 브래든 id
$m_idx_2	= updateSQ($_POST["m_idx_2"]); //이동할 브랜드 id
$g_cnt = updateSQ($_POST["g_cnt"]);
$out_cnt = updateSQ($_POST["out_cnt"]);
$goods_code = updateSQ($_POST["goods_code"]);
$tmp_size = updateSQ($_POST["tmp_size"]);
$tmp_color = updateSQ($_POST["tmp_color"]);


	$chkNum = 0;
	if($m_idx_2 != ""){
		$sql = "select * from tbl_goods_agency_option where m_idx=".$m_idx_2." AND  goods_code='".$goods_code."' AND goods_color = '".$tmp_color."' AND goods_size = '".$tmp_size."' ";
		$result = mysqli_query($connect, $sql) or die (mysql_error($connect));
		
		while($row = mysqli_fetch_array($result)){
			$goods_cnt_old = $row['goods_cnt'];
			$chkNum = 1;
		}
	}

	if($chkNum == 0){
		$sql_in = "insert into tbl_goods_agency_option(m_idx, goods_code, goods_color, goods_size, goods_cnt, use_yn) values(".$m_idx_2.",'".$goods_code."','".$tmp_color."','".$tmp_size."',".$out_cnt.",'')";
		mysqli_query($connect, $sql_in) or die (mysqli_error($connect));		
	}

	if($chkNum == 1){
		if($m_idx_1 != ""){
			$sql_su = "update tbl_goods_agency_option set goods_cnt=".$goods_cnt." where idx=".$m_idx_1."";
			mysqli_query($connect, $sql_su) or die (mysqli_error($connect));
			
			$upCnt = (int)$goods_cnt_old + (int)$out_cnt;

			$sql_2 = "update tbl_goods_agency_option set goods_cnt=".$upCnt." where m_idx=".$m_idx_2." AND  goods_code='".$goods_code."' AND goods_color = '".$tmp_color."' AND goods_size = '".$tmp_size."' ";
		
			mysqli_query($connect, $sql_2) or die (mysqli_error($connect));				
		}
	}
echo "ok";
?>