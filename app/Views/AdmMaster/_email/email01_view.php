<? include "../_include/_header.php"; ?>
	<div id="container">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">

				<div class="inner">
					<h2>자동메일설정</h2>
					<div class="menus">
						<ul class="last">
							<li><a href="javascript:history.back();" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a></li>

							<li><a href="board_write.php?scategory=&amp;search_mode=&amp;search_word=&amp;code=notice&amp;bbs_idx=9&amp;pg=1" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a></li>
							<li><a href="javascript:del_chk('9');" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span><span class="txt">삭제</span></a></li>
						</ul>
				</div>
			</div>
			<!-- // inner -->

	</header>
	<!-- // headerContainer -->

	<div id="contents">

		<div class="listWrap email_container email_container01">

			<form name="frm" id="frm" action="bbs_proc.ajax.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="bbs_idx" value="9">
				<input type="hidden" name="article_num" value="1">
				<input type="hidden" name="search_mode" value="">
				<input type="hidden" name="search_word" value="">
				<input type="hidden" name="scategory" value="">
				<input type="hidden" name="code" value="notice">
				<input type="hidden" name="b_step" value="">
				<input type="hidden" name="b_level" value="">
				<input type="hidden" name="b_ref" value="">
				<input type="hidden" name="pg" value="1">
				<input type="hidden" name="mode" value="">
				<div class="listBottom">
					<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail">
						<caption></caption>
						<colgroup>
							<col width="150px">
							<col width="*">
						</colgroup>

						<tbody>
							<tr style="height:45px;">
								<th>메일항목</th>
								<td><input type="text"></td>
							</tr>

							<tr style="height:45px;">
								<th>구분</th>
								<td>
									<input type="radio">자동발송	
									<input type="radio">자동발송안함	
								</td>
							</tr>
							<tr style="height:45px;">
								<th>발송자이름</th>
								<td><input type="text"></td>
							</tr>
							<tr style="height:45px;">
								<th>발송자E-mail</th>
								<td><input type="text"></td>
							</tr>
							<tr style="height:45px;">
								<th>메일제목</th>
								<td><input type="text"></td>
							</tr>
							<tr>
								<th colspan="2"><textarea name="" id="" cols="30" rows="10"></textarea></th>	
							</tr>
						</tbody>
					</table>
				</div>
				<!-- // listBottom -->
			</form>

			<div id="headerContainer">

				<div class="inner">
					<div class="menus">
						<ul class="last">
							<li><a href="board_list.php?scategory=&amp;search_mode=&amp;search_word=&amp;code=notice&amp;bbs_idx=9&amp;pg=1;" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span class="txt">리스트</span></a></li>
							<!--
									<li><a href="board_write.php?scategory=&search_mode=&search_word=&code=notice&bbs_idx=9&pg=1&mode=reply" class="btn btn-default"><span class="glyphicon
									glyphicon-cog"></span><span class="txt">답글</span></a></li>
									-->
							<li><a href="board_write.php?scategory=&amp;search_mode=&amp;search_word=&amp;code=notice&amp;bbs_idx=9&amp;pg=1" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a></li>
							<li><a href="javascript:del_chk('9');" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span><span class="txt">삭제</span></a></li>
						</ul>

					</div>

				</div>
				<!-- // inner -->

			</div>
			<!-- // headerContainer -->
		</div>
		<!-- // listWrap -->

	</div>
	<!-- // contents -->





	</span>
	<!-- 인쇄 영역 끝 //-->
	</div>

	<? include "../_include/_footer.php"; ?>
