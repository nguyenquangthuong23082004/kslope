<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>

    <div class="page-heading mb-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-0">교육예약</h4>

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
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">■ 총 <?= $num ?>개의 목록이 있습니다.</h5>
            <div class="d-flex flex-wrap gap-2">

            </div>
        </div>

        <div class="card-body pt-3">
            <form method="get" class="mb-3 d-flex gap-2">
                <input type="text" name="keyword" value="<?= $keyword ?>" class="form-control w-auto"
                       placeholder="">

                <button class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <form name="courseForm" id="courseForm">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <colgroup>
                            <col width="50px">
                            <col width="10%">
                            <col width="15%">
                            <col width="15%">
                            <col width="x">
                            <col width="12%">
                            <col width="10%">
                            <col width="150px">
                            <col width="100px">
                        </colgroup>
                        <thead class="table-light">
                        <tr>
                            <th style="width:50px" class="text-center">
                                <input type="checkbox" id="checkAllBox" onclick="checkAll(this.checked)">
                            </th>
                            <th class="text-center">예약번호</th>
                            <th class="text-center">카테고리</th>
                            <th class="text-center">교육명</th>
                            <th class="text-center">신청담당자/전화번호/이메일</th>

                            <th class="text-center">교육기간</th>
                            <th class="text-center">수강료</th>

                            <th class="text-center">상태</th>
                            <th class="text-center">관리</th>
                        </thead>
                        <tbody>
                        <?php foreach ($items as $key => $item): ?>
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox"
                                           name="selected_idx[]"
                                           class="chk-item"
                                           value="<?= esc($item['idx']) ?>">
                                </td>
                                <td>
                                    <a href="/AdmMaster/_reservation/write?idx=<?= $item['idx'] ?>"><?= $item['order_code'] ?></a>
                                </td>
                                <td>
                                    <a href="/AdmMaster/_reservation/write?idx=<?= $item['idx'] ?>"><?= getCodeCourse($item['course_idx']) ?></a>
                                </td>
                                <td>
                                    <a href="/AdmMaster/_reservation/write?idx=<?= $item['idx'] ?>"><?= $item['course_name'] ?></a>
                                </td>
                                <td>
                                    <div class="text-center">
                                        <?= $item['user_name'] ?>
                                        <br>
                                        <?= $item['user_mobile'] ?>
                                        <br>
                                        <?= $item['user_email'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        <?= date('Y.m.d', strtotime($item['start_date'])) ?>
                                        ~ <?= date('Y.m.d', strtotime($item['end_date'])) ?>
                                        (<?= daysBetween($item['start_date'], $item['end_date']) ?>낮)
                                        <br>
                                        <?= $item['number_lecture'] ?>/<?= $item['duration'] ?>일
                                    </div>
                                </td>
                                <td><?= $item['price'] > 0 ? number_format($item['price']) . '원' : '무료' ?></td>
                                <td>
                                    <input type="hidden" name="idx[]" value="<?= $item['idx'] ?>">
                                    <select name="status[]" id="status_<?= $item['idx'] ?>" class="form-select"
                                            onchange="change_item('<?= $item['idx'] ?>')"
                                            data-idx="<?= $item['idx'] ?>" data-old-value="<?= $item['status'] ?>">
                                        <option value="1" <?= $item['status'] == '1' ? 'selected' : '' ?>>정상
                                        </option>
                                        <option value="0" <?= $item['status'] == '0' ? 'selected' : '' ?>>마감
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="/AdmMaster/_reservation/write?idx=<?= $item['idx'] ?>"
                                           class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm"
                                                onclick="delete_it('<?= $item['idx'] ?>')">
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
    </script>
    <script>
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
            selectedIds.forEach(id => formData.append("idx[]", id));

            await processDelete(formData);
        }

        async function processDelete(formData) {
            await fetch('<?= site_url('AdmMaster/_reservation/delete') ?>', {
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

        async function change_it() {
            let frm = document.courseForm;
            let formData = new FormData(frm);
            await processChange(formData, 'A')
        }

        async function processChange(formData, type) {
            let url = '<?= site_url('AdmMaster/_reservation/change') ?>';

            await $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                    alert(response.message);
                    if (type == 'A') location.reload();
                },
                error: function (exception) {
                    alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
                    console.log(exception)
                }
            });
        }

        async function change_item(idx) {
            let formData = new FormData();

            let status = $('#status_' + idx).val();
            formData.append('idx[]', idx);
            formData.append('status[]', status);

            await processChange(formData, 'N')
        }

        async function delete_it(id) {
            if (!confirm(`해당 회원을 삭제하시겠습니까?\n삭제 후 복구할 수 없습니다.`)) {
                return false;
            }

            const formData = new FormData();
            formData.append("idx[]", id);

            await processDelete(formData);
        }
    </script>
<?= $this->endSection() ?>