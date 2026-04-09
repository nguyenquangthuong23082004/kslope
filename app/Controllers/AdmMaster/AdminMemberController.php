<?php

namespace App\Controllers\AdmMaster;

use App\Controllers\BaseController;
use App\Models\MemberEducationModel;
use App\Models\MemberCareerModel;
use App\Models\MemberExtraModel;
use App\Models\MemberQualificationModel;

class AdminMemberController extends BaseController
{
    private $db;
    private $memberModel;
    private $educationModel;
    private $careerModel;
    private $courseModel;
    private $courseProgressModel;

    public function __construct()
    {
        $this->memberModel = model('MemberModel');
        $this->educationModel = new MemberEducationModel();
        $this->careerModel = new MemberCareerModel();
        $this->courseModel = model('CourseModel');
        $this->extraModel = new MemberExtraModel();
        $this->qualificationModel = new MemberQualificationModel();
        $this->courseProgressModel = model('CourseProgressModel');
        $this->db = db_connect();
    }

    public function list()
    {
        try {
            $keyword = $this->request->getGet('keyword') ?? '';
            $type = $this->request->getGet('type') ?? '';
            $page_notice = $this->request->getGet('page_notice') ?? 1;

            $where = array();

            $where['main'] = $keyword;
            $where['member_type'] = $type;
            $perPage = 10;

            $data = $this->memberModel->getPageWithPager($where, $perPage, 'notice');

            $list = $data['items'];
            $pager = $data['pager'];
            $total = $data['total'];

            $managerIds = array_filter(array_column($list, 'manager_id'), function ($val) {
                return !empty($val) && trim($val) != '';
            });

            $managers = [];
            if (!empty($managerIds)) {
                $managersData = $this->memberModel
                    ->whereIn('user_id', $managerIds)
                    ->findAll();

                foreach ($managersData as $manager) {
                    $managers[$manager['user_id']] = $manager;
                }
            }

            $userIds = array_column($list, 'user_id');

            // var_dump($userIds);
            // die();

            $staffList = [];

            if (!empty($userIds) && $type != 'N') {
                $staffData = $this->memberModel
                    ->whereIn('manager_id', $userIds)
                    ->where('member_type', 'N')
                    ->findAll();


                foreach ($staffData as &$staff) {
                    $array_course = array_values(array_filter(explode(',', rtrim(($staff["course_idx"] ?? ""), ','))));
                    $count_course = count($array_course);
                    if (!isset($staffList[$staff['manager_id']])) {
                        $staffList[$staff['manager_id']] = [];
                    }
                    $completed_video = $this->courseProgressModel->where("user_id", $staff['user_id'])->where("status", "completed")->countAllResults();

                    if ($completed_video == $count_course && $count_course != 0) {
                        $staff['status_course'] = "완료";
                    } else {
                        $staff['status_course'] = "미완료";
                    }
                    $staffList[$staff['manager_id']][] = $staff;
                }
            }

            foreach ($list as &$member) {
                if (!empty($member['manager_id']) && isset($managers[$member['manager_id']])) {
                    $member['manager_info'] = $managers[$member['manager_id']];
                } else {
                    $member['manager_info'] = null;
                }

                $member['staff_list'] = $staffList[$member['user_id']] ?? [];
                $member['staff_count'] = count($member['staff_list']);
            }

            $data = [
                'num' => $total,
                'items' => $list,
                'pager' => $pager,
                'perPage' => $perPage,
                'page' => $page_notice,
                'keyword' => $keyword ?? '',
                'type' => $type,
            ];

            return view('AdmMaster/_member/list', $data);
        } catch (\Exception $e) {
            return $this
                ->response
                ->setStatusCode(500)
                ->setJSON([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
        }
    }

    // public function updateApprovalStatus()
    // {
    //     try {
    //         $m_idx = $this->request->getPost('m_idx');
    //         $approval_status = $this->request->getPost('approval_status');

    //         if (!$m_idx || !in_array($approval_status, ['Y', 'N'])) {
    //             return $this->response->setJSON([
    //                 'success' => false,
    //                 'message' => '잘못된 요청입니다.'
    //             ]);
    //         }

    //         $this->memberModel->update($m_idx, ['approval_status' => $approval_status]);

    //         return $this->response->setJSON([
    //             'success' => true,
    //             'message' => $approval_status == 'Y' ? '승인되었습니다.' : '승인 대기 상태로 변경되었습니다.'
    //         ]);
    //     } catch (\Exception $e) {
    //         return $this->response->setJSON([
    //             'success' => false,
    //             'message' => $e->getMessage()
    //         ]);
    //     }
    // }

    public function updateApprovalStatus()
    {
        try {
            $m_idx = $this->request->getPost('m_idx');
            $approval_status = $this->request->getPost('approval_status');

            if (!$m_idx || !in_array($approval_status, ['Y', 'N'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => '잘못된 요청입니다.'
                ]);
            }

            $member = $this->memberModel->find($m_idx);
            if (!$member) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => '회원을 찾을 수 없습니다.'
                ]);
            }

            $wasApprovedBefore = ($member['approval_status'] ?? 'N') === 'Y';

            $this->memberModel->update($m_idx, ['approval_status' => $approval_status]);

            $isNowApproved = $approval_status === 'Y';
            $isGorS        = in_array($member['member_type'], ['G', 'S']);
            $isAnyType     = in_array($member['member_type'], ['G', 'S', 'N']);

            if ($isNowApproved && !$wasApprovedBefore) {
                if ($isGorS) {
                    $this->_sendApprovalAlimTalk($member);
                }

                if ($isAnyType) {
                    $this->_sendApprovalAlimTalkUG3178($member);
                }
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => $approval_status == 'Y' ? '승인되었습니다.' : '승인 대기 상태로 변경되었습니다.'
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    private function _sendApprovalAlimTalk(array $member): void
    {
        try {
            $userMobile  = $member['user_mobile'] ?? '';
            $companyName = $member['user_name'] ?? '';

            if (empty($userMobile)) {
                log_message('info', 'AlimTalk UG_2400 skip: no mobile for m_idx=' . $member['m_idx']);
                return;
            }

            $replace = [
                '#{company_name}' => $companyName,
                'phone'           => $userMobile,
            ];

            alimTalkSend('UG_2400', $replace);

            log_message('info', 'AlimTalk UG_2400 sent: m_idx=' . $member['m_idx'] . ', mobile=' . $userMobile);

        } catch (\Exception $e) {
            log_message('error', 'AlimTalk UG_2400 error m_idx=' . $member['m_idx'] . ': ' . $e->getMessage());
        }
    }

    private function _sendApprovalAlimTalkUG3178(array $member): void
    {
        try {
            $userMobile = $member['user_mobile'] ?? '';
            $manageName = $member['user_name'] ?? '';
            $loginId    = $member['user_id'] ?? '';

            if (empty($userMobile)) {
                log_message('info', 'AlimTalk UG_3178 skip: no mobile for m_idx=' . $member['m_idx']);
                return;
            }

            $replace = [
                '#{manage_name}' => $manageName,
                '#{login_id}'    => $loginId,
                '#{login_url}'   => 'https://kslope.mycafe24.com/login',
                'phone'          => $userMobile,
            ];

            log_message('info', '[AlimTalk UG_3178] 발송 정보: ' . json_encode([
                'template'    => 'UG_3178',
                'manage_name' => $manageName,
                'login_id'    => $loginId,
                'login_url'   => 'https://kslope.mycafe24.com/login',
                'phone'       => $userMobile,
                'm_idx'       => $member['m_idx'],
            ], JSON_UNESCAPED_UNICODE));

            alimTalkSend('UG_3178', $replace);

            log_message('info', '[AlimTalk UG_3178] 발송 완료: m_idx=' . $member['m_idx'] . ', mobile=' . $userMobile);

        } catch (\Exception $e) {
            log_message('error', '[AlimTalk UG_3178] 발송 오류 m_idx=' . $member['m_idx'] . ': ' . $e->getMessage());
        }
    }

    public function write()
    {
        try {
            $m_idx = $this->request->getVar('m_idx');

            $row = $this->memberModel->where('m_idx', $m_idx)->first();
            if (empty($row)) {
                return $this
                    ->response
                    ->setStatusCode(404)
                    ->setJSON([
                        'status' => 'error',
                        'message' => 'Not found!',
                    ]);
            }

            $educations = [];
            $careers = [];
            $extras = [];
            $qualifications = [];

            if ($row['member_type'] == 'N') {
                $educations = $this->educationModel->where('m_idx', $m_idx)->findAll();
                $careers = $this->careerModel->where('m_idx', $m_idx)->findAll();
                $extras = $this->extraModel->where('m_idx', $m_idx)->findAll();
                $qualifications = $this->qualificationModel->where('m_idx', $m_idx)->findAll();
            }

            $staffList = [];
            if ($row['member_type'] != 'N') {
                $staffList = $this->memberModel
                    ->where('manager_id', $row['user_id'])
                    ->where('member_type', 'N')
                    ->orderBy('m_idx', 'DESC')
                    ->findAll();
            }

            $managerInfo = null;
            $showCourseSelect = false;
            if (!empty($row['manager_id'])) {
                $managerInfo = $this->memberModel
                    ->where('user_id', $row['manager_id'])
                    ->first();

                if ($managerInfo) {
                    $showCourseSelect = true;
                }
            }

            $courses = [];
            $selectedCourses = [];
            if ($showCourseSelect) {
                $courses = $this->courseModel
                    ->orderBy('course_name', 'ASC')
                    ->findAll();

                if (!empty($row['course_idx'])) {
                    $selectedCourses = explode(',', $row['course_idx']);
                }
            }

            $data['staffList'] = $staffList;

            $data['educations'] = $educations;
            $data['careers'] = $careers;
            $data['extras'] = $extras;
            $data['qualifications'] = $qualifications;

            $data['row'] = $row;

            $data['courses'] = $courses;
            $data['selectedCourses'] = $selectedCourses;
            $data['managerInfo'] = $managerInfo;
            $data['showCourseSelect'] = $showCourseSelect;

            return view('AdmMaster/_member/write', $data);
        } catch (\Exception $e) {
            return $this
                ->response
                ->setStatusCode(500)
                ->setJSON([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function member_staff()
    {
        $user_id = $this->request->getVar('user_id');

        $user = $this->memberModel->where('user_id', $user_id)->first();

        $member_type = $user['member_type'] ?? '';

        $courses = [];
        $courses = $this->courseModel
            ->orderBy('course_name', 'ASC')
            ->findAll();

        $data = [
            'id' => $user_id,
            'member_type' => $member_type,
            'courses' => $courses,
        ];

        return view('AdmMaster/_member/member_staff', $data);
    }

    public function staff_create()
    {
        try {
            $manager_id = $this->request->getPost('manager_id');
            $user_id = $this->request->getPost('user_id');

            $row = $this->memberModel->where('user_id', $user_id)->first();
            if ($row) {
                $result = [
                    'status' => 'error',
                    'message' => '이미 존재하는 아이디입니다.',
                ];
                return $this->response->setJSON($result)->setStatusCode(400);
            }

            $password = $this->request->getPost('password');
            if (!$password) {
                $result = [
                    'status' => 'error',
                    'message' => '비밀번호를 입력해주세요.',
                ];
                return $this->response->setJSON($result)->setStatusCode(400);
            }
            $user_pw = password_hash($password, PASSWORD_BCRYPT);

            $user_name = $this->request->getPost('user_name');

            $user_email = $this->request->getPost('user_email');

            $phone1 = $this->request->getPost('phone1');
            $phone2 = $this->request->getPost('phone2');
            $phone3 = $this->request->getPost('phone3');
            $user_phone = $phone1 . '-' . $phone2 . '-' . $phone3;

            $work_position = $this->request->getPost('work_position');
            $course_idx_array = $this->request->getPost('course_idx');
            $course_idx = !empty($course_idx_array) ? implode(',', $course_idx_array) : '';

            $data = [
                'user_id' => $user_id,
                'user_name' => $user_name,
                'user_pw' => $user_pw,
                'user_phone' => $user_phone,
                'user_mobile' => $user_phone,
                'user_email' => $user_email,
                'work_position' => $work_position,
                'course_idx' => $course_idx,
                'manager_id' => $manager_id,
                'member_type' => 'N',
                'status' => '1',
                'user_level' => '9',
                'r_date' => date('Y-m-d H:i:s'),
            ];

            $this->memberModel->insert($data);
            $this->_sendStaffCreateAlimTalk($user_id, $user_name, $manager_id, $password, $user_phone);
            $result = [
                'status' => 'success',
                'message' => '직원등록되었습니다.',
            ];
            return $this->response->setJSON($result);
        } catch (\Exception $exception) {
            $result = [
                'status' => 'error',
                'message' => $exception->getMessage(),
            ];
            return $this->response->setJSON($result)->setStatusCode(500);
        }
    }

    private function _sendStaffCreateAlimTalk(
        string $userId,
        string $userName,
        string $managerId,
        string $plainPassword,
        string $userMobile
    ): void {
        try {
            $manager     = $this->memberModel->where('user_id', $managerId)->first();
            $managerName = $manager['user_name'] ?? '';
            $managerMobile = $manager['user_mobile'] ?? '';

            $replace = [
                '#{employee_name}'   => $userName,
                '#{manage_name}'   => $managerName,
                '#{login_id}'      => $userId,
                '#{temp_password}' => $plainPassword,
                '#{login_url}'     => 'https://kslope.mycafe24.com/login',
                'phone'            => $userMobile,
            ];

            // log_message('info', '[AlimTalk staff_create] [STAFF] 발송 정보: ' . json_encode([
            //     'template'      => 'UG_2169',
            //     'employee_name'   => $userName,
            //     'manage_name'   => $managerName,
            //     'login_id'      => $userId,
            //     'temp_password' => $plainPassword,
            //     'login_url'     => 'https://kslope.mycafe24.com/login',
            //     'phone'         => $userMobile,
            //     'manager_id'    => $managerId,
            //     'manager_found' => $manager ? 'YES' : 'NO',
            // ], JSON_UNESCAPED_UNICODE));

            alimTalkSend('UG_2169', $replace);
            log_message('info', '[AlimTalk staff_create] [STAFF] 발송 완료: user_id=' . $userId);

            if (!empty($managerMobile)) {
                $replaceManager = [
                    '#{employee_name}'   => $userName,
                    '#{manage_name}'   => $managerName,
                    '#{login_id}'      => $userId,
                    '#{temp_password}' => $plainPassword,
                    '#{login_url}'     => 'https://kslope.mycafe24.com/login',
                    'phone'            => $managerMobile,
                ];

                // log_message('info', '[AlimTalk staff_create] [MANAGER] 발송 정보: ' . json_encode([
                //     'template'      => 'UG_2169',
                //     'employee_name'   => $userName,
                //     'manage_name'   => $managerName,
                //     'login_id'      => $userId,
                //     'temp_password' => $plainPassword,
                //     'login_url'     => 'https://kslope.mycafe24.com/login',
                //     'phone'         => $managerMobile,
                //     'manager_id'    => $managerId,
                // ], JSON_UNESCAPED_UNICODE));

                alimTalkSend('UG_2169', $replaceManager);
                log_message('info', '[AlimTalk staff_create] [MANAGER] 발송 완료: manager_id=' . $managerId);

            } else {
                log_message('info', '[AlimTalk staff_create] [MANAGER] skip: no mobile for manager_id=' . $managerId);
            }

        } catch (\Exception $e) {
            log_message('error', '[AlimTalk staff_create] 발송 오류 user_id=' . $userId . ': ' . $e->getMessage());
        }
    }

    public function checkID()
    {
        try {
            $user_id = $this->request->getPost('manager_id');

            $userExist = $this->memberModel->where('manager_id', $user_id)->first();
            if ($userExist) {
                $result = [
                    'status' => 'error',
                    'message' => '이미 사용 중인 아이디입니다.',
                ];
                return $this->response->setJSON($result)->setStatusCode(400);
            }

            $result = [
                'status' => 'success',
                'message' => '사용 가능한 아이디입니다.',
            ];
            return $this->response->setJSON($result);
        } catch (\Exception $exception) {
            $result = [
                'status' => 'error',
                'message' => $exception->getMessage(),
            ];
            return $this->response->setJSON($result)->setStatusCode(500);
        }
    }

    public function changePassword()
    {
        try {
            $m_idx = $this->request->getPost('m_idx');
            $password = $this->request->getPost('password');
            $type = $this->request->getPost('type');

            if (!$m_idx) {
                return $this
                    ->response
                    ->setStatusCode(404)
                    ->setJSON([
                        'status' => 'error',
                        'message' => '데이터를 찾을 수 없습니다.',
                    ]);
            }

            if (!$password) {
                return $this
                    ->response
                    ->setStatusCode(404)
                    ->setJSON([
                        'status' => 'error',
                        'message' => '비밀번호를 입력해주세요.',
                    ]);
            }

            if (strlen($password) < 6) {
                return $this
                    ->response
                    ->setStatusCode(404)
                    ->setJSON([
                        'status' => 'error',
                        'message' => '비밀번호가 올바르지 않습니다. (최소 6자 이상)',
                    ]);
            }

            $user_pw = password_hash($password, PASSWORD_BCRYPT);

            if ($type != 'G') {
                $this->memberModel->update($m_idx, ['user_pw' => $user_pw]);
            } else {
                $this->memberModel->update($m_idx, ['manager_pw' => $user_pw]);
            }

            return $this
                ->response
                ->setStatusCode(200)
                ->setJSON([
                    'status' => 'success',
                    'message' => '수정되었습니다.',
                ]);
        } catch (\Exception $e) {
            return $this
                ->response
                ->setStatusCode(500)
                ->setJSON([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function update()
    {
        try {
            $m_idx = $this->request->getPost('m_idx');

            $currentMember = $this->memberModel->find($m_idx);
            if (!$currentMember) {
                return $this->response->setStatusCode(404)->setJSON([
                    'status' => 'error',
                    'message' => '회원 정보를 찾을 수 없습니다.',
                ]);
            }

            $uploadPath = FCPATH . 'uploads/member/';

            $user_name = $this->request->getPost('user_name');
            $user_email = $this->request->getPost('user_email');
            $work_position = $this->request->getPost('work_position');
            $company_name = $this->request->getPost('company_name');
            $company_representative = $this->request->getPost('company_representative');
            $business_number = $this->request->getPost('business_number');
            $sms_yn = $this->request->getPost('sms_yn') ?? 'N';
            $user_email_yn = $this->request->getPost('user_email_yn') ?? 'N';
            $zip = $this->request->getPost('zip');
            $addr1 = $this->request->getPost('addr1');
            $addr2 = $this->request->getPost('addr2');
            // $manager_id = $this->request->getPost('manager_id');
            $manager_pw = $this->request->getPost('manager_pw');

            $delete_file = $this->request->getPost('delete_file');

            $r_phone1 = $this->request->getPost('r_phone1');
            $r_phone2 = $this->request->getPost('r_phone2');
            $r_phone3 = $this->request->getPost('r_phone3');

            $m_phone1 = $this->request->getPost('m_phone1');
            $m_phone2 = $this->request->getPost('m_phone2');
            $m_phone3 = $this->request->getPost('m_phone3');

            $membership_type = $this->request->getPost('membership_type');
            $membership_organization = $this->request->getPost('membership_organization');
            $membership_zip = $this->request->getPost('membership_zip');
            $membership_addr1 = $this->request->getPost('membership_addr1');
            $membership_addr2 = $this->request->getPost('membership_addr2');

            $extra_affiliation = $this->request->getPost('extra_affiliation');
            $extra_period = $this->request->getPost('extra_period');

            $s_phone1 = $this->request->getPost('s_phone1');
            $s_phone2 = $this->request->getPost('s_phone2');
            $s_phone3 = $this->request->getPost('s_phone3');

            $b_phone1 = $this->request->getPost('b_phone1');
            $b_phone2 = $this->request->getPost('b_phone2');
            $b_phone3 = $this->request->getPost('b_phone3');

            $membership_qualification = $this->request->getPost('membership_qualification');

            $business_type = $this->request->getPost('business_type');
            $business_industry = $this->request->getPost('business_industry');
            $bussiness_web = $this->request->getPost('bussiness_web');
            $user_department = $this->request->getPost('user_department');

            $organization_name = $this->request->getPost('organization_name');
            $organization_director = $this->request->getPost('organization_director');
            $organization_zip = $this->request->getPost('organization_zip');
            $organization_addr1 = $this->request->getPost('organization_addr1');
            $organization_addr2 = $this->request->getPost('organization_addr2');

            $department_name = $this->request->getPost('department_name');
            $manager_name = $this->request->getPost('manager_name');
            $m_mobile1 = $this->request->getPost('m_mobile1');
            $m_mobile2 = $this->request->getPost('m_mobile2');
            $m_mobile3 = $this->request->getPost('m_mobile3');
            $manager_phone = $m_mobile1 . '-' . $m_mobile2 . '-' . $m_mobile3;

            $member_name = $this->request->getPost('member_name');
            $member_email = $this->request->getPost('member_email');
            $me_mobile1 = $this->request->getPost('me_mobile1');
            $me_mobile2 = $this->request->getPost('me_mobile2');
            $me_mobile3 = $this->request->getPost('me_mobile3');
            $member_phone = $me_mobile1 . '-' . $me_mobile2 . '-' . $me_mobile3;

            $group_introduction = $this->request->getPost('group_introduction');
            $group_history = $this->request->getPost('group_history');

            $files = $this->request->getFiles();

            $r_phone = $r_phone1 . '-' . $r_phone2 . '-' . $r_phone3;
            $m_phone = $m_phone1 . '-' . $m_phone2 . '-' . $m_phone3;
            $s_phone = $s_phone1 . '-' . $s_phone2 . '-' . $s_phone3;
            $business_phone = $b_phone1 . '-' . $b_phone2 . '-' . $b_phone3;
            $course_idx_array = $this->request->getPost('course_idx');
            $course_idx = !empty($course_idx_array) ? implode(',', $course_idx_array) : '';

            $data = [
                'user_name' => $user_name,
                'user_email' => $user_email,
                'work_position' => $work_position,
                'company_name' => $company_name,
                'company_representative' => $company_representative,
                'business_number' => $business_number,
                'user_email_yn' => $user_email_yn,
                'sms_yn' => $sms_yn,
                'zip' => $zip,
                'addr1' => $addr1,
                'addr2' => $addr2,
                'user_phone' => $r_phone,
                'user_mobile' => $m_phone,
                // 'manager_id' => $manager_id,
                'membership_type' => $membership_type,
                'membership_organization' => $membership_organization,
                'membership_zip' => $membership_zip,
                'membership_addr1' => $membership_addr1,
                'membership_addr2' => $membership_addr2,
                'membership_phone' => $s_phone,
                // 'extra_affiliation' => $extra_affiliation,
                // 'extra_period' => $extra_period,
                // 'membership_qualification' => $membership_qualification,
                'business_type' => $business_type,
                'business_industry' => $business_industry,
                'business_phone' => $business_phone,
                'bussiness_web' => $bussiness_web,
                'user_department' => $user_department,
                'organization_name' => $organization_name,
                'organization_director' => $organization_director,
                'organization_zip' => $organization_zip,
                'organization_addr1' => $organization_addr1,
                'organization_addr2' => $organization_addr2,
                'department_name' => $department_name,
                'manager_name' => $manager_name,
                'manager_phone' => $manager_phone,
                'member_name' => $member_name,
                'member_email' => $member_email,
                'member_phone' => $member_phone,
                'group_introduction' => $group_introduction,
                'group_history' => $group_history,
                'course_idx' => $course_idx,
            ];

            if ($manager_pw) {
                $user_pw = password_hash($manager_pw, PASSWORD_BCRYPT);
                $data['manager_pw'] = $user_pw;
            }

            if ($delete_file == 1) {
                $data['company_file'] = null;
            }

            $file = $files['company_file'] ?? null;
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $ufile = $file->getRandomName();
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                $file->move($uploadPath, $ufile);
                $data['company_file'] = $ufile;
            }

            $membership_photo = $files['membership_photo'] ?? null;
            if ($membership_photo && $membership_photo->isValid() && !$membership_photo->hasMoved()) {
                if (!empty($currentMember['membership_photo'])) {
                    $oldFilePath = $uploadPath . $currentMember['membership_photo'];
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                $ufile = $membership_photo->getRandomName();
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                $membership_photo->move($uploadPath, $ufile);
                $data['membership_photo'] = $ufile;
            }

            $qualification_file = $files['qualification_file'] ?? null;
            if ($qualification_file && $qualification_file->isValid() && !$qualification_file->hasMoved()) {
                if (!empty($currentMember['qualification_file'])) {
                    $oldFilePath = $uploadPath . $currentMember['qualification_file'];
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                $ufile = $qualification_file->getRandomName();
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                $qualification_file->move($uploadPath, $ufile);
                $data['qualification_file'] = $ufile;
            }

            $this->memberModel->update($m_idx, $data);

            if ($currentMember['member_type'] == 'N') {
                $this->educationModel->where('m_idx', $m_idx)->delete();
                $this->careerModel->where('m_idx', $m_idx)->delete();
                $this->extraModel->where('m_idx', $m_idx)->delete();
                $this->qualificationModel->where('m_idx', $m_idx)->delete();

                $education_periods = $this->request->getPost('membership_period');
                $education_schools = $this->request->getPost('membership_school');
                $education_departments = $this->request->getPost('membership_department');
                $education_degrees = $this->request->getPost('membership_degree');

                if (is_array($education_periods) && count($education_periods) > 0) {
                    foreach ($education_periods as $index => $period) {
                        if (!empty(trim($period)) && !empty(trim($education_schools[$index] ?? ''))) {
                            $educationData = [
                                'm_idx' => $m_idx,
                                'membership_period' => trim($period),
                                'membership_school' => trim($education_schools[$index] ?? ''),
                                'membership_department' => trim($education_departments[$index] ?? ''),
                                'membership_degree' => trim($education_degrees[$index] ?? ''),
                            ];
                            $this->educationModel->insert($educationData);
                        }
                    }
                }

                $career_periods = $this->request->getPost('active_period');
                $career_affiliations = $this->request->getPost('active_affiliation');
                $career_departments = $this->request->getPost('active_department');
                $career_positions = $this->request->getPost('active_position');

                if (is_array($career_periods) && count($career_periods) > 0) {
                    foreach ($career_periods as $index => $period) {
                        if (!empty(trim($period)) && !empty(trim($career_affiliations[$index] ?? ''))) {
                            $careerData = [
                                'm_idx' => $m_idx,
                                'active_period' => trim($period),
                                'active_affiliation' => trim($career_affiliations[$index] ?? ''),
                                'active_department' => trim($career_departments[$index] ?? ''),
                                'active_position' => trim($career_positions[$index] ?? ''),
                            ];
                            $this->careerModel->insert($careerData);
                        }
                    }
                }

                $extra_periods = $this->request->getPost('extra_period');
                $extra_affiliations = $this->request->getPost('extra_affiliation');

                if (is_array($extra_periods)) {
                    foreach ($extra_periods as $index => $period) {
                        if (!empty($period) && !empty($extra_affiliations[$index])) {
                            $extraData = [
                                'm_idx' => $m_idx,
                                'extra_period' => $period,
                                'extra_affiliation' => $extra_affiliations[$index] ?? '',
                            ];
                            $this->extraModel->insert($extraData);
                        }
                    }
                }

                $membership_affiliations = $this->request->getPost('membership_qualification');

                if (is_array($membership_affiliations)) {
                    foreach ($membership_affiliations as $affiliation) {
                        if (!empty($affiliation)) {
                            $extraData = [
                                'm_idx' => $m_idx,
                                'membership_qualification' => $affiliation,
                            ];
                            $this->qualificationModel->insert($extraData);
                        }
                    }
                }
            }

            return $this
                ->response
                ->setStatusCode(200)
                ->setJSON([
                    'status' => 'success',
                    'message' => '편집이 완료되었습니다.',
                ]);
        } catch (\Exception $e) {
            return $this
                ->response
                ->setStatusCode(500)
                ->setJSON([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function delete()
    {
        try {
            $m_idx = $this->request->getPost('m_idx');
            if (count($m_idx) > 0) {
                for ($i = 0; $i < count($m_idx); $i++) {
                    $this->memberModel->delete($m_idx[$i]);
                }
            }

            return $this
                ->response
                ->setStatusCode(200)
                ->setJSON([
                    'status' => 'success',
                    'message' => '삭제되었습니다.',
                ]);
        } catch (\Exception $e) {
            return $this
                ->response
                ->setStatusCode(500)
                ->setJSON([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function exportExcel()
    {
        try {
            $type = $this->request->getGet('type') ?? 'N';

            if (!in_array($type, ['N', 'G', 'S'])) {
                return redirect()->back()->with('error', '잘못된 회원 유형입니다.');
            }

            require_once FCPATH . 'PhpOffice/SimpleXLSXGen.php';

            $members = $this->memberModel
                ->where('member_type', $type)
                ->orderBy('m_idx', 'DESC')
                ->findAll();

            if (empty($members)) {
                return redirect()->back()->with('error', '데이터가 없습니다.');
            }

            $data = [];

            if ($type == 'N') {
                $data[] = [
                    '번호',
                    '아이디',
                    '이메일',
                    '성명',
                    '직책',
                    '사무실 전화번호',
                    '휴대번호',
                    '우편번호',
                    '주소',
                    '상세주소',
                    '가입일시',
                    '상태',
                    '개인회원 종류',
                    '소속 - 기관/직위',
                    '소속 - 우편번호',
                    '소속 - 주소',
                    '소속 - 상세주소',
                    '소속 - 전화번호',
                    '학력 정보',
                    '주요경력 정보',
                    '대외활동 정보',
                    '자격사항 정보'
                ];

                $num = 1;
                foreach ($members as $member) {
                    $statusText = '';
                    if ($member['status'] == '1') {
                        $statusText = '정상';
                    } elseif ($member['status'] == '0') {
                        $statusText = '잠김';
                    } elseif ($member['status'] == 'O') {
                        $statusText = '탈퇴';
                    }

                    // 학력 정보
                    $educations = $this->educationModel->where('m_idx', $member['m_idx'])->findAll();
                    $educationText = '';
                    if (!empty($educations)) {
                        $eduParts = [];
                        foreach ($educations as $edu) {
                            $eduParts[] = sprintf(
                                "[%s] %s - %s (%s)",
                                $edu['membership_period'] ?? '',
                                $edu['membership_school'] ?? '',
                                $edu['membership_department'] ?? '',
                                $edu['membership_degree'] ?? ''
                            );
                        }
                        $educationText = implode(" | ", $eduParts);
                    }

                    // 주요경력 정보
                    $careers = $this->careerModel->where('m_idx', $member['m_idx'])->findAll();
                    $careerText = '';
                    if (!empty($careers)) {
                        $careerParts = [];
                        foreach ($careers as $career) {
                            $careerParts[] = sprintf(
                                "[%s] %s - %s (%s)",
                                $career['active_period'] ?? '',
                                $career['active_affiliation'] ?? '',
                                $career['active_department'] ?? '',
                                $career['active_position'] ?? ''
                            );
                        }
                        $careerText = implode(" | ", $careerParts);
                    }

                    // 대외활동 정보
                    $extras = $this->extraModel->where('m_idx', $member['m_idx'])->findAll();
                    $extraText = '';
                    if (!empty($extras)) {
                        $extraParts = [];
                        foreach ($extras as $extra) {
                            $extraParts[] = sprintf(
                                "[%s] %s",
                                $extra['extra_period'] ?? '',
                                $extra['extra_affiliation'] ?? ''
                            );
                        }
                        $extraText = implode(" | ", $extraParts);
                    }

                    // 자격사항 정보
                    $qualifications = $this->qualificationModel->where('m_idx', $member['m_idx'])->findAll();
                    $qualificationText = '';
                    if (!empty($qualifications)) {
                        $qualParts = [];
                        foreach ($qualifications as $qual) {
                            $qualParts[] = $qual['membership_qualification'] ?? '';
                        }
                        $qualificationText = implode(" | ", $qualParts);
                    }

                    $data[] = [
                        $num,
                        $member['user_id'] ?? '',
                        $member['user_email'] ?? '',
                        $member['user_name'] ?? '',
                        $member['work_position'] ?? '',
                        $member['user_phone'] ?? '',
                        $member['user_mobile'] ?? '',
                        $member['zip'] ?? '',
                        $member['addr1'] ?? '',
                        $member['addr2'] ?? '',
                        $member['r_date'] ?? '',
                        $statusText,
                        $member['membership_type'] ?? '',
                        $member['membership_organization'] ?? '',
                        $member['membership_zip'] ?? '',
                        $member['membership_addr1'] ?? '',
                        $member['membership_addr2'] ?? '',
                        $member['membership_phone'] ?? '',
                        $educationText,
                        $careerText,
                        $extraText,
                        $qualificationText,
                    ];

                    $num++;
                }
            } elseif ($type == 'G') {
                $data[] = [
                    '번호',
                    '아이디',
                    '담당자 아이디',
                    '이메일',
                    '성명',
                    '직책',
                    '부서',
                    '사무실 전화번호',
                    '휴대번호',
                    '가입일시',
                    '상태',
                    '법인명',
                    '대표자명',
                    '사업자번호',
                    '업태',
                    '업종',
                    '홈페이지',
                    '회사 전화번호',
                    '회사 우편번호',
                    '회사 주소',
                    '회사 상세주소',
                    '단체회원 종류',
                    '단체소개',
                    '주요 연혁'
                ];

                $num = 1;
                foreach ($members as $member) {
                    $statusText = '';
                    if ($member['status'] == '1') {
                        $statusText = '정상';
                    } elseif ($member['status'] == '0') {
                        $statusText = '잠김';
                    } elseif ($member['status'] == 'O') {
                        $statusText = '탈퇴';
                    }

                    $data[] = [
                        $num,
                        $member['user_id'] ?? '',
                        $member['manager_id'] ?? '',
                        $member['user_email'] ?? '',
                        $member['user_name'] ?? '',
                        $member['work_position'] ?? '',
                        $member['user_department'] ?? '',
                        $member['user_phone'] ?? '',
                        $member['user_mobile'] ?? '',
                        $member['r_date'] ?? '',
                        $statusText,
                        $member['company_name'] ?? '',
                        $member['company_representative'] ?? '',
                        $member['business_number'] ?? '',
                        $member['business_type'] ?? '',
                        $member['business_industry'] ?? '',
                        $member['bussiness_web'] ?? '',
                        $member['business_phone'] ?? '',
                        $member['zip'] ?? '',
                        $member['addr1'] ?? '',
                        $member['addr2'] ?? '',
                        $member['membership_type'] ?? '',
                        $member['group_introduction'] ?? '',
                        $member['group_history'] ?? '',
                    ];
                    $num++;
                }
            } elseif ($type == 'S') {
                $data[] = [
                    '번호',
                    '아이디',
                    '담당자 아이디',
                    '이메일',
                    '성명',
                    '직책',
                    '부서',
                    '사무실 전화번호',
                    '휴대번호',
                    '가입일시',
                    '상태',
                    '법인명',
                    '대표자명',
                    '사업자번호',
                    '업태',
                    '업종',
                    '홈페이지',
                    '회사 전화번호',
                    '회사 우편번호',
                    '회사 주소',
                    '회사 상세주소',
                    '특별회원 종류',
                    '기관명',
                    '기관장성명',
                    '기관 우편번호',
                    '기관 주소',
                    '기관 상세주소',
                    '부서명',
                    '과장 성명',
                    '과장 전화번호',
                    '담당자 성명',
                    '담당자 전화번호',
                    '담당자 이메일'
                ];

                $num = 1;
                foreach ($members as $member) {
                    $statusText = '';
                    if ($member['status'] == '1') {
                        $statusText = '정상';
                    } elseif ($member['status'] == '0') {
                        $statusText = '잠김';
                    } elseif ($member['status'] == 'O') {
                        $statusText = '탈퇴';
                    }

                    $data[] = [
                        $num,
                        $member['user_id'] ?? '',
                        $member['manager_id'] ?? '',
                        $member['user_email'] ?? '',
                        $member['user_name'] ?? '',
                        $member['work_position'] ?? '',
                        $member['user_department'] ?? '',
                        $member['user_phone'] ?? '',
                        $member['user_mobile'] ?? '',
                        $member['r_date'] ?? '',
                        $statusText,
                        $member['company_name'] ?? '',
                        $member['company_representative'] ?? '',
                        $member['business_number'] ?? '',
                        $member['business_type'] ?? '',
                        $member['business_industry'] ?? '',
                        $member['bussiness_web'] ?? '',
                        $member['business_phone'] ?? '',
                        $member['zip'] ?? '',
                        $member['addr1'] ?? '',
                        $member['addr2'] ?? '',
                        $member['membership_type'] ?? '',
                        $member['organization_name'] ?? '',
                        $member['organization_director'] ?? '',
                        $member['organization_zip'] ?? '',
                        $member['organization_addr1'] ?? '',
                        $member['organization_addr2'] ?? '',
                        $member['department_name'] ?? '',
                        $member['manager_name'] ?? '',
                        $member['manager_phone'] ?? '',
                        $member['member_name'] ?? '',
                        $member['member_phone'] ?? '',
                        $member['member_email'] ?? '',
                    ];
                    $num++;
                }
            }

            $typeNames = [
                'N' => '개인회원',
                'G' => '단체회원',
                'S' => '특별회원'
            ];

            $filename = ($typeNames[$type] ?? '회원') . '_' . date('Y-m-d_His') . '.xlsx';
            $tempPath = WRITEPATH . 'uploads/temp/';

            if (!is_dir($tempPath)) {
                mkdir($tempPath, 0755, true);
            }

            $filepath = $tempPath . $filename;

            $xlsx = \Shuchkin\SimpleXLSXGen::fromArray($data);
            $xlsx->saveAs($filepath);

            while (ob_get_level()) {
                ob_end_clean();
            }

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . filesize($filepath));
            header('Cache-Control: max-age=0');
            header('Pragma: public');

            readfile($filepath);

            @unlink($filepath);

            exit;
        } catch (\Exception $e) {
            log_message('error', 'Excel export error: ' . $e->getMessage());
            return redirect()->back()->with('error', '엑셀 다운로드 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }
}
