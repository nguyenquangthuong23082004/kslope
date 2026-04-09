<? include "../_include/_header.php"; ?>
<script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js"></script>
<?
	$idx				= updateSQ($_GET["idx"]);
	
	$titleStr = "추가";
	
	if ($idx) {
		$total_sql			= " select * from tbl_adminIP where idx='".$idx."'";
		$result				= mysqli_query($connect, $total_sql) or die (mysql_error());
		$row				= mysqli_fetch_array($result);

		$ip			= $row["ip"];
		$use		= $row["useYN"];
		$memo		= $row["memo"];

		$_tmp_ip = explode(".",$ip);
		
		$titleStr = "수정";
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
	
	if (frm.ip1.value == "")
	{
		frm.ip1.focus();
		alert("아이피를 입력하셔야 합니다.");
		return;
	}

	if (frm.ip2.value == "")
	{
		frm.ip2.focus();
		alert("아이피를 입력하셔야 합니다.");
		return;
	}

	if (frm.ip3.value == "")
	{
		frm.ip3.focus();
		alert("아이피를 입력하셔야 합니다.");
		return;
	}

	if (frm.ip4.value == "")
	{
		frm.ip4.focus();
		alert("아이피를 입력하셔야 합니다.");
		return;
	}

	frm.submit();
}

</script>

<div class="page-heading mb-4">
    
    <div class="d-flex justify-content-between align-items-center">
        <header class="d-block d-xl-none pb-2">
            <a href="#" class="d-block burger-btn d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <h4 class="text-center">관리자 접속 IP <?=$titleStr?></h4>
    </div>
</div>
<div id="container" class="gnb_setting"> <span id="print_this"><!-- 인쇄영역 시작 //-->
	
	<header id="headerContainer">
		<div class="inner">
			<div class="menus">
				<ul >
					<li><a href="javascript:history.back();" class="btn btn-secondary"><i class="bi bi-list"></i><span class="txt">리스트</span></a></li>
					<? if ($idx) { ?>
					<li><a href="javascript:send_it()" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">수정</span></a></li>
					
					<li><a href="javascript:del_it('<?=$idx?>')" class="btn btn-danger"><i class="bi bi-trash"></i><span class="txt">삭제</span></a></li>
					
					<? } else { ?>
					<li><a href="javascript:send_it()" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">등록</span></a></li>
					<? } ?>
					
				</ul>
			</div>
		</div>
		<!-- // inner --> 
		
	</header>
	<!-- // headerContainer -->
	
	<form name="frm" action="admin_ip_write_ok.php"  method="post" enctype="multipart/form-data"  target="hiddenFrame" >
	<input type=hidden name="idx" value='<?=$idx?>'> 
	
	
	
	<div id="contents">
		<div class="listWrap_noline">
			<div class="listBottom">
				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail">
					<caption>
					</caption>
					<colgroup>
					<col width="10%" />
					<col width="90%" />
					</colgroup>
					<tbody>
						
					
						
						<tr height="45">
							<th>IP</th>
							<td>
							<?
								$arr_now_ip = explode(".",$_SERVER["REMOTE_ADDR"]);
							?>
								<input type="text" id="ip1" name="ip1" value="<?=$_tmp_ip[0]?>" class="input_txt onlynum" maxlength="4" style="width:50px" /> .
								<input type="text" id="ip2" name="ip2" value="<?=$_tmp_ip[1]?>" class="input_txt onlynum" maxlength="4" style="width:50px" /> .
								<input type="text" id="ip3" name="ip3" value="<?=$_tmp_ip[2]?>" class="input_txt onlynum" maxlength="4" style="width:50px" /> .
								<input type="text" id="ip4" name="ip4" value="<?=$_tmp_ip[3]?>" class="input_txt onlynum" maxlength="4" style="width:50px" />
								<button type="button" class="btn btn-default" onclick="reg_ip('<?=$arr_now_ip[0]?>','<?=$arr_now_ip[1]?>','<?=$arr_now_ip[2]?>','<?=$arr_now_ip[3]?>');">접속 IP</button>
								<span style="font-weight:bold;color:red;">접속 IP ( <?=$_SERVER["REMOTE_ADDR"]?> )</span>
							</td>
						</tr>

						<tr height="45">
							<th>메모</th>
							<td>
								<input type="text" id="memo" name="memo" value="<?=$memo?>" class="input_txt" style="width:30%" />
							</td>
						</tr>

						


						<tr height="45">
							<th>사용유무</th>
							<td>
								<input type="radio" name="use" value="Y" <? if ($use == "Y" || $use == "") {echo "checked"; } ?>> 사용&nbsp;&nbsp;&nbsp;
								<input type="radio" name="use" value="N" <? if ($use == "N") {echo "checked"; } ?>> 사용안함
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
							<? if ($idx == "") { ?>	
							<a href="javascript:send_it()" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">등록</span></a>
							<? } else { ?>
							<a href="javascript:send_it()" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">수정</span></a>
							
							<a href="javascript:del_it('<?=$idx?>')" class="btn btn-danger"><i class="bi bi-trash"></i><span class="txt">삭제</span></a>
							
							<? } ?>
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

function del_it(code_idx) {
	
	if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false)
	{
		return;
	}
	$("#ajax_loader").removeClass("display-none");
	$.ajax({
		url: "ip_del.php",
		type: "POST",
		data: "idx="+code_idx,
		error : function(request, status, error) {
		 //통신 에러 발생시 처리
			alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
			$("#ajax_loader").addClass("display-none");
		}
		,complete: function(request, status, error) {
//				$("#ajax_loader").addClass("display-none");
		}
		, success : function(response, status, request) {
			response = response.trim();
			if (response == "OK")
			{
				alert_("정상적으로 삭제되었습니다.");
				location.href="admin_ip.php";
				return;
			} else {
				alert(response);
				alert_("오류가 발생하였습니다!!");
				return;
			}
		}
	});
 
}


function reg_ip(ip1,ip2,ip3,ip4){
	$("#ip1").val(ip1);
	$("#ip2").val(ip2);
	$("#ip3").val(ip3);
	$("#ip4").val(ip4);
	
	$("#memo").focus();
}

</script> 
<iframe width="300" height="300" name="hiddenFrame" id="hiddenFrame" src="" style="display:none;"></iframe>

<? include "../_include/_footer.php"; ?>


