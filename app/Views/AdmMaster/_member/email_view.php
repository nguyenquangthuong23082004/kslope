<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Rich Text Editor (Summernote) -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ko-KR.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<style>
    .note-editor .note-editing-area .note-editable table td, .note-editor .note-editing-area .note-editable table th {
    border: unset;
    }
</style>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <!-- HEADER -->
    <div class="page-heading mb-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-0 fw-semibold">자동메일설정</h4>

        <div class="d-flex gap-2">
            <a href="<?= site_url('AdmMaster/_members/email') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-list-task"></i> 리스트
            </a>

            <button type="button" onclick="send_it()" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> 수정
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form name="frm" id="frm" 
                  action="<?= site_url('AdmMaster/_members/email_mod_ok') ?>" 
                  method="post" 
                  enctype="multipart/form-data">
                
                <input type="hidden" name="idx" id="idx" value="<?= $email['idx'] ?? '' ?>" />

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <colgroup>
                            <col width="150">
                            <col width="*">
                        </colgroup>
                        <tbody>
                            <!-- 메일코드 -->
                            <tr>
                                <th style="background-color: #d0ebff;">메일코드 <span class="text-danger">*</span></th>
                                <td>
                                    <input type="text" 
                                           name="code" 
                                           id="code" 
                                           class="form-control" 
                                           style="width: 200px;"
                                           value="<?= $email['code'] ?? '' ?>"
                                           maxlength="20"
                                           required>
                                </td>
                            </tr>

                            <!-- 메일항목 -->
                            <tr>
                                <th style="background-color: #d0ebff;">메일항목 <span class="text-danger">*</span></th>
                                <td>
                                    <input type="text" 
                                           name="title" 
                                           id="title" 
                                           class="form-control" 
                                           value="<?= $email['title'] ?? '' ?>"
                                           required>
                                </td>
                            </tr>

                            <!-- 구분 -->
                            <tr>
                                <th style="background-color: #d0ebff;">구분</th>
                                <td>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                   type="radio" 
                                                   name="autosend" 
                                                   id="autosend_y" 
                                                   value="Y"
                                                   <?= (isset($email['autosend']) && $email['autosend'] == "Y") ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="autosend_y">
                                                자동발송
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                   type="radio" 
                                                   name="autosend" 
                                                   id="autosend_n" 
                                                   value="N"
                                                   <?= (isset($email['autosend']) && $email['autosend'] == "N") ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="autosend_n">
                                                자동발송안함
                                            </label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- 발송자이름 -->
                            <tr>
                                <th style="background-color: #d0ebff;">발송자이름 <span class="text-danger">*</span></th>
                                <td>
                                    <input type="text" 
                                           name="send_name" 
                                           id="send_name" 
                                           class="form-control" 
                                           value="<?= $email['send_name'] ?? '' ?>"
                                           required>
                                </td>
                            </tr>

                            <!-- 발송자E-mail -->
                            <tr>
                                <th style="background-color: #d0ebff;">발송자E-mail <span class="text-danger">*</span></th>
                                <td>
                                    <input type="email" 
                                           name="send_email" 
                                           id="send_email" 
                                           class="form-control" 
                                           value="<?= $email['send_email'] ?? '' ?>"
                                           required>
                                </td>
                            </tr>

                            <!-- 메일제목 -->
                            <tr>
                                <th style="background-color: #d0ebff;">메일제목 <span class="text-danger">*</span></th>
                                <td>
                                    <input type="text" 
                                           name="mail_title" 
                                           id="mail_title" 
                                           class="form-control" 
                                           value="<?= $email['mail_title'] ?? '' ?>"
                                           required>
                                </td>
                            </tr>

                            <!-- 내용 -->
                            <tr>
                                <th style="background-color: #d0ebff;">내용</th>
                                <td>
                                    <textarea name="content" 
                                              id="summernote" 
                                              class="summernote" 
                                              rows="10"><?= $email['content'] ?? '' ?></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <div class="d-flex gap-2">
                        <a href="<?= site_url('AdmMaster/_members/email') ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-list-task"></i> 리스트
                        </a>

                        <button type="button" onclick="send_it()" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> 수정
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Hidden iframe for form submission -->
    <iframe name="hiddenFrame22" 
            id="hiddenFrame22"
            style="display: none;"></iframe>

    <script>
        function send_it() {
            var frm = document.frm;
            
            // Validation
            if (frm.code.value.trim() == "") {
                alert("메일코드를 등록해주세요.");
                frm.code.focus();
                return;
            }

            if (frm.title.value.trim() == "") {
                alert("메일항목을 등록해주세요.");
                frm.title.focus();
                return;
            }

            if (frm.send_name.value.trim() == "") {
                alert("발송자 이름을 등록해주세요.");
                frm.send_name.focus();
                return;
            }

            if (frm.send_email.value.trim() == "") {
                alert("발송자E-mail을 입력해주세요.");
                frm.send_email.focus();
                return;
            }

            // Email validation
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(frm.send_email.value)) {
                alert("올바른 이메일 주소를 입력해주세요.");
                frm.send_email.focus();
                return;
            }

            if (frm.mail_title.value.trim() == "") {
                alert("메일제목을 입력해주세요.");
                frm.mail_title.focus();
                return;
            }

            // Summernote content validation
            if ($('#summernote').summernote('code').trim().length < 10) {
                alert("내용을 10자 이상 입력해주세요.");
                $('#summernote').summernote('focus');
                return;
            }

            // Update content field before submit
            frm.content.value = $('#summernote').summernote('code');

            // Submit form
            frm.submit();
        }

        $(document).ready(function() {
            // Initialize Summernote
            $('#summernote').summernote({
                height: 400,
                placeholder: '내용을 입력해주세요...',
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '30', '36', '48'],
                callbacks: {
                    onImageUpload: function(files) {
                        // Image upload callback if needed
                        for (var i = 0; i < files.length; i++) {
                            sendFile(files[i]);
                        }
                    }
                }
            });

            // Set initial content if exists
            <?php if (!empty($email['content'])): ?>
            $('#summernote').summernote('code', <?= json_encode($email['content']) ?>);
            <?php endif; ?>

            // Form submission via AJAX (optional)
            $('#frm').on('submit', function(e) {
                // You can add AJAX submission here if needed
                // For now, let it submit normally to hidden iframe
            });
        });

        function sendFile(file) {
            var data = new FormData();
            data.append("file", file);
            
            $.ajax({
                data: data,
                type: "POST",
                url: "<?= site_url('AdmMaster/_members/upload_image') ?>", // Create this endpoint
                cache: false,
                contentType: false,
                processData: false,
                success: function(url) {
                    $('#summernote').summernote("insertImage", url);
                },
                error: function(data) {
                    console.log(data);
                    alert("이미지 업로드에 실패했습니다.");
                }
            });
        }
    </script>

<?= $this->endSection() ?>
