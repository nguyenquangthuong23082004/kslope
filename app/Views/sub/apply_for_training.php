<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
<main id="container" class="main main_new">
    <section class="ci-intro dif">

        <div class="ci-bc">
            <a href="#" class="ci-bc__item">HOME</a>
            <a href="#" class="ci-bc__item">계측전문인력 교육</a>

            <a href="#" class="ci-bc__item ci-bc__item--select">
                교육 신청
                <img class="ci-bc__ico" src="/assets/img/sub/ico_select_down.png" alt="">
            </a>
        </div>

        <h1 class="ci-title">교육 신청</h1>

        <nav class="ci-tab">
            <a href="/training_information">교육 안내</a>
            <a href="/apply_for_training" class="is-active">교육 신청</a>
            <a href="/take_training">교육 수강</a>
            <a href="/completioncert_reissue">수료증 재발급 신청</a>
        </nav>

        <div class="ci-visual">
            <img src="/assets/img/sub/ci_visual_training_apply.png" alt="">
            <div class="ci-visual-text">
                <p class="text_dif">계측전문인력 교육</p>
                <p class="text-en">Training Application</p>
                <p class="text-en-small">Korea Slope Safety Association</p>
            </div>
        </div>

    </section>


    <section class="edu-apply-section">
        <div class="edu-inner">

            <h2 class="edu-title">
                <span>교육 신청</span>
            </h2>

            <p class="edu-desc">
                교육신청을 하고자하는 분(기업 및 단체)은 아래의 신청서를 내려받아 작성 후<br>
                이메일(korea-slope@naver.com)로 보내주시면 됩니다.<br>
                교육비 납부는 별도 안내드립니다.
            </p>

            <h3 class="edu-subtitle">
                <span>신청 방법</span>
            </h3>

            <div class="edu-step-wrap">

                <!-- Desktop: 기존 layout -->
                <div class="edu-step-desktop">
                    <!-- row 1 -->
                    <div class="edu-step-row">
                        <div class="edu-step-box">
                            <span class="step-num">STEP 01</span>
                            <p>교육생 모집</p>
                        </div>

                        <span class="step-arrow"></span>

                        <div class="edu-step-box">
                            <span class="step-num">STEP 02</span>
                            <p>교육신청서제출 <em class="apply_small">(첨부다운)</em></p>
                        </div>

                        <span class="step-arrow"></span>

                        <div class="edu-step-box step-has-down">
                            <span class="step-num">STEP 03</span>
                            <p>교육생확정 알림</p>

                            <span class="step-down"></span>
                        </div>
                    </div>


                    <div class="edu-step-row reverse">

                        <div class="edu-step-box">
                            <span class="step-num">STEP 04</span>
                            <p>교육비 납부<br>교육일정 안내알림</p>
                        </div>
                        <span class="step-arrow"></span>

                        <div class="edu-step-box">
                            <span class="step-num">STEP 05</span>
                            <p>교육수강</p>
                        </div>

                        <span class="step-arrow"></span>

                        <div class="edu-step-box">
                            <span class="step-num">STEP 06</span>
                            <p>수료증 교부</p>
                        </div>
                    </div>
                </div>

                <!-- Mobile: 2-column layout -->
                <div class="edu-step-mobile">
                    <div class="m-step-row">
                        <div class="edu-step-box">
                            <span class="step-num">STEP 01</span>
                            <p>교육생 모집</p>
                        </div>
                        <span class="m-step-arrow-right"></span>
                        <div class="edu-step-box">
                            <span class="step-num">STEP 02</span>
                            <p>교육신청서제출 <em class="apply_small">(첨부다운)</em></p>
                        </div>
                    </div>

                    <div class="m-step-row">
                        <div class="edu-step-box">
                            <span class="step-num">STEP 03</span>
                            <p>교육생확정 알림</p>
                        </div>
                        <span class="m-step-arrow-right"></span>
                        <div class="edu-step-box">
                            <span class="step-num">STEP 04</span>
                            <p>교육비 납부<br>교육일정 안내알림</p>
                        </div>
                    </div>

                    <div class="m-step-row">
                        <div class="edu-step-box">
                            <span class="step-num">STEP 05</span>
                            <p>교육수강</p>
                        </div>
                        <span class="m-step-arrow-right"></span>
                        <div class="edu-step-box">
                            <span class="step-num">STEP 06</span>
                            <p>수료증 교부</p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="edu-download">
                <a href="/assets/files/_TrainingApplicationForm.hwp" class="btn-download" download>
                    교육신청서 다운로드
                    <span class="ico-download"></span>
                </a>
            </div>

        </div>
    </section>



</main>
<script>
    $(function() {
        $(".ci-subtab__item").on("click", function(e) {
            e.preventDefault();

            $(".ci-subtab__item").removeClass("is-active");
            $(this).addClass("is-active");
        });
    });
</script>
<?php $this->endSection(); ?>