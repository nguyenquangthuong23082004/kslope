<? include "../_include/_header.php"; ?>

<link rel="stylesheet" href="/admin/css/statistics.css" type="text/css" />
<link rel="stylesheet" href="/admin/js/statistics.js">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/gh/xpressengine/xeicon@latest/xeicon.min.css">

<?php
$years  = $_GET['years'] ?? date('Y');
$months = $_GET['months'] ?? date('m');
$weeks  = $_GET['weeks'] ?? null;
$payin  = $_GET['payin'] ?? null;

$where_week = "";

if (!empty($weeks)) {
    $weeks = (int)$weeks;
    $where_week = "
    AND WEEK(regdate, 1) = (
        WEEK(DATE('$years-$months-01'), 1) + ".($weeks - 1)."
    )
    ";
}


$yoil_arr = [1 => "일", 2 => "월", 3 => "화", 4 => "수", 5 => "목", 6 => "금", 7 => "토"];

$sum_col = '(itemCnt_P + itemCnt_M)';
if ($payin === 'P') $sum_col = 'itemCnt_P';
if ($payin === 'M') $sum_col = 'itemCnt_M';

$sql = "
    SELECT DAYOFWEEK(regdate) AS time_unit, SUM($sum_col) AS tcnt
    FROM tbl_login_device
    WHERE YEAR(regdate) = '$years'
      AND MONTH(regdate) = '$months'
      $where_week
    GROUP BY time_unit
";


$result = mysqli_query($connect, $sql);

$price_arr = array_fill(1, 7, 0);
while ($row = mysqli_fetch_assoc($result)) {
    $price_arr[$row['time_unit']] = $row['tcnt'];
}

$_total_cnt = array_sum($price_arr);
function getWeeksOfMonth($year, $month) {
    $weeks = [];
    $first_day = date('Y-m-01', strtotime("$year-$month-01"));
    $last_day = date('Y-m-t', strtotime($first_day));
    $start = strtotime($first_day);
    $end = strtotime($last_day);

    $week = [];
    for ($i = $start; $i <= $end; $i += 86400) {
        $day_of_week = date('N', $i);
        if ($day_of_week == 1 || empty($week['start'])) {
            $week['start'] = date('Y-m-d', $i);
        }
        $week['end'] = date('Y-m-d', $i);
        if ($day_of_week == 7) {
            $weeks[] = $week;
            $week = [];
        }
    }
    if (!empty($week)) $weeks[] = $week;
    return $weeks;
}
$week_arr = getWeeksOfMonth($years, $months);
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
                    <li class="contentMenuSub ">
                        <a href="member_statistics4.php">검색어통계</a>
                    </li>
                    <li class="contentMenuSub ">
                        <a href="member_statistics5.php"> 접속경로관리</a>
                    </li>
                </ul>
                <div class="contentBar left" style="left: 1215.55px; display: none;"></div>
                <div class="contentBar right" style="left: 1459px; display: none;"></div>

            </div>
            <div class="content">

                <div class="listLine"></div>
                <div class="d-flex justify-content-between">
                    <div class="listSelect size09">
                        <form name="modifyForm1" method="get" action="member_statistics3.php" autocomplete="off">
                            <input type="hidden" name="mode" value="time">
    
                            <div class="firstLine selectYear d-flex gap-2" style="padding-left:0">
                                <select name="years" onchange="fn_search()" class="form-select">
                                    <?php for ($ys = 2024; $ys <= date('Y'); $ys++) { ?>
                                        <option value="<?= $ys ?>" <?php if ($ys == $years) echo "selected"; ?>><?= $ys ?>년</option>
                                    <?php } ?>
                                </select>
    
                                <select name="months" onchange="fn_search()" class="form-select">
                                    <?php for ($ms = 1; $ms <= 12; $ms++) { ?>
                                        <option value="<?= $ms ?>" <?php if ($ms == $months) echo "selected"; ?>><?= $ms ?>월</option>
                                    <?php } ?>
                                </select>
    
                                <select name="weeks" onchange="fn_search()" class="form-select" style="width:250px">
                                    <option value="">전체</option>
                                    <?php
                                    $week_arr = getWeeksOfMonth($years, $months);
                                    foreach ($week_arr as $index => $week) {
                                    ?>
                                        <option value="<?= $index + 1 ?>" <?php if ($weeks == ($index + 1)) echo "selected"; ?>><?= $index + 1 ?>주 (<?= $week['start'] ?>~<?= $week['end'] ?>)</option>
                                    <?php } ?>
                                </select>
    
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
                                <li class="contentMenuSub " data-mode="year" style="width: calc(20% - 2px);">
                                    <a href="member_statistics3_year.php">년별통계</a>
                                </li>
                                <li class="contentMenuSub " data-mode="month" style="width: calc(20% - 2px);">
                                    <a href="member_statistics3_month.php">월별통계</a>
                                </li>
                                <li class="contentMenuSub " data-mode="day" style="width: calc(20% - 2px);">
                                    <a href="member_statistics3_day.php">일별통계</a>
                                </li>
                                <li class="contentMenuSub selected" data-mode="week" style="width: calc(20% - 2px);">
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
                        google.charts.load('current', {
                            'packages': ['corechart']
                        });
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                                ['요일', '명'],
                                ['일', <?= $price_arr[1] ?>],
                                ['월', <?= $price_arr[2] ?>],
                                ['화', <?= $price_arr[3] ?>],
                                ['수', <?= $price_arr[4] ?>],
                                ['목', <?= $price_arr[5] ?>],
                                ['금', <?= $price_arr[6] ?>],
                                ['토', <?= $price_arr[7] ?>]
                            ]);


                            var options = {
                                title: '',
                                curveType: '',
                                legend: {
                                    position: 'bottom'
                                },
                                tooltip: {
                                    isHtml: true
                                } // HTML 툴팁 사용
                            };

                            var chart = new google.visualization.LineChart(document.getElementById('curve_chart1'));

                            chart.draw(data, options);
                        }
                    </script>

                    <table class="listIn fixed-header">
                        <thead>
                            <tr>
                                <th>시간대</th>
                                <th>방문자수</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($yoil_arr as $i => $yoil): ?>
                                <?php
                                    $count = $price_arr[$i] ?? 0; 
                                    $percent = $_total_cnt > 0 ? round($count / $_total_cnt * 100, 2) : 0;
                                ?>
                                <tr>
                                    <td class="number"><?= $yoil ?></td>
                                    <td class="number"><?= number_format($count) ?> <br> <span><?= $percent ?>%</span></td>
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
    $(document).click(function(event) {
        var heapBox = event.target.closest(".heapBox.heapBoxBo");

        if (heapBox) {
            $(".heap").hide();
            var heap = $(heapBox).find(".heap");
            heap.toggle();
        } else {
            $(".heap").hide();
        }
    });

    function fn_search(){
        let frm = document.modifyForm1;
        frm.submit();

    }
</script>

<? include "../_include/_footer.php"; ?>