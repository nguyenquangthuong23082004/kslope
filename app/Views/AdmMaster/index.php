<!DOCTYPE HTML>
<html lang="ko">

<head>
  <title><?= esc($site['site_name'] ?? '') ?> 관리자</title>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />

  <meta property="og:type" content="website">
  <meta name="twitter:card" content="summary">

  <link rel="stylesheet" href="<?= base_url('admin/css/import.css') ?>">
  <link rel="stylesheet" href="<?= base_url('admin/css/adm_login.css') ?>">

  <meta property="og:title" content="<?= esc($site['og_title'] ?? '') ?>">
  <meta property="og:site_name" content="<?= esc($site['og_site'] ?? '') ?>">
  <meta property="og:description" content="<?= esc($site['og_des'] ?? '') ?>">
  <meta property="og:url" content="<?= esc($site['og_url'] ?? '') ?>">
  <meta property="og:image" content="<?= esc($site['og_img'] ?? '') ?>">

  <meta name="keywords" content="<?= esc($site['meta_keyword'] ?? '') ?>">
  <meta name="description" content="<?= esc($site['meta_tag'] ?? '') ?>">

  <script src="/js/jquery-1.11.1.min.js"></script>
  <link rel="stylesheet" href="/js/jquery-ui-1.11.2.custom/jquery-ui.css">
  <script type="text/javascript" src="/js/jquery.number.js"></script>
  <script src="/js/jquery-ui-1.11.2.custom/jquery-ui.js"></script>
  <script src="/js/notifIt.js" type="text/javascript"></script>
  <link href="/js/notifIt.css" type="text/css" rel="stylesheet">
  <!--notice 스크립트끝-->
  <script src="/js/common.js"></script>
  <script src="/js/jquery.form.js"></script>
  <style type="text/css">
    .wrap-loading {
      /*화면 전체를 어둡게 합니다.*/
      position: fixed;
      left: 0;
      right: 0;
      top: 0;
      bottom: 0;
      z-index: 999;
      background: rgba(0, 0, 0, 0.2);
      /*not in ie */
      filter: progid:DXImageTransform.Microsoft.Gradient(startColorstr='#20000000', endColorstr='#20000000');
      /* ie */
    }

    .wrap-loading div {
      /*로딩 이미지*/
      position: fixed;
      top: 50%;
      left: 50%;
      margin-left: -21px;
      margin-top: -21px;
    }

    .display-none {
      /*감추기*/
      display: none;
    }
  </style>


</head>

<body>
  <div id="ajax_loader" class="wrap-loading display-none">
    <div><img src="/js/ajax-loader.gif" /></div>
  </div>

  <div class="bk_box">

    <?php if (session()->getFlashdata('error')) : ?>
      <script>
        function alertData() {
          alert('<?= session()->getFlashdata('error') ?>');
          return false;
        }

        alertData();
      </script>
    <?php endif; ?>

    <div class="login_cell">
      <div class="login_wrap">
        <div class="login_logo">
          <h1>Welcome to Back<br>한국급경사지안전협회</h1>
        </div>
        <div class="login_form">
          <form action="<?= site_url('AdmMaster/login') ?>" method="post" name="loginForm">
            <?= csrf_field() ?>
            <div class="login_box">
              <h2>관리자 로그인</h2>

              <input type="text" name="user_id" placeholder="아이디" value="" onkeyup="javascript:press_it()" style="ime-mode:disabled" />

              <input type="password" name="user_pw" placeholder="비밀번호" value="" onkeyup="javascript:press_it()" />

              <div class="save_id">
                <input type="checkbox" name="saveId" value="Y" id="save_id" class="input_checkbox" onkeypress="javascript:press_it()" />
                <label for="save_id">아이디 저장</label>
              </div>

              <a href="javascript:loginSendit();" class="login_btn">로그인</a>
            </div>

          </form>
        </div>
        <p class="copy">designed by uwal communication</p>
      </div>
    </div>

    <!-- <div class="btm">
		<p class="bar"><img src="/AdmMaster/_images/login/bar.png"></p>
		<ul class="btm_guide">
			<li>- 관리자모드 접속화면으로 허가된 관계자만 이용 하시기 바랍니다.</li>
		</ul>
	</div> -->







  </div>

  <script>
    function loginSendit() {
      var form = document.loginForm;
      if (form.user_id.value == "" || form.user_id.value == "아이디") {
        alert_("아이디를 입력해 주십시오.");
        form.user_id.value = "";
        form.user_id.focus();
        return;
      }
      if (form.user_pw.value == "" || form.user_pw.value == "비밀번호") {
        alert_("비밀번호를 입력해 주십시오.");
        form.user_pw.value = "";
        form.user_pw.focus();
        return;
      }

      if (form.saveId.checked) {
        saveLogin(form.user_id.value);
      } else {
        saveLogin("");
      }

      form.submit();
    }


    function press_it() {
      if (event.keyCode == 13) {
        loginSendit();
      }
    }


    function focusin() {
      document.loginForm.user_id.focus();
    }

    // 쿠키값 가져오기
    function getCookie(key) {
      var cook = document.cookie + ";";
      var idx = cook.indexOf(key, 0);
      var val = "";

      if (idx != -1) {
        cook = cook.substring(idx, cook.length);
        begin = cook.indexOf("=", 0) + 1;
        end = cook.indexOf(";", begin);
        val = unescape(cook.substring(begin, end));
      }

      return val;
    }

    // 쿠키값 설정
    function setCookie(name, value, expiredays) {
      var today = new Date();
      today.setDate(today.getDate() + expiredays);
      document.cookie = name + "=" + escape(value) + "; path=/; expires=" + today.toGMTString() + ";"
    }

    // 쿠키에서 로그인 정보 가져오기
    function getLogin() {
      var form = document.loginForm;

      // user_id 쿠키에서 id 값을 가져온다.
      var id = getCookie("user_id");

      // 가져온 쿠키값이 있으면
      if (id != "") {
        form.user_id.value = id;
        form.saveId.checked = true;
      }
    }
    //암호화
    function Encrypt(theText) {
      output = new String;
      Temp = new Array();
      Temp2 = new Array();
      TextSize = theText.length;
      for (i = 0; i < TextSize; i++) {
        rnd = Math.round(Math.random() * 122) + 68;
        Temp[i] = theText.charCodeAt(i) + rnd;
        Temp2[i] = rnd;
      }
      for (i = 0; i < TextSize; i++) {
        output += String.fromCharCode(Temp[i], Temp2[i]);
      }
      return output;
    }

    //복호화
    function unEncrypt(theText) {
      output = new String;
      Temp = new Array();
      Temp2 = new Array();
      TextSize = theText.length;
      for (i = 0; i < TextSize; i++) {
        Temp[i] = theText.charCodeAt(i);
        Temp2[i] = theText.charCodeAt(i + 1);
      }
      for (i = 0; i < TextSize; i = i + 2) {
        output += String.fromCharCode(Temp[i] - Temp2[i]);
      }
      return output;
    }

    // 쿠키에 로그인 정보 저장
    function saveLogin(id) {

      if (id != "") {
        // user_id 쿠키에 id 값을 7일간 저장
        setCookie("user_id", id, 70);
      } else {
        // user_id 쿠키 삭제
        setCookie("user_id", id, -1);
      }
    }
    getLogin();
  </script>

</body>

</html>