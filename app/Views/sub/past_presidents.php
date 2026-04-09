<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
<?php $this->section('styles'); ?>
    <link rel="stylesheet" href="/assets/css/pages/subs/past-presidents.css">
<?php $this->endSection(); ?>
<main id="container" class="main main_new">
    <section class="ci-intro dif">

        <div class="ci-bc">
            <a href="#" class="ci-bc__item">HOME</a>
            <a href="#" class="ci-bc__item">협회 소개</a>

            <a href="#" class="ci-bc__item ci-bc__item--select">
                역대 회장
                <img class="ci-bc__ico" src="/assets/img/sub/ico_select_down.png" alt="">
            </a>
        </div>

        <h1 class="ci-title">역대 회장</h1>

        <nav class="ci-tab">
            <a href="/greeting">협회 인사말</a>
           
            <a href="/history">설립 목적 및 연혁</a>
            <a href="/vision">비전</a>
            <a href="/organization_guide">조직 안내</a>
            <a href="/ci_introduction">CI 소개</a>
            <a href="/past_presidents" class="is-active">역대회장</a>
            <a href="/directions">오시는 길</a>
        </nav>

        <div class="ci-visual">
            <img src="/assets/img/sub/ci_visual_presidents.png" alt="">
            <div class="ci-visual-text">
              
                <p class="text-en">About k-slope</p>
                <p class="text-en-small">Korea Slope Safety Association</p>
            </div>
        </div>

    </section>
    <section class="chairman-history">

        <!-- item 1 -->
        <article class="chairman-item">

            <div class="chairman-left">
                <div class="chairman-bg type-current"></div>

                <div class="chairman-info">

                    <strong class="chairman-term">제 2대 회장(현)</strong>
                    <p class="chairman-title">
                        한국급경사지안전협회
                    </p>
                    <p class="chairman-date">
                        2023.07.20 ~ 재임중
                    </p>
                </div>

                <div class="chairman-avatar">
                    <img src="/assets/img/member/chairman_02.png" alt="전상률">
                </div>
            </div>

            <div class="chairman-right">
                <div class="wrap_right">
                    <h3 class="chairman-name">
                        전상률
                    </h3>
                    <div class="wrap_chairman">
                        <span>JEON SANG RYUL</span>
                        <a href="/past_presidents_detail" class="chairman-more">
                            더보기 <img src="/assets/img/member/next_icon.png" alt="">
                        </a>
                    </div>
                </div>

                <ul class="chairman-career">
                    <li>
                        <span>한려대학교 총장</span>
                        <em>2018.11 ~ 2022.02</em>
                    </li>
                    <li>
                        <span>한려대학교 부총장</span>
                        <em>2018.08 ~ 2018.10</em>
                    </li>
                    <li>
                        <span>한려대학교 건설방재공학과 교수</span>
                        <em>1997.03 ~ 2018.07</em>
                    </li>
                </ul>

            </div>

        </article>

        <!-- item 2 -->
        <article class="chairman-item">

            <div class="chairman-left">
                <div class="chairman-bg type-past"></div>

                <div class="chairman-info">

                    <strong class="chairman-term">제 1대 회장</strong>
                    <p class="chairman-title">
                        한국급경사지안전협회
                    </p>
                    <p class="chairman-date">
                        2020.06.16 ~ 2023.07.20
                    </p>
                </div>

                <div class="chairman-avatar">
                    <img src="/assets/img/member/chairman_01.png" alt="류지협">
                </div>
            </div>

            <div class="chairman-right">
                <div class="wrap_right">
                    <h3 class="chairman-name">
                        류 지 협
                    </h3>
                    <div class="wrap_chairman">
                        <span>Ryu Ji hyeop</span>
                        <a href="/past_presidents_detail" class="chairman-more">
                            더보기 <img src="/assets/img/member/next_icon.png" alt="">
                        </a>
                    </div>
                </div>

                <ul class="chairman-career">
                    <li>
                        <span>한려대학교 총장</span>
                        <em>2018.11 ~ 2022.02</em>
                    </li>
                    <li>
                        <span>한려대학교 부총장</span>
                        <em>2018.08 ~ 2018.10</em>
                    </li>
                    <li>
                        <span>한려대학교 건설방재공학과 교수</span>
                        <em>1997.03 ~ 2018.07</em>
                    </li>
                </ul>
            </div>

        </article>

    </section>

</main>
<?php $this->endSection(); ?>