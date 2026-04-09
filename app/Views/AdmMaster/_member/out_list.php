<? include "../_include/_header.php"; ?>
<?

	//$user_type = $_GET['user_type'];

	if($user_type == ""){
		$user_type = "1";
	}

	$g_list_rows = 20;
	if ($search_name)
	{
		$strSql = $strSql." and replace(".$search_category.",'-','') like '%".str_replace("-","",$search_name)."%' ";
	}

	if ($s_status == "") {
		$s_status = "Y";
	}


	$strSql = $strSql." and status = 0 and user_level > 1 ";
	$total_sql = " select *		
				   from tbl_member a left outer join tbl_member_out b
				   on a.user_id = b.user_id 
				   where 1=1 $strSql ";
	
	//echo $total_sql;
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$nTotalCount = mysqli_num_rows($result);
?>
		<div id="container" class="gnb_member">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>탈퇴회원 리스트</h2>

				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents">
				<form name="search" id="search">		
				<input type="hidden" name="gubun" value="<?=$gubun?>">
				<input type="hidden" name="user_type" value="<?=$user_type?>">
				
				<header id="headerContents">
						<select id="" name="search_category" class="input_select" style="width:112px">
							<option value="user_name" <? if ($search_category == "user_name") {echo "selected"; } ?>>성명</option>
							<option value="user_id" <? if ($search_category == "user_id") {echo "selected"; } ?>>아이디</option>
							<option value="user_email" <? if ($search_category == "user_email") {echo "selected"; } ?>>이메일</option>
							<!-- <option value="user_phone" <? if ($search_category == "user_phone") {echo "selected"; } ?>>연락처</option> -->
						</select>


						<input type="text" id="" name="search_name" value="<?=$search_name?>" class="input_txt placeHolder" rel="검색어 입력" style="width:240px" />

						<a href="javascript:search_it()" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> <span class="txt">검색하기</span></a>
						</header><!-- // headerContents -->
				</form>
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
							<p class="schTxt">■ 총 <?=number_format($nTotalCount)?>개의 목록이 있습니다.</p>
						</div>

					</div><!-- // listTop -->
					
					
					



					<form name="frm" id="frm">				
					<div class="listBottom">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable">
						<caption></caption>
						<colgroup>
						<!-- <col width="50px" /> -->
						<!-- <col width="60px" /> -->
						<!-- <col width="100px" /> -->
						<col width="150px" />
						<col width="150px" />
						<!--<col width="100px" />-->
						<col width="*" />						
						<!-- <col width="150px" /> -->
						<!--<col width="150px" />-->
						<!--<col width="150px" />-->
						<col width="200px" />
						<!-- <col width="100px" /> -->
						</colgroup>
						<thead>
							<tr>
								<!-- <th>선택</th> -->
								<!-- <th>번호</th> -->
                                <!-- <th>현황</th> -->
								<th>아이디</th>
								<th>이름</th>	
								<!--<th>성별</th>-->
								<th>탈퇴사유</th>
								<!-- <th>연락처</th> -->
								<!--<th>마일리지</th>-->
								<!--<th>쿠폰</th>-->
								<th>탈퇴일시</th>
								<!-- <th>관리</th> -->
							</tr>
						</thead>	
						<tbody>
							<?
								$nPage = ceil($nTotalCount / $g_list_rows);
								if ($pg == "") $pg = 1;
								$nFrom = ($pg - 1) * $g_list_rows;

								$sql    = $total_sql . " order by m_idx desc limit $nFrom, $g_list_rows ";
								$result = mysqli_query($connect, $sql) or die (mysql_error());
								$num = $nTotalCount - $nFrom;
								
								$_genderArr['M'] = "남";
								$_genderArr['W'] = "여";
								
								if ($nTotalCount == 0) {
							?>
							<tr>
								<td colspan=12 style="text-align:center;height:100px">검색된 결과가 없습니다.</td>
							</tr>
							<?
								}
								while($row=mysqli_fetch_array($result)){
									$statusStr = "";
									if ($row["status"] == "1")
									{
										$statusStr = "정상";
									} elseif ($row["status"] == "0") {
										$statusStr = "탈퇴";
									}

									
							?>
							<tr style="height:50px">
								<!-- <td><input type="checkbox" name="m_idx[]" class="m_idx" value="<?=$row[m_idx]?>"  class="input_check"/></td> -->
								<!-- <td><?=$num--?></td> -->
                                <!-- <td class="tac"><?=$statusStr?></td> -->
								<td class="tac"><?=$row["user_id"]?></td>
								<td class="tac"><?=$row["user_name"]?></td>
								<td class="tac"><?=$row["type"]?></td>
								<!-- <td class="tac"><?=$row["user_mobile"]?></td> -->
								<!--<td class="tac"><?=number_format(showPoint($row["user_id"]))?><a href="#!" onclick="view_m('<?=$row["user_id"]?>')" class="open_popup m_popup"><img src="/AdmMaster/_images/common/ico_setting2_1.png" alt=""></a></td>-->
								<!--<td class="tac"><?=$row["mileage"]?><a href="#!" onclick="view_c('<?=$row["user_id"]?>')" class="open_popup c_popup"><img src="/AdmMaster/_images/common/ico_setting2_1.png" alt=""></a></td>-->
								<td class="tac"><?=$row["insertDate"]?></td>
								<!-- <td>
									<a href="write.php?m_idx=<?=$row[m_idx]?>&user_type=<?=$user_type?>"><img src="/AdmMaster/_images/common/ico_setting2.png"></a>
									<a href="javascript:del_it('<?=$row[m_idx]?>');"><img src="/AdmMaster/_images/common/ico_error.png" alt="에러" /></a>
								</td> -->
							</tr>
							<?  } ?>




							
						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

					<?echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF]."?user_type=$user_type&s_status=$s_status&search_category=$search_category&search_name=$search_name&pg=")?>


					<div id="headerContainer">
						
						<div class="inner">

						</div><!-- // inner -->

					</div><!-- // headerContainer -->
				</div><!-- // listWrap -->

			</div><!-- // contents -->





		</span><!-- 인쇄 영역 끝 //-->
		</div><!-- // container -->


			  
<? include "../_include/_footer.php"; ?>

