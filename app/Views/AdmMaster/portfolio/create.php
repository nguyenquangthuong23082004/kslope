<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>

    <!-- HEADER -->
    <div class="page-heading mb-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-0 fw-semibold">포트폴리오 등록</h4>

        <div class="d-flex gap-2">
            <a href="<?= site_url('AdmMaster/portfolio') ?>"
               class="btn btn-outline-secondary">
                <i class="bi bi-list-task"></i> 취소
            </a>

            <button type="submit"
                    form="portfolioForm"
                    class="btn btn-primary">
                <i class="bi bi-save me-1"></i> 저장
            </button>
        </div>
    </div>

<?php if (session('error')): ?>
    <div class="alert alert-danger"><?= session('error') ?></div>
<?php endif ?>

    <form id="portfolioForm"
          method="post"
          action="<?= site_url('AdmMaster/portfolio/store') ?>"
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
                                   value="Y">
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
                                   value="<?= old('r_title') ?>"
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
                                            <?= old('r_type') == $type['code_no'] ? 'selected' : '' ?>>
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
                                   value="<?= old('r_output') ?>">
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
                                   value="<?= old('r_url') ?>">
                        </td>
                    </tr>

                    <!-- 설명 -->
                    <tr>
                        <th style="background-color: #d0ebff;">설명</th>
                        <td colspan="3">
                            <input type="text"
                                   name="browser_title"
                                   class="form-control"
                                   value="<?= old('browser_title') ?>">
                        </td>
                    </tr>

                    <tr>
                        <th style="background-color: #d0ebff;">브라우져 타이틀</th>
                        <td colspan="3">
                            <input type="text"
                                   name="meta_keyword"
                                   class="form-control"
                                   value="<?= old('meta_keyword') ?>">
                        </td>
                    </tr>

                    <tr>
                        <th style="background-color: #d0ebff;">메타 키워드</th>
                        <td colspan="3">
                            <input type="text"
                                   name="meta_title"
                                   class="form-control"
                                   value="<?= old('meta_title') ?>">
                        </td>
                    </tr>

                    <tr>
                        <th style="background-color: #d0ebff;">제목</th>
                        <td colspan="3">
                            <input type="text"
                                   name="meta_des"
                                   class="form-control"
                                   value="<?= old('meta_des') ?>">
                        </td>
                    </tr>

                    <tr>
                        <th style="background-color: #d0ebff;">설명</th>
                        <td colspan="3">
                            <textarea name="r_description"
                                      rows="4"
                                      class="form-control"><?= old('r_description') ?></textarea>
                        </td>
                    </tr>

                    <!-- 썸네일 -->
                    <tr>
                        <th style="background-color: #d0ebff;">썸네일</th>
                        <td colspan="3">
                            <input type="file" name="r_file" class="form-control">
                        </td>
                    </tr>

                    <tr>
                        <th style="background-color: #d0ebff;">상세 사진</th>
                        <td colspan="3">
                            <input type="file" name="r_file2" class="form-control">
                        </td>
                    </tr>

                    <!-- 정렬 -->
                    <tr>
                        <th style="background-color: #d0ebff;">순위</th>
                        <td>
                            <input type="number"
                                   name="r_order"
                                   class="form-control"
                                   value="<?= old('r_order', 0) ?>"
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
                                    <?= old('r_used', 'Y') === 'Y' ? 'checked' : '' ?>>
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

<?= $this->endSection() ?>