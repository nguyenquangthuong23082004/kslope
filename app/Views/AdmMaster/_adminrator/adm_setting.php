<? include "../_include/_header.php"; ?>
<link rel="stylesheet" href="/AdmMaster/_common/css/sms_contents.css" type="text/css" />
<div id="container" class="gnb_setting"> <span id="print_this"><!-- 인쇄영역 시작 //-->
	
	<header id="headerContainer">
		<div class="inner">
			<h2>관리자 설정 </h2>
			<div class="menus">
				<ul >
					<li><a href="javascript:send_its()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a></li>
				</ul>
			</div>
		</div>
		<!-- // inner --> 
		
	</header>
	<!-- // headerContainer -->
	
	<div id="contents">
		<div class="listWrap_noline">
			<div class="listTop">
				<div class="left">
					<p class="schTxt">■ 운영자정보 셋팅 (수정)</p>
				</div>
			</div>
			<!-- // listTop -->
			
			<form name="frm" id="frm" method="post">
			<input type="hidden" id="" name="user_email" value="<?=$row[user_email]?>" class="input_txt placeHolder" rel="" style="width:400px" />
			<?
				$total_sql = " select * from tbl_member where m_idx='".$_SESSION[member][idx]."'";
				$result = mysqli_query($connect, $total_sql) or die (mysqli_error($connect));
				$row=mysqli_fetch_array($result);	
			?>
			<div class="listBottom">
				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail">
					<caption>
					</caption>
					<colgroup>
					<col width="150px" />
					<col width="*" />
					</colgroup>
					<tbody>
						<tr>
							<th>관리 아이디</th>
							<td><span  class="txt_black bold"><?=$row[user_email]?></span> <span class="txt_point">* 변경 불가</span></td>
						</tr>
						<tr>
							<th>관리자명</th>
							<td><input type="text" id="" name="user_name" value="<?=$row[user_name]?>" class="input_txt placeHolder" rel="" style="width:200px" /></td>
						</tr>
						<tr>
							<th>현재 비밀번호</th>
							<td><input type="password" id="" name="user_pw_org" value="" class="input_txt placeHolder" rel="" style="width:200px" />
								<span class="txt_point">* 비밀번호 변경시 현재 비밀번호 입력</span></td>
						</tr>
						<tr>
							<th>신규 비밀번호</th>
							<td><input type="password" id="" name="user_pw" value="" class="input_txt placeHolder" rel="" style="width:200px" /></td>
						</tr>
						<tr>
							<th>신규 비밀번호 확인</th>
							<td><input type="password" id="" name="user_pw2" value="" class="input_txt placeHolder" rel="" style="width:200px" />
								<span class="txt_point">* 신규 비밀번호 재확인</span></td>
						</tr>
					</tbody>
				</table>
			</div>
			</form>
			
				<script>
					function chk_it1(strs)
					{
						document.frm1.chk1.value = strs;
						if (strs == "Y")
						{
							$(".chk_1_1").addClass("on");
							$(".chk_1_2").removeClass("off");
						} else {
							$(".chk_1_1").removeClass("on");
							$(".chk_1_2").addClass("off");
						}
					}
					function chk_it2(strs)
					{
						document.frm1.chk2.value = strs;
						if (strs == "Y")
						{
							$(".chk_2_1").addClass("on");
							$(".chk_2_2").removeClass("off");
						} else {
							$(".chk_2_1").removeClass("on");
							$(".chk_2_2").addClass("off");
						}
					}
					function chk_it3(strs)
					{
						document.frm1.chk3.value = strs;
						if (strs == "Y")
						{
							$(".chk_3_1").addClass("on");
							$(".chk_3_2").removeClass("off");
						} else {
							$(".chk_3_1").removeClass("on");
							$(".chk_3_2").addClass("off");
						}
					}
					function smsByteChk1(content)
					{
						$("#messagebyte1").text(content.value.bytes());

						if (content.value.bytes() > 80)
						{
							content.value = content.value.cut(80);
						}
					}
					function smsByteChk2(content)
					{
						$("#messagebyte2").text(content.value.bytes());

						if (content.value.bytes() > 80)
						{
							content.value = content.value.cut(80);
						}
					}
					function smsByteChk3(content)
					{
						$("#messagebyte3").text(content.value.bytes());

						if (content.value.bytes() > 80)
						{
							content.value = content.value.cut(80);
						}
					}

					String.prototype.cut = function(len) {
							var str = this;
							var l = 0;
							for (var i=0; i<str.length; i++) {
									l += (str.charCodeAt(i) > 128) ? 2 : 1;
									if (l > len) return str.substring(0,i);
							}
							return str;
					}

					String.prototype.bytes = function() {
							var str = this;
							var l = 0;
							for (var i=0; i<str.length; i++) l += (str.charCodeAt(i) > 128) ? 2 : 1;
							return l;
					}

				</script>
				
				</div>
			</div>
			</form>
			
		</div>
		<!-- // listWrap --> 


		
		
	</div>
	<!-- // contents --> 
	
	</span><!-- 인쇄 영역 끝 //--> 
</div>
<!-- // container --> 

<script>
	function send_its()
	{
		var check = /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{6,16}$/;

		if (trim(frm.user_name.value) == "")
		{
			alert_("성명을 입력하셔야 합니다.");
			frm.user_name.focus();
			return;
		}

		if (frm.user_pw_org.value != "")
		{
			if (frm.user_pw.value.length < 6 || frm.user_pw.value.length > 20) {
				alert_("비밀번호는 6 ~ 20 자리로 입력해주세요.");
				frm.user_pw.focus();
				return;
			}
			if (frm.user_pw.value != frm.user_pw2.value) {
				alert_("비밀번호가 일치하지 않습니다.");
				frm.user_pw2.focus();
				return;
			}
		}
		frm.action ="admin_modify.ajax.php";
		//frm.submit();
		$("#frm").submit();
	}
	$(function(){
		$("#frm").ajaxForm({
			url: "admin_modify.ajax.php",
			type: "POST",
			data: $("#frm").serialize(),
			error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				$("#ajax_loader").addClass("display-none");
			}
			, success : function(response, status, request) {
				if (response == "DE") {
					alert_("이메일이 중복됩니다.");
					return;
				} else if (response == "NP") {
					alert_("이전 패스워드가 일치하지 않습니다.");
					return;
				} else if (response == "OK") {
					alert_("정상적으로 수정되었습니다.");
					setTimeout(function() {
						location.reload();
					}, 1000);
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

<? include "../_include/_footer.php"; ?>
