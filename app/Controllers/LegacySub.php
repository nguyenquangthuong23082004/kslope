<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class LegacySub extends BaseController
{
    public function center(string $page = 'history')
    {
        return $this->renderLegacySubView('center', $page);
    }

    public function education(string $page = 'notice')
    {
        return $this->renderLegacySubView('education', $page);
    }

    public function reservation(string $page = 'education_list')
    {
        return $this->renderLegacySubView('reservation', $page);
    }

    private function renderLegacySubView(string $group, string $page)
    {
        $page = trim($page);
        $page = str_replace(['..', '\\', '/'], '', $page);

        if ($page === '') {
            $page = 'index';
        }

        $view = "sub/{$group}/{$page}";

        if (!is_file(APPPATH . 'Views/' . $view . '.php')) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setBody('404');
        }

        return view($view);
    }
}
