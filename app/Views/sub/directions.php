<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
<main id="container" class="main main_new">
    <section class="ci-intro dif">

        <div class="ci-bc">
            <a href="#" class="ci-bc__item">HOME</a>
            <a href="#" class="ci-bc__item">협회 소개</a>

            <a href="#" class="ci-bc__item ci-bc__item--select">
                오시는 길
                <img class="ci-bc__ico" src="/assets/img/sub/ico_select_down.png" alt="">
            </a>
        </div>

        <h1 class="ci-title">오시는 길</h1>

        <nav class="ci-tab">
            <a href="/greeting">협회 인사말</a>
            <a href="/history">설립 목적 및 연혁</a>
            <a href="/vision">비전</a>
            <a href="/organization_guide">조직 안내</a>
            <a href="/ci_introduction">CI 소개</a>
            <a href="/past_presidents">역대회장</a>
            <a href="/directions" class="is-active">오시는 길</a>
        </nav>

        <div class="ci-visual">
            <img src="/assets/img/sub/ci_visual_contact.png" alt="">
            <div class="ci-visual-text">
                <p class="text_dif">협회소개</p>
                <p class="text-en">Directions</p>
                <p class="text-en-small">Korea Slope Safety Association</p>
            </div>
        </div>

    </section>
    <section class="location-section">
        <div class="location-inner">

            <!-- title -->
            <div class="location-title">
                <span class="location-pin">
                    <img src="/assets/img/sub/ico_pin_red.png" alt="pin">
                </span>
                <h3>한국급경사지안전협회</h3>
                <p>세종특별자치시 나성북로 21, 센트럴타워 8층</p>
            </div>

            <!-- map -->
            <div class="location-map">
                <!-- <img src="/assets/img/sub/map_location.png" alt="map"> -->
                <div id="daumRoughmapContainer1767929315633" class="root_daum_roughmap root_daum_roughmap_landing"></div>
            </div>

            <!-- contact info -->
            <ul class="location-info">
                <li>
                    <img src="/assets/img/sub/ico_phone.png" alt="">
                    <span>대표번호 : 044-868-5680</span>
                </li>
                <li>
                    <img src="/assets/img/sub/ico_fax.png" alt="">
                    <span>팩스번호 : 044-868-5681</span>
                </li>
                <li>
                    <img src="/assets/img/sub/ico_mail.png" alt="">
                    <span>메일주소 : korea-slope@naver.com</span>
                </li>
            </ul>

        </div>
    </section>
    <section class="traffic-section">
        <div class="traffic-inner">

            <div class="wrap_line">
                <h3 class="traffic-title">교통편 안내</h3>
                <div class="traffic-row">
                    <div class="traffic-icon">
                        <img class="ico_bus" src="/assets/img/sub/ico_bus.png" alt="bus">
                    </div>
                    <div class="o_wrap">

                        <strong class="traffic-head">센트럴타워 · 나성동 정류장</strong>
                        <div class="traffic-content">

                            <div class="traffic-bus">
                                <span class="bus-tag blue-btn">간선</span>
                                <span class="bus-text">1001, 1002 (BRT)</span>
                            </div>

                            <div class="traffic-bus">
                                <span class="bus-tag red-btn">지선</span>
                                <span class="bus-text">221, 222, 340, 341</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="traffic-row dif">
                <div class="traffic-icon">
                    <img class="ico_car" src="/assets/img/sub/ico_car.png" alt="car">
                </div>
                <div class="o_wrap">
                    <strong class="traffic-head">승용차</strong>
                    <div class="traffic-content">

                        <ul class="traffic-list">
                            <li>
                                한누리대로
                                <img src="/assets/img/sub/ico_arrow_right.png" class="arrow-img" alt="→">
                                나성북로 진입
                                <img src="/assets/img/sub/ico_arrow_right.png" class="arrow-img" alt="→">
                                센트럴타워 방향
                            </li>

                            <li>
                                세종대로
                                <img src="/assets/img/sub/ico_arrow_right.png" class="arrow-img" alt="→">
                                나성북로
                                <img src="/assets/img/sub/ico_arrow_right.png" class="arrow-img" alt="→">
                                센트럴타워 도착
                            </li>

                            <li>
                                정부세종청사 인근
                                <img src="/assets/img/sub/ico_arrow_right.png" class="arrow-img" alt="→">
                                나성동 중심상업지구 방향
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </section>


</main>
<script charset="UTF-8" class="daum_roughmap_loader_script" src="https://ssl.daumcdn.net/dmaps/map_js_init/roughmapLoader.js"></script>
<script charset="UTF-8">
    new daum.roughmap.Lander({
        "timestamp": "1767929315633",
        "key": "fpey4nf34se",
        "mapWidth": "1200",
        "mapHeight": "500"
    }).render();
</script>
<?php $this->endSection(); ?>