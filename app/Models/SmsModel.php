<?php

namespace App\Models;

use CodeIgniter\Model;

class SmsModel extends Model
{
    protected $table = 'tbl_auto_sms_skin';

    protected $primaryKey = 'idx';

    protected $allowedFields = [
        "title", "content", "code", "autosend",
    ];
}