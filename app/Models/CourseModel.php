<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table = 'tbl_course';
    protected $primaryKey = 'idx';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'course_code_1',
        'course_code_2',
        'course_code_3',
        'course_name',
        'course_introduction',
        'course_description',
        'table_contents',
        'course_url',
        'mentor',
        'start_date',
        'end_date',
        'number_lecture',
        'duration',
        'price',
        'status',
        'onum',
        'created_at',
        'updated_at',
        'u_file',
        'r_file',
        'textbook',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $skipValidation = false;

    public function counts(array $where = [])
    {
        $builder = $this->builder();

        if (!empty($where['course_name'])) {
            $builder->like('course_name', $where['course_name']);
        }
        if (!empty($where['mentor'])) {
            $builder->like('mentor', $where['mentor']);
        }
        if (!empty($where['price'])) {
            $builder->where('price', $where['price']);
        }
        if (!empty($where['main'])) {
            $keyword = $where['main'];

            $builder->groupStart()
                ->like('course_name', $keyword)
                ->orLike('mentor', $keyword)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }

    public function getList(array $where = [])
    {
        if (!empty($where['course_name'])) {
            $this->like('course_name', $where['course_name']);
        }
        if (!empty($where['mentor'])) {
            $this->like('mentor', $where['mentor']);
        }
        if (!empty($where['price'])) {
            $this->where('price', $where['price']);
        }
        return $this->where('status', 1)
            ->orderBy('onum', 'DESC')
            ->orderBy('idx', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getListPaginate(array $where = [], $perPage = 10)
    {
        if (!empty($where['course_name'])) {
            $this->like('course_name', $where['course_name']);
        }
        if (!empty($where['mentor'])) {
            $this->like('mentor', $where['mentor']);
        }
        if (!empty($where['price'])) {
            $this->where('price', $where['price']);
        }
        $this->where('status', 1)
            ->orderBy('onum', 'DESC')
            ->orderBy('idx', 'DESC');

        return $this->paginate($perPage);
    }

    public function getPageWithPager(array $where = [], int $perPage = 10, string $group = 'notice')
    {
        $builder = $this->builder();

        foreach ($where as $key => $val) {
            if ($val !== null && $val !== '' && $key !== 'main') {
                $builder->where($key, $val);
            }
        }

        if (!empty($where['main'])) {
            $keyword = trim($where['main']);

            $builder->groupStart()
                ->like('course_name', $keyword)
                ->orLike('mentor', $keyword)
                ->groupEnd();
        }

        $countBuilder = clone $builder;
        $total = $countBuilder->countAllResults();

        $pager = service('pager');
        $page = $pager->getCurrentPage($group);
        $page = max(1, $page);

        $offset = ($page - 1) * $perPage;

        $items = $builder
            ->orderBy('onum', 'DESC')
            ->orderBy('idx', 'DESC')
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
