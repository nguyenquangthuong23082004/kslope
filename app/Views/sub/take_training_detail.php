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
            max-width: calc(100vw - 32px);
            background: #fff;
            border-radius: 8px;
            padding: 32px 16px 16px;
            display: none;
            z-index: 1000;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        #player {
            position: relative;
            width: 100%;
            padding-top: 56.25%;
        }

        #player iframe,
        #player > div {
            position: absolute;
            top: 0;
            left: 0;
            width: 100% !important;
            height: 100% !important;
        }

        .close-btn {
            position: absolute;
            top: 4px;
            right: 16px;
            cursor: pointer;
            font-size: 18px;
        }

    </style>
    <main id="container" class="main main_new main_detail view_main">

        <section class="job-list-wrap">

            <div class="course-detail-section">
                <div class="course-detail-inner">

                    <!-- back -->
                    <a href="javascript:history.back();" class="course-back">
                        <img
                                src="/img/ico/left-arrows.png"
                                alt="뒤로가기"
                                class="ico-back-img">
                        목록보기
                    </a>

                    <div class="course-detail-wrap">

                        <!-- left image -->
                        <div class="course-detail-thumb">
                            <img src="/uploads/course/<?= $course['u_file'] ?>" alt="<?= $course['r_file'] ?>">
                        </div>

                        <!-- right info -->
                        <div class="course-detail-info">

                            <div class="course-path">
                                <?= getCodeCourse($course['idx']) ?>
                            </div>

                            <h2 class="course-detail-title">
                                <?= $course['course_name'] ?>
                            </h2>

                            <ul class="course-detail-meta">
                                <li>
                                    <span class="label">강사</span>
                                    <span class="value"><?= $course['mentor'] ?></span>
                                </li>
                                <li>
                                    <span class="label">강의수/기간</span>
                                    <span class="value"><?= $course['number_lecture'] ?>/<?= $course['duration'] ?>일</span>
                                </li>
                                <li>
                                    <span class="label">교재명</span>
                                    <span class="value"><?= $course['textbook'] ?></span>
                                </li>
                                <li>
                                    <span class="label">수강료</span>
                                    <span class="value"><?= $course['price'] > 0 ? number_format($course['price']) . '원' : '무료' ?></span>
                                </li>
                                <li>
                                    <input type="hidden" name="ytLink" id="ytLink" value="<?= $course['course_url'] ?>">
                                    <span class="label">샘플강의</span>
                                    <div class="sample-btns">
                                        <?php if (!empty($videos)): ?>
                                            <?php foreach ($videos as $index => $video): ?>
                                                <?php if ($index === 0 && !empty($video['video_url'])): ?>
                                                    <button type="button" 
                                                            onclick="openVideo('normal', '<?= esc($video['video_url']) ?>')"
                                                            class="sample low">
                                                        수강보기
                                                    </button>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                        <?php endif; ?>
                                        <!-- <button class="sample low" onclick="openVideo('normal')">저화질</button>
                                        <button class="sample high" onclick="openVideo('hd')">고화질</button> -->
                                    </div>
                                </li>
                                <li class="sample">
                                    <span class="label">수강동영상</span>
                                    <div class="list_video">
                                        <?php if (!empty($videos)): ?>
                                            <?php foreach ($videos as $index => $video): ?>
                                                <p><span><?= $index + 1 ?>. </span><?= esc($video['title']) ?></p>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            </ul>

                            <div class="course-detail-actions" style="display: none">
                                <a href="/reservation/create?course_idx=<?= $course['idx'] ?>" class="btn">
                                    <img src="/img/ico/edit.png" alt="" class="icon_">
                                    바로신청하기</a>
                                <!--                                <a href="#" class="btn">-->
                                <!--                                    <img src="/img/ico/shopping-cart.png" alt="" class="icon_">-->
                                <!--                                    장바구니</a>-->
                            </div>

                        </div>
                    </div>

                    <div class="course-detail-tabs">
                        <div class="tabs_list">
                            <div class="tab_item active" data-content="introduction">강좌소개</div>
                            <div class="tab_item" data-content="description">교재소개</div>
                            <div class="tab_item" data-content="table_contents">학습목차</div>
                            <!--                            <div class="tab_item" data-content="reviews">수강후기</div>-->
                        </div>
                    </div>

                    <div class="course-detail-contents">
                        <div class="contents_list">
                            <div class="content_item show introduction">
                                <?= $course['course_introduction'] ?>
                            </div>
                            <div class="content_item description">
                                <?= $course['course_description'] ?>
                            </div>
                            <div class="content_item table_contents">
                                <?= $course['table_contents'] ?>
                            </div>
                            <div class="content_item reviews">

                            </div>
                        </div>
                    </div>
                </div>
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

        $(document).ready(function () {
            $('.tab_item').click(function () {
                let c = $(this).data('content');
                $('.tab_item').removeClass('active');
                $(this).addClass('active');
                $('.content_item').removeClass('show');
                $('.contents_list').find('.' + c).addClass('show');
            })
        })
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

        // function openVideo(type) {
        //     document.getElementById('overlay').style.display = 'block';
        //     document.getElementById('videoPopup').style.display = 'block';

        //     pendingQuality = (type === 'hd') ? 'hd720' : 'medium';

        //     const url = document.getElementById('ytLink').value;
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
                width: '100%',
                height: '100%',
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
            iframe.style.width = '100%';
            iframe.style.height = '100%';
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