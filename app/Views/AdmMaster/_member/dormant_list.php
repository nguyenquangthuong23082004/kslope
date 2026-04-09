<? include "../_include/_header.php"; ?>
<?
	$g_list_rows = 20;
	if ($search_name)
	{
		$strSql = $strSql." and replace(".$search_category.",'-','') like '%".str_replace("-","",$search_name)."%' ";
	}

	if ($s_status == "") {
		$s_status = "Y";
	}


	//$strSql = $strSql." and user_level > 1 ";
	
	

	$total_sql = "  
					select *		
					from tbl_member 
					where 1 = 1
					and date_format(login_date, '%Y-%m-%d') <= date_format(DATE_SUB(NOW(), INTERVAL 1 YEAR), '%Y-%m-%d') 
					$strSql 
				";
	
	//echo $total_sql;
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$nTotalCount = mysqli_num_rows($result);
?>
		<div id="container" class="gnb_member">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>휴면회원 리스트</h2>
					<div class="menus">
						<!--ul class="first">
							<li><a href="javascript:CheckAll(document.getElementsByName('m_idx[]'), true)" class="btn btn-success">전체선택</a></li>
							<li><a href="javascript:CheckAll(document.getElementsByName('m_idx[]'), false)" class="btn btn-success">선택해체</a></li>
							<li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li>
						</ul-->

						<ul class="last">
						</ul>
						
					</div>

				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents">
				<form name="search" id="search">		
				<input type="hidden" name="gubun" value="<?=$gubun?>">
				<header id="headerContents">
						<select id="" name="search_category" class="input_select" style="width:112px">
							<option value="user_name" <? if ($search_category == "user_name") {echo "selected"; } ?>>성명</option>
							<option value="user_id" <? if ($search_category == "user_id") {echo "selected"; } ?>>아이디</option>
							<option value="user_email" <? if ($search_category == "user_email") {echo "selected"; } ?>>이메일</option>
							<option value="user_phone" <? if ($search_category == "user_phone") {echo "selected"; } ?>>연락처</option>
						</select>


						<input type="text" id="" name="search_name" value="<?=$search_name?>" class="input_txt placeHolder" rel="검색어 입력" style="width:240px" />

						<a href="javascript:search_it()" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> <span class="txt">검색하기</span></a>
						</header><!-- // headerContents -->
				</form>
				<script>
				function search_it()
				{
					var frm = document.search;
					if (frm.search_name.value == "검색어 입력")
					{
						frm.search_name.value = "";
					}
					frm.submit();
				}
				</script>

				<div class="listWrap">
					<!-- 안내 문구 필요시 구성 //-->

				
				
		

					
					<div class="listTop">
						<div class="left">
							<p class="schTxt">■ 총 <?=number_format($nTotalCount)?>개의 목록이 있습니다.</p>
						</div>

					</div><!-- // listTop -->
					
					
					



					<form name="frm" id="frm">				
					<div class="listBottom">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable">
						<caption></caption>
						<colgroup>
						
						<col width="60px" />
						<col width="70px" />
						<col width="150px" />
						<col width="150px" />
						<col width="100px" />
						<col width="*" />						
						<col width="150px" />
						<col width="150px" />
						<col width="150px" />
						<col width="100px" />
						<col width="200px" />
						<col width="200px" />
						
						</colgroup>
						<thead>
							<tr>
								
								<th>번호</th>
								<th>현황</th>
								<th>아이디</th>
								<th>이름</th>	
								<th>성별</th>
								<th>이메일</th>
								<th>연락처</th>
								<th>처리</th>
								<th>마지막 로그인 일시</th>
								<th>가입일시</th>
								
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
								
								$_genderArr['M'] = "남";
								$_genderArr['W'] = "여";
								
								if ($nTotalCount == 0) {
							?>
							<tr>
								<td colspan=12 style="text-align:center;height:100px">검색된 결과가 없습니다.</td>
							</tr>
							<?
								}
								while($row=mysqli_fetch_array($result)){
									$statusStr = "";
									if ($row["status"] == "1")
									{
										$statusStr = "정상";
									} elseif ($row["status"] == "0") {
										$statusStr = "탈퇴";
									}

									$dormantStr = "";
									if ($row["dormant"] == "1")
									{
										$dormantStr = "휴면메일전송";
									} elseif ($row["dormant"] == "2") {
										$dormantStr = "탈퇴처리";
									}



									
							?>
							<tr style="height:50px">
								
								<td><?=$num--?></td>
								<td class="tac"><?=$statusStr?></td>
								<td class="tac"><?=$row["user_id"]?></td>
								<td class="tac"><?=$row["user_name"]?></td>
								<td class="tac"><?=$_genderArr[$row["gender"]]?></td>
								<td class="tac"><?=$row["user_email"]?></td>
								<td class="tac"><?=$row["user_mobile"]?></td>
								<td class="tac"><?=$dormantStr?></td>
								<td class="tac"><?=$row["login_date"]?></td>
								<td class="tac"><?=$row["r_date"]?></td>
								
							</tr>
							<?  } ?>




							
						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

					<?echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF]."?s_status=$s_status&search_category=$search_category&search_name=$search_name&pg=")?>


					<div id="headerContainer">
						
						<div class="inner">
							<div class="menus">
								<!--ul class="first">
									<li><a href="javascript:CheckAll(document.getElementsByName('m_idx[]'), true)" class="btn btn-success">전체선택</a></li>
									<li><a href="javascript:CheckAll(document.getElementsByName('m_idx[]'), false)" class="btn btn-success">선택해체</a></li>
									<li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li>
								</ul-->

								<ul class="last">
								</ul>
								
							</div>

						</div><!-- // inner -->

					</div><!-- // headerContainer -->
				</div><!-- // listWrap -->

			</div><!-- // contents -->





		</span><!-- 인쇄 영역 끝 //-->
		</div><!-- // container -->

