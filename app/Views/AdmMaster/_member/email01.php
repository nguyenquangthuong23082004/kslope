<? include "../_include/_header.php"; ?>
<?
	$g_list_rows = 10;


	$total_sql = " select *
	                 from tbl_auto_mail_skin
					where 1=1  ";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$nTotalCount = mysqli_num_rows($result);
?>
		<div id="container" class="gnb_member">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>자동메일관리</h2>
					<div class="menus">
						<ul class="first">
							<? include "./email_menu.php"; ?>
							
						</ul>
					</div>
				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents">
				

				<div class="listWrap">
					<!-- 안내 문구 필요시 구성 //-->
					
					<div class="listTop">
						<div class="left">
							<p class="schTxt">■ 총 <?=$nTotalCount?>개의 목록이 있습니다.</p>
						</div>

					</div><!-- // listTop -->
					
					
					



					<form name="frm" id="frm">				
					<div class="listBottom">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable">
						<caption></caption>
						<colgroup>
						<col width="15%" />
						<col width="55%" />
						<col width="15%" />
						<col width="15%" />
						</colgroup>
						<thead>
							<tr>
								<th>메일코드</th>
								<th>메일명</th>
								<th>미리보기</th>
								<th>자동발송여부</th>
							</tr>
						</thead>	
						<tbody>


						<?
							$nPage = ceil($nTotalCount / $g_list_rows);
							if ($pg == "") $pg = 1;
							$nFrom = ($pg - 1) * $g_list_rows;

							//$sql    = $total_sql . " order by idx desc limit $nFrom, $g_list_rows ";	페이징 제거
							$sql    = $total_sql . " order by idx desc  ";
							$result = mysqli_query($connect, $sql) or die (mysql_error());
							$num = $nTotalCount - $nFrom;
							
						
							
							if ($nTotalCount == 0) {
						?>
						<tr>
							<td colspan=4 style="text-align:center;height:100px">검색된 결과가 없습니다.</td>
						</tr>
						<?
							}
							while($row=mysqli_fetch_array($result)){
						?>


							<tr>
								<td><?=$row['code']?></td>
								<td><a href="email01_view.php?idx=<?=$row['idx']?>"><?=$row['title']?></a></td>
								<td><a href="javascript:void(0)" class="btn_preview" rel="<?=$row['idx']?>" >미리보기</a></td>
								<td>
								<?
									if($row['autosend'] == "Y"){
										echo "자동발송";
									}else{
										echo "사용안함";
									}
								?>
								</td>
							</tr>

						<?  } ?>


						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

					<?//echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF]."?s_status=$s_status&search_category=$search_category&search_name=$search_name&pg=")?>


					<div id="headerContainer">
						
						<div class="">
							<div class="menus">
								<ul class="first">
									
								</ul>

							</div>

						</div><!-- // inner -->

					</div><!-- // headerContainer -->
				</div><!-- // listWrap -->

			</div><!-- // contents -->





		</span><!-- 인쇄 영역 끝 //-->
		</div><!-- // container -->
		<div class="preview_popup">
			<div class="popup_box">
				<div style="height:500px;">
					<iframe style="width:100%;height:100%;" name="previews" id="previews" src="" ></iframe>
				</div>
				<a href="javascript:void(0)" class="close_popup">CLOSE</a>
			</div>
			
		</div>
		<script>
			$(document).ready(function(){
				$('.btn_preview').on('click',function(){
					var tmp_idx = $(this).attr("rel");
					$("#previews").prop("src","/AdmMaster/_member/pre_viw_mail.php?idx="+tmp_idx);
					$('.preview_popup').css({'display':'block'});
				});

				$('.close_popup').on('click',function(){
					$("#previews").prop("src","");
					$('.preview_popup').css({'display':'none'});
				});

				$('.preview_popup').click(function(e){
					if ($(e.target).hasClass('preview_popup')) {
								//alert(33);
						$("#previews").prop("src","");
						$('.preview_popup').css({'display':'none'});
					}
				});
			});
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


<? include "../_include/_footer.php"; ?>