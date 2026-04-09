<? include "../_include/_header.php"; ?>
<script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>


<?
	include $_SERVER[DOCUMENT_ROOT]."/AdmMaster/include/calender.js.php"; 
	$strTitle = "등록";
	if ($idx)
	{
		$strTitle = "수정";
		$sql = " select * from tbl_popup where idx='".$idx."' ";
		$result = mysqli_query($connect,$sql) or die (mysql_error());
		$row=mysqli_fetch_array($result);
		$P_SUBJECT		= $row[P_SUBJECT];
		$P_STARTDAY		= $row[P_STARTDAY];
		$P_START_HH		= $row[P_START_HH];
		$P_START_MM		= $row[P_START_MM];
		$P_ENDDAY		= $row[P_ENDDAY];
		$P_END_HH		= $row[P_END_HH];
		$P_END_MM		= $row[P_END_MM];
		$P_POPUP_U		= $row[P_POPUP_U];
		$P_MOVEURL		= $row[P_MOVEURL];
		$P_WIN_WIDTH	= $row[P_WIN_WIDTH];
		$P_WIN_LEFT		= $row[P_WIN_LEFT];
		$P_WIN_HEIGHT	= $row[P_WIN_HEIGHT];
		$P_WIN_TOP		= $row[P_WIN_TOP];
		$P_CATE			= $row[P_CATE];

		$is_mobile		= $row[is_mobile];
		$status			= $row[status];
		$P_START_HH		= $row[P_START_HH];
		$P_START_MM		= $row[P_START_MM];

		$P_END_HH		= $row[P_END_HH];
		$P_END_MM		= $row[P_END_MM];

		$P_STYLE		= $row[P_STYLE];
		$P_CONTENT		= $row[P_CONTENT];
		$P_WEEK1		= $row['week_1'];
		$P_WEEK2		= $row['week_2'];
		$P_WEEK3		= $row['week_3'];
		$ufile			= $row[ufile];
		$titleStr = "수정";
	}
?>
<div class="page-heading mb-4">
    
    <div class="d-flex justify-content-between align-items-center">
        <header class="d-block d-xl-none pb-2">
            <a href="#" class="d-block burger-btn d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <h4 class="text-center">팝업창 <?=$strTitle?></h4>
    </div>
