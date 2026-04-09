<? include "../_include/_header.php"; ?>

<link rel="stylesheet" href="/admin/css/statistics.css" type="text/css" />
<link rel="stylesheet" href="/admin/js/statistics.js">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/gh/xpressengine/xeicon@latest/xeicon.min.css">

<?php
$start_year = $_GET['years'] ?? 2024;
$payin = $_GET['payin'] ?? null;

$sum_col = '(itemCnt_P + itemCnt_M)';
if ($payin === 'P') $sum_col = 'itemCnt_P';
if ($payin === 'M') $sum_col = 'itemCnt_M';

$sql = "
    SELECT YEAR(regdate) AS year_unit, SUM($sum_col) AS tcnt
    FROM tbl_login_device
    WHERE YEAR(regdate) >= '$start_year'
    GROUP BY YEAR(regdate)
    ORDER BY YEAR(regdate)
";

$result = mysqli_query($connect, $sql);

$year_arr = [];
$_total_cnt = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $year_arr[$row['year_unit']] = (int)$row['tcnt'];
    $_total_cnt += (int)$row['tcnt'];
}
?>

<div id="container">
    <span id="print_this">
        <div id="contents">
            <div id="mainContentMenu" class="contentMenu">
                <ul>
                    <!-- <li class="contentMenuSub">
                        <a href="member_statistics.php">회원가입통계 </a>
                    </li> -->
                    <li class="contentMenuSub selected">
                        <a href="member_statistics3.php">방문자수통계</a>
                    </li>
                    <li class="contentMenuSub">
                        <a href="member_statistics4.php">검색어통계</a>
                    </li>
                    <li class="contentMenuSub">
                        <a href="member_statistics5.php">접속경로관리</a>
                    </li>
                </ul>
                <div class="contentBar left" style="left: 1215.55px; display: none;"></div>
                <div class="contentBar right" style="left: 1459px; display: none;"></div>
            </div>

            <div class="content">
                <div class="listLine"></div>
                <div class="d-flex justify-content-between">
                    <div class="listSelect size09">
                        <form name="modifyForm1" method="get" action="member_statistics3_year.php" autocomplete="off">
                            <div class="firstLine selectYear d-flex gap-2" style="padding-left:0">
                                <!-- <select name="years" onchange="fn_search()" class="form-select">
                                    <?php for ($y = 2024; $y <= date('Y'); $y++) { ?>
                                        <option value="<?= $y ?>" <?php if ($y == $start_year) echo "selected"; ?>><?= $y ?>년</option>
                                    <?php } ?>
                                </select> -->

                                <select name="payin" onchange="fn_search()" class="form-select">
                                    <option value="">통합</option>
                                    <option value="P" <?php if ($payin == "P") echo "selected"; ?>>PC</option>
                                    <option value="M" <?php if ($payin == "M") echo "selected"; ?>>모바일</option>
                                </select>
                            </div>
                        </form>
                    </div>

                    <div class="listSelectR">
                        <div class="contentMenu">
                            <ul>
                                <li class="contentMenuSub selected" data-mode="year" style="width: calc(20% - 2px);">
                                    <a href="member_statistics3_year.php">년별통계</a>
                                </li>
                                <li class="contentMenuSub" data-mode="month" style="width: calc(20% - 2px);">
                                    <a href="member_statistics3_month.php">월별통계</a>
                                </li>
                                <li class="contentMenuSub" data-mode="day" style="width: calc(20% - 2px);">
                                    <a href="member_statistics3_day.php">일별통계</a>
                                </li>
                                <li class="contentMenuSub" data-mode="week" style="width: calc(20% - 2px);">
                                    <a href="member_statistics3.php">요일별통계</a>
                                </li>
                            </ul>
                            <div class="contentBar left" style="left: 0px; display: none;"></div>
                            <div class="contentBar right" style="left: 115px; display: none;"></div>

                            <script>
                                var a = 100 / parseInt($(".content .listSelectR .contentMenu ul li").length);
                                $(".content .listSelectR .contentMenuSub").css({
                                    'width': 'calc(' + a + '% - 2px)'
                                });
                            </script>
                        </div>
                    </div>
                </div>

                <div id="listArea">
                    <div class="empty10">&nbsp;</div>
                    <div id="chart-area">
                        <div id="curve_chart1"></div>
                    </div>
                    <div class="empty10">&nbsp;</div>

                    <script type="text/javascript">
                        google.charts.load('current', { packages: ['corechart'] });
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                                ['연도', '방문자수'],
                                <?php foreach ($year_arr as $year => $cnt): ?>
                                    ['<?= $year ?>', <?= $cnt ?>],
                                <?php endforeach; ?>
                            ]);

                            var options = {
                                title: '',
                                legend: { position: 'bottom' },
                                tooltip: { isHtml: true }
                            };

                            var chart = new google.visualization.LineChart(document.getElementById('curve_chart1'));
                            chart.draw(data, options);
                        }
                    </script>

                    <table class="listIn fixed-header">
                        <thead>
                            <tr>
                                <th>연도</th>
                                <th>방문자수</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($year_arr as $year => $cnt): ?>
                                <tr>
                                    <td class="number"><?= $year ?></td>
                                    <td class="number"><?= number_format($cnt) ?> <br> <span><?= $_total_cnt > 0 ? round($cnt / $_total_cnt * 100, 2) : 0 ?>%</span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
                <div class="listLineB"></div>
            </div>
        </div>
    </span>
</div>

<script>
    function fn_search(){
        document.modifyForm1.submit();
    }
</script>

<? include "../_include/_footer.php"; ?>
