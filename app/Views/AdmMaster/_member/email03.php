<? include "../_include/_header.php"; ?>

<!-- 에디터 사용에 필요한 js 인크루드 -->
<script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js"></script>

<?
    // 발신정보 참조
	$sql    = " select * from tbl_homeset ";
	$result = mysqli_query($connect, $sql) or die (mysql_error());
    $data   = mysqli_fetch_array($result);

	$g_list_rows = 40;
    $strSql = ""; // where 절에 사용할 query 변수
	if($sms_yn == "2") $strSql .= " and sms_yn = 'Y' ";  // 수신동의 포함여부
	if($search_col && $search_text) $strSql .= " and $search_col like '%{$search_text}%' "; // 검색항목 선택
	
	$total_sql = " select * from tbl_member where 1=1 $strSql ";

	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$nTotalCount = mysqli_num_rows($result);
?>
		<div id="container" class="gnb_member">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>개별메일발송</h2>
					<div class="menus">
						<ul class="first">
							<? include "./email_menu.php"; ?>
						</ul>
					</div>
				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents email_container email_container03">
				<form name="search" id="search">		
				<input type="hidden" name="gubun" value="<?=$gubun?>">
					<header id="" class="width_96">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable01 email_form01" style="table-layout:fixed;">
							<colgroup>
								<col width="130px">
								<col width="*">
							</colgroup>
							<tbody>
								<tr>
									<td class="label">회원등급</td>
									<td class="inbox">
										<select name="sms_yn" id="sms_yn">
										<? if($sms_yn == "1") { ?>
											<option value="">선택</option>
											<option value="1" selected>전체회원</option>
											<option value="2">수신동의회원</option>
										<? } else if($sms_yn == "2") { ?>
											<option value="">선택</option>
											<option value="1">전체회원</option>
											<option value="2" selected>수신동의회원</option>
										<? } else { ?>
											<option value="" selected>선택</option>
											<option value="1">전체회원</option>
											<option value="2">수신동의회원</option>
                                        <? } ?>
										</select>
										<select name="search_col" id="search_col">
										<? if($search_col == "user_name") { ?>
											<option value="">선택</option>
											<option value="user_name" selected>회원명</option>
											<option value="user_id">회원아이디</option>
											<option value="user_mobile">휴대폰</option>
										<? } else if($search_col == "user_id") { ?>
											<option value="">선택</option>
											<option value="user_name">회원명</option>
											<option value="user_id" selected>회원아이디</option>
											<option value="user_mobile">휴대폰</option>
										<? } else if($search_col == "user_mobile") { ?>
											<option value="">선택</option>
											<option value="user_name">회원명</option>
											<option value="user_id">회원아이디</option>
											<option value="user_mobile" selected>휴대폰</option>
										<? } else { ?>
											<option value="" selected>선택</option>
											<option value="user_name">회원명</option>
											<option value="user_id">회원아이디</option>
											<option value="user_mobile">휴대폰</option>
                                        <? } ?>
										</select>
										<input type="text" name="search_text" id="search_text" value="<?=$search_text?>" placeholder="검색해 주세요">
										<a href="javascript:search_it()" class="btn btn-default btn_email03"><span class="glyphicon glyphicon-search"></span> <span class="txt">검색</span></a>
									</td>
								</tr>								
							</tbody>
						</table>
						
					</header><!-- // headerContents -->
				</form>
				<script>
				function search_it()
				{
					var frm = document.search;

					if($("#search_col").val()) {
					   if(!$("#search_text").val()) {
                           alert('검색어를 입력하세요');
                           $("#search_text").focus();
						   return false;
                       }
                    } 

					frm.submit();
				}

                function send_email_it()
				{
                    var frm = document.frm_send;
					
					if(!$("#to_email").val()) {
                        alert('수신E-mail을 입력하세요');
                        $("#to_email").focus();
					    return false;
                    }

					if(!$("#send_name").val()) {
                        alert('발송자이름을 입력하세요');
                        $("#send_name").focus();
					    return false;
                    }

					if(!$("#send_email").val()) {
                        alert('발송자 E-mail을 입력하세요');
                        $("#send_email").focus();
					    return false;
                    }

					if(!$("#mail_title").val()) {
                        alert('메일제목을 입력하세요');
                        $("#mail_title").focus();
					    return false;
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
				</script>

				<div class="listWrap email_container email_container02">
					<!-- 안내 문구 필요시 구성 //-->
		
					<div class="listTop">
						<div class="left">
							<p class="schTxt"> 총 <?=$nTotalCount?>명 발송대상</p>
						</div>

					</div><!-- // listTop -->
					
					<form name="frm" id="frm">				
					<div class="listBottom email01">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable">
						<caption></caption>
						<colgroup>
						<col width="5%" />
						<col width="5%" />
						<col width="5%" />
						<col width="5%" />
						<col width="10%" />
						<col width="10%" />
						<col width="5%" />
						<col width="5%" />
						<col width="10%" />
						<col width="10%" />
						<col width="10%" />
						<col width="5%" />
						</colgroup>
						<thead>
							<tr>
								<th><span style="font-size:0.8em;">전체선택</span><br><input type="checkbox" id="checkall"></th>
								<th>번호</th>
								<th>등급</th>
								<th>아이디</th>
								<th>성명</th>
								<th>성별</th>
								<th>연령</th>
								<th>접속수</th>
								<th>최근접속일</th>
								<th>가입일</th>
								<th>이메일</th>
								<th>이메일수신</th>				
							</tr>
						</thead>	
						<tbody>
						<?
							$nPage = ceil($nTotalCount / $g_list_rows);
							if ($pg == "") $pg = 1;
							$nFrom = ($pg - 1) * $g_list_rows;

							$sql    = $total_sql . " order by m_idx desc limit $nFrom, $g_list_rows ";
							$result = mysqli_query($connect, $sql) or die (mysql_error());
							$num = $nTotalCount - $nFrom;
							
							if ($nTotalCount == 0) {
						?>
						<tr>
							<td colspan=14 style="text-align:center;height:100px">검색된 결과가 없습니다.</td>
						</tr>
						<?
							}						
							while($row = mysqli_fetch_array($result)){
							$row_num = $num--;

							// 성별
							if ($row["gender"] == "M")
							{
								$gender = "남";
							} elseif ($row["gender"] == "W") {
								$gender = "여";
							} else {
								$gender = "";
							} 

							// sms 수신동의 여부
							if ($row["user_email_yn"] == "Y")
							{
								$email_yn = "수신동의";
							} else {
								$email_yn = "수신거부";
							} 

							// 연령계산 
							$birth_time = strtotime($row['birthday']);
							$now        = date('Y');
							$birthday   = date('Y' , $birth_time);
							$age        = $now - $birthday + 1 ;
                                    									
						?>
							<tr>
								<td><input type="checkbox" name="chk" value="<?=$row['user_id']?>:<?=$row['user_email']?>"></td>
								<td><?=$row['m_idx']?></td>
								<td><?=$row['user_level']?></td>
								<td><?=$row['user_id']?></td>
								<td><?=$row['user_name']?></td>
								<td><?=$gender?></td>
								<td><?=$age?></td>
								<td><?=$row['login_count']?></td>
								<td><?=$row['login_date']?></td>
								<td><?=substr($row['r_date'],0,10)?></td>
								<td><?=$row['user_email']?></td>
								<td><?=$email_yn?></td>
							</tr>
						<?}?>

						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

					<div class="inner">		
						<button type="button" class="btn_save02" id="member_select">선택한 회원 추가</button>
					</div><!-- // inner -->

                    <?if ($nTotalCount > 0) { ?>
					<?echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF]."?s_status=$s_status&search_category=$search_category&search_name=$search_name&pg=")?>
                    <? } ?>
                    
					<div style="margin-bottom:20px;"> </div><!-- // headerContainer -->

					<form name="frm_send" id="frm_send" method="post" action="email03_send.php" >
					<input type="hidden" name="send_r" id="send_r" value="">
					<input type="hidden" name="pg" id="pg" value="<?=$pg?>">

					<div class="listBottom email02">
					<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail">
						<caption></caption>
						<colgroup>
							<col width="150px">
							<col width="*">
						</colgroup>

						<tbody>
							<tr style="height:45px;">
								<th>수신대상</th>
								<td><span id="send_id"></span></td>
							</tr>
							<tr style="height:45px;">
								<th>수신E-mail<br>(직접입력)</th>
								<td><textarea name="to_email" id="to_email" cols="30" rows="3" style="height:100px;"></textarea></td>
							</tr>
							<tr style="height:45px;">
								<th>발송자이름</th>
								<td><input type="text" name="send_name" id="send_name" value="<?=$data['home_name']?>"></td>
							</tr>
							<tr style="height:45px;">
								<th>발송자E-mail</th>
								<td><input type="text" name="send_email" id="send_email" value="<?=$data['email']?>"></td>
							</tr>
							<tr style="height:45px;">
								<th>메일제목</th>
								<td><input type="text" name="mail_title" id="mail_title"></td>
							</tr>
							<tr style="height:45px;">
								<th>내용</th>
								<td>
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
                                </td>
								</th>
							</tr>
						</tbody>
					</table>
					<div>
						<button type="button" onclick="send_email_it();" class="btn_save03">발송하기</button>
						<button type="button"  class="btn_save03">미리보기</button>
					</div>
				</div>
				<!-- // listBottom -->
				</div><!-- // listWrap -->
                </form>
			</div><!-- // contents -->





		</span><!-- 인쇄 영역 끝 //-->
		</div><!-- // container -->

