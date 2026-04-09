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

    <div class="d-flex gap-2">
        <a href="<?= site_url('AdmMaster/notice/write') ?>"
            class="btn btn-success">
            <i class="bi bi-plus-square"></i> 등록
        </a>

        <button type="button"
            class="btn btn-danger"
            onclick="deleteSelected()">
            <i class="bi bi-trash"></i> 선택삭제
        </button>
    </div>

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

        <h5 class="mb-3">■ 총 <?= number_format($total) ?>개의 목록이 있습니다.</h5>

        <!-- LIST -->
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width:50px" class="text-center">
                        선택
                    </th>
                    <th style="width:80px" class="text-center">번호</th>
                    <th class="text-center">제목</th>
                    <th style="width:120px" class="text-center">작성자</th>
                    <th style="width:120px" class="text-center">작성일</th>
                    <th style="width:160px" class="text-center">관리</th>
                </tr>
            </thead>
            <!-- <tbody>

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
                                <a href="<?= site_url('AdmMaster/notice/edit/' . $row['r_idx']) ?>"
                                    class="btn btn-sm btn-primary"
                                    title="수정">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <button type="button"
                                    class="btn btn-sm btn-danger ms-1"
                                    title="삭제"
                                    onclick="deleteNotice(<?= (int)$row['r_idx'] ?>)">
                                    <i class="bi bi-trash"></i>
                                </button>
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

            </tbody> -->
            <tbody>
                <?php if (!empty($rows)): ?>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td class="text-center">
                                <input type="checkbox"
                                    class="row-check"
                                    value="<?= (int)$row['r_idx'] ?>">
                            </td>

                            <td class="text-center">
                                <?= esc($row['r_idx']) ?>
                            </td>

                            <td>
                                <a href="<?= site_url('AdmMaster/notice/edit/' . $row['r_idx']) ?>">
                                    <?= esc($row['r_title']) ?>
                                </a>
                            </td>

                            <td class="text-center"><?= esc($row['r_name'] ?? '관리자') ?></td>

                            <td class="text-center"><?= esc(substr($row['r_regdate'], 0, 10)) ?></td>

                            <td class="text-center">
                                <a href="<?= site_url('AdmMaster/notice/edit/' . $row['r_idx']) ?>"
                                    class="btn btn-sm btn-primary"
                                    title="수정">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <button type="button"
                                    class="btn btn-sm btn-danger ms-1"
                                    title="삭제"
                                    onclick="deleteNotice(<?= (int)$row['r_idx'] ?>)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">등록된 공지사항이 없습니다.</td>
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
<script>
    function deleteNotice(idx) {
        if (!confirm('삭제하시겠습니까?\n삭제 후 복구할 수 없습니다.')) {
            return;
        }

        fetch('<?= site_url('AdmMaster/notice/delete') ?>/' + idx, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('삭제되었습니다.');
                    location.reload();
                } else {
                    alert(data.message || '삭제 실패');
                }
            })
            .catch(() => alert('서버 오류'));
    }
</script>
<script>
    function deleteSelected() {

        const ids = Array.from(document.querySelectorAll('.row-check:checked'))
            .map(cb => cb.value);

        if (ids.length === 0) {
            alert('삭제할 항목을 선택하세요.');
            return;
        }

        if (!confirm('선택한 공지사항을 삭제하시겠습니까?\n삭제 후 복구할 수 없습니다.')) {
            return;
        }

        fetch('<?= site_url('AdmMaster/notice/delete-multi') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    ids
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('선택한 항목이 삭제되었습니다.');
                    location.reload();
                } else {
                    alert(data.message || '삭제 실패');
                }
            })
            .catch(() => alert('서버 오류'));
    }
</script>

<?= $this->endSection() ?>