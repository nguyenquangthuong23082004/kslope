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
    <style>
        .form-check {
            display: flex;
        }
    </style>
    <div class="page-heading mb-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-0">포트폴리오 관리</h4>

        <div class="d-flex gap-2 align-items-center">
            <a href="javascript:checkAll(true)" class="btn btn-outline-success">
                <i class="bi bi-check-square"></i> 전체선택
            </a>
            <a href="javascript:checkAll(false)" class="btn btn-outline-secondary">
                <i class="bi bi-square"></i> 선택해체
            </a>
            <a href="javascript:bulkDelete()" class="btn btn-danger">
                <i class="bi bi-trash"></i> 선택삭제
            </a>
            <a href="javascript:changeOrder()" class="btn btn-warning">
                <i class="bi bi-arrow-up-down"></i> 순위변경
            </a>
            <a href="<?= site_url('AdmMaster/portfolio/create') ?>" class="btn btn-success">
                <i class="bi bi-plus-square"></i> 등록
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <!-- FILTER & SEARCH -->
            <form method="get" class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex gap-2 align-items-center flex-wrap">

                        <select name="main_exposure"
                                class="form-select"
                                style="width: 120px; height: 40px"
                                onchange="this.form.submit()">
                            <option value="">메인노출</option>
                            <option value="Y" <?= $main_exposure === 'Y' ? 'selected' : '' ?>>노출</option>
                            <option value="N" <?= $main_exposure === 'N' ? 'selected' : '' ?>>미노출</option>
                        </select>
                        <select name="r_used"
                                class="form-select"
                                style="width: 120px; height: 40px"
                                onchange="this.form.submit()">
                            <option value="">전체 노출</option>
                            <option value="Y" <?= $r_used === 'Y' ? 'selected' : '' ?>>노출</option>
                            <option value="N" <?= $r_used === 'N' ? 'selected' : '' ?>>미노출</option>
                        </select>

                        <input type="text"
                               name="search_title"
                               class="form-control"
                               placeholder="제목 검색"
                               value="<?= esc($search_title ?? '') ?>"
                               style="width: 250px; height: 40px">

                        <button type="submit" class="btn btn-primary" style="height: 40px">
                            <i class="bi bi-search"></i> 검색
                        </button>
                    </div>
                    <div class="d-flex gap-3">
                        <?php if (!empty($typeList)): ?>
                            <?php foreach ($typeList as $type): ?>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="r_type[]"
                                           id="type_<?= esc($type['code_no']) ?>"
                                           value="<?= esc($type['code_no']) ?>"
                                        <?= in_array($type['code_no'], $r_type ?? []) ? 'checked' : '' ?>
                                           onchange="this.form.submit()">
                                    <label class="form-check-label" for="type_<?= esc($type['code_no']) ?>">
                                        <?= esc($type['code_name']) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </form>

            <h5 class="mb-3">■ 총 <?= number_format($total) ?>개의 목록이 있습니다.</h5>
            <!-- LIST -->
            <form name="frmOrder" id="frmOrder">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                    <tr>
                        <th style="width:50px" class="text-center">
                            <input type="checkbox" id="checkAllBox" onclick="checkAll(this.checked)">
                        </th>
                        <th style="width:70px" class="text-center">노출</th>
                        <th style="width:150px" class="text-center">썸네일</th>
                        <th style="width:120px" class="text-center">타입</th>
                        <th class="text-center">제목</th>
                        <th style="width:120px" class="text-center">출력</th>
                        <th style="width:70px" class="text-center">메인노출</th>
                        <th style="width:80px" class="text-center">URL</th>
                        <th style="width:90px" class="text-center">정렬</th>
                        <th style="width:180px" class="text-center">관리</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($list)): ?>
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">
                                검색 결과가 없습니다.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($list as $row): ?>
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox"
                                           name="selected_idx[]"
                                           class="chk-item"
                                           value="<?= esc($row['r_idx']) ?>">
                                </td>

                                <td class="text-center">
                                    <input type="checkbox"
                                        <?= $row['r_used'] === 'Y' ? 'checked' : '' ?>
                                           onchange="toggleUse('<?= $row['r_idx'] ?>', 'r_used')">
                                </td>

                                <td class="text-center">
                                    <?php if (!empty($row['r_file'])): ?>
                                        <img src="/uploads/file/<?= esc($row['r_file']) ?>"
                                             style="width:120px;height:90px;object-fit:cover;border-radius:4px">
                                    <?php else: ?>
                                        <span class="text-muted small">NO IMAGE</span>
                                    <?php endif ?>
                                </td>

                                <td class="text-center">
                                    <span><?= esc($typeMap[$row['r_type']] ?? $row['r_type']) ?></span>
                                </td>

                                <td>
                                    <a href="/AdmMaster/portfolio/edit/<?= $row['r_idx'] ?>"><?= esc($row['r_title']) ?></a>
                                </td>

                                <td class="text-center">
                                    <?= esc($row['r_output'] ?? '-') ?>
                                </td>

                                <td class="text-center">
                                    <input type="checkbox"
                                        <?= $row['main_exposure'] === 'Y' ? 'checked' : '' ?>
                                           onchange="toggleUse('<?= $row['r_idx'] ?>', 'main_exposure')">
                                </td>

                                <td class="text-center">
                                    <?php if (!empty($row['r_url'])): ?>
                                        <a href="<?= esc($row['r_url']) ?>" target="_blank"
                                           class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-box-arrow-up-right"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif ?>
                                </td>

                                <td class="text-center">
                                    <input type="hidden" name="order_idx[]" value="<?= esc($row['r_idx']) ?>">
                                    <input type="number"
                                           name="order_value[]"
                                           value="<?= esc($row['r_order']) ?>"
                                           style="width: 70px"
                                           class="form-control form-control-sm text-center">
                                </td>

                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= site_url('AdmMaster/portfolio/edit/' . $row['r_idx']) ?>"
                                           class="btn btn-primary"
                                           title="수정">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button"
                                                class="btn btn-danger ms-1"
                                                onclick="deleteItem(<?= $row['r_idx'] ?>)"
                                                title="삭제">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </form>

            <?php if ($pager): ?>
                <div class="mt-4">
                    <?= $pager->links('portfolio', 'bootstrap5_full') ?>
                </div>
            <?php endif ?>

        </div>
    </div>

    <script>
        // 전체 선택/해제
        function checkAll(checked) {
            const checkboxes = document.querySelectorAll('.chk-item');
            checkboxes.forEach(checkbox => {
                checkbox.checked = checked;
            });

            // 헤더 체크박스도 업데이트
            const checkAllBox = document.getElementById('checkAllBox');
            if (checkAllBox) {
                checkAllBox.checked = checked;
            }
        }

        // 선택 삭제
        function bulkDelete() {
            const checkedBoxes = document.querySelectorAll('.chk-item:checked');

            if (checkedBoxes.length === 0) {
                alert('삭제할 항목을 선택해주세요.');
                return;
            }

            if (!confirm(`선택한 ${checkedBoxes.length}개 항목을 삭제하시겠습니까?\n삭제 후 복구할 수 없습니다.`)) {
                return;
            }

            const selectedIds = Array.from(checkedBoxes).map(cb => cb.value);

            fetch('<?= site_url('AdmMaster/portfolio/bulkDelete') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    ids: selectedIds
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message || '삭제되었습니다.');
                        location.reload();
                    } else {
                        alert(data.message || '삭제 실패');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('오류가 발생했습니다.');
                });
        }

        // 순위 변경
        function changeOrder() {
            if (!confirm('순위를 변경하시겠습니까?')) {
                return false;
            }

            const formData = new FormData(document.getElementById('frmOrder'));

            // order_idx[]와 order_value[]를 r_idx[]와 r_order[]로 변환
            const data = new FormData();
            const orderIds = formData.getAll('order_idx[]');
            const orderValues = formData.getAll('order_value[]');

            orderIds.forEach(id => data.append('r_idx[]', id));
            orderValues.forEach(value => data.append('r_order[]', value));

            fetch('<?= site_url('AdmMaster/portfolio/changeOrder') ?>', {
                method: 'POST',
                body: data
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message || '순위가 변경되었습니다.');
                        location.reload();
                    } else {
                        alert(data.message || '변경 실패');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('오류가 발생했습니다.');
                });
        }

        // 노출 토글
        function toggleUse(idx, type) {
            fetch('<?= site_url('AdmMaster/portfolio/toggle') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'idx=' + encodeURIComponent(idx) + '&type=' + encodeURIComponent(type)
            })
                .then(r => r.json())
                .then(res => {
                    if (!res.success) {
                        alert('변경 실패');
                        location.reload();
                    } else {
                        alert('변경되었습니다.');
                    }
                });
        }

        // 단일 삭제
        function deleteItem(idx) {
            if (!confirm('정말 삭제하시겠습니까?\n삭제 후 복구할 수 없습니다.')) {
                return;
            }

            fetch('<?= site_url('AdmMaster/portfolio/delete') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'idx=' + idx
            })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        alert('삭제되었습니다.');
                        location.reload();
                    } else {
                        alert('삭제 실패');
                    }
                });
        }
    </script>

<?= $this->endSection() ?>