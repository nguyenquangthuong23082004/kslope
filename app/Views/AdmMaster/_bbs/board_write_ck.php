<? include "../_include/_header.php"; ?>


<style>

/**
 * @license Copyright (c) 2014-2020, CKSource - Frederico Knabben. All rights reserved.
 * This file is licensed under the terms of the MIT License (see LICENSE.md).
 */

 :root {
	--ck-sample-base-spacing: 2em;
	--ck-sample-color-white: #fff;
	--ck-sample-color-green: #279863;
	--ck-sample-color-blue: #1a9aef;
	--ck-sample-container-width: 1285px;
	--ck-sample-sidebar-width: 350px;
	--ck-sample-editor-min-height: 400px;
}

/* --------- EDITOR STYLES  ---------------------------------------------------------------------------------------- */

.editor__editable,
/* Classic build. */
main .ck-editor[role='application'] .ck.ck-content,
/* Decoupled document build. */
.ck.editor__editable[role='textbox'],
.ck.ck-editor__editable[role='textbox'],
/* Inline & Balloon build. */
.ck.editor[role='textbox'] {
	width: 100%;
	background: #fff;
	font-size: 1em;
	line-height: 1.6em;
	min-height: var(--ck-sample-editor-min-height);
	padding: 1.5em 2em;
}

</style>

<?
	include $_SERVER[DOCUMENT_ROOT]."/AdmMaster/include/bbs_info.inc.php";
	$writer			= $_SESSION[member][name];
	$email			= $_SESSION[member][email];
	$search_mode	= updateSQ($_GET[search_mode]);
	$search_word	= updateSQ($_GET[search_word]);
	$pg				= updateSQ($_GET[pg]);
	$bbs_idx		= updateSQ($_GET[bbs_idx]);
	$scategory		= updateSQ($_GET[scategory]);
	$wDate			= date("Y-m-d H:i:s", time());
	$hit			= 0;
	//echo $_SERVER[DOCUMENT_ROOT].'/data/editor/';

	$mode			= updateSQ($_GET[mode]);

	$titleStr = "등록";
	$cnt = 0;
	if ($mode == "reply"){
		$total_sql	= " select * from tbl_bbs_list where bbs_idx='".$bbs_idx."'";
		$result		= mysqli_query($connect, $total_sql) or die (mysqli_error($connect));
		$row		= mysqli_fetch_array($result);
		$subject	= "[re]".$row[subject];
		$contents	= "-------------------- 원본글 -------------------- <br>".$row[contents];
		$b_step		= $row[b_step];
		$b_level	= $row[b_level];
		$b_ref		= $row[b_ref];
		$secure_yn	= $row[secure_yn];
		$mode		= "reply";
	} elseif ($bbs_idx) {
		$total_sql	= " select * from tbl_bbs_list where bbs_idx='".$bbs_idx."'";
		$result		= mysqli_query($connect, $total_sql) or die (mysqli_error($connect));
		$row		= mysqli_fetch_array($result);
		$writer		= $row[writer];
		$email		= $row[email];
		$hit		= $row[hit];
		$subject	= $row[subject];
		$simple		= $row[simple];
		$s_date		= $row[s_date];
		$e_date		= $row[e_date];
		$notice_yn	= $row[notice_yn];
		$secure_yn	= $row[secure_yn];
		$recomm_yn	= $row[recomm_yn];
		$contents	= $row[contents];
		$category	= $row[category];
		$url		= $row[url];
		$cnt		= 0;
		$ufile1		= $row[ufile1];
		$rfile1		= $row[rfile1];

		$ufile2		= $row[ufile2];
		$rfile2		= $row[rfile2];

		$ufile3		= $row[ufile3];
		$rfile3		= $row[rfile3];

		$ufile4		= $row[ufile4];
		$rfile4		= $row[rfile4];

		$ufile5		= $row[ufile5];
		$rfile5		= $row[rfile5];

		$ufile6		= $row[ufile6];
		$rfile6		= $row[rfile6];
		$wDate		= $row[r_date];

		$s_date		= $row[s_date];
		$e_date		= $row[e_date];


		if ($ufile1 != "")
		{
		$cnt		= $cnt + 1;
		}
		if ($ufile2 != "")
		{
		$cnt		= $cnt + 1;
		}
		if ($ufile3 != "")
		{
		$cnt		= $cnt + 1;
		}
		if ($ufile4 != "")
		{
		$cnt		= $cnt + 1;
		}
		if ($ufile5 != "")
		{
		$cnt		= $cnt + 1;
		}
		if ($cnt < 1) {
		$cnt		= 1;
		}
	} else {
		$cnt		= 1;
	}

	if ($writer	== "")
	{
		$writer = "관리자";
	}
