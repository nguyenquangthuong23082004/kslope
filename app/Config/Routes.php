<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Main::index');
$routes->get('main_tasks', 'Sub::main_tasks');
$routes->get('disaster_risk', 'Sub::disaster_risk');
$routes->get('safety_inspection', 'Sub::safety_inspection');
$routes->get('detailed_investigation', 'Sub::detailed_investigation');
$routes->get('slope_topography_map', 'Sub::slope_topography_map');
$routes->get('contract_information', 'Sub::contract_information');

$routes->get('ci_introduction', 'Sub::ci_introduction');
$routes->get('recruitment_infor', 'Sub::recruitment_infor');
$routes->get('recruitment_detail', 'Sub::recruitment_detail');
$routes->get('notice', 'Sub::notice');
$routes->get('notice_detail', 'Sub::notice_detail');
$routes->get('promotion', 'Sub::promotion');
$routes->get('promotion_detail', 'Sub::promotion_detail');
$routes->get('competition', 'Sub::competition');
$routes->get('competition_detail', 'Sub::competition_detail');
$routes->get('greeting', 'Sub::greeting');
$routes->get('past_presidents', 'Sub::past_presidents');
$routes->get('past_presidents_detail', 'Sub::past_presidents_detail');
$routes->get('history', 'Sub::history');
$routes->get('association_journal', 'Sub::association_journal');
$routes->post('increase_view/(:num)', 'Sub::increaseView/$1');
$routes->get('organization_guide', 'Sub::organization_guide');
$routes->get('vision', 'Sub::vision');
$routes->get('directions', 'Sub::directions');
$routes->get('member_resource', 'Sub::member_resource');
$routes->get('sign_up_instructions', 'Sub::sign_up_instructions');
$routes->get('take_training', 'Sub::take_training');
$routes->get('take_training_detail', 'Sub::take_training_detail');
$routes->get('apply_for_training', 'Sub::apply_for_training');
$routes->get('completioncert_reissue', 'Sub::completioncert_reissue');
$routes->get('member_resource_detail','Sub::member_resource_detail');
$routes->get('training_information', 'Sub::training_information');

$routes->get('slope_safety', 'Sub::slope_safety');


$routes->get('login', 'Member::login');
$routes->get('join_the_membership', 'Member::join_the_membership');
$routes->get('join_special_membership', 'Member::join_special_membership');
$routes->get('membership_infomation', 'Member::membership_infomation');
$routes->get('membership_infomation/(:any)', 'Member::membership_infomation/$1');
$routes->get('membership_group', 'Member::membership_group');
$routes->get('membership_group/(:any)', 'Member::membership_group/$1');
$routes->get('membership_special', 'Member::membership_special');
$routes->get('membership_special/(:any)', 'Member::membership_special/$1');
$routes->get('find_id', 'Member::find_id');
$routes->get('find_password', 'Member::find_password');
$routes->get('logout', 'Member::logout');


$routes->get('mypage', 'MypageController::mypage');
$routes->get('verify_password', 'MypageController::verify_password');
$routes->get('edit_member_information', 'MypageController::edit_member_information');
$routes->get('lecture_video', 'MypageController::lecture_video');
$routes->get('lecture_video_detail', 'MypageController::lecture_video_detail');
$routes->get('mypage/getVideoProgress', 'MypageController::getVideoProgress');
$routes->post('mypage/updateVideoProgress', 'MypageController::updateVideoProgress');
$routes->get('staff_management', 'MypageController::staff_management');
$routes->get('staff_create', 'MypageController::staff_create');
$routes->post('staff_store', 'MypageController::staff_store');
$routes->post('handle_verify_password', 'MypageController::handleVerifyPassword');
$routes->post('save_information', 'MypageController::save_information');


$routes->group('member', function ($routes) {
    $routes->post('member_reg_ok', 'Member::member_reg_ok');
    $routes->post('member_infomation_ok', 'Member::member_infomation_ok');
    $routes->post('member_group_ok', 'Member::member_group_ok');
    $routes->post('member_special_ok', 'Member::member_special_ok');
    $routes->post('chk_id', 'Member::checkUserId');
    $routes->post('send_sms', 'Member::sendSms');
    $routes->post('chk_phone', 'Member::verifyCode');
    $routes->post('login', 'Member::processLogin');

    $routes->group("find_id", static function ($routes) {
        $routes->post('send_verify_code', 'Member::findIDSendVerifyCode');
        $routes->post('verify_code', 'Member::findIDVerifyCode');
        $routes->post('final', 'Member::find_id_ok');
    });

    $routes->group("find_password", static function ($routes) {
        $routes->post('send_verify_code', 'Member::findPWSendVerifyCode');
        $routes->post('verify_code', 'Member::findPWVerifyCode');
        $routes->post('final', 'Member::find_password_ok');
    });
});

