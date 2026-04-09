<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>
<style>
    .form-check {
        display: flex;
        min-height: 1.5rem;
        padding-left: 1.7em;
        margin-bottom: .125rem;
        align-items: center;
        gap: 5px;
    }
</style>
    <div class="page-heading mb-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-0 fw-semibold">회원관리</h4>

        <div class="d-flex gap-2">
            <!-- <a href="<?= site_url('AdmMaster/_members/list?type=' . $row['member_type']) ?>"
               class="btn btn-outline-secondary">
                <i class="bi bi-list-task"></i> 목록
            </a> -->

            <button type="button" 
                    onclick="history.back();"
                    class="btn btn-outline-secondary">
                <i class="bi bi-list-task"></i> 목록
            </button>

            <button type="button" onclick="submitForm();"
                    form="updateForm"
                    class="btn btn-primary">
                <i class="bi bi-gear-fill me-1"></i> 저장
            </button>
        </div>
    </div>

    <section class="section">
        <div class="col-lg-12">
            <form id="updateForm"
                  name="updateForm"
                  method="post"
                  action="#!"
                  enctype="multipart/form-data"
                  class="card">
                <input type="hidden" name="m_idx" id="m_idx" value="<?= esc($row['m_idx']) ?>">
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
                            <?php if ($row['member_type'] != 'N'): ?>
                                <tr>
                                    <td colspan="4" class="text-secondary">
                                        기본정보
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <th style="background-color: #d0ebff;">아이디</th>
                                <td colspan="">
                                    <?= esc($row['user_id']) ?>
                                </td>
                                <th style="background-color: #d0ebff;">비밀번호</th>
                                <td colspan="3">
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="password"
                                               name="password"
                                               id="password"
                                               class="form-control w-25"
                                               value="">

                                        <button type="button" class="btn btn-outline-primary"
                                                onclick="changePassword();">
                                            수정
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th style="background-color: #d0ebff;">상태</th>
                                <td colspan="">
                                    <select name="status" id="status" class="form-select"
                                            style="height: 40px; width: 150px">
                                        <option value="1" <?= $row['status'] == '1' ? 'selected' : '' ?>>정상</option>
                                        <option value="0" <?= $row['status'] == '0' ? 'selected' : '' ?>>잠김</option>
                                    </select>
                                </td>
                                <th style="background-color: #d0ebff;">가입일시</th>
                                <td colspan="">
                                    <?= esc($row['r_date']) ?>
                                </td>
                            </tr>
                            <tr>
                                <th style="background-color: #d0ebff;">이메일</th>
                                <td colspan="3">
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="text"
                                               name="user_email"
                                               class="form-control w-50"
                                               value="<?= esc($row['user_email']) ?>">
                                        <div class="form-check">
                                            <input class="form-check-input" name="user_email_yn" type="checkbox"
                                                   value="Y"
                                                <?= $row['user_email_yn'] == 'Y' ? 'checked' : '' ?> id="user_email_yn">
                                            <label class="form-check-label" for="user_email_yn">
                                                정보 메일 수신
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" name="sms_yn" type="checkbox" value="Y"
                                                <?= $row['sms_yn'] == 'Y' ? 'checked' : '' ?> id="sms_yn">
                                            <label class="form-check-label" for="sms_yn">
                                                SMS 수신여부 동의함
                                            </label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <?php if ($row['member_type'] != 'N'): ?>
                                <tr>
                                    <td colspan="4" class="text-secondary">
                                        회사정보
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d0ebff;">법인명</th>
                                    <td>
                                        <input type="text"
                                               name="company_name"
                                               class="form-control"
                                               value="<?= esc($row['company_name']) ?>">
                                    </td>
                                    <th style="background-color: #d0ebff;">대표자명</th>
                                    <td>
                                        <input type="text"
                                               name="company_representative"
                                               class="form-control"
                                               value="<?= esc($row['company_representative']) ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d0ebff;">사업자등록번호(고유등록번호)</th>
                                    <td>
                                        <input type="text"
                                               name="business_number"
                                               class="form-control"
                                               value="<?= esc($row['business_number']) ?>">
                                    </td>
                                    <th style="background-color: #d0ebff;">업태</th>
                                    <td>
                                        <input type="text"
                                               name="business_type"
                                               class="form-control"
                                               value="<?= esc($row['business_type']) ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d0ebff;">업종</th>
                                    <td>
                                        <input type="text"
                                               name="business_industry"
                                               class="form-control"
                                               value="<?= esc($row['business_industry']) ?>">
                                    </td>
                                    <th style="background-color: #d0ebff;">홈페이지</th>
                                    <td>
                                        <input type="text"
                                               name="bussiness_web"
                                               class="form-control"
                                               value="<?= esc($row['bussiness_web']) ?>">
                                    </td>
                                </tr>

                                <tr>
                                    <th style="background-color: #d0ebff;">전화번호</th>
                                    <td colspan="3">
                                        <?php
                                        $phoneBusiness = explode('-', $row['business_phone'] ?? '');
                                        $b_phone1 = $phoneBusiness[0] ?? '';
                                        $b_phone2 = $phoneBusiness[1] ?? '';
                                        $b_phone3 = $phoneBusiness[2] ?? '';
                                        ?>
                                        <div class="d-flex gap-2 align-items-center">
                                            <input type="text"
                                                name="b_phone1"
                                                class="form-control"
                                                style="max-width: 120px;"
                                                maxlength="3"
                                                placeholder="010"
                                                pattern="[0-9]{2,3}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                value="<?= esc($b_phone1) ?>">
                                            <span>-</span>
                                            <input type="text"
                                                name="b_phone2"
                                                class="form-control"
                                                style="max-width: 120px;"
                                                maxlength="4"
                                                placeholder=""
                                                pattern="[0-9]{3,4}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                value="<?= esc($b_phone2) ?>">
                                            <span>-</span>
                                            <input type="text"
                                                name="b_phone3"
                                                class="form-control"
                                                style="max-width: 120px;"
                                                maxlength="4"
                                                placeholder=""
                                                pattern="[0-9]{4}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                value="<?= esc($b_phone3) ?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d0ebff;">주소</th>
                                    <td colspan="3">
                                        <div class="d-flex gap-2 align-items-center">
                                            <input type="text" name="zip" id="sample2_postcode" placeholder=""
                                                class="form-control" style="width:100px;"
                                                value="<?= esc($row['zip']) ?>">
                                            <button type="button" onclick="openPostCode()"
                                                    class="zip_btn btn btn-outline-dark">우편번호
                                            </button>
                                            <input type="text" name="addr1" id="sample2_address" placeholder=""
                                                class="form-control" style="width:40%;"
                                                value="<?= esc($row['addr1']) ?>">
                                            <input type="text" name="addr2" id="sample2_detailAddress" placeholder=""
                                                class="form-control" style="width:20%;"
                                                value="<?= esc($row['addr2']) ?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr style="display: none">
                                    <th style="background-color: #d0ebff;">사업자등록증</th>
                                    <td colspan="3">
                                        <!-- 현재 파일 표시 -->
                                        <?php if (!empty($row['company_file'])): ?>
                                            <div class="mb-3" id="currentFileWrapper">
                                                <div class="d-flex align-items-center gap-2">
                                                    <?php
                                                    $filePath = '/uploads/member/' . $row['company_file'];
                                                    $fileExt = strtolower(pathinfo($row['company_file'], PATHINFO_EXTENSION));
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
                                                                    <?= esc($row['company_file_ori'] ?? $row['company_file']) ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    <?php else: ?>
                                                        <!-- 일반 파일인 경우 -->
                                                        <div>
                                                            <i class="bi bi-file-earmark-text fs-1"></i>
                                                            <div class="mt-1">
                                                                <small class="text-muted">
                                                                    <?= esc($row['company_file_ori'] ?? $row['company_file']) ?>
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
                                                   name="company_file"
                                                   id="company_file"
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
                            <?php endif; ?>
                            <?php if ($row['member_type'] != 'N'): ?>
                                <tr>
                                    <td colspan="4" class="text-secondary">
                                        담당자정보
                                    </td>
                                </tr>
                                <tr style="display: none">
                                    <th style="background-color: #d0ebff;">아이디</th>
                                    <td colspan="">
                                        <div class="d-flex gap-2 align-items-center">
                                            <input type="text"
                                                   id="manager_id"
                                                   name="manager_id"
                                                <?php if ($row['manager_id']): ?>
                                                    readonly
                                                <?php endif; ?>
                                                   class="form-control w-25 <?= $row['manager_id'] ? 'bg-secondary bg-opacity-25' : ''?> "
                                                   value="<?= esc($row['manager_id']) ?>">
                                            <input type="hidden" name="check_manager_id" id="check_manager_id"
                                                   value="N">

                                            <?php if (!$row['manager_id']): ?>
                                                <button type="button" id="btnChkID" onclick="chkID()"
                                                        class="btn btn-outline-primary">
                                                    중복확인
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <th style="background-color: #d0ebff;">비밀번호</th>
                                    <td colspan="3">
                                        <div class="d-flex gap-2 align-items-center">
                                            <input type="password"
                                                   id="manager_pw"
                                                   name="manager_pw"
                                                   class="form-control w-25"
                                                   value="">
                                            <?php if ($row['manager_id']): ?>
                                                <button type="button" class="btn btn-outline-primary"
                                                        onclick="savePassword();">
                                                    수정
                                                </button>
                                            <?php endif; ?>

                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <th style="background-color: #d0ebff;">성명</th>
                                <td colspan="">
                                    <input type="text"
                                           name="user_name"
                                           class="form-control"
                                           value="<?= esc($row['user_name']) ?>">
                                </td>
                                <th style="background-color: #d0ebff;">직책</th>
                                <td colspan="">
                                    <input type="text"
                                           name="work_position"
                                           class="form-control"
                                           value="<?= esc($row['work_position']) ?>">
                                </td>
                            </tr>
                            <?php if ($row['member_type'] != 'N'): ?>
                            <tr>
                                <th style="background-color: #d0ebff;">부서</th>
                                <td colspan="3">
                                    <input type="text"
                                            name="user_department"
                                            class="form-control"
                                            value="<?= esc($row['user_department']) ?>">
                                </td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <!-- <th style="background-color: #d0ebff;">사무실 전화번호</th>
                                <td colspan="">
                                    <?php
                                    $phoneParts = explode('-', $row['user_phone'] ?? '');
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
                                </td> -->
                                <th style="background-color: #d0ebff;">휴대번호</th>
                                <td colspan="3">
                                    <?php
                                    $phoneParts = explode('-', $row['user_mobile'] ?? '');
                                    $m_phone1 = $phoneParts[0] ?? '';
                                    $m_phone2 = $phoneParts[1] ?? '';
                                    $m_phone3 = $phoneParts[2] ?? '';
                                    ?>
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="text"
                                               name="m_phone1"
                                               class="form-control"
                                               style="max-width: 120px;"
                                               maxlength="3"
                                               placeholder="010"
                                               pattern="[0-9]{2,3}"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                               value="<?= esc($m_phone1) ?>">
                                        <span>-</span>
                                        <input type="text"
                                               name="m_phone2"
                                               class="form-control"
                                               style="max-width: 120px;"
                                               maxlength="4"
                                               placeholder=""
                                               pattern="[0-9]{3,4}"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                               value="<?= esc($m_phone2) ?>">
                                        <span>-</span>
                                        <input type="text"
                                               name="m_phone3"
                                               class="form-control"
                                               style="max-width: 120px;"
                                               maxlength="4"
                                               placeholder=""
                                               pattern="[0-9]{4}"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                               value="<?= esc($m_phone3) ?>">
                                    </div>
                                </td>
                            </tr>
                            <?php if ($row['member_type'] == 'N') { ?>
                                <?php if (isset($showCourseSelect) && $showCourseSelect === true) { ?>
                                <tr>
                                    <th style="background-color: #d0ebff;">교육 수강</th>
                                    <td colspan="3">
                                        <div style="max-height: 250px; overflow-y: auto; border: 1px solid #dee2e6; padding: 15px; border-radius: 4px; background-color: #f8f9fa;">
                                            <?php if(isset($courses) && !empty($courses)): ?>
                                                <div class="form-check mb-3 pb-2" style="border-bottom: 2px solid #dee2e6;">
                                                    <input class="form-check-input" 
                                                        type="checkbox" 
                                                        id="select_all_courses"
                                                        onclick="toggleAllCourses(this)">
                                                    <label class="form-check-label fw-bold" for="select_all_courses">
                                                        전체 선택
                                                    </label>
                                                </div>
                                                
                                                <?php foreach($courses as $course): ?>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input course-checkbox" 
                                                            type="checkbox" 
                                                            name="course_idx[]" 
                                                            value="<?= esc($course['idx']) ?>" 
                                                            id="course_<?= esc($course['idx']) ?>"
                                                            <?= in_array($course['idx'], $selectedCourses ?? []) ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="course_<?= esc($course['idx']) ?>">
                                                            <?= esc($course['course_name']) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <p class="text-muted mb-0">사용 가능한 교육 과정이 없습니다.</p>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                    
                                    <script>
                                    function toggleAllCourses(source) {
                                        var checkboxes = document.querySelectorAll('.course-checkbox');
                                        checkboxes.forEach(function(checkbox) {
                                            checkbox.checked = source.checked;
                                        });
                                    }
                                    
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var courseCheckboxes = document.querySelectorAll('.course-checkbox');
                                        var selectAllCheckbox = document.getElementById('select_all_courses');
                                        
                                        if (courseCheckboxes.length > 0 && selectAllCheckbox) {
                                            courseCheckboxes.forEach(function(checkbox) {
                                                checkbox.addEventListener('change', function() {
                                                    var allChecked = Array.from(courseCheckboxes).every(cb => cb.checked);
                                                    selectAllCheckbox.checked = allChecked;
                                                });
                                            });
                                            
                                            var allChecked = Array.from(courseCheckboxes).every(cb => cb.checked);
                                            selectAllCheckbox.checked = allChecked;
                                        }
                                    });
                                    </script>
                                <?php } ?>
                            <?php } ?>

                            </tbody>
                        </table>

                        <?php if ($row['member_type'] == 'N'): ?>
                        <table class="table table-bordered align-middle">
                            <colgroup>
                                <col width="10%">
                                <col width="10%">
                                <col width="80%">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td colspan="3" class="text-secondary">
                                        정보 추가
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d0ebff;">개인회원 종류</th>
                                    <td colspan="2">
                                        <select name="membership_type" id="membership_type" class="form-select"
                                            style="height: 40px; width: 250px">
                                            <option value="일반" <?= $row['membership_type'] == '일반' ? 'selected' : '' ?>>일반</option>
                                            <option value="종신" <?= $row['membership_type'] == '종신' ? 'selected' : '' ?>>종신</option>
                                            <option value="명예" <?= $row['membership_type'] == '명예' ? 'selected' : '' ?>>명예</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d0ebff;">증명사진</th>
                                    <td colspan="2">
                                        <!-- 현재 파일 표시 -->
                                        <?php if (!empty($row['membership_photo'])): ?>
                                            <div class="mb-3" id="currentFileWrapper">
                                                <div class="d-flex align-items-center gap-2">
                                                    <?php
                                                    $filePath = '/uploads/member/' . $row['membership_photo'];
                                                    $fileExt = strtolower(pathinfo($row['membership_photo'], PATHINFO_EXTENSION));
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
                                                                    <?= esc($row['membership_photo_ori'] ?? $row['membership_photo']) ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    <?php else: ?>
                                                        <!-- 일반 파일인 경우 -->
                                                        <div>
                                                            <i class="bi bi-file-earmark-text fs-1"></i>
                                                            <div class="mt-1">
                                                                <small class="text-muted">
                                                                    <?= esc($row['membership_photo_ori'] ?? $row['membership_photo']) ?>
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
                                                   name="membership_photo"
                                                   id="membership_photo"
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
                                <tr>
                                    <th style="background-color: #d0ebff;" rowspan="3">소속</th>
                                    <th style="background-color: #9fc5df;">기관 / 직위</th>
                                    <td>
                                        <input type="text"
                                               name="membership_organization"
                                               class="form-control"
                                               value="<?= esc($row['membership_organization']) ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #9fc5df;">주소</th>
                                    <td>
                                        <div class="d-flex gap-2 align-items-center">
                                        <input type="text" name="membership_zip" id="sample2_postcode2" placeholder=""
                                               class="form-control" style="width:100px;"
                                               value="<?= esc($row['membership_zip']) ?>">
                                        <button type="button" onclick="openPostCode2()"
                                                class="zip_btn btn btn-outline-dark">우편번호
                                        </button>
                                        <input type="text" name="membership_addr1" id="sample2_address2" placeholder=""
                                               class="form-control" style="width:40%;"
                                               value="<?= esc($row['membership_addr1']) ?>">
                                        <input type="text" name="membership_addr2" id="sample2_detailAddress2" placeholder=""
                                               class="form-control" style="width:20%;"
                                               value="<?= esc($row['membership_addr2']) ?>">
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #9fc5df;">전화번호</th>
                                    <td>
                                    <?php
                                    $phoneMemberShip = explode('-', $row['membership_phone'] ?? '');
                                    $s_phone1 = $phoneMemberShip[0] ?? '';
                                    $s_phone2 = $phoneMemberShip[1] ?? '';
                                    $s_phone3 = $phoneMemberShip[2] ?? '';
                                    ?>
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="text"
                                               name="s_phone1"
                                               class="form-control"
                                               style="max-width: 120px;"
                                               maxlength="3"
                                               placeholder="010"
                                               pattern="[0-9]{2,3}"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                               value="<?= esc($s_phone1) ?>">
                                        <span>-</span>
                                        <input type="text"
                                               name="s_phone2"
                                               class="form-control"
                                               style="max-width: 120px;"
                                               maxlength="4"
                                               placeholder=""
                                               pattern="[0-9]{3,4}"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                               value="<?= esc($s_phone2) ?>">
                                        <span>-</span>
                                        <input type="text"
                                               name="s_phone3"
                                               class="form-control"
                                               style="max-width: 120px;"
                                               maxlength="4"
                                               placeholder=""
                                               pattern="[0-9]{4}"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                               value="<?= esc($s_phone3) ?>">
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d0ebff;" rowspan="1">학력</th>
                                    <td colspan="2">
                                        <div id="education-container-admin">
                                            <?php if (!empty($educations)): ?>
                                                <?php foreach ($educations as $index => $education): ?>
                                                    <div class="education-item-admin mb-3 p-3 border rounded">
                                                        <div class="row g-2">
                                                            <div class="col-md-3">
                                                                <label class="form-label">기 간<?= $index > 0 ? ($index + 1) : '' ?></label>
                                                                <input type="text" 
                                                                    name="membership_period[]" 
                                                                    class="form-control"
                                                                    value="<?= esc($education['membership_period']) ?>">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">학교명<?= $index > 0 ? ($index + 1) : '' ?></label>
                                                                <input type="text" 
                                                                    name="membership_school[]" 
                                                                    class="form-control"
                                                                    value="<?= esc($education['membership_school']) ?>">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">학과명<?= $index > 0 ? ($index + 1) : '' ?></label>
                                                                <input type="text" 
                                                                    name="membership_department[]" 
                                                                    class="form-control"
                                                                    value="<?= esc($education['membership_department']) ?>">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="form-label">학위<?= $index > 0 ? ($index + 1) : '' ?></label>
                                                                <input type="text" 
                                                                    name="membership_degree[]" 
                                                                    class="form-control"
                                                                    value="<?= esc($education['membership_degree']) ?>">
                                                            </div>
                                                            <div class="col-md-1 d-flex align-items-end">
                                                                <?php if ($index > 0): ?>
                                                                    <button type="button" 
                                                                            class="btn btn-sm btn-danger w-100" 
                                                                            onclick="removeEducationAdmin(this)">삭제</button>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="education-item-admin mb-3 p-3 border rounded">
                                                    <div class="row g-2">
                                                        <div class="col-md-3">
                                                            <label class="form-label">기 간</label>
                                                            <input type="text" name="membership_period[]" class="form-control">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">학교명</label>
                                                            <input type="text" name="membership_school[]" class="form-control">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">학과명</label>
                                                            <input type="text" name="membership_department[]" class="form-control">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">학위</label>
                                                            <input type="text" name="membership_degree[]" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="addEducationAdmin()">
                                            <i class="bi bi-plus-circle"></i> 학력 추가
                                        </button>
                                    </td>
                                </tr>
                                    
                                <tr>
                                    <th style="background-color: #d0ebff;" rowspan="1">주요경력</th>
                                    <td colspan="2">
                                        <div id="career-container-admin">
                                            <?php if (!empty($careers)): ?>
                                                <?php foreach ($careers as $index => $career): ?>
                                                    <div class="career-item-admin mb-3 p-3 border rounded">
                                                        <div class="row g-2">
                                                            <div class="col-md-3">
                                                                <label class="form-label">기 간<?= $index > 0 ? ($index + 1) : '' ?></label>
                                                                <input type="text" 
                                                                    name="active_period[]" 
                                                                    class="form-control"
                                                                    value="<?= esc($career['active_period']) ?>">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">소속<?= $index > 0 ? ($index + 1) : '' ?></label>
                                                                <input type="text" 
                                                                    name="active_affiliation[]" 
                                                                    class="form-control"
                                                                    value="<?= esc($career['active_affiliation']) ?>">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="form-label">담당부서<?= $index > 0 ? ($index + 1) : '' ?></label>
                                                                <input type="text" 
                                                                    name="active_department[]" 
                                                                    class="form-control"
                                                                    value="<?= esc($career['active_department']) ?>">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">직위<?= $index > 0 ? ($index + 1) : '' ?></label>
                                                                <input type="text" 
                                                                    name="active_position[]" 
                                                                    class="form-control"
                                                                    value="<?= esc($career['active_position']) ?>">
                                                            </div>
                                                            <div class="col-md-1 d-flex align-items-end">
                                                                <?php if ($index > 0): ?>
                                                                    <button type="button" 
                                                                            class="btn btn-sm btn-danger w-100" 
                                                                            onclick="removeCareerAdmin(this)">삭제</button>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="career-item-admin mb-3 p-3 border rounded">
                                                    <div class="row g-2">
                                                        <div class="col-md-3">
                                                            <label class="form-label">기 간</label>
                                                            <input type="text" name="active_period[]" class="form-control">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">소속</label>
                                                            <input type="text" name="active_affiliation[]" class="form-control">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">담당부서</label>
                                                            <input type="text" name="active_department[]" class="form-control">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">직위</label>
                                                            <input type="text" name="active_position[]" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="addCareerAdmin()">
                                            <i class="bi bi-plus-circle"></i> 경력 추가
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d0ebff;" rowspan="1">대외활동</th>
                                    <td colspan="2">
                                        <div id="extra-container-admin">
                                            <?php if (!empty($extras)): ?>
                                                <?php foreach ($extras as $index => $extra): ?>
                                                    <div class="extra-item-admin mb-3 p-3 border rounded">
                                                        <div class="row g-2">
                                                            <div class="col-md-5">
                                                                <label class="form-label">기간<?= $index > 0 ? ($index + 1) : '' ?></label>
                                                                <input type="text" 
                                                                    name="extra_period[]" 
                                                                    class="form-control"
                                                                    value="<?= esc($extra['extra_period']) ?>">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">소속<?= $index > 0 ? ($index + 1) : '' ?></label>
                                                                <input type="text" 
                                                                    name="extra_affiliation[]" 
                                                                    class="form-control"
                                                                    value="<?= esc($extra['extra_affiliation']) ?>">
                                                            </div>
                                                            <div class="col-md-1 d-flex align-items-end">
                                                                <?php if ($index > 0): ?>
                                                                    <button type="button" 
                                                                            class="btn btn-sm btn-danger w-100" 
                                                                            onclick="removeExtraAdmin(this)">삭제</button>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="extra-item-admin mb-3 p-3 border rounded">
                                                    <div class="row g-2">
                                                        <div class="col-md-6">
                                                            <label class="form-label">기간</label>
                                                            <input type="text" name="extra_period[]" class="form-control">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">소속</label>
                                                            <input type="text" name="extra_affiliation[]" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="addExtraAdmin()">
                                            <i class="bi bi-plus-circle"></i> 대외활동 추가
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d0ebff;" rowspan="1">자격사항</th>
                                    <td colspan="2">
                                        <div id="qualification-container-admin">
                                            <?php if (!empty($qualifications)): ?>
                                                <?php foreach ($qualifications as $index => $qualification): ?>
                                                    <div class="qualification-item-admin mb-3 p-3 border rounded">
                                                        <div class="row g-2">
                                                            <div class="col-md-11">
                                                                <label class="form-label">자격증명<?= $index > 0 ? ($index + 1) : '' ?></label>
                                                                <input type="text" 
                                                                    name="membership_qualification[]" 
                                                                    class="form-control"
                                                                    value="<?= esc($qualification['membership_qualification']) ?>">
                                                            </div>
                                                            <div class="col-md-1 d-flex align-items-end">
                                                                <?php if ($index > 0): ?>
                                                                    <button type="button" 
                                                                            class="btn btn-sm btn-danger w-100" 
                                                                            onclick="removeQualificationAdmin(this)">삭제</button>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="qualification-item-admin mb-3 p-3 border rounded">
                                                    <div class="row g-2">
                                                        <div class="col-md-12">
                                                            <label class="form-label">자격증명</label>
                                                            <input type="text" name="membership_qualification[]" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="addQualificationAdmin()">
                                            <i class="bi bi-plus-circle"></i> 자격사항 추가
                                        </button>
                                    </td>
                                </tr>
                                <tr style="display: none">
                                    <th style="background-color: #9fc5df;">사진 전문가</th>
                                    <td>
                                        <!-- 현재 파일 표시 -->
                                        <?php if (!empty($row['qualification_file'])): ?>
                                            <div class="mb-3" id="currentFileWrapper">
                                                <div class="d-flex align-items-center gap-2">
                                                    <?php
                                                    $filePath = '/uploads/member/' . $row['qualification_file'];
                                                    $fileExt = strtolower(pathinfo($row['qualification_file'], PATHINFO_EXTENSION));
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
                                                                    <?= esc($row['qualification_file_ori'] ?? $row['qualification_file']) ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    <?php else: ?>
                                                        <!-- 일반 파일인 경우 -->
                                                        <div>
                                                            <i class="bi bi-file-earmark-text fs-1"></i>
                                                            <div class="mt-1">
                                                                <small class="text-muted">
                                                                    <?= esc($row['qualification_file_ori'] ?? $row['qualification_file']) ?>
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
                                                   name="qualification_file"
                                                   id="qualification_file"
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
                        <?php endif; ?>
                        <?php if ($row['member_type'] == 'G'): ?>
                        <table class="table table-bordered align-middle">
                            <colgroup>
                                <col width="10%">
                                <col width="10%">
                                <col width="80%">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td colspan="3" class="text-secondary">
                                        청보추가
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d0ebff;">단체회원 종류</th>
                                    <td colspan="2">
                                        <select name="membership_type" id="membership_type" class="form-select"
                                            style="height: 40px; width: 250px">
                                            <option value="일반" <?= $row['membership_type'] == '일반' ? 'selected' : '' ?>>일반</option>
                                            <option value="종신 (가급)" <?= $row['membership_type'] == '종신 (가급)' ? 'selected' : '' ?>>종신 (가급)</option>
                                            <option value="종신 (나급)" <?= $row['membership_type'] == '종신 (나급)' ? 'selected' : '' ?>>종신 (나급)</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d0ebff;">증명사진</th>
                                    <td colspan="2">
                                        <!-- 현재 파일 표시 -->
                                        <?php if (!empty($row['membership_photo'])): ?>
                                            <div class="mb-3" id="currentFileWrapper">
                                                <div class="d-flex align-items-center gap-2">
                                                    <?php
                                                    $filePath = '/uploads/member/' . $row['membership_photo'];
                                                    $fileExt = strtolower(pathinfo($row['membership_photo'], PATHINFO_EXTENSION));
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
                                                                    <?= esc($row['membership_photo_ori'] ?? $row['membership_photo']) ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    <?php else: ?>
                                                        <!-- 일반 파일인 경우 -->
                                                        <div>
                                                            <i class="bi bi-file-earmark-text fs-1"></i>
                                                            <div class="mt-1">
                                                                <small class="text-muted">
                                                                    <?= esc($row['membership_photo_ori'] ?? $row['membership_photo']) ?>
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
                                                   name="membership_photo"
                                                   id="membership_photo"
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
                                <tr>
                                    <th style="background-color: #d0ebff;">단체소개</th>
                                    <td colspan="2">
                                        <textarea name="group_introduction" id="group_introduction" rows="6" class="form-control"><?= $row['group_introduction']?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d0ebff;">주요 연혁</th>
                                    <td colspan="2">
                                        <textarea name="group_history" id="group_history" rows="6" class="form-control"><?= $row['group_history']?></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?php endif; ?>
                        <?php if ($row['member_type'] == 'S'): ?>
                        <table class="table table-bordered align-middle">
                            <colgroup>
                                <col width="10%">
                                <col width="10%">
                                <col width="80%">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td colspan="3" class="text-secondary">
                                        정보 추가
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d0ebff;">정보 추가</th>
                                    <td colspan="2">
                                        <select name="membership_type" id="membership_type" class="form-select"
                                            style="height: 40px; width: 250px">
                                            <option value="정부" <?= $row['membership_type'] == '정부' ? 'selected' : '' ?>>정부</option>
                                            <option value="지방자치단체" <?= $row['membership_type'] == '지방자치단체' ? 'selected' : '' ?>>지방자치단체</option>
                                            <option value="기관" <?= $row['membership_type'] == '기관' ? 'selected' : '' ?>>기관</option>
                                            <option value="기타" <?= $row['membership_type'] == '기타' ? 'selected' : '' ?>>기타</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d0ebff;" rowspan="3">기관 기본 정보</th>
                                    <th style="background-color: #9fc5df;">기관명</th>
                                    <td>
                                        <input type="text"
                                               name="organization_name"
                                               class="form-control"
                                               value="<?= esc($row['organization_name']) ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #9fc5df;">기관장성명</th>
                                    <td>
                                        <input type="text"
                                               name="organization_director"
                                               class="form-control"
                                               value="<?= esc($row['organization_director']) ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #9fc5df;">주소</th>
                                    <td>
                                        <div class="d-flex gap-2 align-items-center">
                                        <input type="text" name="organization_zip" id="sample2_postcode2" placeholder=""
                                               class="form-control" style="width:100px;"
                                               value="<?= esc($row['organization_zip']) ?>">
                                        <button type="button" onclick="openPostCode2()"
                                                class="zip_btn btn btn-outline-dark">우편번호
                                        </button>
                                        <input type="text" name="organization_addr1" id="sample2_address2" placeholder=""
                                               class="form-control" style="width:40%;"
                                               value="<?= esc($row['organization_addr1']) ?>">
                                        <input type="text" name="organization_addr2" id="sample2_detailAddress2" placeholder=""
                                               class="form-control" style="width:20%;"
                                               value="<?= esc($row['organization_addr2']) ?>">
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d0ebff;" rowspan="3">담당부서 정보</th>
                                    <th style="background-color: #9fc5df;">부서명</th>
                                    <td>
                                        <input type="text"
                                               name="department_name"
                                               class="form-control"
                                               value="<?= esc($row['department_name']) ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #9fc5df;">과장 성명</th>
                                    <td>
                                        <input type="text"
                                               name="manager_name"
                                               class="form-control"
                                               value="<?= esc($row['manager_name']) ?>">
                                    </td>
                                </tr>

                                <tr>
                                    <th style="background-color: #9fc5df;">전화번호</th>
                                    <td>
                                    <?php
                                    $phoneManager = explode('-', $row['manager_phone'] ?? '');
                                    $m_mobile1 = $phoneManager[0] ?? '';
                                    $m_mobile2 = $phoneManager[1] ?? '';
                                    $m_mobile3 = $phoneManager[2] ?? '';
                                    ?>
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="text"
                                               name="m_mobile1"
                                               class="form-control"
                                               style="max-width: 120px;"
                                               maxlength="3"
                                               placeholder="010"
                                               pattern="[0-9]{2,3}"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                               value="<?= esc($m_mobile1) ?>">
                                        <span>-</span>
                                        <input type="text"
                                               name="m_mobile2"
                                               class="form-control"
                                               style="max-width: 120px;"
                                               maxlength="4"
                                               placeholder=""
                                               pattern="[0-9]{3,4}"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                               value="<?= esc($m_mobile2) ?>">
                                        <span>-</span>
                                        <input type="text"
                                               name="m_mobile3"
                                               class="form-control"
                                               style="max-width: 120px;"
                                               maxlength="4"
                                               placeholder=""
                                               pattern="[0-9]{4}"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                               value="<?= esc($m_mobile3) ?>">
                                    </div>
                                    </td>
                                </tr>
                               
                                <tr>
                                    <th style="background-color: #d0ebff;" rowspan="4">담당자 정보</th>
                                    <th style="background-color: #9fc5df;">성명</th>
                                    <td>
                                        <input type="text"
                                               name="member_name"
                                               class="form-control"
                                               value="<?= esc($row['member_name']) ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #9fc5df;">전화번호</th>
                                    <td>
                                    <?php
                                    $phoneMembers = explode('-', $row['member_phone'] ?? '');
                                    $me_mobile1 = $phoneMembers[0] ?? '';
                                    $me_mobile2 = $phoneMembers[1] ?? '';
                                    $me_mobile3 = $phoneMembers[2] ?? '';
                                    ?>
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="text"
                                               name="me_mobile1"
                                               class="form-control"
                                               style="max-width: 120px;"
                                               maxlength="3"
                                               placeholder="010"
                                               pattern="[0-9]{2,3}"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                               value="<?= esc($me_mobile1) ?>">
                                        <span>-</span>
                                        <input type="text"
                                               name="me_mobile2"
                                               class="form-control"
                                               style="max-width: 120px;"
                                               maxlength="4"
                                               placeholder=""
                                               pattern="[0-9]{3,4}"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                               value="<?= esc($me_mobile2) ?>">
                                        <span>-</span>
                                        <input type="text"
                                               name="me_mobile3"
                                               class="form-control"
                                               style="max-width: 120px;"
                                               maxlength="4"
                                               placeholder=""
                                               pattern="[0-9]{4}"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                               value="<?= esc($me_mobile3) ?>">
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #9fc5df;">이메일</th>
                                    <td>
                                        <input type="text"
                                               name="member_email"
                                               class="form-control"
                                               value="<?= esc($row['member_email']) ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="background-color: #9fc5df;">증명사진</th>
                                    <td>
                                        <!-- 현재 파일 표시 -->
                                        <?php if (!empty($row['membership_photo'])): ?>
                                            <div class="mb-3" id="currentFileWrapper">
                                                <div class="d-flex align-items-center gap-2">
                                                    <?php
                                                    $filePath = '/uploads/member/' . $row['membership_photo'];
                                                    $fileExt = strtolower(pathinfo($row['membership_photo'], PATHINFO_EXTENSION));
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
                                                                    <?= esc($row['membership_photo_ori'] ?? $row['membership_photo']) ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    <?php else: ?>
                                                        <!-- 일반 파일인 경우 -->
                                                        <div>
                                                            <i class="bi bi-file-earmark-text fs-1"></i>
                                                            <div class="mt-1">
                                                                <small class="text-muted">
                                                                    <?= esc($row['membership_photo_ori'] ?? $row['membership_photo']) ?>
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
                                                   name="membership_photo"
                                                   id="membership_photo"
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
                        <?php endif; ?>

                        <?php if ($row['member_type'] != 'N'): ?>
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center" style="background-color: #fff !important" >
                                        <h5 class="mb-0">
                                            <i class="bi bi-people-fill me-2"></i>
                                            직원 관리 목록 (<?= count($staffList) ?>명)
                                        </h5>
                                        <a href="/AdmMaster/_members/member_staff?user_id=<?= $row['user_id'] ?>" 
                                        class="btn btn-sm btn-success">
                                            <i class="bi bi-person-plus"></i> 직원 등록
                                        </a>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered mb-0">
                                                <thead class="table-light">
                                                    <tr class="text-center">
                                                        <th width="60px">No</th>
                                                        <th width="120px">아이디</th>
                                                        <th width="120px">성명</th>
                                                        <th width="150px">이메일</th>
                                                        <th width="120px">휴대폰</th>
                                                        <th width="100px">직책</th>
                                                        <th width="120px">등록일</th>
                                                        <th width="150px">관리</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($staffList as $index => $staff): ?>
                                                        <tr>
                                                            <td class="text-center"><?= $index + 1 ?></td>
                                                            <td><?= esc($staff['user_id']) ?></td>
                                                            <td><?= esc($staff['user_name']) ?></td>
                                                            <td><?= esc($staff['user_email']) ?></td>
                                                            <td><?= esc($staff['user_mobile']) ?></td>
                                                            <td><?= esc($staff['work_position']) ?></td>
                                                            <td class="text-center">
                                                                <?= date('Y-m-d', strtotime($staff['r_date'])) ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="d-flex gap-1 justify-content-center">
                                                                    <a href="/AdmMaster/_members/write?m_idx=<?= $staff['m_idx'] ?>&type=N" 
                                                                    class="btn btn-sm btn-primary"
                                                                    title="수정">
                                                                        <i class="bi bi-pencil"></i>
                                                                    </a>
                                                                    <button type="button" 
                                                                            onclick="deleteStaff('<?= $staff['m_idx'] ?>', '<?= $staff['user_name'] ?>')" 
                                                                            class="btn btn-sm btn-danger"
                                                                            title="삭제">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                    </div>
                </div>

            </form>
        </div>

        <div class="mt-4 d-flex justify-content-end align-items-center">
            <div class="d-flex gap-2">
                <!-- <a href="<?= site_url('AdmMaster/_members/list?type=' . $row['member_type']) ?>"
                   class="btn btn-outline-secondary">
                    <i class="bi bi-list-task"></i> 목록
                </a> -->
                <button type="button" 
                        onclick="history.back();"
                        class="btn btn-outline-secondary">
                    <i class="bi bi-list-task"></i> 목록
                </button>

                <button type="button" onclick="submitForm();"
                        form="updateForm"
                        class="btn btn-primary">
                    <i class="bi bi-gear-fill me-1"></i> 저장
                </button>
            </div>
        </div>
    </section>
    <div id="layer" style="display:none;position:fixed;overflow:hidden;z-index:1999;-webkit-overflow-scrolling:touch;">
        <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer"
             style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()"
             alt="닫기 버튼">
    </div>
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <style>
        #currentFileWrapper img {
            object-fit: contain;
        }
    </style>
    <script>
    function deleteStaff(m_idx, userName) {
        if (!confirm(`"${userName}" 직원을 삭제하시겠습니까?\n\n이 작업은 되돌릴 수 없습니다.`)) {
            return;
        }
        
        $.ajax({
            url: '/AdmMaster/_members/delete',
            type: 'POST',
            data: { m_idx: [m_idx] },
            success: function(response) {
                alert(response.message || '삭제되었습니다.');
                window.location.reload();
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || '삭제 중 오류가 발생했습니다.');
            }
        });
    }
    </script>
    <script>
        function addEducationAdmin() {
            const container = document.getElementById('education-container-admin');
            const itemNumber = container.children.length + 1;
            const educationItem = document.createElement('div');
            educationItem.className = 'education-item-admin mb-3 p-3 border rounded';
            educationItem.innerHTML = `
                <div class="row g-2">
                    <div class="col-md-3">
                        <label class="form-label">기 간${itemNumber}</label>
                        <input type="text" name="membership_period[]" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">학교명${itemNumber}</label>
                        <input type="text" name="membership_school[]" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">학과명${itemNumber}</label>
                        <input type="text" name="membership_department[]" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">학위${itemNumber}</label>
                        <input type="text" name="membership_degree[]" class="form-control">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-danger w-100" onclick="removeEducationAdmin(this)">삭제</button>
                    </div>
                </div>
            `;
            container.appendChild(educationItem);
        }

        // 학력 삭제 함수
        function removeEducationAdmin(btn) {
            const container = document.getElementById('education-container-admin');
            if (container.children.length > 1) {
                btn.closest('.education-item-admin').remove();
                updateEducationLabelsAdmin();
            } else {
                alert('최소 1개의 학력 정보는 필요합니다.');
            }
        }

        // 학력 레이블 번호 업데이트
        function updateEducationLabelsAdmin() {
            const container = document.getElementById('education-container-admin');
            const items = container.querySelectorAll('.education-item-admin');
            
            items.forEach((item, index) => {
                const labels = item.querySelectorAll('.form-label');
                const labelTexts = ['기 간', '학교명', '학과명', '학위'];
                const number = index > 0 ? (index + 1) : '';
                
                labels.forEach((label, labelIndex) => {
                    if (labelIndex < labelTexts.length) {
                        label.textContent = labelTexts[labelIndex] + number;
                    }
                });
            });
        }

        // 주요경력 추가 함수
        function addCareerAdmin() {
            const container = document.getElementById('career-container-admin');
            const itemNumber = container.children.length + 1;
            const careerItem = document.createElement('div');
            careerItem.className = 'career-item-admin mb-3 p-3 border rounded';
            careerItem.innerHTML = `
                <div class="row g-2">
                    <div class="col-md-3">
                        <label class="form-label">기 간${itemNumber}</label>
                        <input type="text" name="active_period[]" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">소속${itemNumber}</label>
                        <input type="text" name="active_affiliation[]" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">담당부서${itemNumber}</label>
                        <input type="text" name="active_department[]" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">직위${itemNumber}</label>
                        <input type="text" name="active_position[]" class="form-control">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-danger w-100" onclick="removeCareerAdmin(this)">삭제</button>
                    </div>
                </div>
            `;
            container.appendChild(careerItem);
        }

        // 주요경력 삭제 함수
        function removeCareerAdmin(btn) {
            const container = document.getElementById('career-container-admin');
            if (container.children.length > 1) {
                btn.closest('.career-item-admin').remove();
                updateCareerLabelsAdmin();
            } else {
                alert('최소 1개의 경력 정보는 필요합니다.');
            }
        }

        // 주요경력 레이블 번호 업데이트
        function updateCareerLabelsAdmin() {
            const container = document.getElementById('career-container-admin');
            const items = container.querySelectorAll('.career-item-admin');
            
            items.forEach((item, index) => {
                const labels = item.querySelectorAll('.form-label');
                const labelTexts = ['기 간', '소속', '담당부서', '직위'];
                const number = index > 0 ? (index + 1) : '';
                
                labels.forEach((label, labelIndex) => {
                    if (labelIndex < labelTexts.length) {
                        label.textContent = labelTexts[labelIndex] + number;
                    }
                });
            });
        }

        // 대외활동 추가 함수
        function addExtraAdmin() {
            const container = document.getElementById('extra-container-admin');
            const itemNumber = container.children.length + 1;
            const extraItem = document.createElement('div');
            extraItem.className = 'extra-item-admin mb-3 p-3 border rounded';
            extraItem.innerHTML = `
                <div class="row g-2">
                    <div class="col-md-5">
                        <label class="form-label">기간${itemNumber}</label>
                        <input type="text" name="extra_period[]" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">소속${itemNumber}</label>
                        <input type="text" name="extra_affiliation[]" class="form-control">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-danger w-100" onclick="removeExtraAdmin(this)">삭제</button>
                    </div>
                </div>
            `;
            container.appendChild(extraItem);
        }

        // 대외활동 삭제 함수
        function removeExtraAdmin(btn) {
            const container = document.getElementById('extra-container-admin');
            if (container.children.length > 1) {
                btn.closest('.extra-item-admin').remove();
                updateExtraLabelsAdmin();
            } else {
                alert('최소 1개의 대외활동 정보는 필요합니다.');
            }
        }

        // 대외활동 레이블 번호 업데이트
        function updateExtraLabelsAdmin() {
            const container = document.getElementById('extra-container-admin');
            const items = container.querySelectorAll('.extra-item-admin');
            
            items.forEach((item, index) => {
                const labels = item.querySelectorAll('.form-label');
                const labelTexts = ['기간', '소속'];
                const number = index > 0 ? (index + 1) : '';
                
                labels.forEach((label, labelIndex) => {
                    if (labelIndex < labelTexts.length) {
                        label.textContent = labelTexts[labelIndex] + number;
                    }
                });
            });
        }

        // 자격사항 추가 함수
        function addQualificationAdmin() {
            const container = document.getElementById('qualification-container-admin');
            const itemNumber = container.children.length + 1;
            const qualificationItem = document.createElement('div');
            qualificationItem.className = 'qualification-item-admin mb-3 p-3 border rounded';
            qualificationItem.innerHTML = `
                <div class="row g-2">
                    <div class="col-md-11">
                        <label class="form-label">자격증명${itemNumber}</label>
                        <input type="text" name="membership_qualification[]" class="form-control">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-danger w-100" onclick="removeQualificationAdmin(this)">삭제</button>
                    </div>
                </div>
            `;
            container.appendChild(qualificationItem);
        }

        // 자격사항 삭제 함수
        function removeQualificationAdmin(btn) {
            const container = document.getElementById('qualification-container-admin');
            if (container.children.length > 1) {
                btn.closest('.qualification-item-admin').remove();
                updateQualificationLabelsAdmin();
            } else {
                alert('최소 1개의 자격사항 정보는 필요합니다.');
            }
        }

        // 자격사항 레이블 번호 업데이트
        function updateQualificationLabelsAdmin() {
            const container = document.getElementById('qualification-container-admin');
            const items = container.querySelectorAll('.qualification-item-admin');
            
            items.forEach((item, index) => {
                const labels = item.querySelectorAll('.form-label');
                const number = index > 0 ? (index + 1) : '';
                
                labels.forEach((label) => {
                    label.textContent = '자격증명' + number;
                });
            });
        }
    </script>
    <script>
        // 우편번호 찾기 화면을 넣을 element
        var element_layer = document.getElementById('layer');

        function closeDaumPostcode() {
            // iframe을 넣은 element를 안보이게 한다.
            element_layer.style.display = 'none';
        }

        function openPostCode() {
            new daum.Postcode({
                oncomplete: function (data) {
                    // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                    // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                    // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                    var addr = ''; // 주소 변수
                    var extraAddr = ''; // 참고항목 변수

                    //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                    if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                        addr = data.roadAddress;
                    } else { // 사용자가 지번 주소를 선택했을 경우(J)
                        addr = data.jibunAddress;
                    }

                    // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                    if (data.userSelectedType === 'R') {
                        // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                        // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                        if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
                            extraAddr += data.bname;
                        }
                        // 건물명이 있고, 공동주택일 경우 추가한다.
                        if (data.buildingName !== '' && data.apartment === 'Y') {
                            extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                        }
                        // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                        if (extraAddr !== '') {
                            extraAddr = ' (' + extraAddr + ')';
                        }
                        // 조합된 참고항목을 해당 필드에 넣는다.
                        // document.getElementById("sample2_extraAddress").value = extraAddr;

                    } else {
                        // document.getElementById("sample2_extraAddress").value = '';
                    }

                    // 우편번호와 주소 정보를 해당 필드에 넣는다.
                    document.getElementById('sample2_postcode').value = data.zonecode;
                    document.getElementById("sample2_address").value = addr;
                    // 커서를 상세주소 필드로 이동한다.
                    document.getElementById("sample2_detailAddress").focus();

                    // iframe을 넣은 element를 안보이게 한다.
                    // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
                    element_layer.style.display = 'none';
                },
                width: '100%',
                height: '100%',
                maxSuggestItems: 5
            }).embed(element_layer);

            // iframe을 넣은 element를 보이게 한다.
            element_layer.style.display = 'block';

            // iframe을 넣은 element의 위치를 화면의 가운데로 이동시킨다.
            initLayerPosition();
        }

        function openPostCode2() {
            new daum.Postcode({
                oncomplete: function (data) {
                    // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                    // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                    // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                    var addr = ''; // 주소 변수
                    var extraAddr = ''; // 참고항목 변수

                    //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                    if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                        addr = data.roadAddress;
                    } else { // 사용자가 지번 주소를 선택했을 경우(J)
                        addr = data.jibunAddress;
                    }

                    // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                    if (data.userSelectedType === 'R') {
                        // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                        // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                        if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
                            extraAddr += data.bname;
                        }
                        // 건물명이 있고, 공동주택일 경우 추가한다.
                        if (data.buildingName !== '' && data.apartment === 'Y') {
                            extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                        }
                        // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                        if (extraAddr !== '') {
                            extraAddr = ' (' + extraAddr + ')';
                        }
                        // 조합된 참고항목을 해당 필드에 넣는다.
                        // document.getElementById("sample2_extraAddress").value = extraAddr;

                    } else {
                        // document.getElementById("sample2_extraAddress").value = '';
                    }

                    // 우편번호와 주소 정보를 해당 필드에 넣는다.
                    document.getElementById('sample2_postcode2').value = data.zonecode;
                    document.getElementById("sample2_address2").value = addr;
                    // 커서를 상세주소 필드로 이동한다.
                    document.getElementById("sample2_detailAddress2").focus();

                    // iframe을 넣은 element를 안보이게 한다.
                    // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
                    element_layer.style.display = 'none';
                },
                width: '100%',
                height: '100%',
                maxSuggestItems: 5
            }).embed(element_layer);

            // iframe을 넣은 element를 보이게 한다.
            element_layer.style.display = 'block';

            // iframe을 넣은 element의 위치를 화면의 가운데로 이동시킨다.
            initLayerPosition();
        }

        // 브라우저의 크기 변경에 따라 레이어를 가운데로 이동시키고자 하실때에는
        // resize이벤트나, orientationchange이벤트를 이용하여 값이 변경될때마다 아래 함수를 실행 시켜 주시거나,
        // 직접 element_layer의 top,left값을 수정해 주시면 됩니다.
        function initLayerPosition() {
            var width = 300; //우편번호서비스가 들어갈 element의 width
            var height = 400; //우편번호서비스가 들어갈 element의 height
            var borderWidth = 5; //샘플에서 사용하는 border의 두께

            // 위에서 선언한 값들을 실제 element에 넣는다.
            element_layer.style.width = width + 'px';
            element_layer.style.height = height + 'px';
            element_layer.style.border = borderWidth + 'px solid';
            // 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
            element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width) / 2 - borderWidth) + 'px';
            element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height) / 2 - borderWidth) + 'px';
        }
    </script>
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
                document.getElementById('updateForm').appendChild(hiddenInput);
            }
        }
    </script>
    <script>
        async function changePassword() {
            let formData = new FormData();

            let password = $('#password').val();

            if (!password) {
                alert('비밀번호를 입력해주세요.');
                return false;
            }

            formData.append('m_idx', '<?= $row['m_idx'] ?>')
            formData.append('password', password)
            formData.append('type', 'N')
            let url = '/AdmMaster/_members/changePassword';

            await handlePassword(url, formData);
        }

        async function handlePassword(url, formData) {
            await $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                    alert(response.message);
                    window.location.reload();
                },
                error: function (exception) {
                    alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
                    console.log(exception)
                }
            });
        }

        async function savePassword() {
            let formData = new FormData();

            let password = $('#manager_pw').val();

            if (!password) {
                alert('비밀번호를 입력해주세요.');
                return false;
            }

            formData.append('m_idx', '<?= $row['m_idx'] ?>')
            formData.append('password', password)
            formData.append('type', 'G')
            let url = '/AdmMaster/_members/changePassword';

            await handlePassword(url, formData);
        }

        async function chkID() {
            let manager_id = $('#manager_id').val();

            let url = '/AdmMaster/_members/chk_id';
            let data = {
                manager_id: manager_id,
            }

            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function (response) {
                    console.log(response)
                    alert(response.message);
                    $('#check_manager_id').val('Y');
                    $('#btnChkID').prop('disabled', true).addClass('disabled');
                },
                error: function (exception) {
                    alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
                    console.log(exception)
                }
            });
        }
    </script>
    <script>
        async function submitForm() {
            let frm = document.updateForm;
            let formData = new FormData(frm);
            let url = '/AdmMaster/_members/update';

            let manager_id = $('#manager_id').val();
            if (manager_id && manager_id != '' && manager_id != '<?= esc($row['manager_id']) ?>') {
                let check = $('#check_manager_id').val();
                if (check != 'Y') {
                    alert('ID 중복 여부를 확인해 주세요.');
                    return false;
                }
            }

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                    alert(response.message);
                    window.location.reload();
                },
                error: function (exception) {
                    alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
                    console.log(exception)
                }
            });
        }
    </script>
<?= $this->endSection() ?>