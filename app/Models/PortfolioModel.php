<?php

namespace App\Models;

use CodeIgniter\Model;

class PortfolioModel extends Model
{
    protected $table      = 'jk_goods';
    protected $primaryKey = 'r_idx';

    protected $allowedFields = [
        'r_title',
        'r_description',
        'r_keywords',

        'r_file',
        'r_file_ori',

        'r_used',
        'r_type',
        'r_type2',

        'r_client',
        'r_output',
        'r_launching',
        'r_url',
        'r_content',

        'r_file2',
        'r_file2_ori',
        'r_file3',
        'r_file3_ori',
        'r_file4',
        'r_file4_ori',
        'r_file5',
        'r_file5_ori',
        'r_file6',
        'r_file6_ori',

        'shopcode',
        'r_order',
        'r_order2',
        'r_regdate',
        'browser_title',
        'meta_keyword',
        'meta_title',
        'meta_des',

        'main_exposure',
    ];
}
