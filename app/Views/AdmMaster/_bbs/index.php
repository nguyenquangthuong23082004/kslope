<?
	// 공용 클래스 (+관리자 인증)
	require_once $_SERVER['DOCUMENT_ROOT']."/include/common.php";

	// 메뉴 구분
	$r_code = $_GET['r_code'];
	if($r_code == "") $r_code = "notice";

	// 클래스
	require_once($_SERVER['DOCUMENT_ROOT']."/class/JkBbs.php");
	$Bbs = new JkBbs($r_code);

	$code_info = $Bbs->get_code_info();
	$category_arr = $Bbs->category_arr;

	$scale = 250; // 목록에 표시되는 정보의 수
	$page_cnt = 10; // 페이지 목록에 표시되는 페이지의 수

	$total_cnt = $Bbs->get_total_cnt();
	$total_page = ceil($total_cnt / $scale);

	if($page > $total_page) $page = $total_page;
	if($page < 1) $page = 1;

	$start = ($page - 1) * $scale;
	$Bbs->input['start'] = $start;
	$Bbs->input['scale'] = $scale;

	$list_arr = $Bbs->get_list();
	$list_cnt = count($list_arr);


	// 헤더 (관리자 기본 설정 및 인증)
	require_once $_SERVER['DOCUMENT_ROOT']."/AdmMaster/_include/_header.php";

?>
<script>
	var r_code = "<?=$r_code;?>"; // 게시판 코드

	var total_cnt = <?=$total_cnt * 1;?>; // 검색된 전체 갯수
	var scale = <?=$scale * 1;?>; // 검색된 전체 갯수
	var page = <?=$page * 1;?>; // 현재 페이지 번호

	var sch_param = "<?=$Bbs->sch_param;?>"; // 검색 조건
	var sort_param = "<?=$Bbs->sort_param;?>"; // 정렬 조건
</script>
<script src="index.js"></script>

