<? include "../_include/_header.php"; ?>
<script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js"></script>
<?
	$code_idx				= updateSQ($_GET["code_idx"]);
	
	$titleStr = "생성";
	
	if ($code_idx) {
		$total_sql			= " select * from tbl_transcom where code_idx='".$code_idx."'";
		$result				= mysqli_query($connect, $total_sql) or die (mysql_error());
		$row				= mysqli_fetch_array($result);
		$code_name			= $row["code_name"];
		$status				= $row["status"];
		$t_tel				= $row["code_name"];
		$t_url				= $row["t_url"];
		$memo				= $row["memo"];
		
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
	oEditors1.getById["memo"].exec("UPDATE_CONTENTS_FIELD", []);
	if (frm.code_name.value == "")
	{
		frm.code_name.focus();
		alert("배송업체명을 입력하셔야 합니다.");
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
        <h4 class="text-center">배송사 <?=$titleStr?></h4>
    </div>
</div>

<div id="container" class="gnb_setting"> <span id="print_this"><!-- 인쇄영역 시작 //-->
	
	<header id="headerContainer">
		<div class="inner">
			<div class="menus">
				<ul >
					<li><a href="javascript:history.back();" class="btn btn-secondary"><i class="bi bi-list"></i><span class="txt">리스트</span></a></li>
					<? if ($code_idx) { ?>
					<li><a href="javascript:send_it()" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">수정</span></a></li>
					<!--
					<li><a href="javascript:del_it()" class="btn btn-danger"><i class="bi bi-trash"></i><span class="txt">삭제</span></a></li>
					-->
					<? } else { ?>
					<li><a href="javascript:send_it()" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">등록</span></a></li>
					<? } ?>
					
				</ul>
			</div>
		</div>
		<!-- // inner --> 
		
	</header>
	<!-- // headerContainer -->
	
	<form name="frm" action="transcom_write_ok.php"  method="post" enctype="multipart/form-data"  target="hiddenFrame" >
	<input type=hidden name="code_idx" value='<?=$code_idx?>'> 
	
	
	
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
							<th>배송업체명</th>
							<td>
								<input type="text" id="code_name" name="code_name" value="<?=$code_name?>" class="input_txt" style="width:30%" />
							</td>
						</tr>

						<tr height="45">
							<th>연락처</th>
							<td>
								<input type="text" id="t_tel" name="t_tel" value="<?=$t_tel?>" class="input_txt" style="width:30%" />
							</td>
						</tr>

						<tr height="45">
							<th>URL</th>
							<td>
								<input type="text" id="t_url" name="t_url" value="<?=$t_url?>" class="input_txt" style="width:30%" />
							</td>
						</tr>



						<tr height="45">
							<th>상태설정</th>
							<td>
								<input type="radio" name="status" value="Y" <? if ($status == "Y" || $status == "") {echo "checked"; } ?>> 사용&nbsp;&nbsp;&nbsp;
								<input type="radio" name="status" value="C" <? if ($status == "C") {echo "checked"; } ?>> 마감&nbsp;&nbsp;&nbsp;
								<input type="radio" name="status" value="N" <? if ($status == "N") {echo "checked"; } ?>> 삭제
							</td>
						</tr>


						<tr height="45">
							<th>메모</th>
							<td>
								<textarea name="memo" id="memo" rows="10" cols="100" class="input_txt" style="width:100%; height:400px; display:none;"><?=viewSQ($memo);?></textarea>

								<script type="text/javascript">
								var oEditors1 = [];

								// 추가 글꼴 목록

								nhn.husky.EZCreator.createInIFrame({
									oAppRef: oEditors1,
									elPlaceHolder: "memo",
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
							<? if ($code_idx == "") { ?>	
							<a href="javascript:send_it()" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">등록</span></a>
							<? } else { ?>
							<a href="javascript:send_it()" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">수정</span></a>
							<!--
							<a href="javascript:del_it()" class="btn btn-danger"><i class="bi bi-trash"></i><span class="txt">삭제</span></a>
							-->
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
		function del_it() {
			if(confirm(" 삭제후 복구하실수 없습니다. \n\n 삭제하시겠습니까?")) {
				hiddenFrame.location.href = "transcom_del.php?code_idx[]=<?=$code_idx?>&mode=view&s_ca_idx=<?=$ca_idx?>";
			}
		 
		}
</script> 
<iframe width="300" height="300" name="hiddenFrame" id="hiddenFrame" src="" style="display:none;"></iframe>

<? include "../_include/_footer.php"; ?>
