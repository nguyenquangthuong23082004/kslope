<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
    <style>
        .resource-thumb {
            aspect-ratio: 4 / 3;
            overflow: hidden;
        }

        .resource-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
    </style>
    <main id="container" class="main main_new">
        <section class="ci-intro">

            <div class="ci-bc">
                <a href="#" class="ci-bc__item">HOME</a>
                <a href="#" class="ci-bc__item">알림마당</a>

                <a href="#" class="ci-bc__item ci-bc__item--select">
                    협회지
                    <img class="ci-bc__ico" src="/assets/img/sub/ico_select_down.png" alt="">
                </a>
            </div>

            <h1 class="ci-title">협회지</h1>

            <nav class="ci-tab">
                <a href="/notice">공지사항</a>
                <a href="/recruitment_infor">채용정보</a>
                <a href="/promotion">홍보자료</a>
                <a href="/competition">입찰/공모</a>
                <a href="/association_journal" class="is-active">협회지</a>
            </nav>

            <div class="ci-visual">
                <img src="/assets/img/sub/ci_visual_association.png" alt="">
                <div class="ci-visual-text">

                    <p class="text-en">Announcements</p>
                    <p class="text-en-small">Korea Slope Safety Association</p>
                </div>
            </div>

            <!-- <div class="ci-subtab pc-only1">
                <?php foreach ($categories as $key => $category): ?>
                    <a href="/association_journal?category_no=<?= $category['code_no'] ?>"
                       class="ci-subtab__item <?= $category['code_no'] == $category_no ? 'is-active' : '' ?>"><?= $category['code_name'] ?></a>
                <?php endforeach; ?>
            </div>

            <div class="custom-select mo-only">
                <div class="select-selected">
                    협회지
                </div>
                <ul class="select-options">
                    <?php foreach ($categories as $key => $category): ?>
                        <li data-value="/association_journal?category_no=<?= $category['code_no'] ?>"
                            class="<?= $category['code_no'] == $category_no ? 'is-active' : '' ?>">
                            <?= $category['code_name'] ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div> -->

        </section>


        <section class="job-list-wrap">
            <?php echo view("/sub/inc/top-search.php"); ?>

            <!-- table -->
            <!-- <div class="job-table-wrap">
                <table class="job-table">
                    <thead>
                    <tr>
                        <th class="col-no">번호</th>
                        <th class="col-title">제목</th>
                        <th class="col-date">작성일</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($items)): ?>
                        <tr>
                            <td colspan="3">검색된 결과가 없습니다.</td>
                        </tr>
                    <?php else: ?>
                        <?php
                        $startNum = $total - (($page_order - 1) * $perPage);
                        ?>
                        <?php foreach ($items as $key => $item): ?>
                            <tr class="pc-only2">
                                <td><?= $startNum - $key ?></td>
                                <td class="title">
                                    <div class="wrap_col2">
                                        <a target="_blank"
                                           href="<?= $item['ufile1'] ? '/uploads/bbs/' . $item['ufile1'] : '#' ?>"><?= $item['subject'] ?></a>

                                        <?php if (isset($item['ufile1']) && $item['ufile1'] != ''): ?>
                                            <a href="/uploads/bbs/<?= $item['ufile1'] ?>"
                                               download="<?= $item['rfile1'] ?>">
                                                <img src="/assets/img/sub/ico_pdf.png" alt="">
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td><?= date('Y.m.d', strtotime($item['r_date'])) ?></td>
                            </tr>

                            <tr class="job-item mo-only">
                                <td class="title">
                                    <a target="_blank"
                                       href="<?= $item['ufile1'] ? '/uploads/bbs/' . $item['ufile1'] : '#' ?>"><?= $item['subject'] ?></a>

                                    <div class="meta">
                                        <span>번호:</span>
                                        <?= $startNum - $key ?> |
                                        <span>파일:</span>
                                         <?php if (isset($item['ufile1']) && $item['ufile1'] != ''): ?>
                                        <a class="a-image" href="/uploads/bbs/<?= $item['ufile1'] ?>"
                                           download="<?= $item['rfile1'] ?>">
                                            <img src="/assets/img/sub/ico_pdf.png" alt="">
                                        </a>
                                    <?php endif; ?> |
                                        <span>작성일:</span>
                                        <?= date('Y.m.d', strtotime($item['r_date'])) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div> -->

            <div class="resource-grid">
                <?php if (empty($items)): ?>
                    <div style="grid-column: 1/-1; text-align:center; padding: 60px 0; color:#999;">
                        <p>데이터가 없습니다.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($items as $item): ?>
                        <article class="resource-item">
                            <a href="<?= !empty($item['link']) ? esc($item['link']) : '/member_resource_detail?idx=' . $item['bbs_idx'] ?>"
                            <?= !empty($item['link']) ? 'target="_blank" rel="noopener noreferrer"' : '' ?>
                            data-idx="<?= $item['bbs_idx'] ?>"
                            class="resource-link">
                                <div class="resource-thumb">
                                    <?php if (!empty($item['ufile3'])): ?>
                                        <img src="/uploads/bbs/<?= $item['ufile3'] ?>" alt="<?= $item['rfile3'] ?>">
                                    <?php else: ?>
                                        <img src="https://picsum.photos/seed/<?= $item['bbs_idx'] ?>/400/300" alt="<?= $item['subject'] ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="resource-body">
                                    <h3 class="resource-title">
                                        <?= esc($item['subject']) ?>
                                    </h3>
                                    <div class="resource-meta">
                                        <span class="resource-date"><?= date('Y.m.d', strtotime($item['r_date'])) ?></span>
                                        <span class="resource-view">
                                            <img src="/assets/img/sub/ico_view.png" alt="">
                                            <?= number_format($item['view_count']) ?>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </article>
                    <?php endforeach; ?>
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
    <script>
    document.querySelectorAll('.resource-link').forEach(function(el) {
        el.addEventListener('click', function() {
            const bbs_idx = this.dataset.idx;
            fetch('/increase_view/' + bbs_idx, { method: 'POST' });
        });
    });
    </script>
<?php $this->endSection(); ?>