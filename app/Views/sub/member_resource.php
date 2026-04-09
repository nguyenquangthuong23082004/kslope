<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
    <main id="container" class="main main_new">
        <section class="ci-intro dif">

            <div class="ci-bc">
                <a href="#" class="ci-bc__item">HOME</a>
                <a href="#" class="ci-bc__item">회원 안내</a>

                <a href="#" class="ci-bc__item ci-bc__item--select">
                    회원 자료실
                    <img class="ci-bc__ico" src="/assets/img/sub/ico_select_down.png" alt="">
                </a>
            </div>

            <h1 class="ci-title">회원 자료실</h1>

            <nav class="ci-tab">
                <a href="/sign_up_instructions">가입 안내</a>
                <a href="/member_resource" class="is-active">회원 자료실</a>
            </nav>

            <div class="ci-visual">
                <img src="/assets/img/sub/ci_visual_resource.png" alt="">
                <div class="ci-visual-text">
                    <p class="text_dif">회원 안내</p>
                    <p class="text-en">Member Resources</p>
                    <p class="text-en-small">Korea Slope Safety Association</p>
                </div>
            </div>

        </section>


        <section class="job-list-wrap-resource">
            <?php echo view("/sub/inc/top-search.php"); ?>

            <div class="resource-grid">
                <?php foreach ($items as $key => $item): ?>
                    <article class="resource-item">
                       <a href="/member_resource_detail?idx=<?= $item['bbs_idx'] ?>">
                            <div class="resource-thumb">
                                <img src="/uploads/bbs/<?= $item['ufile1'] ?>" alt="<?= $item['rfile1'] ?>">
                            </div>
                            <div class="resource-body">
                                <h3 class="resource-title">
                                    <?= $item['subject'] ?>
                                </h3>

                                <div class="resource-meta">
                                    <span class="resource-date"><?= date('Y.m.d', strtotime($item['r_date'])) ?></span>
                                    <span class="resource-view">
                                <img src="/assets/img/sub/ico_view.png" alt="">
                                <?= number_format($item['hit']) ?>
                            </span>
                                </div>
                            </div>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>

            <?= $pager->links('order', 'custom_pagination') ?>

        </section>


    </main>
    <script>
        $(function () {
            $(".ci-subtab__item").on("click", function (e) {
                e.preventDefault();

                $(".ci-subtab__item").removeClass("is-active");
                $(this).addClass("is-active");
            });
        });
    </script>
<?php $this->endSection(); ?>