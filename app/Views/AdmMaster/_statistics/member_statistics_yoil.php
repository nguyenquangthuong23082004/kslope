<?php include "../_include/_header.php"; ?>

<link rel="stylesheet" href="/admin/css/statistics.css" type="text/css" />
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/gh/xpressengine/xeicon@latest/xeicon.min.css">

<?php
$years  = $_GET['years'] ?? date('Y');
$months = $_GET['months'] ?? date('m');
$days   = $_GET['days'] ?? date('d');

$s_date = date('Y-m-d 00:00:00', strtotime("$years-$months-$days"));
$e_date = date('Y-m-d 23:59:59', strtotime("$years-$months-$days"));

$week_names = ['월','화','수','목','금','토','일'];
$week_days  = array_fill_keys($week_names, 0);
$week_days2 = array_fill_keys($week_names, 0); 

$sql1 = "SELECT DAYOFWEEK(r_date) AS weekday, COUNT(*) AS tcnt
         FROM tbl_member 
         WHERE r_date >= '$s_date' AND r_date <= '$e_date' AND status='1' AND user_level>2
         GROUP BY weekday";
$res1 = mysqli_query($connect, $sql1);
while ($row = mysqli_fetch_assoc($res1)) {
    $day_idx = $row['weekday']; 
    $names = ['일','월','화','수','목','금','토'];
    $week_days[$names[$day_idx-1]] = (int)$row['tcnt'];
}
$_total_cnt = array_sum($week_days);

$sql2 = "SELECT DAYOFWEEK(r_date) AS weekday, COUNT(*) AS tcnt
         FROM tbl_member 
         WHERE r_date >= '$s_date' AND r_date <= '$e_date' AND status='0' AND user_level>2
         GROUP BY weekday";
$res2 = mysqli_query($connect, $sql2);
while ($row = mysqli_fetch_assoc($res2)) {
    $day_idx = $row['weekday'];
    $names = ['일','월','화','수','목','금','토'];
    $week_days2[$names[$day_idx-1]] = (int)$row['tcnt'];
}
$_total_cnt2 = array_sum($week_days2);

$week_days  = array_merge(array_slice($week_days,1,6), array_slice($week_days,0,1));
$week_days2 = array_merge(array_slice($week_days2,1,6), array_slice($week_days2,0,1));
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
                        <form name="modifyForm1" method="get" action="member_statistics_yoil.php" autocomplete="off">
                            <div class="firstLine selectYear d-flex gap-2" style="padding-left:0">
                                <select name="years" onchange="fn_search()" class="form-select">
                                    <?php for ($ys=2024;$ys<=date('Y');$ys++): ?>
                                        <option value="<?= $ys ?>" <?= ($ys==$years)?"selected":"" ?>><?= $ys ?>년</option>
                                    <?php endfor; ?>
                                </select>
                                <select name="months" onchange="fn_search()" class="form-select">
                                    <?php for ($ms=1;$ms<=12;$ms++): ?>
                                        <option value="<?= $ms ?>" <?= ($ms==$months)?"selected":"" ?>><?= $ms ?>월</option>
                                    <?php endfor; ?>
                                </select>
                                <select name="week" onchange="fn_search()" class="form-select">
                                    <option value="">전체</option>
                                <?php
                                $first_day_of_month = strtotime("$years-$months-01");
                                $last_day_of_month  = strtotime(date('Y-m-t', $first_day_of_month));
                                $week_number = 1;

                                for($start = $first_day_of_month; $start <= $last_day_of_month; $start = strtotime('+1 week', $start)) {
                                    $end = strtotime('+6 days', $start);
                                    if ($end > $last_day_of_month) $end = $last_day_of_month;

                                    $start_str = date('Y-m-d', $start);
                                    $end_str   = date('Y-m-d', $end);

                                    $selected = (isset($_GET['week_start']) && $_GET['week_start'] == $start_str) ? 'selected' : '';
                                    echo "<option value='$week_number' data-start='$start_str' data-end='$end_str' $selected>{$week_number}주 ($start_str ~ $end_str)</option>";

                                    $week_number++;
                                }
                                ?>
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
                                <li class="contentMenuSub selected" data-mode="week" style="width: calc(20% - 2px);">
                                    <a href="member_statistics_yoil.php">요일별통계</a>
                                </li>
                                <li class="contentMenuSub" data-mode="time" style="width: calc(20% - 2px);">
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
                                <td><?= number_format($_total_cnt) ?></td>
                                <td><?= number_format($_total_cnt2) ?></td>
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
                                ['요일', '활성', '비활성'],
                                <?php
                                foreach($week_days as $day => $cnt){
                                    echo "['$day', ".$cnt.", ".$week_days2[$day]."],";
                                }
                                ?>
                            ]);

                            var options = {
                                title: '',
                                legend: { position: 'bottom' }
                            };

                            var chart = new google.visualization.ColumnChart(document.getElementById('curve_chart1'));
                            chart.draw(data, options);
                        }
                    </script>

                    <table class="listIn fixed-header">
                        <colgroup>
                            <col width="33%">
                            <col width="33%">
                            <col width="34%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>요일</th>
                                <th>활성회원수</th>
                                <th>비활성회원수</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($week_days as $day=>$cnt): ?>
                                <tr>
                                    <td><?= $day ?></td>
                                    <td><?= $cnt ?> <span><?= ($_total_cnt>0)?round($cnt/$_total_cnt*100,2):0 ?>%</span></td>
                                    <td><?= $week_days2[$day] ?> <span><?= ($_total_cnt2>0)?round($week_days2[$day]/$_total_cnt2*100,2):0 ?>%</span></td>
                                </tr>
                            <?php endforeach; ?>
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
