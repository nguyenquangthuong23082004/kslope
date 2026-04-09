<? include "../_include/_header.php"; ?>
<?
	$idx				= updateSQ($_GET["idx"]);

	if($idx == ""){

	}else{
	
	
		$sql		= " select * from tbl_review2 where idx = '".$idx."'";
		$result		= mysqli_query($connect, $sql) or die (mysql_error($connect));
		$row		= mysqli_fetch_object($result);

		foreach($row as $keys => $vals){
			//echo $keys . " => " . $vals . "<br/>";
			${$keys} = $vals;

		}

		$gift_arr = explode('||', substr($gift,1,-1) );

		//echo "status = ".$status;


		$p_sql		= "select code_name from tbl_period where code_no = '".$period."' ";
		$p_result	= mysqli_query($connect, $p_sql);
		$p_row		= mysqli_fetch_array($p_result);

		$g_sql		= "select * from tbl_goods where g_idx = '".$g_idx."' ";
		$g_result	= mysqli_query($connect, $g_sql);
		$g_row		= mysqli_fetch_array($g_result);

		$g_code_sql = "select * from tbl_code where code_no = '".substr($g_row['product_code'], 1, -1)."' ";
		$g_code_result = mysqli_query($connect, $g_code_sql);
		$g_code_row = mysqli_fetch_array($g_code_result);
		if ( $g_code_row['parent_code_no'] == '0'){
			$g_code_name = $g_code_row['code_name'];
		}else{
			$gcode_sql = "select * from tbl_code where code_no = '".$g_code_row['parent_code_no']."' ";
			$gcode_result = mysqli_query($connect, $gcode_sql);
			$gcode_row = mysqli_fetch_array($gcode_result);
			$g_code_name = $gcode_row['code_name'];
		}
	}
	$titleStr = "상품후기(링크) 상세";
	$links = "list2.php";

?>


<div class="page-heading mb-4">
    
    <div class="d-flex justify-content-between align-items-center">
        <header class="d-block d-xl-none pb-2">
            <a href="#" class="d-block burger-btn d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <h4 class="text-center"><?=$titleStr?></h4>
    </div>
</div>
<div id="container" class="gnb_goods"> <span id="print_this"><!-- 인쇄영역 시작 //-->

	<header id="headerContainer">
		<div class="inner">
			<div class="menus">
				<ul >
					
					<li><a href="javascript:history.go(-1);" class="btn btn-secondary"><i class="bi bi-list"></i><span class="txt">리스트</span></a></li>					
					<li><a href="javascript:del_it()" class="btn btn-danger"><i class="bi bi-trash"></i><span class="txt">삭제</span></a></li>
				</ul>
			</div>
		</div>
		<!-- // inner -->

	</header>
	<!-- // headerContainer -->


	<div id="contents">
		<div class="listWrap_noline">
		
			<div class="listBottom">
				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail" style="table-layout:fixed;">
					<caption>
					</caption>
					<colgroup>
						<col width="10%" />
						<col width="40%" />
						<col width="10%" />
						<col width="40%" />
					</colgroup>
					<tbody>

						<tr height="45">
							<td colspan="4">
								리뷰 제품정보 및 확인
							</td>
						</tr>

						<tr height="45">
							<th>제품명</th>
							<td>[<?=$g_code_name?>]<?=$g_row['goods_name_front']?></td>
                            <th>약정기간</th>
							<td>
								<?=$p_row['code_name']?>
							</td>
						</tr>
