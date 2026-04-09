<?php

namespace App\Controllers\AdmMaster;

use App\Controllers\BaseController;
use App\Models\MemberModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;

class AdminReservationController extends BaseController
{
    protected $memberModel;
    protected $orderModel;
    protected $orderItemModel;
    private $db;
    private $courseModel;

    public function __construct()
    {
        $this->courseModel = model('CourseModel');
        $this->memberModel = new MemberModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
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

            $data = $this->orderModel->getPageWithPager($where, $perPage, 'notice');

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

            return view('/AdmMaster/_reservation/list', $data);
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
            $row = $this->orderModel->where('idx', $idx)->first();

            if (empty($row)) {
                return $this
                    ->response
                    ->setStatusCode(404)
                    ->setJSON([
                        'status' => 'error',
                        'message' => 'Not found!',
                    ]);
            }

            $course = $this->courseModel->where('idx', $row['course_idx'])->first();

            $orderItems = $this->orderItemModel->where('order_id', $idx)->findAll();

            $member = $this->memberModel->where('user_id', $row['user_id'])->first();

            $data = [
                'row' => $row,
                'course' => $course,
                'orderItems' => $orderItems,
                'member' => $member,
            ];

            return view('AdmMaster/_reservation/write', $data);
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

            if (count($idx) > 0) {
                for ($i = 0; $i < count($idx); $i++) {
                    $data = [
                        'status' => $status[$i],
                    ];
                    $this->orderModel->update($idx[$i], $data);
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

    public function update()
    {
        try {
            $idx = $this->request->getPost('idx');
            $status = $this->request->getPost('status');
            $memo = $this->request->getPost('memo');

            $data = [
                'status' => $status,
                'memo' => $memo,
            ];

            $this->orderModel->update($idx, $data);

            $orderItems = $this->orderItemModel->where('order_id', $idx)->findAll();

            $orderItemOldIdx = array();
            foreach ($orderItems as $orderItem) {
                $orderItemOldIdx[] = $orderItem['id'];
            }

            $order_items = $this->request->getPost('order_item');
            $sub_company_names = $this->request->getPost('sub_company_name');
            $positions = $this->request->getPost('position');
            $names = $this->request->getPost('name');
            $genders = $this->request->getPost('gender');
            $birthdays = $this->request->getPost('birthday');
            $phones = $this->request->getPost('phone');
            $residences = $this->request->getPost('residence');

            $resultDel = array_diff($orderItemOldIdx, $order_items);
            foreach ($resultDel as $item) {
                $this->orderItemModel->delete($item);
            }

            foreach ($order_items as $key => $order_item_id) {
                $post = [
                    'sub_company_name' => $sub_company_names[$key],
                    'position' => $positions[$key],
                    'name' => $names[$key],
                    'gender' => $genders[$key],
                    'birthday' => $birthdays[$key],
                    'phone' => $phones[$key],
                    'residence' => $residences[$key],
                ];

                if ($order_item_id) {
                    $post['updated_at'] = date('Y-m-d H:i:s');
                    $this->orderItemModel->update($order_item_id, $post);
                } else {
                    $post['order_id'] = $idx;
                    $post['created_at'] = date('Y-m-d H:i:s');
                    $this->orderItemModel->insert($post);
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

    public function delete()
    {
        try {
            $idx = $this->request->getPost('idx');
            if (count($idx) > 0) {
                for ($i = 0; $i < count($idx); $i++) {
                    $this->orderModel->delete($idx[$i]);

                    $orderItems = $this->orderItemModel->where('order_id', $idx)->findAll();

                    foreach ($orderItems as $orderItem) {
                        $this->orderItemModel->delete($orderItem['id']);
                    }
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