?>

		<div id="container">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">

				<div class="inner">
					<h2><?=getBoardName($code)?></h2>
					<div class="menus">
						<ul class="last">
							<li><a href="board_list.php?scategory=<?=$scategory?>&search_mode=<?=$search_mode?>&search_word=<?=$search_word?>&code=<?=$code?>&bbs_idx=<?=$bbs_idx?>&pg=<?=$pg?>" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a></li>
							<? if ($bbs_idx) { ?>
							<li><a href="javascript:send_it();" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a></li>
							<li><a href="javascript:del_chk('<?=$bbs_idx?>');" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span><span class="txt">삭제</span></a></li>
							<? } else { ?>
							<li><a href="javascript:send_it();" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span class="txt">글 등록</span></a></li>
							<? } ?>
						</ul>

					</div>

				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents">


		<div class="listWrap_noline">




					<form name=frm id=frm action="bbs_proc.ajax.php" method=post enctype="multipart/form-data" >
					<input type=hidden name="bbs_idx" value='<?=$bbs_idx?>'>
					<input type=hidden name="article_num" value='<?=$cnt?>'>
					<input type=hidden name="search_mode" value='<?=$search_mode?>'>
					<input type=hidden name="search_word" value='<?=$search_word?>'>
					<input type=hidden name="scategory" value='<?=$scategory?>'>
					<input type=hidden name="code" value='<?=$code?>'>
					<input type=hidden name="b_step" value='<?=$b_step?>'>
					<input type=hidden name="b_level" value='<?=$b_level?>'>
					<input type=hidden name="b_ref" value='<?=$b_ref?>'>
					<input type=hidden name="pg" value='<?=$pg?>'>
					<input type=hidden name="mode" value='<?=$mode?>'>
					<div class="listBottom">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail">
						<caption></caption>
						<colgroup>
						<col width="150px" />
						<col width="*" />
						</colgroup>

						<tbody>
							<tr <? if ($skin == "faq" || $skin == "gallery" || $skin == "media" || $skin == "event" ) {?>style="display:none"<?}?>>
								<th>작성자</th>
								<td><input type="text" id="" name="writer" value='<?=$writer?>' class="input_txt placeHolder" rel="" style="width:150px" /></td>
							</tr>

							<tr <? if ($code == "faq" ||$code == "as" ||$code == "notice" || $skin == "gallery" || $skin == "media" || $skin == "event" ) {?>style="display:none"<?}?>>
								<th>이메일</th>
								<td><input type="text" id="" name="email" value='<?=$email?>' class="input_txt placeHolder" rel="" style="width:250px" /></td>
							</tr>

							<? if ($code == "event"){?>
							<tr >
								<th>기간</th>
								<td>
									<input type="text" id="" name="s_date"  value='<?=$s_date?>' class="datepicker input_txt placeHolder" rel="" style="width:80px" />
									&nbsp; &nbsp; ~ &nbsp; &nbsp;
									<input type="text" id="" name="e_date"  value='<?=$e_date?>' class="datepicker input_txt placeHolder" rel="" style="width:80px" />
								</td>
							</tr>
							<?}?>

							<? if ($isCategory == "Y") { ?>
							<tr style="height:40px">
								<th>구분</th>
								<td>
									<select name="category" class="input_select">
										<option value="">선택</option>
									<?
									$fsql    = " select * from tbl_bbs_category where code='$code' order by onum desc";
									$fresult = mysqli_query($connect, $fsql) or die (mysqli_error($connect));
									while($frow=mysqli_fetch_array($fresult)){
									?>
										<option value="<?=$frow["tbc_idx"]?>" <? if ($frow["tbc_idx"] == $scategory) {echo "selected"; } ?>><?=$frow["subject"]?></option>
									<?
									}
									?>
									</select>

								</td>
							</tr>
							<? } ?>


							<? if ($isNotice == "Y" || $isSecure == "Y") { ?>
							<tr height="45" <? if ($skin == "faq" || $skin == "gallery" || $skin == "media" || $skin == "event") {?>style="display:none"<?}?>>
								<th>구분</th>
								<td>
									<? if ($isNotice == "Y" ) { ?>
									<input type="checkbox" id="notice_yn" name="notice_yn" value="Y" class="input_check" <? if ($notice_yn=="Y") {echo "checked"; } ?>/> 공지글 &nbsp;&nbsp;&nbsp;
									<? } ?>
									<? if ($isSecure == "Y") { ?>
									<input type="checkbox" id="secure_yn" name="secure_yn" value="Y" class="input_check" <? if ($secure_yn=="Y") {echo "checked"; } ?>/ >비밀글
									<? } ?>
								</td>
							</tr>
							<? } ?>
							<tr <? if ($skin == "faq" || $skin == "gallery" || $skin == "media" || $skin == "event") {?>style="display:none"<?}?>>
								<th>등록일</th>
								<td><input type="text" id="" name="wdate" value='<?=$wDate?>' class="input_txt placeHolder" rel="2015-06-22 12:15:59" style="width:150px" /></td>
							</tr>
							<?if($code!="banner"){?>
							<tr <? if ($skin == "faq" || $skin == "gallery") {?>style="display:none"<?}?>>
								<th>조회</th>
								<td><input type="text" id="" name="hit" value='<?=$hit?>' class="input_txt placeHolder" rel="145" style="width:60px" numberOnly/></td>
							</tr>
							<?}else{?>
								<input type="hidden" id="" name="hit" value='<?=$hit?>' class="input_txt placeHolder" rel="145" style="width:60px" numberOnly/>

							<?}?>

							<tr>
								<th>제목</th>
								<td><input type="text" id="" name="subject" value='<?=$subject?>' class="input_txt placeHolder" rel="" style="width:98%" /></td>
							</tr>
						

							<?if($code=="banner"){?>
							<tr>
								<th>링크</th>
								<td><input type="text" id="" name="url" value='<?=$url?>' class="input_txt placeHolder" rel="" style="width:98%" /></td>
							</tr>
							<?}?>

							<?if($code!="banner"){?>
							<tr>
								<th>내용</th>
								<td>
									<!--<textarea name="contents" id="contents_" rows="10" cols="100" class="editor" s><?=$contents?></textarea>-->
									<div class="contents_" ><?=nl2br(viewSQ($contents))?></div>
								</td>
							</tr>

							<?if($isReply=="Y"){?>
							<tr>
								<th>답변</th>
								<td>
									<textarea name="reply" id="reply" rows="10" cols="150" class="" ><?=$row['reply']?></textarea>
								</td>
							</tr>
							<?}?>

							<?}?>
							<? if ($skin == "gallery" || $skin == "media" || $skin == "event") { ?>
							<tr>
								<th>PC이미지첨부</th>
								<td colspan="3">
										<? for ($i=6;$i<=6;$i++) { ?>
											<input type="file" name="ufile<?=$i?>"  class="bbs_inputbox_pixel" style="width:500px;" />
											<? if (${"ufile".$i} != "") { ?><br>파일삭제:<input type=checkbox name="del_<?=$i?>" value='Y'><a href="/include/dn.php?mode=bbs&ufile=<?=${"ufile".$i}?>&rfile=<?=${"rfile".$i}?>"><?=${"rfile".$i}?></a><? } ?>
										<? } ?>

										<? if ($code == "banner") { ?>
										<!--갤러리 이미지 사이즈-->


										<? }else if ($skin == "gallery") { ?>
										<!--갤러리 이미지 사이즈-->
										<span class="img_size_noti">* 이미지 사이즈: 310px * 211px</span>
										<? } else if ($skin == "media") { ?>
										<!--미디어 이미지 사이즈-->
										<span class="img_size_noti">* 이미지 사이즈: 150px * 103px</span>
										<? } else if ($skin == "event") { ?>
										<!--이벤트 이미지 사이즈-->
										<span class="img_size_noti">* 이미지 사이즈: 413px * 207px</span>

										
										<? } ?>


										<? if ($code == "banner") { 
											$_banner_size["16"] = "450px * 310px";
											$_banner_size["1"] = "780px * 390px";
											$_banner_size["14"] = "1180px * 105px";
											$_banner_size["15"] = "1180px * 105px";
											$_banner_size["2"] = "340px * 370px";
											$_banner_size["10"] = "561px * 312px";
											$_banner_size["11"] = "132px * 32px";
											$_banner_size["12"] = "132px * 32px";
											$_banner_size["13"] = "132px * 32px";
											$_banner_size["25"] = "132px * 32px";
											$_banner_size["18"] = "680px * 340px";
											$_banner_size["20"] = "980px * 175px";
											$_banner_size["21"] = "980px * 175px";
											$_banner_size["22"] = "980px * 175px";
											$_banner_size["23"] = "980px * 175px";
											$_banner_size["24"] = "980px * 175px";

											$_banner_size["17"] = "450px * ";
											$_banner_size["19"] = "1920px * 50px";
										?>
										<!--배너 이미지 사이즈-->

											<span class="img_size_noti">* 이미지 사이즈: <?=$_banner_size[$scategory]?></span>

										<? } ?>
								</td>
							</tr>
							<? } ?>



							<? if ($code == "banner") { ?>
							<!-- <tr>
								<th>브랜드 이미지첨부</th>
								<td colspan="3">
										<? for ($i=4;$i<=4;$i++) { ?>
											<input type="file" name="ufile<?=$i?>"  class="bbs_inputbox_pixel" style="width:500px;" />
											<? if (${"ufile".$i} != "") { ?><br>파일삭제:<input type=checkbox name="del_<?=$i?>" value='Y'><a href="/include/dn.php?mode=bbs&ufile=<?=${"ufile".$i}?>&rfile=<?=${"rfile".$i}?>"><?=${"rfile".$i}?></a><? } ?>
										<? } ?>

										

								</td>
							</tr> -->
							<tr>
								<th>모바일 이미지첨부</th>
								<td colspan="3">
										<? for ($i=5;$i<=5;$i++) { ?>
											<input type="file" name="ufile<?=$i?>"  class="bbs_inputbox_pixel" style="width:500px;" />
											<? if (${"ufile".$i} != "") { ?><br>파일삭제:<input type=checkbox name="del_<?=$i?>" value='Y'><a href="/include/dn.php?mode=bbs&ufile=<?=${"ufile".$i}?>&rfile=<?=${"rfile".$i}?>"><?=${"rfile".$i}?></a><? } ?>
										<? } ?>

										<? if ($code == "banner") { ?>
										<!--갤러리 이미지 사이즈-->


										<? }else if ($skin == "gallery") { ?>
										<!--갤러리 이미지 사이즈-->
										<span class="img_size_noti">* 이미지 사이즈: 310px * 211px</span>
										<? } else if ($skin == "media") { ?>
										<!--미디어 이미지 사이즈-->
										<span class="img_size_noti">* 이미지 사이즈: 150px * 103px</span>
										<? } else if ($skin == "event") { ?>
										<!--이벤트 이미지 사이즈-->
										<span class="img_size_noti">* 이미지 사이즈: 413px * 207px</span>
										<? } ?>

								</td>
							</tr>
							<? } ?>









							<tr <? if ($skin == "faq" || $skin == "gallery" || $skin == "media" || $skin == "event") {?>style="display:none"<?}?>>
								<th>파일첨부</th>
								<td>
									<? for ($i=1;$i<=1;$i++) { ?>
									<div class="layerA " style="display:<? if (${"ufile".$i} == "") { ?>none<? } ?>">
									<input type="file" name="ufile<?=$i?>"  class="bbs_inputbox_pixel" style="width:500px;" />
									<? if (${"ufile".$i} != "") { ?><br>파일삭제:<input type=checkbox name="del_<?=$i?>" value='Y'><a href="/include/dn.php?mode=bbs&ufile=<?=${"ufile".$i}?>&rfile=<?=${"rfile".$i}?>"><?=${"rfile".$i}?></a><? } ?>
									</div>
									<? } ?>
									&nbsp;&nbsp;&nbsp;
									</td>
							</tr>
							


						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

					<div id="headerContainer">

						<div class="inner">
							<div class="menus">
								<ul class="last">
									<li><a href="board_list.php?scategory=<?=$scategory?>&search_mode=<?=$search_mode?>&search_word=<?=$search_word?>&code=<?=$code?>&bbs_idx=<?=$bbs_idx?>&pg=<?=$pg?>" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a></li>
									<? if ($bbs_idx) { ?>
										<? if ($mode != "reply" && $skin != "gallery") { ?>
									<!--
									<li><a href="board_write.php?mode=reply&scategory=<?=$scategory?>&search_mode=<?=$search_mode?>&search_word=<?=$search_word?>&code=<?=$code?>&bbs_idx=<?=$bbs_idx?>&pg=<?=$pg?>" class="btn btn-default"><span class="glyphicon
									glyphicon-cog"></span><span class="txt">답글</span></a></li>
									-->

									<li><a href="javascript:send_it();" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a></li>
										<? } else { ?>
										<li><a href="javascript:send_it();" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a></li>
										<? } ?>
										<? if ($mode != "reply") { ?>
									<li><a href="javascript:del_chk('<?=$bbs_idx?>');" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span><span class="txt">삭제</span></a></li>
										<? } ?>
									<? } else { ?>
									<li><a href="javascript:send_it();" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span class="txt">글 등록</span></a></li>
									<? } ?>
								</ul>

							</div>

						</div><!-- // inner -->

					</div><!-- // headerContainer -->
				</div><!-- // listWrap -->

			</div><!-- // contents -->





		</span><!-- 인쇄 영역 끝 //-->
		</div><!-- // container -->




	<script src="/ckeditor5/build/ckeditor.js"></script>
	
	<script>ClassicEditor
			.create( document.querySelector( '.contents_' ), {
				alignment: {
					options: [ 'left', 'right' ]
				},				
				toolbar: {
					items: [
						'heading',
						'|',
						'bold',
						'italic',
						'link',
						'bulletedList',
						'numberedList',
						'|',
						'indent',
						'outdent',
						'|',						
						'imageUpload',
						'blockQuote',
						'insertTable',
						'mediaEmbed',
						'alignment',
						'undo',
						'redo'
					]
				},
				language: 'ko',
				image: {
					toolbar: [
						'imageTextAlternative',
						'imageStyle:full',
						'imageStyle:side'
					]
				},
				table: {
					contentToolbar: [
						'tableColumn',
						'tableRow',
						'mergeTableCells'
					]
				},
				licenseKey: '',
				simpleUpload: {
					uploadUrl: '업로드 처리 페이지 경로',
				}
				
			} )
			.then( editor => {
				window.editor = editor;
			} )
			.catch( error => {
				console.error( 'Oops, something went wrong!' );
				console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
				console.warn( 'Build id: h2awqj8p91id-8o65j7c6blw0' );
				console.error( error );
			} );
	</script>






