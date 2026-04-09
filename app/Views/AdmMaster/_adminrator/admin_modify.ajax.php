<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 

	mysqli_query($connect, "SET AUTOCOMMIT=0");
	mysqli_query($connect, "START TRANSACTION");


	$user_name		= updateSQ(trim($_POST[user_name]));
	$user_pw		= updateSQ(trim($_POST[user_pw]));
	$user_email		= updateSQ(trim($_POST[user_email]));

	if ($user_pw != "")
	{
		$total_sql = " select * from tbl_member where m_idx='".$_SESSION[member][idx]."' ";
//		echo $total_sql;
		$result = mysqli_query($connect, $total_sql) or die (mysqli_error($connect));
		$row=mysqli_fetch_array($result);	
		if ($row["user_pw"] != sql_password($user_pw_org)) {
			//패스워드가 일치하지 않습니다.
			echo "NP";
			exit();
		}
		$sql = "update tbl_member set ";
		$sql = $sql." user_pw		= '".sql_password($user_pw)."'";
		$sql = $sql."where  m_idx='".$_SESSION[member][idx]."' ";
		$db1 = mysqli_query($connect, $sql);
	}

		$sql = "update tbl_member set user_name	= '$user_name'";
		$sql = $sql."where  m_idx='".$_SESSION[member][idx]."' ";

	$db1 = mysqli_query($connect, $sql);

	if ($db1) {
		echo "OK";
		mysqli_query($connect,"COMMIT");
	} else {        
		//rollback
		mysqli_query($connect,"ROLLBACK");
		echo "NO";
	}
	mysqli_close($connect);
?>