<style>
	.date_pic { width:100px; text-align:center; }
	.btn_mod, .btn_del { margin:5px; cursor:pointer; }
	.stock_link { color:blue; font-weight:bold; cursor:pointer; }
	#tbl_list tr:hover { background:#eee; }
	#tbl_list tr td { text-align:center; padding:5px; }
	#tbl_list tr td.td_str { text-align:left; }
	#tbl_list tr td.td_num { text-align:right; }
	#tbl_list button { border:1px solid #999; border-radius:3px; background:#f5f5f5; }
	#tbl_list .btn:disabled { color:#bbb; border-color:#ddd; }
	#tbl_list .btn_chk { cursor:pointer; }

	.div_notice { padding:30px 50px; text-align:center; font-size:20px; line-height:30px; font-weight:bold; color:#888; }
</style>

<div id="container">
<span id="print_this"><!-- 인쇄영역 시작 //-->

	<header id="headerContainer">
		
		<div class="inner">
			<h2><?=$code_info['r_title'];?></h2>
			<div class="menus">
				<ul class="first">
					<li><a href="#!" class="btn btn-default" onClick="check_all(true);"><span class="glyphicon glyphicon-ok"></span><span class="txt">전체선택</span></a></li>
					<li><a href="#!" class="btn btn-default" onClick="check_all(false);"><span class="glyphicon glyphicon-remove"></span><span class="txt">선택해체</span></a></li>
					<li><a href="#!" class="btn btn-danger" onClick="go_del_ok('checked');"><span class="glyphicon glyphicon-trash"></span><span class="txt">선택삭제</span></a></li>	
				</ul>

				<ul class="last">
					<li><a href="#!" class="btn btn-primary" onClick="go_form('');"><span class="glyphicon glyphicon-pencil"></span> <span class="txt">글 등록</span></a></li>
				</ul>
			</div>

		</div><!-- // inner -->

	</header><!-- // headerContainer -->

	<div id="contents">

		<div class="listWrap">
			<!-- 안내 문구 필요시 구성 //-->

			<div class="listTop">
				<div class="left">
					<p class="schTxt">■ 총 <span id="str_total_cnt"><?=number_format($total_cnt)?></span>개의 목록이 있습니다.</p>
				</div>

				<div class="right">
					<form name="search" id="frm_sch" method="get" action="<?=$_SERVER['PHP_SELF'];?>">
						<input type="hidden" name="r_code" value="<?=$r_code;?>">
						<!-- ajax 호출용 -->
						<input type="hidden" name="call_type" value="form">
						<!-- <input type="hidden" name="data_type" value="json"> -->
						<input type="hidden" name="cmd" value="ajax_get_list">

						<!-- 정렬 -->
						<input type="hidden" name="sort_item" value="">
						<input type="hidden" name="sort_dir" value="">

						<!-- 페이지 -->
						<input type="hidden" name="start" value="0">
						<input type="hidden" name="scale" value="<?=$scale;?>">
						<input type="hidden" name="page" value="<?=$page;?>">

						<header id="headerContents">
							<select name="scale" id="scale">
								<option <? if($scale == "25") echo "selected";?> value="25">25개씩 표시</option>
								<option <? if($scale == "50") echo "selected";?> value="50">50개씩 표시</option>
								<option <? if($scale == "100") echo "selected";?> value="100">100개씩 표시</option>
							</select>
							&nbsp; 
							상태 : 
							<select name="sch_status">
								<option value="">전체</option>
								<option <? if($sch_status == "Y") echo "selected";?> value="Y">정상</option>
								<option <? if($sch_status == "N") echo "selected";?> value="N">잠김</option>
								<!-- <option <? if($sch_status == "D") echo "selected";?> value="D">삭제</option> -->
							</select>
							<? if($code_info['r_use_answer'] == "Y"){ ?>
							&nbsp; 
							답변 : 
							<select name="sch_answer_status">
								<option value="">전체</option>
								<option <? if($sch_answer_status == "Y") echo "selected";?> value="Y">답변</option>
								<option <? if($sch_answer_status == "N") echo "selected";?> value="N">미답변</option>
							</select>
							<? } ?>
							<? if($code_info['r_use_category'] == "Y"){ ?>
							&nbsp; 
							분류 : 
							<select name="sch_category">
								<option value="">*선택*</option>
								<?
									$is_assoc = $Lib->is_assoc($Bbs->category_arr); // 연관 배열 여부 (bool)
									foreach($Bbs->category_arr as $key => $val){
										if(!$is_assoc) $key = $val;
								?>
								<option value="<?=$key;?>" <? if($key == $sch_category) echo "selected";?>><?=$val;?></option>
								<? } ?>
							</select>

								<? if($code_info['r_use_category2'] == "Y"){ ?>
								<select name="sch_category2">
									<option value="">*선택*</option>
									<?
										foreach($Bbs->category2_arr as $category => $arr){
											$is_assoc = $Lib->is_assoc($arr); // 연관 배열 여부 (bool)
											foreach($arr as $key => $val){
												if(!$is_assoc) $key = $val;
									?>
									<option value="<?=$key;?>" data-category="<?=$category;?>" <? if($key == $sch_category2) echo "selected";?>><?=$val;?></option>
									<?
											}
										}
									?>
								</select>

								<script>
									// 1분류 변경 -> 2차 분류 목록 재설정
									$("select[name='sch_category']").change(function(){
										var old = $("select[name='sch_category2']").val();

										$("select[name='sch_category2'] option").hide();
										$("select[name='sch_category2'] option[value='']").show();
										$("select[name='sch_category2'] option[data-category='"+$("select[name='sch_category']").val()+"']").show();

										if($("select[name='sch_category2'] option[value='"+old+"']").css("display") == "none")
											$("select[name='sch_category2']").val("");
									}).trigger("change");
								</script>
								<? } ?>
							<? } ?>
							&nbsp; 
							<select name="sch_item" style="height:30px;">
								<option <? if($sch_item == "all") echo "selected";?> value="all">전체</option>
								<? if($code_info['r_use_name'] == "Y"){ ?>
								<option <? if($sch_item == "r_name") echo "selected";?> value="r_name">작성자</option>
								<? } ?>
								<? if($code_info['r_use_title'] == "Y"){ ?>
								<option <? if($sch_item == "r_title") echo "selected";?> value="r_title">제목</option>
								<? } ?>
								<? if($code_info['r_use_desc'] == "Y"){ ?>
								<option <? if($sch_item == "r_desc") echo "selected";?> value="r_desc">요약</option>
								<? } ?>
								<? if($code_info['r_use_content'] == "Y"){ ?>
								<option <? if($sch_item == "r_content") echo "selected";?> value="r_content">내용</option>
								<? } ?>
							</select>
							<input type="text" name="sch_value" value="<?=$sch_value?>" class="input_txt placeHolder" rel="" style="width:150px; line-height:28px;" />

							<a href="javascript:go_sch();" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> <span class="txt">검색하기</span></a>
						</header><!-- // headerContents -->
					</form>
				</div>
			</div><!-- // listTop -->

			<div class="listBottom">
				<table id="tbl_list" class="listTable">
					<colgroup>
						<col style="width:15px;">
						<col style="width:50px;">
						<? if($code_info['r_use_category'] == "Y"){ ?>
						<col style="width:100px;">
						<? } ?>
						<? if($code_info['r_use_category2'] == "Y"){ ?>
						<col style="width:100px;">
						<? } ?>
						<? if($code_info['r_use_title'] == "Y"){ ?>
						<col style="width:300px;">
						<? } ?>
						<? if($code_info['r_use_name'] == "Y"){ ?>
						<col style="width:100px;">
						<? } ?>
						<? if($code_info['r_use_file'] == "Y"){ ?>
						<col style="width:120px;">
						<? } ?>
						<col style="width:100px;">
						<col style="width:50px;">
						<? if($code_info['r_use_answer'] == "Y"){ ?>
						<col style="width:100px;">
						<? } ?>
						<col style="width:80px;">
					</colgroup>
					<thead>
						<tr>
							<th><input type="checkbox" onClick="check_all(this.checked);"></th>
							<th>No</th>
							<? if($code_info['r_use_category'] == "Y"){ ?>
							<th data-item="T.r_category">분류</th>
							<? } ?>
							<? if($code_info['r_use_category2'] == "Y"){ ?>
							<th data-item="T.r_category2">분류2</th>
							<? } ?>
							<? if($code_info['r_use_title'] == "Y"){ ?>
							<th data-item="T.r_title">제목</th>
							<? } ?>
							<? if($code_info['r_use_name'] == "Y"){ ?>
							<th data-item="T.r_name">작성자</th>
							<? } ?>
							<? if($code_info['r_use_file'] == "Y"){ ?>
							<th data-item="T.r_file_name">첨부파일</th>
							<? } ?>
							<th>작성일</th>
							<th data-item="T.r_view_cnt">조회</th>
							<? if($code_info['r_use_answer'] == "Y"){ ?>
							<th>답변일</th>
							<? } ?>
							<th>관리</th>
						</tr>
					</thead>
					<tbody>
						<? for($i=0, $no=$total_cnt-$start; $i < $list_cnt; $i++,$no--){ $row = $list_arr[$i]; ?>
						<tr data-idx="<?=$row['r_idx'];?>">
							<td class="td_check"><input type="checkbox" class="check_idx" value="<?=$row['r_idx'];?>"></td>
							<td class="td_no"><?=$no;?></td>
							<? if($code_info['r_use_category'] == "Y"){ ?>
							<td class="td_category btn_view">
								<? if ($r_code == "review") { ?>
								<?=$row['r_category'];?>
								<? } else { ?>
								<!-- <?=$category_arr[$row['r_category']];?> -->
								<?=$row['r_category']?>  
								<? } ?>
							</td>
							<? } ?>

							<? if($code_info['r_use_category2'] == "Y"){ ?>
							<td class="td_category2 btn_view"><?=$row['r_category2'];?></td>
							<? } ?>
							<? if($code_info['r_use_title'] == "Y"){ ?>
							<td class="td_title btn_view" style="text-align:left;cursor:pointer" ><?=$row['r_title'];?>
								<? if ($row['r_cmt_cnt'] > 0) {?>
								(<?=$row['r_cmt_cnt']?>)
								<? } ?>
							
							</td>
							<? } ?>
							<? if($code_info['r_use_name'] == "Y"){ ?>
							<td class="td_name btn_view"><?=$row['r_name'];?></td>
							<? } ?>
							<? if($code_info['r_use_file'] == "Y"){ ?>
							<td class="td_file_name"><?=$row['r_file_name'];?></td>
							<? } ?>
							<td class="td_date"><?=$row['r_date'];?></td>
							<td class="td_view_cnt"><?=number_format($row['r_view_cnt']);?></td>
							<? if($code_info['r_use_answer'] == "Y"){ ?>
							<td class="td_date"><?=($row['r_answer_status'] == "Y") ? $row['r_answer_date'] : "&nbsp;";?></td>
							<? } ?>
							<td class="td_control">
								<img src="/AdmMaster/_images/common/ico_setting2.png" class="btn_mod" alt="관리">
								<img src="/AdmMaster/_images/common/ico_error.png" class="btn_del" alt="삭제">
							</td>
						</tr>
						<? } ?>
					</tbody>
				</table>

				<!-- 
				<xmp id="tmp_tr_ing" style="display:none;">
					<tr>
						<td colspan="20">
							<div class="div_notice">
								잠시만 기다려 주세요.
							</div>
						</td>
					</tr>
				</xmp>

				<xmp id="tmp_tr" style="display:none;">
					<tr data-idx="__BBS_IDX__">
						<td class="td_no">__NO__</td>
						<td class="td_category">__CATEGORY__</td>
						<td class="td_title">__TITLE__</td>
						<td class="td_name">__NAME__</td>
						<td class="td_date">__DATE__</td>
						<td class="td_status">__STR_STATUS__</td>
						<td class="td_control"><img src="/AdmMaster/_images/common/ico_setting2.png" class="btn_mod" alt="관리"></td>
					</tr>
				</xmp>
				-->
			</div>
			<?
				// 페이지 목록
				$start_page = (floor(($page - 1) / $page_cnt) * $page_cnt) + 1;
				$end_page = $start_page + $page_cnt - 1;
				if($end_page > $total_page) $end_page = $total_page;

				$prev_page = ($start_page > 1) ? $start_page - 1 : 1;
				$next_page = ($end_page < $total_page) ? $end_page + 1 : $total_page;
			?>
			<div class='paging mt30'>
				<ul>
					<li class='first'><a href='javascript: go_page(1);' title='Go to next page'>&lt;&lt; 처음</a></li>
					<li class='prev'><a href='javascript: go_page(<?=$prev_page;?>);' title='Go to first page'>&lt; 이전</a></li>
					<? for($p = $start_page; $p <= $end_page; $p++){ ?>
					<li class="<? if($p == $page) echo "active";?>"><a href="javascript: go_page(<?=$p;?>);" title='Go to <?=$p;?> page'><?=$p;?></a></li>
					<? } ?>
					<li class='next'><a href='javascript: go_page(<?=$next_page;?>);' title='Go to next page'>다음 &gt;</a></li>
					<li class='last'><a href='javascript: go_page(<?=$total_page;?>);' title='Go to last page'>맨끝 &gt;&gt;</a></li>
				</ul>
			</div>
			<br>
			<br>

			<div id="headerContainer">
				<div class="inner">
					<div class="menus">
						<ul class="first">
							<li><a href="#!" class="btn btn-default" onClick="check_all(true);"><span class="glyphicon glyphicon-ok"></span><span class="txt">전체선택</span></a></li>
							<li><a href="#!" class="btn btn-default" onClick="check_all(false);"><span class="glyphicon glyphicon-remove"></span><span class="txt">선택해체</span></a></li>
							<li><a href="#!" class="btn btn-danger" onClick="go_del_ok('checked');"><span class="glyphicon glyphicon-trash"></span><span class="txt">선택삭제</span></a></li>	
						</ul>

						<ul class="last">
							<li><a href="#!" class="btn btn-primary" onClick="go_form('');"><span class="glyphicon glyphicon-pencil"></span> <span class="txt">글 등록</span></a></li>
						</ul>
					</div>
				</div><!-- // inner -->
			</div><!-- // headerContainer -->

		</div>
	</div>

</span><!-- print_this -->
</div><!-- container -->

<?
	include_once $_SERVER['DOCUMENT_ROOT']."/AdmMaster/_include/_footer.php";
?>