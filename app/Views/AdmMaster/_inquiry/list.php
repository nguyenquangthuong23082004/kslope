<? include "../_include/_header.php"; ?>
<?
// $g_list_rows = 10;
$g_list_rows = 20;
if ($search_name) {
	$strSql = $strSql . " and replace(" . $search_category . ",'-','') like '%" . str_replace("-", "", $search_name) . "%' ";
}

if ($s_status == "") {
	$s_status = "Y";
}

$dateSql = '';
if ($s_date) {
	$dateSql = $dateSql . " and date_format(regdate, '%Y-%m-%d') >= date_format('" . $s_date . "', '%Y-%m-%d')";
}

if ($e_date) {
	$dateSql = $dateSql . " and date_format(regdate, '%Y-%m-%d') <= date_format('" . $e_date . "', '%Y-%m-%d')";
}


//$strSql = $strSql." and status != 0 and user_level > 1 ";
$total_sql = " select *		
						from tbl_inquiry where 1=1 $strSql $dateSql";

//echo $total_sql;
$result = mysqli_query($connect, $total_sql) or die(mysql_error());
$nTotalCount = mysqli_num_rows($result);
?>
<div class="page-heading mb-4">

	<div class="d-flex justify-content-between align-items-center">
		<header class="d-block d-xl-none pb-2">
			<a href="#" class="d-block burger-btn d-xl-none">
				<i class="bi bi-justify fs-3"></i>
			</a>
		</header>
		<h4 class="text-center">간편상담</h4>
	</div>
