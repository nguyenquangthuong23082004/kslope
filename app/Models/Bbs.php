<?php

namespace App\Models;

use CodeIgniter\Model;

class Bbs extends Model
{
    protected $table = 'tbl_bbs_list';
    protected $primaryKey = 'bbs_idx';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'code', 'category', 'subject', 'subject_en', 'writer', 'email',
        'user_id', 'm_idx', 'passwd', 'notice_yn', 'secure_yn', 'recomm_yn', 'contents',
        'contents2', 'simple', 'hit', 'keyword', 'url', 's_date', 'e_date', 'reply',
        'ufile1', 'rfile1', 'ufile2', 'rfile2', 'ufile3', 'rfile3', 'ufile4', 'rfile4', 'ufile5', 'rfile5',
        'ufile6', 'rfile6', 'b_ref', 'b_step', 'b_level', 'ip_address', 'r_date',
        'status', 'onum', 'data_type', 'lang', 'link', 'category_no', 'download',
        'apply_method', 'recruit_type', 'employment_type', 'qualification',
        'organization_type', 'work_location', 'manager_name',
        'contact_phone', 'attachment', 'zip', 'addr1', 'addr2', 'company_type',
        'company_phone', 'homepage', 'company_address', 'company_name',
    ];
    protected $skipValidation = false;

    public function getListWithPager(array $params = [], int $perPage = 10, string $group = 'order'): array
    {
        if (!empty($params['keyword'])) {
            $this->like('subject', $params['keyword']);
        }

        if (!empty($params['category_no'])) {
            $this->where('category_no', $params['category_no']);
        }

        if (!empty($params['code'])) {
            $this->where('code', $params['code']);
        }

        if (!empty($params['status'])) {
            $this->where('status', $params['status']);
        }

        if (!empty($params['search_name'])) {
            $this->like($params['search_name'], $params['search_word']);
        }

        if (empty($params['search_name']) && !empty($params['search_word'])) {
            $this->like('subject', $params['search_word'])
                ->orLike('writer', $params['search_word']);
        }

        $this->orderBy('onum', 'DESC');
        $this->orderBy('bbs_idx', 'DESC');

        $items = $this->paginate($perPage, $group);

        return [
            'items' => $items,
            'pager' => $this->pager,
            'total' => $this->pager->getTotal($group),
        ];
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
                ->like('subject', $keyword)
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
            ->orderBy('bbs_idx', 'DESC')
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
