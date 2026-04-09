<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table = 'jk_project';
    protected $primaryKey = 'idx'; 

    protected $allowedFields = [
        'bbs_cls_cd',
        're_ref',
        're_level',
        're_step',
        'notice_yn',
        'title',
        'content',
        'content_reply',
        'content_reply_yn',
        'homepage',
        'hit_cnt',
        'scret_cls',
        'passwd',
        'display_yn',
        'reg_id',
        'reg_nm',
        'regdate',
        'start_date',
        'end_date',
        'per_cell',
        'per_email',
        'group_name',
        'group_num',
        'kind_req',
        'file1',
        'etc2',
        'shopcode'
    ];

    public function getRecentProjects($limit = 10)
    {
        return $this->select('title, start_date')
            ->orderBy('start_date', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}