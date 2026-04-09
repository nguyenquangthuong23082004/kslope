<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
    <main id="container" class="main main_new">
        <section class="ci-intro">

            <div class="ci-bc">
                <a href="#" class="ci-bc__item">HOME</a>
                <a href="#" class="ci-bc__item">알림마당</a>

                <a href="#" class="ci-bc__item ci-bc__item--select">
                    홍보자료
                    <img class="ci-bc__ico" src="/assets/img/sub/ico_select_down.png" alt="">
                </a>
            </div>

            <h1 class="ci-title">홍보자료</h1>

            <nav class="ci-tab">
                <a href="/notice">공지사항</a>
                <a href="/recruitment_infor">채용정보</a>
                <a href="/promotion" class="is-active">홍보자료</a>
                <a href="/competition">입찰/공모</a>
                <a href="/association_journal">협회지</a>
            </nav>

            <div class="ci-visual">
                <img src="/assets/img/sub/ci_visual_promotion.png" alt="">
                <div class="ci-visual-text">

                    <p class="text-en">Announcements</p>
                    <p class="text-en-small">Korea Slope Safety Association</p>
                </div>
            </div>
            <div class="ci-subtab pc-only1">
                <?php foreach ($categories as $key => $category): ?>
                    <a href="/promotion?category_no=<?= $category['code_no'] ?>"
                       class="ci-subtab__item <?= $category['code_no'] == $category_no ? 'is-active' : '' ?>"><?= $category['code_name'] ?></a>
                <?php endforeach; ?>
            </div>
    
            <div class="custom-select mo-only">
            <div class="select-selected">
                협회 공지
            </div>
            <ul class="select-options">
                <?php foreach ($categories as $key => $category): ?>
                    <li data-value="/promotion?category_no=<?= $category['code_no'] ?>"
                        class="<?= $category['code_no'] == $category_no ? 'is-active' : '' ?>">
                        <?= $category['code_name'] ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>


        </section>


        <section class="job-list-wrap dif">
            <?php echo view("/sub/inc/top-search.php"); ?>

            <div class="job-content">

                <?php if (empty($items)): ?>
                    <p class="" style="text-align: center; width: 100%;">검색된 결과가 없습니다.</p>
                <?php else: ?>
                    <ul class="job-card-pro-grid">
                        <?php foreach ($items as $key => $item): ?>
                            <li class="job-card-pro">
                                <a href="/promotion_detail?idx=<?= $item['bbs_idx'] ?>">
                                    <div class="job-thumb">
                                        <img src="/uploads/bbs/<?= $item['ufile1'] ?>" alt="<?= $item['rfile1'] ?>">
                                    </div>
                                    <p class="job-title"><?= $item['subject'] ?></p>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <?= $pager->links('order', 'custom_pagination') ?>
            

        </section>


    </main>
    <script>
    document.addEventListener("DOMContentLoaded", function () {

        const select = document.querySelector(".custom-select");
        const selected = select.querySelector(".select-selected");
        const options = select.querySelectorAll(".select-options li");

        const currentUrl = window.location.pathname + window.location.search;

        options.forEach(option => {
            if (option.dataset.value === currentUrl) {
                option.classList.add("active");
                selected.textContent = option.textContent;
            }
        });

        selected.addEventListener("click", function () {
            select.classList.toggle("active");
        });

        options.forEach(option => {
            option.addEventListener("click", function () {

                selected.textContent = this.textContent;

                window.location.href = this.dataset.value;
            });
        });

        document.addEventListener("click", function (e) {
            if (!select.contains(e.target)) {
                select.classList.remove("active");
            }
        });

    });
</script>
<?php $this->endSection(); ?>