<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>

<!-- Page Header -->
<div class="page-heading mb-4 d-flex justify-content-between align-items-center">
    <h4 class="mb-0"><?= esc($code_name) ?> 코드 리스트</h4>
</div>

<!-- Main Content -->
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">■ 총 <?= number_format($nTotalCount) ?>개의 목록이 있습니다.</h5>
            <div class="d-flex flex-wrap gap-2">
                <?php if (!empty($grandParentCode)): ?>
                    <a href="<?= site_url('AdmMaster/_code?s_parent_code_no=' . $grandParentCode) ?>" 
                       class="btn btn-success btn-sm">
                        <i class="bi bi-arrow-up"></i> 상위이동
                    </a>
                <?php endif; ?>
                <button type="button" onclick="change_it()" class="btn btn-success">
                   순위변경
                </button>
                <a href="<?= site_url('AdmMaster/_code/write?s_parent_code_no=' . $s_parent_code_no) ?>" 
                   class="btn btn-primary">
                    <i class="bi bi-pencil"></i> 신규등록
                </a>
            </div>
        </div>

        <div class="card-body pt-3">
            <form name="frm" id="frm">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th style="width: 5%;">번호</th>
                                <th style="width: 10%">코드번호</th>
                                <th>코드명</th>
                                <th style="width: 10%;">DEPTH</th>
                                <th style="width: 10%;">하위갯수</th>
                                <th style="width: 10%;">현황</th>
                                <th style="width: 10%;">우선순위</th>
                                <th style="width: 18%;">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($result)): ?>
                                <tr>
                                    <td colspan="8" 
                                        class="text-center py-5">
                                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                        <p class="mt-2 text-muted">검색된 결과가 없습니다.</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($result as $row): ?>
                                    <tr>
                                        <td class="text-center"><?= $num-- ?></td>
                                        <td class="text-center">
                                            <?= esc($row['code_no']) ?>
                                        </td>
                                        <td>
                                            <a href="<?= site_url('AdmMaster/_code/write?code_idx=' . $row['code_idx'] . '&s_parent_code_no=' . $s_parent_code_no) ?>" 
                                               class="text-decoration-none">
                                                <?= esc($row['code_name']) ?>
                                            </a>
                                        </td>
                                        <td class="text-center"><?= esc($row['depth']) ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-info"><?= esc($row['cnt']) ?></span>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            $statusConfig = [
                                                'Y' => ['label' => '사용', 'class' => 'success'],
                                                'N' => ['label' => '삭제', 'class' => 'danger'],
                                                'C' => ['label' => '마감', 'class' => 'warning']
                                            ];
                                            $status = $statusConfig[$row['status']] ?? ['label' => '-', 'class' => 'secondary'];
                                            ?>
                                            <span class="badge bg-<?= $status['class'] ?>">
                                                <?= $status['label'] ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <input type="number" 
                                                   name="onum[]" 
                                                   value="<?= esc($row['onum']) ?>" 
                                                   class="form-control form-control-sm text-center d-inline-block" 
                                                   style="width: 70px;" />
                                            <input type="hidden" 
                                                   name="code_idx[]" 
                                                   value="<?= esc($row['code_idx']) ?>" />
                                        </td>
                                        <td class="text-center">
                                                <button type="button" 
                                                        onclick="del_it(<?= $row['code_idx'] ?>)" 
                                                        class="btn btn-danger" 
                                                        title="삭제">
														코드삭제
                                                </button>
                                                <a href="<?= site_url('AdmMaster/_code/write?s_parent_code_no=' . $row['code_no']) ?>" 
                                                   class="btn btn-primary" 
                                                   title="추가등록">
                                                    추가등록
                                                </a>
                                                <a href="<?= site_url('AdmMaster/_code/list?s_parent_code_no=' . $row['code_no']) ?>" 
                                                   class="btn btn-success" 
                                                   title="하위리스트">
                                                    하위리스트
                                                </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </form>

            <!-- Pagination -->
            <?php if ($nPage > 1): ?>
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php
                        $start_page = max(1, $pg - 2);
                        $end_page = min($nPage, $pg + 2);
                        ?>
                        
                        <!-- First & Previous -->
                        <?php if ($pg > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= site_url('AdmMaster/_code?s_parent_code_no=' . $s_parent_code_no . '&pg=1') ?>">
                                    <i class="bi bi-chevron-double-left"></i>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="<?= site_url('AdmMaster/_code?s_parent_code_no=' . $s_parent_code_no . '&pg=' . ($pg - 1)) ?>">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- Page Numbers -->
                        <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                            <li class="page-item <?= ($i == $pg) ? 'active' : '' ?>">
                                <a class="page-link" href="<?= site_url('AdmMaster/_code?s_parent_code_no=' . $s_parent_code_no . '&pg=' . $i) ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <!-- Next & Last -->
                        <?php if ($pg < $nPage): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= site_url('AdmMaster/_code?s_parent_code_no=' . $s_parent_code_no . '&pg=' . ($pg + 1)) ?>">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="<?= site_url('AdmMaster/_code?s_parent_code_no=' . $s_parent_code_no . '&pg=' . $nPage) ?>">
                                    <i class="bi bi-chevron-double-right"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>

            <!-- Bottom Buttons -->
            <div class="d-flex justify-content-end mt-4">
				<div class="d-flex flex-wrap gap-2">
					<?php if (!empty($grandParentCode)): ?>
						<a href="<?= site_url('AdmMaster/_code?s_parent_code_no=' . $grandParentCode) ?>" 
						class="btn btn-success btn-sm">
							<i class="bi bi-arrow-up"></i> 상위이동
						</a>
					<?php endif; ?>
					<button type="button" onclick="change_it()" class="btn btn-success">
					순위변경
					</button>
					<a href="<?= site_url('AdmMaster/_code/write?s_parent_code_no=' . $s_parent_code_no) ?>" 
					class="btn btn-primary">
						<i class="bi bi-pencil"></i> 신규등록
					</a>
				</div>
            </div>
        </div>
    </div>
</section>

<script>
function change_it() {
    if (!confirm('순위를 변경하시겠습니까?')) {
        return;
    }

    $.ajax({
        url: "<?= site_url('AdmMaster/_code/change') ?>",
        type: "POST",
        data: $("#frm").serialize(),
        beforeSend: function() {
            // Loading indicator
            $('button').prop('disabled', true);
        },
        success: function(response) {
            if (response == "OK") {
                alert("정상적으로 변경되었습니다.");
                location.reload();
            } else {
                alert("오류가 발생하였습니다!");
            }
        },
        error: function(request, status, error) {
            alert("code : " + request.status + "\nmessage : " + request.responseText);
        },
        complete: function() {
            $('button').prop('disabled', false);
        }
    });
}

function del_it(code_idx) {
    if (!confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.")) {
        return;
    }

    $.ajax({
        url: "<?= site_url('AdmMaster/_code/del') ?>",
        type: "POST",
        data: { code_idx: code_idx },
        beforeSend: function() {
            $('button').prop('disabled', true);
        },
        success: function(response) {
            if (response == "OK") {
                alert("정상적으로 삭제되었습니다.");
                location.reload();
            } else {
                alert("오류가 발생하였습니다!");
            }
        },
        error: function(request, status, error) {
            alert("code : " + request.status + "\nmessage : " + request.responseText);
        },
        complete: function() {
            $('button').prop('disabled', false);
        }
    });
}
</script>

<?= $this->endSection() ?>