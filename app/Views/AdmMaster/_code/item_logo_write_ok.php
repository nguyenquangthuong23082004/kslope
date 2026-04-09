<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 

	$code_no				= updateSQ($_POST["code_no"]);
	$code_idx				= updateSQ($_POST["code_idx"]);
	$code_name				= updateSQ($_POST["code_name"]);
	$content				= updateSQ($_POST["content"]);
	$price					= updateSQ($_POST["price"]);
	$max_price				= updateSQ($_POST["max_price"]);
	$status					= updateSQ($_POST["status"]);
	$appli_method			= updateSQ($_POST['appli_method']);
	$onum					= updateSQ($_POST["onum"]);
	$del_1					= updateSQ($_POST["del_1"]);
	$upload="../../data/item_logo/";




	




if ($code_idx)
{

	if($del_1 == "Y"){

		$total_sql = " select * from tbl_item_logo where code_idx = '".$code_idx."' ";
		$result = mysqli_query($connect, $total_sql) or die (mysqli_error($connect));
		$row=mysqli_fetch_array($connect, $result);	

		unlink($upload . $row['ufile']);

		$sql = "
			update tbl_item_logo SET 
			ufile		= '',
			rfile		= ''
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
				update tbl_item_logo SET 
				ufile		= '".${"ufile_".$i}."',
				rfile		= '".${"rfile_".$i}."'
				where code_idx = '".$code_idx."'
			";
			mysqli_query($connect, $sql) or die (mysqli_error($connect));
		}
	}



	$sql = "
		update tbl_item_logo SET 
			code_name			= '".$code_name."'	
			,status				= '".$status."'
			,onum				= '".$onum."'
		where	code_idx = '".$code_idx."'
	";
	
	mysqli_query($connect, $sql) or die (mysql_error());
	


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

			$img_sql .= " ,ufile		= '".${"ufile_".$i}."'";
			$img_sql .= " ,rfile		= '".${"rfile_".$i}."'";
			
		}
	}

	
	$sql = "
		insert into tbl_item_logo SET 
			 code_no			= '".$code_no."'	
			,code_name			= '".$code_name."'	
			,onum				= '".$onum."'	
			,status				= '".$status."'
	". $img_sql;
	
	mysqli_query($connect, $sql) or die (mysql_error());
}
?>
<script>
	<? if ($b_idx)	{ ?>
	parent.location.reload();
	<? } else { ?>
	parent.location.href="item_logo_list.php";
	<? }?>
</script>