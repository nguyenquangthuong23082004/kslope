<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>

    <div class="page-heading mb-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><?= $title_ ?? '' ?></h4>

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
            <a href="/AdmMaster/_bbs/write?code=<?= $code ?>" class="btn btn-primary">
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
            <form id="formSearch" name="formSearch" method="get" class="mb-3 d-flex gap-2">
                <input type="text" name="keyword" value="<?= $keyword ?>" class="form-control w-auto"
                       placeholder="제목 검색">
                <input type="hidden" name="code" value="<?= $code ?>">

                <select name="page_count" id="page_count" class="form-select w-auto" onchange="processSearch(event);">
                    <option <?= $page_count == '10' ? 'selected' : '' ?> value="10">10</option>
                    <option <?= $page_count == '20' ? 'selected' : '' ?> value="20">20</option>
                    <option <?= $page_count == '50' ? 'selected' : '' ?> value="50">50</option>
                    <option <?= $page_count == '100' ? 'selected' : '' ?> value="100">100</option>
                </select>

                <button type="button" class="btn btn-primary" onclick="processSearch(event);">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <form name="courseForm" id="courseForm">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <colgroup>
                            <col width="50px">

                            <col width="x">

                            <?php if ($code == 'competition'): ?>
                                <col width="5%">
                            <?php endif; ?>

                            <?php if ($code == 'recruitment'): ?>
                                <col width="20%">
                            <?php endif; ?>

                            <?php if ($code == 'promotion'): ?>
                                <col width="10%">
                            <?php endif; ?>

                            <col width="10%">
                            <col width="5%">

                            <?php if ($code == 'recruitment'): ?>
                                <col width="10%">
                                <col width="100px">
                                <col width="100px">
                            <?php endif; ?>

                            <col width="100px">
                            <col width="100px">
                            <col width="100px">
                        </colgroup>
                        <thead class="table-light">
                        <tr>
                            <th style="width:50px" class="text-center">
                                <input type="checkbox" id="checkAllBox" onclick="checkAll(this.checked)">
                            </th>

                            <?php if ($code == 'notice' || $code == 'promotion' || $code == 'competition' || $code == 'association' || $code == 'member_resource'): ?>
                                <th class="text-center">제목</th>
                            <?php endif; ?>

                            <?php if ($code == 'competition'): ?>
                                <th class="text-center">베스트</th>
                            <?php endif; ?>

                            <?php if ($code == 'promotion'): ?>
                                <th class="text-center">LOGO</th>
                            <?php endif; ?>

                            <?php if ($code == 'recruitment'): ?>
                                <th class="text-center">이름</th>
                                <th class="text-center">필요하다</th>
                            <?php endif; ?>

                            <th class="text-center">작성자</th>
                            <th class="text-center"><?= $code !== 'association' ? '조회' : '조회수' ?></th>

                            <?php if ($code == 'recruitment'): ?>
                                <th class="text-center">LOGO</th>
                                <th class="text-center">시작일</th>
                                <th class="text-center">종료일</th>
                            <?php endif; ?>

                            <th class="text-center">작성일</th>
                            <th class="text-center">우선순위</th>
                            <th class="text-center">관리</th>
                        </thead>
                        <tbody>
                        <?php foreach ($items as $key => $item): ?>
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox"
                                           name="selected_bbs_idx[]"
                                           class="chk-item"
                                           value="<?= esc($item['bbs_idx']) ?>">
                                </td>
                                <td>
                                    <a href="/AdmMaster/_bbs/write?bbs_idx=<?= $item['bbs_idx'] ?>&code=<?= $code ?>">
                                        <?= $item['subject'] ?>
                                    </a>
                                </td>
                                <?php if ($code == 'competition'): ?>
                                    <th class="text-center"> <?= $item['keyword'] ?></th>
                                <?php endif; ?>
                                <?php if ($code == 'promotion'): ?>
                                    <td>
                                        <img src="/uploads/bbs/<?= $item['ufile1'] ?>" alt="<?= $item['rfile1'] ?>">
                                    </td>
                                <?php endif; ?>
                                <?php if ($code == 'recruitment'): ?>
                                    <td>
                                        <p class="text-truncate"><?= $item['contents2'] ?></p>
                                    </td>
                                <?php endif; ?>
                                <td><?= $item['writer'] ?></td>
                                <td class="text-center"><?= $code !== 'association' ? number_format($item['hit']) : $item['view_count'] ?></td>

                                <?php if ($code == 'recruitment'): ?>
                                    <td>
                                        <img src="/uploads/bbs/<?= $item['ufile1'] ?>" alt="<?= $item['rfile1'] ?>">
                                    </td>
                                    <td class="text-center"><?= date('Y-m-d', strtotime($item['s_date'])) ?></td>
                                    <td class="text-center"><?= date('Y-m-d', strtotime($item['e_date'])) ?></td>
                                <?php endif; ?>

                                <td class="text-center"><?= date('Y-m-d', strtotime($item['r_date'])) ?></td>
                                <td>
                                    <input type="text" class="form-control" id="onum_<?= $item['bbs_idx'] ?>"
                                           name="onum[]"
                                           value="<?= $item['onum'] ?>">
                                    <input type="hidden" name="bbs_idx[]" id="bbs_idx_<?= $item['bbs_idx'] ?>"
                                           value="<?= $item['bbs_idx'] ?>">
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="/AdmMaster/_bbs/write?bbs_idx=<?= $item['bbs_idx'] ?>&code=<?= $code ?>"
                                           class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm"
                                                onclick="delete_it('<?= $item['bbs_idx'] ?>')">
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
        function processSearch(e) {
            e.preventDefault();
            $('#formSearch').trigger('submit');
        }
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
            selectedIds.forEach(id => formData.append("bbs_idx[]", id));

            await processDelete(formData);
        }

        async function processDelete(formData) {
            await fetch('<?= site_url('AdmMaster/_bbs/delete') ?>', {
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
            let url = '<?= site_url('AdmMaster/_bbs/change') ?>';

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
            formData.append("bbs_idx[]", id);

            await processDelete(formData);
        }
    </script>
<?= $this->endSection() ?>