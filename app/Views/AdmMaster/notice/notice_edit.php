<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('error')): ?>
    <script>
        alert("<?= esc(session()->getFlashdata('error')) ?>");
    </script>
<?php endif ?>

<div class="page-heading mb-4 d-flex justify-content-between align-items-center">
    <h4 class="mb-0">공지사항 수정</h4>

    <div class="d-flex gap-2">
        <a href="<?= site_url('AdmMaster/notice') ?>"
            class="btn btn-outline-secondary">
            <i class="bi bi-list-task"></i> 목록
        </a>

        <button type="submit"
            form="noticeForm"
            class="btn btn-primary">
            <i class="bi bi-gear-fill me-1"></i> 저장
        </button>
    </div>
</div>

<div class="card">
    <div class="card-body">

        <form id="noticeForm" method="post"
            action="<?= site_url('AdmMaster/notice/update/' . $row['r_idx']) ?>">

            <!-- 제목 -->
            <div class="mb-3">
                <label class="form-label">제목</label>
                <input type="text"
                    name="r_title"
                    class="form-control"
                    value="<?= esc(old('r_title', $row['r_title'])) ?>"
                    required>
            </div>

            <!-- 작성자 -->
            <div class="mb-3">
                <label class="form-label">작성자</label>
                <input type="text"
                    name="r_name"
                    class="form-control"
                    value="<?= esc(old('r_name', $row['r_name'] ?? '관리자')) ?>">
            </div>

            <!-- 내용 (Summernote) -->
            <div class="mb-4">
                <label class="form-label">내용</label>
                <textarea name="r_content"
                    id="r_content"
                    class="form-control"
                    rows="10"
                    required><?= old('r_content', $row['r_content']) ?></textarea>
            </div>


        </form>

    </div>
</div>

<!-- Summernote -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $('#r_content').summernote({
        height: 350,
        lang: 'ko-KR',
        toolbar: [
            ['style', ['bold', 'italic', 'underline']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'picture']],
            ['view', ['codeview']]
        ],
        callbacks: {
            onImageUpload: function(files) {
                uploadSummernoteImage(files[0]);
            }
        }
    });

    function uploadSummernoteImage(file) {
        let data = new FormData();
        data.append('file', file);

        $.ajax({
            url: "<?= site_url('AdmMaster/notice/uploadImage') ?>",
            type: "POST",
            data: data,
            enctype: "multipart/form-data",
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.url) {
                    $('#r_content').summernote('insertImage', res.url);
                }
            },
            error: function() {
                alert('이미지 업로드 실패');
            }
        });
    }
</script>
<?= $this->endSection() ?>