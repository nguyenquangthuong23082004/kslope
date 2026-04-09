<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>

    <!-- HEADER -->
    <div class="page-heading mb-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-0 fw-semibold">자동메일관리</h4>

        <div class="d-flex gap-2">
            <!-- <button type="button" onclick="change_it()" class="btn btn-success">
                <i class="bi bi-arrow-up-down"></i> 순위변경
            </button> -->

            <a href="<?= site_url('AdmMaster/_members/email_view') ?>" class="btn btn-primary">
                <i class="bi bi-plus-square"></i> 상품 등록
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="mb-3">■ 총 <?= number_format($total_count ?? 0) ?>개의 목록이 있습니다.</h5>
        
            <!-- Table -->
            <div class="table-responsive">
                <form name="frm" id="frm">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="15%" class="text-center">메일코드</th>
                                <th class="text-center">메일명</th>
                                <th width="15%" class="text-center">미리보기</th>
                                <th width="15%" class="text-center">자동발송여부</th>
                                <th width="12%" class="text-center">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($emails)): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        검색된 결과가 없습니다.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($emails as $row): ?>
                                    <tr>
                                        <td class="text-center"><?= esc($row['code']) ?></td>
                                        <td>
                                            <a href="<?= site_url('AdmMaster/_members/email_view?idx=' . $row['idx']) ?>" 
                                               class="text-decoration-none text-dark">
                                                <?= esc($row['title']) ?>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-primary btn_preview"
                                                    data-idx="<?= esc($row['idx']) ?>">
                                                <i class="bi bi-eye"></i> 미리보기
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($row['autosend'] == "Y"): ?>
                                                <span class="badge bg-success">자동발송</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">사용안함</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center" role="group">
                                                <button onclick="window.location.href='<?= site_url('AdmMaster/_members/email_view?idx=' . $row['idx']) ?>'"
                                                        type="button" 
                                                        class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil"></i> 
                                                </button>
                                                <button onclick="del_it('<?= $row['idx'] ?>');" 
                                                        type="button" 
                                                        class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i> 
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">메일 미리보기</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="previewFrame" 
                            style="width: 100%; height: 500px; border: none;" 
                            src=""></iframe>
                </div>
            </div>
        </div>
    </div>

    <script>
        function change_it() {
            $.ajax({
                url: "<?= site_url('AdmMaster/_members/email_change') ?>",
                type: "POST",
                data: $("#frm").serialize(),
                error: function (request, status, error) {
                    alert("code : " + request.status + "\r\nmessage : " + request.responseText);
                },
                success: function (response, status, request) {
                    alert(response.message);
                    if (response.result == true) {
                        location.reload();
                        return;
                    }
                }
            });
        }

        function del_it(idx) {
            if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.")) {
                handleDel(idx);
            }
        }

        function handleDel(idx) {
            $.ajax({
                url: '<?= site_url('AdmMaster/_members/email_delete') ?>',
                type: "POST",
                data: "idx[]=" + idx,
                error: function (request, status, error) {
                    alert("code : " + request.status + "\r\nmessage : " + request.responseText);
                },
                success: function (response, status, request) {
                    alert("정상적으로 삭제되었습니다.");
                    location.reload();
                    return;
                }
            });
        }

        $(document).ready(function () {
            // Preview modal
            $('.btn_preview').on('click', function () {
                var idx = $(this).data("idx");
                $("#previewFrame").prop("src", "<?= site_url('AdmMaster/_members/pre_viw_mail') ?>?idx=" + idx);
                
                var modal = new bootstrap.Modal(document.getElementById('previewModal'));
                modal.show();
            });

            // Clear iframe when modal is hidden
            $('#previewModal').on('hidden.bs.modal', function () {
                $("#previewFrame").prop("src", "");
            });
        });
    </script>

<?= $this->endSection() ?>
