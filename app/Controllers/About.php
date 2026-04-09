<?php

namespace App\Controllers;

use App\Models\Code;

class About extends BaseController
{
    // public function landing(): string
    // {
    //     return view('sub/landing');
    // }
    public function landing(): string
    {
        $codeModel = new Code();

        $landingCode = $codeModel
            ->where('link', 'landing')
            ->where('status', 'Y')
            ->first();

        if (!$landingCode) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rType = $landingCode['code_no']; // ví dụ: 101

        $db = db_connect();
        $builder = $db->table('jk_goods')
            ->where('r_used', 'Y')
            ->where('shopcode', '')
            ->where('r_type', $rType);

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

        return view('sub/landing', [
            // 'activeTitle'   => '랜딩페이지 제작비용',
            'rType'         => $rType,
            'portfolioList' => $portfolioList,
            'totalCount'    => $totalCount,
        ]);
    }

    public function sLanding(): string
    {
        return view('about/landing');
    }

    public function sWebsite(): string
    {
        $codeModel = new Code();

        $landingCode = $codeModel
            ->where('link', 'compnay')
            ->where('status', 'Y')
            ->first();

        if (!$landingCode) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rType = $landingCode['code_no']; 

        $db = db_connect();
        $builder = $db->table('jk_goods')
            ->where('r_used', 'Y')
            ->where('shopcode', '')
            ->where('r_type', $rType);

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

        return view('about/website', [
            // 'activeTitle'   => '랜딩페이지 제작비용',
            'rType'         => $rType,
            'portfolioList' => $portfolioList,
            'totalCount'    => $totalCount,
        ]);
    }

    public function sTour(): string
    {
        // return view('about/tour');
        $codeModel = new Code();

        $landingCode = $codeModel
            ->where('link', 'tour')
            ->where('status', 'Y')
            ->first();

        if (!$landingCode) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rType = $landingCode['code_no']; 

        $db = db_connect();
        $builder = $db->table('jk_goods')
            ->where('r_used', 'Y')
            ->where('shopcode', '')
            ->where('r_type', $rType);

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

        return view('about/tour', [
            // 'activeTitle'   => '랜딩페이지 제작비용',
            'rType'         => $rType,
            'portfolioList' => $portfolioList,
            'totalCount'    => $totalCount,
        ]);
    }

    public function sDetail(): string
    {
        return view('about/detail');
    }

    public function shoppingmall(): string
    {
        // return view('sub/shoppingmall');
        $codeModel = new \App\Models\Code();

        $mall = $codeModel
            ->where('parent_code_no', '1')
            ->where('link', 'mall')
            ->where('status', 'Y')
            ->first();

        if (!$mall) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rType = $mall['code_no'];

        $db = db_connect();
        $builder = $db->table('jk_goods')
            ->where('r_used', 'Y')
            ->where('shopcode', '')
            ->where('r_type', $rType);

        $portfolioList = $builder
            ->orderBy('r_order', 'DESC')
            ->orderBy('r_idx', 'DESC')
            ->limit(6)
            ->get()
            ->getResultArray();

        return view('about/shoppingmall', [
            'activeTitle' => '랜딩페이지 제작비용',
            'portfolioList' => $portfolioList,
            'portfolioType' => $rType, // để dùng cho AJAX load thêm
        ]);
    }

    public function sShoppingmall(): string
    {
        return view('about/shoppingmall');
    }

    public function sRentalmall(): string
    {
        return view('about/rentalmall');
    }

    public function sShopm(): string
    {
        return view('about/shopm');
    }

    public function vietnam(): string
    {
        return view('sub/vietnam');
    }

    public function overview(): string
    {
        return view('sub/overview');
    }

    public function legacy(string $slug): string
    {
        $slug = basename($slug);

        $mapToMethod = [
            'landing' => 'landing',
            'landing' => 'sLanding',
            'landing' => 'sLanding',
            'website' => 'sWebsite',
            'website' => 'sWebsite',
            'solution' => 'landing',
            'solution' => 'landing',
            'marketing' => 'landing',
            'marketing' => 'landing',

            'tour' => 'sTour',
            'tour' => 'sTour',
            'detail' => 'sDetail',
            'detail' => 'sDetail',

            'shoppingmall' => 'shoppingmall',
            's_shoppingmall' => 'sShoppingmall',
            's_shoppingmall' => 'sShoppingmall',
            's_rentalmall' => 'sRentalmall',
            's_rentalmall' => 'sRentalmall',
            's_shopm' => 'sShopm',
            's_shopm' => 'sShopm',
            's_shop_po1' => 'shoppingmall',
            's_shop_po2' => 'shoppingmall',
            's_shop_po3' => 'shoppingmall',

            'vietnam' => 'vietnam',
            'recruite' => 'vietnam',
            'recruite' => 'vietnam',
            's_recruite' => 'vietnam',
            's_recruite' => 'vietnam',
            'safe_zone' => 'vietnam',
            'safe_zone' => 'vietnam',

            'overview' => 'overview',
            'overview' => 'overview',
            'overview_01' => 'overview',
            'uwalworks' => 'overview',
        ];

        if (isset($mapToMethod[$slug])) {
            $method = $mapToMethod[$slug];
            return $this->$method();
        }

        return view('sub/coming_soon', [
            'legacyPath' => 'about/' . $slug,
        ]);
    }
}
