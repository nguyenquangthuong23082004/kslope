<?php

namespace App\Controllers;

use App\Models\Bbs;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\MemberEducationModel;
use App\Models\MemberCareerModel;
use App\Models\MemberExtraModel;
use App\Models\MemberQualificationModel;

class MypageController extends BaseController
{
    protected $bbsModel;
    protected $orderModel;
    protected $orderItemModel;
    private $db;
    private $courseModel;
    private $memberModel;
    private $codeModel;
    private $videoModel;
    private $videoProgressModel;
    private $courseProgressModel;
    protected $educationModel;
    protected $careerModel;
    protected $extraModel;
    protected $qualificationModel;

    public function __construct()
    {
        $this->courseModel = model('CourseModel');
        $this->codeModel = model('Code');
        $this->memberModel = model('MemberModel');
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->bbsModel = new Bbs();
        $this->videoModel = model('VideoModel');
        $this->videoProgressModel = model('VideoProgressModel');
        $this->courseProgressModel = model('CourseProgressModel');
        $this->educationModel = new MemberEducationModel();
        $this->careerModel = new MemberCareerModel();
        $this->extraModel = new MemberExtraModel();
        $this->qualificationModel = new MemberQualificationModel();

        $this->db = db_connect();
    }

    public function mypage()
    {
        $page = $this->request->getGet('page') ?? 1;
        $course_code_2 = $this->request->getGet('course_code_2') ?? "";
        $course_idx = $this->request->getGet('course_idx') ?? "";
        $user_name = $this->request->getGet('user_name') ?? "";
        $status = $this->request->getGet('status') ?? "";

        $categories = $this->codeModel->where('code_gubun', 'goods')
            ->where('parent_code_no', '2')
            ->where('depth', '2')
            ->orderBy('onum', 'DESC')
            ->orderBy('code_idx', 'DESC')
            ->findAll();


        $perPage = 1000;

        $list_courses = $this->courseModel->getList() ?? [];

        $manager_id = session()->get("member")['id'];

        $data = $this->courseProgressModel->getCoursesGroupByManager([
            'manager_id' => $manager_id,
            'course_code_2' => $course_code_2,
            'course_idx' => $course_idx,
            'user_name' => $user_name,
            'status' => $status
        ], $perPage, 'notice');

        $courses = $data['items'];
        $pager = $data['pager'];
        $total = $data['total'];

        $startNum = $total - (($page - 1) * $perPage);

        return view('mypage/mypage', [
            "categories" => $categories,
            "list_courses" => $list_courses,
            "courses" => $courses,
            "pager" => $pager,
            "total" => $total,
            "startNum" => $startNum,
            "course_code_2" => $course_code_2,
            "course_idx" => $course_idx,
            "user_name" => $user_name,
            "status" => $status,
        ]);
    }

    public function verify_password()
    {
        $session = session();
        $member = $session->get('member');
        $id = $member['id'];
        $data = [
            'user_id' => $id,
        ];

        return view('mypage/verify_password', $data);
    }

