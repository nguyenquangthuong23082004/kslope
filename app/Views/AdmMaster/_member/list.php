<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>
<div class="page-heading mb-4 d-flex justify-content-between align-items-center">
    <h4 class="mb-0">회원관리</h4>

    <div class="d-flex gap-2 align-items-center">
        <?php if (in_array($type, ['N', 'G', 'S'])): ?>
            <a href="<?= site_url('AdmMaster/_members/exportExcel?type=' . $type) ?>" class="btn btn-success">
                <i class="bi bi-download"></i> 엑셀 다운로드
            </a>
        <?php endif; ?>
        <a href="javascript:checkAll(true)" class="btn btn-outline-success">
            전체선택
        </a>
        <a href="javascript:checkAll(false)" class="btn btn-outline-secondary">
            선택해체
        </a>
        <a href="javascript:bulkDelete()" class="btn btn-danger">
            선택삭제
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">■ 총 <?= $num ?>개의 목록이 있습니다.</h5>
        <div class="d-flex flex-wrap gap-2">
            <?php if ($type != 'N') { ?>
                <a href="/AdmMaster/_members/list?type=G"
                    class="btn <?php echo ($type == 'G') ? 'btn-primary' : 'btn-outline-secondary'; ?>">
                    단체회원
                </a>

                <a href="/AdmMaster/_members/list?type=S"
                    class="btn <?php echo ($type == 'S') ? 'btn-primary' : 'btn-outline-secondary'; ?>">
                    특별회원
                </a>
            <?php } ?>

        </div>
    </div>

    <div class="card-body pt-3">
        <form method="get" class="mb-3 d-flex gap-2">
            <input type="hidden" name="type" value="<?= $type ?>">
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
                        <col width="10%">
                        <?php if ($type != 'N') { ?>
                            <col width="12%">
                        <?php } ?>
                        <?php if ($type == 'N'): ?>
                            <col width="8%">
                            <col width="6%">
                        <?php endif; ?>
                        <col width="10%">
                        <col width="10%">
                        <col width="8%">
                        <col width="10%">
                        <col width="x">
                        <col width="10%">
                        <col width="5%">
                        <col width="100px">
                    </colgroup>
                    <thead class="table-light">
                        <tr>
                            <th style="width:50px" class="text-center">
                                <input type="checkbox" id="checkAllBox" onclick="checkAll(this.checked)">
                            </th>
                            <th>번호</th>
                            <th>아이디</th>
                            <?php if ($type != 'N') { ?>
                                <th>직원관리</th>
                            <?php } ?>
                            <?php if ($type == 'N'): ?>
                                <th class="text-center">업체ID</th>
                                <th class="text-center">업체구분</th>
                            <?php endif; ?>
                            <th>이메일</th>
                            <th>휴대번호</th>
                            <th>성명</th>
                            <th>직책</th>
                            <th>사업장 주소</th>
                            <th>가입일시</th>
                            <!--<th>상태</th>-->
                            <th class="text-center">승인상태</th>
                            <th>관리</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $startNum = $num - (($page - 1) * $perPage);
                        $managerRowspan = [];
                        if ($type == 'N') {
                            foreach ($items as $item) {
                                $managerId = $item['manager_id'] ?? '';
                                if (!empty($managerId)) {
                                    if (!isset($managerRowspan[$managerId])) {
                                        $managerRowspan[$managerId] = ['count' => 0, 'first_index' => null];
                                    }
                                    if ($managerRowspan[$managerId]['first_index'] === null) {
                                        $managerRowspan[$managerId]['first_index'] = $item['m_idx'];
                                    }
                                    $managerRowspan[$managerId]['count']++;
                                }
                            }
                        }

                        $displayedManagers = [];
                        ?>
                        <?php foreach ($items as $key => $item): ?>
                            <?php
                            $managerId = $item['manager_id'] ?? '';
                            $isFirstOfManager = false;
                            $rowspanCount = 1;

                            if ($type == 'N' && !empty($managerId)) {
                                if (!in_array($managerId, $displayedManagers)) {
                                    $isFirstOfManager = true;
                                    $displayedManagers[] = $managerId;
                                    $rowspanCount = $managerRowspan[$managerId]['count'] ?? 1;
                                }
                            }
                            ?>
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox"
                                        name="selected_idx[]"
                                        class="chk-item"
                                        value="<?= esc($item['m_idx']) ?>">
                                </td>
                                <td class="text-center"><?= $startNum - $key ?></td>
                                <td>
                                    <a href="/AdmMaster/_members/write?m_idx=<?= $item['m_idx'] ?>&type=<?= $item['member_type'] ?>"><?= $item['user_id'] ?></a>
                                </td>
                                <?php if ($type != 'N'): ?>
                                    <td>
                                        <div class="d-flex gap-2 align-items-center">
                                            <div class="flex-grow-1">
                                                <?php if ($item['staff_count'] > 0): ?>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-primary dropdown-toggle"
                                                            type="button"
                                                            data-bs-toggle="dropdown"
                                                            style="width: 90px">
                                                            <i class="bi bi-people"></i> <?= $item['staff_count'] ?> Staff
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <?php foreach ($item['staff_list'] as $staff): ?>
                                                                <li>
                                                                    <a class="dropdown-item d-flex justify-content-between"
                                                                        href="/AdmMaster/_members/write?m_idx=<?= $staff['m_idx'] ?>&type=<?= $staff['member_type'] ?>">
                                                                        <div>
                                                                            <i class="bi bi-person"></i>
                                                                            <?= $staff['user_name'] ?>
                                                                            <small class="text-muted">(<?= $staff['user_id'] ?>)</small>
                                                                        </div>
                                                                        <small style="margin-left: 15px;" class="text-muted"><?= $staff['status_course'] ?></small>
                                                                    </a>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary" style="width: 90px; height: 29px; line-height: 19px;">0 Staff</span>
                                                <?php endif; ?>
                                            </div>

                                            <a href="/AdmMaster/_members/member_staff?user_id=<?= $item['user_id'] ?>"
                                                class="btn btn-sm btn-success"
                                                title="직원등록">
                                                <i class="bi bi-person-plus"></i> 직원등록
                                            </a>
                                        </div>
                                    </td>
                                <?php endif; ?>
                                <?php if ($type == 'N'): ?>
                                    <?php if (empty($managerId) || $isFirstOfManager): ?>
                                        <td class="text-center" <?= !empty($managerId) && $rowspanCount > 1 ? "rowspan='{$rowspanCount}'" : '' ?>>
                                            <?php if (!empty($item['manager_info'])): ?>
                                                <a href="/AdmMaster/_members/write?m_idx=<?= $item['manager_info']['m_idx'] ?>&type=<?= $item['manager_info']['member_type'] ?>">
                                                    <?= $item['manager_id'] ?>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">--</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center" <?= !empty($managerId) && $rowspanCount > 1 ? "rowspan='{$rowspanCount}'" : '' ?>>
                                            <?php if (!empty($item['manager_info'])): ?>
                                                <?php
                                                $managerType = $item['manager_info']['member_type'];
                                                $badgeClass = '';
                                                $typeText = '';

                                                switch ($managerType) {
                                                    case 'G':
                                                        $badgeClass = 'bg-success';
                                                        $typeText = '단체회원';
                                                        break;
                                                    case 'S':
                                                        $badgeClass = 'bg-info';
                                                        $typeText = '특별회원';
                                                        break;
                                                    default:
                                                        $badgeClass = 'bg-secondary';
                                                        $typeText = '개인회원';
                                                }
                                                ?>
                                                <span class="badge <?= $badgeClass ?>"><?= $typeText ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">개인회원</span>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <td>
                                    <a href="/AdmMaster/_members/write?m_idx=<?= $item['m_idx'] ?>&type=<?= $item['member_type'] ?>"><?= $item['user_email'] ?></a>
                                </td>
                                <td> <?= $item['user_mobile'] ?></td>
                                <td>
                                    <a href="/AdmMaster/_members/write?m_idx=<?= $item['m_idx'] ?>&type=<?= $item['member_type'] ?>"><?= $item['user_name'] ?></a>
                                </td>
                                <td><?= $item['work_position'] ?></td>
                                <td>
                                    <div class="text-truncate">
                                        <?= $item['zip'] ?> - <?= $item['addr1'] ?> <?= $item['addr2'] ?>
                                    </div>
                                </td>
                                <td> <?= date('Y-m-d H:i:s', strtotime($item['r_date'])) ?></td>
                                <!--<td></td>-->
                                <td class="text-center">
                                    <?php
                                    $approvalStatus = $item['approval_status'] ?? 'Y';
                                    $badgeClass = $approvalStatus == 'Y' ? 'bg-success' : 'bg-warning';
                                    $statusText = $approvalStatus == 'Y' ? '승인완료' : '승인';
                                    ?>
                                    <span class="badge <?= $badgeClass ?> approval-badge"
                                        style="cursor: pointer;"
                                        data-idx="<?= $item['m_idx'] ?>"
                                        data-status="<?= $approvalStatus ?>"
                                        onclick="toggleApprovalStatus(this)">
                                        <?= $statusText ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="/AdmMaster/_members/write?m_idx=<?= $item['m_idx'] ?>&type=<?= $item['member_type'] ?>"
                                            class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" onclick="deleteMember('<?= $item['m_idx'] ?>')"
                                            class="btn btn-danger btn-sm">
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
                url: '<?= site_url('AdmMaster/_members/updateStatus') ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    m_idx: idx,
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

    function toggleApprovalStatus(element) {
        const m_idx = $(element).data('idx');
        const currentStatus = $(element).data('status');
        const newStatus = currentStatus == 'Y' ? 'N' : 'Y';
        const confirmMessage = newStatus == 'Y' ?
            '이 회원을 승인하시겠습니까?' :
            '이 회원을 승인 대기 상태로 변경하시겠습니까?';

        if (!confirm(confirmMessage)) {
            return false;
        }

        $.ajax({
            url: '<?= site_url('AdmMaster/_members/updateApprovalStatus') ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                m_idx: m_idx,
                approval_status: newStatus
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message);

                    // UI 업데이트
                    $(element).data('status', newStatus);
                    if (newStatus == 'Y') {
                        $(element).removeClass('bg-warning').addClass('bg-success');
                        $(element).text('승인완료');
                    } else {
                        $(element).removeClass('bg-success').addClass('bg-warning');
                        $(element).text('승인');
                    }
                } else {
                    alert('변경 실패: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('오류가 발생했습니다: ' + error);
            }
        });
    }


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

    async function deleteMember(id) {
        if (!confirm(`해당 회원을 삭제하시겠습니까?\n삭제 후 복구할 수 없습니다.`)) {
            return false;
        }

        const formData = new FormData();
        formData.append("m_idx[]", id);

        await processDelete(formData);
    }

    async function processDelete(formData) {
        await fetch('<?= site_url('AdmMaster/_members/delete') ?>', {
                method: "POST",
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    alert('삭제되었습니다.');
                    location.reload();
                } else {
                    alert('삭제 실패');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('오류가 발생했습니다.');
            });
    }


    // 선택 삭제
    async function bulkDelete() {
        const checkedBoxes = document.querySelectorAll('.chk-item:checked');

        if (checkedBoxes.length === 0) {
            alert('삭제할 항목을 선택해주세요.');
            return false;
        }

        if (!confirm(`선택한 ${checkedBoxes.length}개 항목을 삭제하시겠습니까?\n삭제 후 복구할 수 없습니다.`)) {
            return false;
        }

        const selectedIds = Array.from(checkedBoxes).map(cb => cb.value);

        const formData = new FormData();
        selectedIds.forEach(id => formData.append("m_idx[]", id));

        await processDelete(formData);
    }
</script>
<?= $this->endSection() ?>