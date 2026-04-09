<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>

<?php
if (!$pg) {
    $pg = 1;
}

if (!$g_list_rows) {
    $g_list_rows = 10;
}

$strSql = "";
if ($search_word != "") {
    $strSql = " and (P_SUBJECT like '%" . esc($search_word) . "%') ";
}

$total_sql = " SELECT * FROM tbl_popup WHERE 1=1 $strSql";
$fresult = $query = $db->query($total_sql)->getResultArray();
$nTotalCount = count($fresult);
?>

<div class="page-heading mb-4 d-flex justify-content-between align-items-center">
    <h4 class="mb-0">팝업 관리</h4>

</div>

<section class="section">
    <div class="card">
        <div class="card-body">
            <!-- Search & Filter Bar -->
            <form method="GET" id="searchForm" class="mb-4">
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <select name="g_list_rows" 
                                class="form-select" 
                                onchange="this.form.submit()" style="height: 40px; width: 150px">
                            <option value="10" <?= $g_list_rows == 10 ? 'selected' : '' ?>>10개</option>
                            <option value="20" <?= $g_list_rows == 20 ? 'selected' : '' ?>>20개</option>
                            <option value="30" <?= $g_list_rows == 30 ? 'selected' : '' ?>>30개</option>
                            <option value="50" <?= $g_list_rows == 50 ? 'selected' : '' ?>>50개</option>
                            <option value="100" <?= $g_list_rows == 100 ? 'selected' : '' ?>>100개</option>
                        </select>
                    
                        <div class="d-flex align-items-center gap-2" style="width: 200px">
                            <input type="text" 
                                   name="search_word" 
                                   class="form-control" 
                                   placeholder="팝업창 제목 검색..."
                                   value="<?= esc($search_word ?? '') ?>" style="height: 40px; width: 150px">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> 검색
                            </button>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center gap-2" role="group">
                            <button type="button" 
                                    onclick="checkAll(true)" 
                                    class="btn btn-outline-success">
                                <i class="bi bi-check-square"></i> 전체선택
                            </button>
                            <button type="button" 
                                    onclick="checkAll(false)" 
                                    class="btn btn-outline-secondary">
                                <i class="bi bi-square"></i> 선택해체
                            </button>
                            <button type="button" 
                                    onclick="bulkDelete()" 
                                    class="btn btn-danger">
                                <i class="bi bi-trash"></i> 선택삭제
                            </button>
                                <a href="<?= site_url('AdmMaster/_popup/detail') ?>" class="btn btn-success">
                                    <i class="bi bi-plus-square"></i> 등록
                                </a>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="pg" value="<?= $pg ?>">
            </form>

            <!-- Total Count -->
            <div class="alert alert-light border mb-3">
                <i class="bi bi-list-ul text-primary"></i>
                총 <strong class="text-primary"><?= number_format($nTotalCount) ?></strong>개의 팝업
            </div>

            <!-- Table -->
            <form id="listForm">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;" class="text-center">
                                    <input type="checkbox" 
                                           id="checkAllBox" 
                                           onclick="checkAll(this.checked)">
                                </th>
                                <th style="width: 70px" class="text-center">번호</th>
                                <th style="width: 150px" class="text-center">사용여부</th>
                                <th class="text-center">팝업창 제목</th>
                                <th style="width: 100px" class="text-center">노출기기</th>
                                <th style="width: 150px" class="text-center">시작일시</th>
                                <th style="width: 150px" class="text-center">종료일시</th>
                                <th style="width: 100px" class="text-center">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nPage = ceil($nTotalCount / $g_list_rows);
                            if ($pg == "") $pg = 1;
                            $nFrom = ($pg - 1) * $g_list_rows;

                            $sql = $total_sql . " order by idx desc limit $nFrom, $g_list_rows ";
                            $fresult = $db->query($sql)->getResultArray();
                            $num = $nTotalCount - $nFrom;

                            if (empty($fresult)):
                            ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        등록된 팝업이 없습니다.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($fresult as $frow): ?>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" 
                                                   name="idx[]" 
                                                   class="chk-item" 
                                                   value="<?= $frow['idx'] ?>">
                                        </td>
                                        
                                        <td class="text-center"><?= $num ?></td>
                                        
                                        <td class="text-center">
                                            <select style="height: 40px" class="form-select form-select-sm" 
                                                    onchange="changeStatus('<?= $frow['idx'] ?>', this.value)">
                                                <option value="B" <?= $frow["status"] == "B" ? "selected" : "" ?>>
                                                    강제 노출
                                                </option>
                                                <option value="C" <?= $frow["status"] == "C" ? "selected" : "" ?>>
                                                    강제 비노출
                                                </option>
                                            </select>
                                        </td>
                                        
                                        <td>
                                            <a href="<?= site_url('AdmMaster/_popup/detail/' . $frow["idx"]) ?>" 
                                               class="text-decoration-none">
                                                <?php
                                                if ($search_word != '') {
                                                    echo preg_replace("/(" . preg_quote($search_word, '/') . ")/i", 
                                                        "<mark>$1</mark>", 
                                                        esc($frow["P_SUBJECT"]));
                                                } else {
                                                    echo esc($frow["P_SUBJECT"]);
                                                }
                                                ?>
                                            </a>
                                        </td>
                                        
                                        <td class="text-center">
                                            <?php if ($frow['is_mobile'] == "P"): ?>
                                                <span class="badge bg-primary">
                                                    <i class="bi bi-laptop"></i> PC
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-info">
                                                    <i class="bi bi-phone"></i> Mobile
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <td class="text-center small">
                                            <?= $frow['P_STARTDAY'] ?>
                                            <br>
                                            <span class="text-muted">
                                                <?= $frow['P_START_HH'] ?>:<?= $frow['P_START_MM'] ?>
                                            </span>
                                        </td>
                                        
                                        <td class="text-center small">
                                            <?= $frow['P_ENDDAY'] ?>
                                            <br>
                                            <span class="text-muted">
                                                <?= $frow['P_END_HH'] ?>:<?= $frow['P_END_MM'] ?>
                                            </span>
                                        </td>
                                        
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a href="<?= site_url('AdmMaster/_popup/detail/' . $frow["idx"]) ?>" 
                                                   class="btn btn-primary"
                                                   title="수정">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-danger"
                                                        onclick="deleteItem('<?= $frow['idx'] ?>')"
                                                        title="삭제">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $num--; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
