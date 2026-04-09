<? include "../_include/_header.php"; ?>
<?
	$titleStr = "생성";
?>
<script type="text/javascript">

function send_it()
{
	var frm = document.frm;
	
	if (frm.coupon_cnt.value == "")
	{
		frm.coupon_cnt.focus();
		alert("발행 매수를 입력해주세요.");
		return;
	}


	frm.submit();
}

</script>


<div id="container" class="gnb_operator"> <span id="print_this"><!-- 인쇄영역 시작 //-->
	
	<header id="headerContainer">
		<div class="inner">
			<h2>쿠폰 <?=$titleStr?> </h2>
			<div class="menus">
				<ul >
					<li><a href="javascript:history.back();" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a></li>

					<? if ($idx) { ?>
						<li><a href="javascript:send_it()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a></li>
					
						<li><a href="javascript:del_it()" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span><span class="txt">삭제</span></a></li>
					<? } else { ?>
						<li><a href="javascript:send_it()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">등록</span></a></li>
					<? } ?>
				</ul>
			</div>
		</div>
		<!-- // inner --> 
		
	</header>
	<!-- // headerContainer -->
	
	<form name="frm" action="coupon_write_ok.php"  method="post" enctype="multipart/form-data"  >
		<input type="hidden" name="idx" value='<?=$idx?>'> 
	
	
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
							<th>쿠폰타입</th>
							<td>
								<select name="coupon_type" id="coupon_type"  >
									<option value="">선택</option>
								<?
								$sql_c = " select *	from tbl_coupon_setting where state = 'Y' order by idx desc ";
								$result_c = mysqli_query($connect, $sql_c) or die (mysql_error());
								while($row_c=mysqli_fetch_array($result_c)){
								?>
									<option value="<?=$row_c['idx']?>"><?=$row_c['coupon_name']?></option>
								<?}?>
									
								</select>
							</td>
						</tr>

						<tr height="45">
							<th>발행매수</th>
							<td>
								<input type="text" name="coupon_cnt" id="coupon_cnt" class="onlynum" style="text-align:right;" value="" maxlength="3" />
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
							<? if ($idx == "") { ?>	
							<a href="javascript:send_it()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">등록</span></a>
							<? } else { ?>
							<a href="javascript:send_it()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a>
							
							<a href="javascript:del_it()" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span><span class="txt">삭제</span></a>
							
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
		hiddenFrame.location.href = "coupon_setting_del.php?idx[]=<?=$idx?>&mode=view&s_ca_idx=<?=$ca_idx?>";
	}
 
}

$(document).ready(function(){
	$("#types").change(function(){

		if( $("#types").val() == "N"){
			$("#coupon_type").prop("disabled",false);
		}else{
			$("#coupon_type").val("");
			$("#coupon_type").prop("disabled",true);
		}
	});
	

});
</script> 
<iframe width="300" height="300" name="hiddenFrame" id="hiddenFrame" src="" style="display:none;"></iframe>

<? include "../_include/_footer.php"; ?>
