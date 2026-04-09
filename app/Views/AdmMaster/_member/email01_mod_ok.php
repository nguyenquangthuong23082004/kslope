<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";



	$idx				= updateSQ($_POST["idx"]);
	$autosend			= updateSQ($_POST["autosend"]);
	$send_name			= updateSQ($_POST["send_name"]);
	$send_email			= updateSQ($_POST["send_email"]);
	$mail_title			= updateSQ($_POST["mail_title"]);
	$content			= updateSQ($_POST["content"]);
	
	

	$sql = "
		update tbl_auto_mail_skin SET
			 autosend		= '".$autosend."'
			,send_name		= '".$send_name."'
			,send_email		= '".$send_email."'
			,mail_title		= '".$mail_title."'
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
