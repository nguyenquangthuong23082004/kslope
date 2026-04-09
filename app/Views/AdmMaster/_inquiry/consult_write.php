<? include "../_include/_header.php"; ?>
<?
	$idx				= updateSQ($_GET["idx"]);

	if($idx == ""){

	}else{
	
	
		$sql		= " select * from tbl_consult where idx = '".$idx."'";
		$result		= mysqli_query($connect, $sql) or die (mysql_error($connect));
		$row		= mysqli_fetch_object($result);

		foreach($row as $keys => $vals){
			//echo $keys . " => " . $vals . "<br/>";
			${$keys} = $vals;

		}

		//echo "status = ".$status;


		$p_sql		= "select code_name from tbl_period where code_no = '".$period."' ";
		$p_result	= mysqli_query($connect, $p_sql);
		$p_row		= mysqli_fetch_array($p_result);

		$g_sql		= "select * from tbl_goods where g_idx = '".$g_idx."' ";
		$g_result	= mysqli_query($connect, $g_sql);
		$g_row		= mysqli_fetch_array($g_result);
	}
	$titleStr = "제품상담신청 상세";
	$links = "list.php";

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
<div id="container" class="gnb_inquiry"> <span id="print_this"><!-- 인쇄영역 시작 //-->

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
								상세정보
							</td>
						</tr>

						

						<tr height="45">
							<th>상담 제품</th>
							<td colspan='3'><?=$g_row['goods_name_front']?> (<?=$g_row['goods_code_show']?>)</td>
						</tr>

						<tr height="45">
							<th>관리유형</th>
							<td>
								<?
								if($type == 'self'){
									echo "셀프관리";
								}elseif($type == 'visit'){
									echo "방문관리";
								}
								?>
							</td>
							<th>약정기간</th>
							<td>
								<?=$p_row['code_name']?>
							</td>
						</tr>

						<tr height="45">
							<th>고객명</th>
							<td><?=$user_name?></td>
							<th>연락처</th>
							<td><?=$tel?></td>
						</tr>

						<tr height="45">
							<th>메모사항</th>
							<td colspan='3'>
								<?=$comment?>
							</td>
						</tr>


						<tr height="45">
							<th>상태</th>
							<td colspan='3'>
								<select name="status" id="status" onchange="status_chg('<?=$idx?>', this.value)">
									<option value="1" <?=($status == '1' ? "selected" : "")?>>확인 중</option>
									<option value="2" <?=($status == '2' ? "selected" : "")?>>확인 완료</option>
									<option value="3" <?=($status == '3' ? "selected" : "")?>>보류</option>
								</select>
							</td>
						</tr>

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
		url:"status_chg.php"
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

function del_it(){
	var idx = "<?=$idx?>";

	if( confirm("삭제하시겠습니까?\r\n삭제 후에는 복구가 불가능합니다.") == false){
		return false;
	}else{
		$.ajax({
			 url:"consult_del.php"
			,data:"idx="+idx
			,type:"GET"
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
						location.href='./consult_list.php';
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
</script>

<? include "../_include/_footer.php"; ?>