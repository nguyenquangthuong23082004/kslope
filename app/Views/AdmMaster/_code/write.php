
<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>

<!-- Page Header -->
<div class="page-heading mb-4 d-flex justify-content-between align-items-center">
    <h4 class="mb-0">코드 <?= $titleStr ?></h4>
</div>

<!-- Main Content -->
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-end align-items-center">
            <div class="d-flex flex-wrap gap-2">
                <a href="javascript:history.back();" class="btn btn-secondary">
                    <i class="bi bi-list"></i> 리스트
                </a>
                <button type="button" onclick="send_it()" class="btn btn-success">
                    <i class="bi bi-pencil"></i> <?= $titleStr ?>
                </button>
            </div>
        </div>

        <div class="card-body pt-4">
			<form name="frm" id="frm" action="<?= site_url('AdmMaster/_code/write_ok') ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="code_idx" value="<?= $code_idx ?>">
				<input type="hidden" name="code_no" value="<?= esc($row['code_no']) ?>">
				<input type="hidden" name="depth" value="<?= $depth ?>">
				<input type="hidden" name="parent_code_no" value="<?= $parent_code_no ?>">
				<input type="hidden" name="code_gubun" value="<?= $code_gubun ?>">

				<div class="table-responsive">
					<table class="table table-bordered align-middle">
						<colgroup>
							<col width="10%">
							<col width="90%">
						</colgroup>
						<tbody>
							<!-- 코드 번호 -->
							<tr>
								<th style="background-color: #d0ebff;">코드 번호</th>
								<td>
									<input type="text" class="form-control" value="<?= esc($row['code_no']) ?>" readonly>
									<small class="text-muted">자동 생성됩니다</small>
								</td>
							</tr>

							<?php if ($parent_code_no == '0'): ?>
							<tr>
								<th style="background-color: #d0ebff;">
									코드구분 <span class="text-danger">*</span>
								</th>
								<td>
									<?php if ($code_idx): ?>
										<input type="text" 
											class="form-control" 
											value="<?= esc($code_gubun) ?>" 
											readonly>
									<?php else: ?>
										<input type="text" 
											name="code_gubun" 
											id="code_gubun" 
											class="form-control" 
											value="<?= esc($code_gubun) ?>" 
											required>
									<?php endif; ?>
								</td>
							</tr>
						<?php else: ?>
							<input type="hidden" name="code_gubun" value="<?= esc($code_gubun) ?>">
							
							<tr>
								<th style="background-color: #d0ebff;">코드구분</th>
								<td>
									<input type="text" 
										class="form-control" 
										value="<?= esc($code_gubun) ?>" 
										readonly>
								</td>
							</tr>
						<?php endif; ?>
							<tr>
								<th style="background-color: #d0ebff;">
									코드명 <span class="text-danger">*</span>
								</th>
								<td>
									<input type="text" 
										name="code_name" 
										id="code_name" 
										class="form-control" 
										value="<?= esc($row['code_name']) ?>" 
										required>
								</td>
							</tr>

							<!-- 현황 -->
							<tr>
								<th style="background-color: #d0ebff;">현황</th>
								<td>
									<div class="form-check form-check-inline">
										<input class="form-check-input" 
											type="radio" 
											name="status" 
											id="status_y" 
											value="Y" 
											<?= (!isset($row['status']) || $row['status'] == 'Y') ? 'checked' : '' ?>>
										<label class="form-check-label" for="status_y">사용</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" 
											type="radio" 
											name="status" 
											id="status_c" 
											value="C" 
											<?= (isset($row['status']) && $row['status'] == 'C') ? 'checked' : '' ?>>
										<label class="form-check-label" for="status_c">마감</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" 
											type="radio" 
											name="status" 
											id="status_n" 
											value="N" 
											<?= (isset($row['status']) && $row['status'] == 'N') ? 'checked' : '' ?>>
										<label class="form-check-label" for="status_n">삭제</label>
									</div>
								</td>
							</tr>

							<!-- 베스트 사용 (parent_code_no가 0일 때만) -->
							<?php if ($parent_code_no == '0'): ?>
								<tr>
									<th style="background-color: #d0ebff;">베스트 사용</th>
									<td>
										<div class="form-check form-switch">
											<input class="form-check-input" 
												type="checkbox" 
												name="bestYN" 
												id="bestYN" 
												value="Y" 
												<?= (isset($row['bestYN']) && $row['bestYN'] == 'Y') ? 'checked' : '' ?>>
											<label class="form-check-label" for="bestYN">사용</label>
										</div>
									</td>
								</tr>

								<!-- PC 이미지 -->
								<tr>
									<th style="background-color: #d0ebff;">PC 이미지</th>
									<td>
										<input type="file" 
											name="ufile1" 
											class="form-control mb-2" 
											accept="image/*">
										<?php if (!empty($row['ufile1'])): ?>
											<div class="mt-2 p-3 bg-light rounded">
												<div class="form-check mb-2">
													<input class="form-check-input" 
														type="checkbox" 
														name="del_1" 
														value="Y" 
														id="del_1">
													<label class="form-check-label text-danger" for="del_1">
														<i class="bi bi-trash"></i> 이미지 삭제
													</label>
												</div>
												<div class="border p-2 bg-white rounded">
													<a href="<?= base_url('data/code/' . $row['ufile1']) ?>" 
													target="_blank">
														<img src="<?= base_url('data/code/' . $row['ufile1']) ?>" 
															alt="PC 이미지" 
															class="img-thumbnail" 
															style="max-width: 200px;">
													</a>
													<p class="text-muted small mb-0 mt-2">
														<i class="bi bi-file-earmark-image"></i> 
														파일명: <?= esc($row['rfile1']) ?>
													</p>
												</div>
											</div>
										<?php endif; ?>
									</td>
								</tr>

								<!-- 모바일 이미지 -->
								<tr>
									<th style="background-color: #d0ebff;">모바일 이미지</th>
									<td>
										<input type="file" 
											name="ufile2" 
											class="form-control mb-2" 
											accept="image/*">
										<?php if (!empty($row['ufile2'])): ?>
											<div class="mt-2 p-3 bg-light rounded">
												<div class="form-check mb-2">
													<input class="form-check-input" 
														type="checkbox" 
														name="del_2" 
														value="Y" 
														id="del_2">
													<label class="form-check-label text-danger" for="del_2">
														<i class="bi bi-trash"></i> 이미지 삭제
													</label>
												</div>
												<div class="border p-2 bg-white rounded">
													<a href="<?= base_url('data/code/' . $row['ufile2']) ?>" 
													target="_blank">
														<img src="<?= base_url('data/code/' . $row['ufile2']) ?>" 
															alt="모바일 이미지" 
															class="img-thumbnail" 
															style="max-width: 200px;">
													</a>
													<p class="text-muted small mb-0 mt-2">
														<i class="bi bi-file-earmark-image"></i> 
														파일명: <?= esc($row['rfile2']) ?>
													</p>
												</div>
											</div>
										<?php endif; ?>
									</td>
								</tr>
							<?php endif; ?>

							<!-- 우선순위 -->
							<tr>
								<th style="background-color: #d0ebff;">우선순위</th>
								<td>
									<input type="number" 
										name="onum" 
										class="form-control" 
										value="<?= esc($row['onum'] ?? 0) ?>" 
										style="max-width: 150px;">
									<small class="text-muted">숫자가 높을수록 상위에 노출됩니다.</small>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</form>
        </div>
    </div>
</section>

<script>
function send_it() {
    const frm = document.frm;
    
    if (!frm.code_name.value.trim()) {
        alert('코드명을 입력하셔야 합니다.');
        frm.code_name.focus();
        return false;
    }

    if (confirm('저장하시겠습니까?')) {
        frm.submit();
    }
}

document.getElementById('color')?.addEventListener('change', function() {
    this.nextElementSibling.value = this.value;
});
</script>

<?= $this->endSection() ?>