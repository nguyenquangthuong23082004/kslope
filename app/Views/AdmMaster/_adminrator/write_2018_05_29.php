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
function checkForNumber(str) {
	var key = event.keyCode;
	var frm = document.frm1;
	if(!(key==8||key==9||key==13||key==46||key==144||
	(key>=48&&key<=57)||(key>=96&&key<=105)||key==110||key==190)) {
		event.returnValue = false;
	}
}
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


<div id="container"> <span id="print_this"><!-- 인쇄영역 시작 //-->
	
	<header id="headerContainer">
		<div class="inner">
			<h2><?=$tit?></h2>
			<div class="menus">
				<ul>
					<li><a href="javascript:history.back();" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a></li>
					<li><a href="javascript:send_it()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">등록</span></a></li>
										
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
								<input type="text" name="user_id" value="<?=$row['user_id']?>" id="user_id" class="half frm_input" maxlength="20" style="ime-mode:disabled" <?=$readonly?> >

								<? if($readonly == "") { ?>
								<a href="javascript:id_check();" class="btn btn-default"><span class="txt">중복확인</span></a>
								<? } ?>
							</td>
							<th>비밀번호</th>
							<td><input type="password" name="user_pw" value="" class="bbs_inputbox_pixel" style="width:200px" maxlength="50/"></td>
						</tr>
						<tr height="45">
							<th>이름</th>
							<td><input type="text" name="user_name" value="<?=$row['user_name']?>" class="bbs_inputbox_pixel" style="width:200px" maxlength="50/"></td>
							<th>휴대폰</th>
							<td><input type="text" name="user_mobile" value="<?=$row['user_mobile']?>" class="text" style="width:200px"></td>
						</tr>
						<tr height="45">
							<th>현황</th>
							<td colspan="3">
								<select name="status">
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
									<tbody><tr style="height:45px">
										<td style="width:120px;text-align:center;background-color:#fafafa;font-weight:bold;color:#000000">고객센터</td>
										<td>
											<input type="checkbox" name="auth[]" value="A01" id="A01"> <label for="A01">본토소식</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="A02" id="A02"> <label for="A02">자주묻는질문</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="A03" id="A03"> <label for="A03">A/S</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="A04" id="A04"> <label for="A04">이벤트</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										</td>
									</tr>
									<tr style="height:45px">
										<td style="width:120px;text-align:center;background-color:#fafafa;font-weight:bold;color:#000000">회원관리</td>
										<td>
											<input type="checkbox" name="auth[]" value="B01" id="B01"> <label for="B01">회원관리</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="B02" id="B02"> <label for="B02">회원 적립금 관리</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										</td>
									</tr>
									<tr style="height:45px">
										<td style="width:120px;text-align:center;background-color:#fafafa;font-weight:bold;color:#000000">문의</td>
										<td>
											<input type="checkbox" name="auth[]" value="C01" id="C01"> <label for="C01">박리다매DEAL</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="C02" id="C02"> <label for="C02">예약판매</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="C03" id="C03"> <label for="C03">1:1문의하기</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="C04" id="C04"> <label for="C03">제휴상담/신청</label>
										</td>
									</tr>
									<tr style="height:45px">
										<td style="width:120px;text-align:center;background-color:#fafafa;font-weight:bold;color:#000000">코드관리</td>
										<td>
											<input type="checkbox" name="auth[]" value="D01" id="D01"> <label for="D01">카테고리</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="D02" id="D02"> <label for="D02">분류</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="D03" id="D03"> <label for="D03">브랜드</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="D04" id="D04"> <label for="D04">상품사이즈 그룹관리</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="D05" id="D05"> <label for="D05">상품사이즈</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="D06" id="D06"> <label for="D06">색상관리</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="D07" id="D07"> <label for="D07">아이콘관리</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="D08" id="D08"> <label for="D08">대표색상코드관리</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										</td>
									</tr>
									<tr style="height:45px">
										<td style="width:120px;text-align:center;background-color:#fafafa;font-weight:bold;color:#000000">상품관리</td>
										<td>
											<input type="checkbox" name="auth[]" value="E01" id="E01"> <label for="E01">상품관리</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										</td>
									</tr>
									<tr style="height:45px">
										<td style="width:120px;text-align:center;background-color:#fafafa;font-weight:bold;color:#000000">주문관리</td>
										<td>
											<input type="checkbox" name="auth[]" value="F01" id="F01"> <label for="F01">주문관리</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										</td>
									</tr>
									<tr style="height:45px">
										<td style="width:120px;text-align:center;background-color:#fafafa;font-weight:bold;color:#000000">팝업관리</td>
										<td>
											<input type="checkbox" name="auth[]" value="G01" id="G01"> <label for="G01">팝업관리</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										</td>
									</tr>
									<tr style="height:45px">
										<td style="width:120px;text-align:center;background-color:#fafafa;font-weight:bold;color:#000000">기본설정</td>
										<td>
											<input type="checkbox" name="auth[]" value="H01" id="H01"> <label for="H01">쇼핑몰 기본설정</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="H02" id="H02"> <label for="H02">운영자 계정관리</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="H03" id="H03"> <label for="H03">정책 설정</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="H04" id="H04"> <label for="H04">배송사관리</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="H05" id="H05"> <label for="H05">약관 및 정책</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										</td>
									</tr>
									<tr style="height:45px">
										<td style="width:120px;text-align:center;background-color:#fafafa;font-weight:bold;color:#000000">운영관리</td>
										<td>
											<input type="checkbox" name="auth[]" value="I01" id="I01"> <label for="I01">쿠폰관리</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="I02" id="I02"> <label for="I02">쿠폰설정</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="I03" id="I03"> <label for="I03">TOP5</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="I04" id="I04"> <label for="I04">인기상품</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="I05" id="I05"> <label for="I05">배너관리</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="I06" id="I06"> <label for="I06">박리다매 DEAL</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="I07" id="I07"> <label for="I07">본토회원DEAL</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="I08" id="I08"> <label for="I08">본토장터</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="I09" id="I09"> <label for="I09">9장 DEAL</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="I10" id="I10"> <label for="I10">예약판매</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="I11" id="I11"> <label for="I11">매장관리</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										</td>
									</tr>
									<tr style="height:45px">
										<td style="width:120px;text-align:center;background-color:#fafafa;font-weight:bold;color:#000000">재고관리</td>
										<td>
											<input type="checkbox" name="auth[]" value="J01" id="J01"> <label for="J01">재고관리</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="J02" id="J02"> <label for="J02">본사 재고추가</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="J03" id="J03"> <label for="J03">대리점 재고관리</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="auth[]" value="J04" id="J04"> <label for="J04">매장재고현황</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											
										</td>
									</tr>
									
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

						<a href="javascript:history.back();" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a>
							
						<a href="javascript:send_it()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">등록</span></a>
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
<script>

	$(document).on("click",".mIdx",function(){  
		$(this).parent().remove();

		var agent_idx = "";
		for(j=0 ; j < $(".mIdx").length ; j++)
		{
			agent_idx = agent_idx+"||"+$(".mIdx:eq("+j+")").attr("data-idx");
		}
		$("#agent_idx").val(agent_idx);

	})


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
</script> 
<!-- iOS에서는 position:fixed 버그가 있음, 적용하는 사이트에 맞게 position:absolute 등을 이용하여 top,left값 조정 필요 -->
<div id="layer" style="display:none;position:fixed;overflow:hidden;z-index:1;-webkit-overflow-scrolling:touch;">
<img src="//t1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()" alt="닫기 버튼">
</div>