</div>
<div id="container" class="gnb_inquiry">
	<span id="print_this"><!-- 인쇄영역 시작 //-->

		<div id="contents">
			<form name="search" id="search">
				<input type="hidden" name="gubun" value="<?= $gubun ?>">
				<header id="listBottom">

					<!-- 시작 -->

					<table cellpadding="0" cellspacing="0" summary="" class="listTable01" style="table-layout:fixed;">
						<colgroup>
							<col width="150">
							<col width="*">
						</colgroup>
						<thead>
							<tr>
								<th colspan="2"></th>
							</tr>
						</thead>
						<tbody>

							<tr>
								<td class="label">기간검색</td>
								<td class="inbox">

									<p style="margin-bottom: 0">
										<select name="date_chker" id="date_chker" class="form-select" style="height: 39px">
											<option value="regdate" <?if($date_chker=="regdate")echo"selected";?> >등록일</option>
										</select>
									</p>

									<div class="contact_btn_box">
										<div>
											<button type="button" rel="<?=date('Y-m-d')?>" class="contact_btn" title="today" style="height: 39px">오늘</button>
											<button type="button" rel="<?=date('Y-m-d', strtotime('-1 week'));?>" class="contact_btn" title="week" style="height: 39px">1주일</button>
											<button type="button" rel="<?=date('Y-m-d', strtotime('-1 month'));?>" class="contact_btn" title="1month" style="height: 39px">1개월</button>
											<button type="button" rel="<?=date('Y-m-d', strtotime('-6 month'));?>" class="contact_btn" title="6month" style="height: 39px">6개월</button>
											<button type="button" rel="<?=date('Y-m-d', strtotime('-1 year'));?>" class="contact_btn" title="year" style="height: 39px">1년</button>
											<input type="text" name="s_date" id="s_date" value="<?=$s_date?>" class="form-control datepicker" style="height: 39px"><span>~</span><input type="text" name="e_date" id="e_date" value="<?=$e_date?>" class="form-control datepicker" style="height: 39px" >
											<div id="time_layer" style="float: left; display: <?= (trim($s_time) == "" && trim($e_time) == "" ? "none" : "") ?>;">
												<select id="s_time" name="s_time" class="form-select" style="height: 39px">
													<option value="">선택</option>
													<?php for($t=1; $t<=23; $t++) { ?>
														<option value="<?=$t?>" <?=((int)($s_time) == $t ? "selected" : "")?> ><?=((int)($t) < 10 ? "0" . (int)($t) : (int)($t))?></option>
													<?php } ?>
												</select> ~
												<select id="e_time" name="e_time" class="form-select" style="height: 39px">
													<option value="">선택</option>
													<?php for($t=1; $t<=23; $t++) { ?>
														<option value="<?=$t?>" <?=((int)($e_time) == $t ? "selected" : "")?> ><?=((int)($t) < 10 ? "0" . (int)($t) : (int)($t))?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
								</td>
							</tr>


							<tr>
								<td class="label">검색어</td>
								<td class="inbox">
									
									<div class="r_box d-flex" style="gap: 10px;">
										<select id="" name="search_category" class="form-select" style="width:112px; height: 39px">
											<!-- <option value="" >전체검색</option> -->
											<option value="user_name" <?if($search_category=="user_name")echo"selected";?> >고객명</option>
											<option value="tel" <?if($search_category=="tel")echo"selected";?> >연락처</option>
										</select>
										<div class="input-group">
											<input type="text" id="search_name" name="search_name" value="<?=$search_name?>" class="form-control placeHolder" placeholder="검색어 입력" style="width:240px" onkeyDown="if(event.keyCode==13)search_it();" />
											<!-- <input type="text" class="form-control" name="search_txt" placeholder="Search" aria-label="Search" value=""> -->
											<button class="btn btn-light" onclick="search_it()"><i class="bi bi-search"></i></button>
										</div>
										<!-- <input type="text" id="search_name" name="search_name" value="<?=$search_name?>" class="input_txt placeHolder" placeholder="검색어 입력" style="width:240px" onkeyDown="if(event.keyCode==13)search_it();" />

										<a href="javascript:search_it()" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> <span class="txt">검색</span></a> -->
									</div>
								</td>
							</tr>

						</tbody>
					</table>
				</header><!-- // headerContents -->
			</form>
			<script>
				function search_it() {
					var frm = document.search;
					if (frm.search_name.value == "검색어 입력") {
						frm.search_name.value = "";
					}
					frm.submit();
				}
			</script>

			<div class="listWrap">
				<!-- 안내 문구 필요시 구성 //-->






				<div class="listTop d-flex justify-content-between gap-2 w-100" style="margin-bottom: 30px">
					<div class="left">
						<p class="schTxt">■ 총 <?= number_format($nTotalCount) ?>개의 목록이 있습니다.</p>
					</div>

					<ul class="last d-flex flex-wrap gap-2">
							<li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), true)" class="btn btn-success">전체선택</a></li>
							<li><a href="javascript:CheckAll(document.getElementsByName('idx[]'), false)" class="btn btn-success">선택해체</a></li>
							<li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li>
							<!-- <li><a href="javascript:status_chg()" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span class="txt">상태값 변경</span></a></li> -->
						</ul>

				</div><!-- // listTop -->






				<form name="frm" id="frm">
					<div class="listBottom">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable">
							<caption></caption>
							<colgroup>
								<col width="60px" />
								<col width="60px" />
								<col width="*" />
								<col width="150px" />
								<col width="200px" />
								<col width="200px" />
								<col width="120px" />
							</colgroup>
							<thead>
								<tr>
									<th>선택</th>
									<th>번호</th>
									<th>이름</th>
									<th>연락처</th>
									<th>범주</th>
									<th>등록일</th>
									<th>관리</th>
								</tr>
							</thead>
							<tbody>
								<?
								$nPage = ceil($nTotalCount / $g_list_rows);
								if ($pg == "") $pg = 1;
								$nFrom = ($pg - 1) * $g_list_rows;

								$sql    = $total_sql . " order by idx desc limit $nFrom, $g_list_rows ";
								$result = mysqli_query($connect, $sql) or die(mysql_error());
								$num = $nTotalCount - $nFrom;

								if ($nTotalCount == 0) {
								?>
									<tr>
										<td colspan=4 style="text-align:center;height:100px">검색된 결과가 없습니다.</td>
									</tr>
								<?
								}
								while ($row = mysqli_fetch_array($result)) {

								?>
									<tr style="height:50px">
										<td><input type="checkbox" name="idx[]" class="idx" value="<?=$row['idx']?>"  /></td>
										<td><?= $num-- ?></td>

										<td class="tac"><?= $row["user_name"] ?></td>

										<td class="tac"><?= $row["tel"] ?></td>
										<td class="tac"><?= $row["category"] ?></td>
										<td class="tac"><?= $row["regdate"] ?></td>
 										<td>
										<a href="javascript:del_it(<?=$row["idx"]?>)" class="btn btn-danger"><i class="bi bi-trash"></i></a>&nbsp;&nbsp;
										</td>
									</tr>
								<?  } ?>





							</tbody>
						</table>
					</div><!-- // listBottom -->
				</form>

				<? echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF] . "?s_status=$s_status&search_category=$search_category&search_name=$search_name&pg=") ?>


				<div id="headerContainer">

					<div class="inner">
						<div class="menus">
							<ul class="first">
								<!-- <li><a href="javascript:CheckAll(document.getElementsByName('m_idx[]'), true)" class="btn btn-success">전체선택</a></li>
									<li><a href="javascript:CheckAll(document.getElementsByName('m_idx[]'), false)" class="btn btn-success">선택해체</a></li>
									<li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li> -->
							</ul>

							<ul class="last">
							</ul>

						</div>

					</div><!-- // inner -->

				</div><!-- // headerContainer -->
			</div><!-- // listWrap -->

		</div><!-- // contents -->





	</span><!-- 인쇄 영역 끝 //-->
</div><!-- // container -->




