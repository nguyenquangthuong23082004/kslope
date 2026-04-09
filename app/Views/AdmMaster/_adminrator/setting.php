<?= $this->extend('AdmMaster/inc/layout') ?>

<link href="<?= base_url('admin/css/sms_contents.css') ?>" rel="stylesheet">

<style type="text/css">
    .radio_sel span {
        margin-right: 15px;
    }
</style>
<?= $this->section('content') ?>
<?php if (session()->getFlashdata('success')): ?>
    <script>
        alert("<?= esc(session()->getFlashdata('success')) ?>");
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <script>
        alert("<?= esc(session()->getFlashdata('error')) ?>");
    </script>
<?php endif; ?>
<section class="section">
    <div class="page-heading mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <header class="d-block d-xl-none pb-2">
                <a href="#" class="d-block burger-btn d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <h4 class="text-center">쇼핑몰 기본설정</h4>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-end align-items-center">
            <div class="d-flex" style="gap: 5px;">
                <a href="javascript:send_its()" class="btn btn btn-primary"><i class="bi bi-gear"></i><span class="txt">수정</span></a>
            </div>
        </div>
        <div class="card-body mt-4">
            <form name="frm" id="frm" action="<?= base_url('AdmMaster/_adminrator/update') ?>"
                method="post"
                enctype="multipart/form-data">


                <div class="listTop">
                    <div class="left">
                        <p class="schTxt">■ 기본정보 & 도메인</p>
                    </div>
                </div>
                <!-- // listTop -->


                <div class="listBottom">

                    <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail">
                        <caption>
                        </caption>
                        <colgroup>
                            <col width="150px" />
                            <col width="*" />
                            <col width="150px" />
                            <col width="*" />
                        </colgroup>
                        <tbody>
                            <tr>
                                <th>쇼핑몰명</th>
                                <td><input type="text" id="site_name" name="site_name"
                                        value="<?= esc($site['site_name'] ?? '') ?>" class="form-control placeHolder"
                                        rel="" style="width:200px" /> _IT_SITE_NAME
                                </td>
                                <th>관리자명</th>
                                <td>
                                    <input type="text" id="admin_name" name="admin_name"
                                        value="<?= esc($site['admin_name'] ?? '') ?>"
                                        class="form-control placeHolder" rel="" style="width:200px" /> _IT_ADMIN_NAME
                                </td>
                            </tr>

                            <tr>
                                <th>쇼핑몰 대표 도메인</th>
                                <td><input type="text" id="domain_url" name="domain_url"
                                        value="<?= esc($site['domain_url'] ?? '') ?>"
                                        class="form-control placeHolder"
                                        rel="" style="width:200px" /> _IT_DOMAIN_URL
                                </td>
                                <th>관리자 이메일</th>
                                <td>
                                    <input type="text" id="admin_email" name="admin_email"
                                        value="<?= esc($site['admin_email'] ?? '') ?>" class="form-control placeHolder" rel=""
                                        style="width:200px" /> _IT_ADMIN_EMAIL
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>


                <div class="listTop">
                    <div class="left">
                        <p class="schTxt">■ 사이트 기본값</p>
                    </div>
                </div>
                <!-- // listTop -->

                <div class="listBottom">
                    <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail ">
                        <caption>
                        </caption>
                        <colgroup>
                            <col width="150px" />
                            <col width="*" />
                            <col width="150px" />
                            <col width="*" />
                        </colgroup>
                        <tbody>

                            <tr>
                                <th>브라우져 타이틀</th>
                                <td colspan="3"><input type="text" id="browser_title" name="browser_title"
                                        value="<?= esc($site['browser_title'] ?? '') ?>" class="form-control placeHolder" rel=""
                                        style="width:70%;" /> _IT_BROWSER_TITLE
                                </td>
                            </tr>

                            <tr>
                                <th>메타 테그</th>
                                <td colspan="3"><input type="text" id="meta_tag" name="meta_tag" value="<?= esc($site['meta_tag'] ?? '') ?>"
                                        class="form-control placeHolder" rel="" style="width:70%;" /> _IT_META_TAG
                                </td>
                            </tr>

                            <tr>
                                <th>메타 키워드</th>
                                <td colspan="3"><input type="text" id="meta_keyword" name="meta_keyword"
                                        value="<?= esc($site['meta_keyword'] ?? '') ?>" class="form-control placeHolder" rel=""
                                        style="width:70%;" /> _IT_META_KEYWORD
                                </td>
                            </tr>

                            <tr>
                                <th>og:제목</th>
                                <td colspan="3"><input type="text" id="og_title" name="og_title" value="<?= esc($site['og_title'] ?? '') ?>"
                                        class="form-control placeHolder" rel="" style="width:70%;" /> _IT_OG_TITLE
                                </td>
                            </tr>
                            <tr>
                                <th>og:부가설명</th>
                                <td colspan="3"><input type="text" id="og_des" name="og_des" value="<?= esc($site['og_des'] ?? '') ?>"
                                        class="form-control placeHolder" rel="" style="width:70%;" /> _IT_OG_DES
                                </td>
                            </tr>
                            <tr>
                                <th>og:url</th>
                                <td colspan="3"><input type="text" id="og_url" name="og_url" value="<?= esc($site['og_url'] ?? '') ?>"
                                        class="form-control placeHolder" rel="" style="width:70%;" /> _IT_OG_URL
                                </td>
                            </tr>
                            <tr>
                                <th>og:사이트이름</th>
                                <td colspan="3"><input type="text" id="og_site" name="og_site" value="<?= esc($site['og_site'] ?? '') ?>"
                                        class="form-control placeHolder" rel="" style="width:70%;" /> _IT_OG_SITE
                                </td>
                            </tr>
                            <tr>
                                <th>og:이미지</th>
                                <td colspan="3">
                                    <input type="file" name="ufile2" class="bbs_inputbox_pixel" style="width:300px" />
                                    _IT_OG_IMG
                                    <br />
                                    <img src="/uploads/home/<?= esc($site['og_img'] ?? '') ?>" style="max-height:200px">
                                </td>
                            </tr>


                            <tr>
                                <th>COPY RIGHT</th>
                                <td colspan="3"><input type="text" id="buytext" name="buytext" value="<?= esc($site['buytext'] ?? '') ?>"
                                        class="form-control placeHolder" rel="" style="width:70%;" /> _IT_BUY_TEXT
                                </td>
                            </tr>


                            <tr>
                                <th>반품지 주소</th>
                                <td colspan="3"><input type="text" id="trantext" name="trantext" value="<?= esc($site['trantext'] ?? '') ?>"
                                        class="form-control placeHolder" rel="" style="width:70%;" /></td>
                            </tr>

                            <tr>
                                <th>favico 이미지</th>
                                <td colspan="3">
                                    <input type="file" name="favico_img1" class="bbs_inputbox_pixel"
                                        style="width:300px" /> _IT_FAVICO_IMG
                                    <br />
                                    <?php if (!empty($site['favico_img'] ?? '')): ?>
                                        <img src="/uploads/home/<?= esc($site['favico_img']) ?>" style="max-height:200px">
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr style='display:none'>
                                <th>네이버 verification</th>
                                <td colspan="3"><input type="text" id="naver_verfct" name="naver_verfct"
                                        value="<?= esc($site['naver_verfct'] ?? '') ?>" class="form-control placeHolder" rel=""
                                        style="width:70%;" /> _IT_NAVER_VERFCT
                                </td>
                            </tr>
                            <tr style='display:none'>
                                <th>구글 verification</th>
                                <td colspan="3"><input type="text" id="google_verfct" name="google_verfct"
                                        value="<?= esc($site['google_verfct'] ?? '') ?>" class="form-control placeHolder" rel=""
                                        style="width:70%;" /> _IT_GOOGLE_VERFCT
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>


                <div class="listTop">
                    <div class="left">
                        <p class="schTxt">■ 상점기본정보</p>
                    </div>
                </div>
                <!-- // listTop -->

                <div class="listBottom">
                    <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail ">
                        <caption>
                        </caption>
                        <colgroup>
                            <col width="150px" />
                            <col width="35%" />
                            <col width="150px" />
                            <col width="*" />
                        </colgroup>
                        <tbody>

                            <tr>
                                <th>상호명</th>
                                <td><input type="text" id="home_name" name="home_name" value="<?= esc($site['home_name'] ?? '') ?>"
                                        class="form-control placeHolder" rel="" style="width:200px" /> _IT_HOME_NAME
                                </td>
                                <th>상호영문</th>
                                <td><input type="text" id="home_name_en" name="home_name_en"
                                        value="<?= esc($site['home_name_en'] ?? '') ?>" class="form-control placeHolder" rel=""
                                        style="width:200px" /> _IT_HOME_NAME_EN
                                </td>
                            </tr>

                            <tr>
                                <th>업태</th>
                                <td><input type="text" id="store_service01" name="store_service01"
                                        value="<?= esc($site['store_service01'] ?? '') ?>" class="form-control placeHolder"
                                        rel=""
                                        style="width:200px" /> _IT_STORE_SER01
                                </td>
                                <th>종목</th>
                                <td><input type="text" id="store_service02" name="store_service02"
                                        value="<?= esc($site['store_service02'] ?? '') ?>" class="form-control placeHolder"
                                        rel=""
                                        style="width:200px" /> _IT_STORE_SER02
                                </td>
                            </tr>
                            <tr>
                                <th>주소</th>
                                <td colspan="3">
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="text" name="zip" id="zip" value="<?= esc($site['zip'] ?? '') ?>"
                                            class="form-control w-25" style="margin-bottom:5px;"
                                            placeholder="우편번호 입력"
                                            readonly> _IT_ZIP_CODE
                                        <a href="javascript:execDaumPostcode('frm','zip','addr1','addr2')"
                                            class="btn btn-primary" style="margin-bottom:5px">
                                            <i class="bi bi-gear"></i>
                                            <span class="txt">주소검색</span>
                                        </a>
                                    </div>

                                    <div class="address_info">
                                        <input type="text" name="addr1" id="addr1" value="<?= esc($site['addr1'] ?? '') ?>"
                                            class="form-control w-50" placeholder="주소 입력" readonly> _IT_ADDR1
                                        <input type="text" name="addr2" id="addr2" value="<?= esc($site['addr2'] ?? '') ?>"
                                            class="form-control w-50" placeholder="상세 주소 입력"> _IT_ADDR2
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <th>사업자번호</th>
                                <td><input type="text" id="comnum" name="comnum" value="<?= esc($site['comnum'] ?? '') ?>"
                                        class="form-control placeHolder" rel="" style="width:200px" /> _IT_COMNUM
                                </td>
                                <th>통신판매신고번호</th>
                                <td><input type="text" id="mall_order" name="mall_order"
                                        value="<?= esc($site['mall_order'] ?? '') ?>"
                                        class="form-control placeHolder" rel="" style="width:200px" /> _IT_MALL_ORDER
                                </td>
                            </tr>
                            <tr>
                                <th>대표자명</th>
                                <td><input type="text" id="com_owner" name="com_owner" value="<?= esc($site['com_owner'] ?? '') ?>"
                                        class="form-control placeHolder" rel="" style="width:200px" /> _IT_COM_OWNER
                                </td>
                                <th>개인정보보호 담당자명</th>
                                <td><input type="text" id="info_owner" name="info_owner"
                                        value="<?= esc($site['info_owner'] ?? '') ?>"
                                        class="form-control placeHolder" rel="" style="width:200px" /> _IT_INFO_OWER
                                </td>
                            </tr>
                            <tr>
                                <th>대표번호(고객센터)</th>
                                <td><input type="text" id="custom_phone" name="custom_phone"
                                        value="<?= esc($site['custom_phone'] ?? '') ?>" class="form-control placeHolder" rel=""
                                        style="width:200px" /> _IT_CUSTOM_PHONE
                                </td>
                                <th>팩스번호</th>
                                <td><input type="text" id="fax" name="fax" value="<?= esc($site['fax'] ?? '') ?>"
                                        class="form-control placeHolder" rel="" style="width:200px" /> _IT_FAX
                                </td>
                            </tr>

                            <tr>
                                <th>고객센터<BR>상담시간1</th>
                                <td><input type="text" id="counsel1" name="counsel1" value="<?= esc($site['counsel1'] ?? '') ?>"
                                        class="form-control placeHolder" rel="" style="width:300px" /> _IT_COUNSEL1
                                </td>
                                <th>고객센터<BR>상담시간2</th>
                                <td><input type="text" id="counsel2" name="counsel2" value="<?= esc($site['counsel2'] ?? '') ?>"
                                        class="form-control placeHolder" rel="" style="width:300px" /> _IT_COUNSEL2
                                </td>
                            </tr>

                            <tr>
                                <th>고객센터<br>상담시간3</th>
                                <td colspan='3'>
                                    <input type="text" id="counsel3" name="counsel3" value="<?= esc($site['counsel3'] ?? '') ?>"
                                        class="form-control placeHolder" rel="" style="width:300px" /> _IT_COUNSEL3
                                </td>
                            </tr>

                            <tr>
                                <th>로고 이미지</th>
                                <td colspan="3">
                                    <input type="file" name="ufile1" class="bbs_inputbox_pixel"
                                        style="width:300px" /> 삭제 : <input type="checkbox" name="dels" id="dels"
                                        value="y" /> _IT_LOGOS
                                    <br />
                                    <img src="/uploads/home/<?= esc($site['logos'] ?? '') ?>" style="max-height:200px; max-width: 400px">
                                </td>
                            </tr>

                            <tr>
                                <th>하단 로고 이미지</th>
                                <td colspan="3">
                                    <input type="file" name="ufile3" class="bbs_inputbox_pixel"
                                        style="width:300px" /> 삭제 : <input type="checkbox" name="dels_f" id="dels_f"
                                        value="y" /> _IT_LOGOS_FOOTER
                                    <br />
                                    <img src="/uploads/home/<?= esc($site['logo_footer'] ?? '') ?>" style="max-height:200px; max-width: 400px">
                                </td>
                            </tr>
                            <tr>
                                <th>카카오톡 채팅상담</th>
                                <td>
                                    <input type="text" id="kakao_chat" name="kakao_chat" value="<?= esc($site['kakao_chat'] ?? '') ?>"
                                        class="form-control placeHolder" rel="" style="width:300px" />
                                </td>
                                <th>Link 카카오톡 채팅상담</th>
                                <td>
                                    <input type="text" id="link_kakao_chat" name="link_kakao_chat" value="<?= esc($site['link_kakao_chat'] ?? '') ?>"
                                        class="form-control placeHolder" rel="" style="width:300px" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="listTop">
                    <div class="left">
                        <p class="schTxt">■ SMS 연동</p>
                    </div>
                </div>
                <!-- // listTop -->

                <div class="listBottom">
                    <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail ">
                        <caption>
                        </caption>
                        <colgroup>
                            <col width="150px" />
                            <col width="*" />
                        </colgroup>
                        <tbody>



                            <tr>
                                <th>알림톡 apikey</th>
                                <td><input type="text" id="allim_apikey" name="allim_apikey"
                                        value="<?= esc($site['allim_apikey'] ?? '') ?>" class="form-control placeHolder" rel=""
                                        style="width:300px" /> _ALLIM_APIKEY</td>
                            </tr>

                            <tr>
                                <th>알림톡 userid</th>
                                <td><input type="text" id="allim_userid" name="allim_userid"
                                        value="<?= esc($site['allim_userid'] ?? '') ?>" class="form-control placeHolder" rel=""
                                        style="width:300px" /> _ALLIM_USERID</td>
                            </tr>

                            <tr>
                                <th>알림톡 senderkey</th>
                                <td><input type="text" id="allim_senderkey" name="allim_senderkey"
                                        value="<?= esc($site['allim_senderkey'] ?? '') ?>" class="form-control placeHolder" rel=""
                                        style="width:300px" /> _ALLIM_SENDERKEY</td>
                            </tr>

                            <tr>
                                <th>문자 발신번호</th>
                                <td><input type="text" id="sms_phone" name="sms_phone"
                                        value="<?= esc($site['sms_phone'] ?? '') ?>" class="form-control placeHolder" rel=""
                                        style="width:300px" />_IT_SMS_PHONE</td>
                            </tr>
                        </tbody>
                    </table>
                </div>



                <div class="listTop">
                    <div class="left">
                        <p class="schTxt">■ 이메일 연동</p>
                    </div>
                </div>
                <!-- // listTop -->

                <div class="listBottom">
                    <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail ">
                        <caption>
                        </caption>
                        <colgroup>
                            <col width="150px" />
                            <col width="*" />
                        </colgroup>
                        <tbody>
                            <tr>
                                <th>HOST</th>
                                <td><input type="text" id="smtp_host" name="smtp_host"
                                        value="<?= esc($site['smtp_host'] ?? '') ?>" class="form-control placeHolder" rel=""
                                        style="width:300px" /> _SMTP_HOST</td>
                            </tr>

                            <tr>
                                <th>ID</th>
                                <td><input type="text" id="smtp_id" name="smtp_id" value="<?= esc($site['smtp_id'] ?? '') ?>"
                                        class="form-control placeHolder" rel="" style="width:300px" /> _SMTP_ID</td>
                            </tr>

                            <tr>
                                <th>PASS</th>
                                <td><input type="text" id="smtp_pass" name="smtp_pass"
                                        value="<?= esc($site['smtp_pass'] ?? '') ?>" class="form-control placeHolder" rel=""
                                        style="width:300px" /> _SMTP_PASS</td>
                            </tr>

                            <tr>
                                <th>이메일 발송</th>
                                <td><input type="text" id="admin_email_list" name="admin_email_list"
                                        value="<?= esc($site['admin_email_list'] ?? '') ?>" class="form-control placeHolder" rel=""
                                        style="width:80%" /> _ADMIN_EMAIL_LIST</td>
                            </tr>

                        </tbody>
                    </table>
                </div>


                <div class="listTop" style='display:none'>
                    <div class="left">
                        <p class="schTxt">■ 계좌관리</p>
                    </div>
                </div>
                <!-- // listTop -->

                <div class="listBottom" style='display:none'>
                    <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail ">
                        <caption>
                        </caption>
                        <colgroup>
                            <col width="150px" />
                            <col width="*" />
                        </colgroup>
                        <tbody>

                            <tr>
                                <th>예금주</th>
                                <td><input type="text" id="bank_user" name="bank_user" value="<?= esc($site['bank_user'] ?? '') ?>"
                                        class="form-control placeHolder" rel="" style="width:200px" /> _IT_BANK_USER
                                </td>
                            </tr>
                            <tr>
                                <th>은행명</th>
                                <td><input type="text" id="banks" name="banks" value="<?= esc($site['banks'] ?? '') ?>"
                                        class="form-control placeHolder" rel="" style="width:200px" /> _IT_BANK_NAME
                                </td>
                            </tr>
                            <tr>
                                <th>계좌번호</th>
                                <td><input type="text" id="bank_account" name="bank_account"
                                        value="<?= esc($site['bank_account'] ?? '') ?>" class="form-control placeHolder" rel=""
                                        style="width:200px" /> _IT_BANK_ACC
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="listTop" style='display:none'>
                    <div class="left">
                        <p class="schTxt">■ 기타</p>
                    </div>
                </div>
            </form>
        </div>
    </div>

</section>


<!-- // container -->
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
    function execDaumPostcode(formId, zipId, addr1Id, addr2Id) {
        new daum.Postcode({
            oncomplete: function(data) {
                let addr = '';

                if (data.userSelectedType === 'R') {
                    addr = data.roadAddress;
                } else {
                    addr = data.jibunAddress;
                }

                document.getElementById(zipId).value = data.zonecode;
                document.getElementById(addr1Id).value = addr;

                const addr2 = document.getElementById(addr2Id);
                if (addr2) {
                    addr2.focus();
                }
            }
        }).open();
    }
</script>

<script>
    function send_its() {

        $("#frm").submit();
    }
</script>


<?= $this->endSection() ?>