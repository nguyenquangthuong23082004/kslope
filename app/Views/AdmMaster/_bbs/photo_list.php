<? include "../_include/_header.php"; ?>
<div id="container">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				
				<div class="inner">
					<h2>Gallery</h2>
					<div class="menus">
						<ul class="first">
							<li><a href="javascript:CheckAll(document.getElementsByName('bbs_idx[]'), true)" class="btn btn-success">전체선택</a></li>
							<li><a href="javascript:CheckAll(document.getElementsByName('bbs_idx[]'), false)" class="btn btn-success">선택해체</a></li>
							<li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li>
						</ul>
						<ul class="last">							
							<li><a href="#" onClick="pp();" style='cursor:pointer; cursor:hand;' class="btn btn-default"><span class="glyphicon glyphicon-print"></span><span class="txt">인쇄</span></a></li>
							<li><a href="board_write.php?code=<?=$code?>" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span class="txt">글 등록</span></a></li>
						</ul>
					</div>
				</div><!-- // inner -->

			</header><!-- // headerContainer -->

			<div id="contents">
				<header id="headerContents">
					<p>
						<input type="radio" name="search_mode" value="" checked=""> 전체  &nbsp; &nbsp; 
						<input type="radio" name="search_mode" value="subject"> 제목  &nbsp; &nbsp; 
						<input type="radio" name="search_mode" value="content"> 내용  &nbsp; &nbsp; 
						<input type="text" id="" name="search_word" value="" class="input_txt placeHolder" rel="검색어 입력" style="width: 240px; color: rgb(155, 155, 155);">
						<a href="javascript:document.frmSearch.submit();" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> <span class="txt">검색하기</span></a>
					</p>
				</header>
				<div class="listWrap">
					<div class="listTop">
						<div class="left">
							<p class="schTxt">■ 총 10개의 목록이 있습니다.</p>
						</div>
					</div><!-- // listTop -->
					<!-- <div class="gallery-wrap">
						<table class="gallery-list">
							<colgroup>
								<col style="width:25%;">
								<col style="width:25%;">
								<col style="width:25%;">
								<col style="width:25%;">
							</colgroup>
							<tbody>
								<tr>
									<td>
										<div>
											<p class="pic"><img src="/_images/common/sample.png" alt=""></p>
											<p class="pic-info">
												<input type="checkbox"> 제목입니다. 제목입니다. 제목입니다. 제목입니다. 제목입니다.
											</p>
										</div>
									</td>
									<td>
										<div>
											<p class="pic"><img src="/_images/common/sample.png" alt=""></p>
											<p class="pic-info">
												<input type="checkbox"> 제목입니다.
											</p>
										</div>
									</td>
									<td>
										<div>
											<p class="pic"><img src="/_images/common/sample.png" alt=""></p>
											<p class="pic-info">
												<input type="checkbox"> 제목입니다.
											</p>
										</div>
									</td>
									<td>
										<div>
											<p class="pic"><img src="/_images/common/sample.png" alt=""></p>
											<p class="pic-info">
												<input type="checkbox"> 제목입니다.
											</p>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<div>
											<p class="pic"><img src="/_images/common/sample.png" alt=""></p>
											<p class="pic-info">
												<input type="checkbox"> 제목입니다.
											</p>
										</div>
									</td>
									<td>
										<div>
											<p class="pic"><img src="/_images/common/sample.png" alt=""></p>
											<p class="pic-info">
												<input type="checkbox"> 제목입니다.
											</p>
										</div>
									</td>
									<td>
										<div>
											<p class="pic"><img src="/_images/common/sample.png" alt=""></p>
											<p class="pic-info">
												<input type="checkbox"> 제목입니다.
											</p>
										</div>
									</td>
									<td>
										<div>
											<p class="pic"><img src="/_images/common/sample.png" alt=""></p>
											<p class="pic-info">
												<input type="checkbox"> 제목입니다.
											</p>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						</div> -->
						<ul class="gallery-wrap">
							<li class="gallery-list">
								<a href="#">
									<p class="pic"><img src="/_images/common/sample.png" alt=""></p>
									<p class="pic-info">
										<input type="checkbox"> 제목입니다. 제목입니다. 제목입니다. 제목입니다. 제목입니다.
									</p>
								</a>
							</li>
							<li class="gallery-list">
								<a href="#">
									<p class="pic"><img src="/_images/common/sample.png" alt=""></p>
									<p class="pic-info">
										<input type="checkbox"> 제목입니다. 제목입니다. 제목입니다. 제목입니다. 제목입니다.
									</p>
								</a>
							</li>
							<li class="gallery-list">
								<a href="#">
									<p class="pic"><img src="/_images/common/sample.png" alt=""></p>
									<p class="pic-info">
										<input type="checkbox"> 제목입니다. 제목입니다. 제목입니다. 제목입니다. 제목입니다.
									</p>
								</a>
							</li>
							<li class="gallery-list">
								<a href="#">
									<p class="pic"><img src="/_images/common/sample.png" alt=""></p>
									<p class="pic-info">
										<input type="checkbox"> 제목입니다. 제목입니다. 제목입니다. 제목입니다. 제목입니다.
									</p>
								</a>
							</li>
							<li class="gallery-list">
								<a href="#">
									<p class="pic"><img src="/_images/common/sample.png" alt=""></p>
									<p class="pic-info">
										<input type="checkbox"> 제목입니다. 제목입니다. 제목입니다. 제목입니다. 제목입니다.
									</p>
								</a>
							</li>
							<li class="gallery-list">
								<a href="#">
									<p class="pic"><img src="/_images/common/sample.png" alt=""></p>
									<p class="pic-info">
										<input type="checkbox"> 제목입니다. 제목입니다. 제목입니다. 제목입니다. 제목입니다.
									</p>
								</a>
							</li>
							<li class="gallery-list">
								<a href="#">
									<p class="pic"><img src="/_images/common/sample.png" alt=""></p>
									<p class="pic-info">
										<input type="checkbox"> 제목입니다. 제목입니다. 제목입니다. 제목입니다. 제목입니다.
									</p>
								</a>
							</li>
							<li class="gallery-list">
								<a href="#">
									<p class="pic"><img src="/_images/common/sample.png" alt=""></p>
									<p class="pic-info">
										<input type="checkbox"> 제목입니다. 제목입니다. 제목입니다. 제목입니다. 제목입니다.
									</p>
								</a>
							</li>
							<li class="gallery-list">
								<a href="#">
									<p class="pic"><img src="/_images/common/sample.png" alt=""></p>
									<p class="pic-info">
										<input type="checkbox"> 제목입니다. 제목입니다. 제목입니다. 제목입니다. 제목입니다.
									</p>
								</a>
							</li>
							<li class="gallery-list">
								<a href="#">
									<p class="pic"><img src="/_images/common/sample.png" alt=""></p>
									<p class="pic-info">
										<input type="checkbox"> 제목입니다. 제목입니다. 제목입니다. 제목입니다. 제목입니다.
									</p>
								</a>
							</li>
							<li class="gallery-list">
								<a href="#">
									<p class="pic"><img src="/_images/common/sample.png" alt=""></p>
									<p class="pic-info">
										<input type="checkbox"> 제목입니다. 제목입니다. 제목입니다. 제목입니다. 제목입니다.
									</p>
								</a>
							</li>
						</ul>
					

					<div class="paging mt30"><ul><li class="first"><a href="javascript:;" title="Go to next page">&lt;&lt; 처음</a></li><li class="prev"><a href="javascript:;" title="Go to first page">&lt; 이전</a></li><li class="active"><a href="javascript:;" title="Go to 1 page"><strong>1</strong></a></li><li class="next"><a href="javascript:;" title="Go to next page">다음 &gt;</a></li><li class="last"><a href="javascript:;" title="Go to last page">맨끝 &gt;&gt;</a></li></ul></div>
					<div id="headerContainer">
						
						<div class="inner">
							<h2>공지사항</h2>
							<div class="menus">
								<ul class="first">
									<li><a href="javascript:CheckAll(document.getElementsByName('bbs_idx[]'), true)" class="btn btn-success">전체선택</a></li>
									<li><a href="javascript:CheckAll(document.getElementsByName('bbs_idx[]'), false)" class="btn btn-success">선택해체</a></li>
									<li><a href="javascript:SELECT_DELETE()" class="btn btn-danger">선택삭제</a></li>
								</ul>
								<ul class="last">							
									<li><a href="#" onclick="pp();" style="cursor:pointer; cursor:hand;" class="btn btn-default"><span class="glyphicon glyphicon-print"></span><span class="txt">인쇄</span></a></li>
									<li><a href="board_write.php?code=notice" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <span class="txt">글 등록</span></a></li>
								</ul>
								
							</div>

						</div><!-- // inner -->

					</div>


				</div><!-- // listWrap -->

			</div><!-- // contents -->





		</span><!-- 인쇄 영역 끝 //-->
		</div><!-- // container -->


<? include "../_include/_footer.php"; ?>