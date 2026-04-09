<? include "../_include/_header.php"; ?>
<?
    // 발신정보 참조
	$sql    = " select * from tbl_homeset ";
	$result = mysqli_query($connect, $sql) or die (mysql_error());
    $data   = mysqli_fetch_array($result);

    $search_val  = "?ft=". $ft ."&gubun=". $gubun ."&user_email_yn=". $user_email_yn . "&nowPrice1=". $nowPrice1 ."&nowPrice2=". $nowPrice2; 
	$search_val .= "&age1=". $age1 ."&age2=". $age2 ."&nowPoint1=". $nowPoint1 ."&nowPoint2=". $nowPoint2 ."&s_date=". $s_date ."&e_date=". $e_date;
	$search_val .= "&login_count1=". $login_count1 ."&login_count2=". $login_count2 ."&con_date1=". $con_date1 ."&con_date2=". $con_date2;
	$search_val .= "&s_date=". $s_date ."&e_date=". $e_date;



	


?>
<!-- 에디터 사용에 필요한 js 인크루드 -->
<script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js"></script>

		<div id="container" class="gnb_member">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2><a href="/AdmMaster/_member/email02.php">개별/단체 메일발송</a></h2>
					<div class="menus">
						<ul class="first">
							<? include "./email_menu.php"; ?>
						</ul>
					</div>
				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents email_container">
				<form name="search" id="search">		
				<input type="hidden" name="ft" value="Y">
				<input type="hidden" name="gubun" value="<?=$gubun?>">
					<header id="" class="width_96">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable01 email_form01" style="table-layout:fixed;">
							<colgroup>
								<col width="130px">
								<col width="*">
								<col width="130px">
								<col width="*">
							</colgroup>
							<tbody>
								<tr>
									<td class="label">회원등급</td>
									<td class="inbox">
										<select name="user_email_yn" id="user_email_yn">
										    <? if($user_email_yn == "Y") { ?>
											<option value="">선택</option>
											<option value="">전체회원</option>
											<option value="Y" selected>수신동의회원</option>
											<? } else { ?>
											<option value="">선택</option>
											<option value="">전체회원</option>
											<option value="Y">수신동의회원</option>
											<? } ?>
										</select>
									</td>
									<td class="label">성별</td>
									<td class="inbox">
									    <? if($gender == "M") { ?>
										<label for="s_1"><input type="radio" id="gender_all" name="gender" value="">전체</label>
										<label for="s_1"><input type="radio" id="gender_m"   name="gender" value="M" checked>남자</label>
										<label for="s_2"><input type="radio" id="gender_w"   name="gender" value="W">여자</label>
										<? } else if($gender == "W") { ?>
										<label for="s_1"><input type="radio" id="gender_all" name="gender" value="">전체</label>
										<label for="s_1"><input type="radio" id="gender_m"   name="gender" value="M">남자</label>
										<label for="s_2"><input type="radio" id="gender_w"   name="gender" value="W" checked>여자</label>
										<? } else { ?>
										<label for="s_1"><input type="radio" id="gender_all" name="gender" value="">전체</label>
										<label for="s_1"><input type="radio" id="gender_m"   name="gender" value="M">남자</label>
										<label for="s_2"><input type="radio" id="gender_w"   name="gender" value="W">여자</label>
										<? } ?>
									</td>

								</tr>
								<tr>
									<td class="label">구매총액</td>
									<td class="inbox">
										<input type="text" name="nowPrice1" value="<?=$nowPrice1?>" ><span>원 ~</span> 
										<input type="text" name="nowPrice2" value="<?=$nowPrice2?>" ><span>원</span> 
									</td>
									<td class="label">연령</td>
									<td class="inbox age">
										<input type="text" name="age1" value="<?=$age1?>"><span>세 ~</span> 
										<input type="text" name="age2" value="<?=$age2?>">><span>세</span> 
									</td>
								</tr>
								<tr>
									<td class="label">포인트</td>
									<td class="inbox">
										<input type="text" name="nowPoint1" value="<?=$nowPoint1?>"><span>점 ~</span> 
										<input type="text" name="nowPoint2" value="<?=$nowPoint2?>"><span>점</span> 
									</td>
									<td class="label">최종접속일</td>
									<td class="inbox">
	
										<div class="contact_btn_box">
											<div>
												<button type="button" onclick="condate_set('7');" class="contact_btn" title="week">7일</button>
												<button type="button" onclick="condate_set('30');"  class="contact_btn" title="1month">1개월</button>
												<button type="button" onclick="condate_set('90');" class="contact_btn" title="3month">3개월</button>
												<button type="button" rel="<?=date('Y-m-d', strtotime('-1 year'));?>" class="contact_btn" title="year">전체</button>
												<input type="text" name="con_date1" id="con_date1" value="<?=$con_date1?>" class="date_form" ><span>~</span>
												<input type="text" name="con_date2" id="con_date2" value="<?=$con_date2?>" class="date_form" >
											</div>
										</div>
									</td>
								</tr>
										
								<tr>
									<td class="label">가입일</td>
									<td class="inbox">
										<div class="contact_btn_box">
											<div>
												<button type="button" onclick="regdate_set('7');"  class="contact_btn" title="week">7일</button>
												<button type="button" onclick="regdate_set('30');" class="contact_btn" title="1month">1개월</button>
												<button type="button" onclick="regdate_set('90');" class="contact_btn" title="3month">3개월</button>
												<button type="button" rel="<?=date('Y-m-d', strtotime('-1 year'));?>" class="contact_btn" title="year">전체</button>
												<input type="text" name="s_date" id="s_date" value="<?=$s_date?>" class="date_form" ><span>~</span>
												<input type="text" name="e_date" id="e_date" value="<?=$e_date?>" class="date_form" >
											</div>
										</div>
									</td>
									<td class="label">접속횟수</td>
									<td class="inbox visit_count">
										<input type="text" name="login_count1" value="<?=$login_count1?>"><span>회 ~</span> 
										<input type="text" name="login_count2" value="<?=$login_count2?>"><span>회</span> 
									</td>
								</tr>
								
								<tr>
									<td class="label">발송대상</td>
									<td class="inbox">	
										<div class="r_box">
											<select id="" name="search_category" class="input_select">
												<option value="receive_name" <?if($search_category=="receive_name")echo"selected";?> >::발송대상::</option>
												<option value="receive_name" <?if($search_category=="receive_name")echo"selected";?> >조건검색</option>
												<option value="order_code" <?if($search_category=="order_code")echo"selected";?> >전체발송</option>
												<option value="user_id" <?if($search_category=="user_id")echo"selected";?> selected >수신동의</option>
											</select>			
										</div>
									</td>
									<td class="label"></td>
									<td class="inbox"></td>
								</tr>
							</tbody>
						</table>
						<a href="javascript:search_it()" class="btn btn-default btn_email"><span class="glyphicon glyphicon-search"></span> <span class="txt">검색</span></a>
					</header><!-- // headerContents -->
				</form>

				<script>
				function search_it()
				{
					var frm = document.search;

					frm.submit();
				}

				function condate_set(days)
				{
					var ilsu = days*1; 
					var date = new Date();
					var nowDate = date.getFullYear() + '-' + fn_leadingZeros(date.getMonth() + 1, 2) + '-' + fn_leadingZeros(date.getDate(), 2);
					$("#con_date2").val(nowDate);

					nowDate = nowDate.split("-");
					var beforeDate = new Date();
					beforeDate.setFullYear(nowDate[0], nowDate[1]-1, nowDate[2]-ilsu);
					var y = beforeDate .getFullYear();
					var m = beforeDate.getMonth() + 1;
					var d = beforeDate.getDate();
					if(m < 10) { m = "0" + m; }
					if(d < 10) { d = "0" + d; }
					beforeDate = y + "-" + m + "-" + d;
                    $("#con_date1").val(beforeDate);
                }

				function regdate_set(days)
				{
					var ilsu = days*1; 
					var date = new Date();
					var nowDate = date.getFullYear() + '-' + fn_leadingZeros(date.getMonth() + 1, 2) + '-' + fn_leadingZeros(date.getDate(), 2);
					$("#e_date").val(nowDate);

					nowDate = nowDate.split("-");
					var beforeDate = new Date();
					beforeDate.setFullYear(nowDate[0], nowDate[1]-1, nowDate[2]-ilsu);
					var y = beforeDate .getFullYear();
					var m = beforeDate.getMonth() + 1;
					var d = beforeDate.getDate();
					if(m < 10) { m = "0" + m; }
					if(d < 10) { d = "0" + d; }
					beforeDate = y + "-" + m + "-" + d;
                    $("#s_date").val(beforeDate);
                }

                function fn_leadingZeros(n, digits) {

			        var zero = '';
			        n = n.toString();
			        if (n.length < digits) {
 			           for (var i = 0; i < digits - n.length; i++){ zero += '0'; }
			        }

			        return zero + n;
 		        }
				</script>
