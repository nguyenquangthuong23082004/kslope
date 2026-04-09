<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <script>
        alert("<?= esc(session()->getFlashdata('success')) ?>");
    </script>
<?php endif ?>

    <style>
        .dropdown-toggle:after {
            display: none;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ko-KR.min.js"></script>

    <div class="page-heading mb-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-0">약관 및 정책 관리</h4>

        <button type="button"
                onclick="submitForm()"
                class="btn btn-primary">
            <i class="bi bi-gear-fill me-1"></i> 저장
        </button>
    </div>

    <section class="section">
        <form id="policyForm"
              method="post"
              action="<?= site_url('AdmMaster/_adminrator/policyUpdate') ?>">
            <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#minfo1" type="button"
                            aria-selected="true" role="tab">
                        개인회원
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#minfo2"
                            type="button">
                        단체 및 특별회원
                    </button>
                </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content">
                <!-- 개인정보처리방침 -->
                <div class="tab-pane fade active show" id="minfo1" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <div class="listTop">
                                <div class="left">
                                    <h4 class="schTxt">■ 약관 동의(필수사항)</h4>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <colgroup>
                                    <col width="10%">
                                    <col width="x">
                                </colgroup>
                                <tbody>
                                <tr>
                                    <th class="text-center " style="vertical-align: middle" scope="row">PC</th>
                                    <td>
                                       <textarea name="minfo1"
                                                 id="editor_minfo1"
                                                 class="summernote"><?= $policy['minfo1'] ?? '' ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-center " style="vertical-align: middle">MOBILE</th>
                                    <td>
                                        <textarea name="minfo1_m"
                                                  id="editor_minfo1_m"
                                                  class="summernote"><?= $policy['minfo1_m'] ?? '' ?></textarea>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <div class="listTop">
                                <div class="left">
                                    <h4 class="schTxt">■ 기본 정보 동의(선택사항)</h4>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <colgroup>
                                    <col width="10%">
                                    <col width="x">
                                </colgroup>
                                <tbody>
                                <tr>
                                    <th class="text-center " style="vertical-align: middle" scope="row">PC</th>
                                    <td>
                                        <textarea name="minfo2"
                                                  id="editor_minfo2"
                                                  class="summernote"><?= $policy['minfo2'] ?? '' ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-center " style="vertical-align: middle">MOBILE</th>
                                    <td>
                                       <textarea name="minfo2_m"
                                                 id="editor_minfo2_m"
                                                 class="summernote"><?= $policy['minfo2_m'] ?? '' ?></textarea>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- 위치정보이용약관 -->
                <div class="tab-pane fade" id="minfo2" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <div class="listTop">
                                <div class="left">
                                    <h4 class="schTxt">■ 약관 동의(필수사항)</h4>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <colgroup>
                                    <col width="10%">
                                    <col width="x">
                                </colgroup>
                                <tbody>
                                <tr>
                                    <th class="text-center " style="vertical-align: middle" scope="row">PC</th>
                                    <td>
                                        <textarea name="minfo3"
                                                  id="editor_minfo3"
                                                  class="summernote"><?= $policy['minfo3'] ?? '' ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-center " style="vertical-align: middle">MOBILE</th>
                                    <td>
                                        <textarea name="minfo3_m"
                                                  id="editor_minfo3_m"
                                                  class="summernote"><?= $policy['minfo3_m'] ?? '' ?></textarea>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <div class="listTop">
                                <div class="left">
                                    <h4 class="schTxt">■ 기본 정보 동의(선택사항)</h4>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <colgroup>
                                    <col width="10%">
                                    <col width="x">
                                </colgroup>
                                <tbody>
                                <tr>
                                    <th class="text-center " style="vertical-align: middle" scope="row">PC</th>
                                    <td>
                                        <textarea name="minfo4"
                                                  id="editor_minfo4"
                                                  class="summernote"><?= $policy['minfo4'] ?? '' ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-center " style="vertical-align: middle">
                                        MOBILE
                                    </th>
                                    <td>
                                        <textarea name="minfo4_m"
                                                  id="editor_minfo4_m"
                                                  class="summernote"><?= $policy['minfo4_m'] ?? '' ?></textarea>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </section>

    <script>
        $(document).ready(function () {
            $('.summernote').summernote({
                height: 400,
                minHeight: 300,
                maxHeight: 600,
                lang: 'ko-KR',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                fontNames: ['맑은고딕', '굴림', '돋움', '바탕', 'Arial', 'Times New Roman'],
                fontNamesIgnoreCheck: ['맑은고딕'],
                callbacks: {
                    onImageUpload: function (files) {
                        uploadSummernoteImage(files[0], this);
                    }
                }
            });
        });

        function submitForm() {
            $('.summernote').each(function () {
                $(this).summernote('code');
            });

            document.getElementById('policyForm').submit();
        }

        function uploadSummernoteImage(file, editor) {
            const data = new FormData();
            data.append("file", file);

            $.ajax({
                url: '<?= site_url('AdmMaster/_adminrator/uploadImage') ?>',
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "post",
                success: function (response) {
                    const data = JSON.parse(response);
                    $(editor).summernote('insertImage', data.url);
                },
                error: function () {
                    alert('이미지 업로드 실패');
                }
            });
        }
    </script>

<?= $this->endSection() ?>