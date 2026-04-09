<?php include "../_include/_header.php"; ?> 
<?php

$limit      = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$sort       = isset($_GET['sort']) ? $sort = strtoupper($_GET['sort']) : "DESC";
$keyword    = isset($_GET['keyword']) ? trim($_GET['keyword']) : "";
$s_date     = isset($_GET['s_date']) ? $_GET['s_date'] : date('Y-m-d');
$e_date     = isset($_GET['e_date']) ? $_GET['e_date'] : date('Y-m-d');
$pg         = isset($_GET['pg']) ? intval($_GET['pg']) : 1;

$offset = ($pg - 1) * $limit;

$where = " WHERE DATE(regdate) >= '{$s_date}' AND DATE(regdate) <= '{$e_date}' ";

if($keyword !== ''){
    $keyword = mysqli_real_escape_string($connect, $keyword);
    $where .= " AND url LIKE '%{$keyword}%' ";
}

$sql_total = "
    SELECT COUNT(*) AS cnt 
    FROM (
        SELECT 1
        FROM tbl_visit_info
        {$where}
        GROUP BY url, os, browser, ip
    ) AS grouped
";
$res_total = mysqli_query($connect, $sql_total);
$row_total = mysqli_fetch_assoc($res_total);
$total_count = $row_total['cnt'];

$sql = "
    SELECT url, os, browser, ip, COUNT(*) AS visit_count, MIN(regdate) AS first_visit, MAX(regdate) AS last_visit
    FROM tbl_visit_info
    {$where}
    GROUP BY url, os, browser, ip
    ORDER BY last_visit {$sort} 
    LIMIT {$offset}, {$limit}
";
$qry = mysqli_query($connect, $sql);

$visit_list = [];
while($row = mysqli_fetch_assoc($qry)){
    $visit_list[] = $row;
}

$page_count = ceil($total_count / $limit);
$num = $total_count - $offset;


?>


<link rel="stylesheet" href="/admin/css/statistics.css" type="text/css" />
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/gh/xpressengine/xeicon@latest/xeicon.min.css">

<style>
    #contents input[type=text] { height: 31px; }
    .ui-datepicker-trigger { display: none; }
</style>



<div id="container">
<span id="print_this">
<div id="contents">
        <div id="mainContentMenu" class="contentMenu">
            <ul>
                <!-- <li class="contentMenuSub">
                    <a href="member_statistics.php">회원가입통계 </a>
                </li> -->
                <li class="contentMenuSub ">
                    <a href="member_statistics3.php">방문자수통계</a>
                </li>
                <li class="contentMenuSub ">
                    <a href="member_statistics4.php">검색어통계</a>
                </li>
                <li class="contentMenuSub selected">
                    <a href="member_statistics5.php"> 접속경로관리</a>
                </li>
            </ul>
            <div class="contentBar left" style="left: 1215.55px; display: none;"></div>
            <div class="contentBar right" style="left: 1459px; display: none;"></div>
        </div>
        <div class="content">

            <form name="listSearchForm" method="get" action="member_statistics5.php" autocomplete="off">

                <div class="searchBox d-flex">
                    <div>
                        <select name="search_type" class="form-select">
                            <option value="order_num" selected>접속경로</option>
                        </select>
                    </div>

                    <div class="searchBoxIn">
                        <input type="text" class="form-control" name="keyword" value="<?= $keyword ?>" data-search-btn="1" autocomplete="off">
                        <p class="searchIcon2 searchIconBtn">
                            <i class="xi-search masterTooltip" onclick="fn_search();"></i>
                        </p>
                    </div>
                </div>


                <div class="period_search d-flex" style="margin-top:20px;">
                    <div class="period_input d-flex align-items-center gap-2">
                        <input type="text" name="s_date" id="s_date" value="<?= $s_date ?>" readonly class="date_form form-control">
                        <span>~</span>
                        <input type="text" name="e_date" id="e_date" value="<?= $e_date ?>" readonly class="date_form form-control">
                    </div>
                    <button type="submit">검색</button>
                    <button type="button" class="contact_btn" rel="<?= date('Y-m-d'); ?>">오늘</button>
                    <button type="button" class="contact_btn" rel="<?= date('Y-m-d', strtotime('-3 day')); ?>">3일</button>
                    <button type="button" class="contact_btn" rel="<?= date('Y-m-d', strtotime('-7 day')); ?>">7일</button>
                    <button type="button" class="contact_btn" rel="<?= date('Y-m-d', strtotime('-1 month')); ?>">1개월</button>
                </div>


                <div class="listTop d-flex justify-content-between align-items-center mt-3 mb-3">
                    <div class="listLeft" style="font-size:20px;">
                        전체 : <b class="orange"><?= number_format($total_count) ?></b> 건
                    </div>

                    <div class="listRight size10 d-flex gap-2">
                        <div>
                            <select name="sort" onchange="fn_search()" class="form-select" style="height: 39px">
                                <option value="DESC" <?= $sort=="DESC"?"selected":"" ?>>등록일 역순</option>
                                <option value="ASC" <?= $sort=="ASC"?"selected":"" ?>>등록일 순</option>
                            </select>
                        </div>

                        <div>
                            <select name="limit" onchange="fn_search()" class="form-select" style="height: 39px">
                                <?php foreach([10,20,30,40,50,60,70,80,90,100] as $val): ?>
                                <option value="<?=$val?>" <?= ($limit==$val)?"selected":"" ?>><?=$val?>개 보기</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </form>


            <div class="listLine"></div>

            <table class="listIn fixed-header">
                <thead>
                    <tr>
                        <th>번호</th>
                        <th>접속경로</th>
                        <th>운영체제</th>
                        <th>브라우저</th>
                        <th>접속아이피</th>
                        <th>접속시간</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($visit_list as $row): ?>
                    <tr>
                        <td class="number"><?= $num ?></td>
                        <td style="text-align:left; font-size:12px"><?= htmlspecialchars($row['url']) ?></td>
                        <td style="text-align:center;"><?= htmlspecialchars($row['os']) ?></td>
                        <td style="text-align:center;"><?= htmlspecialchars($row['browser']) ?></td>
                        <td><?= htmlspecialchars($row['ip']) ?></td>
                        <td class="number"><?= htmlspecialchars($row['last_visit']) ?></td>
                    </tr>
                    <?php $num--; endforeach; ?>
                </tbody>
            </table>

            <?php echo ipageListing($pg, $page_count, $limit, $_SERVER['PHP_SELF']."?pg="); ?>


        </div>
</div>
</span>
</div>



<script>
function fn_search(){ document.listSearchForm.submit(); }

$(".date_form").datepicker({
    showButtonPanel: true,
    dateFormat: 'yy-mm-dd'
});

$(".contact_btn").click(function(){
    $("#s_date").val($(this).attr("rel"));
    $("#e_date").val("<?= date('Y-m-d') ?>");
});
</script>


<?php include "../_include/_footer.php"; ?>
