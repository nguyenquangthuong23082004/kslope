<?php

namespace App\Models;

use CodeIgniter\Model;

class NoticeModel extends Model
{
    protected $table      = 'jk_notice';
    protected $primaryKey = 'r_idx';

    protected $allowedFields = [
        'r_title',
        'r_content',
        'r_name',
        'r_hit',
        'r_notice',
        'r_regdate',
        'r_file',
        'r_file_ori',
        'r_user_idx',
    ];

    protected $useTimestamps = false;
}
