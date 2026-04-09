<? include "../_include/_header.php"; ?>
<script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js"></script>
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
		$total_sql			= " select * from tbl_item_logo where code_idx='".$code_idx."'";
		$result				= mysqli_query($connect, $total_sql) or die (mysql_error());
		$row				= mysqli_fetch_array($result);
		$code_no			= $row["code_no"];
		$code_name			= $row["code_name"];
		$status				= $row["status"];
		$onum				= $row["onum"];	
		$price				= $row['price'];
		$max_price			= $row['max_price'];
		$content			= $row['content'];
		$appli_method		= $row['appli_method'];

		$ufile				= $row['ufile'];
		$rfile				= $row['rfile'];

		$titleStr = "수정";
	} else {
		$total_sql			= "select * from tbl_item_logo where code_no='".$parent_code_no."'";
		$result				= mysqli_query($connect, $total_sql) or die (mysql_error());
		$row				= mysqli_fetch_array($result);
		$depth				= $row["depth"]+1;
		


		$total_sql			= " select ifnull(max(code_no),'".$s_parent_code_no."00')+1 as code_no from tbl_item_logo ";
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

	var ufile_chk = "<?=$ufile?>";

	if (frm.code_name.value == "")
	{
		frm.code_name.focus();
		alert("제품로고명을 입력하셔야 합니다.");
		return;
	}

	if (ufile_chk == '')
	{
		if (frm.ufile1.value == "")
		{
			frm.ufile1.focus();
			alert("이미지를 등록하셔야합니다.");
			return;
		}
	}


//	if (frm.appli_method.value == "")
//	{
//		frm.appli_method.focus();
//		alert("신청방법을 입력하셔야 합니다.");
//		return;
//	}

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
        <h4 class="text-center">제품로고 <?=$titleStr?> </h4>
    </div>
</div>
<div id="container" class="gnb_code"> <span id="print_this"><!-- 인쇄영역 시작 //-->
	
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
	
	<form name="frm" action="item_logo_write_ok.php"  method="post" enctype="multipart/form-data"  target="hiddenFrame" >
	<input type=hidden name="code_idx" value='<?=$code_idx?>'> 
	<input type=hidden name="code_no" value='<?=$code_no?>'> 
	
	
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
							<th>제품로고명</th>
							<td>
								<input type="text" id="code_name" name="code_name" value="<?=$code_name?>" class="input_txt" style="width:30%" />
							</td>
						</tr>

						<tr height="45">
							<th>제품로고이미지 업로드</th>
							<td>
								<input type="file" name="ufile1"  class="bbs_inputbox_pixel" style="width:300px"/>
								<?if($ufile){?>
									<br>파일삭제:<input type='checkbox' name="del_1" value='Y'><a href="/data/item_logo/<?=$ufile?>" class="imgpop"><?=$rfile?></a><br><br>
								<?$imgs = get_img($ufile,"/data/item_logo/","200","200");?>
								<img src="<?=$imgs?>"/>
								<?}?>
							</td>
						</tr>


						<tr height="45">
							<th>현황</th>
							<td>
								<input type="radio" name="status" value="Y" <? if ($status == "Y" || $status == "") {echo "checked"; } ?>> 사용&nbsp;&nbsp;&nbsp;
								<input type="radio" name="status" value="C" <? if ($status == "C") {echo "checked"; } ?>> 마감&nbsp;&nbsp;&nbsp;
								<input type="radio" name="status" value="N" <? if ($status == "N") {echo "checked"; } ?>> 삭제
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
				hiddenFrame.location.href = "icon_del.php?code_idx[]=<?=$code_idx?>&mode=view&s_ca_idx=<?=$ca_idx?>";
			}
		 
		}
</script> 
<iframe width="300" height="300" name="hiddenFrame" id="hiddenFrame" src="" style="display:none;"></iframe>

<? include "../_include/_footer.php"; ?>
