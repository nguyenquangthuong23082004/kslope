<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
<main id="container" class="main main_new">
    <section class="ci-intro">

        <div class="ci-bc">
            <a href="#" class="ci-bc__item">HOME</a>
            <a href="#" class="ci-bc__item">업무 안내</a>

            <a href="#" class="ci-bc__item ci-bc__item--select">
                주요 업무
                <img class="ci-bc__ico" src="/assets/img/sub/ico_select_down.png" alt="">
            </a>
        </div>

        <h1 class="ci-title">주요 업무</h1>

        <nav class="ci-tab">
            <a href="/main_tasks" class="is-active">주요 업무</a>
            <a href="/contract_information">계약 안내</a>
            <a href="slope_safety">급경사지 안전관리 체계</a>
        </nav>

        <div class="ci-visual">
            <img src="/assets/img/sub/ci_visual_disaster_risk.png" alt="">
            <div class="ci-visual-text">
                <p class="text_dif">업무 안내</p>
                <p class="text-en">Key Responsibilities</p>
                <p class="text-en-small">Korea Slope Safety Association</p>
            </div>
        </div>
        <div class="ci-subtab subtab-new pc-only1">
            <a id="tab-survey" href="/main_tasks?tab=survey"
                class="ci-subtab__item dif <?= empty($tab) || $tab == '' || $tab == 'survey' ? 'is-active' : '' ?>">급경사지
                실태조사</a>
            <a id="tab-rnd" href="/main_tasks?tab=rnd"
                class="ci-subtab__item dif <?= !empty($tab) && $tab == 'rnd' ? 'is-active' : '' ?>">R&D</a>
            <a id="tab-db" href="/main_tasks?tab=db"
                class="ci-subtab__item dif <?= !empty($tab) && $tab == 'db' ? 'is-active' : '' ?>">급경사지
                DB구축</a>
            <a id="tab-drone" href="/main_tasks?tab=drone"
                class="ci-subtab__item dif <?= !empty($tab) && $tab == 'drone' ? 'is-active' : '' ?>">드론
                라이다</a>
            <a id="tab-wind" href="/main_tasks?tab=wind"
                class="ci-subtab__item dif <?= !empty($tab) && $tab == 'wind' ? 'is-active' : '' ?>">풍력단지
                재해방지시설</a>
            <!-- href="/main_tasks?tab=safety" -->
            <a id="tab-safety" href="/safety_inspection"
                class="ci-subtab__item dif <?= !empty($tab) && $tab == 'safety' ? 'is-active' : '' ?>">급경사지
                안전점검</a>
            <!-- href="/main_tasks?tab=detail" -->
            <a id="tab-detail" href="/detailed_investigation"
                class="ci-subtab__item dif <?= !empty($tab) && $tab == 'detail' ? 'is-active' : '' ?>">급경사지
                정밀조사</a>
            <!-- href="/main_tasks?tab=risk" -->
            <a id="tab-risk" href="/disaster_risk"
                class="ci-subtab__item dif <?= !empty($tab) && $tab == 'risk' ? 'is-active' : '' ?>">급경사지
                재해위험도평가</a>
            <!-- href="/main_tasks?tab=map" -->
            <a id="tab-map" href="/slope_topography_map"
                class="ci-subtab__item dif <?= !empty($tab) && $tab == 'map' ? 'is-active' : '' ?>">급경사지
                지형도 작성</a>
            <a id="tab-measure-check" href="/main_tasks?tab=measure-check"
                class="ci-subtab__item dif <?= !empty($tab) && $tab == 'measure-check' ? 'is-active' : '' ?>">상시계측
                검수 및 시운전</a>
            <a id="tab-measure-maintain" href="/main_tasks?tab=measure-maintain"
                class="ci-subtab__item dif <?= !empty($tab) && $tab == 'measure-maintain' ? 'is-active' : '' ?>">상시계측
                유지관리</a>
        </div>

        <div class="custom-select mo-only">
            <div class="select-selected">
                급경사지 실태조사
            </div>

            <ul class="select-options">
                <li data-value="/main_tasks?tab=survey">급경사지 실태조사</li>
                <li data-value="/main_tasks?tab=rnd">R&D</li>
                <li data-value="/main_tasks?tab=db">급경사지 DB구축</li>
                <li data-value="/main_tasks?tab=drone">드론 라이다</li>
                <li data-value="/main_tasks?tab=wind">풍력단지 재해방지시설 </li>
                <li data-value="/safety_inspection">급경사지 안전점검 </li>
                <li data-value="/detailed_investigation">급경사지 정밀조사 </li>
                <li data-value="/disaster_risk">급경사지 재해위험도평가</li>
                <li data-value="/slope_topography_map">급경사지 지형도 작성</li>
                <li data-value="/main_tasks?tab=measure-check"> 상시계측 검수 및 시운전</li>
                <li data-value="/main_tasks?tab=measure-maintain"> 상시계측 유지관리</li>
            </ul>
        </div>

    </section>
    <section class="law-section">
        <div class="law-inner">

            <div class="law-block">
                <h2 class="law-title">근거 법령</h2>

                <div class="law-box">
                    급경사지 법제6조에 의하면 관리기관은 소관 급경사지에 대하여 붕괴위험지역으로 지정·해제가 필요한 경우에는 재해위험도평가를 거쳐야 하며 <br>
                    재해위험도 평가시에 는 '급경사지 재해위험도 평가기준'을 준용하여야 한다
                </div>
            </div>

            <div class="law-block">
                <h2 class="law-title">사업 내용</h2>

                <div class="law-box">
                    <ol class="law-list">
                        <li>
                            <ul>
                                <li>
                                    급경사지 재해위험도 평가는 급경사지법 제6조제1항 및 제2항에 따라 "붕괴위험지 역 지정·고시에 필요한 대상지에 대하여 담당 공무원과 전문가가 <br>
                                    행정안전부 행정 규칙 제2023-36호 급경사지 재해위험도 평가기준」에 따라 '재해위험도 등급'을 판 단하는 과정으로서 지정 절차의 절대적 <br>
                                    기준으로 활용되므로 신뢰도 높은 정확한 조 사 및 판단이 필요하다.
                                </li>
                            </ul>
                        </li>

                        <li>
                            <ul>
                                <li>
                                    「급경사지 재해위험도 평가기준」은 '자연비탈면(또는 산지)', '인공비탈면', '옹벽 및 축대'로 크게 3가지로 분류되며 각각 다른 형태의 평가기준
                                    평가표로 <br>
                                    고시되어 있어 . 급경사지 특성에 맞는 평가표로 재해위험도 평가를 실시한다.
                                </li>
                            </ul>
                        </li>

                        <li>
                            <ul>
                                <li>
                                    「급경사지 재해위험도 평가기준」 으로 명확한 판단이 어려운 경우 전문가가 직접 안정성 검토 및 시뮬레이션 등 기술적인 분석을 활용하여 구체적인 <br>
                                    재해위험도 평가 결과를 추가할 수 있으며, 재해위험도 등급은 A~E 동급으로 구분하고 D, E 등급에 대해서는 붕괴위험지역으로 지정 관리하며, <br>
                                    C등급 중에서 붕괴 시 인명피해 우려가 있어 지속적인 점검 등이 필요한 지역은 붕괴위험지역으로 지정·관리하는 것이 바람 직하다.
                                </li>
                            </ul>
                        </li>
                    </ol>
                </div>
            </div>


            <div class="law-block pc-only1">

                <div class="risk-table-wrap">
                    <table class="risk-table">
                        <colgroup>
                            <col style="width:110px">
                            <col style="width:205px">
                            <col style="width:150px">
                            <col style="width:150px">
                            <col>
                            <col>
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="th-grade" rowspan="2">등급</th>
                                <th class="th-group" colspan="3">재해위험도 평가점수</th>
                                <th class="th-group" rowspan="2">재해위험도</th>
                                <th class="th-group" rowspan="2">관리방안</th>
                            </tr>
                            <tr>
                                <th class="th-sub">자연비탈면 또는 산지</th>
                                <th class="th-sub">인공 비탈면</th>
                                <th class="th-sub">옹벽 및 축대</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <th class="td-grade">A</th>
                                <td class="td-score">0 ~ 20</td>
                                <td class="td-score">0 ~ 20</td>
                                <td class="td-score">0 ~ 20</td>
                                <td class="td-text">
                                    <ul class="dot-list">
                                        <li>재해위험 매우 낮음</li>
                                    </ul>
                                </td>
                                <td class="td-text">
                                    <ul class="dot-list">
                                        <li>정기적 안전점검</li>
                                    </ul>
                                </td>
                            </tr>

                            <tr>
                                <th class="td-grade">B</th>
                                <td class="td-score">21 ~ 40</td>
                                <td class="td-score">21 ~ 40</td>
                                <td class="td-score">21 ~ 40</td>
                                <td class="td-text">
                                    <ul class="dot-list">
                                        <li>재해위험 낮음</li>
                                    </ul>
                                </td>
                                <td class="td-text">
                                    <ul class="dot-list">
                                        <li>정기적 안전점검</li>
                                    </ul>
                                </td>
                            </tr>

                            <tr>
                                <th class="td-grade">C</th>
                                <td class="td-score">41 ~ 60</td>
                                <td class="td-score">41 ~ 60</td>
                                <td class="td-score">41 ~ 60</td>
                                <td class="td-text">
                                    <ul class="dot-list">
                                        <li>재해위험 보통</li>
                                    </ul>
                                </td>
                                <td class="td-text">
                                    <ul class="dot-list">
                                        <li>정기적 안전점검</li>
                                        <li>필요시 붕괴위험지역 지정</li>
                                        <li>관리</li>
                                    </ul>
                                </td>
                            </tr>

                            <tr>
                                <th class="td-grade">D</th>
                                <td class="td-score">61 ~ 80</td>
                                <td class="td-score">61 ~ 80</td>
                                <td class="td-score">61 ~ 80</td>
                                <td class="td-text">
                                    <ul class="dot-list">
                                        <li>재해위험 높음</li>
                                    </ul>
                                </td>
                                <td class="td-text">
                                    <ul class="dot-list">
                                        <li>정기적 안전점검</li>
                                        <li>붕괴위험지역 지정 · 관리</li>
                                    </ul>
                                </td>
                            </tr>

                            <tr>
                                <th class="td-grade">E</th>
                                <td class="td-score">81 이상</td>
                                <td class="td-score">81 이상</td>
                                <td class="td-score">81 이상</td>
                                <td class="td-text">
                                    <ul class="dot-list">
                                        <li>재해위험 매우 높음</li>
                                    </ul>
                                </td>
                                <td class="td-text">
                                    <ul class="dot-list">
                                        <li>정기적 안전점검</li>
                                        <li>붕괴위험지역 지정 · 관리</li>
                                        <li>필요시 응급조치</li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="risk-caption">재해위험도 등급별 관리방안</div>
                </div>
            </div>

            <div class="law-block">
                <div class="law-gallery-wrap">

                    <div class="law-slider-outer">

                        <div class="law-slider-viewport">

                            <div class="swiper law-main-swiper">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide"><img src="/assets/img/sub/gallery_risk_01.png" alt="">
                                    </div>
                                    <div class="swiper-slide"><img src="/assets/img/sub/gallery_risk_02.png" alt="">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <button class="law-nav law-prev" type="button"><img src="/assets/img/sub/ico_prev_slide.png"
                                alt="Left arrow"></button>
                        <button class="law-nav law-next" type="button"><img src="/assets/img/sub/ico_next_slide.png"
                                alt="Right arrow"></button>

                    </div>

                    <div class="swiper law-thumb-swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide"><img src="/assets/img/sub/gallery_risk_01.png"></div>
                            <div class="swiper-slide"><img src="/assets/img/sub/gallery_risk_02.png"></div>
                        </div>
                    </div>

                    <!-- <p class="law-gallery-caption">
                        급경사지 실태조사 지자체 설명회 및 현장조사 모습
                    </p> -->
                    <p class="law-gallery-caption" id="galleryCaption"></p>
                    <p class="law-gallery-caption-all pc-only1">A~C등급의 급경사지에서 피해가 발생한 사례</p>
                    <p class="law-gallery-caption-all mobi-only">상시계측관리시스템 검수 및 시운전</p>
                </div>
            </div>


        </div>
    </section>


