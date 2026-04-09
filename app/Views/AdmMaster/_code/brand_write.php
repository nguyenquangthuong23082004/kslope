<? include "../_include/_header.php"; ?>
<script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js"></script>
<script type="text/javascript" src="./brand_write.js"></script>
<?
	$code_idx				= updateSQ($_GET["code_idx"]);
	$s_parent_code_no		= updateSQ($_GET["s_parent_code_no"]);

	$titleStr = "생성";
	if ($s_parent_code_no == "")
	{
		$parent_code_no = "0";
	} else {
		$parent_code_no = $s_parent_code_no;
	}
	if ($code_idx) {
		$total_sql			= " select * from tbl_brand where code_idx='".$code_idx."'";
		$result				= mysqli_query($connect, $total_sql) or die (mysql_error());
		$row				= mysqli_fetch_array($result);
		$code_no			= $row["code_no"];
		$code_name			= $row["code_name"];
		$code_name_en		= $row["code_name_en"];
		$product_code		= $row["product_code"];
		$status				= $row["status"];
		$onum				= $row["onum"];	
		$titleStr = "수정";
		$img				= $row["brandImg"];
		$comment				= $row["comment"];

	} else {
		$total_sql			= "select * from tbl_brand where code_no='".$parent_code_no."'";
		$result				= mysqli_query($connect, $total_sql) or die (mysql_error());
		$row				= mysqli_fetch_array($result);
		$depth				= $row["depth"]+1;
		


		$total_sql			= " select ifnull(max(code_no),'".$s_parent_code_no."00')+1 as code_no from tbl_brand ";
		//echo $total_sql;
		$result				= mysqli_query($connect, $total_sql) or die (mysql_error());
		$row				= mysqli_fetch_array($result);
		$code_no			= $row["code_no"];
		
		

		$onum				= 0;

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
	if (frm.code_name.value == "")
	{
		frm.code_name.focus();
		alert("브랜드 명을 입력하셔야 합니다.");
		return;
	}

	frm.submit();
}

</script>


