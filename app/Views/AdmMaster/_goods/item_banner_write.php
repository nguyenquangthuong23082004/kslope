<? include "../_include/_header.php"; ?>
<!-- <script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js"></script> -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="/summernote/upload.js"></script>
<?
	$idx				= updateSQ($_GET["idx"]);
	$pg					= updateSQ($_GET["pg"]);
	$search_name		= updateSQ($_GET["search_name"]);
	$search_category	= updateSQ($_GET["search_category"]);
	$s_product_code_1	= updateSQ($_GET["s_product_code_1"]);
	$s_product_code_2	= updateSQ($_GET["s_product_code_2"]);

	$titleStr = "제품리스트배너 등록";

	if ($idx)
	{
		$sql					= " select * from tbl_goods_list_bnnr where idx = '".$idx."'";
		$result					= mysqli_query($connect, $sql) or die (mysql_error($connect));
		$row					= mysqli_fetch_object($result);

		foreach($row as $keys => $vals){
			//echo $keys . " => " . $vals . "<br/>";
			${$keys} = $vals;

		}

		$show_cate_arr = explode( "||", substr($show_cate, 1, -1));

		$titleStr = "제품리스트배너 수정";
	}

	$links = "item_banner_list.php";

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
<div id="container" class="gnb_banner"> <span id="print_this"><!-- 인쇄영역 시작 //-->

	<header id="headerContainer">
		<div class="inner">
			<div class="menus">
				<ul >
					<!--
					<li><a href="<?=$links?>?search_gubun=<?=$search_gubun?>&search_category=<?=$search_category?>&search_name=<?=$search_name?>&pg=<?=$pg?>" class="btn btn-secondary"><i class="bi bi-list"></i><span class="txt">리스트</span></a></li>
					-->
					<li><a href="javascript:history.go(-1);" class="btn btn-secondary"><i class="bi bi-list"></i><span class="txt">리스트</span></a></li>


					<? if ($idx) { ?>
					<li><a href="javascript:send_it()" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">수정</span></a></li>
					<li><a href="javascript:del_it()" class="btn btn-danger"><i class="bi bi-trash"></i><span class="txt">삭제</span></a></li>
					<? } else { ?>
					<li><a href="javascript:send_it()" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">등록</span></a></li>
					<? } ?>

				</ul>
			</div>
		</div>
		<!-- // inner -->

	</header>
	<!-- // headerContainer -->


	<div id="contents">
		<div class="listWrap_noline">
			<!--  target="hiddenFrame22"  -->
			<form name="frm" id="frm" action="item_banner_write_ok.php" method="post"  enctype="multipart/form-data" target="hiddenFrame22" > <!--  -->
				<!-- 상품 고유 번호 -->
				<input type="hidden" name="idx" id="idx" value='<?=$idx?>' />

			<div class="listBottom">
				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail" style="table-layout:fixed;">
					<caption>
					</caption>
					<colgroup>
						<col width="20%" />
						<col width="80%" />
					</colgroup>
					<tbody>

						<tr height="45">
							<td colspan="4">
								기본정보
							</td>
						</tr>

						<tr height="45">
							<th>카테고리선택</th>
							<td>

								<select id="category" name="category" class="input_select">
									<option value="">분류</option>
									<?
										$fsql    = "select * from tbl_code where status='Y' and parent_code_no = '0' order by onum desc, code_idx desc";
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
									<option value="<?=$frow["code_no"]?>" <?=($category == $frow["code_no"] ? "selected" : "")?>><?=$frow["code_name"]?> <?=$status_txt?></option>
									<? } ?>

								</select>
							</td>

						</tr>
						<tr height="45">
							<th>사은품명</th>
							<td>
								<input type="text" name='subject' id='subject' value="<?=$subject?>" class="input_txt" style="width:30%">
							</td>
						</tr>
						<tr height="45">
							<th>시간설정</th>
							<td>
								<input type="checkbox" name="show_cate[]" id="show_cate1" value='A' <?=(in_array('A', $show_cate_arr) == true ? "checked" : "" )?>><label for="show_cate1">주간(09:00 ~ 18:00)</label>
								<input type="checkbox" name="show_cate[]" id="show_cate2" value='N' <?=(in_array('N', $show_cate_arr) == true ? "checked" : "" )?>><label for="show_cate2">야간(18:00 ~ 09:00)</label>
								<input type="checkbox" name="show_cate[]" id="show_cate3" value='W' <?=(in_array('W', $show_cate_arr) == true ? "checked" : "" )?>><label for="show_cate3">주말(일요일)</label>
							</td>
						</tr>
						<tr height="45">
							<th>상태</th>
							<td>
								<input type="radio" name="status" id="status_Y" value='Y' <?if($status == 'Y' || $status == ''){echo "checked";}?> >
									<label for="status_Y">게시중</label>
								<input type="radio" name="status" id="status_N" value='N' <?if($status == 'N'){echo "checked";}?>>
									<label for="status_N">게시중지</label>
							</td>
						</tr>
						 <tr>
							<th>세부 사항</th>
							<td><input type="text" id="contents" name="contents" value='<?= $contents ?>'
									class="form-control placeHolder" rel="" style="width:98%"/></td>
						</tr>
						<tr>
							<th>
								글꼴 색상
							</th>
							<td>
								<label>
									<input type="radio" name="color" value="white"
									<?php if($color == "" || $color == "white") echo "checked"; ?>>
									White
								</label>

								<label style="margin-left:15px;">
									<input type="radio" name="color" value="black"
									<?php if($color == "black") echo "checked"; ?>>
									Black
								</label>
							</td>
						</tr>
						<tr height="45">
							<th>링크</th>
							<td>
								<input type="text" name='link' id='link' value="<?=$link?>" class="input_txt" style="width:30%">
							</td>
						</tr>
						<tr height="45">
							<th>우선순위</th>
							<td>
								<input type="text" name="onum" id="onum" value="<?=$onum?>" class="input_txt" style="width:10%">
								<span>(숫자가 높을수록 상위에 노출됩니다.)</span>
							</td>
						</tr>

						

					</tbody>
				</table>

				<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail" style="margin-top:50px;">
					<caption>
					</caption>
					<colgroup>
						<col width="20%" />
						<col width="80%" />
					</colgroup>
					<tbody>
						<tr height="45">
							<td colspan="2">
								이미지 등록
							</td>
						</tr>

						<tr>
							<th>PC이미지</th>
							<td colspan="3">

								<input type="file" name="ufile1"  class="bbs_inputbox_pixel" style="width:500px;margin-bottom:10px" />
								<? if ($ufile1 != "") { ?><br>파일삭제:<input type=checkbox name="del_1" value='Y'><a href="/data/goods_banner/<?=$ufile1?>" class="imgpop"><?=$rfile1?></a><br><br>
								<?$imgs = get_img($ufile1,"/data/goods_banner/","200","200");?>
								<img src="<?=$imgs?>"/>
								<? } ?>
                                <span>* 이미지 사이즈: 1920px*522px</span>
							</td>
						</tr>


						<? for ($i=2;$i<=2;$i++) { ?>
						<tr>
							<th>모바일이미지 </th>
							<td colspan="3">

									<input type="file" name="ufile<?=$i?>"  class="bbs_inputbox_pixel" style="width:500px;margin-bottom:10px" />
									<? if (${"ufile".$i} != "") { ?><br>파일삭제:<input type=checkbox name="del_<?=$i?>" value='Y'><a href="/data/goods_banner/<?=${"ufile".$i}?>" class="imgpop"><?=${"rfile".$i}?></a><br><br>
									<?$imgs = get_img(${"ufile".$i},"/data/goods_banner/","200","200");?>
									<img src="<?=$imgs?>"/>
									<? } ?>
                                    <span>* 이미지 사이즈: 720px*468px</span>
							</td>
						</tr>
						<? } ?>
					



						</tbody>
				</table>

			</div>
			</form>


			<!-- 중복체크 팝업 -->
			<div id="pooup_01" class="popup" >
				<div class="pooup_bg"></div>
				<div class="popup_con">
					<input type="hidden" name="chk_codeType" id="chk_codeType" >
					<input type="hidden" name="chk_codeCnt" id="chk_codeCnt" >
					<h2 class="tit"><span class="code_text"></span>코드 중복 체크</h2>
					<p class="text">- 고객님이 요청하신 <span class="code_text"></span>코드 중복 체크</p>
					<input type="text" name="pop_search" id="pop_search" class="box nothangul">


					<label for="" class="name_search">조회</label>
					<p class="result_text"><strong>코드</strong>를 입력하신 후 조회해주세요.</p>
					<!--
					<p class="result_text">요청하신 <strong>상품코드</strong>는 사용 <span>가능</span> 합니다.</p>
					-->
					<div class="btn_box">
						<p class="ok_btn">사용</p><span>|</span>
						<p class="close_btn">닫기</p>
					</div>
				</div>
			</div>




			<div class="tail_menu">
				<ul>
					<li class="left"></li>
					<li class="right_sub">
						<!--
						<a href="<?=$links?>?search_gubun=<?=$search_gubun?>&search_category=<?=$search_category?>&search_name=<?=$search_name?>&pg=<?=$pg?>" class="btn btn-secondary"><i class="bi bi-list"></i><span class="txt">리스트</span></a>
						-->
						<a href="javascript:history.go(-1);" class="btn btn-secondary"><i class="bi bi-list"></i><span class="txt">리스트</span></a>
						<? if ($idx == "") { ?>
						<a href="javascript:send_it()" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">등록</span></a>
						<? } else { ?>
						<a href="javascript:send_it()" class="btn btn-primary"><i class="bi bi-gear"></i><span class="txt">수정</span></a>
						<a href="javascript:del_it()" class="btn btn-danger"><i class="bi bi-trash"></i><span class="txt">삭제</span></a>
						<? } ?>
					</li>
				</ul>
			</div>






		</div>
		<!-- // listWrap -->

	</div>
	<!-- // contents -->

	</span><!-- 인쇄 영역 끝 //-->