<script>

		function ShowArticleAdd(str) {
			var cnt = document.frm.article_num.value;
			if (str == "+")
			{

				if (cnt < 5)
				{
					var row_num=parseInt(cnt)+1;
					document.frm.article_num.value=row_num;
					for(i=0; i < row_num; i++)
					{
						$(".layerA:eq("+i+")").show();
					}
				}
			} else if (str == "-") {
				if (cnt != 0)
				{
					$(".layerA:eq("+cnt+")").hide();
					var row_num=parseInt(cnt)-1;
					document.frm.article_num.value=row_num;
				}
			}
		}
		for(i=0; i < document.frm.article_num.value; i++)
		{
				//$(".layerA:eq("+i+")").show();
			$(".layerA:eq("+i+")").show();
			//document.all.layerA[i].style.display="";
		}

	$(function(){
		$("#frm").ajaxForm({
			url: "bbs_proc.ajax.php",
			type: "POST",
			data: $("#frm").serialize(),
			error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				$("#ajax_loader").addClass("display-none");
			}
			, success : function(response, status, request) {

				if (response == "OK") {
					<?
					if ($mode == "reply")
					{
					?>
					alert_("정상적으로 등록되었습니다.");
					setTimeout(function() {
						location.href="board_list.php?scategory=<?=$scategory?>&search_mode=<?=$search_mode?>&search_word=<?=$search_word?>&code=<?=$code?>&bbs_idx=<?=$bbs_idx?>&pg=<?=$pg?>";
					}, 1000);
					<?
					} else if ($_GET[bbs_idx] == "") {
					?>
					alert_("정상적으로 등록되었습니다.");
					setTimeout(function() {
						location.href="board_list.php?code=<?=$code?>&scategory=<?=$scategory?>";
					}, 1000);
					<? } else { ?>
					alert_("정상적으로 수정되었습니다.");
					setTimeout(function() {
						location.reload();
					}, 1000);
					<? } ?>
					return;
				} else if (response == "NF") {
					alert_("업로드 금지 파일입니다.");
					return;
				} else {
					alert(response);
					alert_("오류가 발생하였습니다!!");
					return;
				}
			}
		});
	});

	function send_it()
	{
		var frm = document.frm;
		<?
			if ($isCategory	== "Y") {
		?>
			/*
		if (frm.category.value == "")
		{
			frm.category.focus();
			alert_("구분을 선택해주세요.");
			return;

		}
			*/
		<?
			}


			if($code!="banner"){
		?>
		if (frm.subject.value == "")
		{
			frm.subject.focus();
			alert_("제목을 입력해주세요.");
			return;

		}
		if (frm.writer.value == "")
		{
			frm.writer.focus();
			alert_("작성자를 입력해주세요.");
			return;

		}

		//oEditors.getById["contents_"].exec("UPDATE_CONTENTS_FIELD", []);
		if (frm.contents.length < 2)
		{
			frm.contents.focus();
			alert_("내용을 입력하셔야 합니다.");
			return;
		}

		<?
			}
		?>


		$("#ajax_loader").removeClass("display-none");
		$("#frm").submit();

	}

	function del_chk(bbs_idx)
	{
		if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false)
		{
			return;
		}
		$("#ajax_loader").removeClass("display-none");
        $.ajax({
			url: "bbs_del.ajax.php",
			type: "POST",
			data: "bbs_idx[]="+bbs_idx,
			error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				$("#ajax_loader").addClass("display-none");
			}
			,complete: function(request, status, error) {
				$("#ajax_loader").addClass("display-none");
			}
			, success : function(response, status, request) {
				if (response == "OK")
				{
					alert_("정상적으로 삭제되었습니다.");
					setTimeout(function() {
						location.href="board_list.php?code=<?=$code?>&scategory=<?=$scategory?>";
					}, 1000);
					return;
				} else {
					alert_("오류가 발생하였습니다!!");
					return;
				}
			}
        });


	}
</script>

<?
	if ($is_comment == "Y" && $bbs_idx != "") {
//		include "./notice_comment.inc.php";
	}
?>

<? include "../_include/_footer.php"; ?>
