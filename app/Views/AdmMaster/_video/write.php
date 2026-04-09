<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>
<div class="page-heading mb-4 d-flex justify-content-between align-items-center">
    <h4 class="mb-0 fw-semibold">동영상 목록</h4>

    <div class="d-flex gap-2">
        <a href="<?= site_url('AdmMaster/_video/list') ?>"
            class="btn btn-outline-secondary">
            <i class="bi bi-list-task"></i> 목록
        </a>

        <button type="button"
            onclick="submitForm();"
            class="btn btn-primary">
            <i class="bi bi-gear-fill me-1"></i> 저장
        </button>
    </div>
</div>

<section class="section">
    <div class="col-lg-12">
        <form id="videoForm" name="videoForm" method="post" action="#!" enctype="multipart/form-data"
            class="card">
            <input type="hidden" name="video_idx" id="video_idx"
                value="<?= isset($row) ? $row['video_idx'] : '' ?>">
            <div class="card-body">
                <table class="table table-bordered align-middle">
                    <colgroup>
                        <col width="10%">
                        <col width="40%">
                        <col width="10%">
                        <col width="40%">
                    </colgroup>
                    <tbody>
                        <tr>
                            <th style="background-color: #d0ebff;">제목</th>
                            <td colspan="3">
                                <input type="text" name="title" id="title" class="form-control"
                                    value="<?= esc(isset($row) ? $row['title'] : '') ?>">
                            </td>
                        </tr>

                        <tr>
                            <th style="background-color: #d0ebff;">동영상</th>
                            <td colspan="">
                                <input type="text" name="video_url" id="video_url" class="form-control"
                                    value="<?= esc(isset($row) ? $row['video_url'] : '') ?>">
                            </td>
                            <th style="background-color: #d0ebff;">이미지</th>
                            <td colspan="">
                                <input type="file" name="file_upload" id="file_upload" class="form-control"
                                    accept="image/*">
                                <?php if (isset($row)): ?>
                                    <img class="mt-2" src="/uploads/video/<?= $row['ufile'] ?>"
                                        alt="<?= $row['rfile'] ?>" width="100">
                                    <br>
                                    <a href="/uploads/video/<?= $row['ufile'] ?>"
                                        download="<?= $row['rfile'] ?>">
                                        <?= $row['rfile'] ?>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr>
                            <th style="background-color: #d0ebff;">강의시간</th>
                            <td colspan="">
                                <input type="text" name="duration" class="form-control"
                                    value="<?= esc(isset($row) ? $row['duration'] : '0') ?>">
                            </td>
                            <th style="background-color: #d0ebff;">상태</th>
                            <td colspan="">
                                <select name="status" id="status" class="form-select">
                                    <option value="1" <?= isset($row) && $row['status'] == '1' ? 'selected' : '' ?>>
                                        정상
                                    </option>
                                    <option value="0" <?= isset($row) && $row['status'] == '0' ? 'selected' : '' ?>>
                                        잠김
                                    </option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th style="background-color: #d0ebff;">우선순위</th>
                            <td colspan="">
                                <input type="text" name="onum" id="onum" class="form-control"
                                    value="<?= esc(isset($row) ? $row['onum'] : '') ?>">
                            </td>
                            <?php if (isset($row)): ?>
                                <th style="background-color: #d0ebff;">수정된 날짜</th>
                                <td colspan="">
                                    <?= $row['updated_at'] ?>
                                </td>
                            <?php else: ?>
                                <th style="background-color: #d0ebff;">생성일</th>
                                <td colspan="">
                                    <?= date('Y-m-d H:i:s') ?>
                                </td>
                            <?php endif; ?>
                        </tr>

                        <tr>
                            <th style="background-color: #d0ebff;">간략설명</th>
                            <td colspan="3">
                                <textarea class="form-control" id="short_description" rows="10"
                                    name="short_description"><?= esc($row['short_description'] ?? '') ?></textarea>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </form>
    </div>
</section>

<div class="d-flex w-100 justify-content-end mb-2 gap-2">
    <a href="<?= site_url('AdmMaster/_video/list') ?>"
        class="btn btn-outline-secondary">
        <i class="bi bi-list-task"></i> 목록
    </a>

    <button type="button"
        onclick="submitForm();"
        class="btn btn-primary">
        <i class="bi bi-gear-fill me-1"></i> 저장
    </button>
</div>

<script>
    $(document).ready(function() {
        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true
        });
        $('.summernote').summernote({
            height: 400,
            lang: 'ko-KR',
            toolbar: [
                ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph', 'height']],
                ['insert', ['link', 'picture', 'video', 'table', 'hr']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onImageUpload: function(files) {
                    for (let i = 0; i < files.length; i++) {
                        uploadImage(files[i]);
                    }
                }
            }
        });
    });
</script>
<script>
    async function submitForm() {
        let frm = document.videoForm;
        let formData = new FormData(frm);
        let url = '/AdmMaster/_video/write_ok';

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                alert(response.message);
                window.location.reload();
            },
            error: function(exception) {
                alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
                console.log(exception)
            }
        });
    }
</script>
<script src="https://player.vimeo.com/api/player.js"></script>
<script>
    document.getElementById('video_url').addEventListener('blur', async function() {

        const url = this.value.trim();
        if (!url) return;

        const match = url.match(/vimeo\.com\/(?:video\/)?(\d+)/);
        if (!match) return;

        const videoId = match[1];

        try {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = `https://player.vimeo.com/video/${videoId}`;
            document.body.appendChild(iframe);

            const player = new Vimeo.Player(iframe);

            const durationSeconds = await player.getDuration();

            const formatted = formatToKoreanTime(durationSeconds);

            document.querySelector('input[name="duration"]').value = formatted;

            await player.unload();
            iframe.remove();

        } catch (error) {
            console.error('Duration 가져오기 실패:', error);
        }
    });

    function formatToKoreanTime(totalSeconds) {

        totalSeconds = Math.floor(totalSeconds);

        const hours = Math.floor(totalSeconds / 3600);
        const minutes = Math.floor((totalSeconds % 3600) / 60);
        const seconds = totalSeconds % 60;

        if (hours > 0) {
            return `${hours}시간 ${minutes}분 ${seconds}초`;
        }

        if (minutes > 0) {
            return `${minutes}분 ${seconds}초`;
        }

        return `${seconds}초`;
    }
</script>
<?= $this->endSection() ?>