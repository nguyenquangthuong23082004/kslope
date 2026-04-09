<? include "../_include/_header.php"; ?>
<?
	$idx				= updateSQ($_GET["idx"]);
	
	$titleStr = "생성";
	
	if ($idx) {
		$total_sql			= " select * from tbl_coupon_setting where idx='".$idx."'";
		$result				= mysqli_query($connect, $total_sql) or die (mysql_error());
		$row				= mysqli_fetch_object($result);

		foreach($row as $keys => $vals){
			${$keys} = $vals;
		}
		
		$titleStr = "수정";
	}


?>
<script type="text/javascript">

function send_it()
{
	var frm = document.frm;
	
	if (frm.coupon_name.value == "")
	{
		frm.coupon_name.focus();
		alert("쿠폰명을 입력하셔야 합니다.");
		return;
	}


	if (frm.coupon_pe.value == "")
	{
		frm.coupon_pe.focus();
		alert("할인율 설정을 입력하셔야 합니다.");
		return;
	}

	/*
	if (frm.dex_price_pe.value == "")
	{
		frm.dex_price_pe.focus();
		alert("할인율 상한선을 입력하셔야 합니다.");
		return;
	}
	*/

	if (frm.exp_days.value == "")
	{
		frm.exp_days.focus();
		alert("발행일수를 입력하셔야 합니다.");
		return;
	}

	frm.submit();
}

</script>


<div id="container" class="gnb_operator"> <span id="print_this"><!-- 인쇄영역 시작 //-->
	
	<header id="headerContainer">
		<div class="inner">
			<h2>쿠폰설정 <?=$titleStr?> </h2>
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
	
	<form name="frm" action="coupon_setting_write_ok.php"  method="post" enctype="multipart/form-data"  target="hiddenFrame" >
		<input type="hidden" name="idx" value='<?=$idx?>'> 
		<input type="hidden" name="publish_type" value='N'> <!-- 일반 쿠폰만 사용 -->
	
	
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
							<th>쿠폰명</th>
							<td>
								<input type="text" id="coupon_name" name="coupon_name" value="<?=$coupon_name?>" class="input_txt" style="width:30%" />
							</td>
						</tr>


						<tr height="45">
							<th>할인방법</th>
							<td>
								<select name="dc_type" id="dc_type" >
									<option value="P" <?if($dc_type=="P")echo"selected";?> >할인율</option>
									<option value="D" <?if($dc_type=="D")echo"selected";?> >가격할인</option>
								</select>
							</td>
						</tr>

						<tr height="45">
							<th>할인율 설정</th>
							<td>
								<input type="text" id="coupon_pe" name="coupon_pe" value="<?=$coupon_pe?>" class="input_txt onlynum" maxlength="3" /> %
							</td>
						</tr>

						<tr height="45">
							<th>할인가격</th>
							<td>
								<input type="text" id="coupon_price" name="coupon_price" value="<?=$coupon_price?>" class="input_txt onlynum" /> 원
							</td>
						</tr>
						<!--
						<tr height="45">
							<th>할인율 상한선</th>
							<td>
								<input type="text" id="dex_price_pe" name="dex_price_pe" value="<?=$dex_price_pe?>" class="input_txt onlynum" maxlength="3" /> % <span style="color:red;margin-left:10px;">최초가와 현재가의 할인율이 % 이상일때 할인 제외</span>
							</td>
						</tr>
						-->

						<tr height="45">
							<th>발행일수</th>
							<td>
								<input type="text" id="exp_days" name="exp_days" value="<?=$exp_days?>" class="input_txt onlynum" maxlength="4" /> 일 <span style="color:red;margin-left:10px;">발행일수를 기준으로 사용 유효기간 설정.</span>
							</td>
						</tr>

						<tr height="45">
							<th>쿠폰설명</th>
							<td>
								<textarea name="etc_memo" id="etc_memo" rows="10" cols="100" class="input_txt" style="width:100%; height:100px;"><?=viewSQ($etc_memo);?></textarea>								
							</td>
						</tr>

						<tr height="45">
							<th>상태설정</th>
							<td>
								<select name="state" id="state" >
									<option value="Y" <?if($state =="Y")echo"selected";?> >사용</option>
									<option value="N" <?if($state =="N")echo"selected";?> >중지</option>
								</select>
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
		hiddenFrame.location.href = "coupon_setting_del.php?idx[]=<?=$idx?>";
	}
 
}

</script> 
<iframe width="0" height="0" name="hiddenFrame" id="hiddenFrame" src="" style="display:none;"></iframe>

<? include "../_include/_footer.php"; ?>
