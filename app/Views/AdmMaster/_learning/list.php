<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>

<style>
.badge-status-wait     { background: #0d6efd; color: #fff; border-radius: 4px; padding: 4px 8px; font-size: 12px; white-space:nowrap; }
.badge-status-done     { background: #198754; color: #fff; border-radius: 4px; padding: 4px 8px; font-size: 12px; white-space:nowrap; }
.badge-status-progress { background: #fd7e14; color: #fff; border-radius: 4px; padding: 4px 8px; font-size: 12px; white-space:nowrap; }
.badge-status-finish   { background: #6f42c1; color: #fff; border-radius: 4px; padding: 4px 8px; font-size: 12px; white-space:nowrap; }
.badge-status-fail     { background: #dc3545; color: #fff; border-radius: 4px; padding: 4px 8px; font-size: 12px; white-space:nowrap; }
.badge-red    { background: #dc3545; color: #fff; border-radius: 4px; padding: 3px 8px; font-size: 11px; }
.badge-blue   { background: #0d6efd; color: #fff; border-radius: 4px; padding: 3px 8px; font-size: 11px; }
.row-num { color: #555; font-size: 12px; }
</style>

<div class="page-heading mb-4 d-flex justify-content-between align-items-center">
    <h4 class="mb-0">수강생 관리</h4>
    <!-- <div class="d-flex gap-2 align-items-center">
        <a href="javascript:checkAll(true)" class="btn btn-outline-success">
            <i class="bi bi-check-square"></i> 전체선택
        </a>
        <a href="javascript:checkAll(false)" class="btn btn-outline-secondary">
            <i class="bi bi-square"></i> 선택해체
        </a>
        <a href="javascript:SELECT_DELETE()" class="btn btn-danger">
            <i class="bi bi-trash"></i> 선택삭제
        </a>
    </div> -->
</div>

<!-- 검색 필터 -->
<div class="card mb-3">
    <div class="card-body py-2 px-3">
        <form method="get" id="searchForm">
        <table class="table table-bordered filter-table mb-2" style="table-layout:fixed;">
            <colgroup>
                <col style="width:110px"><col><col style="width:110px"><col>
                <col style="width:110px"><col><col style="width:110px"><col>
            </colgroup>
            <tbody>

            <tr>
                <td class="label" colspan="6" style="padding:6px 10px;">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="form-check form-check-inline mb-0">
                            <input class="form-check-input" type="radio" name="search_type" id="type_period" value="period"
                                <?= ($filters['search_type'] !== 'company') ? 'checked' : '' ?>
                                onchange="toggleSearchType(this.value)">
                            <label class="form-check-label" for="type_period">기간 검색</label>
                        </div>
                        <div class="form-check form-check-inline mb-0">
                            <input class="form-check-input" type="radio" name="search_type" id="type_company" value="company"
                                <?= ($filters['search_type'] === 'company') ? 'checked' : '' ?>
                                onchange="toggleSearchType(this.value)">
                            <label class="form-check-label" for="type_company">사업주 검색</label>
                        </div>

                        <!-- 기간 검색 영역 -->
                        <div id="period_fields" style="display:flex; align-items:center; gap:8px;">
                            <select name="year" class="form-select form-select-sm" style="width:100px;">
                                <option value="">년도전체</option>
                                <?php foreach (range(date('Y'), 2020) as $y): ?>
                                <option value="<?= $y ?>" <?= ($filters['year'] == $y) ? 'selected' : '' ?>><?= $y ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select name="month" class="form-select form-select-sm" style="width:80px;">
                                <option value="">월 전체</option>
                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?= $m ?>" <?= ($filters['month'] == $m) ? 'selected' : '' ?>><?= $m ?>월</option>
                                <?php endfor; ?>
                            </select>
                            <select name="period_type" class="form-select form-select-sm" style="width:160px;">
                                <option value="">검색된 기간이 없습니다.</option>
                                <option value="reg"   <?= ($filters['period_type'] === 'reg')   ? 'selected' : '' ?>>등록일</option>
                                <option value="start" <?= ($filters['period_type'] === 'start') ? 'selected' : '' ?>>수강시작일</option>
                                <option value="end"   <?= ($filters['period_type'] === 'end')   ? 'selected' : '' ?>>수강종료일</option>
                            </select>
                            <select name="period_range" class="form-select form-select-sm" style="width:150px;">
                                <option value="">기간을 선택하세요.</option>
                                <option value="today" <?= ($filters['period_range'] === 'today') ? 'selected' : '' ?>>오늘</option>
                                <option value="week"  <?= ($filters['period_range'] === 'week')  ? 'selected' : '' ?>>1주일</option>
                                <option value="month" <?= ($filters['period_range'] === 'month') ? 'selected' : '' ?>>1개월</option>
                            </select>
                        </div>

                        <!-- 사업주 검색 영역 -->
                        <div id="company_fields" style="display:none; align-items:center; gap:8px;">
                            <input type="text" name="company_search" class="form-control form-control-sm"
                                placeholder="회사명 검색" style="width:220px;"
                                value="<?= esc($filters['company_search'] ?? '') ?>">
                        </div>
                    </div>
                </td>
                <td class="label">카테고리</td>
                <td class="inbox">
                    <select name="s_category1" class="form-select form-select-sm" style="width:150px;">
                        <option value="">카테고리 검색</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= esc($cat['code_no']) ?>"
                            <?= ($filters['s_category1'] === $cat['code_no']) ? 'selected' : '' ?>>
                            <?= esc($cat['code_name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td class="label">수강생</td>
                <td class="inbox" colspan="3">
                    <div class="d-flex gap-2">
                        <input type="text" name="student_name" class="form-control form-control-sm"
                               placeholder="이름/ID 검색" style="width:140px;"
                               value="<?= esc($filters['student_name']) ?>">
                        <select name="student_type" class="form-select form-select-sm" style="width:120px;">
                            <option value="">수강생구분</option>
                            <option value="G" <?= ($filters['student_type'] === 'G') ? 'selected' : '' ?>>일반</option>
                            <option value="S" <?= ($filters['student_type'] === 'S') ? 'selected' : '' ?>>비환급</option>
                        </select>
                    </div>
                </td>
                <td class="label">담당자</td>
                <td class="inbox">
                    <input type="text" name="manager" class="form-control form-control-sm"
                           placeholder="이름/ID 검색" style="width:140px;"
                           value="<?= esc($filters['manager']) ?>">
                </td>
                <td class="label">진도율</td>
                <td class="inbox">
                    <div class="d-flex align-items-center gap-1">
                        <input type="number" name="progress_from" class="form-control form-control-sm"
                               style="width:60px;" value="<?= esc($filters['progress_from']) ?>">
                        <span>% ~</span>
                        <input type="number" name="progress_to" class="form-control form-control-sm"
                               style="width:60px;" value="<?= esc($filters['progress_to']) ?>">
                        <span>%</span>
                    </div>
                </td>
            </tr>

            <!-- Row 3: 과정명 / 등록일 / 등록자 -->
            <tr>
                <td class="label">과정명</td>
                <td class="inbox" colspan="3">
                    <select name="course_name" class="form-select form-select-sm" style="width:300px;">
                        <option value="">전체보기</option>
                        <?php foreach ($courses as $course): ?>
                        <option value="<?= esc($course['course_name']) ?>"
                            <?= ($filters['course_name'] === $course['course_name']) ? 'selected' : '' ?>>
                            <?= esc($course['course_name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td class="label">등록일</td>
                <td class="inbox">
                    <input type="text" name="reg_date" class="form-control form-control-sm"
                           placeholder="Ex) 2021-12-31" style="width:130px;"
                           value="<?= esc($filters['reg_date']) ?>">
                </td>
                <td class="label">등록자</td>
                <td class="inbox">
                    <select name="registrar" class="form-select form-select-sm" style="width:100px;">
                        <option value="">전체</option>
                    </select>
                </td>
            </tr>

            <!-- Row 4: 진행상황 / 수료여부 / 환급여부 -->
            <tr>
                <td class="label">진행상황</td>
                <td class="inbox">
                    <select name="progress_status" class="form-select form-select-sm" style="width:100px;">
                        <option value="">전체</option>
                        <option value="수강대기" <?= ($filters['progress_status'] === '수강대기') ? 'selected' : '' ?>>수강대기</option>
                        <option value="수강중"   <?= ($filters['progress_status'] === '수강중')   ? 'selected' : '' ?>>수강중</option>
                        <option value="수강완료" <?= ($filters['progress_status'] === '수강완료') ? 'selected' : '' ?>>수강완료</option>
                        <option value="수료완료" <?= ($filters['progress_status'] === '수료완료') ? 'selected' : '' ?>>수료완료</option>
                        <option value="미수료"   <?= ($filters['progress_status'] === '미수료')   ? 'selected' : '' ?>>미수료</option>
                    </select>
                </td>
                <td class="label">수료여부</td>
                <td class="inbox">
                    <select name="completion" class="form-select form-select-sm" style="width:100px;">
                        <option value="">전체</option>
                        <option value="수료"   <?= ($filters['completion'] === '수료')  ? 'selected' : '' ?>>수료</option>
                        <option value="미수료" <?= ($filters['completion'] === '미수료') ? 'selected' : '' ?>>미수료</option>
                    </select>
                </td>
                <td class="label">환급여부</td>
                <td class="inbox">
                    <select name="refund" class="form-select form-select-sm" style="width:100px;">
                        <option value="">전체</option>
                        <option value="환급"   <?= ($filters['refund'] === '환급')  ? 'selected' : '' ?>>환급</option>
                        <option value="비환급" <?= ($filters['refund'] === '비환급') ? 'selected' : '' ?>>비환급</option>
                    </select>
                </td>
                <td class="inbox" colspan="2"></td>
            </tr>

            <!-- Row 5: 영업자 소속 + 검색 -->
            <tr>
                <td class="label">영업자 소속</td>
                <td class="inbox" colspan="7">
                    <div class="d-flex gap-2">
                        <select name="sales_org" class="form-select form-select-sm" style="width:180px;">
                            <option value="">전체</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm px-4">검색</button>
                    </div>
                </td>
            </tr>

            </tbody>
        </table>
        </form>
    </div>
</div>

<!-- 목록 -->
<div class="card">
    <div class="card-header py-2 d-flex justify-content-between align-items-center">
        <span class="fw-bold">■ 총 <span class="text-primary"><?= number_format($num) ?></span>개의 목록이 있습니다.</span>
    </div>
    <div class="card-body pt-3">
        <form name="listForm" id="listForm">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0" style="font-size:12px;">
                <thead class="table-light">
                <tr>
                    <th class="text-center" style="width:30px;">
                        <input type="checkbox" id="checkAllBox" onclick="checkAll(this.checked)">
                    </th>
                    <th class="text-center" style="width:40px;">번호</th>
                    <th class="text-center" style="width:90px;">진행상황</th>
                    <th class="text-center" style="width:40px;">처리</th>
                    <th class="text-center" style="width:90px;">수강번호<br>구분</th>
                    <th class="text-center" style="width:140px;">이름<br>아이디</th>
                    <th class="text-center" style="min-width:200px;">과정명</th>
                    <th class="text-center" style="width:150px;">수강기간</th>
                    <th class="text-center" style="width:65px;">진도율</th>
                    <th class="text-center" style="width:90px;">총점<br>수료여부</th>
                    <th class="text-center" style="width:80px;">교강사<br>담당자</th>
                    <th class="text-center" style="width:150px;">사업주/전화번호<br>부서/직위</th>
                    <th class="text-center" style="width:50px;">재응시</th>
                    <th class="text-center" style="width:50px;">동영상 건수</th>
                </tr>
                </thead>
                <tbody>
                <?php $startNum = $num - (($page - 1) * $perPage); ?>
                <?php if (empty($items)): ?>
                <tr>
                    <td colspan="14" class="text-center py-5 text-muted">조회된 수강생이 없습니다.</td>
                </tr>
                <?php else: ?>
                <?php foreach ($items as $key => $item): ?>
                <tr>
                    <td class="text-center">
                        <input type="checkbox" name="selected[]" class="chk-item"
                               value="<?= $item['m_idx'] ?>">
                    </td>
                    <td class="text-center row-num"><?= $startNum - $key ?></td>
                    <td class="text-center">
                        <span class="<?= $item['display_status_class'] ?>">
                            <?= $item['display_status'] ?>
                        </span>
                    </td>
                    <td class="text-center"></td>
                    <td class="text-center" style="font-size:11px;">
                        <span class="text-muted"><?= $item['code_name_1'] ?? '' ?></span><br>
                        <span class="text-muted">(<?= $item['code_name_2'] ?? '' ?>)</span>
                    </td>
                    <td class="text-center">
                        <?= $item['user_name'] ?><br>
                        <span class="text-muted"><?= $item['user_id'] ?></span>
                    </td>
                    <td>
                        <?= $item['course_name'] ?? '-' ?>
                    </td>
                    <td class="text-center" style="font-size:11px;">
                        <?= $item['period_str'] ?: '-' ?>
                    </td>
                    <td class="text-center">
                        <?php $pct = (float)($item['progress_percent'] ?? 0); ?>
                        <span class="badge bg-<?= $pct >= 100 ? 'success' : ($pct > 0 ? 'warning text-dark' : 'secondary') ?>">
                            <?= number_format($pct, 0) ?>%
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="<?= $item['completion_class'] ?>">
                            <?= $item['completion_label'] ?>
                        </span>
                    </td>
                    <td class="text-center" style="font-size:11px;">
                        <?= $item['mentor'] ?? '-' ?><br>
                    </td>
                    <td class="text-center" style="font-size:11px;">
                        <?= $item['company_name'] ?? '-' ?><br>
                        <?= $item['company_phone'] ?? '' ?><br>
                        <span class="text-muted"><?= $item['dept'] ?? '' ?></span>
                    </td>
                    <td class="text-center">-</td>
                    <td class="text-center"><?= count(array_filter(array_map('trim', explode(',', $item['course_url'] ?? '')))) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        </form>

        <?php if ($pager): ?>
        <div class="mt-3 mb-2 px-3">
            <?= $pager->links('learning', 'bootstrap5_full') ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function toggleSearchType(val) {
    const periodFields  = document.getElementById('period_fields');
    const companyFields = document.getElementById('company_fields');
    console.log('123');
    
    if (val === 'company') {
        periodFields.style.display  = 'none';
        companyFields.style.display = 'flex';
    } else {
        periodFields.style.display  = 'flex';
        companyFields.style.display = 'none';
    }
}
toggleSearchType('<?= $filters['search_type'] ?>');

function checkAll(checked) {
    document.querySelectorAll('.chk-item').forEach(el => el.checked = checked);
    const box = document.getElementById('checkAllBox');
    if (box) box.checked = checked;
}

function SELECT_DELETE() {
    const checked = document.querySelectorAll('.chk-item:checked');
    if (checked.length === 0) { alert('삭제할 항목을 선택해주세요.'); return; }
    if (!confirm(`선택한 ${checked.length}개 항목을 삭제하시겠습니까?`)) return;

    const formData = new FormData();
    checked.forEach(cb => formData.append('id[]', cb.value));

    fetch('<?= site_url('AdmMaster/_learning/delete') ?>', { method: 'POST', body: formData })
        .then(r => r.json())
        .then(data => {
            alert(data.message || (data.status ? '삭제되었습니다.' : '삭제 실패'));
            if (data.status) location.reload();
        })
        .catch(() => alert('오류가 발생했습니다.'));
}
</script>

<?= $this->endSection() ?>