<? include "../_include/_header.php"; ?>
<?
	$g_list_rows = 15;


	$total_sql = " select *
	                 from tbl_auto_sms_skin
					where 1=1  ";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$nTotalCount = mysqli_num_rows($result);
?>
		<div id="container" class="gnb_member">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>자동SMS설정</h2>
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

			<div id="contents" class="sms_container sms_container01">

				<div class="listWrap sms_container01">
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
						<col width="10%" />
						<col width="10%" />
						<col width="70%" />
						<col width="10%" />
						</colgroup>
						<thead>
							<tr>
								<th>코드</th>
								<th>SMS명</th>
								<th>SMS내용</th>
								<th>자동발송여부</th>
							</tr>
						</thead>	
						<tbody>

						<?
							$nPage = ceil($nTotalCount / $g_list_rows);
							if ($pg == "") $pg = 1;
							$nFrom = ($pg - 1) * $g_list_rows;

							//$sql    = $total_sql . " order by idx desc limit $nFrom, $g_list_rows ";
							$sql    = $total_sql . " order by idx desc ";
							//echo $sql;
							$result = mysqli_query($connect, $sql) or die (mysql_error());
							$num = $nTotalCount - $nFrom;
							
						
							
							if ($nTotalCount == 0) {
						?>
						<tr>
							<td colspan=4 style="text-align:center;height:100px">검색된 결과가 없습니다.</td>
						</tr>
						<?
							}
							while($row=mysqli_fetch_array($result)){

								  if($row['autosend'] == "Y") {
									 $type = "자동발송";
                                  } else { 
									 $type = "자동발송안함";
                                  }
						?>
							<tr>
								<td><?=$row['code']?></td>
								<td><a href="sms01_view.php?idx=<?=$row['idx']?>"><?=$row['title']?></a></td>
								<td>
									<?=$row['content']?>
								</td>
								<td><?=$type?></td>
							</tr>

						<?  } ?>

						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

					<?//echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF]."?s_status=$s_status&search_category=$search_category&search_name=$search_name&pg=")?>
					
					
					
				</div><!-- // listWrap -->

			</div><!-- // contents -->





		</span><!-- 인쇄 영역 끝 //-->
		</div><!-- // container -->



<? include "../_include/_footer.php"; ?>