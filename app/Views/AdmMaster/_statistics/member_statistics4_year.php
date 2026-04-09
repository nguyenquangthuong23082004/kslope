<?php include "../_include/_header.php"; ?>

<link rel="stylesheet" href="/admin/css/statistics.css" type="text/css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/admin/js/statistics.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/gh/xpressengine/xeicon@latest/xeicon.min.css">

<?php
$years = $_GET['years'] ?? date('Y');

$s_date = "$years-01-01";
$e_date = "$years-12-31";

$sql = "
    SELECT keyword, COUNT(*) AS tcnt
    FROM tbl_search_keyword
    WHERE keyword IS NOT NULL
      AND keyword != ''
      AND DATE(regdate) >= '$s_date'
      AND DATE(regdate) <= '$e_date'
    GROUP BY keyword
    ORDER BY tcnt DESC
";
$qry = mysqli_query($connect, $sql);

$data_arr = [];
$total_cnt = 0;
if ($qry) {
    while ($row = mysqli_fetch_assoc($qry)) {
        $data_arr[] = $row;
        $total_cnt += (int)$row['tcnt'];
    }
}

function fn_avg2($cnt, $total) {
    return $total > 0 ? round(($cnt / $total) * 100, 2) : 0;
}
?>

<div id="container">
    <span id="print_this">
        <div id="mainContentMenu" class="contentMenu">
            <ul>
                <li class="contentMenuSub"><a href="member_statistics3.php">방문자수통계</a></li>
                <li class="contentMenuSub selected"><a href="member_statistics4_year.php">검색어통계(연간)</a></li>
                <li class="contentMenuSub"><a href="member_statistics5.php">접속경로관리</a></li>
            </ul>
        </div>

        <div id="contents">
            <div class="content">
                <div class="listLine"></div>

                <div class="d-flex justify-content-between">
                    <div class="listSelect size09">
                        <form name="modifyForm1" method="get" action="" autocomplete="off">
                            <div class="firstLine selectYear d-flex gap-2" style="padding-left:0">
                                <select name="years" onchange="fn_search()" class="form-select">
                                    <?php for($ys=2024; $ys<=date('Y'); $ys++): ?>
                                        <option value="<?= $ys ?>" <?= ($ys==$years)?"selected":"" ?>><?= $ys ?>년</option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </form>
                    </div>

                    <div class="listSelectR">
                        <div class="contentMenu">
                            <ul>
                                <li class="contentMenuSub selected" data-mode="year"><a href="member_statistics4_year.php">년간통계</a></li>
                                <li class="contentMenuSub" data-mode="month"><a href="member_statistics4_month.php">월간통계</a></li>
                                <li class="contentMenuSub" data-mode="week"><a href="member_statistics4_week.php">주간통계</a></li>
                                <li class="contentMenuSub" data-mode="day"><a href="member_statistics4_day.php">일간통계</a></li>
                                <li class="contentMenuSub" data-mode="detail"><a href="member_statistics4.php">특정기간통계</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div id="listArea">
                    <h4><?= $years ?>년 (총 <?= number_format($total_cnt) ?>회)</h4>
                    <table class="listIn fixed-header">
                        <colgroup>
                            <col width="8%"><col width="40%"><col width="20%"><col width="32%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>순위</th>
                                <th>검색어</th>
                                <th>검색수</th>
                                <th>점유률</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rank = count($data_arr);
                            foreach($data_arr as $i => $row):
                                $percent = fn_avg2($row['tcnt'], $total_cnt);
                            ?>
                            <tr>
                                <td class="number"><?= $rank ?></td>
                                <td style="text-align:left;"><?= htmlspecialchars($row['keyword']) ?></td>
                                <td class="number"><?= number_format($row['tcnt']) ?></td>
                                <td>
                                    <div style="display:flex; gap:30px; align-items:center;">
                                        <div class="per_line" id="chart_div_<?= $i ?>"></div>
                                        <div class="floatRight size10 fontMontserrat"><?= $percent ?>%</div>
                                    </div>
                                </td>
                            </tr>
                            <script>
                                google.charts.load('current', { packages: ['corechart', 'bar'] });
                                google.charts.setOnLoadCallback(function() {
                                    var data = google.visualization.arrayToDataTable([
                                        ['Keyword', '%', { role: 'style' }],
                                        ['<?= addslashes($row['keyword']) ?>', <?= $percent ?>, '#4285F4']
                                    ]);
                                    var options = {
                                        legend: { position: 'none' },
                                        hAxis: { viewWindow: { min: 0, max: 100 }, gridlines: { count: 0 }, ticks: [] },
                                        vAxis: { textPosition: 'none' },
                                        height: 30,
                                        width: '100%',
                                        backgroundColor: 'transparent'
                                    };
                                    var el = document.getElementById('chart_div_<?= $i ?>');
                                    if(el) new google.visualization.BarChart(el).draw(data, options);
                                });
                            </script>
                            <?php
                                $rank--;
                            endforeach;
                            ?>
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
