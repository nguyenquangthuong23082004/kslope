<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
<?php $this->section('styles'); ?>
    <link rel="stylesheet" href="/assets/css/pages/subs/training-information.css">
<?php $this->endSection(); ?>
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
            <a href="/training_information" class="is-active">교육 안내</a>
            <a href="/apply_for_training">교육 신청</a>
            <a href="/take_training">교육 수강</a>
            <a href="/completioncert_reissue">수료증 재발급 신청</a>
        </nav>

        <div class="ci-visual">
            <img src="/assets/img/sub/cd_visual_information.png" alt="">
            <div class="ci-visual-text">
                <p class="text_dif">계측전문인력 교육</p>
                <p class="text-en">Training Information</p>
                <p class="text-en-small">Korea Slope Safety Association</p>
            </div>
        </div>

    </section>


    <section class="mem-join-area">
        <!-- <div class="mem-join-watermark">Member <br> ship</div> -->

        <div class="mem-join-inner">
            <div class="qualify-inner" style="gap: 55px">
                <div class="ma" style="display: grid;">
                    <h2 class="mem-join-title" style="margin-bottom: 20px">관련 법령</h2>
                    <h2 class="mem-join-title pc-only1" style="width: 110px;">및 근거</h2>
                </div>
                <ul class="qualify-list">
                    <li>「급경사지법」 제30조(계측전문인력의 사전 실무교육)</li>
                    <li>
                        「급경사지법」 시행규칙 제16조(실무교육훈련과정 등)
                    </li>
                    <li>
                        「급경사지 계측전문인력 교육운영 규정」
                    </li>
                    <li>
                        급경사지 계측전문인력 교육대행기관 지정·고시([행정안전부 고시 제2021-44호])
                    </li>
                </ul>
            </div>
            <div class="mem-join-cards">
                <h2 class="mem-join-title mo-only" style="width: 110px;">및 근거</h2>

                <div class="mem-card mem-card-personal">
                    <div class="mem-card-text">
                        <p class="mem-card-heading mem-green">개인회원 신청</p>
                        <!-- <a href="#" class="mem-apply-btn mem-green">
                            가입신청 <img src="/assets/img/sub/btn_download_w.png" alt="">
                        </a> -->
                        <a href="/assets/files/join_us_individual.hwp" class="mem-apply-btn mem-green" download>
                            가입신청 <img src="/assets/img/sub/btn_download_w.png" alt="">
                        </a>
                    </div>
                    <div class="mem-card-icon mem-icon-personal">
                        <img src="/assets/img/sub/icon_hammer.png" alt="개인회원">
                    </div>
                </div>

                <div class="mem-card dif mem-card-group">
                    <div class="mem-card-text">
                        <p class="mem-card-heading mem-blue">단체 및 특별회원 신청</p>
                        <!-- <a href="#" class="mem-apply-btn mem-blue">
                            가입신청 <img src="/assets/img/sub/btn_download_w.png" alt="">
                        </a> -->
                        <a href="/assets/files/join_us_group.hwp" class="mem-apply-btn mem-blue" download>
                            가입신청 <img src="/assets/img/sub/btn_download_w.png" alt="">
                        </a>
                    </div>
                    <div class="mem-card-icon mem-icon-group">
                        <img src="/assets/img/sub/icon_policy_book.png" alt="개인회원">
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="qualify-area" style="padding-bottom: 100px;">
        <div class="qualify-inner">

            <div class="qualify-left">
                <h2 class="qualify-title" style="width: 144px;">교육 내용</h2>
            </div>

            <div class="qualify-right">
                <h3 class="qualify-subtitle">1. 목적</h3>

                <ul class="qualify-list">
                    <li>전문적인 지식과 경험을 바탕으로 계측기기 설치 전·후 시운전을 통해 상시계측관리 체계의 신뢰성을 확보</li>
                    <li>
                        관련 법령에 따른 실무 역량을 강화하여 급경사지 재해 예방 및 공공의 안전 도모
                    </li>
                </ul>
                <h3 class="qualify-subtitle dif">2. 교육 운영 시기</h3>

                <ul class="qualify-list">
                    <li>상반기 및 하반기 연 2회 개설 추진</li>
                </ul>

                <h3 class="qualify-subtitle dif">3. 교육 과정 및 방법</h3>

                <div class="apply-criteria-wrap">

                    <h3 class="apply-criteria-title">
                        교육 과정
                    </h3>

                    <table class="member-apply-table" style="border-radius:0">
                        <colgroup>
                            <col class="col-kind">
                            <col class="col-grade">
                            <col class="col-form">
                            <col class="col-person">
                        </colgroup>

                        <thead>
                            <tr>
                                <th colspan="2">구분</th>
                                <th>상시계측관리</th>
                                <th>계측기기 성능검사</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td class="td-kind"
                                    style="border-right: 1px solid #7a7a7a;border-bottom: 1px solid #7a7a7a;">기본 과정</td>
                                <td class="td-kind" style="border-bottom: 1px solid #7a7a7a;">기본 과정</td>
                                <td>35시간(5일)</td>
                                <td>35시간(5일)</td>
                            </tr>

                            <tr>
                                <td class="td-kind"
                                    style="border-right: 1px solid #7a7a7a;border-bottom: 1px solid #7a7a7a;">전문 과정</td>
                                <td class="td-kind" style="border-bottom: 1px solid #7a7a7a;">전문 과정</td>
                                <td>21시간(3일)</td>
                                <td>14시간(2일)</td>
                            </tr>

                            <tr>
                                <td class="td-kind" colspan="2">기본 과정 + 전문 과정</td>
                                <td>총 56시간(8일)</td>
                                <td>총 49시간(7일)</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Mobile cards: 교육 과정 -->
                    <div class="m-table-cards">
                        <!-- 기본 과정 -->
                        <div class="m-table-card">
                            <div class="m-table-card-head">기본 과정</div>
                            <div class="m-table-card-body">
                                <div class="m-table-row">
                                    <span class="m-table-label">상시계측관리 :</span>
                                    <span class="m-table-value">35시간(5일)</span>
                                </div>
                                <div class="m-table-row">
                                    <span class="m-table-label">계측기기 성능검사 :</span>
                                    <span class="m-table-value">35시간(5일)</span>
                                </div>
                            </div>
                        </div>

                        <!-- 전문 과정 -->
                        <div class="m-table-card">
                            <div class="m-table-card-head">전문 과정</div>
                            <div class="m-table-card-body">
                                <div class="m-table-row">
                                    <span class="m-table-label">상시계측관리 :</span>
                                    <span class="m-table-value">21시간(3일)</span>
                                </div>
                                <div class="m-table-row">
                                    <span class="m-table-label">계측기기 성능검사 :</span>
                                    <span class="m-table-value">14시간(2일)</span>
                                </div>
                            </div>
                        </div>

                        <!-- 기본 과정 + 전문 과정 -->
                        <div class="m-table-card">
                            <div class="m-table-card-head">기본 과정 + 전문 과정</div>
                            <div class="m-table-card-body">
                                <div class="m-table-row">
                                    <span class="m-table-label">상시계측관리 :</span>
                                    <span class="m-table-value">총 56시간(8일)</span>
                                </div>
                                <div class="m-table-row">
                                    <span class="m-table-label">계측기기 성능검사 :</span>
                                    <span class="m-table-value">총 49시간(7일)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3 class="apply-criteria-title" style="margin-top: 59px">
                        교육 방법
                    </h3>

                    <ul class="qualify-list">
                        <li>기본과정 : 사이버교육</li>
                        <li>
                            기본과정 : 사이버교육
                        </li>
                    </ul>

                </div>
                <h3 class="qualify-subtitle dif">4. 교육 진행 절차</h3>

                <div class="edu-step-wrap">

                    <div class="edu-process">

                        <div class="process-box">
                            <div class="process-head">공고확인</div>
                            <div class="process-body">
                                협회 홈페이지 교육생<br>
                                모집공고 확인
                            </div>
                        </div>

                        <div class="process-arrow"></div>

                        <div class="process-box">
                            <div class="process-head">신청서 접수</div>
                            <div class="process-body">
                                교육 기수 선택 및<br>
                                신청서 작성 후 메일<br>
                                접수
                            </div>
                        </div>

                        <div class="process-arrow"></div>

                        <div class="process-box">
                            <div class="process-head">공고확인</div>
                            <div class="process-body">
                                개설 확정 시 개별 연락<br>
                                및 교육비 입금 안내
                            </div>
                        </div>

                        <div class="process-arrow"></div>

                        <div class="process-box">
                            <div class="process-head">공고확인</div>
                            <div class="process-body">
                                본 교육 진행 및<br>
                                최종 수료
                            </div>
                        </div>

                    </div>

                </div>


            </div>

        </div>

    </section>



</main>
<script>
    $(function () {
        $(".ci-subtab__item").on("click", function (e) {
            e.preventDefault();

            $(".ci-subtab__item").removeClass("is-active");
            $(this).addClass("is-active");
        });
    });
</script>
<?php $this->endSection(); ?>