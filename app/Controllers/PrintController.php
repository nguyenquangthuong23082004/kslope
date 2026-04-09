<?php

namespace App\Controllers;

use App\Models\MemberModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\CourseProgressModel;

class PrintController extends BaseController
{
    protected $memberModel;
    protected $orderModel;
    protected $orderItemModel;
    private $db;
    private $courseModel;
    protected $courseProgressModel;

    public function __construct()
    {
        $this->courseModel = model('CourseModel');
        $this->memberModel = new MemberModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->courseProgressModel = model('CourseProgressModel');
        $this->db = db_connect();
    }

    // public function certificates()
    // {
    //     $data = [];

    //     $idx = $this->request->getVar('idx');

    //     $orderItem = $this->orderItemModel->where('id', $idx)->first();
    //     $order = $this->orderModel->where('idx', $orderItem['order_id'])->first();
    //     $member = $this->memberModel->where('m_idx', $order['user_id'])->first();
    //     $course = $this->courseModel->where('idx', $order['course_idx'])->first();

    //     $data['orderItem'] = $orderItem;
    //     $data['order'] = $order;
    //     $data['member'] = $member;
    //     $data['course'] = $course;

    //     return view('print/certificates.php', $data);
    // }

    public function certificates()
    {
        $userId = $this->request->getGet('user_id');
        $courseIdx = $this->request->getGet('course_idx');
        
        if (!$userId || !$courseIdx) {
            return redirect()->back()->with('error', '잘못된 요청입니다.');
        }
        
        $courseProgress = $this->courseProgressModel->getCourseProgress($userId, $courseIdx);
        
        if (!$courseProgress || $courseProgress['status'] !== 'completed') {
            return redirect()->back()->with('error', '수료 정보를 찾을 수 없습니다.');
        }
        
        $member = $this->memberModel->where('user_id', $userId)->first();
        $course = $this->courseModel->where('idx', $courseIdx)->first();
        
        $manager = null;
        if (!empty($member['manager_id'])) {
            $manager = $this->memberModel->where('user_id', $member['manager_id'])->first();
        }
        
        $data = [
            'courseProgress' => $courseProgress,
            'member' => $member,
            'course' => $course,
            'manager' => $manager,
        ];

        return view('print/certificates.php', $data);
    }
}