$routes->group("api", static function ($routes) {
    $routes->group("code", static function ($routes) {
        $routes->get('list', 'ApiController::getListCode');
    });
    $routes->group("bbs", static function ($routes) {
        $routes->get('download', 'ApiController::downloadBbs');
    });
    $routes->group("courses", static function ($routes) {
        $routes->get('list', 'ApiController::getListCourse');
    });
    $routes->group("find", static function ($routes) {
        $routes->post('cert', 'ApiController::findCert');
    });
    $routes->group("upload", static function ($routes) {
        $routes->post('file', 'ApiController::uploadFile');
        $routes->post('chunk', 'ApiController::uploadChunk');
    });
});

$routes->group("reservation", static function ($routes) {
    $routes->get('create', 'Sub::reservation');
    $routes->post('store', 'ReservationController::store');
});

$routes->group("print", static function ($routes) {
    $routes->get('certificates', 'PrintController::certificates');
});

$routes->group('AdmMaster', function ($routes) {
    $routes->get('/', 'AdmMaster\Home::index');
    $routes->get('login', 'AdmMaster\Auth::login');
    $routes->post('login', 'AdmMaster\Auth::loginProcess');
    $routes->get('logout', 'AdmMaster\Auth::logout');
    $routes->get('_adminrator/setting', 'AdmMaster\Adminrator::setting');
    $routes->post('_adminrator/update', 'AdmMaster\Adminrator::update');
    $routes->get('_adminrator/policy', 'AdmMaster\Adminrator::policy');
    $routes->post('_adminrator/policyUpdate', 'AdmMaster\Adminrator::policyUpdate');

    $routes->get('portfolio', 'AdmMaster\Portfolio::index');
    $routes->post('portfolio/save', 'AdmMaster\Portfolio::save');
    $routes->post('portfolio/toggle', 'AdmMaster\Portfolio::toggle');
    $routes->get('portfolio/edit/(:num)', 'AdmMaster\Portfolio::edit/$1');
    $routes->post('portfolio/update/(:num)', 'AdmMaster\Portfolio::update/$1');
    $routes->post('portfolio/store', 'AdmMaster\Portfolio::store');
    $routes->get('portfolio/create', 'AdmMaster\Portfolio::create');
    $routes->post('portfolio/delete', 'AdmMaster\Portfolio::delete');
    $routes->post('portfolio/bulkDelete', 'AdmMaster\Portfolio::bulkDelete');
    $routes->post('portfolio/changeOrder', 'AdmMaster\Portfolio::changeOrder');


    $routes->get('notice', 'AdmMaster\Bbs::noticeList');
    $routes->get('notice/write', 'AdmMaster\Bbs::noticeWrite');
    $routes->post('notice/save', 'AdmMaster\Bbs::noticeSave');
    $routes->get('notice/edit/(:num)', 'AdmMaster\Bbs::noticeEdit/$1');
    $routes->post('notice/update/(:num)', 'AdmMaster\Bbs::noticeUpdate/$1');
    $routes->get('notice/delete/(:num)', 'AdmMaster\Bbs::noticeDelete/$1');
    $routes->post('notice/uploadImage', 'AdmMaster\Bbs::uploadImage');
    $routes->post('notice/delete-multi', 'AdmMaster\Bbs::noticeDeleteMulti');

    $routes->group("_bbs", static function ($routes) {
        $routes->get("list", "AdmMaster\AdminBbsController::list");
        $routes->get("write", "AdmMaster\AdminBbsController::write");
        $routes->post("write_ok", "AdmMaster\AdminBbsController::write_ok");
        $routes->post("change", "AdmMaster\AdminBbsController::change");
        $routes->post("delete", "AdmMaster\AdminBbsController::delete");
    });

    $routes->group("_courses", static function ($routes) {
        $routes->get("list", "AdmMaster\AdminCourseController::list");
        $routes->get("write", "AdmMaster\AdminCourseController::write");
        $routes->post("write_ok", "AdmMaster\AdminCourseController::write_ok");
        $routes->post("change", "AdmMaster\AdminCourseController::change");
        $routes->post("delete", "AdmMaster\AdminCourseController::delete");
    });

    $routes->group("_code", static function ($routes) {
        $routes->get("list", "CodeController::list_admin");
        $routes->get("write", "CodeController::write_admin");
        $routes->post("write_ok", "CodeController::write_ok");
        $routes->post("del", "CodeController::del");
        $routes->post("add_contents", "CodeController::add_contents");
        $routes->post("del_contents", "CodeController::del_contents");
        $routes->get("country_list", "CodeController::country_list_admin");
        $routes->get("country_write", "CodeController::country_write");
        $routes->post("country_write_ok", "CodeController::country_write_ok");
        $routes->post("country_change", "CodeController::country_change");
        $routes->delete("country_del", "CodeController::country_del");
        $routes->post("change", "CodeController::change_ajax");
    });

    $routes->group("_members", static function ($routes) {
        $routes->get("list", "AdmMaster\AdminMemberController::list");
        $routes->get("write", "AdmMaster\AdminMemberController::write");
        $routes->get("member_staff", "AdmMaster\AdminMemberController::member_staff");
        $routes->post("staff_create", "AdmMaster\AdminMemberController::staff_create");
        $routes->post("change", "AdmMaster\AdminMemberController::change");
        $routes->post("changePassword", "AdmMaster\AdminMemberController::changePassword");
        $routes->post("update", "AdmMaster\AdminMemberController::update");
        $routes->post("delete", "AdmMaster\AdminMemberController::delete");
        $routes->post('updateStatus', 'AdmMaster\AdminMemberController::updateStatus');
        $routes->post('chk_id', 'AdmMaster\AdminMemberController::checkID');
        $routes->get('exportExcel', 'AdmMaster\AdminMemberController::exportExcel');
        $routes->post('updateApprovalStatus', 'AdmMaster\AdminMemberController::updateApprovalStatus');

        $routes->get("email", "AdmMaster\AutoMailController::index");
        $routes->post("email_delete", "AdmMaster\AutoMailController::email_delete");
        $routes->post("email_change", "AdmMaster\AutoMailController::email_change");
        $routes->get("email_view", "AdmMaster\AutoMailController::email_view");
        $routes->post("email_mod_ok", "AdmMaster\AutoMailController::email_mod_ok");
        $routes->get("pre_viw_mail", "AdmMaster\AutoMailController::pre_viw_mail");
    });

    $routes->group("_reservation", static function ($routes) {
        $routes->get('list', 'AdmMaster\AdminReservationController::list');
        $routes->get('write', 'AdmMaster\AdminReservationController::write');
        $routes->post('change', 'AdmMaster\AdminReservationController::change');
        $routes->post('update', 'AdmMaster\AdminReservationController::update');
        $routes->post('delete', 'AdmMaster\AdminReservationController::delete');
    });

    $routes->group("_pass", static function ($routes) {
        $routes->get('list', 'AdmMaster\AdminPassController::list');
        $routes->post('send_email','AdmMaster\AdminPassController::sendEmail');
    });

    $routes->group("_learning", static function ($routes) {
        $routes->get('list', 'AdmMaster\AdminLearningController::list');
    });

    $routes->group("_video", static function ($routes) {
        $routes->get("list", "AdmMaster\AdminVideoController::list");
        $routes->get("write", "AdmMaster\AdminVideoController::write");
        $routes->post("write_ok", "AdmMaster\AdminVideoController::write_ok");
        $routes->post("change", "AdmMaster\AdminVideoController::change");
        $routes->post("delete", "AdmMaster\AdminVideoController::delete");
    });

    $routes->group(
        "_popup",
        static function ($routes) {
            $routes->get("list", "PopupController::list");
            $routes->get("detail", "PopupController::detail");
            $routes->get("detail/(:segment)", "PopupController::detail/$1");
            $routes->post("insert", "PopupController::insert");
            $routes->post("update/(:segment)", "PopupController::update/$1");
            $routes->post("del_popup", "PopupController::del_popup");
            $routes->post("del_image", "PopupController::del_image");
            $routes->post("change_status", "PopupController::change_status");
        }
    );
});
