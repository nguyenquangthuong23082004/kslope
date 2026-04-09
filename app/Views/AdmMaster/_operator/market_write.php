<? include "../_include/_header.php"; ?>

<?
	$idx = updateSQ($_GET["idx"]);
	
	$titleStr = "생성";
	
	if ($idx) {
		$total_sql			= " select * from tbl_market where m_idx='".$idx."'";
		$result				= mysqli_query($connect, $total_sql) or die (mysql_error());
		$row				= mysqli_fetch_object($result);

		foreach($row as $keys => $vals){
			${$keys} = $vals;
		}
		
		$titleStr = "수정";
	}


?>
<style type="text/css">
	.radio_sel span{margin-right:15px;}
</style>

<div id="container" class="gnb_operator"> <span id="print_this"><!-- 인쇄영역 시작 //-->
	
	<header id="headerContainer">
		<div class="inner">
			<h2>매장 <?=$titleStr?></h2>
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
	
	<div id="contents">
		<div class="listWrap_noline">
			<form name="frm" id="frm" action="market_write_ok.php" method="post"enctype="multipart/form-data"  target="hiddenFrame" >
				<input type="hidden" name="idx" id="idx" value="<?=$idx?>" />
		
			
						
			<div class="listBottom">
				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail ">
					<caption>
					</caption>
					<colgroup>
						<col width="200px" />
						<col width="*" />
					</colgroup>
					<tbody>

						<tr>
							<th>상호명</th>
							<td><input type="text" id="shop_name" name="shop_name" value="<?=$shop_name?>" class="input_txt placeHolder" rel="" style="width:300px" /></td>							
						</tr>

						<tr>
							<th>주소</th>
							<td>
								<input type="text" name="zip" id="zip" value="<?=$zip?>" class="text" style="margin-bottom:5px;" placeholder="우편번호 입력" readonly >
								<a href="javascript:execDaumPostcode('frm','zip','addr1','addr2')" class="btn btn-default" style="margin-bottom:5px"><span class="glyphicon glyphicon-cog"></span><span class="txt">주소검색</span></a>

								<div class="address_info">
									<input type="text" name="addr1" id="addr1" value="<?=$addr1?>" class="text" style="width:500px;margin-bottom:5px" placeholder="주소 입력" readonly ><br/>
									<input type="text" name="addr2" id="addr2" value="<?=$addr2?>" class="text" style="width:500px;" placeholder="상세 주소 입력">
								</div>
							</td>
							
						</tr>
						<tr>
							<th>연락처</th>
							<td><input type="text" id="phone" name="phone" value="<?=$phone?>" class="input_txt placeHolder" rel="" style="width:300px" /></td>
						</tr>
						<tr>
							<th>이메일</th>
							<td><input type="text" id="email" name="email" value="<?=$email?>" class="input_txt placeHolder" rel="" style="width:300px" /></td>
						</tr>
						

					</tbody>
				</table>
			</div>

			</form>
			
		</div>
		<!-- // listWrap --> 


		
		
	</div>
	<!-- // contents --> 
	
	</span><!-- 인쇄 영역 끝 //--> 
</div>
<!-- // container --> 

<script>
	function send_it()
	{
		var frm = document.frm;

		if(frm.shop_name.value==""){
			alert("상호명을 입력해주세요.");
			frm.shop_name.focus();
			return false;
		}

		if(frm.zip.value==""){
			alert("주소를 입력해주세요.");
			frm.zip.focus();
			return false;
		}

		if(frm.addr1.value==""){
			alert("주소를 입력해주세요.");
			frm.addr1.focus();
			return false;
		}

		if(frm.addr2.value==""){
			alert("주소를 입력해주세요.");
			frm.addr2.focus();
			return false;
		}

		if(frm.phone.value==""){
			alert("연락처를 입력해주세요.");
			frm.phone.focus();
			return false;
		}

		if(frm.email.value==""){
			alert("이메일을 입력해주세요.");
			frm.email.focus();
			return false;
		}
		
		$("#frm").submit();
	}



	




</script>
<iframe width="300" height="300" name="hiddenFrame" id="hiddenFrame" src="" style="display:none;"></iframe>
<? include "../_include/_footer.php"; ?>