    public function handleVerifyPassword()
    {
        try {
            $session = session();
            $member = $session->get('member');
            $id = $member['id'] ?? '';
            $password = $this->request->getPost('password');

            $row = $this->memberModel->where('user_id', $id)->first();
            if (!$row) {
                $result = [
                    'status' => 'error',
                    'message' => '아이디가 존재하지 않거나 비밀번호가 일치하지 않습니다.',
                ];
                return $this->response->setJSON($result)->setStatusCode(400);
            }

            if (!password_verify($password, $row["user_pw"])) {
                $result = [
                    'status' => 'error',
                    'message' => '비밀번호가 일치하지 않습니다.',
                ];
                return $this->response->setJSON($result)->setStatusCode(400);
            }

            session()->set("is_valid_password", true);

            $result = [
                'status' => 'success',
                'message' => '',
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

    public function edit_member_information()
    {
        $session = session();

        $is_valid = $session->get('is_valid_password');
        if (!$is_valid) return redirect()->to('/verify_password');

        $member = $session->get('member');

        $id = $member['id'] ?? '';
        $row = $this->memberModel->where('user_id', $id)->first();
        if (!$row) {
            $result = [
                'status' => 'error',
                'message' => '아이디가 존재하지 않거나 비밀번호가 일치하지 않습니다.',
            ];
            return $this->response->setJSON($result)->setStatusCode(400);
        }

        $m_idx = $row['m_idx'];

        $educations = $this->educationModel->where('m_idx', $m_idx)->findAll();

        $careers = $this->careerModel->where('m_idx', $m_idx)->findAll();

        $extras = $this->extraModel->where('m_idx', $m_idx)->findAll();

        $qualifications = $this->qualificationModel->where('m_idx', $m_idx)->findAll();

        $data = [
            'row' => $row,
            'educations' => $educations,
            'careers' => $careers,
            'extras' => $extras,
            'qualifications' => $qualifications,
        ];

        return view('mypage/edit_member_information', $data);
    }

    public function save_information()
    {
        try {
            $public_path = FCPATH . 'uploads/member/';

            $session = session();
            $member = $session->get('member');
            $id = $member['id'] ?? '';

            $row = $this->memberModel->where('user_id', $id)->first();
            if (!$row) {
                $result = [
                    'status' => 'error',
                    'message' => '아이디가 존재하지 않거나 비밀번호가 일치하지 않습니다.',
                ];
                return $this->response->setJSON($result)->setStatusCode(400);
            }

            $m_idx = $row['m_idx'];
            $member_type = $this->request->getPost('member_type');

            $email1 = $this->request->getPost('email1');
            $email2 = $this->request->getPost('email2');
            $email = $email1 . '@' . $email2;

            $user_name = $this->request->getPost('user_name');
            $work_position = $this->request->getPost('work_position');
            $zip = $this->request->getPost('zip');
            $addr1 = $this->request->getPost('addr1');
            $addr2 = $this->request->getPost('addr2');

            $phone1 = $this->request->getPost('phone1');
            $phone2 = $this->request->getPost('phone2');
            $phone3 = $this->request->getPost('phone3');
            $user_phone = $phone1 . '-' . $phone2 . '-' . $phone3;

            $mobile1 = $this->request->getPost('mobile1');
            $mobile2 = $this->request->getPost('mobile2');
            $mobile3 = $this->request->getPost('mobile3');
            $user_mobile = $mobile1 . '-' . $mobile2 . '-' . $mobile3;

            $old_password = $this->request->getPost('old_password');
            $new_password = $this->request->getPost('new_password');
            $password_confirm = $this->request->getPost('password_confirm');

            if ($new_password != '' || $password_confirm != '') {
                if (!$old_password) {
                    $result = [
                        'status' => 'error',
                        'message' => '기존 비밀번호가 올바르지 않습니다.',
                    ];
                    return $this->response->setJSON($result)->setStatusCode(400);
                }

                if ($new_password != $password_confirm) {
                    $result = [
                        'status' => 'error',
                        'message' => '새 비밀번호와 비밀번호 확인이 일치하지 않습니다.',
                    ];
                    return $this->response->setJSON($result)->setStatusCode(400);
                }

                if (!password_verify($old_password, $row["user_pw"])) {
                    $result = [
                        'status' => 'error',
                        'message' => '비밀번호가 일치하지 않습니다.',
                    ];
                    return $this->response->setJSON($result)->setStatusCode(400);
                }
            }

            $data = [
                'user_name' => $user_name,
                'user_phone' => $user_phone,
                'user_mobile' => $user_mobile,
                'user_email' => $email,
                'zip' => $zip,
                'addr1' => $addr1,
                'addr2' => $addr2,
                'work_position' => $work_position,
            ];

            if ($new_password != '' || $password_confirm != '') {
                $data['user_pw'] = password_hash($new_password, PASSWORD_BCRYPT);
            }

            if ($member_type == 'G') {
                $company_name = $this->request->getPost('company_name');
                $company_representative = $this->request->getPost('company_representative');
                $business_type = $this->request->getPost('business_type');
                $business_industry = $this->request->getPost('business_industry');
                $bussiness_web = $this->request->getPost('bussiness_web');
                $user_department = $this->request->getPost('user_department');
                $membership_type = $this->request->getPost('membership_type');
                $group_introduction = $this->request->getPost('group_introduction');
                $group_history = $this->request->getPost('group_history');

                $business_number1 = $this->request->getPost('business_number1');
                $business_number2 = $this->request->getPost('business_number2');
                $business_number3 = $this->request->getPost('business_number3');
                $business_number = $business_number1 . '-' . $business_number2 . '-' . $business_number3;

                $b_phone1 = $this->request->getPost('b_phone1');
                $b_phone2 = $this->request->getPost('b_phone2');
                $b_phone3 = $this->request->getPost('b_phone3');
                $business_phone = $b_phone1 . '-' . $b_phone2 . '-' . $b_phone3;

                $data['company_name'] = $company_name;
                $data['company_representative'] = $company_representative;
                $data['business_number'] = $business_number;
                $data['business_type'] = $business_type;
                $data['business_industry'] = $business_industry;
                $data['bussiness_web'] = $bussiness_web;
                $data['business_phone'] = $business_phone;
                $data['user_department'] = $user_department;
                $data['membership_type'] = $membership_type;
                $data['group_introduction'] = $group_introduction;
                $data['group_history'] = $group_history;

                $company_file = $this->request->getFile('company_file');
                if ($company_file && $company_file->isValid()) {
                    if (!empty($row['company_file']) && file_exists($public_path . $row['company_file'])) {
                        unlink($public_path . $row['company_file']);
                    }
                    $newName = $company_file->getRandomName();
                    $company_file->move($public_path, $newName);
                    $data['company_file'] = $newName;
                }

                $membership_photo = $this->request->getFile('membership_photo');
                if ($membership_photo && $membership_photo->isValid()) {
                    if (!empty($row['membership_photo']) && file_exists($public_path . $row['membership_photo'])) {
                        unlink($public_path . $row['membership_photo']);
                    }
                    $newName = $membership_photo->getRandomName();
                    $membership_photo->move($public_path, $newName);
                    $data['membership_photo'] = $newName;
                }
            }

            if ($member_type == 'N') {
                $membership_organization = $this->request->getPost('membership_organization');
                $membership_zip = $this->request->getPost('membership_zip');
                $membership_addr1 = $this->request->getPost('membership_addr1');
                $membership_addr2 = $this->request->getPost('membership_addr2');

                $s_phone1 = $this->request->getPost('s_phone1');
                $s_phone2 = $this->request->getPost('s_phone2');
                $s_phone3 = $this->request->getPost('s_phone3');
                $membership_phone = $s_phone1 . '-' . $s_phone2 . '-' . $s_phone3;

                $data['membership_organization'] = $membership_organization;
                $data['membership_zip'] = $membership_zip;
                $data['membership_addr1'] = $membership_addr1;
                $data['membership_addr2'] = $membership_addr2;
                $data['membership_phone'] = $membership_phone;

                $membership_photo = $this->request->getFile('membership_photo');
                if ($membership_photo && $membership_photo->isValid()) {
                    if (!empty($row['membership_photo']) && file_exists($public_path . $row['membership_photo'])) {
                        unlink($public_path . $row['membership_photo']);
                    }
                    $newName = $membership_photo->getRandomName();
                    $membership_photo->move($public_path, $newName);
                    $data['membership_photo'] = $newName;
                }

                $qualification_file = $this->request->getFile('qualification_file');
                if ($qualification_file && $qualification_file->isValid()) {
                    if (!empty($row['qualification_file']) && file_exists($public_path . $row['qualification_file'])) {
                        unlink($public_path . $row['qualification_file']);
                    }
                    $newName = $qualification_file->getRandomName();
                    $qualification_file->move($public_path, $newName);
                    $data['qualification_file'] = $newName;
                }

                $this->educationModel->where('m_idx', $m_idx)->delete();
                $this->careerModel->where('m_idx', $m_idx)->delete();
                $this->extraModel->where('m_idx', $m_idx)->delete();
                $this->qualificationModel->where('m_idx', $m_idx)->delete();

                $education_periods = $this->request->getPost('membership_period');
                $education_schools = $this->request->getPost('membership_school');
                $education_departments = $this->request->getPost('membership_department');
                $education_degrees = $this->request->getPost('membership_degree');

                if (is_array($education_periods)) {
                    foreach ($education_periods as $index => $period) {
                        if (!empty($period) && !empty($education_schools[$index])) {
                            $educationData = [
                                'm_idx' => $m_idx,
                                'membership_period' => $period,
                                'membership_school' => $education_schools[$index] ?? '',
                                'membership_department' => $education_departments[$index] ?? '',
                                'membership_degree' => $education_degrees[$index] ?? '',
                            ];
                            $this->educationModel->insert($educationData);
                        }
                    }
                }

                $career_periods = $this->request->getPost('active_period');
                $career_affiliations = $this->request->getPost('active_affiliation');
                $career_departments = $this->request->getPost('active_department');
                $career_positions = $this->request->getPost('active_position');

                if (is_array($career_periods)) {
                    foreach ($career_periods as $index => $period) {
                        if (!empty($period) && !empty($career_affiliations[$index])) {
                            $careerData = [
                                'm_idx' => $m_idx,
                                'active_period' => $period,
                                'active_affiliation' => $career_affiliations[$index] ?? '',
                                'active_department' => $career_departments[$index] ?? '',
                                'active_position' => $career_positions[$index] ?? '',
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

                $membership_qualifications = $this->request->getPost('membership_qualification');

                if (is_array($membership_qualifications)) {
                    foreach ($membership_qualifications as $qualification) {
                        if (!empty($qualification)) {
                            $qualificationData = [
                                'm_idx' => $m_idx,
                                'membership_qualification' => $qualification,
                            ];
                            $this->qualificationModel->insert($qualificationData);
                        }
                    }
                }
            }

            if ($member_type == 'S') {
                $membership_type = $this->request->getPost('membership_type');
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

                $me_mobile1 = $this->request->getPost('me_mobile1');
                $me_mobile2 = $this->request->getPost('me_mobile2');
                $me_mobile3 = $this->request->getPost('me_mobile3');
                $member_phone = $me_mobile1 . '-' . $me_mobile2 . '-' . $me_mobile3;

                $member_email = $this->request->getPost('member_email');

                $data['membership_type'] = $membership_type;
                $data['organization_name'] = $organization_name;
                $data['organization_director'] = $organization_director;
                $data['organization_zip'] = $organization_zip;
                $data['organization_addr1'] = $organization_addr1;
                $data['organization_addr2'] = $organization_addr2;
                $data['department_name'] = $department_name;
                $data['manager_name'] = $manager_name;
                $data['manager_phone'] = $manager_phone;
                $data['member_name'] = $member_name;
                $data['member_phone'] = $member_phone;
                $data['member_email'] = $member_email;

                $membership_photo = $this->request->getFile('membership_photo');
                if ($membership_photo && $membership_photo->isValid()) {
                    if (!empty($row['membership_photo']) && file_exists($public_path . $row['membership_photo'])) {
                        unlink($public_path . $row['membership_photo']);
                    }
                    $newName = $membership_photo->getRandomName();
                    $membership_photo->move($public_path, $newName);
                    $data['membership_photo'] = $newName;
                }
            }

            $this->memberModel->update($m_idx, $data);

            $result = [
                'status' => 'success',
                'message' => '회원 정보가 성공적으로 수정되었습니다.',
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

    public function lecture_video()
    {
        $session = session();
        $member = $session->get('member');
        $id = $member['id'] ?? '';

        $row = $this->memberModel->where('user_id', $id)->first();
        if (!$row) {
            $result = [
                'status' => 'error',
                'message' => '아이디가 존재하지 않거나 비밀번호가 일치하지 않습니다.',
            ];
            return $this->response->setJSON($result)->setStatusCode(400);
        }

        // $orders = $this->orderModel->where('user_id', $id)->findAll();

        // $course_idx = array();
        // foreach ($orders as $order) {
        //     $course_idx[] = $order['course_idx'];
        // }
        // $courses = array();
        // if (!empty($course_idx)){
        //     $courses = $this->courseModel->whereIn('idx', $course_idx)
        //         ->where('status', 1)
        //         ->orderBy('onum', 'DESC')
        //         ->orderBy('idx', 'DESC')
        //         ->findAll();
        // }

        $allowedCourses = [];
        if (!empty($row['course_idx'])) {
            $allowedCourses = array_map('trim', explode(',', $row['course_idx']));
        }

        $courses = [];
        if (!empty($allowedCourses)) {
            $courses = $this->courseModel
                ->whereIn('idx', $allowedCourses)
                ->where('status', 1)
                ->orderBy('onum', 'DESC')
                ->orderBy('idx', 'DESC')
                ->findAll();
        }

        $courses = array_map(function ($course) use ($id) {
            $videos = [];

            $course_url = $course['course_url'];
            $arr_url = $course_url ? array_filter(explode(',', $course_url)) : [];

            if (!empty($arr_url)) {
                $videos = $this->videoModel->whereIn('video_idx', $arr_url)
                    ->orderBy('onum', 'ASC')
                    ->findAll();

                foreach ($videos as &$video) {
                    $progress = $this->videoProgressModel->getVideoProgress($id, $video['video_idx']);

                    $video['progress_percent'] = $progress ? $progress['progress_percent'] : 0;
                    $video['is_completed'] = $progress ? $progress['is_completed'] : 0;
                    $video['last_position'] = $progress ? $progress['last_position'] : 0;
                    $video['total_watch_time'] = $progress ? $progress['total_watch_time'] : 0;
                    $video['last_watch_date'] = $progress ? $progress['last_watch_date'] : null;

                    if ($video['is_completed']) {
                        $video['status_text'] = '수강완료';
                        $video['status_class'] = 'status-complete';
                    } elseif ($video['progress_percent'] > 0) {
                        $video['status_text'] = '수강중';
                        $video['status_class'] = 'status-progress';
                    } else {
                        $video['status_text'] = '수강대기';
                        $video['status_class'] = 'status-wait';
                    }
                }
            }

            $course['videos'] = $videos;

            $courseProgress = $this->courseProgressModel->getCourseProgress($id, $course['idx']);

            $course['course_progress_percent'] = $courseProgress ? $courseProgress['progress_percent'] : 0;
            $course['completed_videos'] = $courseProgress ? $courseProgress['completed_videos'] : 0;
            $course['in_progress_videos'] = $courseProgress ? $courseProgress['in_progress_videos'] : 0;
            $course['total_videos'] = $courseProgress ? $courseProgress['total_videos'] : count($videos);
            $course['total_watch_time'] = $courseProgress ? $courseProgress['total_watch_time'] : 0;
            $course['course_status'] = $courseProgress ? $courseProgress['status'] : 'not_started';
            $course['last_access_date'] = $courseProgress ? $courseProgress['last_access_date'] : null;

            return $course;
        }, $courses);

        $data = [
            'courses' => $courses,
            'user_id' => $id
        ];

        return view('mypage/lecture_video', $data);
    }

    public function getVideoProgress()
    {
        $session = session();
        $member = $session->get('member');
        $userId = $member['id'] ?? '';

        if (!$userId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ])->setStatusCode(401);
        }

        $videoIdx = $this->request->getGet('video_idx');

        if (!$videoIdx) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Video ID required'
            ])->setStatusCode(400);
        }

        $progress = $this->videoProgressModel->getVideoProgress($userId, $videoIdx);

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $progress
        ]);
    }

    // public function updateVideoProgress()
    // {
    //     $session = session();
    //     $member = $session->get('member');
    //     $userId = $member['id'] ?? '';

    //     if (!$userId) {
    //         return $this->response->setJSON([
    //             'status' => 'error',
    //             'message' => 'Unauthorized'
    //         ])->setStatusCode(401);
    //     }

    //     $rawInput = file_get_contents('php://input');
    //     $data = json_decode($rawInput, true);

    //     if (!$data || !isset($data['video_idx']) || !isset($data['course_idx'])) {
    //         return $this->response->setJSON([
    //             'status' => 'error',
    //             'message' => 'Invalid data'
    //         ])->setStatusCode(400);
    //     }

    //     $progressData = [
    //         'user_id' => $userId,
    //         'course_idx' => $data['course_idx'],
    //         'video_idx' => $data['video_idx'],
    //         'watch_duration' => $data['watch_duration'] ?? 0,
    //         'total_duration' => $data['total_duration'] ?? 0,
    //         'last_position' => $data['last_position'] ?? 0,
    //         'total_watch_time' => $data['total_watch_time'] ?? 0,
    //         'is_completed' => $data['is_completed'] ?? 0
    //     ];

    //     $this->db->transStart();

    //     try {
    //         $this->videoProgressModel->updateProgress($progressData);

    //         $this->courseProgressModel->updateCourseProgress($userId, $data['course_idx']);

    //         $this->db->transComplete();

    //         if ($this->db->transStatus() === false) {
    //             throw new \Exception('Transaction failed');
    //         }

    //         return $this->response->setJSON([
    //             'status' => 'success',
    //             'message' => 'Progress updated successfully'
    //         ]);
    //     } catch (\Exception $e) {
    //         $this->db->transRollback();

    //         log_message('error', 'Update video progress error: ' . $e->getMessage());

    //         return $this->response->setJSON([
    //             'status' => 'error',
    //             'message' => 'Failed to update progress'
    //         ])->setStatusCode(500);
    //     }
    // }

    public function updateVideoProgress()
    {
           $session = session();
            $member = $session->get('member');
            $userId = $member['id'] ?? '';

            if (!$userId) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ])->setStatusCode(401);
            }

            $rawInput = file_get_contents('php://input');
            $data = json_decode($rawInput, true);

            if (!$data || !isset($data['video_idx']) || !isset($data['course_idx'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Invalid data'
                ])->setStatusCode(400);
            }

            $existingProgress = $this->videoProgressModel->getVideoProgress($userId, $data['video_idx']);
            $wasCompletedBefore = $existingProgress && $existingProgress['is_completed'] == 1;

            $progressData = [
                'user_id'          => $userId,
                'course_idx'       => $data['course_idx'],
                'video_idx'        => $data['video_idx'],
                'watch_duration'   => $data['watch_duration'] ?? 0,
                'total_duration'   => $data['total_duration'] ?? 0,
                'last_position'    => $data['last_position'] ?? 0,
                'total_watch_time' => $data['total_watch_time'] ?? 0,
                'is_completed'     => $data['is_completed'] ?? 0
            ];

        $this->db->transStart();

        try {
            $this->videoProgressModel->updateProgress($progressData);
            $this->courseProgressModel->updateCourseProgress($userId, $data['course_idx']);

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Transaction failed');
            }

            $isNowCompleted = ($data['is_completed'] == 1) || ($data['last_position'] > 0 && $data['total_duration'] > 0 && ($data['last_position'] / $data['total_duration']) >= 1.0);

            if ($isNowCompleted && !$wasCompletedBefore) {
                $this->_sendVideoCompletionAlimTalk($userId);
            }

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Progress updated successfully'
            ]);

        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', 'Update video progress error: ' . $e->getMessage());

            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Failed to update progress'
            ])->setStatusCode(500);
        }
    }

    private function _sendVideoCompletionAlimTalk(string $userId): void
    {
        try {
            $user = $this->memberModel->where('user_id', $userId)->first();
            if (!$user || empty($user['user_mobile'])) {
                log_message('info', 'AlimTalk skip: no user or mobile for ' . $userId);
                return;
            }

            $userMobile   = $user['user_mobile'];
            $userName     = $user['user_name'] ?? '';

            $companyName = '';
            if (!empty($user['manager_id'])) {
                $manager = $this->memberModel->where('user_id', $user['manager_id'])->first();
                if ($manager) {
                    $companyName = $manager['user_name'] ?? '';
                }
            }

            $replace = [
                '#{employee_name}' => $userName,
                '#{company_name}'  => $companyName,
                'phone'            => $userMobile,
            ];

            alimTalkSend('UG_2173', $replace);

            log_message('info', 'AlimTalk sent for video completion: user=' . $userId . ', mobile=' . $userMobile);

        } catch (\Exception $e) {
            log_message('error', 'AlimTalk send error for user ' . $userId . ': ' . $e->getMessage());
        }
    }

    public function lecture_video_detail()
    {
        $session = session();
        $member = $session->get('member');
        $userId = $member['id'] ?? '';

        $idx = $this->request->getVar('idx') ?? '';

        if (!$idx) {
            return redirect()->to('/mypage/lecture_video');
        }

        $video = $this->videoModel->where('video_idx', $idx)->first();
        if (!$video) {
            return redirect()->to('/mypage/lecture_video');
        }

        $progress = $this->videoProgressModel->getVideoProgress($userId, $video['video_idx']);

        $video['progress_percent'] = $progress ? $progress['progress_percent'] : 0;
        $video['is_completed'] = $progress ? $progress['is_completed'] : 0;
        $video['last_position'] = $progress ? $progress['last_position'] : 0;
        $video['total_watch_time'] = $progress ? $progress['total_watch_time'] : 0;
        $video['last_watch_date'] = $progress ? $progress['last_watch_date'] : null;
        $video['course_idx_m'] = $progress ? $progress['course_idx'] : null;

        $data = [
            'video' => $video,
            'user_id' => $userId
        ];

        return view('mypage/lecture_video_detail', $data);
    }

    public function staff_management()
    {
        $session = session();

        $member = $session->get('member');

        $id = $member['id'];

        $search_name = $this->request->getVar('search_name');
        $search_word = $this->request->getVar('search_word');

        $childs = $this->memberModel
            ->where('manager_id', $id)
            ->where('member_type', 'N');

        if ($search_word) $childs = $childs->like($search_name, $search_word);

        $childs = $childs->orderBy('m_idx', 'DESC')
            ->findAll();

        $data = [
            'childs' => $childs,
            'id' => $id,
            'search_name' => $search_name,
            'search_word' => $search_word,
        ];

        return view('mypage/staff_management', $data);
    }

    public function staff_create()
    {
        $session = session();

        $member = $session->get('member');

        $id = $member['id'];

        $user_id = $this->request->getVar('user_id');

        $courses = $this->courseModel
        ->orderBy('course_name', 'ASC')
        ->findAll();

        $data = [
            'id' => $id,
            'user_id' => $user_id,
            'courses' => $courses,
        ];

        if ($user_id) {
            $user = $this->memberModel->where('user_id', $user_id)->first();
            if ($user) $data['user'] = $user;
        }

        return view('mypage/staff_create', $data);
    }

    public function staff_store()
    {
        try {
            $m_idx = $this->request->getPost('m_idx');
            $manager_id = $this->request->getPost('manager_id');
            $user_id = $this->request->getPost('user_id');

            if (!$m_idx) {
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
            }

            $user_name = $this->request->getPost('user_name');

            $email1 = $this->request->getPost('email1');
            $email2 = $this->request->getPost('email2');
            $email = $email1 . '@' . $email2;

            $phone1 = $this->request->getPost('phone1');
            $phone2 = $this->request->getPost('phone2');
            $phone3 = $this->request->getPost('phone3');
            $user_phone = $phone1 . '-' . $phone2 . '-' . $phone3;

            $work_position = $this->request->getPost('work_position');
            $course_idx_array = $this->request->getPost('course_idx') ?? [];
            $course_idx       = !empty($course_idx_array) ? implode(',', (array)$course_idx_array) : '';
            log_message('debug', '[staff_store] course_idx: ' . var_export($course_idx_array, true));

            if (!$m_idx) {
                $data = [
                    'user_id' => $user_id,
                    'user_name' => $user_name,
                    'user_pw' => $user_pw,
                    'user_phone' => $user_phone,
                    'user_mobile' => $user_phone,
                    'user_email' => $email,
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
            } else {
                $data = [
                    'user_name' => $user_name,
                    'user_phone' => $user_phone,
                    'user_mobile' => $user_phone,
                    'user_email' => $email,
                    'work_position' => $work_position,
                    'manager_id' => $manager_id,
                    'course_idx' => $course_idx,
                ];

                $this->memberModel->update($m_idx, $data);
            }

            $result = [
                'status' => 'success',
                'message' => '회원 가입이 접수되었습니다. 한국급경사지안전협회의 확인 후 최종 승인됩니다.',
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
}
