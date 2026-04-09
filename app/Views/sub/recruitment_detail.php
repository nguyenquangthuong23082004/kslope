<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
    <link rel="stylesheet" href="/admin/vendor/bootstrap-icons/bootstrap-icons.min.css">

    <main id="container" class="main main_new view_main recruitment_detail container">
        <div class="main-content">
            <div class="title-section">
                <div class="logo">
                    <img src="/uploads/bbs/<?= $row['ufile1'] ?>" alt="한국금융사기안전원회">
                </div>
                <h1><?= $row['subject'] ?></h1>
                <div class="status-bar">
                    <?php if (compareDate($row['e_date']) > 0): ?>
                        <span class="status-badge">접수중</span>
                    <?php else: ?>
                        <span class="status-badge expired">마감</span>
                    <?php endif; ?>
                    <span class="date-range"><?= date('Y.m.d', strtotime($row['s_date'])) ?> ~ <?= date('Y.m.d', strtotime($row['e_date'])) ?></span>
                    <button class="share-btn">⚲</button>
                </div>
            </div>

            <div class="">
                <div class="job-details">
                    <h2>채용 정보</h2>

                    <div class="job-content">
                        <div class="content-wrapper">
                            <!-- Left Section - Job Details -->
                            <div class="detail-grid">
                                <div class="detail-row">
                                    <div class="detail-item">
                                        <span class="label">접수 기간</span>
                                        <span class="value"><?= date('Y.m.d', strtotime($row['s_date'])) ?> ~ <?= date('Y.m.d', strtotime($row['e_date'])) ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="label">접수 방법</span>
                                        <span class="value"><?= $row['apply_method'] ?? '' ?> <i
                                                    class="bi bi-box-arrow-up-right"></i></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="label">담당자</span>
                                        <span class="value"><?= $row['manager_name'] ?? '' ?></span>
                                    </div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-item">
                                        <span class="label">채용 구분</span>
                                        <span class="value"><?= $row['recruit_type'] ?? '' ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="label">고용 형태</span>
                                        <span class="value"><?= $row['employment_type'] ?? '' ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="label">연락처</span>
                                        <span class="value"><?= $row['contact_phone'] ?? '' ?></span>
                                    </div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-item">
                                        <span class="label">지원 자격</span>
                                        <span class="value"><?= $row['qualification'] ?? '' ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="label">모집 전공</span>
                                        <span class="value"><?= $row['contents2'] ?? '' ?></span>
                                    </div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-item">
                                        <span class="label">기관 유형</span>
                                        <span class="value"><?= $row['organization_type'] ?? '' ?> <i
                                                    class="bi bi-plus-circle"></i></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="label">근무 지역</span>
                                        <span class="value"><?= $row['work_location'] ?? '' ?> <i class="bi bi-geo"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="job-detail" class="job-detail">
                            <?= $row['contents'] ?? '' ?>
                        </div>

                        <div class="btn-wrapper">
                            <button type="button" class="btn-read" style="display:none;">내용 전체보기</button>
                        </div>
                    </div>

                </div>

                <?php if (!empty($row['ufile2'])): ?>
                    <?php
                    $filePath = $row['ufile2'];
                    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                    $imageExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    ?>
                    <div class="job-file">
                        <?php if (in_array($ext, $imageExt)): ?>
                            <img src="/uploads/bbs/<?= $filePath ?>" alt="Image"
                                 style="max-width: 100%; height: auto;">

                        <?php elseif ($ext === 'pdf'): ?>
                            <iframe src="/uploads/bbs/<?= $filePath ?>"
                                    width="100%"
                                    height="600px"
                                    style="border: none;"></iframe>

                        <?php else: ?>
                            <a href="<?= $filePath ?>" target="_blank" download>
                                파일 다운로드
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="job-maps">
                    <h2>근무 예정지</h2>

                    <div class="map-content">
                        <div class="map-title">
                            <img class="pin-map" src="/assets/img/sub/ico_pin_red.png" alt="location"> 세종
                            : <?= $row['zip'] ?? '' ?> - <?= $row['addr1'] ?? '' ?>, <?= $row['addr2'] ?? '' ?>
                        </div>
                        <!-- map -->
                        <div class="location-map">
                            <!-- <img src="/assets/img/sub/map_location.png" alt="map"> -->
                            <div id="daumRoughmapContainer1767929315633"
                                 class="root_daum_roughmap root_daum_roughmap_landing"></div>
                        </div>
                    </div>
                </div>

                <div class="company-info">
                    <h2>기관 정보</h2>

                    <div class="company-content">
                        <div class="company-base">
                            <img src="/uploads/bbs/<?= $row['ufile1'] ?>" alt="한국금융사기안전원회">
                            <div class="c-name"><?= $row['company_name'] ?></div>
                        </div>
                        <div class="company-detail">
                            <div class="c-item">
                                <div class="c-txt">기관유형</div>
                                <div class="c-val"><?= $row['company_type'] ?></div>
                            </div>
                            <div class="c-item">
                                <div class="c-txt">대표전화</div>
                                <div class="c-val"><?= $row['company_phone'] ?></div>
                            </div>
                            <div class="c-item">
                                <div class="c-txt">홈페이지</div>
                                <div class="c-val"><?= $row['homepage'] ?> <i class="bi bi-box-arrow-up-right"></i>
                                </div>
                            </div>
                            <div class="c-item">
                                <div class="c-txt">대표주소</div>
                                <div class="c-val"><?= $row['company_address'] ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.querySelectorAll('.board-nav .nav-item').forEach(item => {
            const label = item.querySelector('.nav-label');

            label.addEventListener('click', () => {
                item.classList.toggle('is-open');
            });
        });
    </script>
    <script charset="UTF-8" class="daum_roughmap_loader_script"
            src="https://ssl.daumcdn.net/dmaps/map_js_init/roughmapLoader.js"></script>
    <script charset="UTF-8">
        new daum.roughmap.Lander({
            "timestamp": "1767929315633",
            "key": "fpey4nf34se",
            "mapWidth": "1200",
            "mapHeight": "420"
        }).render();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const content = document.getElementById('job-detail');
            const btn = document.querySelector('.btn-read');

            if (content.scrollHeight > 400) {
                btn.style.display = 'inline-block';
            }

            btn.addEventListener('click', function () {
                content.classList.toggle('open');

                if (content.classList.contains('open')) {
                    btn.textContent = '접기';
                } else {
                    btn.textContent = '내용 전체보기';
                }
            });
        });
    </script>
    <script type="text/javascript"
            src="//dapi.kakao.com/v2/maps/sdk.js?appkey=d09d5b2ec029dc309ceca7c52ae5c0c2"></script>
    <script>
        var mapContainer = document.getElementById('map'),
            mapOption = {
                center: new kakao.maps.LatLng(37.5267037655637, 126.916475621279),
                level: 3
            };

        var map = new kakao.maps.Map(mapContainer, mapOption);

        var points = [
            new kakao.maps.LatLng(37.5267037655637, 126.916475621279)
        ];

        var bounds = new kakao.maps.LatLngBounds();

        var i, marker;
        for (i = 0; i < points.length; i++) {
            marker = new kakao.maps.Marker({position: points[i]});
            marker.setMap(map);

            bounds.extend(points[i]);
        }

        function setBounds() {
            map.setBounds(bounds);
        }
    </script>
<?php $this->endSection(); ?>