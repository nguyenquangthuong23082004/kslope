<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>
<?php if (session()->getFlashdata('success')): ?>
<script>
    alert('<?= session()->getFlashdata('success') ?>');
</script>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<script>
    alert('<?= session()->getFlashdata('error') ?>');
</script>
<?php endif; ?>
    <div class="page-heading mb-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-0">견적 문의 목록</h4>

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
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">■ 총 <?= $num ?>개의 목록이 있습니다.</h5>
            <div class="d-flex flex-wrap gap-2">

            </div>
        </div>

        <div class="card-body pt-3">
            <form method="get" class="mb-3 d-flex gap-2">
                <input type="text" name="keyword" value="<?= $keyword ?>" class="form-control w-auto"
                       placeholder="제목 검색">

                <button class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <form name="frm" id="frm">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <colgroup>
                            <col width="50px">
                            <col width="50px">
                            <col width="12%">
                            <col width="10%">
                            <col width="10%">
                            <col width="15%">
                            <col width="x">
                            <col width="10%">
                            <col width="100px">
                        </colgroup>
                        <thead class="table-light">
                            <th style="width:50px" class="text-center">
                                <input type="checkbox" id="checkAllBox" onclick="checkAll(this.checked)">
                            </th>
                            <th>번호</th>
                            <th>업체명</th>
                            <th>담당자</th>
                            <th>연락처</th>
                            <th>이메일</th>
                            <th>문의 내용</th>
                            <th>상태</th>
                            <th>관리</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($items as $key => $item): ?>
                            <tr>
                                 <td class="text-center">
                                    <input type="checkbox" 
                                           name="selected_idx[]" 
                                           class="chk-item" 
                                           value="<?= esc($item['r_idx']) ?>">
                                </td>
                                <td class="text-center"><?= $key + 1 ?></td>
                                <td><a href="/AdmMaster/_quote_request/detail?r_idx=<?= $item['r_idx'] ?>"><?= $item['r_company'] ?></a></td>
                                <td>
                                    <a href="/AdmMaster/_quote_request/detail?r_idx=<?= $item['r_idx'] ?>"><?= $item['r_manager'] ?></a>
                                </td>
                                <td><?= $item['r_phone'] ?></td>
                                <td><?= $item['r_email'] ?></td>
                                <td>
                                    <div class="text-truncate">
                                        <?= $item['r_content'] ?>
                                    </div>
                                </td>
                                <td>
                                    <select name="r_status" 
                                        id="r_status_<?= $item['r_idx'] ?>" 
                                        class="form-select" 
                                        style="height: 40px; width: 150px"
                                        data-idx="<?= $item['r_idx'] ?>"
                                        data-old-value="<?= $item['r_status'] ?>">
                                        <option value="Y" <?= $item['r_status'] == 'Y' ? 'selected' : '' ?>>문의접수</option>
                                        <option value="S" <?= $item['r_status'] == 'S' ? 'selected' : '' ?>>단순문의</option>
                                        <option value="H" <?= $item['r_status'] == 'H' ? 'selected' : '' ?>>취소</option>
                                        <option value="C" <?= $item['r_status'] == 'C' ? 'selected' : '' ?>>답변완료</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="/AdmMaster/_quote_request/detail?r_idx=<?= $item['r_idx'] ?>" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>

            <!-- PAGINATION -->
            <?php if ($pager): ?>
                <div class="mt-4">
                    <?= $pager->links('notice', 'bootstrap5_full') ?>
                </div>
            <?php endif ?>

            <!-- Bottom Buttons -->
        </div>
    </div>

    <script>

        $(document).ready(function() {
            $('select[name="r_status"]').on('change', function() {
                const idx = $(this).data('idx');
                const newStatus = $(this).val();
                const oldStatus = $(this).data('old-value');
                const $select = $(this);
                
                $select.prop('disabled', true);
                
                $.ajax({
                    url: '<?= site_url('AdmMaster/_quote_request/updateStatus') ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        r_idx: idx,
                        r_status: newStatus
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('상태가 변경되었습니다.');
                            $select.data('old-value', newStatus);
                        } else {
                            alert('변경 실패: ' + response.message);
                            $select.val(oldStatus);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('오류가 발생했습니다: ' + error);
                        $select.val(oldStatus);
                    },
                    complete: function() {
                        $select.prop('disabled', false);
                    }
                });
            });
        });


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

        fetch('<?= site_url('AdmMaster/_quote_request/bulkDelete') ?>', {
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
    </script>

<?= $this->endSection() ?>