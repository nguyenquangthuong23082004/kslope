<?
	include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php";

	$idx			= updateSQ($_POST['idx']);
	$subject		= updateSQ($_POST['subject']);
	$category		= updateSQ($_POST['category']);
	$status			= updateSQ($_POST['status']);
	$show_cate_arr	= $_POST['show_cate'];
	$link			= updateSQ($_POST['link']);
	$onum			= updateSQ($_POST['onum']);
	$contents			= updateSQ($_POST['contents']);
	$color			= updateSQ($_POST['color']);
	//$ufile		= updateSQ($_POST['ufile']);
	//$rfile		= updateSQ($_POST['rfile']);

	$upload="../../data/goods_banner/";

$show_cate = '';
foreach($show_cate_arr as $key => $vals)
{
	$show_cate .= "|".$vals."|";
}
//echo $show_cate;
//print_r($_POST);
//exit();
for ($i=1;$i<=2;$i++)
{
	if (${"del_".$i} =="Y"){
		$sql = "
			UPDATE tbl_goods_list_bnnr SET
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

		if ($idx) {
				$sql = "
					UPDATE tbl_goods_list_bnnr SET
					ufile".$i."='".${"ufile_".$i}."',
					rfile".$i."='".${"rfile_".$i}."'
					WHERE idx='$idx';
				";
				mysqli_query($connect, $sql) or die (mysqli_error($connect));
		}

	}
}

	if($idx){
		$sql = "
			update tbl_goods_list_bnnr set
				subject		= '".$subject."',
				category	= '".$category."',
				status		= '".$status."',
				show_cate	= '".$show_cate."',
				link		= '".$link."',
				contents    = '".$contents."',
				color		= '".$color."',
				onum		= '".$onum."'
			where idx = '".$idx."'
		";
		$db = mysqli_query($connect, $sql);
	}else{
		$sql = "
			insert into tbl_goods_list_bnnr(subject, category, status, show_cate, link, ufile1, rfile1, ufile2, rfile2, onum, contents, color, regdate)
			values('".$subject."', '".$category."', '".$status."', '".$show_cate."', '".$link."', '".$ufile_1."', '".$rfile_1."', '".$ufile_2."', '".$rfile_2."', '".$onum."', '".$contents."', '".$color."', now())
		";
		//echo $sql;
		$db = mysqli_query($connect, $sql);
	}
?>
	<script>
<?
	if($db){
		if($idx){
?>
		alert("수정되었습니다.");
		parent.location.reload();
<?
		}else{
?>
		alert("등록되었습니다.");
		parent.location.href="item_banner_list.php";
<?
		}
	}else{
		alert("오류가 발생하였습니다.");
		parent.location.reload();
	}
?>
	</script>