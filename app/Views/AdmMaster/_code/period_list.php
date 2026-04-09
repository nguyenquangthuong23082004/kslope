<? include "../_include/_header.php"; ?>
<?
$g_list_rows = 100;


$total_sql = " select *	from tbl_period where 1=1 $strSql ";
$result = mysqli_query($connect, $total_sql) or die (mysql_error());
$nTotalCount = mysqli_num_rows($result);
?>
    <div class="page-heading mb-4">

        <div class="d-flex justify-content-between align-items-center">
            <header class="d-block d-xl-none pb-2">
                <a href="#" class="d-block burger-btn d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <h4 class="text-center">약정기간코드관리</h4>
        </div>
    </div>
    <div id="container" class="gnb_code">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<div class="menus">
						<ul class="first">
						</ul>

						<ul class="last">
							<li><a href="javascript:change_it()" class="btn btn-success">순위변경</a></li>
							<li><a href="period_write.php" class="btn btn-primary"><span
                                            class="glyphicon glyphicon-pencil"></span> <span class="txt">신규등록</span></a></li>
						</ul>
						
					</div>

				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents">

				<div class="listWrap">
					<!-- 안내 문구 필요시 구성 //-->

					
					<div class="listTop">
						<div class="left">
							<p class="schTxt">■ 총 <?= $nTotalCount ?>개의 목록이 있습니다.</p>
						</div>

					</div><!-- // listTop -->
					

					<form name="frm" id="frm">				
					<div class="listBottom">
						<table cellpadding="0" cellspacing="0" summary="" class="listTable">
						<caption></caption>
						<colgroup>
						<col width="70px"/>
						<col width="120px"/>
						<col width="*"/>
                            <!-- <col width="200px" /> -->
						<col width="120px"/>
						<col width="120px"/>
						<col width="120px" />
						
						</colgroup>
						<thead>
							<tr>
								<th>번호</th>
								<th>코드번호</th>
								<th>사은품코드명</th>
                                <!-- <th>이미지</th> -->
								<th>상태</th>	
								<th>우선순위</th>	
								<th>관리</th>
								
							</tr>
						</thead>	
						<tbody>
							<?
                            $nPage = ceil($nTotalCount / $g_list_rows);
                            if ($pg == "") $pg = 1;
                            $nFrom = ($pg - 1) * $g_list_rows;

                            $sql = $total_sql . " order by onum desc, code_idx desc limit $nFrom, $g_list_rows ";
                            $result = mysqli_query($connect, $sql) or die (mysql_error());
                            $num = $nTotalCount - $nFrom;
                            if ($nTotalCount == 0) {
                                ?>
                                <tr>
								<td colspan=5 style="text-align:center;height:100px">검색된 결과가 없습니다.</td>
							</tr>
                                <?
                            }
                            while ($row = mysqli_fetch_array($result)) {
                                ?>
                                <tr style="height:50px">
								<td><?= $num-- ?></td>
								<td class="tac"><?= $row["code_no"] ?></td>
								<td class="tal"><a
                                            href="period_write.php?code_idx=<?= $row["code_idx"] ?>"><?= $row["code_name"] ?></a></td>

                                    <!-- <td class="tal">
									<img src="/data/card/<?= $row["ufile"] ?>" style="max-height:200px">
								</td> -->
								
								<td class="tac">
								<?
                                if ($row["status"] == "Y") {
                                    echo "사용";
                                } elseif ($row["status"] == "N") {
                                    echo "삭제";
                                } elseif ($row["status"] == "C") {
                                    echo "마감";
                                }
                                ?></td>
								<td class="tac">
									<input type="text" name="onum[]" value="<?= $row["onum"] ?>" class="input_txt"
                                           style="width:50px"/>
									<input type="hidden" name="code_idx[]" value="<?= $row["code_idx"] ?>"
                                           class="input_txt"/>
								</td>

                                <td>
									<a href="javascript:del_it(<?=$row["code_idx"]?>)" class="btn btn-danger"><i class="bi bi-trash"></i></a>&nbsp;&nbsp;
								</td>
								
							</tr>
                            <? } ?>




							
						</tbody>
						</table>
					</div><!-- // listBottom -->
					</form>

					<? echo ipageListing($pg, $nPage, $g_list_rows, $_SERVER[PHP_SELF] . "?ca_idx=$ca_idx&search_category=$search_category&search_name=$search_name&pg=") ?>


					<div id="headerContainer">
						
						<div class="inner">
							<div class="menus">
								<ul class="first">
								</ul>

								<ul class="last">
									<li><a href="javascript:change_it()" class="btn btn-success">순위변경</a></li>
									<li><a href="period_write.php" class="btn btn-primary"><span
                                                    class="glyphicon glyphicon-pencil"></span> <span
                                                    class="txt">신규 등록</span></a></li>
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

        function change_it() {
            $.ajax({
                url: "period_change_ajax.php",
                type: "POST",
                data: $("#frm").serialize(),
                error: function (request, status, error) {
                    //통신 에러 발생시 처리
                    alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
                    $("#ajax_loader").addClass("display-none");
                }
                , complete: function (request, status, error) {
//				$("#ajax_loader").addClass("display-none");
                }
                , success: function (response, status, request) {
                    if (response == "OK") {
                        alert_("정상적으로 변경되었습니다.");
                        setTimeout(function () {
                            location.reload();
                        }, 800);
                        return;
                    } else {
                        alert(response);
                        alert_("오류가 발생하였습니다!!");
                        return;
                    }
                }
            });
        }

        function SELECT_DELETE() {
            if ($(".code_idx").is(":checked") == false) {
                alert_("삭제할 내용을 선택하셔야 합니다.");
                return;
            }
            if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false) {
                return;
            }

            $("#ajax_loader").removeClass("display-none");

            $.ajax({
                url: "del.php",
                type: "POST",
                data: $("#frm").serialize(),
                error: function (request, status, error) {
                    //통신 에러 발생시 처리
                    alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
                    $("#ajax_loader").addClass("display-none");
                }
                , complete: function (request, status, error) {
//				$("#ajax_loader").addClass("display-none");
                }
                , success: function (response, status, request) {
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

        function del_it(code_idx) {

                    if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false)
                    {
                        return;
                    }
                    $("#ajax_loader").removeClass("display-none");
                    $.ajax({
                        url: "del_period.php",
                        type: "POST",
                        data: { code_idx: code_idx },
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


    </script>


<? include "../_include/_footer.php"; ?>