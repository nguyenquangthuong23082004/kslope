<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberEducationModel extends Model
{
    protected $table = 'tbl_member_education';

    protected $primaryKey = 'idx';

    protected $allowedFields = [
        "m_idx", "membership_period", "membership_school", "membership_department", "membership_degree",
    ];

}