<script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script><script charset="UTF-8" type="text/javascript" src="http://t1.daumcdn.net/cssjs/postcode/1522037570977/180326.js"></script>
<script>
    // 우편번호 찾기 화면을 넣을 element
    var element_layer = document.getElementById('layer');

    function closeDaumPostcode() {
        // iframe을 넣은 element를 안보이게 한다.
        element_layer.style.display = 'none';
    }

    function execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var fullAddr = data.address; // 최종 주소 변수
                var extraAddr = ''; // 조합형 주소 변수

                // 기본 주소가 도로명 타입일때 조합한다.
                if(data.addressType === 'R'){
                    //법정동명이 있을 경우 추가한다.
                    if(data.bname !== ''){
                        extraAddr += data.bname;
                    }
                    // 건물명이 있을 경우 추가한다.
                    if(data.buildingName !== ''){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                    fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('company_zip').value = data.zonecode; //5자리 새우편번호 사용
				//$(".addr_txt").text(fullAddr);
                document.getElementById('company_addr1').value = fullAddr;
                document.getElementById('company_addr2').focus();
                document.getElementById('company_sido').value = data.sido;
                document.getElementById('company_sigungu').value = data.sigungu;
                document.getElementById('company_dong').value = data.bname2;

                // iframe을 넣은 element를 안보이게 한다.
                // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
                element_layer.style.display = 'none';
            },
            width : '100%',
            height : '100%'
        }).embed(element_layer);

        // iframe을 넣은 element를 보이게 한다.
        element_layer.style.display = 'block';

        // iframe을 넣은 element의 위치를 화면의 가운데로 이동시킨다.
        initLayerPosition();
    }

    // 브라우저의 크기 변경에 따라 레이어를 가운데로 이동시키고자 하실때에는
    // resize이벤트나, orientationchange이벤트를 이용하여 값이 변경될때마다 아래 함수를 실행 시켜 주시거나,
    // 직접 element_layer의 top,left값을 수정해 주시면 됩니다.
    function initLayerPosition(){
        var width = 300; //우편번호서비스가 들어갈 element의 width
        var height = 460; //우편번호서비스가 들어갈 element의 height
        var borderWidth = 5; //샘플에서 사용하는 border의 두께

        // 위에서 선언한 값들을 실제 element에 넣는다.
        element_layer.style.width = width + 'px';
        element_layer.style.height = height + 'px';
        element_layer.style.border = borderWidth + 'px solid';
        // 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
        element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width)/2 - borderWidth) + 'px';
        element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height)/2 - borderWidth) + 'px';
    }
</script>

<script>
    

	function id_check()
	{
		if ($('#user_id').val().length < 6 )
		{
			$('#user_id').focus();
			alert("아이디는 6자 이상 등록해주셔야 합니다.");
			return;
		}

        $.ajax({
			url: "/member/adminrator_id_chk_ajax.php",
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
<iframe width="300" height="300" name="hiddenFrame" id="hiddenFrame" src="" style="display:none;"></iframe>

		<footer id="footer">
			<!--
			<p class="tel"><img src="/AdmMaster/_images/common/tel.png" alt="시스템 이용관련 문의 02.3667.6635" /></p>
			-->
			<p class="btnTop"><a href="#" class="scrollTop"><img src="/AdmMaster/_images/common/btn_scrolltop.png" alt="top"></a></p>
		</footer><!-- // footer -->


	</div>

<? include "../_include/_footer.php"; ?>