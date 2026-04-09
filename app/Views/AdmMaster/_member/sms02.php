<? include "../_include/_header.php"; ?>

<?
// 발산번호 참조
	$sql    = " select * from tbl_homeset ";
	$result = mysqli_query($connect, $sql) or die (mysql_error());
    $row    = mysqli_fetch_array($result);

?>
<?
	$g_list_rows = 10;
	if ($search_name)
	{
		$strSql = $strSql." and replace(".$search_category.",'-','') like '%".str_replace("-","",$search_name)."%' ";
	}

	if ($s_status == "") {
		$s_status = "Y";
	}


	
	$total_sql = " select d.*, g.goods_name_front
	                 from tbl_counsel_deal d 
					 left outer join tbl_goods g
					   on d.sel_goods = g.g_idx
					where 1=1 $strSql ";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$nTotalCount = mysqli_num_rows($result);
?>
		<div id="container" class="gnb_member">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>단체SMS발송</h2>
					<div class="menus">
						<ul class="first">
							<li><a href="sms01.php" class="btn btn_email01">자동SMS설정</a></li>	
							<!--
							<li><a href="sms02.php" class="btn btn_email01">단체SMS발송</a></li>	
							-->
							<li><a href="sms03.php" class="btn btn_email01">SMS발송</a></li>	
							<li class="mr_10"><a href="sms04.php" class="btn btn_email01">SMS발송내역</a></li>	
						</ul>
					</div>
				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents" class="sms_container sms_container02">
				<form name="frm" id="frm" method="post" action="sms02_send.php" >
					<header id="">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable01 sms_form01" style="table-layout:fixed;">
							<colgroup>
								<col width="130px">
								<col width="*">
							</colgroup>
							<tbody>
								<tr>
									<td class="label">구분</td>
									<td class="inbox">
										<select name="send_grp" id="send_grp">
											<option value="">선택</option>
											<option value="1">전체회원</option>
											<option value="2">수신동의회원</option>
										</select>	
									</td>
								</tr>
								<tr>
									<td class="label">문자내역</td>
									<td class="inbox">
										<textarea name="msg" id="msg" cols="30" rows="10">EX) [본토]{{MEMBER_NAME}}님 가입을 진심으로 축하드립니다. </textarea>
										<span>{NAME}: 이름을 대체합니다.</span>
									</td>
								</tr>	
								<tr>
									<td class="label">발신번호</td>
									<td class="inbox"><input type="text" name="send_num" id="send_num" value="<?=$row['sms_phone']?>"></td>
								</tr>
								
							</tbody>
						</table>
						<div>
							<button type="button" type="button" onclick="chg_it();" class="btn_save01">발송</button>
						</div>	
					</header><!-- // headerContents -->
				</form>			

			</div><!-- // contents -->

		</span><!-- 인쇄 영역 끝 //-->
		</div><!-- // container -->





<script>
 

function chg_it(){
	
	var frm = document.frm;

	if(frm.send_num.value == ""){
		alert("발신번호를 입력해주세요.");
		return false;
	}
		
	frm.submit();
}


</script>

<? include "../_include/_footer.php"; ?>