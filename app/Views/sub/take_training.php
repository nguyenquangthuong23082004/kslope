<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
    <script src="https://www.youtube.com/iframe_api"></script>
    <style>
        #overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            display: none;
            z-index: 999;
        }

        #videoPopup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 900px;
            background: #fff;
            border-radius: 8px;
            padding: 32px 16px 16px;
            display: none;
            z-index: 1000;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        .close-btn {
            position: absolute;
            top: 4px;
            right: 16px;
            cursor: pointer;
            font-size: 18px;
        }

    </style>
    <main id="container" class="main main_new ">
        <section class="ci-intro dif">

            <div class="ci-bc">
                <a href="#" class="ci-bc__item">HOME</a>
                <a href="#" class="ci-bc__item">계측전문인력 교육</a>

                <a href="#" class="ci-bc__item ci-bc__item--select">
                    교육 수강
                    <img class="ci-bc__ico" src="/assets/img/sub/ico_select_down.png" alt="">
                </a>
            </div>

            <h1 class="ci-title">교육 수강</h1>

            <nav class="ci-tab">
                <a href="#">교육 안내</a>
                <a href="/apply_for_training">교육 신청</a>
                <a href="/take_training" class="is-active">교육 수강</a>
                <a href="/completioncert_reissue">수료증 재발급 신청</a>
            </nav>

            <div class="ci-visual">
                <img src="/assets/img/sub/ci_visual_training.png" alt="">
                <div class="ci-visual-text">
                    <p class="text_dif">계측전문인력 교육</p>
                    <p class="text-en">Training Attendance</p>
                    <p class="text-en-small">Korea Slope Safety Association</p>
                </div>
            </div>

        </section>


        <section class="job-list-wrap">
            <div class="job-top">
                <div class="job-total">Total: <strong><?= $total ?></strong></div>

                <form method="get" action="">
                    <div class="job-filter">

                        <div class="job-select">
                            <select name="search_name" id="search_name">
                                <option <?= $search_name == '' ? 'selected' : '' ?> value="">카테고리</option>
                                <option <?= $search_name == 'course_name' ? 'selected' : '' ?> value="course_name">제목
                                </option>
                                <option <?= $search_name == 'mentor' ? 'selected' : '' ?> value="mentor">강사</option>
                                <option <?= $search_name == 'price' ? 'selected' : '' ?> value="price">수강료</option>
                            </select>
                        </div>

                        <div class="job-search">
                            <input type="text" placeholder="" name="keyword" id="keyword" value="<?= $keyword ?>">
                            <button type="button" aria-label="search">
                                <img src="/assets/img/sub/ico_search.png" alt="">
                            </button>
                        </div>

                    </div>
                </form>
            </div>
            <script>
                document.querySelector('.job-search button').addEventListener('click', function () {
                    this.closest('form').submit();
                });

                document.getElementById('keyword').addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        this.closest('form').submit();
                    }
                });
            </script>

            <!-- course list -->
            <div class="course-list">
                <?php if (empty($list)): ?>
                    <p style="text-align: center; margin: 50px auto;">검색 결과가 없습니다</p>
                <?php endif; ?>
                <?php foreach ($list as $row): ?>
                    <!-- item -->
                    <div class="course-item">
                        <a href="/take_training_detail?idx=<?= $row['idx'] ?>" class="course-thumb">
                            <img src="/uploads/course/<?= $row['u_file'] ?>" alt="<?= $row['r_file'] ?>">
                        </a>

                        <div class="course-info">
                            <a href="/take_training_detail?idx=<?= $row['idx'] ?>">
                                <h3 class="course-title">
                                    <?= getCodeCourse($row['idx']) ?>
                                </h3>
                            </a>
                            <a href="/take_training_detail?idx=<?= $row['idx'] ?>">
                                <p class="course-desc">
                                    <?= $row['course_name'] ?>
                                </p>
                            </a>

                            <div class="course-meta">

                                <div class="course-meta-row">
                                    <img src="/assets/img/sub/ico_video.png" alt="">
                                    <div class="wrap_content">
                                        <span class="label">샘플강의 :</span>
                                         <?php if (!empty($row['first_video']) && !empty($row['first_video']['video_url'])): ?>
                                            <button type="button" 
                                                    onclick="openVideo('normal', '<?= $row['first_video']['video_url'] ?>')"
                                                    class="tag">보기</button>
                                        <?php endif; ?>
                                        <!-- <button type="button" onclick="openVideo('normal', '<?= $row['course_url'] ?>')"
                                                class="tag">보기
                                        </button> -->
                                        <!-- <button type="button" onclick="openVideo('hd', '<?= $row['course_url'] ?>')"
                                                class="tag diferen">고
                                        </button> -->
                                    </div>
                                </div>

                                <div class="course-meta-row">
                                    <img src="/assets/img/sub/ico_calendar.png" alt="">
                                    <div class="wrap_content">
                                        <span class="label">수강기간 :</span>
                                        <span class="value"><?= date('Y.m.d', strtotime($row['start_date'])) ?> ~ <?= date('Y.m.d', strtotime($row['end_date'])) ?>(<?= daysBetween($row['start_date'], $row['end_date']) ?>낮)</span>
                                    </div>
                                </div>

                                <div class="course-meta-row">
                                    <img src="/assets/img/sub/ico_user.png" alt="">
                                    <div class="wrap_content">
                                        <span class="label">강사명 :</span>
                                        <span class="value"><?= $row['mentor'] ?></span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="course-action">
                            <div class="course-price">
                                수강료: <?= $row['price'] > 0 ? number_format($row['price']) . '원' : '무료' ?></div>
                            <div class="course-price-line"><span></span></div>

                            <a href="/take_training_detail?idx=<?= $row['idx'] ?>" class="course-btn course-btn--gray">상세보기</a>
                            <!-- <?php if (isset($allowedCourses) && in_array($row['idx'], $allowedCourses)): ?>
                                <a href="/reservation/create?course_idx=<?= $row['idx'] ?>"
                                class="course-btn course-btn--blue">수강신청</a>
                            <?php endif; ?> -->
                            <!-- <a href="/reservation/create?course_idx=<?= $row['idx'] ?>"
                               class="course-btn course-btn--blue">수강신청</a> -->
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

            <?php
            $pagerData = $pager->getDetails();
            $currentPage = $pagerData['currentPage'];
            $totalPage = $pagerData['pageCount'];
            ?>

            <div class="pagination">
                <!-- first -->
                <button class="pg-btn <?= $currentPage == 1 ? 'disabled' : '' ?>"
                        onclick="goPage(1)">
                    <img src="/assets/img/sub/ico_pg_first.png">
                </button>

                <!-- prev -->
                <button class="pg-btn <?= $currentPage == 1 ? 'disabled' : '' ?>"
                        onclick="goPage(<?= max(1, $currentPage - 1) ?>)">
                    <img src="/assets/img/sub/ico_pg_prev.png">
                </button>

                <!-- pages -->
                <ul class="pg-list">
                    <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                        <li class="pg-item <?= $i == $currentPage ? 'active' : '' ?>">
                            <a href="javascript:void(0)" onclick="goPage(<?= $i ?>)">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>

                <!-- next -->
                <button class="pg-btn <?= $currentPage == $totalPage ? 'disabled' : 'primary' ?>"
                        onclick="goPage(<?= min($totalPage, $currentPage + 1) ?>)">
                    <img src="/assets/img/sub/ico_pg_next.png">
                </button>

                <!-- last -->
                <button class="pg-btn <?= $currentPage == $totalPage ? 'disabled' : 'primary' ?>"
                        onclick="goPage(<?= $totalPage ?>)">
                    <img src="/assets/img/sub/ico_pg_last.png">
                </button>

            </div>

        </section>

    </main>

    <div id="overlay" onclick="closePopup()"></div>
    <div id="videoPopup">
        <span class="close-btn" onclick="closePopup()">✕</span>

        <div id="player"></div>
    </div>

    <script>
        $(function () {
            $(".ci-subtab__item").on("click", function (e) {
                e.preventDefault();

                $(".ci-subtab__item").removeClass("is-active");
                $(this).addClass("is-active");
            });
        });
    </script>
    <script>
        function goPage(page) {
            const url = new URL(window.location.href);
            url.searchParams.set('page', page);
            window.location.href = url.toString();
        }
    </script>
    <script>
        function getYouTubeId(url) {
            if (!url) return null;

            // embed
            let match = url.match(/embed\/([a-zA-Z0-9_-]{11})/);
            if (match) return match[1];

            // watch?v=
            match = url.match(/[?&]v=([a-zA-Z0-9_-]{11})/);
            if (match) return match[1];

            // youtu.be
            match = url.match(/youtu\.be\/([a-zA-Z0-9_-]{11})/);
            if (match) return match[1];

            return null;
        }
    </script>

    <script>
        // let player;
        // let pendingQuality = 'hd720';

        // function onYouTubeIframeAPIReady() {
        //     player = new YT.Player('player', {
        //         width: 900,
        //         height: 800,
        //         playerVars: {
        //             autoplay: 1,
        //             rel: 0
        //         },
        //         events: {
        //             onReady: function () {

        //             }
        //         }
        //     });
        // }

        // function openVideo(type, url) {
        //     document.getElementById('overlay').style.display = 'block';
        //     document.getElementById('videoPopup').style.display = 'block';

        //     pendingQuality = (type === 'hd') ? 'hd720' : 'medium';

        //     const videoId = getYouTubeId(url);

        //     if (player) {
        //         player.loadVideoById({
        //             videoId: videoId,
        //             suggestedQuality: pendingQuality
        //         });
        //     }
        // }

        // function closePopup() {
        //     document.getElementById('overlay').style.display = 'none';
        //     document.getElementById('videoPopup').style.display = 'none';

        //     if (player) {
        //         player.pauseVideo();
        //     }
        // }

       let player;
        let playerType = null; 
        let pendingQuality = 'hd720';
        let videoTimer = null;
        let maxDuration = 10; 
        let isPlayerReady = false;
        let hasShownAlert = false;

        function onYouTubeIframeAPIReady() {
        }

        function onPlayerReady(event) {
            isPlayerReady = true;
        }

        function onPlayerStateChange(event) {
            if (event.data == YT.PlayerState.PLAYING) {
                if (videoTimer) {
                    clearInterval(videoTimer);
                }
                
                videoTimer = setInterval(function() {
                    if (player && playerType === 'youtube' && isPlayerReady && typeof player.getCurrentTime === 'function') {
                        try {
                            const currentTime = player.getCurrentTime();
                            if (currentTime >= maxDuration) {
                                player.pauseVideo();
                                clearInterval(videoTimer);
                                videoTimer = null;
                                
                                if (!hasShownAlert) {
                                    hasShownAlert = true;
                                    alert('샘플 영상은 10초까지만 시청 가능합니다.');
                                }
                            }
                        } catch (e) {
                            console.log('Error getting current time:', e);
                            clearInterval(videoTimer);
                            videoTimer = null;
                        }
                    }
                }, 100);
            } else {
                if (videoTimer) {
                    clearInterval(videoTimer);
                    videoTimer = null;
                }
            }
        }

        function openVideo(type, url) {
            isPlayerReady = false;
            hasShownAlert = false;
            
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('videoPopup').style.display = 'block';

            pendingQuality = (type === 'hd') ? 'hd720' : 'medium';

            const videoType = getVideoType(url);
            
            if (videoType === 'youtube') {
                openYouTubeVideo(url);
            } else if (videoType === 'vimeo') {
                openVimeoVideo(url);
            } else {
                alert('지원되지 않는 비디오 형식입니다. YouTube와 Vimeo만 지원됩니다.');
                closePopup();
            }
        }

        function openYouTubeVideo(url) {
            playerType = 'youtube';
            const videoId = getYouTubeId(url);
            
            if (!videoId) {
                alert('유효하지 않은 YouTube URL입니다.');
                closePopup();
                return;
            }

            const playerDiv = document.getElementById('player');
            playerDiv.innerHTML = '';

            const ytDiv = document.createElement('div');
            ytDiv.id = 'youtube-player';
            playerDiv.appendChild(ytDiv);

            player = new YT.Player('youtube-player', {
                width: 900,
                height: 506,
                videoId: videoId,
                playerVars: {
                    autoplay: 1,
                    rel: 0,
                    start: 0,      
                    end: maxDuration,  
                    controls: 1,
                    modestbranding: 1
                },
                events: {
                    onReady: onPlayerReady,
                    onStateChange: onPlayerStateChange
                }
            });
        }

        function openVimeoVideo(url) {
            playerType = 'vimeo';
            const vimeoId = getVimeoId(url);
            
            if (!vimeoId) {
                alert('유효하지 않은 Vimeo URL입니다.');
                closePopup();
                return;
            }

            const playerDiv = document.getElementById('player');
            playerDiv.innerHTML = '';

            const iframe = document.createElement('iframe');
            iframe.id = 'vimeo-player';
            iframe.src = `https://player.vimeo.com/video/${vimeoId}?autoplay=1&muted=0&title=0&byline=0&portrait=0#t=0s`;
            iframe.width = 900;
            iframe.height = 506;
            iframe.frameBorder = 0;
            iframe.allow = 'autoplay; fullscreen';
            iframe.allowFullscreen = true;
            
            playerDiv.appendChild(iframe);

            player = new Vimeo.Player(iframe);
            
            player.setCurrentTime(0).catch(function(error) {
                console.log('Error setting time:', error);
            });
            
            player.on('timeupdate', function(data) {
                if (data.seconds >= maxDuration) {
                    if (!hasShownAlert) {
                        hasShownAlert = true;
                        player.pause().then(function() {
                            alert('샘플 영상은 10초까지만 시청 가능합니다.');
                        }).catch(function(error) {
                            console.log('Error pausing:', error);
                        });
                    }
                }
            });
            
            player.on('seeked', function(data) {
                if (data.seconds > maxDuration) {
                    player.setCurrentTime(0).catch(function(error) {
                        console.log('Error seeking:', error);
                    });
                }
            });
            
            player.play().catch(function(error) {
                console.log('Error playing:', error);
            });
        }

        function closePopup() {
            if (videoTimer) {
                clearInterval(videoTimer);
                videoTimer = null;
            }
            
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('videoPopup').style.display = 'none';
            
            if (player) {
                try {
                    if (playerType === 'youtube') {
                        if (isPlayerReady && typeof player.stopVideo === 'function') {
                            player.stopVideo();
                        }
                        if (typeof player.destroy === 'function') {
                            player.destroy();
                        }
                    } else if (playerType === 'vimeo') {
                        if (typeof player.pause === 'function') {
                            player.pause();
                        }
                        if (typeof player.destroy === 'function') {
                            player.destroy();
                        }
                    }
                } catch (e) {
                    console.log('Error closing player:', e);
                }
            }
            
            setTimeout(function() {
                document.getElementById('player').innerHTML = '';
                player = null;
                playerType = null;
                isPlayerReady = false;
                hasShownAlert = false;
            }, 100);
        }

        function getVideoType(url) {
            if (getYouTubeId(url)) return 'youtube';
            if (getVimeoId(url)) return 'vimeo';
            return 'unknown';
        }

        function getYouTubeId(url) {
            const patterns = [
                /(?:youtube\.com\/watch\?v=)([a-zA-Z0-9_-]{11})/,
                /(?:youtu\.be\/)([a-zA-Z0-9_-]{11})/,
                /(?:youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/,
                /(?:youtube\.com\/v\/)([a-zA-Z0-9_-]{11})/
            ];

            for (const pattern of patterns) {
                const match = url.match(pattern);
                if (match) return match[1];
            }

            return null;
        }

        function getVimeoId(url) {
            const patterns = [
                /vimeo\.com\/(?:video\/)?(\d+)/,
                /player\.vimeo\.com\/video\/(\d+)/,
                /vimeo\.com\/channels\/[^\/]+\/(\d+)/,
                /vimeo\.com\/groups\/[^\/]+\/videos\/(\d+)/
            ];

            for (const pattern of patterns) {
                const match = url.match(pattern);
                if (match) return match[1];
            }

            return null;
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const overlay = document.getElementById('overlay');
                if (overlay && overlay.style.display === 'block') {
                    closePopup();
                }
            }
        });
    </script>
<?php $this->endSection(); ?>