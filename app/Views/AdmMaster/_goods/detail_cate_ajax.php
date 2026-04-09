<?
	include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php";

	$code_no = $_POST['code_no'];
    $g_idx   = $_POST['g_idx'];
    
	$sql = "select * from tbl_code_cate where status = 'Y' and parent_code_no = '".$code_no."' order by onum desc, code_idx desc";
    $result = mysqli_query($connect, $sql);
    
    $g_sql = "select * from tbl_goods where g_idx = '".$g_idx."' ";
    $g_result = mysqli_query($connect, $g_sql);
    $g_row = mysqli_fetch_array($g_result);

    $srch_arr = explode('||', substr($g_row['detail_srch'],1,-1));	
	$content = "";
	$content .= "<table>";
	$content .= "	<colgroup>";
	$content .= "	<col width='10%' />";
	$content .= "	<col width='90%' />";
	$content .= "	</colgroup>";
	$content .= "	<tbody>";
	while($row = mysqli_fetch_array($result) ){
		$content .= "<tr>";
		$content .= "<th>".$row['code_name']."</th>";
		$content .= "<td>";
		$child_sql = "
			select * from tbl_code_cate 
				where parent_code_no = '".$row['code_no']."' 
					and status = 'Y' 
				order by onum desc, code_idx desc 
		";
		
		$child_result = mysqli_query($connect, $child_sql);
		while( $child_row = mysqli_fetch_array($child_result) ){
            $sr_chk = '';
            if(in_array($child_row['code_no'],$srch_arr) == true){
                $sr_chk = "checked";
            }
			$content .= "<input type='checkbox' name='detail_chk[]' value='".$child_row['code_no']."' id='detail_".$child_row['code_no']."' ".$sr_chk."> ";
			$content .= "<label for='detail_".$child_row['code_no']."'>".$child_row['code_name']."</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
				$content .= "</td>";
			$content .= "</tr>";
	}
	$content .= "	</tbody>";
	$content .= "</table>";
	//echo $content;
	$chk = array(
		"chk"=>"OK",
		"content"=>$content
	);
	echo json_encode($chk);
?>