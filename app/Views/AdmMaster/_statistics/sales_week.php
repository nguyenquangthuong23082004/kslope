<? include "../_include/_header.php"; ?>

    <div id="container" class="gnb_statistics">
		<span id="print_this"><!-- 인쇄영역 시작 //-->

			<header id="headerContainer">
				<div class="inner">
					<h2>매출분석</h2>
				</div><!-- // inner -->
			</header><!-- // headerContainer -->

			<div id="contents">
                <div class="statistics_tab">
                    <a href="sales_day.php">일별 매출</a>
                    <a href="sales_week.php" class="on">주별 매출</a>
                    <a href="sales_month.php">월별 매출</a>
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
                                        최근
                                        <select name="" id="">
                                            <option value="">1</option>
                                            <option value="">2</option>
                                            <option value="">3</option>
                                            <option value="">4</option>
                                            <option value="">5</option>
                                            <option value="">6</option>
                                            <option value="">7</option>
                                        </select>
                                        주
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



                        <span style="display: block; width: 100%; height: 100%; line-height: 440px; background: #333; color: #fff; text-align: center; font-size: 30px;">통계 그래프 영역 개발시 이 태그만 삭제</span>




                    </div>
                </div>
                <!-- //graph_wrap -->
                

                <!-- statistics_table -->
                <div class="statistics_table">
                    <h3>전주/금주 증감추이</h3>
                    <form name="frm" id="frm">				
                    <table>
                    <caption>전주/금주 증감추이</caption>
                            <colgroup>
                                <col style="width:auto;">
                                <col style="width:15%;">
                                <col style="width:10%;">
                                <col style="width:15%;">
                                <col style="width:10%;">
                                <col style="width:15%;">
                                <col style="width:10%;">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col">기간</th>
                                    <th scope="col" colspan="2">결제합계</th>
                                    <th scope="col" colspan="2">환불합계</th>
                                    <th scope="col" colspan="2">순매출</th>
                                </tr>
                            </thead>
                            <tbody class="center middle">
                                <tr>
                                    <td class="center">금주(2020-12-07 ~ 2020-12-11)</td>
                                    <td class="center">165,094,230</td>
                                    <td class="center" rowspan="2">
                                        <span class="red_txt">18.96% 감소</span>
                                    </td>
                                    <td class="center">540,600</td>
                                    <td class="center" rowspan="2">
                                        <span class="red_txt">48.53% 감소</span>
                                    </td>
                                    <td class="center">164,553,630</td>
                                    <td class="center" rowspan="2">
                                        <span class="red_txt">18.81% 감소</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="center">전주(2020-11-30 ~ 2020-12-06)</td>
                                    <td class="center">203,722,640</td>
                                    <td class="center">1,050,300</td>
                                    <td class="center">202,672,340</td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                <!-- //statistics_table -->

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
                                <col style="width:110px;">
                                <col style="width:80px;">
                                <col style="width:80px;">
                                <col style="width:100px;">
                                <col style="width:80px;">
                                <col style="width:80px;">
                                <col style="width:80px;">
                                <col style="width:100px;">
                                <col style="width:100px;">
                                <col style="width:140px;">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th rowspan="2">일자</th>
                                    <th colspan="6">결제완료</th>
                                    <th rowspan="2">결제합계</th>
                                    <th rowspan="2">환불합계</th>
                                    <th rowspan="2">순매출</th>
                                </tr>
                                <tr>
                                    <th>주문수</th>
                                    <th>품목수</th>
                                    <th>상품구매금액</th>
                                    <th>배송비</th>
                                    <th>할인</th>
                                    <th>쿠폰</th>
                                </tr>
                            </thead>	
                            <tbody>
                                <tr>
                                    <td class="date">
                                        2020-12-08(화)
                                    </td>
                                    <td>
                                        248
                                    </td>
                                    <td>
                                        637
                                    </td>
                                    <td>
                                        38,018,450
                                    </td>
                                    <td>
                                        21,500
                                    </td>
                                    <td>
                                        5,110,230
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        32,929,720
                                    </td>
                                    <td>
                                        39,600
                                    </td>
                                    <td>
                                        32,890,120
                                    </td>
                                </tr>
                                <tr>
                                    <td class="date">
                                        2020-12-07(월)
                                    </td>
                                    <td>
                                        248
                                    </td>
                                    <td>
                                        637
                                    </td>
                                    <td>
                                        38,018,450
                                    </td>
                                    <td>
                                        21,500
                                    </td>
                                    <td>
                                        5,110,230
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        32,929,720
                                    </td>
                                    <td>
                                        39,600
                                    </td>
                                    <td>
                                        32,890,120
                                    </td>
                                </tr>
                                <tr>
                                    <td class="date">
                                        2020-12-06(일)
                                    </td>
                                    <td>
                                        248
                                    </td>
                                    <td>
                                        637
                                    </td>
                                    <td>
                                        38,018,450
                                    </td>
                                    <td>
                                        21,500
                                    </td>
                                    <td>
                                        5,110,230
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        32,929,720
                                    </td>
                                    <td>
                                        39,600
                                    </td>
                                    <td>
                                        32,890,120
                                    </td>
                                </tr>
                                <tr>
                                    <td class="date">
                                        2020-12-05(토)
                                    </td>
                                    <td>
                                        248
                                    </td>
                                    <td>
                                        637
                                    </td>
                                    <td>
                                        38,018,450
                                    </td>
                                    <td>
                                        21,500
                                    </td>
                                    <td>
                                        5,110,230
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        32,929,720
                                    </td>
                                    <td>
                                        39,600
                                    </td>
                                    <td>
                                        32,890,120
                                    </td>
                                </tr>
                                <tr>
                                    <td class="date">
                                        2020-12-04(금)
                                    </td>
                                    <td>
                                        248
                                    </td>
                                    <td>
                                        637
                                    </td>
                                    <td>
                                        38,018,450
                                    </td>
                                    <td>
                                        21,500
                                    </td>
                                    <td>
                                        5,110,230
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        32,929,720
                                    </td>
                                    <td>
                                        39,600
                                    </td>
                                    <td>
                                        32,890,120
                                    </td>
                                </tr>
                                <tr>
                                    <td class="date">
                                        2020-12-03(목)
                                    </td>
                                    <td>
                                        248
                                    </td>
                                    <td>
                                        637
                                    </td>
                                    <td>
                                        38,018,450
                                    </td>
                                    <td>
                                        21,500
                                    </td>
                                    <td>
                                        5,110,230
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        32,929,720
                                    </td>
                                    <td>
                                        39,600
                                    </td>
                                    <td>
                                        32,890,120
                                    </td>
                                </tr>
                                <tr>
                                    <td class="date">
                                        2020-12-02(수)
                                    </td>
                                    <td>
                                        248
                                    </td>
                                    <td>
                                        637
                                    </td>
                                    <td>
                                        38,018,450
                                    </td>
                                    <td>
                                        21,500
                                    </td>
                                    <td>
                                        5,110,230
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        32,929,720
                                    </td>
                                    <td>
                                        39,600
                                    </td>
                                    <td>
                                        32,890,120
                                    </td>
                                </tr>
                                <tr>
                                    <td class="date">
                                        2020-12-01(화)
                                    </td>
                                    <td>
                                        248
                                    </td>
                                    <td>
                                        637
                                    </td>
                                    <td>
                                        38,018,450
                                    </td>
                                    <td>
                                        21,500
                                    </td>
                                    <td>
                                        5,110,230
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        32,929,720
                                    </td>
                                    <td>
                                        39,600
                                    </td>
                                    <td>
                                        32,890,120
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="tfoot_label">합계</td>
                                    <td>
                                        4,211
                                    </td>
                                    <td>
                                        4,661
                                    </td>
                                    <td>
                                        258,309,500
                                    </td>
                                    <td>
                                        115,000
                                    </td>
                                    <td>
                                        30,504,900
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        227,919,600
                                    </td>
                                    <td>
                                        698,500
                                    </td>
                                    <td>
                                        227,221,100
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
                <!-- //statistics_table -->


			</div><!-- // contents -->





		</span><!-- 인쇄 영역 끝 //-->
    </div><!-- // container -->

<? include "../_include/_footer.php"; ?>