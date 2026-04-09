<?php

namespace App\Models;

use CodeIgniter\Model;

class VideoModel extends Model
{
    protected $table = 'tbl_video';

    protected $primaryKey = 'video_idx';

    protected $allowedFields = [
        "course_idx", "title", "short_description", "duration", "ufile", "rfile",
        "onum", "status", "video_url", "created_at", "updated_at",
    ];

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
                ->like('title', $keyword)
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
            ->orderBy('video_idx', 'DESC')
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