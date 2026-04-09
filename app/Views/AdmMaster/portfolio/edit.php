<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>

    <!-- HEADER -->
    <div class="page-heading mb-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-0 fw-semibold">포트폴리오 수정</h4>

        <div class="d-flex gap-2">
            <a href="<?= site_url('AdmMaster/portfolio') ?>"
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


    <form id="portfolioForm"
          method="post"
          action="<?= site_url('AdmMaster/portfolio/update/' . $row['r_idx']) ?>"
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
                    <!-- 메인노출 -->
                    <tr>
                        <th style="background-color: #d0ebff;">
                            메인노출
                        </th>
                        <td colspan="3">
                            <input type="checkbox"
                                   name="main_exposure"
                                <?= $row['main_exposure'] == 'Y' ? 'checked' : '' ?> value="Y">
                        </td>
                    </tr>

                    <!-- 제목 -->
                    <tr>
                        <th style="background-color: #d0ebff;">
                            제목 <span class="text-danger">*</span>
                        </th>
                        <td colspan="3">
                            <input type="text"
                                   name="r_title"
                                   class="form-control"
                                   value="<?= esc($row['r_title']) ?>"
                                   required>
                        </td>
                    </tr>

                    <!-- 타입 -->
                    <tr>
                        <th style="background-color: #d0ebff;">
                            타입 <span class="text-danger">*</span>
                        </th>
                        <td colspan="3">
                            <select name="r_type" class="form-select" required style="height: 40px">
                                <option value="">선택</option>
                                <?php if (!empty($typeList)): ?>
                                    <?php foreach ($typeList as $type): ?>
                                        <option value="<?= esc($type['code_no']) ?>"
                                            <?= $row['r_type'] == $type['code_no'] ? 'selected' : '' ?>>
                                            <?= esc($type['code_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </td>
                    </tr>

                    <!-- 출력 텍스트 -->
                    <tr>
                        <th style="background-color: #d0ebff;">출력 텍스트</th>
                        <td colspan="3">
                            <input type="text"
                                   name="r_output"
                                   class="form-control"
                                   value="<?= esc($row['r_output']) ?>">
                        </td>
                    </tr>

                    <!-- 사이트 URL -->
                    <tr>
                        <th style="background-color: #d0ebff;">사이트 URL</th>
                        <td colspan="3">
                            <input type="url"
                                   name="r_url"
                                   class="form-control"
                                   placeholder="https://"
                                   value="<?= esc($row['r_url']) ?>">
                        </td>
                    </tr>

                    <!-- 설명 -->
                    <tr>
                        <th style="background-color: #d0ebff;">설명</th>
                        <td colspan="3">
                            <input type="text"
                                   name="browser_title"
                                   class="form-control"
                                   value="<?= esc($row['browser_title']) ?>">
                        </td>
                    </tr>

                    <tr>
                        <th style="background-color: #d0ebff;">브라우져 타이틀</th>
                        <td colspan="3">
                            <input type="text"
                                   name="meta_keyword"
                                   class="form-control"
                                   value="<?= esc($row['meta_keyword']) ?>">
                        </td>
                    </tr>

                    <tr>
                        <th style="background-color: #d0ebff;">메타 키워드</th>
                        <td colspan="3">
                            <input type="text"
                                   name="meta_title"
                                   class="form-control"
                                   value="<?= esc($row['meta_title']) ?>">
                        </td>
                    </tr>

                    <tr>
                        <th style="background-color: #d0ebff;">제목</th>
                        <td colspan="3">
                            <input type="text"
                                   name="meta_des"
                                   class="form-control"
                                   value="<?= esc($row['meta_des']) ?>">
                        </td>
                    </tr>

                    <tr>
                        <th style="background-color: #d0ebff;">부가설명</th>
                        <td colspan="3">
                            <textarea name="r_description"
                                      rows="4"
                                      class="form-control"><?= esc($row['r_description']) ?></textarea>
                        </td>
                    </tr>

                    <!-- 썸네일 -->
                    <tr>
                        <th style="background-color: #d0ebff;">썸네일</th>
                        <td colspan="3">

                            <?php if (!empty($row['r_file'])): ?>
                                <div class="mb-3" id="thumbWrapper">
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                            <img src="<?= base_url('uploads/file/' . $row['r_file']) ?>"
                                                class="img-thumbnail"
                                                style="max-width: 300px;">
                                            <div class="mt-1">
                                                <small class="text-muted">
                                                    <i class="bi bi-file-earmark-image"></i>
                                                    <?= esc($row['r_file']) ?>
                                                </small>
                                            </div>
                                        </div>

                                        <div>
                                            <a href="<?= base_url('uploads/file/' . $row['r_file']) ?>"
                                            class="btn btn-sm btn-outline-primary"
                                            download>
                                                <i class="bi bi-download"></i> 다운로드
                                            </a>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="removeThumb()">
                                                <i class="bi bi-trash"></i> 삭제
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="mb-3 text-muted">
                                    <i class="bi bi-file-earmark-x"></i> 이미지가 없습니다.
                                </div>
                            <?php endif; ?>

                            <input type="file"
                                name="r_file"
                                class="form-control"
                                accept="image/*">
                        </td>
                    </tr>


                    <tr>
                        <th style="background-color: #d0ebff;">상세 사진</th>
                        <td colspan="3">

                            <?php if (!empty($row['r_file2'])): ?>
                                <div class="mb-3" id="detailWrapper">
                                    <div class="d-flex align-items-start gap-3">
                                        <div>
                                            <img src="<?= base_url('uploads/file/' . $row['r_file2']) ?>"
                                                class="img-thumbnail"
                                                style="max-width: 300px;">
                                            <div class="mt-1">
                                                <small class="text-muted">
                                                    <i class="bi bi-file-earmark-image"></i>
                                                    <?= esc($row['r_file2']) ?>
                                                </small>
                                            </div>
                                        </div>

                                        <div>
                                            <a href="<?= base_url('uploads/file/' . $row['r_file2']) ?>"
                                            class="btn btn-sm btn-outline-primary"
                                            download>
                                                <i class="bi bi-download"></i> 다운로드
                                            </a>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="removeDetail()">
                                                <i class="bi bi-trash"></i> 삭제
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="mb-3 text-muted">
                                    <i class="bi bi-file-earmark-x"></i> 이미지가 없습니다.
                                </div>
                            <?php endif; ?>

                            <input type="file"
                                name="r_file2"
                                class="form-control"
                                accept="image/*">
                        </td>
                    </tr>


                    <!-- 정렬 -->
                    <tr>
                        <th style="background-color: #d0ebff;">순위</th>
                        <td>
                            <input type="number"
                                   name="r_order"
                                   class="form-control"
                                   value="<?= esc($row['r_order']) ?>"
                                   style="max-width: 150px;">
                        </td>
                        <th style="background-color: #d0ebff;">노출</th>
                        <td>
                            <div class="form-check form-switch">
                                <input type="hidden" name="r_used" value="N">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="r_used"
                                       id="r_used"
                                       value="Y"
                                    <?= $row['r_used'] === 'Y' ? 'checked' : '' ?>>
                                <label class="form-check-label" for="r_used">
                                    사용
                                </label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>

        <style>
        #currentFileWrapper img {
            object-fit: contain;
        }
    </style>

    <script>
        function removeThumb() {
            if (confirm('썸네일 이미지를 삭제하시겠습니까?')) {
                document.getElementById('thumbWrapper').innerHTML =
                    '<div class="text-muted"><i class="bi bi-file-earmark-x"></i> 저장 시 삭제됩니다.</div>';

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_r_file';
                input.value = '1';
                document.getElementById('portfolioForm').appendChild(input);
            }
        }

        function removeDetail() {
            if (confirm('상세 이미지를 삭제하시겠습니까?')) {
                document.getElementById('detailWrapper').innerHTML =
                    '<div class="text-muted"><i class="bi bi-file-earmark-x"></i> 저장 시 삭제됩니다.</div>';

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_r_file2';
                input.value = '1';
                document.getElementById('portfolioForm').appendChild(input);
            }
        }

    </script>

<?= $this->endSection() ?>