<?php

namespace App\Models;

use CodeIgniter\Model;

class BbsCategory extends Model
{
    protected $table = 'tbl_bbs_category';
    protected $primaryKey = 'tbc_idx';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'subject', 'onum', 'code',
    ];
    protected $useTimestamps = true;
    protected $skipValidation = false;

}
