<?
	include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php";

	//print_R($_POST);
	//print_R($_FILES);

	$idx = $_POST['idx'];
	$upd_chk = $_POST['upd_chk'];

	$upload="../../data/product/";


	if($_FILES["file"]['name']){

		$wow=$_FILES["file"]['name'];
		if (no_file_ext($_FILES["file"]['name']) != "Y") {
			echo "NF";
			exit();
		}

		$rfile=$wow;
		$wow2=$_FILES["file"]['tmp_name'];//tmp 폴더의 파일
		$ufile=file_check($wow,$wow2,$upload,"N");

		
		$result = Array("ufile"=>$ufile,"rfile"=>$rfile);
		
		echo json_encode($result);
	}

?>