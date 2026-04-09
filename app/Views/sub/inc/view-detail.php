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
                <span>작성일 : <span class="span_black"><?= date('Y-m-d', strtotime($row['r_date'])) ?></span></span>
                <span>조회수 : <span class="span_black"><?= number_format($row['hit']) ?></span></span>
            </div>
        </div>

        <div class="board-attach-row">
            <div class="attach-left">
                첨부파일 :
                <a target="_blank" href="/api/bbs/download?idx=<?= $row['bbs_idx'] ?>" class="attach-link">
                    <span class="span_black"><?= $row['rfile1'] ?></span>
                    <img src="/assets/img/sub/ico_download_detail.png" alt="download">
                </a>
            </div>
            <div class="attach-right">
                다운로드수 : <span class="span_black"><?= number_format($row['download']) ?></span>
            </div>
        </div>
        <div class="board-content">
            <?= htmlspecialchars_decode($row['contents']) ?>
        </div>

        <div class="board-nav">
            <div class="nav-item">
                <span class="nav-label next">다음글</span>
                <span class="nav-none toggle-content">
                    <?php if ($nextRow): ?>
                        <a href="<?= $detailUrl ?? '#!' ?>?idx=<?= $nextRow['bbs_idx'] ?>"><?= $nextRow['subject'] ?></a>
                    <?php else: ?>
                        <span class="no-post">다음글이 없습니다.</span>
                    <?php endif; ?>
                </span>
            </div>

            <div class="nav-item">
                <span class="nav-label prev">이전글</span>
                <span class="nav-none toggle-content">
                    <?php if ($prevRow): ?>
                        <a href="<?= $detailUrl ?? '#!' ?>?idx=<?= $prevRow['bbs_idx'] ?>"><?= $prevRow['subject'] ?></a>
                    <?php else: ?>
                        <span class="no-post">이전글이 없습니다.</span>
                    <?php endif; ?>
                </span>
            </div>
        </div>

        <div class="board-btn-wrap">
            <a href="<?= $listUrl ?? '#!' ?>" class="btn-list">목록으로</a>
        </div>

    </div>

    <!-- mobile -->
    <div class="detail-wrap mo-only">
        <div class="detail-header">
            <h1 class="detail-title">
                <?= $row['subject'] ?>
            </h1>
        </div>
        <div class="detail-meta">
            <span>작성자 : <span class="span_black">
                        <?= $row['writer'] ?>
                    </span></span>
            <span class="divider"></span>
            <span>작성일 : <span class="span_black">
                        <?= date('Y-m-d', strtotime($row['r_date'])) ?>
                    </span></span>
        </div>
        <div class="detail-meta">
            <span>첨부파일 :</span>
            <span class="divider"></span>
            <a target="_blank" href="/api/bbs/download?idx=<?= $row['bbs_idx'] ?>" class="attach-link">
                <span class="span_black"><?= $row['rfile1'] ?></span>
                <img src="/assets/img/sub/ico_download_detail.png" alt="download">
            </a>

        </div>
        <div class="detail-count">
            <span>조회수 : <strong class="span_black">
                        <?= number_format($row['hit']) ?>
                    </strong></span>
            <span class="divider"></span>
                    <span>다운로드수 : <strong class="span_black"><?= number_format($row['download']) ?></strong></span>
        </div>
        <div class="detail-content">
            <!-- <h2>계측기기 성능검사대행자 안내</h2> -->
            <div class="board-content">
                <?= htmlspecialchars_decode($row['contents']) ?>
            </div>
        </div>
        <div class="detail-nav">

            <div class="nav-item">
                <span class="nav-label next">다음글</span>
                <span class="nav-title">
                    <?php if ($nextRow): ?>
                        <a href="<?= $detailUrl ?? '#!' ?>?idx=<?= $nextRow['bbs_idx'] ?>"><?= $nextRow['subject'] ?></a>
                    <?php else: ?>
                        <span class="no-post">다음글이 없습니다.</span>
                    <?php endif; ?>
                </span>
            </div>

            <div class="nav-item">
                <span class="nav-label prev">이전글</span>
                <span class="nav-title">
                    <?php if ($prevRow): ?>
                        <a href="<?= $detailUrl ?? '#!' ?>?idx=<?= $prevRow['bbs_idx'] ?>"><?= $prevRow['subject'] ?></a>
                    <?php else: ?>
                        <span class="no-post">이전글이 없습니다.</span>
                    <?php endif; ?>
                </span>
            </div>

        </div>
        <div class="detail-footer">
            <a href="<?= $listUrl ?? '#!' ?>" class="btn-list">목록으로</a>
        </div>

    </div>
</section>