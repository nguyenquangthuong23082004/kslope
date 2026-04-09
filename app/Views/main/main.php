<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
<?= $this->include("inc/popup.php") ?>
<main id="container" class="main main_new">
    <section class="hero-kssa">

        <div class="swiper hero-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img class="only_web" src="/assets/img/main/hero_bg.png" alt="">
                    <img class="only_mo" src="/assets/img/main/hero_bg_mo.png" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="/assets/img/main/hero_bg2.png" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="/assets/img/main/hero_bg.png" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="/assets/img/main/hero_bg2.png" alt="">
                </div>
            </div>
        </div>

        <div class="hero-inner">

            <h1 class="hero-title">
                급경사지 재해로부터 <br class="only_mo"> 국민의 재산과<br class="only_web">
                생명 보호를 <br class="only_mo"> 위해 노력합니다
            </h1>

            <div class="hero-brand">
                <img class="only_web" src="/assets/img/main/hero_logo.png" alt="KSSA">
                <img class="only_mo" src="/assets/img/main/hero_logo_mo.png" alt="KSSA">
                <p>Korea Slope Safety Association</p>
            </div>

            <div class="hero-controls">

                <div class="hero-pagination "></div>

                <div class="wrap_btn">
                    <button class="hero-btn hero-play" id="heroPlayBtn" aria-label="play">
                        <img src="/assets/img/main/ico_play.png" alt="play">
                    </button>

                    <button class="hero-btn hero-pause" id="heroPauseBtn" aria-label="pause">
                        <img src="/assets/img/main/ico_pause.png" alt="pause">
                    </button>
                </div>


            </div>
            <div class="hero-scroll img-version">
                <img src="/assets/img/main/ico_mouse.png" alt="">
                <span>SCROLL</span>
            </div>

        </div>
    </section>

    <section class="kslope-info">

        <div class="kslope-title">
            <p class="sub">주요정보</p>
            <h2>K-slope <span>소개</span></h2>
        </div>

        <div class="kslope-card-grid">

            <a href="#" class="kslope-card card-purple">
                <div class="card-text">
                    <h3 class="dif">급경사지 안전관리</h3><br>
                    <h3 class="dif2">헬프데스크</h3>
                    <p>급경사지관련 공지사항, 제도, 알림·공고 등 협회의 최신소식을 전달합니다.</p>
                </div>
                <span class="card-btn dif1">
                    바로가기
                    <img src="/assets/img/common/ico_arrow_white.png" alt="">
