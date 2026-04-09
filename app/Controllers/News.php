<?php

namespace App\Controllers;

class News extends BaseController
{
    public function index(): string
    {
        $request = service('request');

        $cate = (string) ($request->getGet('cate') ?? 'r_title');
        $keyword = trim((string) ($request->getGet('keyword') ?? ''));
        $perPage = (int) ($request->getGet('g_list_rows') ?? 20);
        $perPage = $perPage > 0 ? $perPage : 20;

        $page = (int) ($request->getGet('pg') ?? 1);
        $page = $page > 0 ? $page : 1;

        $allowedCate = ['r_title', 'r_content'];
        if (!in_array($cate, $allowedCate, true)) {
            $cate = 'r_title';
        }

        $db = db_connect();
        $builder = $db->table('jk_notice');
        $builder->where('r_idx >', 0);

        if ($keyword !== '') {
            $builder->like($cate, $keyword);
        }

        $totalCount = (int) $builder->countAllResults(false);
        $totalPages = (int) ceil($totalCount / $perPage);
        if ($totalPages < 1) {
            $totalPages = 1;
        }
        if ($page > $totalPages) {
            $page = $totalPages;
        }

        $offset = ($page - 1) * $perPage;

        $rows = $builder
            ->orderBy('r_idx', 'DESC')
            ->get($perPage, $offset)
            ->getResultArray();

        return view('sub/news', [
            'rows' => $rows,
            'pg' => $page,
            'nPage' => $totalPages,
            'g_list_rows' => $perPage,
            'cate' => $cate,
            'keyword' => $keyword,
        ]);
    }

    public function view(): string
    {
        $request = service('request');
        $idx = (int) ($request->getGet('idx') ?? 0);

        if ($idx <= 0) {
            return view('sub/coming_soon', [
                'legacyPath' => 'news/news_list_view?idx=' . $idx,
            ]);
        }

        $db = db_connect();

        $db->table('jk_notice')
            ->set('r_hit', 'r_hit+1', false)
            ->where('r_idx', $idx)
            ->update();

        $row = $db->table('jk_notice')->where('r_idx', $idx)->get()->getRowArray();
        if (!$row) {
            return view('sub/coming_soon', [
                'legacyPath' => 'news/news_list_view?idx=' . $idx,
            ]);
        }

        $prevRow = $db->table('jk_notice')
            ->select('r_idx')
            ->where('r_idx <', $idx)
            ->orderBy('r_idx', 'DESC')
            ->limit(1)
            ->get()
            ->getRowArray();

        $nextRow = $db->table('jk_notice')
            ->select('r_idx')
            ->where('r_idx >', $idx)
            ->orderBy('r_idx', 'ASC')
            ->limit(1)
            ->get()
            ->getRowArray();

        return view('sub/news_view', [
            'row' => $row,
            'idx' => $idx,
            'prev_idx' => isset($prevRow['r_idx']) ? (int) $prevRow['r_idx'] : 0,
            'next_idx' => isset($nextRow['r_idx']) ? (int) $nextRow['r_idx'] : 0,
        ]);
    }

    public function share(): string
    {
        return view('sub/coming_soon', [
            'legacyPath' => 'news/share_news.php',
        ]);
    }

    public function legacy(string $slug): string
    {
        $slug = basename($slug);

        if ($slug === 'news_list.php' || $slug === 'news_list01.php' || $slug === 'news_list_2018_05_11.php') {
            return $this->index();
        }

        if ($slug === 'news_list_view.php' || $slug === 'news_list_view_2018.01.23.php') {
            return $this->view();
        }

        if ($slug === 'share_news.php') {
            return $this->share();
        }

        return view('sub/coming_soon', [
            'legacyPath' => 'news/' . $slug,
        ]);
    }
}
