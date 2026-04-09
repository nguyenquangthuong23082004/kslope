<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>

    <div class="page-heading mb-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-0">수료증 발급</h4>

        <div class="d-flex gap-2 align-items-center">
            <a href="javascript:checkAll(true)" class="btn btn-outline-success">
                <i class="bi bi-check-square"></i> 전체선택
            </a>
            <a href="javascript:checkAll(false)" class="btn btn-outline-secondary">
                <i class="bi bi-square"></i> 선택해체
            </a>
            <a href="javascript:SELECT_DELETE()" class="btn btn-danger">
                <i class="bi bi-trash"></i> 선택삭제
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body pt-3">
            <form method="get" class="mb-3 d-flex gap-2">
                <table class="table table-bordered" style="table-layout:fixed;">
                    <colgroup>
                        <col style="width: 150px">
                        <col style="width: auto">
                        <col style="width: 150px">
                        <col style="width: auto">
                    </colgroup>
                    <tbody>
                    <tr>
                        <td class="label">교육과정명</td>
                        <td class="inbox">
                            <select name="education_subject" id="education_subject" class="form-select w-auto">
                                <option value="">전체</option>
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?= $course['idx'] ?>" 
                                        <?= ($filters['education_subject'] == $course['idx']) ? 'selected' : '' ?>>
                                        <?= esc($course['course_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td class="label">신청법인</td>
                        <td class="inbox">
                            <select name="company_name" id="company_name" class="form-select w-auto">
                                <option value="">전체</option>
                                <?php foreach ($companies as $company): ?>
                                    <option value="<?= esc($company['user_name']) ?>"
                                        <?= ($filters['company_name'] == $company['user_name']) ? 'selected' : '' ?>>
                                        <?= esc($company['user_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="label">수료기간</td>
                        <td colspan="3" class="inbox">
                            <div class="d-flex align-items-center gap-2">
                                <input type="date" 
                                       name="schedule_start" 
                                       id="schedule_start" 
                                       value="<?= esc($filters['schedule_start']) ?>"
                                       class="form-control w-auto">
                                <span>~</span>
                                <input type="date" 
                                       name="schedule_end" 
                                       id="schedule_end" 
                                       value="<?= esc($filters['schedule_end']) ?>"
                                       class="form-control w-auto">

                                <button type="button" class="btn btn-outline-primary" onclick="setDateRange('today')">
                                    오늘
                                </button>
                                <button type="button" class="btn btn-outline-primary" onclick="setDateRange('week')">
                                    1주일
                                </button>
                                <button type="button" class="btn btn-outline-primary" onclick="setDateRange('1month')">
                                    1개월
                                </button>
                                <button type="button" class="btn btn-outline-primary" onclick="setDateRange('6month')">
                                    6개월
                                </button>
                                <button type="button" class="btn btn-outline-primary" onclick="setDateRange('year')">
                                    1년
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="label">성명</td>
                        <td colspan="3" class="inbox">
                            <input class="form-control w-auto" 
                                   type="text" 
                                   name="name" 
                                   id="name" 
                                   value="<?= esc($filters['name']) ?>">
                            <button type="submit" class="btn btn-primary">검색하기</button>
                            <button type="button" onclick="resetSearch()" class="btn btn-secondary">
                                검색 조건 초기화
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">■ 총 <?= number_format($num) ?>개의 목록이 있습니다.</h5>
        </div>

        <div class="card-body pt-3">
            <form name="courseForm" id="courseForm">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <colgroup>
                            <col width="50px">
                            <col width="50px">
                            <col width="15%">
                            <col width="x">
                            <col width="8%">
                            <col width="100px">
                            <col width="8%">
                            <col width="200px">
                            <col width="100px">
                            <col width="100px">
                            <col width="150px">
                            <col width="50px">
                        </colgroup>
                        <thead class="table-light">
                        <tr>
                            <th class="text-center">
                                <input type="checkbox" id="checkAllBox" onclick="checkAll(this.checked)">
                            </th>
                            <th class="text-center">번호</th>
                            <th class="text-center">교육명</th>
                            <th class="text-center">소속/법인</th>
                            <th class="text-center">성명</th>
                            <th class="text-center">생년월일</th>
                            <th class="text-center">휴대폰번호</th>
                            <th class="text-center">교육기간</th>
                            <th class="text-center">수료일</th>
                            <th class="text-center">진도율</th>
                            <th class="text-center">이수여부</th>
                            <th class="text-center">이수증</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $startNum = $num - (($page - 1) * $perPage);
                        ?>
                        <?php if (empty($items)): ?>
                            <tr>
                                <td colspan="12" class="text-center py-5">
                                    수료한 교육 과정이 없습니다.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($items as $key => $item): ?>
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox"
                                               name="selected_id[]"
                                               class="chk-item"
                                               value="<?= esc($item['course_progress_idx']) ?>">
                                    </td>
                                    <td class="text-center"><?= $startNum - $key ?></td>
                                    <td class="text-center"><?= esc($item['course_name']) ?></td>
                                    <td class="text-center"><?= esc($item['manager_user_id']) ?></td>
                                    <td class="text-center"><?= esc($item['user_name']) ?></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"><?= esc($item['user_mobile']) ?></td>
                                    <td class="text-center">
                                        <?= date('Y-m-d', strtotime($item['start_date'])) ?>
                                        ~ <?= date('Y-m-d', strtotime($item['end_date'])) ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $item['completion_date'] ? date('Y-m-d', strtotime($item['completion_date'])) : '-' ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success">
                                            <?= number_format($item['progress_percent'], 1) ?>%
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($item['certificate'] == 'Y'): ?>
                                            <span class="badge bg-success">수료</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">미수료</span><br>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-primary mt-1"
                                                    onclick="openSendMailModal(
                                                        '<?= esc($item['course_progress_idx']) ?>',
                                                        '<?= esc($item['user_name']) ?>',
                                                        '<?= esc($item['user_email']) ?>'
                                                    )">
                                                <i class="bi bi-envelope"></i> 메일수신
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($item['status'] == 'completed'): ?>
                                            <a target="_blank" 
                                               href="/print/certificates?user_id=<?= esc($item['user_id']) ?>&course_idx=<?= esc($item['course_idx']) ?>"
                                               class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-printer"></i>
                                            </a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </form>
            <div class="modal fade" id="sendMailModal" tabindex="-1" aria-labelledby="sendMailModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="sendMailModalLabel">
                                <i class="bi bi-envelope"></i> 메일 발송
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="sendMailForm">
                                <input type="hidden" name="r_idx" id="r_idx">
                                <div class="mb-3">
                                    <label for="mail_to_name" class="form-label">이름</label>
                                    <input type="text" name="mail_to_name" id="mail_to_name" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="mail_to_email" class="form-label">이메일 <span class="text-danger">*</span></label>
                                    <input type="email" name="mail_to_email" id="mail_to_email" class="form-control" required>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-x-lg"></i> 닫기
                            </button>
                            <button type="button" class="btn btn-primary" onclick="sendEmailAjax()">
                                <i class="bi bi-send"></i> 보내기
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- PAGINATION -->
            <?php if ($pager): ?>
                <div class="mt-4">
                    <?= $pager->links('notice', 'bootstrap5_full') ?>
                </div>
            <?php endif ?>
        </div>
    </div>

    <script>
        function openSendMailModal(idx, userName, userEmail) {
            document.getElementById('r_idx').value         = idx;
            document.getElementById('mail_to_name').value  = userName;
            document.getElementById('mail_to_email').value = userEmail;

            new bootstrap.Modal(document.getElementById('sendMailModal')).show();
        }

        function sendEmailAjax() {
            const r_idx = $('#r_idx').val().trim();
            const r_email = $('#mail_to_email').val().trim();
            const mail_to_name = $('#mail_to_name').val().trim();

            if (!r_email || !mail_to_name) {
                alert('필수 정보를 모두 입력해주세요.\n- 이메일\n- 이름');
                return;
            }

            console.log(r_email);
            

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(r_email)) {
                alert('올바른 이메일 주소를 입력해주세요.');
                $('#mail_to_email').focus();
                return;
            }

            const formData = {
                r_idx: r_idx,
                r_email: r_email,
                mail_to_name: mail_to_name,
            };

            const $btn = $('button[onclick="sendEmailAjax()"]');
            const originalText = $btn.html();
            $btn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> 발송 중...');

            $.ajax({
                url: '<?= site_url('/AdmMaster/_pass/send_email') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        bootstrap.Modal.getInstance(document.getElementById('sendMailModal')).hide();
                        location.reload();
                    } else {
                        alert(response.message || '이메일 발송에 실패했습니다.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', xhr.responseText);
                    alert('서버 오류가 발생했습니다. 잠시 후 다시 시도해주세요.');
                },
                complete: function() {
                    $btn.prop('disabled', false).html(originalText);
                }
            });
        }



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

        async function SELECT_DELETE() {
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
            selectedIds.forEach(id => formData.append("id[]", id));

            await processDelete(formData);
        }

        async function processDelete(formData) {
            await fetch('<?= site_url('AdmMaster/_pass/delete') ?>', {
                method: "POST",
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
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

        function resetSearch() {
            window.location.href = '<?= site_url('AdmMaster/_pass/list') ?>';
        }

        function setDateRange(period) {
            const today = new Date();
            const startInput = document.getElementById('schedule_start');
            const endInput = document.getElementById('schedule_end');
            
            let startDate = new Date();
            let endDate = new Date(today);
            
            switch(period) {
                case 'today':
                    startDate = new Date(today);
                    break;
                case 'week':
                    startDate.setDate(today.getDate() - 7);
                    break;
                case '1month':
                    startDate.setMonth(today.getMonth() - 1);
                    break;
                case '6month':
                    startDate.setMonth(today.getMonth() - 6);
                    break;
                case 'year':
                    startDate.setFullYear(today.getFullYear() - 1);
                    break;
            }
            
            startInput.value = startDate.toISOString().split('T')[0];
            endInput.value = endDate.toISOString().split('T')[0];
        }
    </script>
<?= $this->endSection() ?>