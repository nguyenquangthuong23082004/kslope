<? include "../_include/_header.php"; ?>

    <div id="container" class="gnb_statistics">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				<div class="inner">
					<h2>상품분석</h2>
				</div><!-- // inner -->
			</header><!-- // headerContainer -->

			<div id="contents">
                <div class="statistics_tab">
                    <a href="goods_product.php" class="on">품목별 매출</a>
                    <a href="goods_item.php">상품별 매출</a>
                </div>
                <p class="statistics_notice">통계자료는 국세청 및 기타제출용 자료로 사용이 불가능하며, 쇼핑몰 운영의 참고자료로 이용하시기 바랍니다.</p>

                
                <!-- period_table -->
                <div class="period_table">
                    <form action="#" method="GET">
                        <table cellpadding="0" cellspacing="0" summary="">
                            <colgroup>
                                <col style="width: 150px;">
                                <col style="width: auto;">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>기간검색</th>
                                    <td>
                                        <div class="period_search">
                                            <div class="input_radio">
                                                <input type="radio" name="period" id="period01">
                                                <label for="period01">오늘</label>
                                            </div>
                                            <div class="input_radio">
                                                <input type="radio" name="period" id="period02">
                                                <label for="period02">1주일</label>
                                            </div>
                                            <div class="input_radio">
                                                <input type="radio" name="period" id="period03">
                                                <label for="period03">1개월</label>
                                            </div>
                                            <div class="input_radio">
                                                <input type="radio" name="period" id="period04">
                                                <label for="period04">6개월</label>
                                            </div>
                                            <div class="input_radio">
                                                <input type="radio" name="period" id="period05">
                                                <label for="period05">1년</label>
                                            </div>
                                            <div class="period_input">
                                                <input type="text" name="" id="">
                                                <span>~</span>
                                                <input type="text" name="" id="">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>결제방법</th>
                                    <td>
                                        <select name="" id="">
                                            <option value="">결제수단선택</option>
                                        </select>
                                        <select name="" id="">
                                            <option value="">기간전체</option>
                                        </select>
                                        <button type="button" class="submit_btn">검색</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                <!-- // period_table --> 			
                <!-- graph_wrap -->
                <div class="graph_wrap">
                    <h3>통계 그래프</h3>
                    <div class="graph_area">

                        <div class="small_graph_area">
                            <span style="display: block; width: 100%; height: 100%; line-height: 440px; background: #333; color: #fff; text-align: center; font-size: 30px;">통계 그래프 영역 개발시 이 태그만 삭제</span>
                        </div>
                        <div class="small_graph_area">
                            <span style="display: block; width: 100%; height: 100%; line-height: 440px; background: #333; color: #fff; text-align: center; font-size: 30px;">통계 그래프 영역 개발시 이 태그만 삭제</span>                            
                        </div>

                    </div>
                </div>
                <!-- //graph_wrap -->
                


                <!-- statistics_table -->
                <div class="statistics_table">
                    <div class="table_util">
                        <select name="" id="" class="view_select">
                            <option value="">100개씩 보기</option>
                        </select>
                        <a href="#" class="excel_down"><span>엑셀 다운로드</span></a>
                    </div>
                    <form name="frm" id="frm">				
                        <table cellpadding="0" cellspacing="0" summary="">
                            <caption></caption>
                            <colgroup>
                            <col style="width:8%;">
                            <col style="width:12%;">
                            <col style="width:auto;">
                            <col style="width:12%;">
                            <col style="width:6%;">
                            <col style="width:6%;">
                            <col style="width:6%;">
                            <col style="width:8%;">
                            <col style="width:12%;">
                        </colgroup>
                            <thead>
                                <tr>
                                    <th>순위</th>
                                    <th>상품코드</th>
                                    <th>상품명/옵션</th>
                                    <th>판매가</th>
                                    <th>재고</th>
                                    <th>결제수량</th>
                                    <th>환불수량</th>
                                    <th>판매수량</th>
                                    <th>판매합계</th>
                                </tr>
                            </thead>	
                            <tbody>
                                <tr>
                                    <td class="center">
                                        1
                                    </td>
                                    <td class="center">
                                        P00000CG
                                    </td>
                                    <td class="left">
                                        <div class="goods_info">
                                            <span class="thumb" style="background-image: url(/data/product/20200429110451.jpg)"></span>
                                            <span class="name">동백샴푸바</span>
                                        </div>
                                    </td>
                                    <td>
                                        660
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        1,000
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        1,000
                                    </td>
                                    <td>
                                        660,000
                                    </td>
                                </tr>
                                <tr>
                                    <td class="center">
                                        2
                                    </td>
                                    <td class="center">
                                        P00000CG
                                    </td>
                                    <td class="left">
                                        <div class="goods_info">
                                            <span class="thumb" style="background-image: url(/data/product/20200429110451.jpg)"></span>
                                            <span class="name">동백샴푸바</span>
                                        </div>
                                    </td>
                                    <td>
                                        660
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        1,000
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        1,000
                                    </td>
                                    <td>
                                        660,000
                                    </td>
                                </tr>
                                <tr>
                                    <td class="center">
                                        3
                                    </td>
                                    <td class="center">
                                        P00000CG
                                    </td>
                                    <td class="left">
                                        <div class="goods_info">
                                            <span class="thumb" style="background-image: url(/data/product/20200429110451.jpg)"></span>
                                            <span class="name">동백샴푸바</span>
                                        </div>
                                    </td>
                                    <td>
                                        660
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        1,000
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        1,000
                                    </td>
                                    <td>
                                        660,000
                                    </td>
                                </tr>
                                <tr>
                                    <td class="center">
                                        4
                                    </td>
                                    <td class="center">
                                        P00000CG
                                    </td>
                                    <td class="left">
                                        <div class="goods_info">
                                            <span class="thumb" style="background-image: url(/data/product/20200429110451.jpg)"></span>
                                            <span class="name">동백샴푸바</span>
                                        </div>
                                    </td>
                                    <td>
                                        660
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        1,000
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        1,000
                                    </td>
                                    <td>
                                        660,000
                                    </td>
                                </tr>
                                <tr>
                                    <td class="center">
                                        5
                                    </td>
                                    <td class="center">
                                        P00000CG
                                    </td>
                                    <td class="left">
                                        <div class="goods_info">
                                            <span class="thumb" style="background-image: url(/data/product/20200429110451.jpg)"></span>
                                            <span class="name">동백샴푸바</span>
                                        </div>
                                    </td>
                                    <td>
                                        660
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        1,000
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        1,000
                                    </td>
                                    <td>
                                        660,000
                                    </td>
                                </tr>
                                <tr>
                                    <td class="center">
                                        6
                                    </td>
                                    <td class="center">
                                        P00000CG
                                    </td>
                                    <td class="left">
                                        <div class="goods_info">
                                            <span class="thumb" style="background-image: url(/data/product/20200429110451.jpg)"></span>
                                            <span class="name">동백샴푸바</span>
                                        </div>
                                    </td>
                                    <td>
                                        660
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        1,000
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        1,000
                                    </td>
                                    <td>
                                        660,000
                                    </td>
                                </tr>
                                <tr>
                                    <td class="center">
                                        7
                                    </td>
                                    <td class="center">
                                        P00000CG
                                    </td>
                                    <td class="left">
                                        <div class="goods_info">
                                            <span class="thumb" style="background-image: url(/data/product/20200429110451.jpg)"></span>
                                            <span class="name">동백샴푸바</span>
                                        </div>
                                    </td>
                                    <td>
                                        660
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        1,000
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        1,000
                                    </td>
                                    <td>
                                        660,000
                                    </td>
                                </tr>
                                <tr>
                                    <td class="center">
                                        8
                                    </td>
                                    <td class="center">
                                        P00000CG
                                    </td>
                                    <td class="left">
                                        <div class="goods_info">
                                            <span class="thumb" style="background-image: url(/data/product/20200429110451.jpg)"></span>
                                            <span class="name">동백샴푸바</span>
                                        </div>
                                    </td>
                                    <td>
                                        660
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        1,000
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        1,000
                                    </td>
                                    <td>
                                        660,000
                                    </td>
                                </tr>
                                <tr>
                                    <td class="center">
                                        9
                                    </td>
                                    <td class="center">
                                        P00000CG
                                    </td>
                                    <td class="left">
                                        <div class="goods_info">
                                            <span class="thumb" style="background-image: url(/data/product/20200429110451.jpg)"></span>
                                            <span class="name">동백샴푸바</span>
                                        </div>
                                    </td>
                                    <td>
                                        660
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        1,000
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        1,000
                                    </td>
                                    <td>
                                        660,000
                                    </td>
                                </tr>
                                <tr>
                                    <td class="center">
                                        10
                                    </td>
                                    <td class="center">
                                        P00000CG
                                    </td>
                                    <td class="left">
                                        <div class="goods_info">
                                            <span class="thumb" style="background-image: url(/data/product/20200429110451.jpg)"></span>
                                            <span class="name">동백샴푸바</span>
                                        </div>
                                    </td>
                                    <td>
                                        660
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        1,000
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        1,000
                                    </td>
                                    <td>
                                        660,000
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                <!-- //statistics_table -->


			</div><!-- // contents -->





		</span><!-- 인쇄 영역 끝 //-->
    </div><!-- // container -->

<? include "../_include/_footer.php"; ?>