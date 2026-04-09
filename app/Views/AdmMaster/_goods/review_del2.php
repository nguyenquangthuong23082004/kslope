<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 

	$dir = $_SERVER['DOCUMENT_ROOT']."/data/review3/";

	mysqli_query($connect, "SET AUTOCOMMIT=0");
	mysqli_query($connect, "START TRANSACTION");

	if(!isset($_POST['idx'])) exit;

	for ($i=0;$i < count($idx) ; $i++) {
		$sql1	= " delete from tbl_review3 where idx = '".$idx[$i]."' ";
		$db1	= mysqli_query($connect, $sql1);
		if (!$db1) {
			mysqli_query($connect, "ROLLBACK");
			echo "NO";
			exit();
		}else{
			//파일 삭제
			$sql_s = "select ufile from tbl_review3_file where r_idx = '".$idx[$i]."' ";
			$result_s = mysqli_query($connect, $sql_s);
			while($row_s = mysqli_fetch_array($result_s)){
				unlink($dir.$row_s['ufile']);
			}
			//데이터 삭제
			$sql2 = "delete from tbl_review3_file where r_idx = '".$idx[$i]."' ";
			$result = mysqli_query($connect, $sql2);
			if($result){
				mysqli_query($connect, "COMMIT");
			}else{
				mysqli_query($connect, "ROLLBACK");
			}
		}
	}


	if ($db1) {
		echo "OK";
		mysqli_query($connect, "COMMIT");
	} else {        
		//rollback
		mysqli_query($connect, "ROLLBACK");
		echo "NO";
	}
	mysqli_close($connect);
?>