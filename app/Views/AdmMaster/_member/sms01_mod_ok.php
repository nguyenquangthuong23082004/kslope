<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";



	$idx				= updateSQ($_POST["idx"]);
	$autosend			= updateSQ($_POST["autosend"]);
	$content			= updateSQ($_POST["content"]);
	
	

	$sql = "
		update tbl_auto_sms_skin SET
			 autosend		= '".$autosend."'
			,content		= '".$content."'
		where idx = '".$idx."'
	";

	mysqli_query($connect, $sql) or die (mysqli_error($connect));



?>
<script>
	<?if ($idx){?>
	alert("수정되었습니다.");
	parent.location.reload();
	<? } else { ?>
	alert("등록되었습니다.");
	parent.location.reload();
	<?}?>
</script>
