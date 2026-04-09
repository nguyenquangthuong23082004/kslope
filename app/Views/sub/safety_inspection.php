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
                급경사지 안전점검
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
                    급경사지법 제5조(급경사지에 대한 안전점검)
                </div>
            </div>

            <div class="law-block">
                <h2 class="law-title">사업 내용</h2>

                <div class="law-box">
                    <ol class="law-list">
                        <li>
                            <ul>
                                <li>
                                    관리기관은 소관 급경사지에 대하여 연 2회 이상 안전점검을 실시하고 그 결과를 안전점검은 매년 초 행정안전부에서 배포하는 안전점검 체크리스트를 <br>
                                    활용하여, 육 안점검 및 장비(클리노콤파스, 거리측정기, 워킹미터, 줄자, 드론 등)를 활용하여 급 경사지의 불연속면, 암종, 사면 상태와 붕괴이력, <br>
                                    급경사지 시설 및 현황 등을 조사 한다 급경사지 안전점검은 해빙기 및 우기대비 점검을 통하여 인명 및 재산 피해를 최소 화함을 목적으로 실시하며, <br>
                                    전문가를 활용한 신뢰성 있는 안전점검을 실시하여야 한다.
                                </li>
                            </ul>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="law-block">
                <div class="law-gallery-wrap">

                    <div class="law-slider-outer">

                        <div class="law-slider-viewport">

                            <div class="swiper law-main-swiper">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide"><img src="/assets/img/sub/gallery_safety_01.png" alt="">
                                    </div>
                                    <div class="swiper-slide"><img src="/assets/img/sub/gallery_safety_02.png" alt="">
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
                            <div class="swiper-slide"><img src="/assets/img/sub/gallery_safety_01.png"></div>
                            <div class="swiper-slide"><img src="/assets/img/sub/gallery_safety_02.png"></div>
                        </div>
                    </div>

                    <!-- <p class="law-gallery-caption">
                        급경사지 실태조사 지자체 설명회 및 현장조사 모습
                    </p> -->
                    <p class="law-gallery-caption" id="galleryCaption"></p>
                    <p class="law-gallery-caption-all">NDMS 안점점검 결과 '안전' 붕괴발생 사례</p>
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

    document.querySelectorAll('.ci-subtab').forEach(function(scrollElement) {
        scrollElement.addEventListener('wheel', function(e) {
            var currentScroll = scrollElement.scrollLeft;
            var newScroll = currentScroll + e.deltaY;
            scrollElement.scrollLeft = newScroll;
            e.preventDefault();
        });

        var isMouseDown = false;
        var startX;
        var startScroll;
        var isDragging = false;

        scrollElement.addEventListener('mousedown', function(e) {
            if (e.button !== 0) return;

            isMouseDown = true;
            isDragging = false;
            startX = e.clientX;
            startScroll = scrollElement.scrollLeft;
            scrollElement.style.cursor = 'grabbing';
            e.preventDefault();
        });

        scrollElement.addEventListener('mousemove', function(e) {
            if (!isMouseDown) return;

            var deltaX = e.clientX - startX;

            if (Math.abs(deltaX) > 5) {
                isDragging = true;
            }

            scrollElement.scrollLeft = startScroll - deltaX;
            e.preventDefault();
        });

        document.addEventListener('mouseup', function() {
            if (isMouseDown) {
                isMouseDown = false;
                scrollElement.style.cursor = 'grab';

                setTimeout(function() {
                    isDragging = false;
                }, 10);
            }
        });

        scrollElement.addEventListener('mouseleave', function() {
            if (isMouseDown) {
                isMouseDown = false;
                scrollElement.style.cursor = 'grab';
            }
        });

        scrollElement.addEventListener('click', function(e) {
            if (isDragging) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
            }
        }, true);
    });
</script>
<!-- 
<script>
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

    document.addEventListener("DOMContentLoaded", function() {
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
        // "동작구 사당동 아파트 옹벽",
        // "광주 대화아파트"
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
            init: function() {
                captionEl.innerText = captions[this.realIndex] || "";
            },
            slideChange: function() {
                captionEl.innerText = captions[this.realIndex] || "";
            }
        }
    });

    thumbSwiper.on("click", function() {
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