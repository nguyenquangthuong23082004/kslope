<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 


	$code_idx				= updateSQ($_POST["code_idx"]);
	$code_gubun				= updateSQ($_POST["code_gubun"]);
	$code_no				= updateSQ($_POST["code_no"]);
	$code_name				= updateSQ($_POST["code_name"]);
	$code_name_en			= updateSQ($_POST["code_name_en"]);
	$parent_code_no			= updateSQ($_POST["parent_code_no"]);
	$depth					= updateSQ($_POST["depth"]);
	$status					= updateSQ($_POST["status"]);
	$onum					= updateSQ($_POST["onum"]);
	$product_code			= updateSQ($_POST["product_code"]);
	$comment			= updateSQ($_POST["comment"]);
	

	$upload="../../data/icon/";

if ($code_idx)
{
	



	if($dels == "y"){

		$total_sql = " select * from tbl_icon where code_idx = '".$code_idx."' ";
		$result = mysqli_query($connect, $total_sql) or die (mysqli_error($connect));
		$row=mysqli_fetch_array($connect, $result);	

		unlink($upload . $row['iconimg']);

		$sql = "
			update tbl_icon SET 
			iconimg		= ''
			where code_idx = '".$code_idx."'
		";
		mysqli_query($connect, $sql) or die (mysqli_error($connect));
	}

	for ($i=1;$i<=1;$i++)
	{
		if($_FILES["ufile".$i]['name'])
		{
			$wow=$_FILES["ufile".$i]['name'];
			if (no_file_ext($_FILES["ufile".$i]['name']) != "Y") {
				echo "NF";
				exit();
			}

			${"rfile_".$i}=$wow;
			$wow2=$_FILES["ufile".$i]['tmp_name'];//tmp 폴더의 파일
			${"ufile_".$i}=file_check($wow,$wow2,$upload,"N");
			$sql = "
				update tbl_brand SET 
				brandImg		= '".${"ufile_".$i}."'
				where code_idx = '".$code_idx."'
			";
			mysqli_query($connect, $sql) or die (mysqli_error($connect));
		}
	}





		$sql = "
			update tbl_brand SET 
				 code_name			= '".$code_name."'	
				,code_name_en		= '".$code_name_en."'	
				,product_code		= '".$product_code."'	
				,status				= '".$status."'
				,onum				= '".$onum."'
				,comment				= '".$comment."'
			where	code_idx = '".$code_idx."'
		";
		
		mysqli_query($connect, $sql) or die (mysql_error());
	//}
} else {
	

	$img_sql = "";

	for ($i=1;$i<=1;$i++)
	{
		if($_FILES["ufile".$i]['name'])
		{
			$wow=$_FILES["ufile".$i]['name'];
			if (no_file_ext($_FILES["ufile".$i]['name']) != "Y") {
				echo "NF";
				exit();
			}

			${"rfile_".$i}=$wow;
			$wow2=$_FILES["ufile".$i]['tmp_name'];//tmp 폴더의 파일
			${"ufile_".$i}=file_check($wow,$wow2,$upload,"N");

			$img_sql .= " ,brandImg		= '".${"ufile_".$i}."'";
			
		}
	}



	$sql = "
		insert into tbl_brand SET 
			 code_no			= '".$code_no."'	
			,code_name			= '".$code_name."'	
			,code_name_en		= '".$code_name_en."'	
			,product_code		= '".$product_code."'	
			,onum				= '".$onum."'	
			,status				= '".$status."'
			,comment			= '".$comment."'
			". $img_sql;
	
	mysqli_query($connect, $sql) or die (mysql_error());
}
?>
<script>
	<? if ($b_idx)	{ ?>
	parent.location.reload();
	<? } else { ?>
	parent.location.href="brand_list.php";
	<? }?>
</script>