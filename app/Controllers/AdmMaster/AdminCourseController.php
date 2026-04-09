<?php

namespace App\Controllers\AdmMaster;

use App\Controllers\BaseController;

class AdminCourseController extends BaseController
{
    private $db;
    private $courseModel;

    private $codeModel;
    private $videoModel;

    public function __construct()
    {
        $this->courseModel = model('CourseModel');
        $this->videoModel = model('VideoModel');
        $this->codeModel = model('Code');
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

            $data = $this->courseModel->getPageWithPager($where, $perPage, 'notice');

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

            return view('/AdmMaster/_courses/list', $data);
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
            $idx = $this->request->getPost('idx');
            $status = $this->request->getPost('status');
            $onum = $this->request->getPost('onum');

            if (count($idx) > 0) {
                for ($i = 0; $i < count($idx); $i++) {
                    $data = [
                        'onum' => $onum[$i],
                        'status' => $status[$i],
                    ];
                    $this->courseModel->update($idx[$i], $data);
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
            $idx = $this->request->getVar('idx');

            $row = $this->courseModel->where('idx', $idx)->first();

            $category1 = $this->codeModel->where('code_gubun', 'goods')->where('depth', '1')->first();
            $categories2 = $this->codeModel->where('code_gubun', 'goods')
                ->where('parent_code_no', $category1['code_no'])
                ->where('depth', '2')
                ->orderBy('onum', 'DESC')
                ->orderBy('code_idx', 'DESC')
                ->findAll();

            $categories3 = array();

            if ($row) {
                $categories3 = $this->codeModel->where('code_gubun', 'goods')
                    ->where('parent_code_no', $row['course_code_2'])
                    ->where('depth', '3')
                    ->orderBy('onum', 'DESC')
                    ->orderBy('code_idx', 'DESC')
                    ->findAll();
            }

            $videos = $this->videoModel->where('status', 1)
                ->orderBy('onum', 'DESC')
                ->orderBy('video_idx', 'DESC')
                ->findAll();

            $data['category1'] = $category1;
            $data['categories2'] = $categories2;

            $data['row'] = $row;
            $data['videos'] = $videos;

            $data['categories3'] = $categories3;

            return view('AdmMaster/_courses/write', $data);
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
            $idx = $this->request->getPost('idx');

            $uploadPath = FCPATH . 'uploads/course/';

            $course_code_1 = $this->request->getPost('course_code_1');
            $course_code_2 = $this->request->getPost('course_code_2');
            $course_code_3 = $this->request->getPost('course_code_3');
            $course_name = $this->request->getPost('course_name');
            $course_introduction = $this->request->getPost('course_introduction');
            $course_description = $this->request->getPost('course_description');
            $table_contents = $this->request->getPost('table_contents') ?? '';

            $mentor = $this->request->getPost('mentor');
            $start_date = $this->request->getPost('start_date');
            $end_date = $this->request->getPost('end_date');
            $number_lecture = $this->request->getPost('number_lecture');
            $price = $this->request->getPost('price');
            $status = $this->request->getPost('status');
            $onum = $this->request->getPost('onum');
            $duration = $this->request->getPost('duration');
            $textbook = $this->request->getPost('textbook');

            $files = $this->request->getFiles();

            $course_url = $this->request->getPost('course_url') ?? [];
            $course_url = array_unique($course_url);
            $list_url = implode(',', $course_url);

            $data = [
                'course_code_1' => $course_code_1,
                'course_code_2' => $course_code_2,
                'course_code_3' => $course_code_3,
                'course_name' => $course_name,
                'course_introduction' => $course_introduction,
                'course_description' => $course_description,
                'table_contents' => $table_contents,
                'course_url' => $list_url,
                'mentor' => $mentor,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'number_lecture' => $number_lecture,
                'price' => $price,
                'status' => $status,
                'onum' => $onum,
                'duration' => $duration,
                'textbook' => $textbook,
            ];

            $file = $files['file_upload'] ?? null;

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $r_file = $file->getClientName();
                $ufile = $file->getRandomName();

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $ufile);

                $data['r_file'] = $r_file;
                $data['u_file'] = $ufile;
            }

            if ($idx) {
                $data['updated_at'] = date('Y-m-d H:i:s');
                $this->courseModel->update($idx, $data);
            } else {
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->courseModel->insert($data);
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
            $idx = $this->request->getPost('idx');
            if (count($idx) > 0) {
                for ($i = 0; $i < count($idx); $i++) {
                    $this->courseModel->delete($idx[$i]);
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