</div>
		<div id="container" class="gnb_operator">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
		
					<div class="menus">
						<ul >
							<li><a href="javascript:history.back();" class="btn btn-secondary"><i class="bi bi-list"></i><span class="txt">리스트</span></a></li>
							<?if ($idx) { ?>
							<li><a href="javascript:send_it();" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">수정</span></a></li>
							<li><a href="javascript:del_chk(<?=$idx?>)" class="btn btn-danger"><i class="bi bi-trash"></i><span class="txt">삭제</span></a></li>
							<? } else  { ?>
							<li><a href="javascript:send_it();" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">등록</span></a></li>
							<? } ?>
						</ul>						
					</div>

				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents">
				
				
				<form name=frm id="frm" method=post  enctype="multipart/form-data">
				<input type=hidden name="idx" value='<?=$idx?>'>

				<div class="listWrap_noline">
				

					<!-- 안내 문구 필요시 구성 //-->
					<div class="guide_box mb10">
						- 시작일과 종료일 밤 12시를 기준으로 자동 노출/비노출 처리가 되며, 분단위로 시간을 조정하실 수 있습니다.<br />
						<!--
						- 팝업창은 가급적 500x500 기준으로 동일한 이미지를 웹(내용)과 모바일에 적용하시면 최적화 되어 노출됩니다.
						-->
					</div>

				
			

					<div class="listBottom"  style="width:100%; margin-bottom:15px;">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail">
									<caption></caption>
									<colgroup>
									<col width="150px" />
									<col width="*" />
									</colgroup>
									<tbody>
										<tr style="height:40px">
											<th>팝업창 제목</th>
											<td><input type="text" id=""  name="P_SUBJECT" value='<?=$P_SUBJECT?>'  class="input_txt placeHolder" rel="" style="width:98%" /></td>
										</tr>
										<tr style="height:40px">
											<th>팝업노출 기간</th>
											<td>
												<input type="text" id="" name="P_STARTDAY"  value='<?=$P_STARTDAY?>' class="date_form form-control input_txt placeHolder" rel="" style="width:180px" autocomplete="off"/>
												<input type="text" id="" name="P_START_HH"  value='<?=$P_START_HH?>'  class="input_txt placeHolder" rel="" style="width:60px" maxlength=2 numberOnly=true/> 
												: 
												<input type="text" id="" name="P_START_MM"  value='<?=$P_START_MM?>'  class="input_txt placeHolder" rel="" style="width:60px" maxlength=2 numberOnly=true/>&nbsp;&nbsp;부터&nbsp;&nbsp; 
												<input type="text" id="" name="P_ENDDAY"  value='<?=$P_ENDDAY?>' class="date_form form-control input_txt placeHolder" rel="" style="width:180px" autocomplete="off"/>
												<input type="text" id="" name="P_END_HH"  value='<?=$P_END_HH?>'  class="input_txt placeHolder" rel="" style="width:60px" maxlength=2 numberOnly=true/> 
												: 
												<input type="text" id="" name="P_END_MM"  value='<?=$P_END_MM?>'  class="input_txt placeHolder" rel="" style="width:60px" maxlength=2 numberOnly=true/> 
												까지
											</td>
										</tr>
										<tr style="height:40px">
											<th>팝업노출 노출일</th>
											<td>
											<input type="checkbox" name="week1" id="week1" value='Y' <?=($P_WEEK1 == 'Y' ? "checked" : "")?>>
											<label for="week1">평일</label>
											<input type="checkbox" name="week2" id="week2" value='Y' <?=($P_WEEK2 == 'Y' ? "checked" : "")?>>
											<label for="week2">토요일</label>
											<input type="checkbox" name="week3" id="week3" value='Y' <?=($P_WEEK3 == 'Y' ? "checked" : "")?>>
											<label for="week3">일요일</label>
											</td>
										</tr>
										<tr style="height:40px">
											<th>노출여부</th>
											<td>
												<input type="radio" name="status" id="statusA" value="A" <? if ($status == "A" || $status == "") { echo "checked"; } ?>> <label for="statusA" >일정별 자동노출</label>	&nbsp; &nbsp; 
												<input type="radio" name="status" id="statusB" value="B" <? if ($status == "B") { echo "checked"; } ?>> <label for="statusB" >강제노출</label>		&nbsp; &nbsp; 
												<input type="radio" name="status" id="statusC" value="C" <? if ($status == "C") { echo "checked"; } ?>> <label for="statusC" >강제 비노출</label> 
											</td>
										</tr>

										<tr style="height:40px">
											<th>노출 기기</th>
											<td>
												<input name="is_mobile" id="is_pc"   type="radio" value="P"   <? if ($is_mobile == "P" || $is_mobile == ""){echo "checked";} ?> />
												<label for="is_pc">PC</label> &nbsp; &nbsp;
												<input name="is_mobile" id="is_mobile"   type="radio" value="M"  <? if ($is_mobile == "M"){echo "checked";} ?> />
												<label for="is_mobile" >모바일</label>
												
											</td>
										</tr>

										<tr style="height:40px" class='styleL'>
											<th>노출 방식</th>
											<td>
												<input name="P_CATE" id="p_cate_l"  type="radio" value="L"  <? if ($P_CATE == "L" || $P_CATE == ""){echo "checked";} ?> />
												<label for="p_cate_l" >레이어형</label> &nbsp; &nbsp;
												<!-- <input name="P_CATE" id="p_cate_p"  type="radio" value="P"   <? if ($P_CATE == "P"){echo "checked";} ?> />
												<label for="p_cate_p" >윈도우형</label> -->
												<span class="bbs_guide" style="color:red;font-weight:bold;">* (PC에서만 적용됩니다)</span></td>
											</td>
										</tr>
										
										
										<tr style="height:40px" class='styleL'>
											<th>팝업창 노출 위치</th>
											<td>
												<input type="text" id="" name="P_WIN_LEFT" value='<?=$P_WIN_LEFT?>' class="input_txt placeHolder" rel="" style="width:60px" maxlength=4 numberOnly=true/> X 
												<input type="text" id="" name="P_WIN_TOP"  value='<?=$P_WIN_TOP?>' class="input_txt placeHolder" rel="" style="width:60px" maxlength=4 numberOnly=true/> 								
												<span class="bbs_guide" style="color:red;font-weight:bold;">* 가로 X 세로, 픽셀기준, 화면 좌상단 기준 (PC 레이어에서만 적용됩니다)</span></td>
										</tr>


										<tr style="height:40px;" class="styleP">
											<th>링크주소</th>
											<td><input type="text" id=""  name="P_MOVEURL" value='<?=$P_MOVEURL?>'  class="input_txt placeHolder" rel="" style="width:98%" /></td>
										</tr>
										
										<tr style="height:40px;" class="styleT">
											<th>이미지</th>
											<td>
												<input type="file" name="ufile" class="bbs_inputbox_pixel" style="width:410px;  margin-bottom:3px;  margin-top:8px;"  onchange="javascript:check_ext(this)"/>
											<? if ($ufile) { ?>
												<p><input type=checkbox name="img_del" value="Y" class="input_check">
												삭제
												<a href="/data/homepage/<?=$ufile?>" class="imgpop"><img src="/data/homepage/<?=$ufile?>"  class="programlist"></a></p>
											<? } ?>
											</td>
										</tr>
										
									</tbody>
								</table>


					<div class="tail_menu">
						<ul>
							<li class="left"><a href="javascript:history.back();" class="btn btn-secondary"><i class="bi bi-list"></i><span class="txt">리스트</span></a></li>
							<li class="right_sub">
								<?if ($idx) { ?>
								<a href="javascript:send_it();" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">수정</span></a>
								<a href="javascript:del_chk(<?=$idx?>)" class="btn btn-danger"><i class="bi bi-trash"></i><span class="txt">삭제</span></a>
								<? } else  { ?>
								<a href="javascript:send_it();" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">등록</span></a>
								<? } ?>
							</li>
						</ul>
					</div>
					<!-- <div id="headerContainer" style="margin-top:20px">
						
						<div class="inner">
							<h2>팝업창 <?=$strTitle?></h2>
									
							<div class="menus">
								<ul >
									<li><a href="javascript:history.back();" class="btn btn-secondary"><i class="bi bi-list"></i><span class="txt">리스트</span></a></li>
									<?if ($idx) { ?>
									<li><a href="javascript:send_it();" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">수정</span></a></li>
									<li><a href="javascript:del_chk(<?=$idx?>)" class="btn btn-danger"><i class="bi bi-trash"></i><span class="txt">삭제</span></a></li>
									<? } else  { ?>
									<li><a href="javascript:send_it();" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">등록</span></a></li>
									<? } ?>
								</ul>						
							</div>
					
						</div>// inner
					
					</div>// headerContainer -->


					
					</div><!-- // listBottom -->
					</form>
				</div><!-- // listWrap -->

			</div><!-- // contents -->





		</span><!-- 인쇄 영역 끝 //-->
		</div><!-- // container -->


