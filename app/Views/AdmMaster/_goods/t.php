<?
/*
	include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php";

	$sql = "
		select * from tbl_review3
			order by idx asc
	";
	$result = mysqli_query($connect, $sql);

	while($row = mysqli_fetch_array($result)){
		$sql1 = "
			insert into tbl_review2 set
				 g_idx		= '".$row['g_idx']."'
				,r_type		= 'L'
				,status		= '".$row['status']."'
				,type		= '".$row['type']."'
				,period		= '".$row['period']."'
				,user_name	= '".$row['user_name']."'
				,tel1		= '".$row['tel1']."'
				,tel2		= '".$row['tel2']."'
				,zipcode	= '".$row['zipcode']."'
				,addr1		= '".$row['addr1']."'
				,addr2		= '".$row['addr2']."'
				,gift		= '".$row['gift']."'
				,bank		= '".$row['bank']."'
				,bank_num	= '".$row['bank_num']."'
				,bank_own	= '".$row['bank_own']."'
				,bank_money	= '".$row['bank_money']."'
				,comment	= '".$row['comment']."'
				,subject	= '".$row['subject']."'
				,content	= '".$row['content']."'
				,onum		= '".$row['onum']."'
				,regdate	= '".$row['regdate']."'
				,deli_status= '".$row['deli_status']."'
		";
		mysqli_query($connect, $sql1);
	}

	$sql = "select * from tbl_review3_file order by idx asc ";
	$result = mysqli_query($connect, $sql);

	while($row = mysqli_fetch_array($result)){
		$sql2 = "select * from tbl_review2 where regdate = '".$row['regdate']."' ";
		$result2 = mysqli_query($connect, $sql2);
		$row2 = mysqli_fetch_array($result2);

		$sql3 = "
			insert into tbl_review2_file set
				 r_idx		= '".$row2['idx']."'
				,ufile		= '".$row['ufile']."'
				,rfile		= '".$row['rfile']."'
				,regdate	= '".$row['regdate']."'
		";
		mysqli_query($connect, $sql3);
	}
	*/
?>