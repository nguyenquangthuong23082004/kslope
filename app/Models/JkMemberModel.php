<?php

namespace App\Models;

use CodeIgniter\Model;

class JkMemberModel extends Model
{
    protected $table      = 'tbl_member';
    protected $primaryKey = 'm_idx';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'user_id',
        'user_pw',
        'user_name',
        'sms_yn',
        'user_phone',
        'user_mobile',
        'user_email',
        'user_email_yn',
        'user_level',
        'zip',
        'addr1',
        'addr2',
        'status',
        'user_ip',
        'login_date',
        'r_date',
        'birthday_type',
        'account_name',
        'bank',
        'account_num',
        'login_count',
        'sns_key',
        'company_name',
        'company_representative',
        'company_code',
        'company_file',
        'work_position',
        'company_mail',
    ];

    protected $useTimestamps = false;

    public function getByUserId(string $userId): ?array
    {
        return $this->where('user_id', $userId)->first();
    }
}
