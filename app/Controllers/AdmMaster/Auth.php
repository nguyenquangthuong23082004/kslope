<?php

namespace App\Controllers\AdmMaster;

use App\Controllers\BaseController;
use App\Models\JkMemberModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('AdmMaster/index');
    }

    public function loginProcess()
    {
        $userId = trim((string) $this->request->getPost('user_id'));
        $userPw = trim((string) $this->request->getPost('user_pw'));

        if ($userId === '' || $userPw === '') {
            return redirect()->back()->with('error', '아이디와 비밀번호를 입력해주세요.');
        }

        $memberModel = new \App\Models\JkMemberModel();
        $row = $memberModel->getByUserId($userId);

        // 아이디 없음
        if (!$row) {
            return redirect()->back()->with('error', '존재하지 않는 아이디입니다.');
        }

        // (옵션) 상태 체크: status 컬럼이 Y/N 라면
        if (isset($row['status']) && $row['status'] !== '1') {
            return redirect()->back()->with('error', '사용할 수 없는 계정입니다.');
        }

        // 비밀번호 확인 (기존 logic 유지)
        // ✅ r_passwd -> user_pw
        if (($row['user_pw'] ?? '') !== sql_password($userPw)) {
            return redirect()->back()->with('error', '패스워드가 일치하지 않습니다.');
        }

        // 권한 체크
        // ✅ r_level -> user_level
        if ((int)($row['user_level'] ?? 999) > 2) {
            return redirect()->back()->with('error', '로그인 하실 권한이 없으십니다.');
        }

        // 세션 저장
        // ✅ r_idx,r_userid,r_name,r_email,r_level -> m_idx,user_id,user_name,user_email,user_level
        session()->set('member', [
            'idx'   => (int) $row['m_idx'],
            'id'    => (string) $row['user_id'],
            'name'  => (string) ($row['user_name'] ?? ''),
            'email' => (string) ($row['user_email'] ?? ''),
            'level' => (int) ($row['user_level'] ?? 0),
        ]);

        // (옵션) 로그인 정보 업데이트
        // $memberModel->updateLoginInfo((int)$row['m_idx'], $this->request->getIPAddress());

        return redirect()->to('/AdmMaster/_adminrator/setting')
            ->with('success', '로그인 되었습니다.');
    }

    public function logout()
    {
        session()->remove('member');
        return redirect()->to('/AdmMaster');
    }
}