<script>
$(document).ready(function(){
    //선택한 회원추가
	
    $("#member_select").click(function(){
		var member_id = "";	
		var member_email = "";	
		var member_r = "";	
		$("input[name=chk]:checked").each(function() {
            member_r += $(this).val() +'|';
            var temp = $(this).val().split(":");
			member_id += '<span>'+temp[0]+'<a href="javascript:id_del(\''+ temp[0] +'\')"><img src="/img/btn/cancel_btn.gif"></a>,</span>';
			member_email += temp[1] +',';
		});
		//alert(member_r);
		//alert(member_id);
		//alert(member_mobile);
		$("#send_r").val(member_r);
		$("#send_id").html(member_id);
		$("#to_email").val(member_email);

	})
    
})
</script>

<script>
function id_del(id)
{
   var member_id = "";	
   var member_email = "";	
   var temp = $("#send_r").val();
   //alert('temp- '+temp);
   var member_r = temp.split("|");
   //alert('id- '+id);
   var send_r = "";   
   var tot = member_r.length; // 배열에 할당된 데이터 갯수 구하기
   //alert('tot- '+tot);
   for (i=0;i<tot-1;i++) {
       var member = member_r[i].split(":");
	   if(id != member[0]) {
			member_id += '<span>'+member[0]+'<a href="javascript:id_del(\''+ member[0] +'\')"><img src="/img/btn/cancel_btn.gif"></a>,</span>';
			member_email += member[1] +',';
			send_r += member[0] +':'+ member[1] +'|';
       }
   }

   $("#send_r").val(send_r);
   $("#send_id").html(member_id);
   $("#to_email").val(member_email);
}
</script>

