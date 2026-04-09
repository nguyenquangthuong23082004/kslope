<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>

    <div class="page-heading mb-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-0 fw-semibold">견적 문의 상세</h4>

        <div class="d-flex gap-2">
            <a href="<?= site_url('AdmMaster/_quote_request/list') ?>"
                class="btn btn-outline-secondary">
                <i class="bi bi-list-task"></i> 목록
            </a>

            <button type="submit"
                form="portfolioForm"
                class="btn btn-primary">
                <i class="bi bi-gear-fill me-1"></i> 저장
            </button>
        </div>
    </div>

    <section class="section">
        <div class="col-lg-12">
            <form id="portfolioForm"
                method="post"
                action="<?= site_url('AdmMaster/_quote_request/update/' . $row['r_idx']) ?>"
                enctype="multipart/form-data"
                class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <colgroup>
                                <col width="10%">
                                <col width="40%">
                                <col width="10%">
                                <col width="40%">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th style="background-color: #d0ebff;">업체명</th>
                                    <td colspan="3">
                                        <input type="text"
                                            name="r_company"
                                            class="form-control"
                                            value="<?= esc($row['r_company']) ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d0ebff;">담당자</th>
                                    <td colspan="3">
                                        <input type="text"
                                            name="r_manager"
                                            class="form-control"
                                            value="<?= esc($row['r_manager']) ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d0ebff;">연락처</th>
                                    <td colspan="3">
                                        <?php
                                        $phoneParts = explode('-', $row['r_phone'] ?? '');
                                        $r_phone1 = $phoneParts[0] ?? '';
                                        $r_phone2 = $phoneParts[1] ?? '';
                                        $r_phone3 = $phoneParts[2] ?? '';
                                        ?>
                                        <div class="d-flex gap-2 align-items-center">
                                            <input type="text"
                                                name="r_phone1"
                                                class="form-control"
                                                style="max-width: 120px;"
                                                maxlength="3"
                                                placeholder="010"
                                                pattern="[0-9]{2,3}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                value="<?= esc($r_phone1) ?>">
                                            <span>-</span>
                                            <input type="text"
                                                name="r_phone2"
                                                class="form-control"
                                                style="max-width: 120px;"
                                                maxlength="4"
                                                placeholder=""
                                                pattern="[0-9]{3,4}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                value="<?= esc($r_phone2) ?>">
                                            <span>-</span>
                                            <input type="text"
                                                name="r_phone3"
                                                class="form-control"
                                                style="max-width: 120px;"
                                                maxlength="4"
                                                placeholder=""
                                                pattern="[0-9]{4}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                value="<?= esc($r_phone3) ?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d0ebff;">이메일</th>
                                    <td colspan="3">
                                        <input type="text"
                                            name="r_email"
                                            class="form-control"
                                            value="<?= esc($row['r_email']) ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d0ebff;">상태</th>
                                    <td colspan="3">
                                        <select name="r_status" id="r_status" class="form-select" style="height: 40px; width: 150px">
                                            <option value="Y" <?= $row['r_status'] == 'Y' ? 'selected' : '' ?>>문의접수</option>
                                            <option value="S" <?= $row['r_status'] == 'S' ? 'selected' : '' ?>>단순문의</option>
                                            <option value="H" <?= $row['r_status'] == 'H' ? 'selected' : '' ?>>취소</option>
                                            <option value="C" <?= $row['r_status'] == 'C' ? 'selected' : '' ?>>답변완료</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d0ebff;">문의 내용</th>
                                    <td colspan="3">
                                        <textarea name="r_content" id="r_content" class="form-control"
                                        rows="5"><?= $row['r_content'] ?></textarea>
                                    </td>
                                </tr>
                                
                                <!-- ✅ 첨부 파일 -->
                                <tr>
                                    <th style="background-color: #d0ebff;">첨부 파일</th>
                                    <td colspan="3">
                                        <!-- 현재 파일 표시 -->
                                        <?php if (!empty($row['r_file'])): ?>
                                            <div class="mb-3" id="currentFileWrapper">
                                                <div class="d-flex align-items-center gap-2">
                                                    <?php
                                                    $filePath = '/data/order/' . $row['r_file'];
                                                    $fileExt = strtolower(pathinfo($row['r_file'], PATHINFO_EXTENSION));
                                                    $imageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                                                    ?>
                                                    
                                                    <?php if (in_array($fileExt, $imageExts)): ?>
                                                        <!-- 이미지인 경우 미리보기 -->
                                                        <div>
                                                            <img src="<?= base_url($filePath) ?>" 
                                                                alt="첨부 이미지" 
                                                                style="max-width: 300px; max-height: 200px; border: 1px solid #ddd; border-radius: 4px;">
                                                            <div class="mt-1">
                                                                <small class="text-muted">
                                                                    <i class="bi bi-file-earmark-image"></i>
                                                                    <?= esc($row['r_file_ori'] ?? $row['r_file']) ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    <?php else: ?>
                                                        <!-- 일반 파일인 경우 -->
                                                        <div>
                                                            <i class="bi bi-file-earmark-text fs-1"></i>
                                                            <div class="mt-1">
                                                                <small class="text-muted">
                                                                    <?= esc($row['r_file_ori'] ?? $row['r_file']) ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <div>
                                                        <a href="<?= base_url($filePath) ?>" 
                                                            target="_blank" 
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-download"></i> 다운로드
                                                        </a>
                                                        <button type="button" 
                                                            class="btn btn-sm btn-outline-danger"
                                                            onclick="removeCurrentFile()">
                                                            <i class="bi bi-trash"></i> 삭제
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="mb-3 text-muted">
                                                <i class="bi bi-file-earmark-x"></i> 첨부된 파일이 없습니다.
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- 새 파일 업로드 -->
                                        <div>
                                            <input type="file" 
                                                name="r_file" 
                                                id="r_file"
                                                class="form-control"
                                                accept="image/*,.pdf,.doc,.docx,.xls,.xlsx"
                                                onchange="previewFile(this)">
                                        </div>
                                        
                                        <!-- 새 파일 미리보기 -->
                                        <div id="newFilePreview" class="mt-3" style="display: none;">
                                            <div class="alert alert-info">
                                                <strong>새 파일 미리보기:</strong>
                                                <div id="previewContent" class="mt-2"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </form>
        </div>
    </section>

    <style>
        #currentFileWrapper img {
            object-fit: contain;
        }
    </style>

    <script>
        // 현재 파일 삭제
        function removeCurrentFile() {
            if (confirm('현재 파일을 삭제하시겠습니까?')) {
                document.getElementById('currentFileWrapper').innerHTML = 
                    '<div class="text-muted"><i class="bi bi-file-earmark-x"></i> 파일이 삭제됩니다. (저장 시 적용)</div>';
                
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'delete_file';
                hiddenInput.value = '1';
                document.getElementById('portfolioForm').appendChild(hiddenInput);
            }
        }

        // function previewFile(input) {
        //     const preview = document.getElementById('newFilePreview');
        //     const previewContent = document.getElementById('previewContent');
            
        //     if (input.files && input.files[0]) {
        //         const file = input.files[0];
        //         const fileSize = (file.size / 1024 / 1024).toFixed(2); 
                
        //         if (file.size > 15 * 1024 * 1024) {
        //             alert('파일 크기가 너무 큽니다 (최대 15MB)');
        //             input.value = '';
        //             preview.style.display = 'none';
        //             return;
        //         }
                
        //         if (file.type.startsWith('image/')) {
        //             const reader = new FileReader();
        //             reader.onload = function(e) {
        //                 previewContent.innerHTML = `
        //                     <img src="${e.target.result}" 
        //                         style="max-width: 300px; max-height: 200px; border: 1px solid #ddd; border-radius: 4px;">
        //                     <div class="mt-2">
        //                         <strong>${file.name}</strong> (${fileSize} MB)
        //                     </div>
        //                 `;
        //                 preview.style.display = 'block';
        //             };
        //             reader.readAsDataURL(file);
        //         } else {
        //             previewContent.innerHTML = `
        //                 <i class="bi bi-file-earmark-text fs-1"></i>
        //                 <div class="mt-2">
        //                     <strong>${file.name}</strong> (${fileSize} MB)
        //                 </div>
        //             `;
        //             preview.style.display = 'block';
        //         }
        //     } else {
        //         preview.style.display = 'none';
        //     }
        // }
    </script>

<?= $this->endSection() ?>