<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
<main id="container" class="main main_new view_main">
    <section class="board-view">
        <section class="board-view">
            <div class="board-view-inner pc-detail">

                <div class="board-view-head">
                    <h2 class="board-title">
                        <?= $row['subject'] ?>
                    </h2>
                </div>

                <div class="board-meta-row">
                    <div class="meta-left">
                        작성자 : <span class="span_black"> <?= $row['writer'] ?></span>
                    </div>
                    <div class="meta-right">
                        <span>작성일 : <span
                                class="span_black"><?= date('Y-m-d', strtotime($row['r_date'])) ?></span></span>
                        <span>조회수 : <span class="span_black"><?= number_format($row['hit']) ?></span></span>
                    </div>
                </div>

                <div class="img-content">
                    <img src="/uploads/bbs/<?= $row['ufile1'] ?>" alt="<?= $row['rfile1'] ?>">
                </div>
                <div class="board-content">
                    <?= htmlspecialchars_decode($row['contents']) ?>
                </div>

                <div class="board-nav">
                    <div class="nav-item">
                        <span class="nav-label next">다음글</span>
                        <span class="nav-none toggle-content">
                            <?php if ($nextRow): ?>
                                <a
                                    href="/member_resource_detail?idx=<?= $nextRow['bbs_idx'] ?>"><?= $nextRow['subject'] ?></a>
                            <?php else: ?>
                                <span class="no-post">다음글이 없습니다.</span>
                            <?php endif; ?>
                        </span>
                    </div>

                    <div class="nav-item">
                        <span class="nav-label prev">이전글</span>
                        <span class="nav-none toggle-content">
                            <?php if ($prevRow): ?>
                                <a
                                    href="/member_resource_detail?idx=<?= $prevRow['bbs_idx'] ?>"><?= $prevRow['subject'] ?></a>
                            <?php else: ?>
                                <span class="no-post">이전글이 없습니다.</span>
                            <?php endif; ?>
                        </span>
                    </div>
                </div>

                <div class="board-btn-wrap">
                    <a href="/member_resource" class="btn-list">목록으로</a>
                </div>

            </div>


            <div class="detail-wrap mo-only">
                <div class="detail-header">
                    <h1 class="detail-title">
                        <?= $row['subject'] ?>
                    </h1>
                </div>
                <div class="detail-meta">
                    <span>작성자 : <span class="span_black"> <?= $row['writer'] ?></span></span>
                    <span class="divider"></span>
                    <span>작성일 : <span class="span_black"><?= date('Y-m-d', strtotime($row['r_date'])) ?> </span></span>
                </div>
                <!-- <div class="detail-attach">
                    <p class="attach-title">첨부파일</p>

                    <a href="#" class="attach-item">
                        계측기기 성능검사 기준에 관한 규정.zip
                        <span class="download">⬇</span>
                    </a>

                    <a href="#" class="attach-item">
                        sdfdsfdsfsf.jpg
                        <span class="download">⬇</span>
                    </a>
                </div> -->
                <div class="detail-count">
                    <span>조회수 : <span class="span_black"><?= number_format($row['hit']) ?></span></span>
                    <!-- <span class="divider"></span>
                    <span>다운로드수 : <strong>333</strong></span> -->
                </div>
                <div class="detail-content">
                    <!-- <h2>계측기기 성능검사대행자 안내</h2> -->

                    <div class="img-content">
                        <img src="/uploads/bbs/<?= $row['ufile1'] ?>" alt="<?= $row['rfile1'] ?>">
                    </div>
                    <div class="board-content">
                        <?= htmlspecialchars_decode($row['contents']) ?>
                    </div>
                </div>
                <div class="detail-nav">

                    <div class="nav-item">
                        <span class="nav-label next">다음글</span>
                        <span class="nav-title">
                            <?php if ($nextRow): ?>
                                <a href="/member_resource_detail?idx=<?= $nextRow['bbs_idx'] ?>">
                                    <?= $nextRow['subject'] ?>
                                </a>
                            <?php else: ?>
                                다음글이 없습니다.
                            <?php endif; ?>
                        </span>
                    </div>

                    <div class="nav-item">
                        <span class="nav-label prev">이전글</span>
                        <span class="nav-title">
                            <?php if ($prevRow): ?>
                                <a href="/member_resource_detail?idx=<?= $prevRow['bbs_idx'] ?>">
                                    <?= $prevRow['subject'] ?>
                                </a>
                            <?php else: ?>
                                이전글이 없습니다.
                            <?php endif; ?>
                        </span>
                    </div>

                </div>
                <div class="detail-footer">
                    <a href="/member_resource" class="btn-list">목록으로</a>
                </div>

            </div>

        </section>
    </section>
</main>
<script>
    document.querySelectorAll('.board-nav .nav-item').forEach(item => {
        const label = item.querySelector('.nav-label');

        label.addEventListener('click', () => {
            item.classList.toggle('is-open');
        });
    });
</script>
<?php $this->endSection(); ?>