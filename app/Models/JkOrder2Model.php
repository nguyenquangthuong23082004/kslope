<?php

namespace App\Models;

use CodeIgniter\Model;

class JkOrder2Model extends Model
{
    protected $table = 'jk_order2';
    protected $primaryKey = 'r_idx';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'r_company',
        'r_manager',
        'r_part',
        'r_phone',
        'r_tel',
        'r_email',
        'r_content',
        'r_file',
        'r_file_ori',
        'r_file2',
        'r_regdate',
        'r_grade',
        'r_charge',
        'r_state',
        'r_state2',
        'r_file2_ori',
        'r_type',
        'r_update',
        'r_status',
    ];


    public function counts(array $where = [])
    {
        $builder = $this->builder();

        if (!empty($where)) {
            foreach ($where as $key => $val) {
                if ($val !== null && $val !== '' && $key != 'main') {
                    $builder->where($key, $val);
                }
            }
        }

        if (!empty($where['main'])) {

            $keyword = $where['main'];

            $builder->groupStart()
                ->like('r_company', $keyword)
                ->orLike('r_manager', $keyword)
                ->orLike('r_phone', $keyword)
                ->orLike('r_email', $keyword)
                ->orLike('r_content', $keyword)
                ->groupEnd();
        }

        return $builder->countAllResults();
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
                ->like('r_company', $keyword)
                ->orLike('r_manager', $keyword)
                ->orLike('r_phone', $keyword)
                ->orLike('r_email', $keyword)
                ->orLike('r_content', $keyword)
                ->groupEnd();
        }

        $countBuilder = clone $builder;
        $total = $countBuilder->countAllResults();

        $pager = service('pager');
        $page  = $pager->getCurrentPage($group);
        $page  = max(1, $page);

        $offset = ($page - 1) * $perPage;

        $items = $builder
            ->orderBy('r_idx', 'DESC')
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

    public function getList($where, $g_list_rows, $pg)
    {
        $builder = $this->builder();

        if (!empty($where)) {
            foreach ($where as $key => $val) {
                if ($val !== null && $val !== '' && $key != 'main') {
                    $builder->where($key, $val);
                }
            }
        }

        if (!empty($where['main'])) {

            $keyword = $where['main'];

            $builder->groupStart()
                ->like('r_company', $keyword)
                ->orLike('r_manager', $keyword)
                ->orLike('r_phone', $keyword)
                ->orLike('r_email', $keyword)
                ->orLike('r_content', $keyword)
                ->groupEnd();
        }

        $countBuilder = clone $builder;
        $nTotalCount = $countBuilder->countAllResults();

        $nPage = ($nTotalCount > 0) ? ceil($nTotalCount / $g_list_rows) : 1;
        $pg = max(1, (int)$pg);

        $nFrom = ($pg - 1) * $g_list_rows;

        $items = $builder
            ->limit($g_list_rows, $nFrom)
            ->get()
            ->getResultArray();

        return [
            'items' => $items,
            'nTotalCount' => $nTotalCount,
            'nPage' => $nPage,
            'pg' => $pg,
            'g_list_rows' => $g_list_rows,
            'num' => $nTotalCount - $nFrom
        ];
    }
}