<script>
$(document).ready(function(){
    //최상단 체크박스 클릭
    $("#checkall").click(function(){
        //클릭되었으면
        if($("#checkall").prop("checked")){
            //input태그의 name이 chk인 태그들을 찾아서 checked옵션을 true로 정의
            $("input[name=chk]").prop("checked",true);
            //클릭이 안되있으면
        }else{
            //input태그의 name이 chk인 태그들을 찾아서 checked옵션을 false로 정의
            $("input[name=chk]").prop("checked",false);
        }
    })
})
</script>


<script>
 function CheckAll(checkBoxes,checked){
    var i;
    if(checkBoxes.length){
        for(i=0;i<checkBoxes.length;i++){
            checkBoxes[i].checked=checked;
        }
    }else{
        checkBoxes.checked=checked;
   }

}

function SELECT_DELETE() {
		if ($(".m_idx").is(":checked") == false)
		{
			alert_("삭제할 내용을 선택하셔야 합니다.");
			return;
		}
		if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false)
		{
			return;
		}

		$("#ajax_loader").removeClass("display-none");

        $.ajax({
			url: "del_deal.php",
			type: "POST",
			data: $("#frm").serialize(),
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
						location.reload();
					return;
				} else {
					alert(response);
					alert_("오류가 발생하였습니다!!");
					return;
				}
			}
        });
 
}

function del_it(idx) {

		if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false)
		{
			return;
		}
		$("#ajax_loader").removeClass("display-none");
        $.ajax({
			url: "del_deal.php",
			type: "POST",
			data: "idx[]="+idx,
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
					location.reload();
					return;
				} else {
					alert(response);
					alert_("오류가 발생하였습니다!!");
					return;
				}
			}
        });
 
}

function chg_it(idx, vals){
	
	
		$("#ajax_loader").removeClass("display-none");
        $.ajax({
			url: "chg_deal.php",
			type: "POST",
			data: "idx="+idx+"&vals="+vals,
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
					alert_("정상적으로 변경되었습니다.");
					location.reload();
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
<script>
$(function() {
	$( ".date_form" ).datepicker({
		showOn: "both",
		dateFormat: 'yy-mm-dd',
		buttonImageOnly: false,
		showButtonPanel: false,
		changeMonth: false, // 월을 바꿀수 있는 셀렉트 박스를 표시한다.
		changeYear: false, // 년을 바꿀수 있는 셀렉트 박스를 표시한다.
		dayNames: ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'],
		dayNamesMin: ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT']
		});
	});



	

</script>

<? include "../_include/_footer.php"; ?>