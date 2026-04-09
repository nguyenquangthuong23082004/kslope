$(document).ready(function () {
    const contents = {
        required: {
            title: "약관 동의",
        },
        optional: {
            title: "기본 정보 동의",
        },
    }

    $(".popup-close").on("click", function () {
        $("#agreePopup").hide();
    });

    $("#agreePopup").on("click", function (e) {
        if ($(e.target).is("#agreePopup")) {
            $("#agreePopup").hide();
        }
    })

    $('.btn-agree-info').click(function () {
        let type = $(this).data('type');

        let titleEl = contents[type].title;
        $('#agreePopup').css('display', 'flex')

        $('#popupTitle').text(titleEl);

        if (type == 'required') {
            $('#content1').show();
            $('#content2').hide();
        } else {
            $('#content1').hide();
            $('#content2').show();
        }
    })

    $('#agree_all').on('change', function () {
        const checked = $(this).is(':checked');
        $('#agree1, #agree2').prop('checked', checked);
    });

    $('#agree1, #agree2').on('change', function () {
        const total = $('#agree1, #agree2').length;
        const checked = $('#agree1:checked, #agree2:checked').length;

        $('#agree_all').prop('checked', total === checked);
    });
})

document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById("btnBizFile");
    const fileInput = document.getElementById("bizFileInput");
    const fileNameInput = document.getElementById("bizFileName");

    btn.addEventListener("click", function () {
        fileInput.click();
    });

    fileInput.addEventListener("change", function () {
        if (this.files.length > 0) {
            fileNameInput.value = this.files[0].name;
        } else {
            fileNameInput.value = "";
        }
    });
});

// function execDaumPostcode() {
//     new daum.Postcode({
//         oncomplete: function (data) {
//             document.getElementById("zipcode").value = data.zonecode;
//             document.getElementById("address").value = data.address;
//             document.getElementById("addressDetail").focus();
//         }
//     }).open();
// }


var element_layer = document.getElementById('layer');

function execDaumPostcode() {
    new daum.Postcode({
        oncomplete: function (data) {
            console.log("data", data);

            document.getElementById("zipcode").value = data.zonecode;
            document.getElementById("address").value = data.address;
            document.getElementById("addressDetail").focus();

            element_layer.style.display = 'none';
        },
        width: '100%',
        height: '100%',
        maxSuggestItems: 5
    }).embed(element_layer);

    element_layer.style.display = 'block';

    initLayerPosition();
}



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

function closeDaumPostcode() {
    // iframe을 넣은 element를 안보이게 한다.
    element_layer.style.display = 'none';
}

async function sendSms() {
    let mobile1 = $('#mobile1').val();
    let mobile2 = $('#mobile2').val();
    let mobile3 = $('#mobile3').val();

    if (!mobile1 || !mobile2 || !mobile3) {
        alert('전화번호를 입력해주세요.');
        $('#mobile2').focus();
        return false;
    }

    let phone = mobile1 + mobile2 + mobile3;

    let url = '/member/send_sms'
    let data = {
        tophone: phone,
    }

    $.ajax({
        url: url,
        method: 'POST',
        data: data,
        success: function (response) {
            console.log(response)
            alert(response.message);
            $('#verify_code').focus();
        },
        error: function (exception) {
            alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
            console.log(exception)
        }
    });
}

async function sendSms2() {
    let mobile1 = $('#mobile1_2').val();
    let mobile2 = $('#mobile2_2').val();
    let mobile3 = $('#mobile3_2').val();

    if (!mobile1 || !mobile2 || !mobile3) {
        alert('전화번호를 입력해주세요.');
        $('#mobile2_2').focus();
        return false;
    }

    let phone = mobile1 + mobile2 + mobile3;

    let url = '/member/send_sms'
    let data = {
        tophone: phone,
    }

    $.ajax({
        url: url,
        method: 'POST',
        data: data,
        success: function (response) {
            console.log(response)
            alert(response.message);
            $('#verify_code2').focus();
        },
        error: function (exception) {
            alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
            console.log(exception)
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.number-only').forEach(function(input) {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            
            if (this.value.length >= parseInt(this.maxLength) && this.dataset.next) {
                document.querySelector(`[name="${this.dataset.next}"]`)?.focus();
            }
        });
        
        input.addEventListener('keypress', function(e) {
            if (!/[0-9]/.test(e.key)) e.preventDefault();
        });
        
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !this.value && this.dataset.prev) {
                document.querySelector(`[name="${this.dataset.prev}"]`)?.focus();
            }
        });
        
        input.addEventListener('paste', function(e) {
            setTimeout(() => this.value = this.value.replace(/[^0-9]/g, ''), 0);
        });
        
        input.setAttribute('inputmode', 'numeric');
    });
});

function validateLength(value) {
    return value.length >= 6 && value.length <= 20;
}

async function chkID() {
    let user_id = $('#user_id').val();

    if (!user_id) {
        alert('ID를 입력해 주세요.');
        $('#user_id').focus();
        return false;
    }

    let isValid = validateLength(user_id);
    if (!isValid) {
        alert('6~20자 이내로 입력해주세요.');
        return false;
    }

    let url = '/member/chk_id';
    let data = {
        user_id: user_id,
    }

    $.ajax({
        url: url,
        method: 'POST',
        data: data,
        success: function (response) {
            console.log(response)
            alert(response.message);
            $('#id_chk').val('Y');
            $('#btnChkID').prop('disabled', true).addClass('disabled');
        },
        error: function (exception) {
            alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
            console.log(exception)
        }
    });
}

