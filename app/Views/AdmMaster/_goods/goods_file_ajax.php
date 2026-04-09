<?
	include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php";

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

	}

		if($ufile != '' && $rfile != ''){
			$result = Array("result"=>"OK","ufile"=>$ufile,"rfile"=>$rfile);
		}else{
			$result = Array("result"=>'NO');
		}
		echo json_encode($result);
?>