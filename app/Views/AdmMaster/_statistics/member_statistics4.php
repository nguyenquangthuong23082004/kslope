<?php include "../_include/_header.php"; ?>

<link rel="stylesheet" href="/admin/css/statistics.css" type="text/css" />

<script src="/admin/js/statistics.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/gh/xpressengine/xeicon@latest/xeicon.min.css">

<style>
    .ui-datepicker-trigger { display: none; }
</style>

<?php
$s_date = isset($_GET['s_date']) ? trim($_GET['s_date']) : date('Y-m-d');
$e_date = isset($_GET['e_date']) ? trim($_GET['e_date']) : date('Y-m-d');

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $s_date)) $s_date = date('Y-m-d');
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $e_date)) $e_date = date('Y-m-d');

$sql = "
    SELECT keyword, COUNT(*) AS tcnt
    FROM tbl_search_keyword
    WHERE keyword IS NOT NULL
      AND keyword != ''
      AND DATE(regdate) >= '{$s_date}'
      AND DATE(regdate) <= '{$e_date}'
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
$num = count($data_arr);

function fn_avg2($cnt, $total)
{
    if ($total == 0) return 0;
    return round(($cnt / $total) * 100, 2);
}
?>

<div id="container">
    <span id="print_this">
        <div id="mainContentMenu" class="contentMenu">
                <ul>
                    <!-- <li class="contentMenuSub">
                        <a href="member_statistics.php">회원가입통계 </a>
                    </li> -->
                    <li class="contentMenuSub ">
                        <a href="member_statistics3.php">방문자수통계</a>
                    </li>
                    <li class="contentMenuSub selected">
                        <a href="member_statistics4.php">검색어통계</a>
                    </li>
                    <li class="contentMenuSub ">
                        <a href="member_statistics5.php"> 접속경로관리</a>
                    </li>
                </ul>
                <div class="contentBar left" style="left: 1215.55px; display: none;"></div>
                <div class="contentBar right" style="left: 1459px; display: none;"></div>
            </div>
        <div id="contents">
            <div class="content">
                <div class="listLine"></div>
                <div class="d-flex justify-content-between">
                    <div class="listSelect size09">
                        <form method="get" autocomplete="off">
                            <div class="period_search d-flex">
                                <div class="period_input d-flex align-items-center gap-2">
                                    <input type="text" name="s_date" id="s_date" value="<?php echo htmlspecialchars($s_date); ?>" readonly class="date_form form-control">
                                    <span>~</span>
                                    <input type="text" name="e_date" id="e_date" value="<?php echo htmlspecialchars($e_date); ?>" readonly class="date_form form-control">
                                </div>
                                <button type="submit">검색</button>
                                <button type="button" class="contact_btn" rel="<?php echo date('Y-m-d'); ?>">오늘</button>
                                <button type="button" class="contact_btn" rel="<?php echo date('Y-m-d', strtotime('-3 day')); ?>">3일</button>
                                <button type="button" class="contact_btn" rel="<?php echo date('Y-m-d', strtotime('-7 day')); ?>">7일</button>
                                <button type="button" class="contact_btn" rel="<?php echo date('Y-m-d', strtotime('-1 month')); ?>">1개월</button>
                            </div>
                        </form>
                    </div>
                    <div class="listSelectR">
                        <div class="contentMenu">
                            <ul>
                                <li class="contentMenuSub " data-mode="year" style="width: calc(20% - 2px);"><a href="member_statistics4_year.php">년간통계</a></li>
                                <li class="contentMenuSub " data-mode="month" style="width: calc(20% - 2px);"><a href="member_statistics4_month.php">월간통계</a></li>
                                <li class="contentMenuSub " data-mode="week" style="width: calc(20% - 2px);"><a href="member_statistics4_week.php">주간통계</a></li>
                                <li class="contentMenuSub" data-mode="day" style="width: calc(20% - 2px);"><a href="member_statistics4_day.php">일간통계</a></li>
                                <li class="contentMenuSub selected" data-mode="detail" style="width: calc(20% - 2px);"><a href="member_statistics4.php">특정기간통계</a></li>
                            </ul>
                            <div class="contentBar left" style="left: 460px; display: none;"></div>
                            <div class="contentBar right" style="left: 575px; display: none;"></div>
                        </div>
                    </div>
                </div>
                <script>
                    google.charts.load('current', { packages: ['corechart', 'bar'] });
                    google.charts.setOnLoadCallback(drawCharts);

                    function drawCharts() {
                        <?php foreach ($data_arr as $i => $row): ?>
                            drawSingleChart(
                                <?= json_encode($row['keyword']) ?>,
                                <?= json_encode(fn_avg2($row['tcnt'], $total_cnt)) ?>,
                                <?= json_encode("chart_div_" . $i) ?>
                            );
                        <?php endforeach; ?>
                    }

                    function drawSingleChart(keyword, percent, elementId) {
                        var data = google.visualization.arrayToDataTable([
                            ['Keyword', '%', { role: 'style' }],
                            [keyword, percent, '#4285F4']
                        ]);

                        var options = {
                            legend: { position: 'none' },
                            hAxis: { viewWindow: { min: 0, max: 100 }, gridlines: { count: 0 }, ticks: [] },
                            vAxis: { textPosition: 'none' },
                            height: 30,
                            width: '100%',
                            backgroundColor: 'transparent'
                        };

                        var el = document.getElementById(elementId);
                        if (el) {
                            new google.visualization.BarChart(el).draw(data, options);
                        }
                    }
                </script>
                <div id="listArea">
                    <table class="listIn fixed-header">
                        <colgroup>
                            <col width="8%"><col width="20%"><col width="20%"><col width="52%">
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
                            $rank = $num;
                            foreach ($data_arr as $i => $row):
                            ?>
                                <tr>
                                    <td class="number"><?php echo $rank; ?></td>
                                    <td style="text-align:left;"><?php echo htmlspecialchars($row['keyword']); ?></td>
                                    <td class="number"><?php echo number_format($row['tcnt']); ?></td>
                                    <td>
                                        <div style="display:flex; gap:30px; align-items:center;">
                                            <div class="per_line" id="chart_div_<?php echo $i; ?>"></div>
                                            <div class="floatRight size10 fontMontserrat"><?php echo fn_avg2($row['tcnt'], $total_cnt); ?>%</div>
                                        </div>
                                    </td>
                                </tr>
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
    jQuery(function($){
        $(".contact_btn").on('click', function() {
            var relDate = $(this).attr("rel");              
            $("#s_date").val(relDate);                       
            $("#e_date").val("<?php echo date('Y-m-d'); ?>");
            $("form").first().submit();                   
        });
        
    });
$(".date_form").datepicker({
    showButtonPanel: true,
    dateFormat: 'yy-mm-dd'
});
</script>


<?php include "../_include/_footer.php"; ?>
