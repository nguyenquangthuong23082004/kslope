<?php include "../_include/_header.php"; ?>

<link rel="stylesheet" href="/admin/css/statistics.css" type="text/css" />
<link rel="stylesheet" href="/admin/js/statistics.js">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/gh/xpressengine/xeicon@latest/xeicon.min.css">

<?php
$years  = $_GET['years'] ?? date('Y');
$months = $_GET['months'] ?? date('m');
$days   = $_GET['days'] ?? date('d');

$s_date = date('Y-m-d 00:00:00', strtotime("$years-$months-$days"));
$e_date = date('Y-m-d 23:59:59', strtotime("$years-$months-$days"));

$hour_arr = array_fill(0, 24, 0); 
$hour_arr2 = array_fill(0, 24, 0);

$sql1 = "SELECT HOUR(r_date) AS time_unit, COUNT(*) AS tcnt 
         FROM tbl_member 
         WHERE r_date >= '$s_date' AND r_date <= '$e_date' AND status='1' AND user_level>2
         GROUP BY time_unit";
$res1 = mysqli_query($connect, $sql1);
while ($row = mysqli_fetch_assoc($res1)) {
    $hour_arr[(int)$row['time_unit']] = (int)$row['tcnt'];
}
$_total_cnt = array_sum($hour_arr);

$sql2 = "SELECT HOUR(r_date) AS time_unit, COUNT(*) AS tcnt 
         FROM tbl_member 
         WHERE r_date >= '$s_date' AND r_date <= '$e_date' AND status='0' AND user_level>2
         GROUP BY time_unit";
$res2 = mysqli_query($connect, $sql2);
while ($row = mysqli_fetch_assoc($res2)) {
    $hour_arr2[(int)$row['time_unit']] = (int)$row['tcnt'];
}
$_total_cnt2 = array_sum($hour_arr2);
?>

<div id="container">
    <span id="print_this">
        <div id="contents">
            <div id="mainContentMenu" class="contentMenu">
                <ul>
                    <li class="contentMenuSub selected">
                        <a href="member_statistics.php">회원가입통계</a>
                    </li>
                    <li class="contentMenuSub">
                        <a href="member_statistics3.php">방문자수통계</a>
                    </li>
                    <li class="contentMenuSub">
                        <a href="member_statistics4.php">검색어통계</a>
                    </li>
                    <li class="contentMenuSub">
                        <a href="member_statistics5.php">접속경로관리</a>
                    </li>
                </ul>
            </div>

            <div class="content">
                <div class="listLine"></div>
                
                <div class="d-flex justify-content-between">
                    <div class="listSelect size09">
                        <form name="modifyForm1" method="get" action="member_statistics.php" autocomplete="off">
                            <div class="firstLine selectYear d-flex gap-2" style="padding-left:0">
                                <select name="years" onchange="fn_search()" class="form-select">
                                    <?php for ($ys = 2024; $ys <= date('Y'); $ys++): ?>
                                        <option value="<?= $ys ?>" <?= ($ys == $years) ? "selected" : "" ?>><?= $ys ?>년</option>
                                    <?php endfor; ?>
                                </select>

                                <select name="months" onchange="fn_search()" class="form-select">
                                    <?php for ($ms = 1; $ms <= 12; $ms++): ?>
                                        <option value="<?= $ms ?>" <?= ($ms == $months) ? "selected" : "" ?>><?= $ms ?>월</option>
                                    <?php endfor; ?>
                                </select>

                                <select name="days" onchange="fn_search()" class="form-select">
                                    <?php for ($dt = 1; $dt <= date('t', strtotime("$years-$months-01")); $dt++): ?>
                                        <option value="<?= $dt ?>" <?= ($dt == $days) ? "selected" : "" ?>><?= $dt ?>일</option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </form>
                    </div>
                                        <div class="listSelectR">
                        <div class="contentMenu">
                            <ul>
                                <li class="contentMenuSub " data-mode="year" style="width: calc(20% - 2px);">
                                    <a href="member_statistics_year.php">년별통계</a>
                                </li>
                                <li class="contentMenuSub " data-mode="month" style="width: calc(20% - 2px);">
                                    <a href="member_statistics_month.php">월별통계</a>
                                </li>
                                <li class="contentMenuSub " data-mode="day" style="width: calc(20% - 2px);">
                                    <a href="member_statistics_day.php">일별통계</a>
                                </li>
                                <li class="contentMenuSub " data-mode="week" style="width: calc(20% - 2px);">
                                    <a href="member_statistics_yoil.php">요일별통계</a>
                                </li>
                                <li class="contentMenuSub selected" data-mode="time" style="width: calc(20% - 2px);">
                                    <a href="member_statistics.php">시간별통계</a>
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
                    <table class="listIn">
                        <colgroup>
                            <col width="50%">
                            <col width="50%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>활성회원수</th>
                                <th>비활성회원수</th>
                            </tr>
                        </thead>
                        <tbody class="statistics">
                            <tr>
                                <td>
                                    <p><?= number_format($_total_cnt) ?></p>
                                </td>
                                <td>
                                    <p><?= number_format($_total_cnt2) ?></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="empty10">&nbsp;</div>
                    <div id="chart-area">
                        <div id="curve_chart1"></div>
                    </div>
                    <div class="empty10">&nbsp;</div>

                    <script type="text/javascript">
                        google.charts.load('current', {packages:['corechart']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                                ['시간', '활성', '비활성'],
                                <?php
                                for ($i=0; $i<=23; $i++):
                                    echo "['".str_pad($i,2,'0',STR_PAD_LEFT)."', ".($hour_arr[$i] ?? 0).", ".($hour_arr2[$i] ?? 0)."],";
                                endfor;
                                ?>
                            ]);

                            var options = {
                                title: '',
                                curveType: '',
                                legend: { position: 'bottom' }
                            };

                            var chart = new google.visualization.ColumnChart(document.getElementById('curve_chart1'));
                            chart.draw(data, options);
                        }
                    </script>

                    <table class="listIn fixed-header">
                        <colgroup>
                            <col width="20%">
                            <col width="40%">
                            <col width="40%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>시간대</th>
                                <th>활성회원수</th>
                                <th>비활성회원수</th>
                            </tr>
                        </thead>
                        <tbody class="count_per" id="count_all">
                            <?php for ($i=0; $i<24; $i++): ?>
                                <tr>
                                    <td class="number"><?= str_pad($i,2,'0',STR_PAD_LEFT) ?>:00</td>
                                    <td class="number"><?= $hour_arr[$i] ?> <span><?= ($_total_cnt>0)?round($hour_arr[$i]/$_total_cnt*100,2):0 ?>%</span></td>
                                    <td class="number"><?= $hour_arr2[$i] ?> <span><?= ($_total_cnt2>0)?round($hour_arr2[$i]/$_total_cnt2*100,2):0 ?>%</span></td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </span>
</div>

<script>
    function fn_search(){
        document.modifyForm1.submit();
    }
</script>

<?php include "../_include/_footer.php"; ?>
