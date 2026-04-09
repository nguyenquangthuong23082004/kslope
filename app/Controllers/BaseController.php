<?php

namespace App\Controllers;

use App\Models\HomeSetModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class BaseController extends Controller
{
    protected array $site = [];

    public function initController(
        RequestInterface  $request,
        ResponseInterface $response,
        LoggerInterface   $logger
    )
    {
        parent::initController($request, $response, $logger);

        $homeSetModel = new HomeSetModel();
        $site = $homeSetModel->getSiteConfig(1);

        $defaults = [
            'site_name' => '',
            'domain_url' => '',
            'admin_name' => '',
            'admin_email' => '',
            'browser_title' => '',
            'meta_tag' => '',
            'meta_keyword' => '',
            'og_title' => '',
            'og_des' => '',
            'og_url' => '',
            'og_site' => '',
            'og_img' => '',
            'favico_img' => '',
            'logo_footer' => '',
            'logos' => '',
            'buytext' => '',
            'trantext' => '',
            'home_name' => '',
            'home_name_en' => '',
            'store_service01' => '',
            'store_service02' => '',
            'zip' => '',
            'addr1' => '',
            'addr2' => '',
            'comnum' => '',
            'mall_order' => '',
            'com_owner' => '',
            'info_owner' => '',
            'custom_phone' => '',
            'fax' => '',
            'sms_phone' => '',
            'counsel1' => '',
            'counsel2' => '',
            'counsel3' => '',
            'naver_verfct' => '',
            'google_verfct' => '',
            'kakao_chat' => '',
            'link_kakao_chat' => '',
            'smtp_host' => '',
            'smtp_id' => '',
            'smtp_pass' => '',
            'admin_email_list' => '',
        ];

        $this->site = array_merge($defaults, $site);

        service('renderer')->setVar('site', $this->site);
    }

    protected function handleUpload(
        $file,
        string $uploadPath,
        array $allowedTypes,
        int $maxFileSize,
        int $maxWidth = 5000,
        int $maxHeight = 5000
    )
    {
        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return null;
        }

        // Check size
        if ($file->getSize() > $maxFileSize) {
            return [
                'error' => '파일 크기는 100MB를 초과할 수 없습니다.',
            ];
        }

        // Check extension
        $extension = strtolower(pathinfo($file->getClientName(), PATHINFO_EXTENSION));
        if (!in_array($extension, $allowedTypes)) {
            return [
                'error' => '허용되지 않는 파일 형식입니다.',
            ];
        }

        // Check image
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            $imageInfo = getimagesize($file->getTempName());
            if ($imageInfo === false) {
                return [
                    'error' => '유효하지 않은 이미지 파일입니다.',
                ];
            }

            [$width, $height] = $imageInfo;
            if ($width > $maxWidth || $height > $maxHeight) {
                return [
                    'error' => '이미지 크기는 5000x5000 픽셀을 초과할 수 없습니다.',
                ];
            }
        }

        // Create folder
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $originalName = $file->getClientName();
        $randomName = $file->getRandomName();

        $file->move($uploadPath, $randomName);

        return [
            'ufile' => $randomName,
            'rfile' => $originalName,
        ];
    }
}
