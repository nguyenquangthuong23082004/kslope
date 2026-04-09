<?php include "../_include/_header.php"; ?>

<link rel="stylesheet" href="/admin/css/statistics.css" type="text/css" />
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/gh/xpressengine/xeicon@latest/xeicon.min.css">

<?php
$years  = $_GET['years'] ?? date('Y');

$months_labels = [];
$active_counts = [];
$inactive_counts = [];

for ($m = 1; $m <= 12; $m++) {
    $start_month = date('Y-m-01 00:00:00', strtotime("$years-$m-01"));
    $end_month   = date('Y-m-t 23:59:59', strtotime("$years-$m-01"));
    $label = date('Y-m', strtotime($start_month));

    $months_labels[] = $label;

    $sql1 = "SELECT COUNT(*) AS cnt
             FROM tbl_member
             WHERE r_date >= '$start_month' AND r_date <= '$end_month' AND status='1' AND user_level>2";
    $res1 = mysqli_query($connect, $sql1);
    $row1 = mysqli_fetch_assoc($res1);
    $active_counts[] = (int)$row1['cnt'];

    $sql2 = "SELECT COUNT(*) AS cnt
             FROM tbl_member
             WHERE r_date >= '$start_month' AND r_date <= '$end_month' AND status='0' AND user_level>2";
    $res2 = mysqli_query($connect, $sql2);
    $row2 = mysqli_fetch_assoc($res2);
    $inactive_counts[] = (int)$row2['cnt'];
}
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
                        <form name="modifyForm1" method="get" action="member_statistics_month.php" autocomplete="off">
                            <div class="firstLine selectYear d-flex gap-2" style="padding-left:0">
                                <select name="years" onchange="fn_search()" class="form-select">
                                    <?php for ($ys=2024; $ys<=date('Y'); $ys++): ?>
                                        <option value="<?= $ys ?>" <?= ($ys==$years)?"selected":"" ?>><?= $ys ?>년</option>
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
                                <li class="contentMenuSub selected" data-mode="month" style="width: calc(20% - 2px);">
                                    <a href="member_statistics_month.php">월별통계</a>
                                </li>
                                <li class="contentMenuSub " data-mode="day" style="width: calc(20% - 2px);">
                                    <a href="member_statistics_day.php">일별통계</a>
                                </li>
                                <li class="contentMenuSub " data-mode="week" style="width: calc(20% - 2px);">
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
                                <td><?= number_format(array_sum($active_counts)) ?></td>
                                <td><?= number_format(array_sum($inactive_counts)) ?></td>
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
                                ['월', '활성', '비활성'],
                                <?php
                                foreach($months_labels as $i => $label) {
                                    echo "['$label', ".$active_counts[$i].", ".$inactive_counts[$i]."],";
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
                                <th>월</th>
                                <th>활성회원수</th>
                                <th>비활성회원수</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($months_labels as $i => $label): ?>
                                <tr>
                                    <td><?= $label ?></td>
                                    <td><?= $active_counts[$i] ?> <span><?= (array_sum($active_counts)>0)?round($active_counts[$i]/array_sum($active_counts)*100,2):0 ?>%</span></td>
                                    <td><?= $inactive_counts[$i] ?> <span><?= (array_sum($inactive_counts)>0)?round($inactive_counts[$i]/array_sum($inactive_counts)*100,2):0 ?>%</span></td>
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
