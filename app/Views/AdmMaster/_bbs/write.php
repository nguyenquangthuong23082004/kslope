<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ko-KR.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <div class="page-heading mb-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-0 fw-semibold">교육 수강 상세</h4>

        <div class="d-flex gap-2">
            <a href="<?= site_url('AdmMaster/_bbs/list?code='.$code) ?>"
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
            <form id="courseForm" name="courseForm" method="post" action="/AdmMaster/_bbs/write_ok"
                  enctype="multipart/form-data"
                  class="card">
                <input type="hidden" name="bbs_idx" id="bbs_idx" value="<?= isset($row) ? $row['bbs_idx'] : '' ?>">
                <input type="hidden" name="code" id="code" value="<?= $code ?>">
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
                            <?php if ($code != 'member_resource'): ?>
                                <th style="background-color: #d0ebff;">카테고리</th>
                                <td colspan="">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <select id="category_no" name="category_no" class="form-select">
                                                <?php foreach ($categories as $category): ?>
                                                    <option <?= $category['code_no'] == (isset($row) ? $row['category_no'] : '') ? 'selected' : '' ?>
                                                            value="<?= $category['code_no'] ?>"><?= $category['code_name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                            <?php endif; ?>
                            <th style="background-color: #d0ebff;">작성자</th>
                            <td colspan="<?= $code != 'member_resource' ? '' : '3' ?>">
                                <input type="text" name="writer" id="writer" class="form-control"
                                       value="<?= esc(isset($row) ? $row['writer'] : '관리자') ?>">
                            </td>

                        </tr>

                        <tr>
                            <th style="background-color: #d0ebff;">제목</th>
                            <?php if ($code == 'association'): ?>
                                <td>
                                    <input type="text" name="subject" id="subject" class="form-control" value="<?= esc(isset($row) ? $row['subject'] : '') ?>">
                                </td>
                                <th style="background-color: #d0ebff;">링크</th>
                                <td>
                                    <input type="text" name="link_url" id="link_url" class="form-control" placeholder="https://" value="<?= esc(isset($row) ? $row['link'] : '') ?>">
                                </td>
                            <?php else: ?>
                                <td colspan="3">
                                    <input type="text" name="subject" id="subject" class="form-control" value="<?= esc(isset($row) ? $row['subject'] : '') ?>">
                                </td>
                            <?php endif; ?>
                        </tr>
                        <?php if ($code == 'competition'): ?>
                            <tr>
                                <th style="background-color: #d0ebff;">베스트</th>
                                <td colspan="3">
                                    <input type="text" name="keyword" id="keyword" class="form-control"
                                           value="<?= esc(isset($row) ? $row['keyword'] : '') ?>">
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($code == 'recruitment'): ?>
                            <tr>
                                <th style="background-color: #d0ebff;">회사명</th>
                                <td colspan="3">
                                    <input type="text" name="company_name" id="company_name" class="form-control"
                                           value="<?= esc($row['company_name'] ?? '') ?>">
                                </td>
                            </tr>

                            <tr>
                                <th style="background-color: #d0ebff;">분야</th>
                                <td colspan="3">
                                <textarea class="form-control" id="contents2" rows="5"
                                          name="contents2"><?= $row['contents2'] ?? '' ?></textarea>
                                </td>
                            </tr>

                            <tr>
                                <th style="background-color: #d0ebff;">시작일</th>
                                <td colspan="">
                                    <input type="text" name="s_date" id="s_date" class="form-control datepicker"
                                           value="<?= esc(isset($row) ? $row['s_date'] : '') ?>" readonly
                                           autocomplete="off">
                                </td>
                                <th style="background-color: #d0ebff;">종료일</th>
                                <td colspan="">
                                    <input type="text" name="e_date" id="e_date" class="form-control datepicker"
                                           value="<?= esc(isset($row) ? $row['e_date'] : '') ?>" readonly
                                           autocomplete="off">
                                </td>
                            </tr>

                            <tr>
                                <th style="background-color: #d0ebff;">접수 방법</th>
                                <td>
                                    <input type="text" name="apply_method" id="apply_method" class="form-control"
                                           value="<?= esc($row['apply_method'] ?? '') ?>">
                                </td>
                                <th style="background-color: #d0ebff;">채용 구분</th>
                                <td>
                                    <input type="text" name="recruit_type" id="recruit_type" class="form-control"
                                           value="<?= esc($row['recruit_type'] ?? '') ?>">
                                </td>
                            </tr>

                            <tr>
                                <th style="background-color: #d0ebff;">고용 형태</th>
                                <td>
                                    <input type="text" name="employment_type" id="employment_type" class="form-control"
                                           value="<?= esc($row['employment_type'] ?? '') ?>">
                                </td>
                                <th style="background-color: #d0ebff;">지원 자격</th>
                                <td>
                                    <input type="text" name="qualification" id="qualification" class="form-control"
                                           value="<?= esc($row['qualification'] ?? '') ?>">
                                </td>
                            </tr>

                            <tr>
                                <th style="background-color: #d0ebff;">기관 유형</th>
                                <td>
                                    <input type="text" name="organization_type" id="organization_type"
                                           class="form-control"
                                           value="<?= esc($row['organization_type'] ?? '') ?>">
                                </td>
                                <th style="background-color: #d0ebff;">근무 지역</th>
                                <td>
                                    <input type="text" name="work_location" id="work_location" class="form-control"
                                           value="<?= esc($row['work_location'] ?? '') ?>">
                                </td>
                            </tr>

                            <tr>
                                <th style="background-color: #d0ebff;">담당자</th>
                                <td>
                                    <input type="text" name="manager_name" id="manager_name" class="form-control"
                                           value="<?= esc($row['manager_name'] ?? '') ?>">
                                </td>
                                <th style="background-color: #d0ebff;">연락처</th>
                                <td>
                                    <input type="text" name="contact_phone" id="contact_phone" class="form-control"
                                           value="<?= esc($row['contact_phone'] ?? '') ?>">
                                </td>
                            </tr>

                            <tr>
                                <th style="background-color: #d0ebff;">첨부파일</th>
                                <td colspan="3">
                                    <input type="file" name="attachment" id="attachment" class="form-control w-auto">
                                    <br>
                                    <?php if (isset($row['ufile2'])): ?>
                                        <a href="/uploads/bbs/<?= $row['ufile2'] ?>"
                                           download="<?= $row['ufile2'] ?>">
                                            <?= $row['rfile2'] ?>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <tr>
                                <th style="background-color: #d0ebff;">주소</th>
                                <td colspan="3">
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="text" name="zip" id="sample2_postcode" class="form-control"
                                               style="width:100px;"
                                               value="<?= esc($row['zip'] ?? '') ?>">
                                        <button type="button" onclick="openPostCode()" class="btn btn-outline-dark">
                                            우편번호
                                        </button>
                                        <input type="text" name="addr1" id="sample2_address" class="form-control"
                                               style="width:40%;"
                                               value="<?= esc($row['addr1'] ?? '') ?>">
                                        <input type="text" name="addr2" id="sample2_detailAddress" class="form-control"
                                               style="width:20%;"
                                               value="<?= esc($row['addr2'] ?? '') ?>">
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th style="background-color: #d0ebff;">기관유형</th>
                                <td>
                                    <input type="text" name="company_type" id="company_type" class="form-control"
                                           value="<?= esc($row['company_type'] ?? '') ?>">
                                </td>
                                <th style="background-color: #d0ebff;">대표전화</th>
                                <td>
                                    <input type="text" name="company_phone" id="company_phone" class="form-control"
                                           value="<?= esc($row['company_phone'] ?? '') ?>">
                                </td>
                            </tr>

                            <tr>
                                <th style="background-color: #d0ebff;">홈페이지</th>
                                <td>
                                    <input type="text" name="homepage" id="homepage" class="form-control"
                                           value="<?= esc($row['homepage'] ?? '') ?>">
                                </td>
                                <th style="background-color: #d0ebff;">대표주소</th>
                                <td>
                                    <input type="text" name="company_address" id="company_address" class="form-control"
                                           value="<?= esc($row['company_address'] ?? '') ?>">
                                </td>
                            </tr>
                        <?php endif; ?>

                        <tr>
                            <?php if ($code == 'association'): ?>
                                <th style="background-color: #d0ebff;">조회수</th>
                                <td colspan="">
                                    <input disabled="disabled" type="text" name="view_count" id="view_count" class="form-control" value="<?= esc(isset($row) ? $row['view_count'] : '') ?>">
                                </td>
                            <?php else : ?>
                                <th style="background-color: #d0ebff;">조회</th>
                                <td colspan="">
                                    <input type="text" name="hit" id="hit" class="form-control"
                                        value="<?= esc(isset($row) ? $row['hit'] : '') ?>">
                                </td>
                            <?php endif; ?>

                            <?php if ($code == 'association'): ?>
                                <th style="background-color: #d0ebff;">이미지</th>
                                <td colspan="3">
                                    <input type="file" name="image_upload" id="image_upload" class="form-control" accept="image/*">
                                    <?php if (isset($row) && !empty($row['ufile3'])): ?>
                                        <div style="position:relative; display:inline-block; margin-top:8px;" id="image-preview-wrap">
                                            <img src="/uploads/bbs/<?= $row['ufile3'] ?>" alt="<?= $row['rfile3'] ?>" style="max-width:100px; display:block;">
                                            <button type="button" onclick="clearImage()"
                                                style="position:absolute; top:-8px; right:-8px; width:20px; height:20px; border-radius:50%; background:#ff4d4f; border:none; color:#fff; font-size:12px; line-height:1; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                                                ✕
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            <?php else : ?>
                                <th style="background-color: #d0ebff;">
                                    <?php if ($code == 'recruitment'): ?>
                                        LOGO
                                    <?php endif; ?>
                                    <?php if ($code == 'notice' || $code == 'promotion' || $code == 'member_resource'): ?>
                                        첨부파일
                                    <?php endif; ?>

                                    <?php if ($code == 'competition'): ?>
                                        파일
                                    <?php endif; ?>
                                </th>
                                <td colspan="">
                                    <input type="file" name="file_upload" id="file_upload" class="form-control">
                                    <?php if (isset($row)): ?>
                                        <a href="/uploads/bbs/<?= $row['ufile1'] ?>"
                                        download="<?= $row['rfile1'] ?>">
                                            <?= $row['rfile1'] ?>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>   
                        </tr>
                                    
                        <tr>
                            <th style="background-color: #d0ebff;">우선순위</th>
                            <td colspan="">
                                <input type="text" name="onum" id="onum" class="form-control"
                                       value="<?= esc(isset($row) ? $row['onum'] : '') ?>">
                            </td>
                            <th style="background-color: #d0ebff;">생성일</th>
                            <td colspan="">
                                <?= date('Y-m-d H:i:s') ?>
                            </td>
                        </tr>
                        
                        <?php if ($code !== 'association'): ?>
                        <tr>
                            <th style="background-color: #d0ebff;">내용</th>
                            <td colspan="3">
                                <textarea class="form-control summernote" id="contents"
                                          name="contents"><?= $row['contents'] ?? '' ?></textarea>
                            </td>
                        </tr>
                        <?php endif; ?>

                        </tbody>
                    </table>
                </div>

            </form>
        </div>
    </section>

    <div class="d-flex w-100 justify-content-end mb-2 gap-2">
        <a href="<?= site_url('AdmMaster/_bbs/list?code='.$code) ?>"
           class="btn btn-outline-secondary">
            <i class="bi bi-list-task"></i> 목록
        </a>

        <button type="button"
                onclick="submitForm();"
                class="btn btn-primary">
            <i class="bi bi-gear-fill me-1"></i> 저장
        </button>
    </div>
    <div id="layer" style="display:none;position:fixed;overflow:hidden;z-index:1999;-webkit-overflow-scrolling:touch;">
        <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer"
             style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()"
             alt="닫기 버튼">
    </div>
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
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
        $(document).ready(function () {
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
                    onImageUpload: function (files) {
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
            const form = document.courseForm;
            const formData = new FormData(form);

            try {
                const res = await fetch('/AdmMaster/_bbs/write_ok', {
                    method: 'POST',
                    body: formData
                });

                const data = await res.json();
                alert(data.message);
                if (data.status == 'success') {
                    window.location.href = '/AdmMaster/_bbs/list?code=<?= $code ?>';
                }
            } catch (err) {
                alert('오류가 발생했습니다!');
                console.error(err);
            }
        }
    </script>
    <script>
        async function startUpload() {
            const fileInput = document.getElementById('file_upload');
            const files = fileInput.files;

            if (files.length === 0) {
                alert("Vui lòng chọn ít nhất một file!");
                return;
            }

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                await uploadLargeFile(file);
            }
        }

        async function handleMultipleUploads(inputElement) {
            const files = inputElement.files;

            for (let i = 0; i < files.length; i++) {
                console.log(`Đang tải file ${i + 1}/${files.length}: ${files[i].name}`);
                await uploadLargeFile(files[i]);
            }
        }

        async function uploadLargeFile(file) {
            const chunkSize = 2 * 1024 * 1024;
            const totalChunks = Math.ceil(file.size / chunkSize);
            const identifier = Math.random().toString(36).substring(2) + Date.now();

            for (let chunkIndex = 0; chunkIndex < totalChunks; chunkIndex++) {
                const chunk = file.slice(chunkIndex * chunkSize, (chunkIndex + 1) * chunkSize);
                const formData = new FormData();

                formData.append('file', chunk);
                formData.append('chunkIndex', chunkIndex);
                formData.append('totalChunks', totalChunks);
                formData.append('filename', file.name);
                formData.append('identifier', identifier);

                await $.ajax({
                    url: '/api/upload/chunk',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false
                });
            }
        }
    </script>

    <script>
        document.getElementById('image_upload').addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                // Xóa preview cũ nếu có
                const oldWrap = document.getElementById('image-preview-wrap');
                if (oldWrap) oldWrap.remove();

                // Tạo preview mới
                const wrap = document.createElement('div');
                wrap.id = 'image-preview-wrap';
                wrap.style.cssText = 'position:relative; display:inline-block; margin-top:8px;';

                wrap.innerHTML = `
                    <img src="${e.target.result}" style="max-width:100px; display:block;">
                    <button type="button" onclick="clearImage()"
                        style="position:absolute; top:-8px; right:-8px; width:20px; height:20px; border-radius:50%; background:#ff4d4f; border:none; color:#fff; font-size:12px; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                        ✕
                    </button>
                `;

                // Chèn sau input
                document.getElementById('image_upload').insertAdjacentElement('afterend', wrap);
            };
            reader.readAsDataURL(file);
        });

        function clearImage() {
            document.getElementById('image_upload').value = '';
            document.getElementById('image-preview-wrap')?.remove();
        }
    </script>
    <script>
        function clearImage() {
            document.getElementById('image_upload').value = '';
            document.getElementById('image-preview-wrap')?.remove();
        }
    </script>
<?= $this->endSection() ?>