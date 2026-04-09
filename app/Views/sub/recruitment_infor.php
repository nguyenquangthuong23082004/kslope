<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
    <main id="container" class="main main_new">
        <section class="ci-intro">

            <div class="ci-bc">
                <a href="#" class="ci-bc__item">HOME</a>
                <a href="#" class="ci-bc__item">알림마당</a>

                <a href="#" class="ci-bc__item ci-bc__item--select">
                    채용정보
                    <img class="ci-bc__ico" src="/assets/img/sub/ico_select_down.png" alt="">
                </a>
            </div>

            <h1 class="ci-title">채용정보</h1>

            <nav class="ci-tab">
                <a href="/notice">공지사항</a>
                <a href="/recruitment_infor" class="is-active">채용정보</a>
                <a href="/promotion">홍보자료</a>
                <a href="/competition">입찰/공모</a>
                <a href="/association_journal">협회지</a>
            </nav>

            <div class="ci-visual">
                <img src="/assets/img/sub/ci_visual_recruitment.png" alt="">
                <div class="ci-visual-text">

                    <p class="text-en">Announcements</p>
                    <p class="text-en-small">Korea Slope Safety Association</p>
                </div>
            </div>

        </section>


        <section class="job-list-wrap dif">
            <?php echo view("/sub/inc/top-search.php"); ?>

            <div class="job-grid">
                <?php if (empty($items)): ?>
                    <p>검색된 결과가 없습니다.</p>
                <?php else: ?>
                    <?php foreach ($items as $key => $item): ?>
                        <article class="job-card">
                            <div class="job-badges">
                                <span class="badge type <?= $item['category_no'] % 2 == 0 ? '' : 'sky' ?>"><?= getCodeBbs($item['category_no'], 'code_name') ?></span>
                                <?php if (getUrgentBbs($item['e_date'], 3)): ?>
                                    <span class="badge urgent">• 마감임박</span>
                                <?php endif; ?>
                            </div>

                            <div class="job-logo">
                                <a href="/recruitment_detail?idx=<?= $item['bbs_idx'] ?>">
                                    <img src="/uploads/bbs/<?= $item['ufile1'] ?>" alt="<?= $item['rfile1'] ?>">
                                </a>
                            </div>

                            <h3 class="job-company">
                                <a href="/recruitment_detail?idx=<?= $item['bbs_idx'] ?>">
                                    <?= $item['subject'] ?>
                                </a>
                            </h3>
                            <p class="job-desc">
                                <a href="/recruitment_detail?idx=<?= $item['bbs_idx'] ?>">
                                    <?= $item['contents2'] ?>
                                </a>
                            </p>

                            <div class="job-footer">
                                <div class="wrap_footer">
                                    <span class="job-meta"><?= $item['writer'] ?></span>
                                    <span class="job-meta-date"><?= date('Y.m.d', strtotime($item['r_date'])) ?></span>
                                </div>
                                <a href="/recruitment_detail?idx=<?= $item['bbs_idx'] ?>" class="job-btn">상세보기</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <?= $pager->links('order', 'custom_pagination') ?>

        </section>


    </main>
<?php $this->endSection(); ?>