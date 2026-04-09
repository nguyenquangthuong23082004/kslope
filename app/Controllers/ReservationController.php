<?php

namespace App\Controllers;

use App\Models\MemberModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;

class ReservationController extends BaseController
{
    protected $db;
    protected $memberModel;
    protected $orderModel;
    protected $orderItemModel;

    public function __construct()
    {
        $this->db = db_connect();
        $this->memberModel = new MemberModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
    }

    public function store()
    {
        try {
            $user_id = $this->request->getPost('user_id');
            $course_idx = $this->request->getPost('course_idx');
            $created_at = date('Y-m-d H:i:s');
            $status = 'Y';

            $order_code = $this->orderModel->generateOrderCode();

            $data = [
                'user_id' => $user_id,
                'course_idx' => $course_idx,
                'created_at' => $created_at,
                'status' => $status,
                'order_code' => $order_code,
                'memo' => '',
            ];

            $order_idx = $this->orderModel->insert($data);

            $sub_company_names = $this->request->getPost('sub_company_name');
            $positions = $this->request->getPost('position');
            $names = $this->request->getPost('name');
            $genders = $this->request->getPost('gender');
            $birthdays = $this->request->getPost('birthday');
            $phones = $this->request->getPost('phone');
            $residences = $this->request->getPost('residence');

            foreach ($names as $key => $name) {
                $post = [
                    'order_id' => $order_idx,
                    'sub_company_name' => $sub_company_names[$key],
                    'position' => $positions[$key],
                    'name' => $name,
                    'gender' => $genders[$key],
                    'birthday' => $birthdays[$key],
                    'phone' => $phones[$key],
                    'residence' => $residences[$key],
                    'created_at' => $created_at,
                ];

                $this->orderItemModel->insert($post);
            }

            $result = [
                'status' => 'success',
                'message' => '교육 예약이 정상적으로 완료되었습니다.',
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
}