<div class="mileage_popup mc_popup">
	<section class="">
            <h2></h2>
			<a href="#!" class="mc_close_popup"><img src="/AdmMaster/_images/common/top_close.png" alt=""></a>
            <form name="frm" id="frm">				
					<div class="listBottom" id="select_cash">
						<!--
						<table cellpadding="0" cellspacing="0" summary="" class="listTable">
						<caption></caption>
						<colgroup>
							<col width="100px">
							<col width="100px">
							<col width="190px">
							<col width="*">
							<col width="150px">
							<col width="150px">
						</colgroup>
						<thead>
							<tr>
								<th>번호</th>
								<th>아이디</th>
								<th>지급사유</th>	
								<th>적용포인트</th>
								<th>누적포인트</th>
								<th>최종적용일</th>
							</tr>
						</thead>	
						<tbody>
							<tr style="height:50px;  ">
								<td>93277</td>
								<td class="tac">wldndruddn</td>
								<td class="tac">수취확인으로 인한 포인트 적립</td>
								<td class="tac"></td>
								<td class="tac">5,940</td>
								<td class="tac">2018-06-18 15:10:36</td>
							</tr>
							
						</tbody>
						</table>
						-->
						<?//echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF]."?s_status=$s_status&search_category=$search_category&search_name=$search_name&pg=")?>
					</div><!-- // listBottom -->
			</form>
	</section>

</div>



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
			url: "del.php",
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

function del_it(m_idx) {

		if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false)
		{
			return;
		}
		$("#ajax_loader").removeClass("display-none");
        $.ajax({
			url: "del.php",
			type: "POST",
			data: "m_idx[]="+m_idx,
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


</script>
<script>

	function view_m(user_id, pg=1){
		$('.mileage_popup').css({'display':'block'});
		$('html').css({'overflow': 'hidden', 'height': '100%'}); 
		$('#element').on('scroll touchmove mousewheel', function(event) {  event.preventDefault();  event.stopPropagation();   return false; });
		

		$.ajax({
			url: "getpoint.php",
			type: "POST",
			data: "user_id="+user_id+"&pg="+pg,
			error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				$("#ajax_loader").addClass("display-none");
			}
			,complete: function(request, status, error) {
//				$("#ajax_loader").addClass("display-none");
			}
			, success : function(response, status, request) {
				$("#select_cash").html(response);
			}
        });


	}


	function view_c(user_id, pg=1){
		$('.cupon_popup').css({'display':'block'});
		$('html').css({'overflow': 'hidden', 'height': '100%'}); 
		$('#element').on('scroll touchmove mousewheel', function(event) {  event.preventDefault();  event.stopPropagation();   return false; });

		$.ajax({
			url: "getcoupon.php",
			type: "POST",
			data: "user_id="+user_id+"&pg="+pg,
			error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				$("#ajax_loader").addClass("display-none");
			}
			,complete: function(request, status, error) {
//				$("#ajax_loader").addClass("display-none");
			}
			, success : function(response, status, request) {
				$("#select_coupon").html(response);
			}
        });

	}


	$(window).load(function(){
		/*
		$('.open_popup').on('click',function(){
			
			if($(this).hasClass('m_popup')){
				$('.mileage_popup').css({'display':'block'});
			}else if($(this).hasClass('c_popup')){
				$('.cupon_popup').css({'display':'block'});
			}
			$('html').css({'overflow': 'hidden', 'height': '100%'}); 
			$('#element').on('scroll touchmove mousewheel', function(event) {  event.preventDefault();  event.stopPropagation();   return false; });
			
		});
		*/


		
		$('.mc_close_popup').on('click',function(){
			$('.mc_popup').css({'display':'none'});
			$('html').css({'overflow': 'auto', 'height': '100%'}); 
			$('#element').off('scroll touchmove mousewheel');

			$("#select_cash").html("");
			$("#select_coupon").html("");

		});

		$('.mc_popup').on('click',function(e){
			
			if ($(e.target).hasClass('mc_popup')) {

				 $('.mc_popup').css({'display':'none'});
			}
			$('html').css({'overflow': 'auto', 'height': '100%'}); 
			$('#element').off('scroll touchmove mousewheel');

		});
	});
</script>


<? include "../_include/_footer.php"; ?>