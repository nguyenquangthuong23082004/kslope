<?php

namespace App\Controllers\Ajax;

use App\Controllers\BaseController;
use App\Models\Code;

class PortfolioAjax extends BaseController
{
    protected $codeModel;

    public function __construct()
    {
        $this->codeModel = new Code();
    }

    private function getPortfolioTypeCodes(): array
    {
        $types = $this->codeModel->getListByParentCode('1');
        return array_column($types, 'code_no');
    }

    private function fetchPortfolioRows(string $schType, int $rOrder, ?array $allowedTypes = null, int $limit, $type = null): array
    {
        $schType = $schType !== '' ? $schType : 'ALL';
        $userIp = $this->request->getIPAddress();

        if ($allowedTypes === null) {
            $allowedTypes = $this->getPortfolioTypeCodes();
        }

        $db = db_connect();
        $builder = $db->table('jk_goods a');

        $builder->select([
            'a.r_idx', 'a.r_title', 'a.r_description', 'a.r_keywords',
            'a.r_file', 'a.r_file_ori', 'a.r_used', 'a.r_type',
            'a.r_client', 'a.r_output', 'a.r_launching', 'a.r_url', 'a.r_content',
            'a.r_file2', 'a.r_file2_ori', 'a.r_file3', 'a.r_file3_ori',
            'a.r_file4', 'a.r_file4_ori', 'a.r_file5', 'a.r_file5_ori',
            'a.r_file6', 'a.r_file6_ori', 'a.shopcode', 'a.r_type2',
            'a.r_regdate', 'a.r_order', 'a.r_order2',
            'b.r_idx AS fa_idx'
        ]);

        $builder->join(
            'jk_favorite b',
            'a.r_idx = b.r_portfolio_idx AND b.r_ip = ' . $db->escape($userIp),
            'left'
        );

        if ($type == 'main') $builder->where('a.main_exposure', 'Y');

        $builder->where('a.r_used', 'Y');
        $builder->where('a.shopcode', '');

        if ($schType === 'ALL') {
            if (!empty($allowedTypes)) {
                $builder->whereIn('a.r_type', $allowedTypes);
            }
        } else {
            $builder->where('a.r_type', $schType);
        }

        if ($rOrder > 0) {
            $builder->where('a.r_order <', $rOrder);
        }

        $builder->orderBy('a.r_order', 'DESC');
        $builder->orderBy('a.r_idx', 'DESC');
        $builder->limit($limit);

        return $builder->get()->getResultArray();
    }

    private function renderPortfolioListItems(array $rows, string $schType, int $categCode): string
    {
        $out = '';
        foreach ($rows as $row) {
            $chkType = '';
            $portfolioIdx = (int)($row['r_idx'] ?? 0);
            $isFav = !empty($row['fa_idx']);

            $viewUrl = base_url('portfolio/view')
                . '?idx=' . $portfolioIdx
                . '&categ_code=' . $categCode
                . '&lType=' . rawurlencode((string)$schType);

            $snsUrl = base_url('portfolio/view') . '?idx=' . $portfolioIdx;
            $imgUrl = base_url('uploads/file/' . ($row['r_file'] ?? ''));

            $out .= '<li class="list-content ' . $chkType . ' ajax" r_order="' . esc($row['r_order']) . '">';
            $out .= '<a href="' . esc($viewUrl) . '">';
            $out .= '<div class="img_box">';
            $out .= '<img src="' . esc($imgUrl) . '" alt="" >';
            $out .= '</div>';
            $out .= '<div class="text">';
            $out .= '<div class="txt_box">';
            $out .= '<b class="title">' . esc($row['r_title'] ?? '') . '</b>';
            $out .= '<p class="type">' . esc($row['r_output'] ?? '') . '</p>';
            $out .= '</div>';
            $out .= '<div class="social_box">';
            $out .= '<ul class="social_link">';

            if (!empty($row['r_url'])) {
                $out .= '<li>';
                $out .= '<a href="' . esc($row['r_url']) . '" target="_blank">';
                $out .= '<img src="' . esc(base_url('assets/img/ico/Launch.png')) . '" alt="">';
                $out .= '</a>';
                $out .= '</li>';
            }

            $out .= '</ul>';
//            $out .= '<b class="favorite_add' . ($isFav ? ' active' : '') . '" fa_idx="' . esc($portfolioIdx) . '"></b>';
            $out .= '</div>';
            $out .= '</div>';
            $out .= '</a>';
            $out .= '</li>';
        }

        return $out;
    }

