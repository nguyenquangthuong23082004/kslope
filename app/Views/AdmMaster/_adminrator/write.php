<? include "../_include/_header.php"; ?>

<link rel="stylesheet" href="/AdmMaster/_common/css/sms_contents.css" type="text/css" />

<div id="wrap">				

<?
   if($m_idx) {
      $readonly = "readonly";
	  $tit = "직원정보 수정";
	  $sql    = "select * from tbl_member_adminrator where m_idx = '{$m_idx}' ";
	  $result = mysqli_query($connect, $sql) or die (mysql_error());
  	  $row	  = mysqli_fetch_array($result);
   } else {
      $readonly = "";
	  $tit = "직원정보 추가";
   }
?>


<script type="text/javascript">

	function send_it()
	{
		var frm = document.frm;
			if (frm.id_chk.value == "N")
		{
			frm.user_id.focus();
			alert("아이디 중복체크를 해주셔야 합니다.");
			return;
		}
				if (frm.user_name.value == "")
		{
			frm.user_name.focus();
			alert("이름을 입력해 주세요. ");
			return;

		}

		frm.submit();
	}
</script>

<style>
	.form-control {
		width: unset;
	}

	.form-select {
		width: unset;
		height: 30px;
	}
</style>

<div class="page-heading mb-4">
    
    <div class="d-flex justify-content-between align-items-center">
        <header class="d-block d-xl-none pb-2">
            <a href="#" class="d-block burger-btn d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <h4 class="text-center"><?=$tit?></h4>
    </div>
</div>
<div id="container" class="gnb_setting"> <span id="print_this"><!-- 인쇄영역 시작 //-->
	
	<header id="headerContainer">
		<div class="inner">
			<div class="menus">
				<ul>
					<li><a href="javascript:history.back();" class="btn btn-secondary"><i class="bi bi-list"></i><span class="txt">리스트</span></a></li>
					<li><a href="javascript:send_it()" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">등록</span></a></li>
										
				</ul>
			</div>
		</div>
		<!-- // inner --> 
		
	</header>
	<!-- // headerContainer -->
	
<form name="frm" action="write_ok.php" method="post" target="hiddenFrame" enctype="multipart/form-data">
<input type="hidden" name="m_idx" value="<?=$m_idx?>"> 
<input type="hidden" name="o_status" value=""> 