</div>


<iframe width="0" height="0" name="hiddenFrame22" id="hiddenFrame22" style="display:none;"></iframe>

<? include "../_include/_footer.php"; ?>



<!--


-->
<script type="text/javascript">

$('#file_add01').off('change').on('change',function(){
	
	var form = $('#frm')[0]; //전송할 폼
	var formData = new FormData(form);
	formData.append('fileObj', $('input[name=file]')[0].files[0]); //데이터 추가 또는 업로드할 파일

	$.ajax({
		url:"freebies_ajax.php",
		data:formData,
		type:"POST",
		dataType:"json",
		processData:false,
		contentType:false,
		error:function(request, status, error){
			alert("CODE : " + request.status + "\r\nmessage : " + request.reponseText);
			return false;
		},
		success:function(response, status, request){
			if(response.ufile !=''){
				$('#file_show').css({"background-image":"url('/data/product/"+response.ufile+"')"});
				$('input[name=ufile]').val(response.ufile);
				$('input[name=rfile]').val(response.rfile);
			}else{
				alert("오류가 발생하였습니다.");
			}
		}
	})
})

function send_it(){
	var frm = document.frm;
	//oEditors1.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);

	if ( frm.category.value == '')
	{
		frm.category.focus();
		alert("카테고리를 선택해주세요");
		return false;
	}

	if ( frm.subject.value == '')
	{
		frm.subject.focus();
		alert("제목 입력해주세요.");
		return false;
	}

	if ( $('input[name="show_cate[]"]').is(":checked") == false )
	{
		frm.subject.focus();
		alert("시간설정을 해주세요.");
		return false;
	}

	if ( frm.status.checked == false )
	{
		frm.status.focus();
		alert("상태값을 선택해주세요");
		return false;
	}

	frm.submit();
}

</script>