<script>
	function CheckAll(checkBoxes, checked) {
		var i;
		if (checkBoxes.length) {
			for (i = 0; i < checkBoxes.length; i++) {
				checkBoxes[i].checked = checked;
			}
		} else {
			checkBoxes.checked = checked;
		}

	}

	function SELECT_DELETE() {
		if ($(".idx").is(":checked") == false) {
			alert_("삭제할 내용을 선택하셔야 합니다.");
			return;
		}
		if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false) {
			return;
		}

		$("#ajax_loader").removeClass("display-none");

		$.ajax({
			url: "del_inquiry.php",
			type: "POST",
			data: $("#frm").serialize(),
			error: function(request, status, error) {
				//통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				$("#ajax_loader").addClass("display-none");
			},
			complete: function(request, status, error) {
				//				$("#ajax_loader").addClass("display-none");
			},
			success: function(response, status, request) {
				if (response == "OK") {
					alert_("정상적으로 삭제되었습니다.");
					location.reload();
					return;
				} else {
					alert(response);
					alert_("오류가 발생하였습니다!!");
					return;
				}
			}
		});

	}

	    function del_it(idx) {

                    if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false)
                    {
                        return;
                    }
                    $("#ajax_loader").removeClass("display-none");
                    $.ajax({
                        url: "del_inquiry.php",
                        type: "POST",
                        data: { idx: idx },
                        error : function(request, status, error) {
                        //통신 에러 발생시 처리
                            alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
                            $("#ajax_loader").addClass("display-none");
                        }
                        ,complete: function(request, status, error) {
            //				$("#ajax_loader").addClass("display-none");
                        }
                        , success : function(response, status, request) {
                            if (response == "OK")
                            {
                                alert_("정상적으로 삭제되었습니다.");
                                location.reload();
                                return;
                            } else {
                                alert(response);
                                alert_("오류가 발생하였습니다!!");
                                return;
                            }
                        }
                    });
            
        }
	$(".contact_btn_box .contact_btn").click(function() {
		resetClass();
		$(this).addClass("active");


		var date1 = $(this).attr("rel");
		var date2 = $.datepicker.formatDate('yy-mm-dd', new Date());

		$("#s_date").val(date1);
		$("#e_date").val(date2);

	});

	function resetClass() {
		$(".contact_btn_box .contact_btn").each(function() {
			$(this).removeClass("active");
		});
	}
</script>
<script>
	function view_m(user_id, pg = 1) {
		$('.mileage_popup').css({
			'display': 'block'
		});
		$('html').css({
			'overflow': 'hidden',
			'height': '100%'
		});
		$('#element').on('scroll touchmove mousewheel', function(event) {
			event.preventDefault();
			event.stopPropagation();
			return false;
		});


		$.ajax({
			url: "getpoint.php",
			type: "POST",
			data: "user_id=" + user_id + "&pg=" + pg,
			error: function(request, status, error) {
				//통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				$("#ajax_loader").addClass("display-none");
			},
			complete: function(request, status, error) {
				//				$("#ajax_loader").addClass("display-none");
			},
			success: function(response, status, request) {
				$("#select_cash").html(response);
			}
		});


	}


	function view_c(user_id, pg = 1) {
		$('.cupon_popup').css({
			'display': 'block'
		});
		$('html').css({
			'overflow': 'hidden',
			'height': '100%'
		});
		$('#element').on('scroll touchmove mousewheel', function(event) {
			event.preventDefault();
			event.stopPropagation();
			return false;
		});

		$.ajax({
			url: "getcoupon.php",
			type: "POST",
			data: "user_id=" + user_id + "&pg=" + pg,
			error: function(request, status, error) {
				//통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				$("#ajax_loader").addClass("display-none");
			},
			complete: function(request, status, error) {
				//				$("#ajax_loader").addClass("display-none");
			},
			success: function(response, status, request) {
				$("#select_coupon").html(response);
			}
		});

	}


	$(window).load(function() {
		/*
		$('.open_popup').on('click',function(){
			
			if($(this).hasClass('m_popup')){
				$('.mileage_popup').css({'display':'block'});
			}else if($(this).hasClass('c_popup')){
				$('.cupon_popup').css({'display':'block'});
			}
			$('html').css({'overflow': 'hidden', 'height': '100%'}); 
			$('#element').on('scroll touchmove mousewheel', function(event) {  event.preventDefault();  event.stopPropagation();   return false; });
			
		});
		*/



		$('.mc_close_popup').on('click', function() {
			$('.mc_popup').css({
				'display': 'none'
			});
			$('html').css({
				'overflow': 'auto',
				'height': '100%'
			});
			$('#element').off('scroll touchmove mousewheel');

			$("#select_cash").html("");
			$("#select_coupon").html("");

		});

		$('.mc_popup').on('click', function(e) {

			if ($(e.target).hasClass('mc_popup')) {

				$('.mc_popup').css({
					'display': 'none'
				});
			}
			$('html').css({
				'overflow': 'auto',
				'height': '100%'
			});
			$('#element').off('scroll touchmove mousewheel');

		});
	});
</script>

<style>
	.btn.btn-default {
		border: 1px solid #cccccc;
		padding: 2px 8px;
	}
</style>
<? include "../_include/_footer.php"; ?>