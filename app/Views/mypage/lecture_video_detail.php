<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
<main id="container" class="main main_new">
    <section class="mypage-wrap">
        <div class="mypage-inner">

            <?= view('mypage/mypage_sidebar', ['active' => 'lecture']) ?>

            <div class="mypage-content">
                <h3 class="content-title diff">수강영상</h3>
                <div class="course-detail-inner">

                    <!-- back -->
                    <a href="javascript:history.back();" class="course-back">
                        <img src="/img/ico/left-arrows.png" alt="뒤로가기" class="ico-back-img">
                        목록보기
                    </a>

                    <div class="course-path detail">
                        교육수강 &gt; 기초학품 
                    </div>
                    
                    <div class="course-detail-wrap">
                        <div class="course-detail-thumb detail">
                            <a href="javascript:void(0)"
                                class="course-thumb-diff detail"
                                data-video-url="<?= $video['video_url'] ?>"
                                data-video-idx="<?= $video['video_idx'] ?>"
                                data-course-idx="<?= $video['course_idx_m'] ?>">
                                <img
                                    class="vimeo-thumb detail"
                                    src="/uploads/video/<?= $video['ufile'] ?>"
                                    alt="<?= $video['rfile'] ?>">
                                <span class="video-play-btn detail"></span>
                                
                                <!-- Progress Badge -->
                                <?php if (isset($video['is_completed']) && $video['is_completed']): ?>
                                    <span class="video-completed-badge">완료</span>
                                <?php elseif (isset($video['progress_percent']) && $video['progress_percent'] > 0): ?>
                                    <span class="video-progress-badge"><?= number_format($video['progress_percent'], 0) ?>%</span>
                                <?php endif; ?>
                            </a>
                        </div>

                        <div class="course-detail-info detail">
                            <h2 class="course-detail-title detail">
                                <?= esc($video['title']) ?>
                            </h2>

                            <ul class="course-detail-meta detail">
                                <li class="only_start">
                                    <span class="label">간략설명</span>
                                    <div class="value-wrap">
                                        <span class="value dif"><?= nl2br(esc($video['short_description'])) ?></span>
                                        <button type="button" class="toggle-arrow"></button>
                                    </div>
                                </li>
                                <li>
                                    <span class="label">강의시간</span>
                                    <span class="value"><?= $video['duration'] ?></span>
                                </li>
                                <li>
                                    <span class="label">진도률</span>
                                    <span class="value">
                                        <div class="eduCourse-progressWrap">
                                            <div class="eduCourse-progress">
                                                <span style="width:<?= $video['progress_percent'] ?? 0 ?>%"></span>
                                            </div>
                                            <p class="eduCourse-percent"><?= number_format($video['progress_percent'] ?? 0, 0) ?>%</p>
                                        </div>
                                    </span>
                                </li>
                                <li class="sample">
                                    <span class="label">강의보기</span>
                                    <span class="value">
                                        <div class="sample-btns">
                                            <button class="sample low btn-open-video"
                                                    data-video-url="<?= $video['video_url'] ?>"
                                                    data-video-idx="<?= $video['video_idx'] ?>"
                                                    data-course-idx="<?= $video['course_idx_m'] ?>">
                                                <?php if (isset($video['is_completed']) && $video['is_completed']): ?>
                                                    다시보기
                                                <?php elseif (isset($video['progress_percent']) && $video['progress_percent'] > 0): ?>
                                                    이어서 보기
                                                <?php else: ?>
                                                    보기
                                                <?php endif; ?>
                                            </button>
                                        </div>
                                    </span>
                                </li>
                                
                                <?php if (isset($video['last_watch_date']) && $video['last_watch_date']): ?>
                                <li>
                                    <span class="label">마지막 시청</span>
                                    <span class="value"><?= date('Y-m-d H:i', strtotime($video['last_watch_date'])) ?></span>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Video Modal -->
    <div class="vimeo-modal" id="vimeoModal">
        <div class="vimeo-overlay"></div>
        <div class="vimeo-content">
            <button class="vimeo-close">&times;</button>
            <div class="vimeo-iframe-wrap">
                <iframe
                    id="vimeoIframe"
                    src=""
                    frameborder="0"
                    allow="autoplay; fullscreen"
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>
</main>