<?
    $strSql = "";

    if($user_email_yn)                 $strSql .= " and user_email_yn = '{$user_email_yn}' ";  
    if($gender)                        $strSql .= " and gender = '{$gender}' ";  
    if($nowPrice1 && $nowPrice2)       $strSql .= " and (nowPrice between '{$nowPrice1}' and '{$nowPrice2}'  ) ";
    if($age1 && $age2)                 $strSql .= " and  ( (left(curdate(),4) - left(m.birthday,4) + 1)  between '{$age1}' and '{$age2}' )"; 
    if($nowPoint1 && $nowPoint2)       $strSql .= " and (nowPoint between '{$nowPoint1}' and '{$nowPoint2}'  ) ";
    if($login_count1 && $login_count2) $strSql .= " and (login_count between '{$login_count1}' and '{$login_count2}'  ) ";
    if($s_date && $e_date) {
       $fr_date = $s_date ." 00:00:00";  
       $to_date = $e_date ." 11:59:59"; 
       $strSql .= " and (m.r_date between '{$fr_date}' and '{$to_date}') ";
    }
    if($con_date1 && $con_date2) {
       $fr_date .= $con_date1 ." 00:00:00";  
       $to_date .= $con_date2 ." 11:59:59"; 
       $strSql  .= " and (m.login_date between '{$fr_date}' and '{$to_date}') ";
    }

	$g_list_rows = 40;
	$total_sql = " SELECT m.*
						, p.nowPoint
						, o.nowPrice
						, ( left(curdate(),4) - left(m.birthday,4) + 1) as olds
				     FROM tbl_member m
				     LEFT OUTER JOIN (select sum(point) as nowPoint, user_id from tbl_point group by user_id) p
					   ON m.user_id = p.user_id
				     LEFT OUTER JOIN (select sum(total_price) as nowPrice, user_id from tbl_order where status = 'M' group by user_id ) o
					   ON m.user_id = o.user_id
					WHERE m.status = 1 and m.user_email != '' $strSql ";
    //echo $total_sql;
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$nTotalCount = mysqli_num_rows($result);
	$num = $nTotalCount;


