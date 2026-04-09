<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('styles'); ?>
    <link rel="stylesheet" href="/assets/css/pages/subs/ci_introduction.css">
<?php $this->endSection(); ?>
<?php $this->section('content'); ?>
<main id="container" class="main main_new">
    <section class="ci-intro dif">

        <div class="ci-bc">
            <a href="#" class="ci-bc__item">HOME</a>
            <a href="#" class="ci-bc__item">협회 소개</a>

            <a href="#" class="ci-bc__item ci-bc__item--select">
                CI소개
                <img class="ci-bc__ico" src="/assets/img/sub/ico_select_down.png" alt="">
            </a>
        </div>

        <h1 class="ci-title">CI 소개</h1>

        <nav class="ci-tab">
            <a href="/greeting">협회 인사말</a>
            <a href="/history">설립 목적 및 연혁</a>
            <a href="/vision">비전</a>
            <a href="/organization_guide">조직 안내</a>
            <a href="/ci_introduction" class="is-active">CI 소개</a>
            <a href="/past_presidents">역대회장</a>
            <a href="/directions">오시는 길</a>
        </nav>

        <div class="ci-visual">
            <picture>
                <source srcset="/assets/img/sub/ci_visual_brand_mobile.png" media="(max-width: 720px)">
                <img src="/assets/img/sub/ci_visual_brand.png" alt="">
            </picture>

            <div class="ci-visual-text">
                <p class="text-en">About k-slope</p>
                <p class="text-en-small">Korea Slope Safety Association</p>
            </div>
        </div>

    </section>

    <section class="ci-story">


        <div class="ci-head">
            <h3 class="ci-title-sub dif">슬로건</h3>
            <div class="ci-block">

                <div class="ci-slogan">
                    미래 급경사지 기술을 선도하는 <br>
                    국민의 안전 파트너
                </div>

                <p class="ci-block-desc dif2">
                    한국급경사지안전협회 슬로건은 IoT(사물인터넷), AI(인공지능), BigData(빅데이터)등의 <br>
                    미래기술을 급경사지 기술과 융합하여 급경사지 안전관 리 및 방재역량을 향상시키는데 <br>
                    기여함으로써 국민의 생명과 재산을 보호하기 위한 협회의 의지를 표현함
                </p>
            </div>
        </div>
        <!-- <img src="/assets/img/sub/ci_deco_square.png"
            alt=""
            class="ci-deco ci-deco--left"> -->

        <img src="/assets/img/sub/ci_deco_illust.png" alt="" class="ci-deco ci-deco--right">

        <div class="ci-head">
            <h3 class="ci-title-sub">CI 스토리</h3>
            <div class="ci-visual-sub pc-only">
                <img src="/assets/img/sub/ci_symbol.png" alt="CI Symbol">
                <img src="/assets/img/sub/ci_logo.png" alt="CI Logo">
            </div>
            <div class="mo-only">
                <div class="ci-visual-sub">
                    <img src="/assets/img/sub/ci_symbol.png" alt="CI Symbol">
                </div>
                <div class="ci-visual-sub">
                    <img src="/assets/img/sub/ci_logo.png" alt="CI Logo">
                </div>
            </div>
        </div>

        <div class="ci-head">
            <h3 class="ci-title-none"></h3>
            <div class="ci-block">
                <h4 class="ci-block-title">Symbol</h4>
                <p class="ci-block-desc">
                    한국급경사지안전협회의 CI는 급경사지를 표현하는 황금색의 바탕에 IoT 분야를 대표하는 계측기와 급경사지 보강공법인 앵커를 <br>
                    형상화하여 표현하였으며, 협회가 급경사지 기술을 활용하여 국민의 안전을 도모한다는 의미로 녹색의 방패를 형상화함으로써 <br>
                    협회의 비전이자 슬로건인 “미래 급경사지 기술을 선도하는 국민의 안전 파트너”를 이미지화함
                </p>
            </div>
        </div>

        <div class="ci-head">
            <h3 class="ci-title-none"></h3>
            <div class="ci-block">
                <h4 class="ci-block-title">컬러상징</h4>
                <p class="ci-block-desc">
                    컬러는 한국급경사지안전협회 아이덴티티를 형성하는 중요한 요소로, 인쇄 시에는 cmyk 컬러는 준수하여 예시된 색상에 <br>
                    가장 가까운 최적의 상태가 되도록 유지한다.
                </p>
                <ul class="ci-color-list">
                    <li class="ci-color red">
                        <span class="ci-color-box">Fresh Green</span>
                        <p>친환경·신뢰·성장</p>
                    </li>
                    <li class="ci-color gray">
                        <span class="ci-color-box">Primary Blue</span>
                        <p>안정감·전문성·테크</p>
                    </li>
                    <li class="ci-color black">
                        <span class="ci-color-box">Navy Blue</span>
                        <p>고급·신뢰·프리미엄</p>
                    </li>
                </ul>
            </div>
        </div>

    </section>


</main>
<?php $this->endSection(); ?>