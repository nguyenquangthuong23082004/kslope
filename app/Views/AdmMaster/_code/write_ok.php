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
	$color					= updateSQ($_POST["color"]);
	$types					= updateSQ($_POST["types"]);

	$bestYN					= updateSQ($_POST['bestYN']);

	$upload="../../data/category/";

for($i=1;$i<=2; $i++)
{
	if (${'del_'.$i} =="Y"){
		$sql = "
			UPDATE tbl_code SET
				ufile".$i." ='',
				rfile".$i." =''
			WHERE code_idx='$code_idx'
		";
		mysqli_query($connect, $sql) or die (mysqli_error($connect));

	} elseif($_FILES["ufile".$i]['name']){

		$wow=$_FILES["ufile".$i]['name'];
		if (no_file_ext($_FILES["ufile"]['name']) != "Y") {
			echo "NF";
			exit();
		}

		${'rfile_'.$i}=$wow;
		$wow2=$_FILES["ufile".$i]['tmp_name'];//tmp ������ ����
		${'ufile_'.$i}=file_check($wow,$wow2,$upload,"N");

		if ($code_idx) {
				$sql = "
					UPDATE tbl_code SET
						ufile".$i."='".${'ufile_'.$i}."',
						rfile".$i."='".${'rfile_'.$i}."'
					WHERE code_idx='$code_idx';
				";
				mysqli_query($connect, $sql) or die (mysqli_error($connect));
		}

	}
}
if ($code_idx)
{
	
		$sql = "
			update tbl_code SET 
				code_name			= '".$code_name."'	
				,code_name_en		= '".$code_name_en."'	
				,status				= '".$status."'
				,bestYN				= '".$bestYN."'
				,onum				= '".$onum."'
				,color				= '".$color."'
				,types				= '".$types."'
			where	code_idx = '".$code_idx."'
		";
		
		mysqli_query($connect, $sql) or die (mysql_error());
	//}
} else {
	
	$sql = "
		insert into tbl_code SET 
			code_gubun			= '".$code_gubun."'
			,code_no			= '".$code_no."'	
			,code_name			= '".$code_name."'	
			,code_name_en		= '".$code_name_en."'	
			,parent_code_no		= '".$parent_code_no."'	
			,depth				= '".$depth."'
			,status				= '".$status."'
			,bestYN				= '".$bestYN."'
			,ufile1				= '".$ufile_1."'
			,rfile1				= '".$rfile_1."'
			,ufile2				= '".$ufile_2."'
			,rfile2				= '".$rfile_2."'
			,onum				= '".$onum."'
			,color				= '".$color."'
			,types				= '".$types."'
	";
	
	mysqli_query($connect, $sql) or die (mysql_error());
}
?>
<script>
	<? if ($b_idx)	{ ?>
	parent.location.reload();
	<? } else { ?>
	parent.location.href="list.php?s_parent_code_no=<?=$parent_code_no?>";
	<? }?>
</script>