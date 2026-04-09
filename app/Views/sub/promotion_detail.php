<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
    <style>
        .img-content {
            width: 100%;
            margin-top: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
    <main id="container" class="main main_new view_main">
        <section class="board-view">
            <section class="board-view">
                <div class="board-view-inner">

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

                    <!-- content -->
                    <div class="board-content">
                        <?= htmlspecialchars_decode($row['contents']) ?>
                    </div>

                    <div class="board-nav">
                        <div class="nav-item">
                            <span class="nav-label next">다음글</span>
                            <span class="nav-none toggle-content">
                                <?php if ($nextRow): ?>
                                    <a href="/promotion_detail?idx=<?= $nextRow['bbs_idx'] ?>"><?= $nextRow['subject'] ?></a>
                                <?php else: ?>
                                    <span class="no-post">다음글이 없습니다.</span>
                                <?php endif; ?>
                            </span>
                        </div>

                        <div class="nav-item">
                            <span class="nav-label prev">이전글</span>
                            <span class="nav-none toggle-content">
                                <?php if ($prevRow): ?>
                                    <a href="/promotion_detail?idx=<?= $prevRow['bbs_idx'] ?>"><?= $prevRow['subject'] ?></a>
                                <?php else: ?>
                                    <span class="no-post">이전글이 없습니다.</span>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>

                    <div class="board-btn-wrap">
                        <a href="/promotion" class="btn-list">목록으로</a>
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