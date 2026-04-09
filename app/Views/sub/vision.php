<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('styles'); ?>
    <link rel="stylesheet" href="/assets/css/pages/subs/vision.css">
<?php $this->endSection(); ?>
<?php $this->section('content'); ?>
<main id="container" class="main main_new">
    <section class="ci-intro dif">

        <div class="ci-bc">
            <a href="#" class="ci-bc__item">HOME</a>
            <a href="#" class="ci-bc__item">협회 소개</a>

            <a href="#" class="ci-bc__item ci-bc__item--select">
                비전
                <img class="ci-bc__ico" src="/assets/img/sub/ico_select_down.png" alt="">
            </a>
        </div>

        <h1 class="ci-title">비전</h1>
 
        <nav class="ci-tab"> 
            <a href="/greeting">협회 인사말</a>
            <a href="/history">설립 목적 및 연혁</a>
            <a href="/vision" class="is-active">비전</a>
            <a href="/organization_guide">조직 안내</a>
            <a href="/ci_introduction">CI 소개</a>
            <a href="/past_presidents">역대회장</a>
            <a href="/directions">오시는 길</a>
        </nav>

        <div class="ci-visual">
            <img src="/assets/img/sub/ci_visual_vision.png" alt="">
            <div class="ci-visual-text">
                <p class="text_dif">협회소개</p>
                <p class="text-en">VISION</p>
                <p class="text-en-small">Korea Slope Safety Association</p>
            </div>
        </div>

    </section>

    <section class="vision-section">
        <div class="vision-inner">

            <h3 class="vision-title">비전</h3>

            <p class="vision-main">
                급경사지 안전관리 강화로<br>
                국민의 안전 및 공공복리 증진
            </p>

            <p class="vision-sub">
                스마트 안전관리로 더 튼튼한 급경사지, 더 안전한 국토
            </p>

        </div>
    </section>

    <section class="vision-wrap">
        <div class="vision-box">

            <div class="vision-top">
                <h3 class="title-vision">기술 혁신·융합 고도화</h3>
                <ul>
                    <li>기후위기에 따른 전주기적 급경사지 유지관리 기술 혁신체계 마련</li>
                    <li>급경사지 스마트 기술 융합을 통한 조사·분석·대책수립 기술 강화</li>
                </ul>
            </div>

            <div class="vision-center">
                <img src="/assets/img/sub/vision_new.png" alt="VISION">
            </div>

            <div class= "vision-responsive">
                <div class="vision-left">
                    <h3 class="title-vision">인재 양성·협력 확대</h3>
                    <ul>
                        <li>급경사지 조사점검·평가 계측분야 <br>
                            실무교육을 통한 전문인력 양성</li>
                        <li>급경사지 관련 산·학·연 유기적 <br>
                            협력 기반의 기술 공유 및 증대</li>
                    </ul>
                </div>

                <div class="vision-right">
                    <h3 class="title-vision">국민 안전·정책 지원</h3>
                    <ul>
                        <li>지속가능한 급경사지 안전관리를 <br>
                            통해 국민 안전 강화</li>
                        <li>정부 및 지방자치단체와 유기적 <br>
                            협력을 통한 급경사지 정책 지원</li>
                    </ul>
                </div>
            </div>

        </div>
    </section>






</main>
<?php $this->endSection(); ?>