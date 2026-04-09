<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'tbl_order';

    protected $primaryKey = 'idx';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        "order_code", "status", "user_id", "created_at", "course_idx", "memo", "updated_at",
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $skipValidation = false;

    public function isOrderCodeExists(string $orderCode): bool
    {
        return $this->where('order_code', $orderCode)
                ->countAllResults() > 0;
    }

    public function generateOrderCode()
    {
        $date = date('Ymd');
        $builder = $this->builder();
        $builder->like('order_code', $date, 'after');
        $builder->orderBy('order_code', 'DESC');
        $builder->limit(1);

        $row = $builder->get()->getRowArray();

        if ($row) {
            $lastNumber = (int)substr($row['order_code'], -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $order_code = $date . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        return $order_code;
    }

    public function getPageWithPager(array $where = [], int $perPage = 10, string $group = 'notice')
    {
        $builder = $this->builder();

        $builder->select([
            'tbl_order.*',
            'tbl_member.user_name AS user_name',
            'tbl_member.user_mobile AS user_mobile',
            'tbl_member.user_email AS user_email',
            'tbl_member.company_name AS company_name',
            'tbl_course.course_name AS course_name',
            'tbl_course.mentor AS mentor',
            'tbl_course.start_date AS start_date',
            'tbl_course.end_date AS end_date',
            'tbl_course.number_lecture AS number_lecture',
            'tbl_course.price AS price',
            'tbl_course.duration AS duration',
        ]);

        $builder->join('tbl_member', 'tbl_member.user_id = tbl_order.user_id', 'left')
            ->join('tbl_course', 'tbl_course.idx = tbl_order.course_idx', 'left');

        foreach ($where as $key => $val) {
            if ($val !== null && $val !== '' && $key !== 'main') {
                $builder->where($key, $val);
            }
        }

        if (!empty($where['main'])) {
            $keyword = trim($where['main']);

            $builder->groupStart()
                ->like('tbl_order.order_code', $keyword)
                ->orLike('tbl_course.course_name', $keyword)
                ->orLike('tbl_course.mentor', $keyword)
                ->orLike('tbl_member.user_name', $keyword)
                ->orLike('tbl_member.user_email', $keyword)
                ->orLike('tbl_member.user_mobile', $keyword)
                ->groupEnd();
        }

        $countBuilder = clone $builder;
        $total = $countBuilder->countAllResults();

        $pager = service('pager');
        $page = $pager->getCurrentPage($group);
        $page = max(1, $page);

        $offset = ($page - 1) * $perPage;

        $items = $builder
            ->orderBy('tbl_order.idx', 'DESC')
            ->limit($perPage, $offset)
            ->get()
            ->getResultArray();

        $pager->store($group, $page, $perPage, $total);

        return [
            'items' => $items,
            'pager' => $pager,
            'total' => $total
        ];
    }
}