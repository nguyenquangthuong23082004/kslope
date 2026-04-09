<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>

    <div class="page-heading mb-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-0">동영상 목록</h4>

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
            <a href="/AdmMaster/_video/write" class="btn btn-primary">
                <i class="bi bi-pencil-square"></i> 등록
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
                            <col width="50px">
                            <col width="x">
                            <col width="12%">
                            <col width="5%">
                            <col width="10%">
                            <col width="100px">
                            <col width="150px">
                            <col width="100px">
                            <col width="100px">
                        </colgroup>
                        <thead class="table-light">
                        <tr>
                            <th style="width:50px" class="text-center">
                                <input type="checkbox" id="checkAllBox" onclick="checkAll(this.checked)">
                            </th>
                            <th class="text-center">번호</th>
                            <th class="text-center">제목</th>
                            <th class="text-center">간략설명</th>
                            <th class="text-center">강의시간</th>
                            <th class="text-center">이미지</th>
                            <th class="text-center">생성일</th>
                            <th class="text-center">상태</th>
                            <th class="text-center">우선순위</th>
                            <th class="text-center">관리</th>
                        </thead>
                        <tbody>
                        <?php foreach ($items as $key => $item): ?>
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox"
                                           name="selected_idx[]"
                                           class="chk-item"
                                           value="<?= esc($item['video_idx']) ?>">
                                </td>
                                <td class="text-center"><?= $key + 1 ?></td>
                                <td>
                                    <a class="text-truncate" href="/AdmMaster/_video/write?video_idx=<?= $item['video_idx'] ?>"><?= $item['title'] ?></a>
                                </td>
                                <td>
                                    <p class="text-truncate"><?= $item['short_description'] ?></p>
                                </td>
                                <td class="text-center"><?= $item['duration'] ?></td>
                                <td>
                                    <a href="<?= $item['video_url'] ?>" target="_blank">
                                        <img class="mt-2" src="/uploads/video/<?= $item['ufile'] ?>"
                                             alt="<?= $item['rfile'] ?>">
                                    </a>
                                </td>
                                <td><?= date('Y.m.d', strtotime($item['created_at'])) ?></td>
                                <td>
                                    <select name="status[]" id="status_<?= $item['video_idx'] ?>" class="form-select"
                                            data-video_idx="<?= $item['video_idx'] ?>"
                                            data-old-value="<?= $item['status'] ?>">
                                        <option value="1" <?= $item['status'] == '1' ? 'selected' : '' ?>>정상
                                        </option>
                                        <option value="0" <?= $item['status'] == '0' ? 'selected' : '' ?>>마감
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="onum_<?= $item['video_idx'] ?>"
                                           name="onum[]"
                                           value="<?= $item['onum'] ?>">
                                    <input type="hidden" name="video_idx[]" id="video_idx_<?= $item['video_idx'] ?>"
                                           value="<?= $item['video_idx'] ?>">
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="/AdmMaster/_video/write?video_idx=<?= $item['video_idx'] ?>"
                                           class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm"
                                                onclick="delete_it('<?= $item['video_idx'] ?>')">
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
            selectedIds.forEach(id => formData.append("video_idx[]", id));

            await processDelete(formData);
        }

        async function processDelete(formData) {
            await fetch('<?= site_url('AdmMaster/_video/delete') ?>', {
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
            let url = '<?= site_url('AdmMaster/_video/change') ?>';

            let frm = document.courseForm;
            let formData = new FormData(frm);

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                    alert(response.message);
                    location.reload();
                },
                error: function (exception) {
                    alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
                    console.log(exception)
                }
            });
        }

        async function delete_it(id) {
            if (!confirm(`해당 회원을 삭제하시겠습니까?\n삭제 후 복구할 수 없습니다.`)) {
                return false;
            }

            const formData = new FormData();
            formData.append("video_idx[]", id);

            await processDelete(formData);
        }
    </script>
<?= $this->endSection() ?>