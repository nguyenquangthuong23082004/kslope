<?
	include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php";

	$idx		= updateSQ($_POST['idx']);
	$subject	= updateSQ($_POST['subject']);
	$category	= updateSQ($_POST['category']);
	$status		= updateSQ($_POST['status']);
	$content	= updateSQ($_POST['content']);
	$onum		= updateSQ($_POST['onum']);
	$ufile		= updateSQ($_POST['ufile']);
	$rfile		= updateSQ($_POST['rfile']);
	$is_best		= updateSQ($_POST['is_best']);

	/*
	if($_FILES["file"]['name']){

		$wow=$_FILES["file"]['name'];
		if (no_file_ext($_FILES["file"]['name']) != "Y") {
			echo "NF";
			exit();
		}

		$rfile=$wow;
		$wow2=$_FILES["file"]['tmp_name'];//tmp 폴더의 파일
		$ufile=file_check($wow,$wow2,$upload,"N");

		if ($idx) {
				$sql = "
					UPDATE tbl_freebies SET
					ufile='".$ufile."',
					rfile='".$rfile."'
					WHERE idx='$idx';
				";
				mysqli_query($connect, $sql) or die (mysqli_error($connect));
		}
	}
	*/

	if($idx){
		$sql = "
			update tbl_freebies set
				subject		= '".$subject."',
				category	= '".$category."',
				status		= '".$status."',
				content		= '".$content."',
				ufile		= '".$ufile."',
				rfile		= '".$rfile."',
				is_best		= '".$is_best."',
				onum		= '".$onum."'
			where idx = '".$idx."'
		";
		$db = mysqli_query($connect, $sql);
	}else{
		$sql = "
			insert into tbl_freebies(subject, category, status, content, ufile, rfile, onum, is_best, regdate)
			values('".$subject."', '".$category."', '".$status."', '".$content."', '".$ufile."', '".$rfile."', '".$onum."', '".$is_best."', now())
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
		parent.location.href="freebies_list.php";
<?
		}
	}else{
		alert("오류가 발생하였습니다.");
		parent.location.reload();
	}
?>
	</script>