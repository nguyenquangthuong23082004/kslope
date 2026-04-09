<? include "../_include/_header.php"; ?>
<?
	$code	= updateSQ($_GET["code"]);

	$total_sql = " select * from tbl_email_log where code='".$code."' ";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$nTotalCount = mysqli_num_rows($result);
?>
		<div id="container" class="gnb_member">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>매일발송내역</h2>
					<div class="menus">
						<ul class="first">
							<? include "./email_menu.php"; ?>
						</ul>
					</div>
				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents" class="email_container email_container04">
				<script>
				function search_it()
				{
					var frm = document.search;
					if (frm.search_name.value == "검색어 입력")
					{
						frm.search_name.value = "";
					}
					frm.submit();
				}
				</script>

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
						<col width="5%" />
						<col width="*" />
						<col width="45%" />
						<col width="20%" />
						</colgroup>
						<thead>
							<tr>
								<th>번호</th>
								<th>제목</th>
								<th>이메일</th>
								<th>발송일시</th>
							</tr>
						</thead>	
						<tbody>

						<?
							$sql    = $total_sql . " order by idx desc  ";
							$result = mysqli_query($connect, $sql) or die (mysql_error());
							$num = $nTotalCount - $nFrom;
							
						
							while($row = mysqli_fetch_array($result)){
								$row_num = $num--;
						?>

							<tr>
								<td><?=$row_num?></td>
								<td><?=$row['title']?></td>
								<td><?=$row['tomail']?></td>
								<td><?=$row['regdate']?></td>
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
									<li><a href="#!" onclick="history.go(-1);" class="btn btn-success btn_dd01">목록</a></li>	
								</ul>

							</div>

						</div><!-- // inner -->

					</div><!-- // headerContainer -->
					
				</div><!-- // listWrap -->

			</div><!-- // contents -->





		</span><!-- 인쇄 영역 끝 //-->
		</div><!-- // container -->


<script>
$(function() {
	$( ".date_form" ).datepicker({
		showOn: "both",
		dateFormat: 'yy-mm-dd',
		buttonImageOnly: false,
		showButtonPanel: false,
		changeMonth: false, // 월을 바꿀수 있는 셀렉트 박스를 표시한다.
		changeYear: false, // 년을 바꿀수 있는 셀렉트 박스를 표시한다.
		dayNames: ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'],
		dayNamesMin: ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT']
		});
	});



	

</script>


<? include "../_include/_footer.php"; ?>