<script src="https://player.vimeo.com/api/player.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('vimeoModal');
        const iframe = document.getElementById('vimeoIframe');
        let progressTracker = null;

        // Copy toàn bộ class VideoProgressTracker từ lecture_video.php
        class VideoProgressTracker {
            constructor(videoIdx, courseIdx, videoType, embedUrl, iframeElement) {
                this.videoIdx = videoIdx;
                this.courseIdx = courseIdx;
                this.videoType = videoType;
                this.embedUrl = embedUrl;
                this.player = null;
                this.isCompleted = false;
                this.iframe = iframeElement;
                this.isRestoring = false;
                
                this.config = {
                    MIN_PROGRESS_CHANGE: 3,
                    SYNC_INTERVAL: 180000,
                    LOCAL_SAVE_INTERVAL: 60000,
                    COMPLETION_THRESHOLD: 0.85,
                    MIN_WATCH_TIME: 10,
                    MAX_SKIP_SECONDS: 30
                };
                
                this.lastSyncedProgress = 0;
                this.lastSyncedPosition = 0;
                this.totalWatchTime = 0;
                this.startTime = null;
                this.isPlaying = false;
                this.localSaveTimer = null;
                this.syncTimer = null;
                this.initialPosition = 0;
                this.lastKnownPosition = 0;
                
                this.init();
            }
            
            async init() {
                await this.loadInitialProgress();
                
                if (this.videoType === 'youtube') {
                    this.initYouTubePlayer();
                } else if (this.videoType === 'vimeo') {
                    this.initVimeoPlayer();
                }
            }
            
            async loadInitialProgress() {
                try {
                    const response = await fetch(`/mypage/getVideoProgress?video_idx=${this.videoIdx}`);
                    const result = await response.json();
                    
                    if (result.status === 'success' && result.data) {
                        this.lastSyncedProgress = result.data.progress_percent || 0;
                        this.lastSyncedPosition = result.data.last_position || 0;
                        this.initialPosition = result.data.last_position || 0;
                        this.totalWatchTime = Number(result.data.total_watch_time) || 0;
                        this.lastKnownPosition = result.data.last_position || 0;
                        
                        if (result.data.is_completed == 1 && result.data.progress_percent >= 100) {
                            this.isCompleted = true;
                        } else {
                            this.isCompleted = false;
                        }
                    } else {
                        this.isCompleted = false;
                    }
                } catch (error) {
                    this.isCompleted = false;
                }
            }
            
            initYouTubePlayer() {
                if (this.isCompleted) return;
                this.startTracking();
            }
            
            initVimeoPlayer() {
                if (typeof Vimeo !== 'undefined') {
                    this.player = new Vimeo.Player(this.iframe);
                    this.setupVimeoEvents();
                }
                
                if (!this.isCompleted) {
                    this.startTracking();
                }
            }
            
            setupVimeoEvents() {
                this.player.on('loaded', () => {
                    if (this.isCompleted) {
                        this.isPlaying = false;
                        return;
                    }
                });
                
                this.player.on('play', () => {
                    if (this.isCompleted) return;
                    
                    if (!this.isPlaying) {
                        this.isPlaying = true;
                        this.startTime = Date.now();
                    }
                });
                
                this.player.on('pause', () => {
                    if (this.isCompleted) return;
                    
                    if (this.isPlaying) {
                        this.updateWatchTime();
                        this.isPlaying = false;
                        this.smartSync();
                    }
                });
                
                this.player.on('ended', () => {
                    if (this.isCompleted) return;
                    
                    if (this.isPlaying) {
                        this.updateWatchTime();
                        this.isPlaying = false;
                    }
                    this.forceSyncComplete();
                });
                
                let lastSyncProgress = 0;
                let lastCheckedPosition = 0;
                let allowSkipUntil = 0;
                
                this.player.on('timeupdate', async (data) => {
                    if (this.isCompleted) return;
                    
                    const currentTime = Math.floor(data.seconds);
                    const now = Date.now();
                    const timeDiff = currentTime - lastCheckedPosition;
                    
                    if (now > allowSkipUntil && Math.abs(timeDiff) > 2) {
                        const skipAmount = currentTime - this.lastKnownPosition;
                        
                        if (skipAmount > this.config.MAX_SKIP_SECONDS) {
                            await this.player.setCurrentTime(this.lastKnownPosition);
                            alert(`최대 ${this.config.MAX_SKIP_SECONDS}초까지만 건너뛸 수 있습니다.\n현재 위치로 돌아갑니다.`);
                            lastCheckedPosition = this.lastKnownPosition;
                            return;
                        }
                        
                        if (skipAmount < 0) {
                            this.lastKnownPosition = currentTime;
                        }
                    }
                    
                    lastCheckedPosition = currentTime;
                    
                    if (!this.isPlaying && currentTime > 0) {
                        this.isPlaying = true;
                        this.startTime = Date.now();
                    }
                    
                    if (Math.abs(timeDiff) <= 2 || timeDiff < 0 || now <= allowSkipUntil) {
                        this.lastKnownPosition = currentTime;
                    }
                    
                    const duration = await this.getDuration();
                    if (duration === 0) return;
                    
                    const currentProgress = (currentTime / duration) * 100;
                    
                    if (currentProgress - lastSyncProgress >= 3 && currentTime > 10) {
                        lastSyncProgress = Math.floor(currentProgress / 3) * 3;
                        this.updateWatchTime();
                        this.syncToServer(currentTime, duration, currentProgress);
                    }
                });
                
                if (this.initialPosition > 5 && !this.isCompleted) {
                    this.isRestoring = true;
                    setTimeout(async () => {
                        const duration = await this.getDuration();
                        const progressPercent = (this.initialPosition / duration) * 100;
                        
                        if (progressPercent > 3 && progressPercent < 95) {
                            const minutes = Math.floor(this.initialPosition / 60);
                            const seconds = Math.floor(this.initialPosition % 60);
                            
                            const message = minutes > 0 
                                ? `마지막으로 ${minutes}분 ${seconds}초까지 시청하셨습니다. 이어서 보시겠습니까?`
                                : `마지막으로 ${seconds}초까지 시청하셨습니다. 이어서 보시겠습니까?`;
                            
                            if (confirm(message)) {
                                allowSkipUntil = Date.now() + 3000;
                                
                                await this.player.setCurrentTime(this.initialPosition);
                                this.lastKnownPosition = this.initialPosition;
                                lastCheckedPosition = this.initialPosition;
                            }
                        }

                        this.isRestoring = false;
                    }, 1500);
                }
            }
            
            startTracking() {
                if (this.isCompleted) return;
                
                this.localSaveTimer = setInterval(() => {
                    if (!this.isCompleted) {
                        this.saveToLocal();
                    }
                }, this.config.LOCAL_SAVE_INTERVAL);
                
                this.syncTimer = setInterval(() => {
                    if (this.isPlaying && !this.isCompleted) {
                        this.smartSync();
                    }
                }, this.config.SYNC_INTERVAL);
                
                window.addEventListener('beforeunload', () => {
                    if (!this.isCompleted) {
                        this.forceSync();
                    }
                });
                
                document.addEventListener('visibilitychange', () => {
                    if (document.hidden && this.isPlaying && !this.isCompleted) {
                        this.updateWatchTime();
                        this.isPlaying = false;
                        this.smartSync();
                    }
                });
            }
            
            updateWatchTime() {
                if (this.startTime && !this.isRestoring) {
                    const now = Date.now();
                    const watchedSeconds = Math.floor((now - this.startTime) / 1000);
                    
                    if (watchedSeconds > 0) {
                        this.totalWatchTime += watchedSeconds;
                        this.startTime = now;
                    }
                }
            }
            
            saveToLocal() {
                const data = {
                    videoIdx: this.videoIdx,
                    courseIdx: this.courseIdx,
                    totalWatchTime: this.totalWatchTime,
                    timestamp: Date.now()
                };
                
                localStorage.setItem(`video_progress_${this.videoIdx}`, JSON.stringify(data));
            }
            
            async getCurrentTime() {
                if (this.videoType === 'vimeo' && this.player) {
                    try {
                        return await this.player.getCurrentTime();
                    } catch (error) {
                        return 0;
                    }
                }
                return 0;
            }
            
            async getDuration() {
                if (this.videoType === 'vimeo' && this.player) {
                    try {
                        return await this.player.getDuration();
                    } catch (error) {
                        return 0;
                    }
                }
                return 0;
            }
            
            async smartSync() {
                this.updateWatchTime();
                
                if (this.totalWatchTime < this.config.MIN_WATCH_TIME) {
                    return;
                }
                
                const currentPosition = await this.getCurrentTime();
                const duration = await this.getDuration();
                const currentProgress = duration > 0 ? (currentPosition / duration) * 100 : 0;
                
                const progressChange = Math.abs(currentProgress - this.lastSyncedProgress);
                
                if (progressChange >= this.config.MIN_PROGRESS_CHANGE) {
                    this.syncToServer(currentPosition, duration, currentProgress);
                }
            }
            
            async forceSyncComplete() {
                this.updateWatchTime();
                const duration = await this.getDuration();
                this.syncToServer(duration, duration, 100, true);
            }
            
            async forceSync() {
                this.updateWatchTime();
                
                if (this.totalWatchTime < this.config.MIN_WATCH_TIME) {
                    return;
                }
                
                const currentPosition = await this.getCurrentTime();
                const duration = await this.getDuration();
                const currentProgress = duration > 0 ? (currentPosition / duration) * 100 : 0;
                
                this.syncToServer(currentPosition, duration, currentProgress);
            }
            
            syncToServer(position, duration, progress, isCompleted = false) {
                if (this.isCompleted && !isCompleted) {
                    return;
                }
                
                const data = {
                    video_idx: this.videoIdx,
                    course_idx: this.courseIdx,
                    watch_duration: Math.floor(position),
                    total_duration: Math.floor(duration),
                    last_position: Math.floor(position),
                    total_watch_time: this.totalWatchTime,
                    is_completed: isCompleted || (progress >= 85) ? 1 : 0
                };
                
                fetch('/mypage/updateVideoProgress', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                    keepalive: true
                })
                .then(response => response.json())
                .then(result => {
                    if (result.status === 'success') {
                        this.lastSyncedProgress = progress;
                        this.lastSyncedPosition = position;
                        
                        if (progress >= 100 && data.is_completed == 1) {
                            this.isCompleted = true;
                            
                            if (this.localSaveTimer) {
                                clearInterval(this.localSaveTimer);
                                this.localSaveTimer = null;
                            }
                            if (this.syncTimer) {
                                clearInterval(this.syncTimer);
                                this.syncTimer = null;
                            }
                        }
                        
                        this.updateProgressUI(progress, data.is_completed === 1);
                    }
                })
                .catch(error => {
                    console.error('❌ Lỗi sync:', error);
                });
            }
            
            updateProgressUI(progress, isCompleted) {
                const progressBar = document.querySelector('.eduCourse-progress span');
                const progressPercent = document.querySelector('.eduCourse-percent');
                const badge = document.querySelector('.video-progress-badge, .video-completed-badge');
                
                if (progressBar) progressBar.style.width = `${progress}%`;
                if (progressPercent) progressPercent.textContent = `${Math.round(progress)}%`;
                
                if (isCompleted && badge) {
                    badge.className = 'video-completed-badge';
                    badge.textContent = '완료';
                } else if (progress > 0 && badge) {
                    badge.className = 'video-progress-badge';
                    badge.textContent = `${Math.round(progress)}%`;
                }
            }
            
            destroy() {
                if (this.localSaveTimer) clearInterval(this.localSaveTimer);
                if (this.syncTimer) clearInterval(this.syncTimer);
                
                this.saveToLocal();
                
                if (!this.isCompleted) {
                    this.forceSync();
                }
                
                if (this.player) this.player = null;
            }
        }

        // Helper functions
        function getEmbedUrl(url) {
            const youtubeId = getYoutubeId(url);
            if (youtubeId) {
                return `https://www.youtube.com/embed/${youtubeId}?autoplay=1&mute=0&rel=0`;
            }

            const vimeoId = getVimeoId(url);
            if (vimeoId) {
                return `https://player.vimeo.com/video/${vimeoId}?autoplay=1&muted=0`;
            }

            return null;
        }

        function getYoutubeId(url) {
            const patterns = [
                /(?:youtube\.com\/watch\?v=)([a-zA-Z0-9_-]{11})/,
                /(?:youtu\.be\/)([a-zA-Z0-9_-]{11})/,
                /(?:youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/
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
                /player\.vimeo\.com\/video\/(\d+)/
            ];

            for (const pattern of patterns) {
                const match = url.match(pattern);
                if (match) return match[1];
            }
            return null;
        }

        function getVideoType(url) {
            if (getYoutubeId(url)) return 'youtube';
            if (getVimeoId(url)) return 'vimeo';
            return 'unknown';
        }

        function openVideoByUrl(videoUrl, videoIdx, courseIdx) {
            if (!videoUrl) {
                alert('잘못된 동영상 URL입니다');
                return;
            }

            const embedUrl = getEmbedUrl(videoUrl);
            if (!embedUrl) {
                alert('잘못된 동영상 URL입니다');
                return;
            }

            const videoType = getVideoType(videoUrl);

            modal.classList.add('active');
            document.body.style.overflow = 'hidden';

            const wrap = document.querySelector('.vimeo-iframe-wrap');

            const newIframe = document.createElement('iframe');
            newIframe.src = embedUrl;
            newIframe.frameBorder = "0";
            newIframe.allow = "autoplay; fullscreen";
            newIframe.allowFullscreen = true;

            wrap.innerHTML = '';
            wrap.appendChild(newIframe);

            newIframe.onload = function() {
                progressTracker = new VideoProgressTracker(
                    videoIdx,
                    courseIdx,
                    videoType,
                    embedUrl,
                    newIframe
                );
            };
        }

        async function closeModal() {
            modal.classList.remove('active');
            document.body.style.overflow = '';
            
            if (progressTracker) {
                await progressTracker.destroy();
                progressTracker = null;
            }

            const wrap = document.querySelector('.vimeo-iframe-wrap');
            wrap.innerHTML = '';

            currentVideoIdx = null;
            currentCourseIdx = null;
        }

        document.querySelectorAll('.course-thumb-diff').forEach(wrapper => {
            wrapper.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                openVideoByUrl(
                    this.dataset.videoUrl,
                    this.dataset.videoIdx,
                    this.dataset.courseIdx
                );
            });
        });

        document.querySelectorAll('.btn-open-video').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                openVideoByUrl(
                    this.dataset.videoUrl,
                    this.dataset.videoIdx,
                    this.dataset.courseIdx
                );
            });
        });

        const closeBtn = modal.querySelector('.vimeo-close');
        const overlay = modal.querySelector('.vimeo-overlay');

        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (overlay) overlay.addEventListener('click', closeModal);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                closeModal();
            }
        });
        
        // Toggle arrow
        document.querySelectorAll('.toggle-arrow').forEach(btn => {
            btn.addEventListener('click', function() {
                const wrap = this.closest('.value-wrap');
                wrap.classList.toggle('active');
            });
        });
    });
</script>

<?php $this->endSection(); ?>