<form name=cfrm id=cfrm method=post enctype="multipart/form-data" >
<input type=hidden name="bbs_idx" value='<?=$bbs_idx?>'> 
<input type=hidden name="code" value='<?=$code?>'> 
<input type=hidden name="cidx" value=''> 
<div class="reply_box mb30">
	<p class="reply_tit">댓글 남기기</p>
	<dl>
		<dt>
			<textarea  name="comment"  class="input_txt" id="reply_text"  onkeyup="javascript:chkLengthEvent(this,500);" <? if ($_SESSION[member][level] == "") {?>readonly onclick="javascript:alert_('로그인 하셔야 합니다.');"; <? } ?>></textarea>
			<ul class="reply_btm">
				<li class="left"><span id="showLength">0</span>/500자</li>
				<li class="right"><a href="#">[댓글 운영원칙]</a></li>
			</ul>
		</dt>
		<dd><span class="reply_btn"><a href="javascript:comment_it()">댓글 남기기</a></span></dd>
	</dl>
	<p class="txt_guide"> - 전체 500자 이내 댓글을 작성하실 수 있습니다. <br />
		- 욕설, 비방, 광고, 선정적인 내용등의 댓글은 별도 고지없이 관리자에 의해 임의 삭제됩니다. </p>
</div>
</form>
<script>
		function comment_it()
		{
			<? if ($_SESSION[member][level] == "") {?>
			alert_("로그인해주셔야 합니다.");
			<? } else {?>
			var frm = document.cfrm;
			if (frm.comment.frm == "")
			{
				alert_("내용을 입력해주셔야 합니다.");
				frm.comment.focus();
				return;
			}
			/*
			frm.target="hiddenFrame";
			frm.action="/include/bbs_comment_ok.php";
			*/
			$("#cfrm").submit();
			<? } ?>
		}

	$(function(){
		$("#cfrm").ajaxForm({
			url: "/ajax/comment_ok.ajax.php",
			type: "POST",
			data: $("#cfrm").serialize(),
			error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				$("#ajax_loader").addClass("display-none");
			}
			, success : function(response, status, request) {
				if (response == "OK") {
					alert_("정상적으로 등록되었습니다.");
					get_list("bbs_idx=<?=$bbs_idx?>");
					document.cfrm.comment.value="";
					$("#showLength").html("0");
					return;
				} else {
					alert(response);
					alert_("오류가 발생하였습니다!!");
					return;
				}
			}
		});
	});
</script>
<?
		$total_sql		= " select count(*) as cnt from tbl_bbs_comment where bbs_idx='$bbs_idx' ";
		$result			= mysql_query($total_sql) or die (mysql_error());
		$row			= mysql_fetch_array($result);
		$nTotalCount	= $row[0];
?>
<!-- 댓글 리스트 부분 //-->
<div class="reply_list_box">
</div>
	<script>
		function get_list(url)
		{
			$.ajax({
				url: "/AdmMaster/ajax/get_comment_list.ajax.php",
				type: "POST",
				data: url,
				error : function(request, status, error) {
				 //통신 에러 발생시 처리
					alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
					$("#ajax_loader").addClass("display-none");
				}
				,complete: function(request, status, error) {
	//				$("#ajax_loader").addClass("display-none");
				}
				, success : function(response, status, request) {
					$(".reply_list_box").html(response);
				}
			});

		}
		get_list("bbs_idx=<?=$bbs_idx?>");

		function comment_del(num)
		{
			var frm = document.cfrm;
			if (confirm("삭제하시겠습니까?"))
			{
				$.ajax({
					url: "/ajax/comment_del.ajax.php",
					type: "POST",
					data: "bbs_idx=<?=$bbs_idx?>&cidx="+num,
					error : function(request, status, error) {
					 //통신 에러 발생시 처리
						alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
						$("#ajax_loader").addClass("display-none");
					}
					,complete: function(request, status, error) {
		//				$("#ajax_loader").addClass("display-none");
					}
					, success : function(response, status, request) {
						alert_("삭제되었습니다.");
						get_list("bbs_idx=<?=$bbs_idx?>");
					}
				});
			}
		}

		function chkLengthEvent(memo, num) 
		{ 
			var ari_max=num;
			var ls_str = memo.value; // 이벤트가 일어난 컨트롤의 value 값 
			var li_str_len = ls_str.length; // 전체길이 

			// 변수초기화 
			var li_max = ari_max; // 제한할 글자수 크기 
			var i = 0;     // for문에 사용 
			var li_byte = 0;  // 한글일경우는 2 그밗에는 1을 더함 
			var li_len = 0;  // substring하기 위해서 사용 
			var ls_one_char = ""; // 한글자씩 검사한다 
			var ls_str2 = ""; // 글자수를 초과하면 제한할수 글자전까지만 보여준다. 

			for(i=0; i< li_str_len; i++) 
			{ 
				// 한글자추출 
				ls_one_char = ls_str.charAt(i); 

				// 한글이면 2를 더한다. 
				if (escape(ls_one_char).length > 4) { 
					li_byte += 2; 
				}else{   // 그밗의 경우는 1을 더한다. 
					li_byte++; 
				} 
				// 전체 크기가 li_max를 넘지않으면 
				if(li_byte <= li_max){ 
					li_len = i + 1; 
				} 
			} 

			// 전체길이를 초과하면 
			if(li_byte > li_max){ 
				alert(""+num+" 바이트를 초과하면 안됩니다."); 
				ls_str2 = ls_str.substr(0, li_len); 
				memo.value = ls_str2; 
			} 
			$("#showLength").html(li_byte);
		} 


</script>