</main>
<!--    <script>-->
<!--        $(function () {-->
<!--            $(".ci-subtab__item").on("click", function (e) {-->
<!--                e.preventDefault();-->
<!---->
<!--                $(".ci-subtab__item").removeClass("is-active");-->
<!--                $(this).addClass("is-active");-->
<!--            });-->
<!--        });-->
<!--    </script>-->

<style>
    .law-list ul li::before {
        display: none;
    }

    .law-list>li {
        margin-bottom: 15px;
    }

    .law-list ul li {
        position: relative;
        padding-left: unset;
        font-size: 20px;
        letter-spacing: -1px;
        line-height: 1.4;
        text-transform: uppercase;
        color: #555555;
        font-family: "SUIT";
        margin-bottom: 12px;
    }

    .law-list ul {
        list-style: none;
        padding: unset;
        margin: 0;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    const lawThumbSwiper = new Swiper(".law-thumb-swiper", {
        slidesPerView: "auto",
        spaceBetween: 10,
        watchSlidesProgress: true,
    });

    const lawMainSwiper = new Swiper(".law-main-swiper", {
        slidesPerView: 1,
        loop: true,
        navigation: {
            nextEl: ".law-next",
            prevEl: ".law-prev",
        },
        thumbs: {
            swiper: lawThumbSwiper,
        },
    });

    document.querySelectorAll('.ci-subtab').forEach(function (scrollElement) {
        scrollElement.addEventListener('wheel', function (e) {
            var currentScroll = scrollElement.scrollLeft;
            var newScroll = currentScroll + e.deltaY;
            scrollElement.scrollLeft = newScroll;
            e.preventDefault();
        });

        var isMouseDown = false;
        var startX;
        var startScroll;
        var isDragging = false;

        scrollElement.addEventListener('mousedown', function (e) {
            if (e.button !== 0) return;

            isMouseDown = true;
            isDragging = false;
            startX = e.clientX;
            startScroll = scrollElement.scrollLeft;
            scrollElement.style.cursor = 'grabbing';
            e.preventDefault();
        });

        scrollElement.addEventListener('mousemove', function (e) {
            if (!isMouseDown) return;

            var deltaX = e.clientX - startX;

            if (Math.abs(deltaX) > 5) {
                isDragging = true;
            }

            scrollElement.scrollLeft = startScroll - deltaX;
            e.preventDefault();
        });

        document.addEventListener('mouseup', function () {
            if (isMouseDown) {
                isMouseDown = false;
                scrollElement.style.cursor = 'grab';

                setTimeout(function () {
                    isDragging = false;
                }, 10);
            }
        });

        scrollElement.addEventListener('mouseleave', function () {
            if (isMouseDown) {
                isMouseDown = false;
                scrollElement.style.cursor = 'grab';
            }
        });

        scrollElement.addEventListener('click', function (e) {
            if (isDragging) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
            }
        }, true);
    });
