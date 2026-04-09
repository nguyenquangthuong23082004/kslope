<?php

namespace App\Controllers\AdmMaster;

use App\Controllers\BaseController;
use App\Models\Bbs;
use App\Models\Code;

class AdminBbsController extends BaseController
{
    protected $bbsModel;
    private $codeModel;
    private $db;

    public function __construct()
    {
        $this->bbsModel = new Bbs();
        $this->codeModel = new Code();
        $this->db = db_connect();
    }

    public function list()
    {
        try {
            $keyword = $this->request->getGet('keyword') ?? '';
            $code = $this->request->getGet('code') ?? '';
            $page_notice = $this->request->getGet('page_notice') ?? 1;
            $page_count = $this->request->getGet('page_count') ?? 20;

            $where = array();

            $where['main'] = $keyword;
            $where['code'] = $code;
            $perPage = $page_count;

            $data = $this->bbsModel->getPageWithPager($where, $perPage, 'notice');

            $list = $data['items'];
            $pager = $data['pager'];
            $total = $data['total'];


            switch ($code) {
                case 'notice':
                    $title_ = '교공지사항';
                    break;
                case 'recruitment':
                    $title_ = '교채용정보';
                    break;
                case 'promotion':
                    $title_ = '교홍보자료';
                    break;
                case 'competition':
                    $title_ = '교입찰/공모';
                    break;
                case 'association':
                    $title_ = '교협회지';
                    break;
                default:
                    $title_ = '';
                    break;
            }

            $data = [
                'num' => $total,
                'items' => $list,
                'title_' => $title_,
                'code' => $code,
                'pager' => $pager,
                'perPage' => $perPage,
                'page' => $page_notice,
                'page_count' => $page_count,
                'keyword' => $keyword ?? '',
            ];

            return view('/AdmMaster/_bbs/list', $data);
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

    public function write()
    {
        try {
            $bbs_idx = $this->request->getVar('bbs_idx');
            $code = $this->request->getVar('code');
            $row = $this->bbsModel->where('bbs_idx', $bbs_idx)->first();

            if ($code == 'notice') {
                $categories = $this->codeModel->where('code_gubun', 'board')->where('parent_code_no', 301)->findAll();
            } elseif ($code == 'recruitment') {
                $categories = $this->codeModel->where('code_gubun', 'board')->where('parent_code_no', 302)->findAll();
            } elseif ($code == 'promotion') {
                $categories = $this->codeModel->where('code_gubun', 'board')->where('parent_code_no', 303)->findAll();
            } elseif ($code == 'competition') {
                $categories = $this->codeModel->where('code_gubun', 'board')->where('parent_code_no', 304)->findAll();
            } elseif ($code == 'association') {
                $categories = $this->codeModel->where('code_gubun', 'board')->where('parent_code_no', 305)->findAll();
            }

            $data = [
                'code' => $code,
                'categories' => $categories ?? [],
                'row' => $row,
            ];

            return view('AdmMaster/_bbs/write', $data);
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

    public function write_ok()
    {
        try {
            $uploadPath = FCPATH . 'uploads/bbs/';

            $bbs_idx = $this->request->getPost('bbs_idx');

            $code = $this->request->getPost('code');
            $subject = $this->request->getPost('subject');
            $contents = $this->request->getPost('contents');
            $onum = $this->request->getPost('onum');
            $category_no = $this->request->getPost('category_no');
            $writer = $this->request->getPost('writer');
            $hit = $this->request->getPost('hit');

            $contents2 = $this->request->getPost('contents2');
            $s_date = $this->request->getPost('s_date');
            $e_date = $this->request->getPost('e_date');

            $keyword = $this->request->getPost('keyword') ?? '';

            $apply_method = $this->request->getPost('apply_method') ?? '';
            $recruit_type = $this->request->getPost('recruit_type') ?? '';
            $employment_type = $this->request->getPost('employment_type') ?? '';
            $qualification = $this->request->getPost('qualification') ?? '';
            $organization_type = $this->request->getPost('organization_type') ?? '';
            $work_location = $this->request->getPost('work_location') ?? '';
            $manager_name = $this->request->getPost('manager_name') ?? '';
            $contact_phone = $this->request->getPost('contact_phone') ?? '';
            $zip = $this->request->getPost('zip') ?? '';
            $addr1 = $this->request->getPost('addr1') ?? '';
            $addr2 = $this->request->getPost('addr2') ?? '';
            $company_type = $this->request->getPost('company_type') ?? '';
            $company_phone = $this->request->getPost('company_phone') ?? '';
            $homepage = $this->request->getPost('homepage') ?? '';
            $company_address = $this->request->getPost('company_address') ?? '';
            $company_name = $this->request->getPost('company_name') ?? '';
            $link_url = $this->request->getPost('link_url') ?? '';
            
            $download = 0;
            $status = 1;
            $ip_address = $this->request->getIPAddress();
            $r_date = date('Y-m-d H:i:s');

            $data = [
                "code" => $code,
                "subject" => $subject,
                "contents" => $contents,
                "contents2" => $contents2,
                "s_date" => $s_date,
                "e_date" => $e_date,
                "keyword" => $keyword,
                "onum" => $onum,
                "category_no" => $category_no,
                "writer" => $writer ?? '관리자',
                "hit" => $hit,
                "download" => $download,
                "status" => $status,
                "ip_address" => $ip_address,
                "apply_method" => $apply_method,
                "recruit_type" => $recruit_type,
                "employment_type" => $employment_type,
                "qualification" => $qualification,
                "organization_type" => $organization_type,
                "work_location" => $work_location,
                "manager_name" => $manager_name,
                "contact_phone" => $contact_phone,
                "zip" => $zip,
                "addr1" => $addr1,
                "addr2" => $addr2,
                "company_type" => $company_type,
                "company_phone" => $company_phone,
                "homepage" => $homepage,
                "company_address" => $company_address,
                "company_name" => $company_name,
                "link" => $link_url,
            ];

            $files = $this->request->getFiles();
            $maxFileSize = 100 * 1024 * 1024; // 100MB
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'zip', 'rar'];

            $result = $this->handleUpload(
                $files['file_upload'] ?? null,
                $uploadPath,
                $allowedTypes,
                $maxFileSize
            );

            if (isset($result['error'])) {
                return $this->response
                    ->setStatusCode(400)
                    ->setJSON([
                        'status' => 'error',
                        'message' => $result['error'],
                    ]);
            }

            if ($result) {
                $data['ufile1'] = $result['ufile'];
                $data['rfile1'] = $result['rfile'];
            }

            $result = $this->handleUpload(
                $files['attachment'] ?? null,
                $uploadPath,
                $allowedTypes,
                $maxFileSize
            );

            if (isset($result['error'])) {
                return $this->response
                    ->setStatusCode(400)
                    ->setJSON([
                        'status' => 'error',
                        'message' => $result['error'],
                    ]);
            }

            if ($result) {
                $data['ufile2'] = $result['ufile'];
                $data['rfile2'] = $result['rfile'];
            }

            $result = $this->handleUpload(
                $files['image_upload'] ?? null,
                $uploadPath,
                ['jpg', 'jpeg', 'png', 'gif', 'webp'],
                $maxFileSize
            );

            if (isset($result['error'])) {
                return $this->response
                    ->setStatusCode(400)
                    ->setJSON([
                        'status' => 'error',
                        'message' => $result['error'],
                    ]);
            }

            if ($result) {
                $data['ufile3'] = $result['ufile'];
                $data['rfile3'] = $result['rfile'];
            }

            if ($bbs_idx) {
                $this->bbsModel->update($bbs_idx, $data);
            } else {
                $data['r_date'] = $r_date;
                $this->bbsModel->insert($data);
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

    public function delete()
    {
        try {
            $bbs_idx = $this->request->getPost('bbs_idx');
            if (count($bbs_idx) > 0) {
                for ($i = 0; $i < count($bbs_idx); $i++) {
                    $this->bbsModel->delete($bbs_idx[$i]);
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

    public function change()
    {
        try {
            $bbs_idx = $this->request->getPost('bbs_idx');
            $onum = $this->request->getPost('onum');

            if (count($bbs_idx) > 0) {
                for ($i = 0; $i < count($bbs_idx); $i++) {
                    $data = [
                        'onum' => $onum[$i],
                    ];
                    $this->bbsModel->update($bbs_idx[$i], $data);
                }
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
}