</span>
            </a>

            <a href="/greeting" class="kslope-card card-indigo">
                <div class="card-text">
                    <h3>협회 소개</h3>
                    <p>협회 연혁과 비전, 조직도를 소개합니다.</p>
                </div>
                <span class="card-btn dif2">
                    바로가기
                    <img src="/assets/img/common/ico_arrow_white2.png" alt="">
                </span>
            </a>

            <a href="/sign_up_instructions" class="kslope-card card-blue">
                <div class="card-text">
                    <h3>가입 안내</h3>
                    <p>회원 가입 절차와 혜택, 회원 전용 자료를 안내합니다.</p>
                </div>
                <span class="card-btn dif3">
                    바로가기
                    <img src="/assets/img/common/ico_arrow_white3.png" alt="">
                </span>
            </a>

            <a href="/training_information" class="kslope-card card-green">
                <div class="card-text">
                    <h3>계속인력전문교육</h3>
                    <p>전문인력 양성을 위한 교육 일정, 신청 및 수강 정보를 제공합니다.</p>
                </div>
                <span class="card-btn dif4">
                    바로가기
                    <img src="/assets/img/common/ico_arrow_white4.png" alt="">
                </span>
            </a>

        </div>

        <div class="kslope-title mt">
            <h2>K-slope <span>주요업무</span></h2>
        </div>

        <ul class="ks-work">
            <li class="ks-work-item">
                <a href="#" class="ks-work-link">
                    <span class="ks-work-ico">
                        <img class="item1" src="/assets/img/main/ico_work01.png" alt="">
                    </span>
                    <span class="ks-work-txt">급경사지<br>실태조사</span>
                </a>
            </li>

            <li class="ks-work-sep" aria-hidden="true"></li>

            <li class="ks-work-item">
                <a href="#" class="ks-work-link">
                    <span class="ks-work-ico">
                        <img class="item2" src="/assets/img/main/ico_work02.png" alt="">
                    </span>
                    <span class="ks-work-txt">급경사지<br>안전점검</span>
                </a>
            </li>

            <li class="ks-work-sep" aria-hidden="true"></li>

            <li class="ks-work-item">
                <a href="#" class="ks-work-link">
                    <span class="ks-work-ico">
                        <img class="item3" src="/assets/img/main/ico_work03.png" alt="">
                    </span>
                    <span class="ks-work-txt">급경사지<br>재해위험도평가</span>
                </a>
            </li>

            <li class="ks-work-sep" aria-hidden="true"></li>

            <li class="ks-work-item">
                <a href="#" class="ks-work-link">
                    <span class="ks-work-ico">
                        <img class="item4" src="/assets/img/main/ico_work04.png" alt="">
                    </span>
                    <span class="ks-work-txt">급경사지<br>정밀조사</span>
                </a>
            </li>

            <li class="ks-work-sep" aria-hidden="true"></li>

            <li class="ks-work-item">
                <a href="#" class="ks-work-link">
                    <span class="ks-work-ico">
                        <img class="item5" src="/assets/img/main/ico_work05.png" alt="">
                    </span>
                    <span class="ks-work-txt">급경사지<br>지형도면작성</span>
                </a>
            </li>

            <li class="ks-work-sep" aria-hidden="true"></li>

            <li class="ks-work-item">
                <a href="#" class="ks-work-link">
                    <span class="ks-work-ico">
                        <img class="item6" src="/assets/img/main/ico_work06.png" alt="">
                    </span>
                    <span class="ks-work-txt">급경사지<br>R&amp;D</span>
                </a>
            </li>
        </ul>

    </section>
    <section class="kssa-webzine">
        <div class="kssa-webzine__inner">

            <div class="kssa-webzine__head">
                <h2 class="kssa-webzine__ttl">한국급경사지안전협회 웹진</h2>
                <a href="/association_journal" class="kssa-webzine__more">더보기 +</a>
            </div>

            <div class="swiper kssa-webzine__swiper">
                <div class="swiper-wrapper">

                    <!-- slide -->
                    <div class="swiper-slide">
                        <a class="kssa-zine-card" href="#">
                            <div class="kssa-zine-card__thumb">
                                <img src="/assets/img/main/zine1.png" alt="">
                            </div>
                            <div class="kssa-zine-card__body">
                                <p class="kssa-zine-card__desc">
                                    국내·외 산사태 ‘명림림 재해 현황 및 예방을 위한 대책…
                                </p>
                                <span class="kssa-zine-card__date">2026.00.00</span>
                            </div>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a class="kssa-zine-card" href="#">
                            <div class="kssa-zine-card__thumb">
                                <img src="/assets/img/main/zine1.png" alt="">
                            </div>
                            <div class="kssa-zine-card__body">
                                <p class="kssa-zine-card__desc">
                                    국내·외 산사태 ‘명림림 재해 현황 및 예방을 위한 대책…
                                </p>
                                <span class="kssa-zine-card__date">2026.00.00</span>
                            </div>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a class="kssa-zine-card" href="#">
                            <div class="kssa-zine-card__thumb">
                                <img src="/assets/img/main/zine1.png" alt="">
                            </div>
                            <div class="kssa-zine-card__body">
                                <p class="kssa-zine-card__desc">
                                    국내·외 산사태 ‘명림림 재해 현황 및 예방을 위한 대책…
                                </p>
                                <span class="kssa-zine-card__date">2026.00.00</span>
                            </div>
                        </a>
                    </div>

                    <!-- slide -->
                    <div class="swiper-slide">
                        <a class="kssa-zine-card" href="#">
                            <div class="kssa-zine-card__thumb">
                                <img src="/assets/img/main/zine1.png" alt="">
                            </div>
                            <div class="kssa-zine-card__body">
                                <p class="kssa-zine-card__desc">
                                    국내·외 산사태 ‘명림림 재해 현황 및 예방을 위한 대책…
                                </p>
                                <span class="kssa-zine-card__date">2026.00.00</span>
                            </div>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a class="kssa-zine-card" href="#">
                            <div class="kssa-zine-card__thumb">
                                <img src="/assets/img/main/zine1.png" alt="">
                            </div>
                            <div class="kssa-zine-card__body">
                                <p class="kssa-zine-card__desc">
                                    국내·외 산사태 ‘명림림 재해 현황 및 예방을 위한 대책…
                                </p>
                                <span class="kssa-zine-card__date">2026.00.00</span>
                            </div>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a class="kssa-zine-card" href="#">
                            <div class="kssa-zine-card__thumb">
                                <img src="/assets/img/main/zine1.png" alt="">
                            </div>
                            <div class="kssa-zine-card__body">
                                <p class="kssa-zine-card__desc">
                                    국내·외 산사태 ‘명림림 재해 현황 및 예방을 위한 대책…
                                </p>
                                <span class="kssa-zine-card__date">2026.00.00</span>
                            </div>
                        </a>
                    </div>



                </div>
            </div>

            <div class="kssa-webzine__ctrl">
                <button class="kssa-webzine__btn kssa-webzine__prev" type="button" aria-label="prev">
                    <img src="/assets/img/common/ico_arrow_left_thin.png" alt="">
                </button>

                <div class="kssa-webzine__fraction">
                    <span class="kssa-webzine__cur">01</span>
                    <span class="kssa-webzine__slash">/</span>
                    <span class="kssa-webzine__tot">10</span>
                </div>

                <button class="kssa-webzine__btn kssa-webzine__next" type="button" aria-label="next">
                    <img src="/assets/img/common/ico_arrow_right_thin.png" alt="">
                </button>
            </div>

        </div>
    </section>

