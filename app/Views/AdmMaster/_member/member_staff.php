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
            <input type="hidden" name="id_chk" id="id_chk" value="">
            <input type="hidden" name="manager_id" id="manager_id" value="<?= $id ?>">
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
                            <tr>
                                <th style="background-color: #d0ebff;">아이디</th>
                                <td colspan="">
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="text" id="user_id" name="user_id" class="form-control w-25" placeholder="">
                                        <button type="button" id="btnChkID" class="btn btn-outline-primary" onclick="chkID()">중복체크
                                        </button>
                                    </div>
                                </td>
                                <th style="background-color: #d0ebff;">비밀번호</th>
                                <td colspan="3">
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="password"
                                            name="password"
                                            id="password"
                                            class="form-control w-25"
                                            value="">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th style="background-color: #d0ebff;">성명</th>
                                <td colspan="">
                                    <input type="text"
                                        name="user_name"
                                        class="form-control"
                                        value="">
                                </td>
                                <th style="background-color: #d0ebff;">이메일</th>
                                <td colspan="">
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="text"
                                            name="user_email"
                                            class="form-control w-50"
                                            value="">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th style="background-color: #d0ebff;">사무실 전화번호</th>
                                <td colspan="">
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="text"
                                            name="phone1"
                                            class="form-control"
                                            style="max-width: 120px;"
                                            maxlength="3"
                                            placeholder="010"
                                            pattern="[0-9]{2,3}"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            value="">
                                        <span>-</span>
                                        <input type="text"
                                            name="phone2"
                                            class="form-control"
                                            style="max-width: 120px;"
                                            maxlength="4"
                                            placeholder=""
                                            pattern="[0-9]{3,4}"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            value="">
                                        <span>-</span>
                                        <input type="text"
                                            name="phone3"
                                            class="form-control"
                                            style="max-width: 120px;"
                                            maxlength="4"
                                            placeholder=""
                                            pattern="[0-9]{4}"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            value="">
                                    </div>
                                </td>
                                <th style="background-color: #d0ebff;">직급</th>
                                <td colspan="">
                                    <input type="text"
                                        name="work_position"
                                        class="form-control"
                                        value="">
                                </td>
                            </tr>
                            <tr>
                                <th style="background-color: #d0ebff;">교육 수강</th>
                                <td colspan="3">
                                    <div style="max-height: 200px; overflow-y: auto; border: 1px solid #dee2e6; padding: 10px; border-radius: 4px;">
                                        <?php if (isset($courses) && !empty($courses)): ?>
                                            <div class="form-check mb-3 pb-2" style="border-bottom: 2px solid #dee2e6;">
                                                <input class="form-check-input"
                                                    type="checkbox"
                                                    id="select_all_courses"
                                                    onclick="toggleAllCourses(this)">
                                                <label class="form-check-label fw-bold" for="select_all_courses">
                                                    전체 선택
                                                </label>
                                            </div>
                                            <?php foreach ($courses as $course): ?>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input course-checkbox"
                                                        type="checkbox"
                                                        name="course_idx[]"
                                                        value="<?= esc($course['idx']) ?>"
                                                        id="course_<?= esc($course['idx']) ?>">
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
                        </tbody>
                    </table>
                </div>
            </div>

        </form>
    </div>

    <div class="mt-4 d-flex justify-content-end align-items-center">
        <div class="d-flex gap-2">
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
<script>
    // 우편번호 찾기 화면을 넣을 element
    var element_layer = document.getElementById('layer');

    function closeDaumPostcode() {
        // iframe을 넣은 element를 안보이게 한다.
        element_layer.style.display = 'none';
    }

    function openPostCode() {
        new daum.Postcode({
            oncomplete: function(data) {
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
            oncomplete: function(data) {
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
    function chkID() {
        let user_id = document.getElementById('user_id').value.trim();

        if (!user_id) {
            alert('ID를 입력해 주세요.');
            document.getElementById('user_id').focus();
            return;
        }

        if (user_id.length < 6 || user_id.length > 20) {
            alert('6~20자 이내로 입력해주세요.');
            return;
        }

        let formData = new FormData();
        formData.append('user_id', user_id);

        fetch('/member/chk_id', {
                method: 'POST',
                body: formData
            })
            .then(async response => {
                const data = await response.json();

                alert(data.message);

                if (response.ok && data.status === 'success') {
                    document.getElementById('id_chk').value = 'Y';
                    document.getElementById('btnChkID').disabled = true;
                    document.getElementById('btnChkID').classList.add('disabled');
                    document.getElementById('user_id').readOnly = true;
                } else {
                    document.getElementById('id_chk').value = '';
                }
            })
            .catch(error => {
                alert('오류가 발생했습니다!');
                console.error(error);
            });
    }
</script>

<script>
    function submitForm() {
        let frm = document.updateForm;
        let formData = new FormData(frm);

        let id_chk = document.getElementById('id_chk').value;

        if (!id_chk || id_chk !== 'Y') {
            alert('ID 중복 여부를 확인해 주세요.');
            return false;
        }

        if (!formData.get('user_id')) {
            alert('아이디를 입력해 주세요.');
            return false;
        }

        if (!formData.get('password')) {
            alert('비밀번호를 입력해 주세요.');
            return false;
        }

        if (!formData.get('user_name')) {
            alert('성명을 입력해 주세요.');
            return false;
        }

        if (!formData.get('user_email')) {
            alert('이메일을 입력해 주세요.');
            return false;
        }

        let url = '/AdmMaster/_members/staff_create';

        fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                alert(data.message);
                window.location.href = document.referrer;
            })
            .catch(error => {
                alert('오류가 발생했습니다!');
                console.log(error);
            });
    }

    document.getElementById('user_id').addEventListener('input', function() {
        if (document.getElementById('id_chk').value === 'Y') {
            document.getElementById('id_chk').value = '';
            document.getElementById('btnChkID').disabled = false;
            document.getElementById('btnChkID').classList.remove('disabled');
            this.readOnly = false;
        }
    });
</script>
<?= $this->endSection() ?>