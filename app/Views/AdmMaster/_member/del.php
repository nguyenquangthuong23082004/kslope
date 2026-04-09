<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 



	if(!isset($_POST['m_idx'])) exit;

	for ($i=0;$i < count($m_idx) ; $i++) {
		
		
		/*
		$sql1	= " update tbl_member set status = '0' where g_idx = '".$idx[$i]."' ";
		$db1	= mysqli_query($connect, $sql1);
		if (!$db1) {
			mysqli_query($connect, "ROLLBACK");
			echo "NO";
			exit();
		}
		*/


		$total_sql = " select * from tbl_member where m_idx = '".$m_idx[$i]."' ";
		$result = mysqli_query($connect, $total_sql) or die (mysql_error());
		$row = mysqli_fetch_array($result);

		$user_id = $row["user_id"];

		$comment = "관리자에 의한 삭제";
	
		$sql_su = "
				insert into tbl_member_out SET 
					 user_id	= '".$user_id."'
					,type		= '".$type."'
					,comment	= '".$comment."'
					,insertDate		=now()
				
			";
	
		$db = mysqli_query($connect, $sql_su) or die (mysqli_error($connect));		
	
		$sql_su = " update tbl_member set status = '0', d_date = now() where user_id = '".$user_id."'";
		$db1 = mysqli_query($connect, $sql_su) or die (mysqli_error($connect));	
	


	}

	if ($db1) {
		echo "OK";
	} else {
		echo "NO";
	}
	
	mysqli_close($connect);
?>