<? if($m_idx) { ?>
<input type="hidden" name="id_chk" id="id_chk" value="Y">
<? } else { ?>
<input type="hidden" name="id_chk" id="id_chk" value="N">
<? } ?>
<input type="hidden" name="agent_idx" id="agent_idx" value=""> 
	
	<div id="contents">
		<div class="listWrap_noline">
				
			
			<div class="listBottom">
				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail">
					<caption>
					</caption>
					<colgroup>
					<col width="10%">
					<col width="40%">
					<col width="10%">
					<col width="40%">
					</colgroup>
					<tbody>
						<tr height="45">
							<th>아이디</th>
							<td>
								<input type="text" name="user_id" value="<?=$row['user_id']?>" id="user_id" class="half form-control frm_input" maxlength="20" style="ime-mode:disabled" <?=$readonly?> >

								<? if($readonly == "") { ?>
								<a href="javascript:id_check();" class="btn btn-primary"><span class="txt">중복확인</span></a>
								<? } ?>
							</td>
							<th>비밀번호</th>
							<td><input type="password" name="user_pw" value="" class="form-control bbs_inputbox_pixel" style="width:200px" maxlength="50/"></td>
						</tr>
						<tr height="45">
							<th>이름</th>
							<td><input type="text" name="user_name" value="<?=$row['user_name']?>" class="form-control bbs_inputbox_pixel" style="width:200px" maxlength="50/"></td>
							<th>휴대폰</th>
							<td><input type="text" name="user_mobile" value="<?=$row['user_mobile']?>" class="form-control text" style="width:200px"></td>
						</tr>
						<tr height="45">
							<th>현황</th>
							<td colspan="3">
								<select name="status" class="form-select">
								    <? if($row['status'] == "Y") { ?>
									<option value="Y" selected>이용중</option>
									<option value="N">정지중</option>
								    <? } else if($row['status'] == "N") { ?>
									<option value="Y">이용중</option>
									<option value="N" selected>정지중</option>
									<? } else { ?>
									<option value="Y" selected>이용중</option>
									<option value="N">정지중</option>
									<? } ?>
								</select>
							</td>
						</tr>					
						<tr height="45" class="cls_out">
							<th>권한</th>
							<td colspan="3">
								<table style="width:100%">
									<colgroup>
									<col width="15%">
									<col width="35%">
									<col width="10%">
									<col width="40%">
									</colgroup>
									<tbody>
									<tr>
										<td colspan="4">
											<button type="button" style="width:10%" onclick="chk_sel();" class="btn btn-success">전체선택
											</button>
											<button type="button" style="width:10%" onclick="chk_not_sel();" class="btn btn-danger">선택취소
											</button>
										</td>
									</tr>
									<?
									foreach( $_Adm_grant_top_name as $keys1 => $vals1 ){
									?>
									<tr style="height:45px">
										<td style="width:120px;text-align:center;background-color:#fafafa;font-weight:bold;color:#000000"><?=$vals1?></td>
										<td colspan="3">
										<?
										foreach( $_Adm_grant_name[$keys1] as $keys2 => $vals2 ){
										?>
											<input type="checkbox" name="auth[]" value="<?=$_Adm_grant_code[$keys1][$keys2]?>" id="<?=$_Adm_grant_code[$keys1][$keys2]?>"> <label for="<?=$_Adm_grant_code[$keys1][$keys2]?>"><?=$vals2?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<?
									}
										?>
										</td>
									</tr>
									<?}?>
								</tbody></table>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- // listBottom --> 

			<div class="tail_menu">
				<ul>
					<li class="left"></li>
					<li class="right_sub">

						<a href="javascript:history.back();" class="btn btn-secondary"><i class="bi bi-list"></i><span class="txt">리스트</span></a>
							
						<a href="javascript:send_it()" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">등록</span></a>
					</li>
				</ul>
			</div>

		</div>
		<!-- // listWrap --> 
		
	</div>
	<!-- // contents --> 
	</form>
	</span><!-- 인쇄 영역 끝 //--> 
</div>
<!-- // container --> 




<iframe width="300" height="300" name="hiddenFrame" id="hiddenFrame" src="" style="display:none;"></iframe>

<script>
	function chk_sel() {
		document.querySelectorAll('input[name="auth[]"]').forEach(chk => {
			chk.checked = true;
		});
	}

	function chk_not_sel() {
		document.querySelectorAll('input[name="auth[]"]').forEach(chk => {
			chk.checked = false;
		});
	}



	function change_it(str)
	{
		if (str == "O")
		{
			$(".cls_out").show();
		} else {
			$(".cls_out").hide();
		}
	}
	
	function del_it() {
		if(confirm(" 삭제후 복구하실수 없습니다. \n\n 삭제하시겠습니까?")) {
			hiddenFrame.location.href = "del.php?m_idx[]=&mode=view";
		}
	 
	}

    

	function id_check()
	{
		if ($('#user_id').val().length < 6 )
		{
			$('#user_id').focus();
			alert("아이디는 6자 이상 등록해주셔야 합니다.");
			return;
		}

        $.ajax({
			url: "/AdmMaster/_member/adminrator_id_chk_ajax.php",
			type: "GET",
			data: "userid="+$("#user_id").val(),
			error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert("code : " + request.status + "\r\nmessage : " + request.reponseText);
			}
			,complete: function(request, status, error) {
//				$("#ajax_loader").addClass("display-none");
			}
			, success : function(response, status, request) {

				response = response.trim();

				$("#id_chk").val("N");

				if( parseInt(response) > 0 ){
					alert("이미 사용중인 아이디입니다.");
					$("#user_id").focus();
					return false;
				}else{
					$("#id_chk").val("Y");
					$("#user_id").val($("#user_id").val());
					alert("사용가능한 아이디입니다.");
				}


				$('#user_id').focus();
			}
        });
	}


</script>

<? include "../_include/_footer.php"; ?>