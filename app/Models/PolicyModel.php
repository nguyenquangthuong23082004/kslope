<?php

namespace App\Models;

use CodeIgniter\Model;

class PolicyModel extends Model
{
    protected $table = 'tbl_policy';
    protected $primaryKey = 'p_idx';

    protected $allowedFields = [
        'members',
        'minfo1',
        'minfo2',
        'minfo3',
        'trans',
        'emails',
        'minfo4_m',
        'minfo3_m',
        'minfo2_m',
        'minfo1_m',
        'minfo4',
    ];
}