</script>

<!-- <script>
    document.addEventListener("DOMContentLoaded", function() {

        const container = document.querySelector(".ci-subtab");
        const activeTab = document.querySelector(".ci-subtab .is-active");

        if (container && activeTab) {

            const containerRect = container.getBoundingClientRect();
            const tabRect = activeTab.getBoundingClientRect();

            const offset = tabRect.left - containerRect.left;

            container.scrollTo({
                left: container.scrollLeft + offset - 80,
                behavior: "smooth"
            });

        }

    });
</script> -->
<script>
    function smoothScrollTo(el, targetLeft, duration = 2000) {
        const startLeft = el.scrollLeft;
        const diff = targetLeft - startLeft;
        const startTime = performance.now();

        const ease = (t) => t * t * (3 - 2 * t);

        function step(now) {
            const t = Math.min(1, (now - startTime) / duration);
            el.scrollLeft = startLeft + diff * ease(t);
            if (t < 1) requestAnimationFrame(step);
        }

        requestAnimationFrame(step);
    }

    document.addEventListener("DOMContentLoaded", function () {
        const container = document.querySelector(".ci-subtab");
        const activeTab = document.querySelector(".ci-subtab .is-active");

        if (!container || !activeTab) return;

        const targetLeft =
            activeTab.offsetLeft -
            container.clientWidth / 2 +
            activeTab.clientWidth / 2;

        smoothScrollTo(container, targetLeft, 2000);
    });