<!-- 
						<tr height="45">
							<th>관리유형</th>
							<td>
								<?
								if($type == 'self'){
									echo "셀프관리";
								}elseif($type == 'visit'){
									echo "방문관리";
								}
								if($type == 'etc'){
									echo "기타";
								}
								?>
							</td>
						</tr> -->

						<!-- <tr height="45">
							<th>상담 제품</th>
							<td colspan='3'><?=($join_type == '1' ? $g_row['goods_name_front'] : ($join_type == '2' ? $goods_name : "" ) )?></td>
						</tr> -->


						<tr height="45">
							<th>상태</th>
							<td >
								<select name="status" id="status" onchange="status_chg('<?=$idx?>', this.value)">
									<option value="N" <?=($status == 'N' ? "selected" : "")?>>미승인</option>
									<option value="Y" <?=($status == 'Y' ? "selected" : "")?>>승인</option>
									<option value="R" <?=($status == 'R' ? "selected" : "")?>>승인거부</option>
								</select>
							</td>
							<th>발송여부</th>
							<td >
								<select name="status" id="status" onchange="deli_chg('<?=$idx?>', this.value)">
									<option value="1" <?=($deli_status == '1' ? "selected" : "")?>>미확인</option>
									<option value="2" <?=($deli_status == '2' ? "selected" : "")?>>발송</option>
									<option value="3" <?=($deli_status == '3' ? "selected" : "")?>>보류</option>
								</select>
							</td>
						</tr>

					</tbody>
				</table>
				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail" style="table-layout:fixed;">
					<colgroup>
						<col width="10%" />
						<col width="40%" />
						<col width="10%" />
						<col width="40%" />
					</colgroup>
					<tbody>
						<tr height='45'>
							<td colspan='4'>
								고객정보
							</td>
						</tr>
						
						<tr height="45">
							<th>고객명</th>
							<td colspan='3'><?=$user_name?></td>
						</tr>

						<tr height="45">
							<th>명의자 연락처</th>
							<td colspan='3'><?=$tel1?></td>
						</tr>

				</tbody>
				</table>
				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail" style="table-layout:fixed;">
					<colgroup>
						<col width="10%" />
						<col width="40%" />
						<col width="10%" />
						<col width="40%" />
					</colgroup>
					<tbody>
						<tr height="45">
							<td colspan='4'>입력 내용</td>
						</tr>
					<?
					$gift_num = 1;
					
					?>
						<tr height="45">
							<th>은행명</th>
							<td colspan='3'>
							<?
								echo $bank;
							?>
							</td>
						</tr>
					
						<tr height="45">
							<th>계좌번호</th>
							<td colspan='3'>
								<?=$bank_num?>
							</td>
						</tr>

						<tr height="45">
							<th>예금주</th>
							<td colspan='3'>
								<?=$bank_own?>
							</td>
						</tr>

						<tr height="45">
							<th>금액</th>
							<td colspan='3'>
								<?=$bank_money?>
							</td>
						</tr>

						<tr height="45">
							<th>제목</th>
							<td colspan='3'><?=$subject?></td>
						</tr>
						<tr height="45" class='bank_wrap'>
							<th>내용</th>
							<td colspan='3'><?=viewSQ(nl2br($content))?></td>
						</tr>
					<?
						$f_sql = "select * from tbl_review2_file where r_idx = '".$idx."' ";
						$f_result = mysqli_query($connect, $f_sql);
						$file_num = 1;
						while( $f_row = mysqli_fetch_array($f_result)){
					?>
						<tr height='45'>
							<th>설치한 사진 <?=$file_num?></th>
							<td colspan='3'>
								<img src="/data/review/<?=$f_row['ufile']?>" alt="" style='width:30%'>
								<?=$f_row['rfile']?>
							</td>
						</tr>
					<?
						$file_num = $file_num +1;
						}
					?>
					</tbody>
				</table>

			</div>
			


			



		</div>
		<!-- // listWrap -->

	</div>
	<!-- // contents -->

	</span><!-- 인쇄 영역 끝 //-->
</div>
<script>
function status_chg(idx, val){
	$.ajax({
		url:"review_status_chg.php"
		,data:"idx="+idx+"&status="+val
		,type:"POST"
		,error:function(request, status, error){
			alert("CODE : "+request.status+"\r\nmessage : "+request.reponseText);
			return false;
		}
		,success:function(response, status, request){
			response = response.trim();
			if (response == "OK")
			{
				alert_("상태값이 변경되었습니다.");
				setTimeout(function(){
					location.reload();
				},1000);
			}else{
				alert(response);
				alert_("오류가 발생하였습니다.");
				return false;
			}
		}
	})
}
function deli_chg(idx, val){
	$.ajax({
		url:"deli_chg_ajax.php"
		,data:"idx="+idx+"&deli_status="+val
		,type:"POST"
		,error:function(request, status, error){
			alert("CODE : "+request.status+"\r\nmessage : "+request.reponseText);
			return false;
		}
		,success:function(response, status, request){
			response = response.trim();
			if (response == "OK")
			{
				alert_("발송여부값 변경되었습니다.");
				setTimeout(function(){
					location.reload();
				},1000);
			}else{
				alert(response);
				alert_("오류가 발생하였습니다.");
				return false;
			}
		}
	})
}
function del_it(){
	var idx = "<?=$idx?>";

	if( confirm("삭제하시겠습니까?\r\n삭제 후에는 복구가 불가능합니다.") == false){
		return false;
	}else{
		$.ajax({
			 url:"review_del2.php"
			,data:"idx="+idx
			,type:"POST"
			,error:function(request, status, error){
				alert("CODE : "+request.status+"\r\nmessage : "+request.reponseText);
				return false;
			}
			,success:function(response, status, request){
				response = response.trim();
				if (response == "OK")
				{
					alert_("삭제되었습니다.");
					setTimeout(function(){
						location.href='./review_list2.php';
					},1000);
				}else{
					alert(response);
					alert_("오류가 발생하였습니다.");
					return false;
				}
			}
		})
	}
}
$(function(){
	var payment = '<?=$payment?>';
	var business = '<?=$business?>';

	if ( payment == 'card' )
	{
		$(".card_wrap").show();
		$(".bank_wrap").hide();
	}
	if ( payment == 'bank' )
	{
		$(".bank_wrap").show();
		$(".card_wrap").hide();
	}

	if ( business == 'n')
	{
		$('.business_wrap').hide();
	}
})
</script>

<? include "../_include/_footer.php"; ?>