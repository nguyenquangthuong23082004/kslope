<?php $setting = homeSetInfo(); ?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $setting['browser_title'] ?></title>

    <?= $this->include('layout/head') ?>
</head>

<body>
<div id="wrap">
    <?= $this->include('layout/header') ?>

    <?= $this->renderSection('content') ?>

    <?= $this->include('layout/footer') ?>
</div>
</body>

</html>