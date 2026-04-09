<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('styles'); ?>
    <link rel="stylesheet" href="/assets/css/pages/subs/organization-guide.css">
<?php $this->endSection(); ?>
<?php $this->section('content'); ?>
<main id="container" class="main main_new">
    <section class="ci-intro dif">

        <div class="ci-bc">
            <a href="#" class="ci-bc__item">HOME</a>
            <a href="#" class="ci-bc__item">협회 소개</a>

            <a href="#" class="ci-bc__item ci-bc__item--select">
                조직 안내
                <img class="ci-bc__ico" src="/assets/img/sub/ico_select_down.png" alt="">
            </a>
        </div>

        <h1 class="ci-title">조직안내</h1>

        <nav class="ci-tab">
            <a href="/greeting">협회 인사말</a>
    
            <a href="/history">설립 목적 및 연혁</a>
            <a href="/vision">비전</a>
            <a href="/organization_guide" class="is-active">조직 안내</a>
            <a href="/ci_introduction">CI 소개</a>
            <a href="/past_presidents">역대회장</a>
            <a href="/directions">오시는 길</a>
        </nav>

        <div class="ci-visual">
            <img src="/assets/img/sub/ci_visual_org.png" alt="">
            <div class="ci-visual-text">
             
                <p class="text-en">About k-slope</p>
                <p class="text-en-small">Korea Slope Safety Association</p>
            </div>
        </div>

    </section>
    <section class="org-chart">
        <div class="org-inner">

            <div class="org-title">
                <h2>ORGANIZATION<br>CHART</h2>
            </div>

            <div class="org-map">

                <div class="org-node circle dark">총회</div>
                <div class="org-node pill navy">이사회</div>
                <div class="org-node pill blue">회장</div>

                <div class="org-line-combo"></div>

                <div class="org-node pill-side outline left">고문·자문단</div>
                <div class="org-node pill-side outline right">감사</div>

                <div class="org-node pill-side light bottom-left">사무국</div>
                <div class="org-node pill-side light bottom-right">위원회</div>

            </div>
        </div>
    </section>
</main>
<?php $this->endSection(); ?>