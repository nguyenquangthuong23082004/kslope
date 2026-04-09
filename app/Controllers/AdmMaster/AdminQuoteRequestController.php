<?php

namespace App\Controllers\AdmMaster;

use App\Controllers\BaseController;

class AdminQuoteRequestController extends BaseController
{
    private $db;
    private $orderModel2;

    public function __construct()
    {
        $this->orderModel2 = model('JkOrder2Model');
        $this->db = db_connect();
    }

    public function list()
    {
        try {
            $pg = $this->request->getGet('pg') ?? 1;
            $keyword = $this->request->getGet('keyword') ?? '';
            $g_list_rows = 10;

            $where = array();

            $where['main'] = $keyword;

            //            $result = $this->orderModel2->getList($where, $g_list_rows, $pg);
            //
            //            $data = [
            //                'items' => $result['items'],
            //                'num' => $result['num'],
            //                'pg' => $pg,
            //                'nTotalCount' => $result['nTotalCount'],
            //                'nPage' => $result['nPage'],
            //                'g_list_rows' => $g_list_rows,
            //                'ca_idx' => $ca_idx ?? '',
            //                'search_category' => $search_category ?? '',
            //                'search_name' => $search_name ?? '',
            //                'keyword' => $keyword ?? '',
            //            ];
            $perPage = 10;

            $data = $this->orderModel2->getPageWithPager($where, $perPage, 'notice');

            $list = $data['items'];
            $pager = $data['pager'];
            $total = $data['total'];

            $data = [
                'num' => $total,
                'items' => $list,
                'pager' => $pager,
                'keyword' => $keyword ?? '',
            ];

            return view('AdmMaster/_quote_request/list', $data);
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

    public function view()
    {
        try {
            $r_idx = $this->request->getVar('r_idx');

            $row = $this->orderModel2->where('r_idx', $r_idx)->first();
            if (empty($row)) {
                return $this
                    ->response
                    ->setStatusCode(404)
                    ->setJSON([
                        'status' => 'error',
                        'message' => 'Not found!',
                    ]);
            }

            $data['row'] = $row;

            return view('AdmMaster/_quote_request/detail', $data);
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

    // public function update()
    // {
    //     try {
    //         $r_idx = $this->request->getPost('r_idx');

    //         $uploadPath = ROOTPATH . 'public/data/order';

    //         $r_company = $this->request->getPost('r_company');
    //         $r_manager = $this->request->getPost('r_manager');
    //         $r_email = $this->request->getPost('r_email');
    //         $r_phone1 = $this->request->getPost('r_phone1');
    //         $r_phone2 = $this->request->getPost('r_phone2');
    //         $r_phone3 = $this->request->getPost('r_phone3');
    //         $r_content = $this->request->getPost('r_content');

    //         $files = $this->request->getFiles();

    //         $r_phone = $r_phone1 . '-' . $r_phone2 . '-' . $r_phone3;

    //         $data = [
    //             'r_company' => $r_company,
    //             'r_manager' => $r_manager,
    //             'r_email' => $r_email,
    //             'r_content' => $r_content,
    //             'r_phone' => $r_phone,
    //             'r_tel' => $r_phone,
    //             'r_update' => date('Y-m-d H:i:s'),
    //         ];

    //         $file = $files['r_file'] ?? null;

    //         if ($file && $file->isValid() && !$file->hasMoved()) {
    //             $rfile = $file->getClientName();
    //             $ufile = $file->getRandomName();

    //             if (!is_dir($uploadPath)) {
    //                 mkdir($uploadPath, 0755, true);
    //             }

    //             $file->move($uploadPath, $ufile);

    //             $data['r_file'] = $ufile;
    //             $data['r_file_ori'] = $rfile;
    //         }

    //         $this->orderModel2->update($r_idx, $data);

    //         return $this
    //             ->response
    //             ->setStatusCode(200)
    //             ->setJSON([
    //                 'status' => 'success',
    //                 'message' => 'success',
    //             ]);
    //     } catch (\Exception $e) {
    //         return $this
    //             ->response
    //             ->setStatusCode(500)
    //             ->setJSON([
    //                 'status' => 'error',
    //                 'message' => $e->getMessage()
    //             ]);
    //     }
    // }

    public function update($id)
    {
            $r_idx = (int) $id;

            $uploadPath = ROOTPATH . 'public/data/order/';

            $r_company = $this->request->getPost('r_company');
            $r_manager = $this->request->getPost('r_manager');
            $r_email = $this->request->getPost('r_email');
            $r_phone1 = $this->request->getPost('r_phone1');
            $r_phone2 = $this->request->getPost('r_phone2');
            $r_phone3 = $this->request->getPost('r_phone3');
            $r_content = $this->request->getPost('r_content');
            $r_status = $this->request->getPost('r_status');

            $files = $this->request->getFiles();

            $r_phone = $r_phone1 . '-' . $r_phone2 . '-' . $r_phone3;

            $data = [
                'r_company' => $r_company,
                'r_manager' => $r_manager,
                'r_email' => $r_email,
                'r_content' => $r_content,
                'r_status' => $r_status,
                'r_phone' => $r_phone,
                'r_tel' => $r_phone,
                'r_update' => date('Y-m-d H:i:s'),
            ];

            $file = $files['r_file'] ?? null;

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $oldRow = $this->orderModel2->find($r_idx);
                if ($oldRow && !empty($oldRow['r_file'])) {
                    $oldFile = $uploadPath . $oldRow['r_file'];
                    if (file_exists($oldFile)) {
                        @unlink($oldFile);
                    }
                }

                $rfile = $file->getClientName();

                $allowedImageMimes = [
                    'image/jpeg',
                    'image/jpg',
                    'image/png',
                    'image/gif',
                    'image/webp'
                ];

                if (in_array($file->getMimeType(), $allowedImageMimes)) {
                    helper('image');
                    $result = simple_upload_and_convert_to_webp($file, $uploadPath, 80, 10000);

                    if ($result['success']) {
                        $data['r_file'] = $result['filename'];
                        $data['r_file_ori'] = $rfile;
                    } else {
                        return redirect()
                            ->back()
                            ->withInput()
                            ->with('error', 'Failed to upload image: ' . $result['error']);
                    }
                } else {
                    $ufile = $file->getRandomName();

                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }

                    $file->move($uploadPath, $ufile);

                    $data['r_file'] = $ufile;
                    $data['r_file_ori'] = $rfile;
                }
            }

            $deleteFile = $this->request->getPost('delete_file');
            if ($deleteFile == '1') {
                $oldRow = $this->orderModel2->find($r_idx);
                if ($oldRow && !empty($oldRow['r_file'])) {
                    $oldFile = $uploadPath . $oldRow['r_file'];
                    if (file_exists($oldFile)) {
                        @unlink($oldFile);
                    }
                    $data['r_file'] = null;
                    $data['r_file_ori'] = null;
                }
            }

            $existing = $this->orderModel2->find($r_idx);
            if (!$existing) {
                return redirect()
                    ->back()
                    ->with('error', 'Record not found');
            }

            $this->orderModel2->update($r_idx, $data);

            return redirect()
                ->to(site_url('/AdmMaster/_quote_request/list'))
                ->with('success', '정상적으로 수정되었습니다.');
    }

    public function delete()
    {
        try {
            $r_idx = $this->request->getPost('r_idx');
            if (count($r_idx) > 0) {
                for ($i = 0; $i < count($r_idx); $i++) {
                    $this->orderModel2->delete($r_idx[$i]);
                }
            }

            return $this
                ->response
                ->setStatusCode(200)
                ->setJSON([
                    'status' => 'success',
                    'message' => 'success',
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

    public function bulkDelete()
    {
        $json = $this->request->getJSON();
        $ids = $json->ids ?? [];

        if (empty($ids)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => '삭제할 항목이 없습니다.'
            ]);
        }

        $uploadPath = ROOTPATH . 'public/data/order/';
        $deleted = 0;

        foreach ($ids as $id) {
            $row = $this->orderModel2->find($id);

            if ($row) {
                if (!empty($row['r_file'])) {
                    $filePath = $uploadPath . $row['r_file'];
                    if (file_exists($filePath)) {
                        @unlink($filePath);
                    }
                }

                if (!empty($row['r_file2'])) {
                    $filePath2 = $uploadPath . $row['r_file2'];
                    if (file_exists($filePath2)) {
                        @unlink($filePath2);
                    }
                }

                $this->orderModel2->delete($id);
                $deleted++;
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => $deleted . '개 항목이 삭제되었습니다.',
            'deleted' => $deleted
        ]);
    }

    public function updateStatus()
    {
        try {
            $r_idx = $this->request->getPost('r_idx');
            $r_status = $this->request->getPost('r_status');

            if (!$r_idx || !$r_status) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => '필수 파라미터가 없습니다.'
                ]);
            }

            $allowedStatus = ['Y', 'S', 'H', 'C'];
            if (!in_array($r_status, $allowedStatus)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => '유효하지 않은 상태값입니다.'
                ]);
            }

            $existing = $this->orderModel2->find($r_idx);
            if (!$existing) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Record not found'
                ]);
            }

            $data = [
                'r_status' => $r_status,
                'r_update' => date('Y-m-d H:i:s'),
            ];

            $this->orderModel2->update($r_idx, $data);

            return $this->response->setJSON([
                'success' => true,
                'message' => '상태가 변경되었습니다.',
                'status' => $r_status
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
