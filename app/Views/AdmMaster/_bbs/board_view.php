<? include "../_include/_header.php"; ?>
<script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js"></script>
<?
	include $_SERVER[DOCUMENT_ROOT]."/AdmMaster/include/bbs_info.inc.php";
	$writer			= $_SESSION[member][name];
	$search_mode	= updateSQ($_GET[search_mode]);
	$search_word	= updateSQ($_GET[search_word]);
	$pg				= updateSQ($_GET[pg]);
	$bbs_idx		= updateSQ($_GET[bbs_idx]);
	$wDate			= date("Y-m-d H:i:s", time());
	$hit			= 0;
	//echo $_SERVER[DOCUMENT_ROOT].'/data/editor/';

	$mode			= updateSQ($_GET[mode]);

	$titleStr = "등록";
	$cnt = 0;
	if ($mode == "reply"){
		$total_sql	= " select * from tbl_bbs_list where bbs_idx='".$bbs_idx."'";
		$result		= mysqli_query($connect, $total_sql) or die (mysql_error());
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
		$result		= mysqli_query($connect, $total_sql) or die (mysql_error());
		$row		= mysqli_fetch_array($result);
		$writer		= $row[writer];
		$hit		= $row[hit];
		$subject	= $row[subject];
		$simple		= $row[simple];
		$email		= $row["email"];
		$s_date		= $row[s_date];
		$e_date		= $row[e_date];
		if ($e_date == "")
		{
			$e_date = "계속";
		}
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
		$$reply   = $row['reply'];

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

		<div id="container" class="<? if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_counsel/") !== false ||$code == "qna"  || $code == "ContactUs")  { ?>gnb_inquiry<? } else if($code == "notice" || $code == "faq" || $code == "event" || $code == "event_notice" )  { ?>gnb_center<? } else if( $code == "banner" )  { ?>gnb_banner<? }?>">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">

				<div class="inner">
					<h2><?=getBoardName($code)?></h2>
					<div class="menus">
						<ul class="last">
							<li><a href="javascript:history.back();" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a></li>
							<? if ($bbs_idx) { ?>
							<!--
							<li><a href="board_write.php?scategory=<?=$scategory?>&search_mode=<?=$search_mode?>&search_word=<?=$search_word?>&code=<?=$code?>&bbs_idx=<?=$row[bbs_idx]?>&pg=<?=$pg?>&mode=reply" class="btn btn-default"><span class="glyphicon
							glyphicon-cog"></span><span class="txt">답글</span></a></li>
							-->
							<li><a href="board_write.php?scategory=<?=$scategory?>&search_mode=<?=$search_mode?>&search_word=<?=$search_word?>&code=<?=$code?>&bbs_idx=<?=$row[bbs_idx]?>&pg=<?=$pg?>" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a></li>
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
							<tr style="height:45px;<? if ($skin == "faq" || $skin == "gallery" ) {?>display:none<?}?>">
								<th>작성자</th>
								<td><?=$writer?>(<?=$email?>)</td>
							</tr>

							<? if ($notice_yn == "Y" || $secure_yn == "Y") { ?>
							<tr style="height:45px;<? if ($skin == "faq" || $skin == "gallery") {?>display:none<?}?>">
								<th>구분</th>
								<td>
									<? if ($notice_yn == "Y" ) { ?>
									공지글 &nbsp;&nbsp;&nbsp;
									<? } ?>
									<? if ($secure_yn == "Y") { ?>
									비밀글
									<? } ?>
								</td>
							</tr>
							<? } ?>
							<tr  style="height:45px;<? if ($skin == "faq" || $skin == "gallery") {?><?}?>">
								<th>등록일</th>
								<td><?=$wDate?></td>
							</tr>
							<tr style="height:45px;<? if ($skin == "faq" || $skin == "gallery") {?>display:none<?}?>">
								<th>조회</th>
								<td><?=$hit?></td>
							</tr>
							<tr style="height:45px;">
								<th>제목</th>
								<td><?=$subject?></td>
							</tr>
							<?
								if ($skin == "event11") {
							?>
							<tr style="height:45px;">
								<th>간략설명</th>
								<td><?=$simple?></td>
							</tr>
							<tr style="height:45px;">
								<th>이벤트기간</th>
								<td><?=$s_date?> ~ <?=$e_date?> </td>
							</tr>
							<?
								}
							?>
							<tr style="height:300px;">
								<th>내용</th>
								<td>
			<? if (right($row[ufile1], 3) == "jpg" || right($row[ufile1], 3) == "png" || right($row[ufile1], 3) == "gif" ) { ?>
				<div style="text-align:center"><img src="/data/bbs/<?=$row[ufile1]?>"></div>
			<br>
			<? } ?>
									<?=nl2br(viewSQ($contents))?>
								</td>
							</tr>
							<?if($reply){?>
							<tr style="height:300px;">
								<th>답변</th>
								<td>
									<?=nl2br(viewSQ($reply))?>
								</td>
							</tr>
							<?}?>
							<? if ($skin == "gallery") { ?>
							<tr>
								<th>썸네일첨부</th>
								<td colspan="3">
										<? for ($i=6;$i<=6;$i++) { ?>

											<? if (${"ufile".$i} != "") { ?><br><a href="/include/dn.php?mode=bbs&ufile=<?=${"ufile".$i}?>&rfile=<?=${"rfile".$i}?>"><?=${"rfile".$i}?></a><? } ?>
										<? } ?>
								</td>
							</tr>
							<? } ?>
							<tr <? if ($skin == "faq" || $skin == "gallery") {?>style="display:none"<?}?>>
								<th>파일첨부</th>
								<td>
									<? for ($i=1;$i<=1;$i++) { ?>
									<div class="layerA " style="display:<? if (${"ufile".$i} == "") { ?>none<? } ?>">
									<? if (${"ufile".$i} != "") { ?><br><a href="/include/dn.php?mode=bbs&ufile=<?=${"ufile".$i}?>&rfile=<?=${"rfile".$i}?>"><?=${"rfile".$i}?></a><? } ?>
									</div>
									<? } ?>
									&nbsp;&nbsp;&nbsp;
									</td>
							</tr>
							<!--
							<tr <? if ($skin == "notice" || $skin == "gallery") {?>style="display:none"<?}?>>
								<th>관련링크</th>
								<td><input type="text" id="url" name="url" value="<?=$url?>" class="input_txt placeHolder" rel="http://" style="width:98%" /></td>
							</tr>
							-->


						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

					<div id="headerContainer">

						<div class="inner">
							<div class="menus">
								<ul class="last">
									<li><a href="board_list.php?scategory=<?=$scategory?>&search_mode=<?=$search_mode?>&search_word=<?=$search_word?>&code=<?=$code?>&bbs_idx=<?=$bbs_idx?>&pg=<?=$pg?>;" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a></li>
									<? if ($bbs_idx) { ?>
										<? if ($mode != "reply" && $skin != "gallery") { ?>
										<!--
									<li><a href="board_write.php?scategory=<?=$scategory?>&search_mode=<?=$search_mode?>&search_word=<?=$search_word?>&code=<?=$code?>&bbs_idx=<?=$row[bbs_idx]?>&pg=<?=$pg?>&mode=reply" class="btn btn-default"><span class="glyphicon
									glyphicon-cog"></span><span class="txt">답글</span></a></li>
									-->
									<li><a href="board_write.php?scategory=<?=$scategory?>&search_mode=<?=$search_mode?>&search_word=<?=$search_word?>&code=<?=$code?>&bbs_idx=<?=$row[bbs_idx]?>&pg=<?=$pg?>" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a></li>
										<? } else { ?>
										<li><a href="board_write.php?scategory=<?=$scategory?>&search_mode=<?=$search_mode?>&search_word=<?=$search_word?>&code=<?=$code?>&bbs_idx=<?=$row[bbs_idx]?>&pg=<?=$pg?>" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a></li>
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
						location.href="board_list.php?code=<?=$code?>";
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

		oEditors.getById["contents_"].exec("UPDATE_CONTENTS_FIELD", []);
		if (frm.contents.length < 2)
		{
			frm.contents.focus();
			alert_("내용을 입력하셔야 합니다.");
			return;
		}
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
						location.href="board_list.php?code=<?=$code?>";
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
