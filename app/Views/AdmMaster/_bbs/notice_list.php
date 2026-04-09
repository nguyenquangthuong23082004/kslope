<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <script>
        alert("<?= esc(session()->getFlashdata('success')) ?>");
    </script>
<?php endif ?>

<?php if (session()->getFlashdata('error')): ?>
    <script>
        alert("<?= esc(session()->getFlashdata('error')) ?>");
    </script>
<?php endif ?>

<!-- PAGE HEADING -->
<div class="page-heading mb-4 d-flex justify-content-between align-items-center">
    <h4 class="mb-0">공지사항 관리</h4>

    <a href="<?= site_url('AdmMaster/_bbs/notice/write') ?>"
        class="btn btn-success">
        <i class="bi bi-plus-square"></i> 등록
    </a>
</div>

<div class="card">
    <div class="card-body">

        <!-- FILTER -->
        <form method="get" class="mb-3 d-flex gap-2">
            <input type="text"
                name="keyword"
                value="<?= esc($keyword ?? '') ?>"
                class="form-control w-auto"
                placeholder="제목 검색">

            <button class="btn btn-primary">
                <i class="bi bi-search"></i>
            </button>
        </form>

        <!-- LIST -->
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width:80px" class="text-center">번호</th>
                    <th class="text-center">제목</th>
                    <th style="width:120px" class="text-center">작성자</th>
                    <th style="width:120px" class="text-center">작성일</th>
                    <th style="width:160px" class="text-center">관리</th>
                </tr>
            </thead>
            <tbody>

                <?php if (!empty($rows)): ?>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td class="text-center">
                                <?php if (($row['r_notice'] ?? 'N') === 'Y'): ?>
                                    <span class="badge bg-danger">공지</span>
                                <?php else: ?>
                                    <?= esc($row['r_idx']) ?>
                                <?php endif ?>
                            </td>

                            <td>
                                <strong><?= esc($row['r_title']) ?></strong>
                            </td>

                            <td class="text-center">
                                <?= esc($row['r_name'] ?? '관리자') ?>
                            </td>

                            <td class="text-center">
                                <?= esc(substr($row['r_regdate'], 0, 10)) ?>
                            </td>

                            <td class="text-center">
                                <a href="<?= site_url('AdmMaster/_bbs/notice/edit/' . $row['r_idx']) ?>"
                                    class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <a href="<?= site_url('AdmMaster/_bbs/notice/delete/' . $row['r_idx']) ?>"
                                    class="btn btn-sm btn-danger ms-1"
                                    onclick="return confirm('삭제하시겠습니까?\n삭제 후 복구할 수 없습니다.')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            등록된 공지사항이 없습니다.
                        </td>
                    </tr>
                <?php endif ?>

            </tbody>
        </table>

        <!-- PAGINATION -->
        <?php if ($pager): ?>
            <div class="mt-4">
                <?= $pager->links('notice', 'bootstrap5_full') ?>
            </div>
        <?php endif ?>

    </div>
</div>

<?= $this->endSection() ?>