<?
include "../_include/_header.php"; 

$idx = updateSQ($_GET["idx"]);
?>
<!-- 에디터 사용에 필요한 js 인크루드 -->
<script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js"></script>

	<div id="container" class="gnb_member">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">

				<div class="inner">
					<h2>자동메일설정</h2>
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
	                 from tbl_auto_mail_skin
					where idx = '".$idx."'  ";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$row = mysqli_fetch_array($result);


?>


	<div id="contents">

		<div class="listWrap email_container email_container01">

			<form name="frm" id="frm" action="email01_mod_ok.php" method="post" enctype="multipart/form-data" target="hiddenFrame22" >
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
								<td><?=$row['title']?> &nbsp&nbsp&nbsp&nbsp(기본설정 변경시 수정 하셔야 됩니다.)</td>
							</tr>

							<tr style="height:45px;">
								<th>구분</th>
								<td>
									<input type="radio" name="autosend" id="autosend" value="Y" <?if($row['autosend'] == "Y")echo "checked";?> >자동발송	
									<input type="radio" name="autosend" id="autosend" value="N" <?if($row['autosend'] == "N")echo "checked";?> >자동발송안함
								</td>
							</tr>
							<tr style="height:45px;">
								<th>발송자이름</th>
								<td><input type="text" name="send_name" id="send_name" value="<?=_IT_SITE_NAME?>" ></td>
							</tr>
							<tr style="height:45px;">
								<th>발송자E-mail</th>
								<td><input type="text" name="send_email" id="send_email" value="<?=_IT_ADMIN_EMAIL?>" ></td>
							</tr>
							<tr style="height:45px;">
								<th>메일제목</th>
								<td><input type="text" name="mail_title" id="mail_title" value="<?=$row['mail_title']?>" ></td>
							</tr>
							<tr>
								<th colspan="2">
									<textarea name="content" id="content_" rows="10" cols="100" class="input_txt" style="width:100%; height:400px; display:none;"><?=$row['content'];?></textarea>

									<script type="text/javascript">
									var oEditors1 = [];

									// 추가 글꼴 목록
									//var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];

									nhn.husky.EZCreator.createInIFrame({
										oAppRef: oEditors1,
										elPlaceHolder: "content_",
										sSkinURI: "/smarteditor/SmartEditor2Skin.html",	
										htParams : {
											bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
											bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
											bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
											//aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
											fOnBeforeUnload : function(){
												//alert("완료!");
											}
										}, //boolean
										fOnAppLoad : function(){
											//예제 코드
											//oEditors.getById["ir1"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
										
										},
										fCreator: "createSEditor2"
									});
									

									
									</script>
								</th>
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
	
	if (frm.send_name.value == "")
	{
		alert_("발송자 이름을 등록해주세요.");
		frm.send_name.focus();
		return;
	}

	if (frm.send_email.value == "")
	{
		alert_("발송자E-mail을 입력해주세요.");
		frm.send_email.focus();
		return;
	}
	

	if (frm.mail_title.value == "")
	{
		alert_("메일제목을 입력해주세요.");
		frm.mail_title.focus();
		return;
	}


	oEditors1.getById["content_"].exec("UPDATE_CONTENTS_FIELD", []);


	

	if (frm.content.value.length < 14)
	{
		frm.content.focus();
		alert_("내용을 입력하셔야 합니다.");
		return;
	}


	
	frm.submit();
}
</script>