<div id="container" class="gnb_code"> <span id="print_this"><!-- 인쇄영역 시작 //-->
	
	<header id="headerContainer">
		<div class="inner">
			<h2>브랜드 <?=$titleStr?> </h2>
			<div class="menus">
				<ul >
					<li><a href="javascript:history.back();" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a></li>
					<? if ($code_idx) { ?>
					<li><a href="javascript:send_it()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a></li>
					<!--
					<li><a href="javascript:del_it()" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span><span class="txt">삭제</span></a></li>
					-->
					<? } else { ?>
					<li><a href="javascript:send_it()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">등록</span></a></li>
					<? } ?>
					
				</ul>
			</div>
		</div>
		<!-- // inner --> 
		
	</header>
	<!-- // headerContainer -->
	
	<form name="frm" action="brand_write_ok.php"  method="post" enctype="multipart/form-data"  target="hiddenFrame" >
	<input type=hidden name="code_idx" value='<?=$code_idx?>'> 
	<input type=hidden name="code_no" value='<?=$code_no?>'> 
	<input type=hidden name="product_code" id="product_code" value='<?=$product_code?>'> 
	
	
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
							<th>코드NO</th>
							<td>
								<?=$code_no?>
							</td>
						</tr>
						
						<tr height="45">
							<th>브랜드 명</th>
							<td>
								<input type="text" id="code_name" name="code_name" value="<?=$code_name?>" class="input_txt" style="width:30%" />
							</td>
						</tr>
						<tr height="45">
							<th>브랜드 명(영문)</th>
							<td>
								<input type="text" id="code_name_en" name="code_name_en" value="<?=$code_name_en?>" class="input_txt" style="width:30%" />
							</td>
						</tr>
						<tr height="45">
							<th>브랜드 소개</th>
							<td>
								<input type="text" id="comment" name="comment" value="<?=$comment?>" class="input_txt" style="width:50%" />
							</td>
						</tr>

						<!--
						<tr height="45">
							<th>분류선택</th>
							<td colspan="3">

								<select id="product_code_1" name="product_code_1" class="input_select" onchange="javascript:get_code(this.value, 2)">
									<option value="">1차분류</option>
									<?
										$fsql    = "select * from tbl_group where depth='1' and status='Y' order by onum desc, code_idx desc";
										$fresult = mysqli_query($connect, $fsql) or die (mysql_error());
										while($frow=mysqli_fetch_array($fresult)){
											$status_txt = "";
											if ($frow["status"] == "Y")
											{ 
												$status_txt = "";
											} elseif ($frow["status"] == "N") {
												$status_txt = "[삭제]";
											} elseif ($frow["status"] == "C") {
												$status_txt = "[마감]";
											}

									?>
									<option value="<?=$frow["code_no"]?>" ><?=$frow["code_name"]?> <?=$status_txt?></option>
									<? } ?>
									
								</select> 
								<select id="product_code_2" name="product_code_2" class="input_select" onchange="javascript:get_code(this.value, 3)" >
									<option value="">2차분류</option>
								</select>
								<select id="product_code_3" name="product_code_3" class="input_select" onchange="javascript:get_code(this.value, 4)" >
									<option value="">3차분류</option>
								</select>
								<select id="product_code_4" name="product_code_4" class="input_select" >
									<option value="">4차분류</option>
								</select>
								
								<button type="button" id="btn_reg_cate" class="btn_01">등록</button>
							</td>
							
						</tr>
						-->
						<?
						$_product_code_arr = explode("||", getCodeSlice($product_code) );
						?>
						<!--
						<tr height="48">
							<th>등록된 분류</th>
							<td colspan="3">
								<ul id="reg_cate">
								<?
								if($product_code){
									foreach($_product_code_arr as $_tmp_code){
								?>

										<li>[<?=$_tmp_code?>] <?=get_group_text($_tmp_code)?> <span onclick="delCategory('<?=$_tmp_code?>', this);" >삭제</span></li>
								<?
									}
								}
								?>
								</ul>
							</td>
						</tr>
						-->


						<tr height="45">
							<th>현황</th>
							<td>
								<input type="radio" name="status" value="Y" <? if ($status == "Y" || $status == "") {echo "checked"; } ?>> 사용&nbsp;&nbsp;&nbsp;
								<input type="radio" name="status" value="C" <? if ($status == "C") {echo "checked"; } ?>> 마감&nbsp;&nbsp;&nbsp;
								<input type="radio" name="status" value="N" <? if ($status == "N") {echo "checked"; } ?>> 삭제
							</td>
						</tr>

						<tr height="45">
							<th>브랜드 이미지 업로드</th>
							<td>
								<input type="file" name="ufile1"  class="bbs_inputbox_pixel"  />
								<?if($img != ""){?> 
									<br /><img src="/data/icon/<?=$img?>" />
								<?}?>
							</td>
						</tr>

						
						<tr height="45">
							<th>우선순위</th>
							<td>
								<input type="text" id="onum" name="onum" value="<?=$onum?>" class="input_txt" style="width:50px" /> (숫자가 높을수록 상위에 노출됩니다.)
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
							<? if ($code_idx == "") { ?>	
							<a href="javascript:send_it()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">등록</span></a>
							<? } else { ?>
							<a href="javascript:send_it()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a>
							<!--
							<a href="javascript:del_it()" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span><span class="txt">삭제</span></a>
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
				hiddenFrame.location.href = "brand_del.php?code_idx[]=<?=$code_idx?>&mode=view&s_ca_idx=<?=$ca_idx?>";
			}
		 
		}
</script> 
<iframe width="300" height="300" name="hiddenFrame" id="hiddenFrame" src="" style="display:none;"></iframe>

<? include "../_include/_footer.php"; ?>
