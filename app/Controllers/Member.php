<?php

namespace App\Controllers;

use App\Models\MemberModel;
use App\Models\MemberEducationModel;
use App\Models\MemberCareerModel;
use App\Models\MemberExtraModel;
use App\Models\MemberQualificationModel;

class Member extends BaseController
{
    protected $db;
    protected $memberModel;
    protected $educationModel;
    protected $careerModel;
    protected $extraModel;
    protected $qualificationModel;

    public function __construct()
    {
        $this->db = db_connect();
        $this->memberModel = new MemberModel();
        $this->educationModel = new MemberEducationModel();
        $this->careerModel = new MemberCareerModel();
        $this->extraModel = new MemberExtraModel();
        $this->qualificationModel = new MemberQualificationModel();
        date_default_timezone_set('Asia/Seoul');
    }

    public function login()
    {
        return view('login/login', []);
    }

    public function logout()
    {
        session()->remove("member");
        return redirect('/');
    }

    public function processLogin()
    {
        try {
            $user_id = $this->request->getPost('user_id');
            $password = strtolower($this->request->getPost('password'));

            $row = $this->memberModel->where('user_id', $user_id)->first();
            if (!$row) {
                $result = [
                    'status' => 'error',
                    'message' => '아이디가 존재하지 않거나 비밀번호가 일치하지 않습니다.',
                ];
                return $this->response->setJSON($result)->setStatusCode(400);
            }

            if ($row["status"] == "O") {
                $result = [
                    'status' => 'error',
                    'message' => '이 계정은 탈퇴되었습니다.',
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

                if ($row["approval_status"] != "Y") {
                $result = [
                    'status' => 'error',
                    'message' => '한국급경사지안전협회의 확인 후 최종 회원 가입이 승인됩니다!',
                ];
                return $this->response->setJSON($result)->setStatusCode(400);
            }

            session()->remove("member");

            $data = [];

            $data['id'] = $row['user_id'];
            $data['idx'] = $row['m_idx'];
            $data["mIdx"] = $row['m_idx'];
            $data['name'] = $row['user_name'];
            $data['email'] = $row['user_email'];
            $data['level'] = $row['user_level'];
            $data['phone'] = $row['user_mobile'];
            $data['member_type'] = $row['member_type'];

            session()->set("member", $data);

            $result = [
                'status' => 'success',
                'message' => '로그인에 성공했습니다.',
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

    public function join_the_membership()
    {
        return view('login/join_the_membership', []);
    }

    public function join_special_membership()
    {
        return view('login/join_special_membership', []);
    }

    public function membership_infomation($m_idx = null)
    {
        if (!$m_idx) {
            $member = session()->get('member');
            $m_idx = $member['mIdx'] ?? null;
        }
        
        if (!$m_idx) {
            return redirect()->to('/')->with('error', '잘못된 접근입니다.');
        }
        
        return view('login/membership_infomation', [
            'm_idx' => $m_idx
        ]);
    }

    public function membership_group($m_idx = null)
    {
        if (!$m_idx) {
            $member = session()->get('member');
            $m_idx = $member['mIdx'] ?? null;
        }
        
        if (!$m_idx) {
            return redirect()->to('/')->with('error', '잘못된 접근입니다.');
        }
        
        return view('login/membership_group', [
            'm_idx' => $m_idx
        ]);
    }

    public function membership_special($m_idx = null)
    {
        if (!$m_idx) {
            $member = session()->get('member');
            $m_idx = $member['mIdx'] ?? null;
        }
        
        if (!$m_idx) {
            return redirect()->to('/')->with('error', '잘못된 접근입니다.');
        }
        
        return view('login/membership_special', [
            'm_idx' => $m_idx
        ]);
    }

    public function member_infomation_ok()
    {
        try {
            $public_path = FCPATH . 'uploads/member/';
            
            $m_idx = $this->request->getPost('m_idx');
            
            if (!$m_idx) {
                $result = [
                    'status' => 'error',
                    'message' => '회원 정보를 찾을 수 없습니다.',
                ];
                return $this->response->setJSON($result)->setStatusCode(400);
            }
            
            $memberData = $this->memberModel->find($m_idx);
            if (!$memberData) {
                $result = [
                    'status' => 'error',
                    'message' => '회원 정보를 찾을 수 없습니다.',
                ];
                return $this->response->setJSON($result)->setStatusCode(400);
            }
            
            $membership_type = $this->request->getPost('membership_type');
            $membership_organization = $this->request->getPost('membership_organization');
            $membership_zip = $this->request->getPost('membership_zip');
            $membership_addr1 = $this->request->getPost('membership_addr1');
            $membership_addr2 = $this->request->getPost('membership_addr2');
            
            $mobile1 = $this->request->getPost('mobile1');
            $mobile2 = $this->request->getPost('mobile2');
            $mobile3 = $this->request->getPost('mobile3');
            $membership_phone = $mobile1 . '-' . $mobile2 . '-' . $mobile3;
            
            $membership_period = $this->request->getPost('membership_period');
            $membership_school = $this->request->getPost('membership_school');
            $membership_department = $this->request->getPost('membership_department');
            $membership_degree = $this->request->getPost('membership_degree');

            $extra_affiliation = $this->request->getPost('extra_affiliation');
            $extra_period = $this->request->getPost('extra_period');
            
            $active_period = $this->request->getPost('active_period');
            $active_affiliation = $this->request->getPost('active_affiliation');
            $active_department = $this->request->getPost('active_department');
            $active_position = $this->request->getPost('active_position');
            
            $membership_qualification = $this->request->getPost('membership_qualification');
            
            $data = [
                'membership_type' => $membership_type,
                'membership_organization' => $membership_organization,
                'membership_zip' => $membership_zip,
                'membership_addr1' => $membership_addr1,
                'membership_addr2' => $membership_addr2,
                'membership_phone' => $membership_phone,
                // 'membership_period' => $membership_period,
                // 'membership_school' => $membership_school,
                // 'membership_department' => $membership_department,
                // 'membership_degree' => $membership_degree,
                // 'extra_affiliation' => $extra_affiliation,
                // 'extra_period' => $extra_period,
                // 'active_period' => $active_period,
                // 'active_affiliation' => $active_affiliation,
                // 'active_department' => $active_department,
                // 'active_position' => $active_position,
                // 'membership_qualification' => $membership_qualification,
                'approval_status' => 'N'
            ];
            
            $membership_photo = $this->request->getFile('membership_photo');
            if ($membership_photo && $membership_photo->isValid()) {
                if (!empty($memberData['membership_photo']) && file_exists($public_path . $memberData['membership_photo'])) {
                    unlink($public_path . $memberData['membership_photo']);
                }
                
                $newName = $membership_photo->getRandomName();
                $membership_photo->move($public_path, $newName);
                $data['membership_photo'] = $newName;
            }
            
            $qualification_file = $this->request->getFile('qualification_file');
            if ($qualification_file && $qualification_file->isValid()) {
                if (!empty($memberData['qualification_file']) && file_exists($public_path . $memberData['qualification_file'])) {
                    unlink($public_path . $memberData['qualification_file']);
                }
                
                $newName = $qualification_file->getRandomName();
                $qualification_file->move($public_path, $newName);
                $data['qualification_file'] = $newName;
            }
            
            $this->memberModel->update($m_idx, $data);

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

            
            session()->remove("member");
            $result = [
                'status' => 'success',
                // 'message' => '회원가입이 성공적으로 완료되었습니다.',
                'message' => '한국급경사지안전협회의 확인 후 최종 회원 가입이 승인됩니다!',
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

    public function member_group_ok()
    {
        try {
            $public_path = FCPATH . 'uploads/member/';
            
            $m_idx = $this->request->getPost('m_idx');
            
            if (!$m_idx) {
                $result = [
                    'status' => 'error',
                    'message' => '회원 정보를 찾을 수 없습니다.',
                ];
                return $this->response->setJSON($result)->setStatusCode(400);
            }
            
            $memberData = $this->memberModel->find($m_idx);
            if (!$memberData) {
                $result = [
                    'status' => 'error',
                    'message' => '회원 정보를 찾을 수 없습니다.',
                ];
                return $this->response->setJSON($result)->setStatusCode(400);
            }
            
            $membership_type = $this->request->getPost('membership_type');
            $group_introduction = $this->request->getPost('group_introduction');
            $group_history = $this->request->getPost('group_history');
            
            $data = [
                'membership_type' => $membership_type,
                'group_introduction' => $group_introduction,
                'group_history' => $group_history,
                'approval_status' => 'N'
            ];
            
            $membership_photo = $this->request->getFile('membership_photo');
            if ($membership_photo && $membership_photo->isValid()) {
                if (!empty($memberData['membership_photo']) && file_exists($public_path . $memberData['membership_photo'])) {
                    unlink($public_path . $memberData['membership_photo']);
                }
                
                $newName = $membership_photo->getRandomName();
                $membership_photo->move($public_path, $newName);
                $data['membership_photo'] = $newName;
            }
            
            $this->memberModel->update($m_idx, $data);
            session()->remove("member");
            $result = [
                'status' => 'success',
                // 'message' => '한국급경사지안전협회의 확인 후 최종 회원 가입이 승인됩니다!',
                'message' => '한국급경사지안전협회의 확인 후 최종 회원 가입이 승인됩니다!',
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

    public function member_special_ok()
    {
        try {
            $public_path = FCPATH . 'uploads/member/';
            
            $m_idx = $this->request->getPost('m_idx');
            
            if (!$m_idx) {
                $result = [
                    'status' => 'error',
                    'message' => '회원 정보를 찾을 수 없습니다.',
                ];
                return $this->response->setJSON($result)->setStatusCode(400);
            }
            
            $memberData = $this->memberModel->find($m_idx);
            if (!$memberData) {
                $result = [
                    'status' => 'error',
                    'message' => '회원 정보를 찾을 수 없습니다.',
                ];
                return $this->response->setJSON($result)->setStatusCode(400);
            }
            
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
            $member_email = $this->request->getPost('member_email');
            $me_mobile1 = $this->request->getPost('me_mobile1');
            $me_mobile2 = $this->request->getPost('me_mobile2');
            $me_mobile3 = $this->request->getPost('me_mobile3');
            $member_phone = $me_mobile1 . '-' . $me_mobile2 . '-' . $me_mobile3;
            
            $data = [
                'membership_type' => $membership_type,
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
                'approval_status' => 'N'
            ];
            
            $membership_photo = $this->request->getFile('membership_photo');
            if ($membership_photo && $membership_photo->isValid()) {
                if (!empty($memberData['membership_photo']) && file_exists($public_path . $memberData['membership_photo'])) {
                    unlink($public_path . $memberData['membership_photo']);
                }
                
                $newName = $membership_photo->getRandomName();
                $membership_photo->move($public_path, $newName);
                $data['membership_photo'] = $newName;
            }
            
            $this->memberModel->update($m_idx, $data);
            
            $result = [
                'status' => 'success',
                'message' => '한국급경사지안전협회의 확인 후 최종 회원 가입이 승인됩니다!',
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

    public function find_id()
    {
        return view('login/find_id', []);
    }

    public function findIDSendVerifyCode()
    {
        try {
            $type = $this->request->getPost("type");
            $phone = $this->request->getPost("phone");
            $email = $this->request->getPost("email");

            if ($type == 'phone') {
                if (empty($phone)) {
                    $result = [
                        'status' => 'error',
                        'message' => '전화번호를 입력해주세요.',
                    ];
                    return $this->response->setJSON($result)->setStatusCode(400);
                }
                if (!phone_chk($phone)) {
                    $result = [
                        'status' => 'error',
                        'message' => '',
                    ];
                    return $this->response->setJSON($result)->setStatusCode(400);
                }
            } else {

            }

            $result = [
                'status' => 'success',
                'message' => '인증 코드가 성공적으로 전송되었습니다.',
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

    public function findIDVerifyCode()
    {
        try {
            $member = session()->get('member');
            $phone_chk = $member['phone_chk'];

            $verify_code = $this->request->getPost('verify_code');
            if (!$verify_code) {
                $result = [
                    'status' => 'error',
                    'message' => '인증번호를 입력해주세요.',
                ];
                return $this->response->setJSON($result)->setStatusCode(400);
            }

            if (!$phone_chk) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => '인증 시간이 만료되었습니다. 다시 시도해주세요.',
                ])->setStatusCode(400);
            }

            if ($phone_chk != $verify_code) {
                $result = [
                    'status' => 'error',
                    'message' => '인증번호가 일치하지 않습니다.',
                ];
                return $this->response->setJSON($result)->setStatusCode(400);
            }

            $result = [
                'status' => 'success',
                'message' => '인증이 완료되었습니다.',
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

    public function find_id_ok()
    {
        try {
            $type = $this->request->getPost("type");
            $user_name = $this->request->getPost("user_name");
            $phone = $this->request->getPost("phone");
            $email = $this->request->getPost("email");

            if ($type == 'phone') {
                $member = $this->memberModel
                    ->where('user_name', $user_name)
                    ->where('user_mobile', $phone)
                    ->first();

                if (!$member) {
                    $result = [
                        'status' => 'error',
                        'message' => '회원 정보가 존재하지 않습니다. 이름 또는 휴대폰 번호를 확인해주세요.',
                    ];
                    return $this->response->setJSON($result)->setStatusCode(400);
                }

                $user_id = $member['user_id'];

                if (!phone_id($phone, $user_id)) {
                    $result = [
                        'status' => 'error',
                        'message' => '입력하신 휴대폰 번호와 ID 정보가 일치하지 않습니다.',
                    ];
                    return $this->response->setJSON($result)->setStatusCode(400);
                }
            } else {
                $member = $this->memberModel
                    ->where('user_name', $user_name)
                    ->where('user_email', $email)
                    ->first();
            }

            $result = [
                'status' => 'success',
                'message' => '인증이 완료되었습니다.',
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

    public function find_password()
    {
        return view('login/find_password', []);
    }

    public function findPWSendVerifyCode()
    {
        try {
            $type = $this->request->getPost("type");
            $phone = $this->request->getPost("phone");
            $email = $this->request->getPost("email");

            if ($type == 'phone') {
                if (empty($phone)) {
                    $result = [
                        'status' => 'error',
                        'message' => '전화번호를 입력해주세요.',
                    ];
                    return $this->response->setJSON($result)->setStatusCode(400);
                }
                if (!phone_chk($phone)) {
                    $result = [
                        'status' => 'error',
                        'message' => '',
                    ];
                    return $this->response->setJSON($result)->setStatusCode(400);
                }
            } else {

            }

            $result = [
                'status' => 'success',
                'message' => '인증 코드가 성공적으로 전송되었습니다.',
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

    public function findPWVerifyCode()
    {
        try {
            $member = session()->get('member');
            $phone_chk = $member['phone_chk'];

            $verify_code = $this->request->getPost('verify_code');
            if (!$verify_code) {
                $result = [
                    'status' => 'error',
                    'message' => '인증번호를 입력해주세요.',
                ];
                return $this->response->setJSON($result)->setStatusCode(400);
            }

            if (!$phone_chk) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => '인증 시간이 만료되었습니다. 다시 시도해주세요.',
                ])->setStatusCode(400);
            }

            if ($phone_chk != $verify_code) {
                $result = [
                    'status' => 'error',
                    'message' => '인증번호가 일치하지 않습니다.',
                ];
                return $this->response->setJSON($result)->setStatusCode(400);
            }

            $result = [
                'status' => 'success',
                'message' => '인증이 완료되었습니다.',
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

    public function find_password_ok()
    {
        try {
            $type = $this->request->getPost("type");
            $user_id = $this->request->getPost("user_id");
            $user_name = $this->request->getPost("user_name");
            $phone = $this->request->getPost("phone");
            $email = $this->request->getPost("email");

            if ($type == 'phone') {
                $member = $this->memberModel
                    ->where('user_name', $user_name)
                    ->where('user_id', $user_id)
                    ->where('user_mobile', $phone)
                    ->first();

                if (!$member) {
                    $result = [
                        'status' => 'error',
                        'message' => '회원 정보가 존재하지 않습니다. 이름 또는 휴대폰 번호를 확인해주세요.',
                    ];
                    return $this->response->setJSON($result)->setStatusCode(400);
                }

                $pw = generateRandomString(8);
                $user_pw = password_hash($pw, PASSWORD_BCRYPT);

                $m_idx = $member['m_idx'];
                $data = [
                    'user_pw' => $user_pw
                ];
                $this->memberModel->update($m_idx, $data);

                if (!phone_pw($phone, $pw)) {
                    $result = [
                        'status' => 'error',
                        'message' => '입력하신 휴대폰 번호와 ID 정보가 일치하지 않습니다.',
                    ];
                    return $this->response->setJSON($result)->setStatusCode(400);
                }
            } else {
                $member = $this->memberModel
                    ->where('user_name', $user_name)
                    ->where('user_id', $user_id)
                    ->where('user_email', $email)
                    ->first();
            }

            $result = [
                'status' => 'success',
                'message' => '새 비밀번호가 고객님의 휴대폰 번호로 전송되었습니다.',
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

    public function sendSms()
    {
        try {
            $tophone = $this->request->getPost("tophone");
            if (empty($tophone)) {
                $result = [
                    'status' => 'error',
                    'message' => '전화번호를 입력해주세요.',
                ];
                return $this->response->setJSON($result)->setStatusCode(400);
            }
            if (!phone_chk($tophone)) {
                $result = [
                    'status' => 'error',
                    'message' => '',
                ];
                return $this->response->setJSON($result)->setStatusCode(400);
            }

            $result = [
                'status' => 'success',
                'message' => '인증 코드가 성공적으로 전송되었습니다.',
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

    public function checkUserId()
    {
        try {
            $user_id = $this->request->getPost('user_id');

            $userExist = $this->memberModel->where('user_id', $user_id)->first();
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

    public function verifyCode()
    {
        try {
            $verify_code = $this->request->getPost("verify_code");

            if (empty($verify_code)) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => '인증 코드를 입력해주세요.',
                ])->setStatusCode(400);
            }

            $member = session()->get('member');
            $savedCode = $member['phone_chk'] ?? null;

            if (empty($savedCode)) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => '인증 코드가 만료되었습니다. 다시 요청해주세요.',
                ])->setStatusCode(400);
            }

            if ((string)$savedCode !== (string)$verify_code) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => '인증 코드가 올바르지 않습니다.',
                ])->setStatusCode(400);
            }

            $member['phone_chk'] = null;
            session()->set('member', $member);

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => '인증이 완료되었습니다.',
            ]);

        } catch (\Exception $exception) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $exception->getMessage(),
            ])->setStatusCode(500);
        }
    }

    public function member_reg_ok()
    {
        try {
            $public_path = FCPATH . 'uploads/member/';

            $member_type = $this->request->getPost('member_type');
            $user_id = $this->request->getPost('user_id');

            $password = strtolower($this->request->getPost('password'));
            $conf_password = strtolower($this->request->getPost('conf_password'));

            if ($password != $conf_password) {
                $result = [
                    'status' => 'error',
                    'message' => '비밀번호가 일치하지 않습니다.',
                ];
                return $this->response->setJSON($result)->setStatusCode(400);
            }

            $userExist = $this->memberModel->where('user_id', $user_id)->first();
            if ($userExist) {
                $result = [
                    'status' => 'error',
                    'message' => '이미 사용 중인 아이디입니다.',
                ];
                return $this->response->setJSON($result)->setStatusCode(400);
            }

            $user_email1 = $this->request->getPost('user_email1');
            $user_email2 = $this->request->getPost('user_email2');

            // $user_email = $user_email1 . '@' . $user_email2;
            $user_email = $user_email1;

            $company_name = $this->request->getPost('company_name');
            $company_representative = $this->request->getPost('company_representative');
            // $business_number = $this->request->getPost('business_number');
            $user_name = $this->request->getPost('user_name');
            $work_position = $this->request->getPost('work_position');
            $business_type = $this->request->getPost('business_type');
            $business_industry = $this->request->getPost('business_industry');
            $bussiness_web = $this->request->getPost('bussiness_web');
            $user_department = $this->request->getPost('user_department');

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

            $b_phone1 = $this->request->getPost('b_phone1');
            $b_phone2 = $this->request->getPost('b_phone2');
            $b_phone3 = $this->request->getPost('b_phone3');
            $business_phone = $b_phone1 . '-' . $b_phone2 . '-' . $b_phone3;

            $business_number1 = $this->request->getPost('business_number1');
            $business_number2 = $this->request->getPost('business_number2');
            $business_number3 = $this->request->getPost('business_number3');
            $business_number = $business_number1 . '-' . $business_number2 . '-' . $business_number3;

            $sms_yn = $this->request->getPost('sms_yn');
            $user_email_yn = $this->request->getPost('user_email_yn');

            $user_pw = password_hash($password, PASSWORD_BCRYPT);
            $approval_status = 'N';

            $data = [
                'user_id' => $user_id,
                'member_type' => $member_type,
                'user_email' => $user_email,
                'company_name' => $company_name,
                'company_representative' => $company_representative,
                'business_number' => $business_number,
                'user_name' => $user_name,
                'work_position' => $work_position,
                'business_type' => $business_type,
                'business_industry' => $business_industry,
                'business_phone' => $business_phone,
                'bussiness_web' => $bussiness_web,
                'user_department' => $user_department,
                'zip' => $zip,
                'addr1' => $addr1,
                'addr2' => $addr2,
                'user_phone' => $user_phone,
                'user_mobile' => $user_mobile,
                'sms_yn' => $sms_yn,
                'user_email_yn' => $user_email_yn,
                'user_pw' => $user_pw,
                'user_level' => 9,
                'status' => 1,
                'approval_status' => $approval_status,
                'r_date' => date('Y-m-d H:i:s'),
            ];

            $company_file = $this->request->getFile('company_file');
            if ($company_file && $company_file->isValid()) {
                $newName = $company_file->getRandomName();
                $company_file->move($public_path, $newName);
                $data['company_file'] = $newName;
            }

            $this->memberModel->insert($data);

            // if ($member_type == 'N') {
            //     session()->remove("member");

            //     $row = $this->memberModel->where('user_id', $user_id)->first();

            //     $sessionData = [
            //         'id' => $row['user_id'],
            //         'idx' => $row['m_idx'],
            //         'mIdx' => $row['m_idx'],
            //         'name' => $row['user_name'],
            //         'email' => $row['user_email'],
            //         'level' => $row['user_level'],
            //         'phone' => $row['user_mobile'],
            //         'member_type' => $row['member_type'],
            //     ];

            //     session()->set("member", $sessionData);

            //     $result = [
            //         'status' => 'success',
            //         'message' => '회원가입이 성공적으로 완료되었습니다.',
            //         'data' => $sessionData,
            //         'auto_login' => true
            //     ];
            // } else {
                $row = $this->memberModel->where('user_id', $user_id)->first();
                $result = [
                    'status' => 'success',
                    'message' => '한국급경사지안전협회의 확인 후 최종 회원 가입이 승인됩니다!',
                    'data' => [
                        'mIdx' => $row['m_idx'],
                        'member_type' => $row['member_type']
                    ],
                    'auto_login' => false
                ];
            // }
            return $this->response->setJSON($result);
        } catch (\Exception $exception) {
            $result = [
                'status' => 'error',
                'message' => $exception->getMessage(),
            ];
            return $this->response->setJSON($result)->setStatusCode(500);
        }
    }
}