</main>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<style>
    body {
        background: #333333
    }
</style>
<script type="text/javascript"
    src="//dapi.kakao.com/v2/maps/sdk.js?appkey=039613133f7574093697899a60f58e40">
</script>
<!-- <script>
    const heroSwiper = new Swiper('.hero-swiper', {
        loop: true,
        effect: 'fade',
        autoplay: {
            delay: 4000,
            disableOnInteraction: false
        },
        pagination: {
            el: '.hero-pagination',
            clickable: true
        },
        on: {
            init() {
                setPlayingUI(true);
            }
        }
    });
</script> -->
<!-- <script>
    const playBtn = document.getElementById('heroPlayBtn');
    const pauseBtn = document.getElementById('heroPauseBtn');

    function setPlayingUI(isPlaying) {
        if (isPlaying) {
            pauseBtn.classList.add('is-active');
            playBtn.classList.remove('is-active');
        } else {
            playBtn.classList.add('is-active');
            pauseBtn.classList.remove('is-active');
        }
    }

    setPlayingUI(true);

    playBtn.addEventListener('click', () => {
        heroSwiper.autoplay.start();
        setPlayingUI(true);
    });

    pauseBtn.addEventListener('click', () => {
        heroSwiper.autoplay.stop();
        setPlayingUI(false);
    });
</script> -->
<script>
    document.addEventListener('DOMContentLoaded', () => {

        const playBtn = document.getElementById('heroPlayBtn');
        const pauseBtn = document.getElementById('heroPauseBtn');

        function setPlayingUI(isPlaying) {
            if (isPlaying) {
                pauseBtn.classList.add('is-active');
                playBtn.classList.remove('is-active');
            } else {
                playBtn.classList.add('is-active');
                pauseBtn.classList.remove('is-active');
            }
        }

        const heroSwiper = new Swiper('.hero-swiper', {
            loop: true,
            effect: 'fade',
            autoplay: {
                delay: 4000,
                disableOnInteraction: false
            },
            pagination: {
                el: '.hero-pagination',
                clickable: true
            },
            on: {
                init() {
                    setPlayingUI(true);
                }
            }
        });

        heroSwiper.autoplay.start();
        setPlayingUI(true);

        playBtn.addEventListener('click', () => {
            heroSwiper.autoplay.start();
            setPlayingUI(true);
        });

        pauseBtn.addEventListener('click', () => {
            heroSwiper.autoplay.stop();
            setPlayingUI(false);
        });

    });
</script>

<script>
    const zineSwiper = new Swiper('.kssa-webzine__swiper', {
        slidesPerView: 3,
        slidesPerGroup: 1,
        spaceBetween: 30,
        loop: true,
        loopedSlides: 3,
        speed: 600,

        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },

        navigation: {
            prevEl: '.kssa-webzine__prev',
            nextEl: '.kssa-webzine__next',
        },
        breakpoints: {
            0: {
                slidesPerView: 1.25,
                spaceBetween: 18 
            },
            360: {
                slidesPerView: 1.3,
                spaceBetween: 20 
            },
            432: {
                slidesPerView: 1.33,
                spaceBetween: 35
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30
            }
        },

        on: {
            init(swiper) {
                updateZineFraction(swiper);
            },
            slideChange(swiper) {
                updateZineFraction(swiper);
            }
        }
    });

    function updateZineFraction(swiper) {
        const curEl = document.querySelector('.kssa-webzine__cur');
        const totEl = document.querySelector('.kssa-webzine__tot');

        const total = swiper.slides.filter(
            slide => !slide.classList.contains('swiper-slide-duplicate')
        ).length;

        const current = swiper.realIndex + 1;

        curEl.textContent = current < 10 ? `0${current}` : current;
        totEl.textContent = total < 10 ? `0${total}` : total;

        curEl.classList.add('is-active');
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const container = document.querySelector(".ks-work");
        if (!container) return;

        const items = [...container.children];

        let lastItemTop = null;

        items.forEach((el, i) => {
            if (!el.classList.contains("ks-work-item")) return;

            const currentTop = el.offsetTop;

            if (lastItemTop !== null && currentTop > lastItemTop) {
                const prev = items[i - 1];
                if (prev && prev.classList.contains("ks-work-sep")) {
                    prev.style.display = "none";
                }
            }

            lastItemTop = currentTop;
        });
    });
</script>

<?php $this->endSection(); ?>