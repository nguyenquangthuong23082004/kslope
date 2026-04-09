<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pager extends BaseConfig
{
    public int $perPage = 10;

    public int $numberOfLinks = 4;

    public array $templates = [
        'default_full'    => 'CodeIgniter\Pager\Views\default_full',
        'default_simple'  => 'CodeIgniter\Pager\Views\default_simple',
        'bootstrap5_full' => 'Pager/bootstrap5_full',
        'custom_pagination' => 'Pager/custom_pagination',
    ];
}