    public function listAdd(): string
    {
        $schType = (string)($this->request->getVar('sch_type') ?? 'ALL');
        $rOrder = $this->request->getVar('r_order');

        $rows = $this->fetchPortfolioRows($schType, 999999999, null, $rOrder);

        return $this->renderPortfolioListItems($rows, $schType, 1);
    }

    public function listAddCopy(): string
    {
        $schType = (string)($this->request->getPost('sch_type') ?? 'ALL');
        $rOrder = (int)($this->request->getPost('r_order') ?? 999999999);
        $limit = (int)($this->request->getPost('limit') ?? 6);

        $rows = $this->fetchPortfolioRows($schType, $rOrder, null, $limit, 'main');

        return $this->renderPortfolioListItems($rows, $schType, 1);
    }

    public function listAdd2(): string
    {
        $schType = (string)($this->request->getPost('sch_type') ?? 'ALL');
        $rOrder = (int)($this->request->getPost('r_order') ?? 999999999);

        $rows = $this->fetchPortfolioRows($schType, $rOrder, null, 8);

        return $this->renderPortfolioListItems($rows, $schType, 3);
    }

    public function favoriteSet(): string
    {
        $mode = (string)($this->request->getPost('mode') ?? '');
        $idx = (int)($this->request->getPost('idx') ?? 0);
        $userIp = (string)($this->request->getPost('user_ip') ?? $this->request->getIPAddress());

        if ($idx <= 0 || ($mode !== 'add' && $mode !== 'del')) {
            return '0';
        }

        $db = db_connect();

        if ($mode === 'add') {
            $db->table('jk_favorite')->insert([
                'r_ip' => $userIp,
                'r_portfolio_idx' => $idx,
                'r_regdate' => date('Y-m-d H:i:s'),
            ]);
        }

        if ($mode === 'del') {
            $db->table('jk_favorite')
                ->where('r_ip', $userIp)
                ->where('r_portfolio_idx', $idx)
                ->delete();
        }

        $num = (int)$db->table('jk_favorite')
            ->where('r_ip', $userIp)
            ->countAllResults();

        return (string)$num;
    }

    public function favoriteList(): string
    {
        $db = db_connect();
        $ip = (string)$this->request->getIPAddress();

        $favorites = $db->table('jk_favorite')
            ->select('r_portfolio_idx')
            ->where('r_ip', $ip)
            ->orderBy('r_portfolio_idx', 'ASC')
            ->get()
            ->getResultArray();

        if ($favorites === []) {
            return '0';
        }

        $out = '';
        foreach ($favorites as $fav) {
            $pid = (int)$fav['r_portfolio_idx'];
            $row = $db->table('jk_goods')->where('r_idx', $pid)->get()->getRowArray();
            if (!$row) {
                continue;
            }

            $out .= '<li>';
            $out .= '<a href="#!">';
            $out .= '<b class="delete"><img src="' . esc(base_url('assets/img/btn/close_btn.png')) . '" alt="닫기버튼" fa_idx="' . esc($pid) . '"></b>';
            $out .= '<b class="tit">' . esc($row['r_title'] ?? '') . '</b>';
            $out .= '<p>' . esc($row['r_output'] ?? '') . '</p>';
            $out .= '</a>';
            $out .= '</li>';
        }

        return $out !== '' ? $out : '0';
    }

    public function sessionSet(): string
    {
        $img = (string)($this->request->getPost('simg') ?? '');
        $url = (string)($this->request->getPost('surl') ?? '');
        $title = (string)($this->request->getPost('stitle') ?? '');
        $content = (string)($this->request->getPost('scontent') ?? '');

        $session = service('session');

        $session->set('meta_url', $url);
        $session->set('meta_title', $title);
        $session->set('meta_img', $img);
        $session->set('meta_content', $content);

        return '1';
    }
}