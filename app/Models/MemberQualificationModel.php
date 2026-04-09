<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberQualificationModel extends Model
{
    protected $table = 'tbl_member_qualification';

    protected $primaryKey = 'idx';

    protected $allowedFields = [
        "m_idx", "membership_qualification", 
    ];

}