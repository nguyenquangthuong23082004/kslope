<?
include "../_include/_header.php"; 

$idx = updateSQ($_GET["idx"]);
?>

	<div id="container" class="gnb_member">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">

				<div class="inner">
					<h2>자동SMS설정</h2>
					<div class="menus">
						<ul class="last">
							<li><a href="javascript:history.back();" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a></li>

							<li><a href="javascript:send_it();" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a></li>
						</ul>
				</div>
			</div>
			<!-- // inner -->

	</header>
	<!-- // headerContainer -->

<?

	$total_sql = " select *
	                 from tbl_auto_sms_skin
					where idx = '".$idx."'  ";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$row = mysqli_fetch_array($result);


?>


	<div id="contents">

		<div class="listWrap email_container email_container01">

			<form name="frm" id="frm" action="sms01_mod_ok.php" method="post" enctype="multipart/form-data" target="hiddenFrame22" >
				<input type="hidden" name="idx" id="idx" value="<?=$idx?>" />
				<div class="listBottom">
					<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail">
						<caption></caption>
						<colgroup>
							<col width="150px">
							<col width="*">
						</colgroup>

						<tbody>
							<tr style="height:45px;">
								<th>메일항목</th>
								<td><?=$row['title']?></td>
							</tr>

							<tr style="height:45px;">
								<th>구분</th>
								<td>
									<input type="radio" name="autosend" id="autosend" value="Y" <?if($row['autosend'] == "Y")echo "checked";?> >자동발송	
									<input type="radio" name="autosend" id="autosend" value="N" <?if($row['autosend'] == "N")echo "checked";?> >자동발송안함
								</td>
							</tr>
							<tr style="height:45px;">
								<th>문자내역</th>
								<td><input type="text" name="content" id="content" value="<?=$row['content']?>" style="width:90%;" ></td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- // listBottom -->
			</form>

			<div id="headerContainer">

				<div class="inner">
					<div class="menus">
						<ul class="last">
							<li><a href="javascript:history.back();" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a></li>
							<li><a href="javascript:send_it();" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a></li>
						</ul>

					</div>

				</div>
				<!-- // inner -->

			</div>
			<!-- // headerContainer -->
		</div>
		<!-- // listWrap -->

	</div>
	<!-- // contents -->





	</span>
	<!-- 인쇄 영역 끝 //-->
	</div>

	<? include "../_include/_footer.php"; ?>

<iframe width="300" height="300" name="hiddenFrame22" id="hiddenFrame22" style="display:block;"></iframe>

<script type="text/javascript">
function send_it()
{
	var frm = document.frm;
	
	if (frm.content.value == "")
	{
		alert_("내용을 입력해주세요.");
		frm.content.focus();
		return;
	}

	frm.submit();
}
</script>