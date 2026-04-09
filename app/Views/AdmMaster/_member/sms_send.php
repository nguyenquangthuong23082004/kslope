<? include "../_include/_header.php"; ?>
<?
	$code	= updateSQ($_GET["code"]);

	// 해당 문자 보낼 달을 구하자~~~
	$total_sql = " select * from tbl_sms_log where code = '".$code."' ";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$row = mysqli_fetch_array($result);

	
	$chk_month = substr($row['regdate'],0,7);
	$chk_month = str_replace("-","",$chk_month);

	$total_sql = " 
					select h.idx, h.phone, h.CALLBACK, h.regdate, h.msg, h.status, h.u_idx, h.c_idx, h.spend_type, h.codes, h.sms_type, h.pc_type, h.sms_stat
					 from (
					 (
					  SELECT 
					   tr_num as idx 
					  ,tr_phone as phone
					  ,tr_callback as callback
					  ,tr_realsenddate as regdate
					  ,tr_msg as msg
					  ,tr_sendstat as status
					  ,tr_etc5 as u_idx
					  ,tr_etc6 as c_idx
					  ,tr_etc4 as spend_type
					,tr_etc2 as codes
					  ,'S' as sms_type
					  ,tr_etc1 as pc_type
					  ,if(TR_RSLTSTAT='06','y','n') as sms_stat
					  FROM SC_LOG_".$chk_month." SC 
					 WHERE 1=1
					 )
					 union all
					 (
					  SELECT 
					   msgkey as idx
					  ,phone as phone
					  ,callback as callback
					  ,TERMINATEDDATE as regdate
					  ,msg as msg
					  ,(
						  case when status = 0 then '0'
						  when status = 2 then '1'
						  when status = 3 then '2'
						  end
					   ) as status
					  ,etc2 as u_idx
					  ,etc3 as c_idx
					  ,etc4 as spend_type
					,etc2 as codes
					  ,'M' as sms_type
					  ,etc1 as pc_type
					  ,if(rslt='1000','y','n') as sms_stat
					  FROM MMS_LOG_".$chk_month."
					  where 1=1
					 )
					 ) h
				  where h.codes = '".$code."'  and h.phone != ''
				 ";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$nTotalCount = mysqli_num_rows($result);
?>
		<div id="container">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>SMS발송내역</h2>
					<div class="menus">
						<ul class="first">
							<li><a href="sms01.php" class="btn btn_email01">자동SMS설정</a></li>	
							<li><a href="sms02.php" class="btn btn_email01">단체SMS발송</a></li>	
							<li><a href="sms03.php" class="btn btn_email01">개별SMS발송</a></li>	
							<li class="mr_10"><a href="sms04.php" class="btn btn_email01">SMS발송내역</a></li>	
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
						<col width="7%" />
						<col width="*" />
						<col width="15%" />
						<col width="20%" />
						</colgroup>
						<thead>
							<tr>
								<th>번호</th>
								<th>휴대폰번호</th>
								<th>상태</th>
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
								<td><?=$row['phone']?></td>
								<td>
									<?
									if($row['sms_stat'] == "y"){
										echo "성공";
									}else{
										echo "실패";
									}
									?>
								</td>
								<td><?=$row['regdate']?></td>
							</tr>
						<?  } ?>
						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

					
					<div id="headerContainer">
						
						<div class="">
							<div class="menus" style="margin-top:10px;">
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