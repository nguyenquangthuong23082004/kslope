<? include "../_include/_header.php"; ?>
<link rel="stylesheet" href="/AdmMaster/_common/css/sms_contents.css" type="text/css" />

<style type="text/css">
	.radio_sel span{margin-right:15px;}
</style>

<?

$idx	= updateSQ($_GET["idx"]);  

$links = "/AdmMaster/_member/member_point.php";
?>

<div id="container" class="gnb_member"> <span id="print_this"><!-- 인쇄영역 시작 //-->
	
	<header id="headerContainer">
		<div class="inner">
			<h2>회원 적립금 관리</h2>
			<div class="menus">
				<ul >
					<li><a href="<?=$links?>?search_gubun=<?=$search_gubun?>&search_category=<?=$search_category?>&search_name=<?=$search_name?>&pg=<?=$pg?>" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a></li>
					<li><a href="javascript:send_its()" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">확인</span></a></li>
				</ul>
			</div>
		</div>
		<!-- // inner --> 
		
	</header>
	<!-- // headerContainer -->
	
	<div id="contents">
		<div class="listWrap_noline">
			<form name="frm" id="frm" action="member_point_write_ok.php" method="post"enctype="multipart/form-data" >
				<input type="hidden" name="idx" id="idx" value="<?=$idx?>" />
			
			<?
				if ($idx)
				{
					$sql		= " select * from tbl_point where idx = '".$idx."'";
					$result		= mysqli_query($connect, $sql) or die (mysqli_error($connect));
					$row		= mysqli_fetch_object($result);

					foreach($row as $keys => $vals){
						//echo $keys . " => " . $vals . "<br/>";
						${$keys} = $vals;
					}
				}
			?>
					
			
			<div class="listBottom">

				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail">
					<caption>
					</caption>
					<colgroup>
						<col width="150px" />
						<col width="*" />
					</colgroup>
					<tbody>
						<tr>
							<th>아이디</th>
							<td colspan="3"><input type="text" id="user_id" name="user_id" value="<?=$user_id?>" class="input_txt placeHolder" rel="" style="width:200px" /></td>
						</tr>

						<tr>
							<th>지급포인트</th>
							<td colspan="3"><input type="text" id="point" name="point" value="<?=$point?>" class="input_txt placeHolder onlynump" rel="" style="width:200px" /></td>
						</tr>

						<tr>
							<th>지급사유</th>
							<td>
								<input type="text" id="msg" name="msg" value="<?=$msg?>" class="input_txt placeHolder" rel="" style="width:200px" />
							</td>
						</tr>
						<!--
						<tr>
							<th>소멸일자</th>
							<td>
								<input type="text" id="enddate" name="enddate" value="<?=$enddate?>" class="datepicker input_txt" rel="" readonly />
							</td>
						</tr>
						-->

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
	function send_its()
	{
		var frm = document.frm;
		var points = frm.point.value.trim();
		var chk_points = parseInt(points);


		if(frm.user_id.value.trim() == ""){
			alert("아이디를 입력해주세요.");
			frm.user_id.focus();
			return false;
		}

		if(points == ""){
			alert("지급포인트를 입력해주세요.");
			frm.point.focus();
			return false;
		}

		if( points != chk_points ){
			alert("포인트를 올바른 형식으로 입력해주세요.");
			return false;
		}else{
			frm.point.value=chk_points;
		}

		if(frm.msg.value.trim() == ""){
			alert("지급사유를 입력해주세요.");
			frm.msg.focus();
			return false;
		}
		
		frm.submit();
	}



	




</script>

<? include "../_include/_footer.php"; ?>
