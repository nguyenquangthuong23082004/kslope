<?php

namespace App\Controllers\AdmMaster;

use App\Controllers\BaseController;

class AdminVideoController extends BaseController
{
    private $db;
    private $courseModel;

    private $videoModel;

    public function __construct()
    {
        $this->courseModel = model('CourseModel');
        $this->videoModel = model('VideoModel');
        $this->db = db_connect();
    }

    public function list()
    {
        try {
            $keyword = $this->request->getGet('keyword') ?? '';
            $page_notice = $this->request->getGet('page_notice') ?? 1;

            $where = array();

            $where['main'] = $keyword;
            $perPage = 10;

            $data = $this->videoModel->getPageWithPager($where, $perPage, 'notice');

            $list = $data['items'];
            $pager = $data['pager'];
            $total = $data['total'];

            $data = [
                'num' => $total,
                'items' => $list,
                'pager' => $pager,
                'perPage' => $perPage,
                'page' => $page_notice,
                'keyword' => $keyword ?? '',
            ];

            return view('/AdmMaster/_video/list', $data);
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
            $idx = $this->request->getPost('video_idx');
            $status = $this->request->getPost('status');
            $onum = $this->request->getPost('onum');

            if (count($idx) > 0) {
                for ($i = 0; $i < count($idx); $i++) {
                    $data = [
                        'onum' => $onum[$i],
                        'status' => $status[$i],
                    ];
                    $this->videoModel->update($idx[$i], $data);
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

    public function write()
    {
        try {
            $idx = $this->request->getVar('video_idx');
            $row = $this->videoModel->where('video_idx', $idx)->first();
            $data['row'] = $row;

            return view('AdmMaster/_video/write', $data);
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
            $idx = $this->request->getPost('video_idx');

            $uploadPath = FCPATH . 'uploads/video/';

            $course_idx = $this->request->getPost('course_idx');
            $title = $this->request->getPost('title');
            $short_description = $this->request->getPost('short_description');
            $duration = $this->request->getPost('duration');
            $status = $this->request->getPost('status');
            $onum = $this->request->getPost('onum');
            $video_url = $this->request->getPost('video_url');

            $files = $this->request->getFiles();

            $data = [
                'course_idx' => $course_idx,
                'title' => $title,
                'short_description' => $short_description,
                'status' => $status,
                'onum' => $onum,
                'duration' => $duration,
                'video_url' => $video_url,
            ];

            $file = $files['file_upload'] ?? null;

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $r_file = $file->getClientName();
                $ufile = $file->getRandomName();

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $ufile);

                $data['rfile'] = $r_file;
                $data['ufile'] = $ufile;
            }

            if ($idx) {
                $data['updated_at'] = date('Y-m-d H:i:s');
                $this->videoModel->update($idx, $data);
            } else {
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->videoModel->insert($data);
            }

            return $this
                ->response
                ->setStatusCode(200)
                ->setJSON([
                    'status' => 'success',
                    'message' => isset($idx) ? '편집이 완료되었습니다.' : '등록이 완료되었습니다.',
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
            $idx = $this->request->getPost('video_idx');
            if (count($idx) > 0) {
                for ($i = 0; $i < count($idx); $i++) {
                    $this->videoModel->delete($idx[$i]);
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
}
