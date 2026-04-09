<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>교육수료증</title>
    <link href="/css/reset.css" rel="stylesheet" type="text/css">
    <link href="/css/print.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="page" id="print">
    <h2 class="to">No. <?= $order['order_code'] ?></h2>
    <h1 class="print_ttl">교육수료증</h1>

    <div class="user_info">
        <dl>
            <dt>성 명</dt>
            <dd><?= $orderItem['name'] ?></dd>
        </dl>
        <dl>
            <dt>생년월일</dt>
            <dd><?= date('Y-m-d', strtotime($orderItem['birthday'])) ?></dd>
        </dl>
        <dl>
            <dt>소 속</dt>
            <dd><?= $orderItem['sub_company_name'] ?></dd>
        </dl>
        <dl>
            <dt>교육과정</dt>
            <dd><?= $course['course_name'] ?>(<?= $course['number_lecture'] ?>/<?= $course['duration'] ?>일)</dd>
        </dl>
        <dl>
            <dt>교육기간</dt>
            <dd><?= date('Y.m.d', strtotime($course['start_date'])) ?>
                ~ <?= date('Y.m.d', strtotime($course['end_date'])) ?></dd>
        </dl>
        <!--        <dl>-->
        <!--            <dt>유효기간</dt>-->
        <!--            <dd>2025. 12. 18 ~ 2028. 12. 18</dd>-->
        <!--        </dl>-->
    </div>

    <h3 class="certi">
        위 사람은 한국급경사지안전협회에서 실시하는<br>
        상기 <?= date('Y', strtotime($course['end_date'])) ?>년도 <?= $course['course_name'] ?>을 이수하였음을 증명함.
    </h3>

    <div class="certi_sec">
        <p><?= date('Y.m.d', strtotime($course['end_date'])) ?></p>
        <p class="serti_name">한국급경사지안전협회</p>
    </div>
</div>


<script>
    window.onload = function () {
        window.print();
    };
</script>
</body>
</html>