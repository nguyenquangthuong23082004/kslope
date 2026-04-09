<?php

namespace App\Controllers;

class Home extends BaseController
{
    private $db;
    private $orderModel2;

    public function __construct()
    {
        $this->orderModel2 = model("JkOrder2Model");
        $this->db = db_connect();
    }

    public function index()
    {
        return view('AdmMaster/index', [
            'site' => $this->site,
        ]);
    }

    public function QuoteRequest()
    {
        try {
            $uploadPath = ROOTPATH . 'public/data/order';

            $r_company = $this->request->getPost('r_company');
            $r_manager = $this->request->getPost('r_manager');
            $r_email = $this->request->getPost('r_email');
            $r_phone1 = $this->request->getPost('r_phone1');
            $r_phone2 = $this->request->getPost('r_phone2');
            $r_phone3 = $this->request->getPost('r_phone3');
            $r_content = $this->request->getPost('r_content');

            $files = $this->request->getFiles();

            $r_phone = $r_phone1 . '-' . $r_phone2 . '-' . $r_phone3;

            $data = [
                'r_company' => $r_company,
                'r_manager' => $r_manager,
                'r_email' => $r_email,
                'r_content' => $r_content,
                'r_phone' => $r_phone,
                'r_tel' => $r_phone,
                'r_regdate' => date('Y-m-d H:i:s'),
            ];

            $file = $files["r_file"] ?? null;

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $rfile = $file->getClientName();
                $ufile = $file->getRandomName();

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $ufile);

                $data['r_file'] = $ufile;
                $data['r_file_ori'] = $rfile;
            }

            $this->orderModel2->insert($data);

            return $this->response
                ->setStatusCode(200)
                ->setJSON([
                    'status' => 'success',
                    'message' => 'success',
                    'data' => $data
                ]);
        } catch (\Exception $e) {
            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
        }
    }
}
