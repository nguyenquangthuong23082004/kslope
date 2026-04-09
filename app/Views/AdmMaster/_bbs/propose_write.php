<? include "../_include/_header.php"; ?>
<?
if ($ta_idx) {
		$total_sql	= " select * from ".TBL_ALLIANCE." where ta_idx='".$ta_idx."'";
		$result		= mysql_query($total_sql) or die (mysql_error());
		$row		= mysql_fetch_array($result);
		$cate		= $row[cate];
		$user_name	= $row[user_name];
		$user_email	= $row[user_email];
		$phone		= $row[phone];
		$title		= $row[title];
		$contents	= viewSQ($row[contents]);	
		$status		= $row[status];
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
	}?>

		<div id="container">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>제휴/광고 문의 </h2>
					<div class="menus">
						<ul class="last">							
							<li><a href="javascript:history.back();" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a></li>
							<li><a href="javascript:send_it();" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a></li>
							<li><a href="javascript:del_chk(<?=$ta_idx?>);" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span><span class="txt">삭제</span></a></li>
							<li><a href="#"  onClick="pp();" style='cursor:pointer; cursor:hand;' class="btn btn-default"><span class="glyphicon glyphicon-print"></span><span class="txt">인쇄</span></a></li>
						</ul>
						
					</div>

				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents">
				

		<div class="listWrap_noline">

					


					<form name=frm id=frm method=post enctype="multipart/form-data" >
					<input type=hidden name="article_num" value='<?=$cnt?>'> 
					<input type=hidden name="ta_idx" value='<?=$ta_idx?>'> 
					<div class="listBottom">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail">
						<caption></caption>
						<colgroup>
						<col width="150px" />
						<col width="*" />
						</colgroup>
	
						<tbody>
							
							<tr>
								<th>문의 구분</th>
								<td>
									<input type=radio name="cate" class="cate" value="C" <? if ($cate == "C") {echo "checked"; } ?>>제휴문의
									<input type=radio name="cate" class="cate" value="A" <? if ($cate == "A") {echo "checked"; } ?>>광고문의
									<input type=radio name="cate" class="cate" value="E" <? if ($cate == "E") {echo "checked"; } ?>>기타문의
								</td>
							</tr>
							<tr>
								<th>확인 현황</th>
								<td>
									<input type=radio name="status" class="status" value="W" <? if ($status == "W" || $status == "" ) {echo "checked"; } ?>>확인중(대기)
									<input type=radio name="status" class="status" value="Y" <? if ($status == "Y") {echo "checked"; } ?>>답변완료
									<input type=radio name="status" class="status" value="N" <? if ($status == "N") {echo "checked"; } ?>>보류
								</td>
							</tr>
							<tr>
								<th>성명</th>
								<td><input type="text" id="" name="user_name" value="<?=$user_name?>" class="input_txt placeHolder" rel="" style="width:200px" /></td>
							</tr>
							<tr>
								<th>이메일</th>
								<td><input type="text" id="" name="user_email" value="<?=$user_email?>" class="input_txt placeHolder" rel="" style="width:400px" /></td>
							</tr>
							<tr>
								<th>연락처</th>
								<td><input type="text" id="" name="phone" value="<?=$phone?>" class="input_txt placeHolder" rel="" style="width:400px"  onkeyup="javascript:mphon(this)" onkeydown="javascript:mphon(this)" maxlength=13/></td>
							</tr>
							<tr>
								<th>제목</th>
								<td><input type="text" id="" name="title" value="<?=$title?>" class="input_txt placeHolder" rel="" style="width:98%" /></td>
							</tr>
							<tr>
								<th>내용</th>
								<td>
									<script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>
									<textarea name="contents" id="contents_" style="width:100%; height:40px; display:none;"><?=$contents?></textarea>
									<script>
										var oEditors = [];

										// 추가 글꼴 목록
										//var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];

										nhn.husky.EZCreator.createInIFrame({
										oAppRef: oEditors,
										elPlaceHolder: "contents_",
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
								</td>
							</tr>
							<tr>
								<th>파일첨부</th>
								<td>
									<a href="javascript:ShowArticleAdd('+')" class="btn btn-black">추가 +</a> 
									<a href="javascript:ShowArticleAdd('-')" class="btn btn-black">삭제 -</a>
									<br />
									<? for ($i=1;$i<=5;$i++) { ?>
									<div class="layerA " style="display:<? if (${"ufile".$i} == "") { ?>none<? } ?>">
									<input type="file" name="ufile<?=$i?>"  class="bbs_inputbox_pixel" style="width:500px;" /> 
									<? if (${"ufile".$i} != "") { ?><br>파일삭제:<input type=checkbox name="del_<?=$i?>" value='Y'><a href="/include/dn.php?mode=bbs&ufile=<?=${"ufile".$i}?>&rfile=<?=${"rfile".$i}?>"><?=${"rfile".$i}?></a><? } ?>
									</div>
									<? } ?>
									&nbsp;&nbsp;&nbsp; 
									<span class="bbs_guide">* 10M 이내, exe 등의 실행파일 첨부 불가, 이미지첨부시 본문 상단에 이미지 노출</span>
								</td>
							</tr>						
						</tbody>
						</table>
					</div><!-- // listBottom -->

					<div id="headerContainer">
						
						<div class="inner">
							<div class="menus">
								<ul class="last">							
									<li><a href="javascript:history.back();" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a></li>
									<li><a href="javascript:send_it();" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a></li>
									<li><a href="javascript:del_chk(<?=$ta_idx?>);" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span><span class="txt">삭제</span></a></li>
									<li><a href="#"  onClick="pp();" style='cursor:pointer; cursor:hand;' class="btn btn-default"><span class="glyphicon glyphicon-print"></span><span class="txt">인쇄</span></a></li>
								</ul>
								
							</div>

						</div><!-- // inner -->

					</div><!-- // headerContainer -->

				</div><!-- // listWrap -->

			</div><!-- // contents -->





		</span><!-- 인쇄 영역 끝 //-->
		</div><!-- // container -->


<script>
	function del_chk(ta_idx)
	{
		if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false)
		{
			return;
		}
		$.ajax({
			url: "/AdmMaster/ajax/alliance_list_del.ajax.php",
			type: "POST",
			data: "ta_idx[]="+ta_idx,
			error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				$("#ajax_loader").addClass("display-none");
			}
			,complete: function(request, status, error) {
//				$("#ajax_loader").addClass("display-none");
			}
			, success : function(response, status, request) {
				if (response == "OK")
				{
					alert_("정상적으로 삭제되었습니다.");
					setTimeout(function() {
						location.href="propose_list.php";
					}, 1000);
					return;
				} else {
					alert(response);
					alert_("오류가 발생하였습니다!!");
					return;
				}
			}
        });

	}
	function send_it()
	{
		var frm = document.frm;
		if ($(".cate").is(":checked") == false)
		{
			alert_("구분을 선택하셔야 합니다.");
			return;
		}
		if (trim(frm.user_name.value) == "")
		{
			alert_("성명을 입력하셔야 합니다.");
			frm.user_name.focus();
			return;
		}
		if (mail_chk(frm.user_email.value) == "")
		{
			alert_("이메일을 바르게 입력하셔야 합니다.");
			frm.user_email.focus();
			return;
		}
		if (trim(frm.phone.value) == "")
		{
			alert_("연락처를 입력하셔야 합니다.");
			frm.phone.focus();
			return;
		}
		if (trim(frm.title.value) == "")
		{
			alert_("제목을 입력하셔야 합니다.");
			frm.title.focus();
			return;
		}
		oEditors.getById["contents_"].exec("UPDATE_CONTENTS_FIELD", []);
		if (frm.contents.value.length < 10)
		{
			frm.contents.focus();
			alert_("내용을 입력하셔야 합니다.");
			return;
		}
		$("#frm").submit();
	}

	$(function(){
		$("#frm").ajaxForm({
			url: "/AdmMaster/ajax/alliance_proc.ajax.php",
			type: "POST",
			data: $("#frm").serialize(),
			error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				$("#ajax_loader").addClass("display-none");
			}
			, success : function(response, status, request) {
				if (response == "OK") {
					<? if ($_GET[ta_idx] == "") { ?>
					alert_("정상적으로 등록되었습니다.");
					setTimeout(function() {
						location.href="alliance_list.php?code=<?=$code?>";
					}, 1000);
					<? } else { ?>
					alert_("정상적으로 수정되었습니다.");
					setTimeout(function() {
						location.reload();
					}, 1000);
					<? } ?>
					return;
				} else {
					alert(response);
					alert_("오류가 발생하였습니다!!");
					return;
				}
			}
		});
	});

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
						$(".layerB:eq("+i+")").show();
					}
				} 
			} else if (str == "-") {
				if (cnt != 0)
				{
					$(".layerA:eq("+cnt+")").hide();
					$(".layerB:eq("+cnt+")").hide();
					var row_num=parseInt(cnt)-1;
					document.frm.article_num.value=row_num;
				}
			}
		}
		for(i=0; i < document.frm.article_num.value; i++)
		{	
			$(".layerA:eq("+i+")").show();
			$(".layerB:eq("+i+")").show();
		}

</script>


<? include "../_include/_footer.php"; ?>