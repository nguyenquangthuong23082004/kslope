<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 
	

	$tot=count($m_idx);
	for ($j=0;$j<$tot;$j++){




		$sql = " insert into tbl_point_del (select * from tbl_point where idx = '".$m_idx[$j]."') ";
		mysqli_query($connect, $sql) or die (mysqli_error($connect));



		$sql = " delete from tbl_point where idx='".$m_idx[$j]."'";
		write_log("포인트삭제 : ".$sql);
		mysqli_query($connect, $sql);
	}

	if ($mode == "view")
	{
	?>
<script>
	alert("삭제처리되었습니다.");
	parent.location.href="list.php?pg=<?=$pg?>";
</script>	
	<?
	} else {
	echo "OK";
	} ?>