<script type="text/javascript">
	$(".date_form").datepicker({
    showButtonPanel: true,
    dateFormat: 'yy-mm-dd'
});
$(document).ready(function(){
	var frm = document.frm;
	if(frm.is_mobile[1].checked == true){
		$(".styleL").hide();
		$(".styleF").show();
	}else{
		$(".styleL").show();
		$(".styleF").hide();
	}
});
//mobile체크되었을때 사이즈 + 노출 위치 hide
$(document).on('click', 'input[name=is_mobile]', function(){
    if($('#is_mobile').is(":checked")){
        $('.styleL').hide();
    } else {
        $('.styleL').show();
    }
});

function checkForNumber(str) {
	var key = event.keyCode;
	var frm = document.frm;
	if(!(key==8||key==9||key==13||key==46||key==144||
	(key>=48&&key<=57)||(key>=96&&key<=105)||key==110||key==190)) {
		event.returnValue = false;
	}
}
// 모바일 : M || PC : P
function chk_os(str){
	if(str == "M"){
		$(".styleL").hide();
		$(".styleF").show();
		$("#p_cate_p").prop('disabled',true);
		$("#p_cate_l").prop('checked',true);
	}else{
		$(".styleL").show();
		$(".styleF").hide();
		$("#p_cate_p").prop('disabled',false);
		$("#p_cate_l").prop('checked',false);
	}
}
// 유효성 검사
function send_it(){
	var frm = document.frm;
	if (frm.P_SUBJECT.value == "")
	{
		frm.P_SUBJECT.focus();
		alert_("제목을 입력해주세요.");
		return;

	}
	if (frm.P_STARTDAY.value == "")
	{
		frm.P_STARTDAY.focus();
		alert_("시작일을 선택해주세요.");
		return;
	}
	if (frm.P_START_HH.value == "")
	{
		frm.P_START_HH.focus();
		alert_("시작 시간을 입력해주세요.");
		return;
	}
	if (frm.P_START_MM.value == "")
	{
		frm.P_START_MM.focus();
		alert_("시작 분을 입력해주세요.");
		return;
	}
	if (frm.P_ENDDAY.value == "")
	{
		frm.P_ENDDAY.focus();
		alert_("종료일을 선택해주세요.");
		return;
	}
	if (frm.P_END_HH.value == "")
	{
		frm.P_END_HH.focus();
		alert_("종료 시간을 입력해주세요.");
		return;
	}
	if (frm.P_END_MM.value == "")
	{
		frm.P_END_MM.focus();
		alert_("종료 분을 입력해주세요.");
		return;
	}
	if (frm.status[0].checked == false && frm.status[1].checked == false && frm.status[2].checked == false )
	{
		alert_("노출여부를 선택해주셔야 합니다.");
		return;
	}
	if (!$("input[name='P_CATE']:checked").length) {
		alert_("노출방식을 설정해주세요.");
		return;
	}

	if (frm.is_mobile[0].checked == false && frm.is_mobile[1].checked == false )
	{
		alert_("노출기기를 설정해주세요.");
		return;
	}
	if (frm.is_mobile[1].checked == false)
	{
		
		if (frm.P_WIN_LEFT.value == "")
		{
			frm.P_WIN_LEFT.focus();
			alert_("팝업 좌측위치를 입력해주세요.");
			return;
		}
		if (frm.P_WIN_TOP.value == "")
		{
			frm.P_WIN_TOP.focus();
			alert_("팝업 상단위치를 입력해주세요.");
			return;
		}
	}
	/*
	if (frm.P_MOVEURL.value == "")
	{
		frm.P_MOVEURL.focus();
		alert_("링크주소를 입력해주세요.");
		return;
	}
	*/
	$("#frm").submit();
}
// query insert ajax
$(function(){
    $("#frm").ajaxForm({
        url: "popup_proc.ajax.php",
        type: "POST",
        dataType: "text",
        processData: false,
        contentType: false,

        error: function(request, status, error) {
            alert_("code : " + request.status + "\nmessage : " + request.responseText);
        },

        success: function(response) {
            if (response.trim() === "OK") {
                <? if ($_GET['idx'] == "") { ?>
                alert_("정상적으로 등록되었습니다.");
                location.href = "popup_list.php";
                <? } else { ?>
                alert_("정상적으로 수정되었습니다.");
                location.reload();
                <? } ?>
            } else {
                alert(response);
                alert_("오류가 발생하였습니다!!");
            }
        }
    });
});

// query delete ajax
function del_chk(ta_idx){
	if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false)
	{
		return;
	}
	$.ajax({
		url: "popup_del.php",
		type: "POST",
		data: "idx[]="+ta_idx,
		error : function(request, status, error) {
			//통신 에러 발생시 처리
			alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
			$("#ajax_loader").addClass("display-none");
		}
		,complete: function(request, status, error) {
//			$("#ajax_loader").addClass("display-none");
		}
		, success : function(response, status, request) {
			if (response == "OK"){
				alert_("정상적으로 삭제되었습니다.");
				setTimeout(function(){
					location.href="/AdmMaster/_front/popup_list.php";
				},1000);
				
				return;
			} else {
				alert(response);
				alert_("오류가 발생하였습니다!!");
				return;
			}
		}
	});
}
</script> 
<? include "../_include/_footer.php"; ?>