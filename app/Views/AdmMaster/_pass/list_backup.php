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
            <a href="javascript:change_it()" class="btn btn-success">
                <i class="bi bi-gear"></i> 순위변경
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
                    <thead>
                    <tr>
                        <th colspan="4"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="label">교육과정명</td>
                        <td class="inbox">
                            <select name="education_subject" id="education_subject" class="form-select w-auto">
                                <option value="" selected="">전체</option>
                            </select>
                        </td>
                        <td class="label">신청법인</td>
                        <td class="inbox">
                            <select name="company_name" id="company_name" class="form-select w-auto">
                                <option value="" selected="">전체</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="label">소속</td>
                        <td class="inbox">
                            <select name="sub_company_name" id="sub_company_name" class="form-select w-auto">
                                <option value="" selected="">전체</option>
                            </select>
                        </td>
                        <td class="label">증서상태</td>
                        <td class="inbox">
                            <select name="expiration_period" id="expiration_period" class="form-select w-auto">
                                <option value="" selected="">전체</option>
                                <option value="available">유효</option>
                                <option value="expiration">만료</option>
                            </select>
                        </td>

                    </tr>

                    <tr>
                        <td class="label">교육기간</td>
                        <td colspan="3" class="inbox">
                            <div class="d-flex">
                                <div>
                                    <input type="text" name="schedule_start" id="schedule_start" value=""
                                           class="date_form w-auto form-control" autocomplete="off" readonly=""
                                           style="cursor: pointer;">
                                    <span>~</span>
                                    <input type="text" name="schedule_end" id="schedule_end" value=""
                                           class="date_form w-auto form-control" autocomplete="off" readonly=""
                                           style="cursor: pointer;">

                                    <button type="button" class="btn btn-outline-primary" title="today">
                                        오늘
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" title="week">
                                        1주일
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" title="1month">
                                        1개월
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" title="6month">
                                        6개월
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" title="year">
                                        1년
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="label">성명</td>
                        <td colspan="3" class="inbox">
                            <input class="form-control w-auto" type="text" name="name" id="name" value="">
                            <a href="javascript:search()" class="btn btn-primary">검색하기</a>
                            <button type="button" onclick="resetSearch()" class="btn btn-secondary">검색
                                조건 초기화
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
            <h5 class="mb-0">■ 총 <?= $num ?>개의 목록이 있습니다.</h5>
            <div class="d-flex flex-wrap gap-2">

            </div>
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
                            <col width="8%">
                            <col width="100px">
                            <col width="8%">
                            <col width="8%">
                            <col width="200px">
                            <col width="100px">
                            <col width="70px">
                            <col width="50px">
                        </colgroup>
                        <thead class="table-light">
                        <tr>
                            <th style="width:50px" class="text-center">
                                <input type="checkbox" id="checkAllBox" onclick="checkAll(this.checked)">
                            </th>
                            <th class="text-center">번호</th>
                            <th class="text-center">교육명</th>
                            <th class="text-center">소속</th>
                            <th class="text-center">직급</th>
                            <th class="text-center">성명</th>
                            <th class="text-center">생년월일</th>
                            <th class="text-center">휴대폰번호</th>
                            <th class="text-center">거주지</th>
                            <th class="text-center">교육기간</th>
                            <th class="text-center">수료일</th>
                            <th class="text-center">이수여부</th>
                            <th class="text-center">이수증</th>
                        </thead>
                        <tbody>
                        <?php
                        $startNum = $num - (($page - 1) * $perPage);
                        ?>
                        <?php foreach ($items as $key => $item): ?>
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox"
                                           name="selected_id[]"
                                           class="chk-item"
                                           value="<?= esc($item['id']) ?>">
                                </td>
                                <td class="text-center"><?= $startNum - $key ?></td>
                                <td class="text-center"><?= esc($item['course_name']) ?></td>
                                <td class="text-center"><?= esc($item['sub_company_name']) ?></td>
                                <td class="text-center"><?= esc($item['position']) ?></td>
                                <td class="text-center"><?= esc($item['name']) ?></td>
                                <td class="text-center"><?= esc($item['birthday']) ?></td>
                                <td class="text-center"><?= esc($item['phone']) ?></td>
                                <td class="text-center"><?= esc($item['residence']) ?></td>
                                <td class="text-center"><?= date('Y-m-d', strtotime($item['start_date'])) ?>
                                    ~ <?= date('Y-m-d', strtotime($item['end_date'])) ?></td>
                                <td class="text-center"><?= date('Y-m-d', strtotime($item['end_date'])) ?></td>
                                <td class="text-center">
                                    <?= compareDate($item['end_date']) < 1 ? '수료' : '미수료' ?>
                                </td>
                                <td class="text-center">
                                    <?php if (compareDate($item['end_date']) < 1): ?>
                                        <a target="_blank" href="/print/certificates?idx=<?= esc($item['id']) ?>"
                                           class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                    <?php endif; ?>
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

    </script>
    <script>
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
    </script>
    <script>
        function resetSearch() {

        }
    </script>
<?= $this->endSection() ?>