<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberExtraModel extends Model
{
    protected $table = 'tbl_member_extra';

    protected $primaryKey = 'idx';

    protected $allowedFields = [
        "m_idx", "extra_affiliation", "extra_period",
    ];

}