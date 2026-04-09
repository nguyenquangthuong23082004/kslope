<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeSetModel extends Model
{
    protected $table            = 'tbl_homeset';
    protected $primaryKey       = 'idx';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'site_name',
        'domain_url',
        'admin_name',
        'admin_email',
        'browser_title',
        'meta_tag',
        'meta_keyword',
        'home_name',
        'home_name_en',
        'store_service01',
        'store_service02',
        'zip',
        'addr1',
        'addr2',
        'comnum',
        'mall_order',
        'com_owner',
        'info_owner',
        'custom_phone',
        'fax',
        'sms_phone',
        'email',
        'munnote_code',
        'logos',
        'logo_footer',
        'logo_adm',
        'bank_user',
        'banks',
        'bank_account',
        'ssl_chk',
        'language',
        'auto_grade',
        'use_mem1',
        'buytext',
        'trantext',
        'og_title',
        'og_des',
        'og_url',
        'og_site',
        'og_img',
        'favico_img',
        'naver_verfct',
        'google_verfct',
        'sms_id',
        'sms_key',
        'allim_apikey',
        'allim_userid',
        'allim_senderkey',
        'npay_but_key',
        'npay_shop_id',
        'npay_certikey',
        'counsel1',
        'counsel2',
        'counsel3',
        'smtp_host',
        'smtp_id',
        'smtp_pass',
        'admin_email_list',
        'kakao_chat',
        'link_kakao_chat',
    ];
    public function getSiteConfig(int $idx = 1): array
    {
        return $this->where('idx', $idx)->first() ?? [];
    }
}
