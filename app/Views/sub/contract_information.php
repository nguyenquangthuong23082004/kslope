<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
<main id="container" class="main main_new">
    <section class="ci-intro dif">

        <div class="ci-bc">
            <a href="#" class="ci-bc__item">HOME</a>
            <a href="#" class="ci-bc__item">업무 안내</a>

            <a href="#" class="ci-bc__item ci-bc__item--select">
                계약 안내
                <img class="ci-bc__ico" src="/assets/img/sub/ico_select_down.png" alt="">
            </a>
        </div>

        <h1 class="ci-title">계약 안내</h1>

        <nav class="ci-tab">
            <a href="/main_tasks">주요 업무</a>
            <a href="/contract_information" class="is-active">계약 안내</a>
            <a href ="/slope_safety">급경사지 안전관리 체계</a>

        </nav>

        <div class="ci-visual">
            <img src="/assets/img/sub/contract_information_banner.png" alt="">
            <div class="ci-visual-text">
                <p class="text_dif">업무 안내</p>
                <p class="text-en">Contract Information</p>
                <p class="text-en-small">Korea Slope Safety Association</p>
            </div>
        </div>

    </section>
    <section class="law-section">
        <div class="law-inner">

            <div class="law-block">
                <h2 class="law-title-contract">사업별 문의처</h2>
                <div class="contact-grid">

                    <!-- card 1 -->
                    <div class="contact-card">
                        <h3>급경사지 실태조사 <br> 문의처</h3>

                        <p class="row">
                            <img src="/assets/img/icon/phone.png">
                            02-1234-5678
                        </p>

                        <p class="row">
                            <img src="/assets/img/icon/mail.png">
                            slope@ksssa.or.kr
                        </p>

                        <p class="row">
                            <img src="/assets/img/icon/time.png">
                            평일 09:00 ~ 18:00
                        </p>
                    </div>

                    <!-- card 2 -->
                    <div class="contact-card">
                        <h3>급경사지 안전점검 <br> 문의처</h3>

                        <p class="row">
                            <img src="/assets/img/icon/phone.png">
                            02-2345-6789
                        </p>

                        <p class="row">
                            <img src="/assets/img/icon/mail.png">
                            safety@ksssa.or.kr
                        </p>

                        <p class="row">
                            <img src="/assets/img/icon/time.png">
                            평일 09:00 ~ 18:00
                        </p>
                    </div>

                    <!-- card 3 -->
                    <div class="contact-card">
                        <h3>급경사지 재해위험도 <br> 평가 문의처</h3>

                        <p class="row">
                            <img src="/assets/img/icon/phone.png">
                            02-2345-6789
                        </p>

                        <p class="row">
                            <img src="/assets/img/icon/mail.png">
                            safety@ksssa.or.kr
                        </p>

                        <p class="row">
                            <img src="/assets/img/icon/time.png">
                            평일 09:00 ~ 18:00
                        </p>
                    </div>

                </div>
            </div>

            <div class="law-block contract">
                <h2 class="law-title-contract2">급경사지 실태조사 문의처</h2>
                <div class="contract-grid">

                    <!-- card 1 -->
                    <div class="contract-card">
                        <div class="contract-left">
                            <h3 class="contract-title">급경사지 실태조사<br>문의처</h3>

                            <p class="contract-row">
                                <img src="/assets/img/icon/phone.png" alt="">
                                02-1234-5678
                            </p>

                            <p class="contract-row">
                                <img src="/assets/img/icon/mail.png" alt="">
                                slope@ksssa.or.kr
                            </p>

                            <p class="contract-row">
                                <img src="/assets/img/icon/time.png" alt="">
                                평일 09:00~18:00
                            </p>
                        </div>

                        <div class="contract-qr">
                            <img src="/assets/img/icon/qr_sample.png" alt="QR">
                        </div>
                    </div>

                    <!-- card 2 -->
                    <div class="contract-card">
                        <div class="contract-left">
                            <h3 class="contract-title">급경사지 실태조사<br>문의처</h3>

                            <p class="contract-row">
                                <img src="/assets/img/icon/phone.png" alt="">
                                02-1234-5678
                            </p>

                            <p class="contract-row">
                                <img src="/assets/img/icon/mail.png" alt="">
                                slope@ksssa.or.kr
                            </p>

                            <p class="contract-row">
                                <img src="/assets/img/icon/time.png" alt="">
                                평일 09:00~18:00
                            </p>
                        </div>

                        <div class="contract-qr">
                            <img src="/assets/img/icon/qr_sample.png" alt="QR">
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </section>


</main>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>




<?php $this->endSection(); ?>