// 전체 선택/해제
function checkAll(checked) {
    const checkboxes = document.querySelectorAll('.chk-item');
    checkboxes.forEach(checkbox => {
        checkbox.checked = checked;
    });
    
    const checkAllBox = document.getElementById('checkAllBox');
    if (checkAllBox) {
        checkAllBox.checked = checked;
    }
}

// 선택 삭제
function bulkDelete() {
    const checkedBoxes = document.querySelectorAll('.chk-item:checked');
    
    if (checkedBoxes.length === 0) {
        alert('삭제할 팝업을 선택해주세요.');
        return;
    }

    if (!confirm(`선택한 ${checkedBoxes.length}개의 팝업을 삭제하시겠습니까?\n삭제 후 복구할 수 없습니다.`)) {
        return;
    }

    const formData = new FormData(document.getElementById('listForm'));

    fetch('<?= site_url('AdmMaster/_popup/del_popup') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.result) {
            alert(data.message);
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

// 단일 삭제
function deleteItem(idx) {
    if (!confirm('이 팝업을 삭제하시겠습니까?\n삭제 후 복구할 수 없습니다.')) {
        return;
    }

    fetch('<?= site_url('AdmMaster/_popup/del_popup') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'idx[]=' + idx
    })
    .then(response => response.json())
    .then(data => {
        if (data.result) {
            alert(data.message);
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

// 상태 변경
function changeStatus(idx, status) {
    fetch('<?= site_url('AdmMaster/_popup/change_status') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
        },
        body: 'idx=' + encodeURIComponent(idx) + '&status=' + encodeURIComponent(status)
    })
    .then(response => response.json())
    .then(data => {
        if (data.result) {
            alert('상태가 정상적으로 변경되었습니다.');
            location.reload();
        } else {
            alert(data.message || '상태 변경 실패');
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('오류가 발생했습니다.');
    });
}

</script>

<style>
mark {
    background-color: #fff3cd;
    padding: 2px 4px;
    border-radius: 2px;
}

.table > :not(caption) > * > * {
    padding: 0.75rem;
}

.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
}
</style>

<?= $this->endSection() ?>