?>

				<div class="listWrap email_container email_container02">
					<!-- 안내 문구 필요시 구성 //-->
		
					<div class="listTop">
						<div class="left">
							<p class="schTxt"> 총 <?=number_format($nTotalCount)?>명 발송대상</p>
						</div>

					</div><!-- // listTop -->
					
					<form name="frm" id="frm">	
					<div class="listBottom email01">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable">
						<caption></caption>
						<colgroup>
						<col width="" />
						<col width="" />
						<col width="" />
						<col width="" />
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

							$sql    = $total_sql . " order by m.m_idx desc limit $nFrom, $g_list_rows ";
							$result = mysqli_query($connect, $sql) or die (mysql_error());
							$num    = $nTotalCount - $nFrom;
							
						if ($nTotalCount == 0) {
						?>
						<tr>
							<td colspan=14 style="text-align:center;height:100px">검색된 결과가 없습니다.</td>
						</tr>
						<?
						} else {	
						  while($row = mysqli_fetch_array($result)) {
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

						?>
							<tr>
								<td><input type="checkbox" name="chk" value="<?=$row['user_id']?>:<?=$row['user_email']?>"></td>
								<td><?=$row_num?></td>
								<td><?=$row['user_level']?></td>
								<td><?=$row['user_id']?></td>
								<td><?=$row['user_name']?></td>
								<td><?=$gender?></td>
								<td><?=$row['olds']?></td>
								<td><?=$row['login_count']?></td>
								<td><?=$row['login_date']?></td>
								<td><?=substr($row['r_date'],0,10)?></td>
								<td><?=$row['user_email']?></td>
								<td><?=$email_yn?></td>
							</tr>
						<? } ?>
					   <? } ?>		
						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

					<div class="inner">		
						<button type="button" class="btn_save02" id="member_select">선택한 회원 추가</button>
					</div><!-- // inner -->

                    <?if ($nTotalCount > 0) { ?>
					<?echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF].$search_val ."&s_status=$s_status&search_category=$search_category&search_name=$search_name&pg=")?>
                    <? } ?>
					
					<div style="margin-bottom:20px;"></div>

					<div class="listBottom email02">
					<form name="frm_send" id="frm_send" method="post" action="email02_send.php" >
					<input type="hidden" name="send_r" id="send_r" value="">
					<input type="hidden" name="pg" id="pg" value="<?=$pg?>">
					<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail">
						<caption></caption>
						<colgroup>
							<col width="150px">
							<col width="*">
						</colgroup>

						<tbody>
							<tr style="height:45px;">
								<th>수신대상</th>
								<td><span id="send_cnt"></span> 명</td>
							</tr>
							<tr style="height:45px;">
								<th>수신아이디</th>
								<td><span id="send_id"></span></td>
							</tr>
							<tr style="height:45px;">
								<th>수신 E-mail(직접입력)</th>
								<td><textarea name="to_email" id="to_email" cols="30" rows="3" style="height:100px;"></textarea>
								<br><span style="color:red;">bonto-netie@naver.com, 메일 직접입 력시 끝에 콤아','를 꼭 넣으셔야합니다.</span>
								</td>
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
								<td><input type="text" name="mail_title" id="mail_title" value=""></td>
							</tr>
							<tr style="height:45px;">
								<th>내용</th>
								<td>
									<textarea name="content" id="content_" rows="10" cols="100" class="input_txt" style="width:100%; height:400px; display:none;"></textarea>

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
						<button type="button" onclick="preview();"  class="btn_save03">미리보기</button>
					</div>
				</div>
				<!-- // listBottom -->
				</div><!-- // listWrap -->
                </form>
			</div><!-- // contents -->

		</span><!-- 인쇄 영역 끝 //-->
		</div><!-- // container -->