</script>
<!-- <script>
    const captions = [
        "동작구 사당동 아파트 옹벽",
        "광주 대화아파트"
    ];

    const swiper = new Swiper(".law-main-swiper", {
        navigation: {
            nextEl: ".law-next",
            prevEl: ".law-prev",
        },
        on: {
            slideChange: function() {
                document.getElementById("galleryCaption").innerText =
                    captions[this.realIndex];
            }
        }
    });

    document.getElementById("galleryCaption").innerText = captions[0];
</script> -->
<script>
    const captions = [
        "동작구 사당동 아파트 옹벽",
        "광주 대화아파트"
    ];

    const captionEl = document.getElementById("galleryCaption");

    const thumbSwiper = new Swiper(".law-thumb-swiper", {
        slidesPerView: "auto",
        spaceBetween: 10,
        watchSlidesProgress: true,
        slideToClickedSlide: true,
    });

    const swiper = new Swiper(".law-main-swiper", {
        navigation: {
            nextEl: ".law-next",
            prevEl: ".law-prev",
        },

        thumbs: {
            swiper: thumbSwiper
        },

        on: {
            init: function () {
                captionEl.innerText = captions[this.realIndex] || "";
            },
            slideChange: function () {
                captionEl.innerText = captions[this.realIndex] || "";
            }
        }
    });

    thumbSwiper.on("click", function () {
        const i = thumbSwiper.clickedIndex;
        if (typeof i === "number") {
            captionEl.innerText = captions[i] || "";
            swiper.slideTo(i);
        }
    });

    captionEl.innerText = captions[0] || "";
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {

        const select = document.querySelector(".custom-select");
        const selected = select.querySelector(".select-selected");
        const options = select.querySelectorAll(".select-options li");

        const currentUrl = window.location.pathname + window.location.search;

        options.forEach(option => {
            if (option.dataset.value === currentUrl) {
                option.classList.add("active");
                selected.textContent = option.textContent;
            }
        });

        selected.addEventListener("click", function () {
            select.classList.toggle("active");
        });

        options.forEach(option => {
            option.addEventListener("click", function () {

                selected.textContent = this.textContent;

                window.location.href = this.dataset.value;
            });
        });

        document.addEventListener("click", function (e) {
            if (!select.contains(e.target)) {
                select.classList.remove("active");
            }
        });

    });
</script>

<?php $this->endSection(); ?>