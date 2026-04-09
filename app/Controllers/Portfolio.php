<?php

namespace App\Controllers;

use App\Models\Code;

class Portfolio extends BaseController
{
    protected $codeModel;

    public function __construct()
    {
        $this->codeModel = new Code();
    }

    public function index()
    {
        return redirect()->to(site_url('pf/all'));
    }

    public function showByLink($codeUrl = 'all'): string
    {
        $codeUrl = strtolower($codeUrl);

        if ($codeUrl === 'all' || empty($codeUrl)) {
            return $this->showByType('ALL');
        }

        $codeInfo = $this->codeModel
            ->where('parent_code_no', '1')
            ->where('link', $codeUrl)
            ->where('status', 'Y')
            ->first();

        if (!$codeInfo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->showByType($codeInfo['code_no']);
    }

    // private function showByType($rType = 'ALL'): string
    // {
    //     $portfolioTypes = $this->codeModel->getListByParentCode('1');
    //     $typeMap = array_column($portfolioTypes, 'code_name', 'code_no');

    //     $db = db_connect();
    //     $builder = $db->table('jk_goods');

    //     $builder->select('*')
    //         ->where('r_used', 'Y')
    //         ->where('shopcode', '');

    //     if ($rType !== 'ALL') {
    //         $builder->where('r_type', $rType);
    //     } else {
    //         $typeCodes = array_column($portfolioTypes, 'code_no');
    //         if (!empty($typeCodes)) {
    //             $builder->whereIn('r_type', $typeCodes);
    //         }
    //     }

    //     $portfolioList = $builder->orderBy('r_order', 'DESC')
    //         ->orderBy('r_idx', 'DESC')
    //         ->limit(20)
    //         ->get()
    //         ->getResultArray();

    //     return view('sub/portfolio', [
    //         'rType' => $rType,
    //         'portfolioTypes' => $portfolioTypes,
    //         'typeMap' => $typeMap,
    //         'portfolioList' => $portfolioList,
    //     ]);
    // }
    private function showByType($rType = 'ALL'): string
    {
        $portfolioTypes = $this->codeModel->getListByParentCode('1');
        $typeMap = array_column($portfolioTypes, 'code_name', 'code_no');

        $db = db_connect();
        $builder = $db->table('jk_goods')
            ->where('r_used', 'Y')
            ->where('shopcode', '');

        if ($rType !== 'ALL') {
            $builder->where('r_type', $rType);
        } else {
            $typeCodes = array_column($portfolioTypes, 'code_no');
            if (!empty($typeCodes)) {
                $builder->whereIn('r_type', $typeCodes);
            }
        }
        $keyword = trim((string) $this->request->getGet('keyword'));
        if ($keyword !== '') {
            $builder->like('r_title', $keyword);
        }

        $totalCount = $builder->countAllResults(false);

        $portfolioList = $builder
            ->orderBy('r_order', 'DESC')
            ->orderBy('r_idx', 'DESC')
            ->limit(20)
            ->get()
            ->getResultArray();

        return view('sub/portfolio', [
            'rType' => $rType,
            'portfolioTypes' => $portfolioTypes,
            'typeMap' => $typeMap,
            'portfolioList' => $portfolioList,
            'totalCount' => $totalCount,
        ]);
    }


    public function view(): string
    {
        $idx = (int) ($this->request->getGet('idx') ?? 0);
        if ($idx <= 0) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $db = db_connect();
        $row = $db->table('jk_goods')->where('r_idx', $idx)->get()->getRowArray();
        if (!$row) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $lType = (string) ($this->request->getGet('lType') ?? 'ALL');
        $rType = (string) ($row['r_type'] ?? '');

        $portfolioTypes = $this->codeModel->getListByParentCode('1');
        $typeMap = array_column($portfolioTypes, 'code_name', 'code_no');

        $prevIdx = null;
        $nextIdx = null;

        if ($rType !== '') {
            $prevRow = $db->table('jk_goods')
                ->select('r_idx')
                ->where('r_used', 'Y')
                ->where('r_type', $rType)
                ->where('r_idx <', $idx)
                ->orderBy('r_idx', 'DESC')
                ->limit(1)
                ->get()
                ->getRowArray();

            if ($prevRow) {
                $prevIdx = (int) $prevRow['r_idx'];
            }

            $nextRow = $db->table('jk_goods')
                ->select('r_idx')
                ->where('r_used', 'Y')
                ->where('r_type', $rType)
                ->where('r_idx >', $idx)
                ->orderBy('r_idx', 'ASC')
                ->limit(1)
                ->get()
                ->getRowArray();

            if ($nextRow) {
                $nextIdx = (int) $nextRow['r_idx'];
            }
        }

        $prevUrl = $prevIdx ? (site_url('pf/view') . '?idx=' . $prevIdx . '&lType=' . rawurlencode($lType)) : '#!';
        $nextUrl = $nextIdx ? (site_url('pf/view') . '?idx=' . $nextIdx . '&lType=' . rawurlencode($lType)) : '#!';
        $listUrl = site_url('pf/all');

        $pageTitle = trim($row['browser_title'] ?? '') ?: $row['r_title'];
        $pageDescription = trim($row['meta_des'] ?? '') ?: $row['r_title'];
        $pageKeywords = trim($row['meta_keyword'] ?? '') ?: $row['r_title'];
        $pageImage = !empty($row['r_file']) ? base_url('uploads/file/' . $row['r_file']) : base_url('img/ico/logo_meta.png');
        $pageUrl = current_url();

        return view('sub/portfolio_view', [
            'row' => $row,
            'idx' => $idx,
            'lType' => $lType,
            'typeMap' => $typeMap,
            'prevUrl' => $prevUrl,
            'nextUrl' => $nextUrl,
            'listUrl' => $listUrl,
            'meta' => [
                'title' => $pageTitle,
                'description' => $pageDescription,
                'keywords' => $pageKeywords,
                'subject' => $pageDescription,
                'og_title' => $row['meta_title'],
                'og_description' => $pageDescription,
                'og_image' => $pageImage,
                'og_url' => $pageUrl,
                'og_type' => 'website',
            ]
        ]);
    }
    public function suggest()
    {
        $keyword = trim((string) $this->request->getGet('keyword'));

        if ($keyword === '' || mb_strlen($keyword) < 1) {
            return $this->response->setJSON([]);
        }

        $db = db_connect();
        $list = $db->table('jk_goods')
            ->select('r_idx, r_title')
            ->where('r_used', 'Y')
            ->like('r_title', $keyword)
            ->orderBy('r_order', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();

        return $this->response->setJSON($list);
    }
}