async function chkPhone() {
    let verify_code = $('#verify_code').val();
    let user_id = $('#user_id').val();

    if (!verify_code) {
        alert('인증 코드를 입력해 주세요.');
        $('#verify_code').focus();
        return false;
    }

    let url = '/member/chk_phone';
    let data = {
        user_id: user_id,
        verify_code: verify_code,
    }

    $.ajax({
        url: url,
        method: 'POST',
        data: data,
        success: function (response) {
            console.log(response)
            alert(response.message);
            $('#phone_chk').val('Y');
            $('#btnChkPhone').prop('disabled', true).addClass('disabled');
        },
        error: function (exception) {
            alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
            console.log(exception)
        }
    });
}

async function chkPhone2() {
    let verify_code = $('#verify_code2').val();
    let user_id = $('#user_id').val();

    if (!verify_code) {
        alert('인증 코드를 입력해 주세요.');
        $('#verify_code2').focus();
        return false;
    }

    let url = '/member/chk_phone';
    let data = {
        user_id: user_id,
        verify_code: verify_code,
    }

    $.ajax({
        url: url,
        method: 'POST',
        data: data,
        success: function (response) {
            console.log(response)
            alert(response.message);
            $('#phone_chk').val('Y');
            $('#btnChkPhone2').prop('disabled', true).addClass('disabled');
        },
        error: function (exception) {
            alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
            console.log(exception)
        }
    });
}

// function validatePassword(password) {
//     const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,20}$/;
//     return regex.test(password);
// }

function validatePassword(password) {
    const lower = password.toLowerCase();
    const regex = /^(?=.*[a-z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,16}$/;
    return regex.test(lower);
}

function normalizePw() {
    const pw = document.getElementById('password');
    const cpw = document.getElementById('conf_password');
    pw.value = pw.value.toLowerCase();
    cpw.value = cpw.value.toLowerCase();
}

async function submitForm() {
    normalizePw();
    let frm = document.frm;
    let formData = new FormData(frm);
    let url = '/member/member_reg_ok';

    let phone_chk = $('#phone_chk').val();
    let id_chk = $('#id_chk').val();

    let password = $('#password').val();
    let conf_password = $('#conf_password').val();

    let isValid = validatePassword(password);
    if (!isValid) {
        alert('비밀번호는 8~20자의 영문 대/소문자, 숫자, 특수문자를 모두 포함해야 합니다.');
        $('#password').focus();
        return false;
    }

    let chk1 = $('#agree1').prop('checked');
    let chk2 = $('#agree2').prop('checked');

    if (!phone_chk || phone_chk !== 'Y') {
        alert('휴대폰 번호 중복 여부를 확인해 주세요.');
        return false;
    }

    if (!id_chk || id_chk !== 'Y') {
        alert('ID 중복 여부를 확인해 주세요.');
        return false;
    }

    if (!chk1 || !chk2) {
        alert('이용 약관 및 조건에 동의해 주세요.');
        return false;
    }

    if (password !== conf_password) {
        alert('비밀번호가 일치하지 않습니다.')
        return false;
    }

    $.ajax({
        url: url,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);
            // var mIdx = response.data.mIdx;
            // var memberType = response.data.member_type;

            // var link = '/membership_infomation/' + mIdx;

            // if (memberType === 'G') {
            //     link = '/membership_group/' + mIdx;
            // } else if (memberType === 'S') {
            //     link = '/membership_special/' + mIdx;
            // }
            // $('#membership_link').attr('href', link);
            // $('.popup_step').addClass('active');
            alert(response.message);
            window.location.href = '/';
        },
        error: function (exception) {
            alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
            console.log(exception)
        }
    });
}

async function send_it() {
    normalizePw();
    let frm = document.frm;
    let formData = new FormData(frm);
    let url = '/member/member_reg_ok';

    let phone_chk = $('#phone_chk').val();
    let id_chk = $('#id_chk').val();

    let password = $('#password').val();
    let conf_password = $('#conf_password').val();

    let isValid = validatePassword(password);
    if (!isValid) {
        alert('비밀번호는 8~20자의 영문 대/소문자, 숫자, 특수문자를 모두 포함해야 합니다.');
        $('#password').focus();
        return false;
    }

    let chk1 = $('#agree1').prop('checked');
    let chk2 = $('#agree2').prop('checked');

    if (!phone_chk || phone_chk !== 'Y') {
        alert('휴대폰 번호 중복 여부를 확인해 주세요.');
        return false;
    }

    if (!id_chk || id_chk !== 'Y') {
        alert('ID 중복 여부를 확인해 주세요.');
        return false;
    }

    if (!chk1 || !chk2) {
        alert('이용 약관 및 조건에 동의해 주세요.');
        return false;
    }

    if (password !== conf_password) {
        alert('비밀번호가 일치하지 않습니다.')
        return false;
    }

    $.ajax({
        url: url,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);
            var mIdx = response.data.mIdx;
            var memberType = response.data.member_type;

            var link = '/membership_infomation/' + mIdx;

            if (memberType === 'G') {
                link = '/membership_group/' + mIdx;
            } else if (memberType === 'S') {
                link = '/membership_special/' + mIdx;
            }

            window.location.href = link;
            // $('#membership_link').attr('href', link);
        },
        error: function (exception) {
            alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
            console.log(exception)
        }
    });
}