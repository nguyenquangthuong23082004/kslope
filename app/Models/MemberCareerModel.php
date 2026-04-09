<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberCareerModel extends Model
{
    protected $table = 'tbl_member_career';

    protected $primaryKey = 'idx';

    protected $allowedFields = [
        "m_idx", "active_period", "active_affiliation", "active_department", "active_position",
    ];

}