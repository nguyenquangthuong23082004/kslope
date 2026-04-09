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

	$code_category			= updateSQ($_POST['code_category']);
	$upload = $_SERVER['DOCUMENT_ROOT'] ."/data/icon/";

if ($code_idx)
{
	
		$sql = "
			update tbl_code_cate SET 
				code_name			= '".$code_name."'	
				,code_name_en		= '".$code_name_en."'	
				,code_cate			= '".$code_category."'
				,status				= '".$status."'
				,onum				= '".$onum."'
			where	code_idx = '".$code_idx."'
		";
		
		mysqli_query($connect, $sql) or die (mysql_error());
	//}
} else {
	
	$sql = "
		insert into tbl_code_cate SET 
			code_gubun			= '".$code_gubun."'
			,code_no			= '".$code_no."'	
			,code_cate			= '".$code_category."'
			,code_name			= '".$code_name."'	
			,code_name_en		= '".$code_name_en."'	
			,parent_code_no		= '".$parent_code_no."'	
			,depth				= '".$depth."'
			,status				= '".$status."'
			,onum				= '".$onum."'
	";
	
	mysqli_query($connect, $sql) or die (mysql_error());
}

	for($i=1;$i<=1;$i++)
	{
		if (${"del_".$i} == "Y")
		{ 
			$sql = "
				UPDATE tbl_code_cate SET
						ufile".$i."='',
						rfile".$i."=''
				WHERE code_idx = '$code_idx'
			";
			mysqli_query($connect, $sql) or die (mysqli_error($connect));
		}

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
				update tbl_code_cate SET 
					 ufile".$i."='".${"ufile_".$i}."' 
					,rfile".$i."='".${"rfile_".$i}."'
				where code_idx = '$code_idx'
			";

			mysqli_query($connect, $sql) or die (mysqli_error($connect));
		}
	}
?>
<script>
	<? if ($b_idx)	{ ?>
	parent.location.reload();
	<? } else { ?>
	parent.location.href="category_list.php?s_parent_code_no=<?=$parent_code_no?>";
	<? }?>
</script>