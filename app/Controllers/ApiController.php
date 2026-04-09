<?php

namespace App\Controllers;

use App\Models\Bbs;
use App\Models\OrderItemModel;
use App\Models\OrderModel;

class ApiController extends BaseController
{
    protected $bbsModel;
    protected $memberModel;
    protected $orderModel;
    protected $orderItemModel;
    private $db;
    private $courseModel;
    private $codeModel;

    public function __construct()
    {
        $this->courseModel = model('CourseModel');
        $this->codeModel = model('Code');
        $this->memberModel = model('MemberModel');
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->bbsModel = new Bbs();
        $this->db = db_connect();
    }

    public function getListCode()
    {
        try {
            $code_no = $this->request->getVar('parent_code_no');
            $depth = $this->request->getVar('depth');

            $codes = $this->codeModel->where('parent_code_no', $code_no)
                ->where('depth', $depth)
                ->orderBy('onum', 'DESC')
                ->orderBy('code_idx', 'DESC')
                ->findAll();

            return $this
                ->response
                ->setStatusCode(200)
                ->setJSON([
                    'status' => 'success',
                    'data' => $codes,
                    'message' => '성공적으로 완료되었습니다.',
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

    public function getListCourse()
    {
        try {
            $category = $this->request->getVar('category');

            $courses = $this->courseModel->where('course_code_2', $category)
                ->orderBy('onum', 'DESC')
                ->orderBy('idx', 'DESC')
                ->findAll();

            return $this
                ->response
                ->setStatusCode(200)
                ->setJSON([
                    'status' => 'success',
                    'data' => $courses,
                    'message' => '성공적으로 완료되었습니다.',
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

    public function findCert()
    {
        try {
            $course = $this->request->getVar('course');
            $user_name = $this->request->getVar('user_name');
            $birthday = $this->request->getVar('birthday');

            $item = $this->orderItemModel->findItem($course, $user_name, $birthday);

            if ($item) $item['valid'] = compareDate($item['end_date']);
            if ($item) $item['start_date'] = date('Y-m-d', strtotime($item['start_date']));
            if ($item) $item['end_date'] = date('Y-m-d', strtotime($item['end_date']));
            if ($item) $item['state'] = $item['valid'] < 1 ? '수료' : '미수료';

            return $this
                ->response
                ->setStatusCode(200)
                ->setJSON([
                    'status' => 'success',
                    'data' => $item,
                    'message' => '성공적으로 완료되었습니다.',
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

    public function uploadFile()
    {
        try {
            $path = $this->request->getPost('path');
            if (empty($path)) $path = 'uploads/tmp/';
            $uploadPath = FCPATH . $path;
            $files = $this->request->getFiles();
            $file = $files['file_upload'] ?? null;

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $r_file = $file->getClientName();
                $ufile = $file->getRandomName();

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $ufile);

                $data['ufile1'] = $ufile;
                $data['rfile1'] = $r_file;
            }

            return $this
                ->response
                ->setStatusCode(200)
                ->setJSON([
                    'status' => 'success',
                    'message' => '성공.',
                    'data' => $data ?? [],
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

    public function uploadChunk()
    {
        try {
            $path = $this->request->getPost('path');
            if (empty($path)) $path = 'uploads/tmp/';

            $file = $this->request->getFile('file');
            $chunkIndex = (int)$this->request->getPost('chunkIndex');
            $totalChunks = (int)$this->request->getPost('totalChunks');
            $identifier = $this->request->getPost('identifier');
            $originalName = $this->request->getPost('filename');

            if (!$file || !$file->isValid()) {
                return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'Invalid file chunk']);
            }

            $tempPath = WRITEPATH . 'uploads/chunks/' . $identifier . '/';
            if (!is_dir($tempPath)) {
                mkdir($tempPath, 0777, true);
            }

            $file->move($tempPath, $chunkIndex);

            if ($chunkIndex === $totalChunks - 1) {
                $finalPath = FCPATH . $path;
                if (!is_dir($finalPath)) {
                    mkdir($finalPath, 0777, true);
                }

                $newName = $identifier . '_' . $originalName;
                $outputFile = $finalPath . $newName;

                $out = fopen($outputFile, "wb");
                for ($i = 0; $i < $totalChunks; $i++) {
                    $chunkFile = $tempPath . $i;
                    if (file_exists($chunkFile)) {
                        $in = fopen($chunkFile, "rb");
                        while ($buff = fread($in, 4096)) {
                            fwrite($out, $buff);
                        }
                        fclose($in);
                        unlink($chunkFile);
                    }
                }
                fclose($out);

                if (is_dir($tempPath)) {
                    rmdir($tempPath);
                }

                return $this->response->setJSON([
                    'status' => 'completed',
                    'file_name' => $originalName,
                    'url' => base_url($path . $newName)
                ]);
            }

            return $this->response->setJSON([
                'status' => 'uploading',
                'chunk' => $chunkIndex
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function downloadBbs()
    {
        try {
            $idx = $this->request->getVar('idx');

            $row = $this->bbsModel->where('bbs_idx', $idx)->where('status', 1)->first();
            if (!$row) {
                return $this
                    ->response
                    ->setStatusCode(404)
                    ->setJSON([
                        'status' => 'error',
                        'message' => 'Not found'
                    ]);
            }

            $ufile1 = $row['ufile1'];
            $rfile1 = $row['rfile1'];

            $filePath = FCPATH . 'uploads/bbs/' . $ufile1;

            if (!file_exists($filePath)) {
                return $this->response
                    ->setStatusCode(404)
                    ->setJSON([
                        'status' => 'error',
                        'message' => 'File not exists'
                    ]);
            }

            $download = $row['download'] + 1;
            $this->bbsModel->update($idx, ['download' => $download]);

            return $this->response->download($filePath, null)
                ->setFileName($rfile1);

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