<script>
function send_email_it()
{
	var frm = document.frm_send;

	if(!$("#to_email").val()) {
		if(!confirm("수신 이메일 미선택 시에 전체 발송됩니다.\r발송하시겠습니가?")){
			return false;
		}
	}
	/*
	if(!$("#to_email").val()) {
		alert('수신E-mail을 입력하세요');
		$("#to_email").focus();
		return false;
	}
	*/

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

<script>
$(document).ready(function(){
    //선택한 회원추가
	
    $("#member_select").click(function(){
		var member_id = "";	
		var member_email = "";	
		var member_r = "";	
		var cnt = 0;
		$("input[name=chk]:checked").each(function() {
			cnt++;
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
		$("#send_cnt").text(cnt);

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
   var cnt = 0;
   for (i=0;i<tot-1;i++) {
       var member = member_r[i].split(":");
	   if(id != member[0]) {
		    cnt++;
			member_id += '<span>'+member[0]+'<a href="javascript:id_del(\''+ member[0] +'\')"><img src="/img/btn/cancel_btn.gif"></a>,</span>';
			member_email += member[1] +',';
			send_r += member[0] +':'+ member[1] +'|';
       }
   }

   $("#send_r").val(send_r);
   $("#send_id").html(member_id);
   $("#to_email").val(member_email);
   $("#send_cnt").text(cnt);
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

function preview(){
	
	oEditors1.getById["content_"].exec("UPDATE_CONTENTS_FIELD", []);
	var divObj = $("#content_");
	
	var printDivObj = divObj.val();

	var tempObj = window.open('',"printName","width=1016,height=500,scrollbars=yes");

    
    tempObj.document.open();
	tempObj.document.write(printDivObj);
	tempObj.document.close();





}	


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