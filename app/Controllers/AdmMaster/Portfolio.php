<?php

namespace App\Controllers\AdmMaster;

use App\Controllers\BaseController;
use App\Models\Code;
use App\Models\PortfolioModel;

class Portfolio extends BaseController
{
    public function __construct()
    {
        ini_set('memory_limit', '512M');
        $this->codeModel = new Code();
        $this->portfolioModel = new PortfolioModel();
        helper('image');
    }

    public function index()
    {
        $model = new PortfolioModel();

        $selectedTypes = $this->request->getGet('r_type') ?? [];
        if (!is_array($selectedTypes)) {
            $selectedTypes = [$selectedTypes];
        }
        $selectedUsed = $this->request->getGet('r_used');
        $mainUsed = $this->request->getGet('main_exposure');
        $searchTitle = $this->request->getGet('search_title');

        if (!empty($selectedTypes)) {
            $model->whereIn('r_type', $selectedTypes);
        }

        if ($selectedUsed !== null && $selectedUsed !== '') {
            $model->where('r_used', $selectedUsed);
        }

        if ($mainUsed !== null && $mainUsed !== '') {
            $model->where('main_exposure', $mainUsed);
        }

        if ($searchTitle) {
            $model->like('r_title', $searchTitle);
        }

        $perPage = 50;

        $total = $model->countAllResults(false);

        $list = $model
            ->orderBy('r_order', 'DESC')
            ->orderBy('r_idx', 'DESC')
            ->paginate($perPage, 'portfolio');

        $pager = $model->pager;

        $typeList = $this->getPortfolioTypes();

        $typeMap = array_column($typeList, 'code_name', 'code_no');

        return view('AdmMaster/portfolio/index', [
            'list' => $list,
            'pager' => $pager,
            'total' => $total,
            'r_type' => $selectedTypes,
            'r_used' => $selectedUsed,
            'main_exposure' => $mainUsed,
            'search_title' => $searchTitle,
            'typeList' => $typeList,
            'typeMap' => $typeMap,
        ]);
    }

    public function changeOrder()
    {
        $idxArray = $this->request->getPost('r_idx');
        $orderArray = $this->request->getPost('r_order');

        if (!$idxArray || !$orderArray) {
            return $this->response->setJSON([
                'success' => false,
                'message' => '데이터가 없습니다.'
            ]);
        }

        $db = db_connect();
        $updated = 0;

        foreach ($idxArray as $key => $idx) {
            if (isset($orderArray[$key])) {
                $order = (int)$orderArray[$key];

                $db->table('jk_goods')
                    ->where('r_idx', (int)$idx)
                    ->update(['r_order' => $order]);

                $updated++;
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => $updated . '개 항목의 순위가 변경되었습니다.',
            'updated' => $updated
        ]);
    }

    public function toggle()
    {
        $idx = (int)$this->request->getPost('idx');
        $type = $this->request->getPost('type');

        $db = db_connect();
        $row = $db->table('jk_goods')->where('r_idx', $idx)->get()->getRowArray();

        if (!$row) {
            return $this->response->setJSON(['success' => false]);
        }

        if ($type == 'main_exposure') {
            $new = $row['main_exposure'] === 'Y' ? 'N' : 'Y';

            $db->table('jk_goods')->where('r_idx', $idx)->update([
                'main_exposure' => $new
            ]);
        } else {
            $new = $row['r_used'] === 'Y' ? 'N' : 'Y';

            $db->table('jk_goods')->where('r_idx', $idx)->update([
                'r_used' => $new
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'status' => $new
        ]);
    }

    public function create()
    {
        $typeList = $this->getPortfolioTypes();
        return view('AdmMaster/portfolio/create', [
            'typeList' => $typeList,
        ]);
    }

    public function edit(int $id)
    {
        $row = $this->portfolioModel->find($id);

        if (!$row) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $typeList = $this->getPortfolioTypes();

        return view('AdmMaster/portfolio/edit', [
            'row' => $row,
            'typeList' => $typeList,
        ]);
    }

    private function getPortfolioTypes()
    {
        return $this->codeModel->getListByParentCode('1');
    }

    public function store()
    {
        $model = new PortfolioModel();

        $main_exposure = $this->request->getPost('main_exposure') ?? 'N';

        $data = [
            'r_title' => $this->request->getPost('r_title'),
            'r_type' => $this->request->getPost('r_type'),
            'r_output' => $this->request->getPost('r_output'),
            'r_url' => $this->request->getPost('r_url'),
            'r_description' => $this->request->getPost('r_description'),
            'r_order' => $this->request->getPost('r_order') ?? 100,
            'r_used' => $this->request->getPost('r_used') === 'Y' ? 'Y' : 'N',
            'r_regdate' => date('Y-m-d H:i:s'),
            'browser_title' => $this->request->getPost('browser_title'),
            'meta_keyword' => $this->request->getPost('meta_keyword'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_des' => $this->request->getPost('meta_des'),
            'main_exposure' => $main_exposure,
        ];

        if (empty($data['r_title']) || empty($data['r_type'])) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '필수 항목을 입력해주세요.');
        }

        $uploadPath = ROOTPATH . 'public/uploads/file/';

        $file = $this->request->getFile('r_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $result = simple_upload_and_convert_to_webp(
                $file,
                $uploadPath,
                85,
                10000
            );

            if ($result['success']) {
                $data['r_file'] = $result['filename'];

                if ($result['resized']) {
                    session()->setFlashdata('warning', '이미지가 10000px로 자동 축소되었습니다.');
                }
            } else {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', '이미지 업로드에 실패했습니다: ' . $result['error']);
            }
        }

        $file2 = $this->request->getFile('r_file2');
        if ($file2 && $file2->isValid() && !$file2->hasMoved()) {
            $result2 = simple_upload_and_convert_to_webp(
                $file2,
                $uploadPath,
                90,
                15000
            );

            if ($result2['success']) {
                $data['r_file2'] = $result2['filename'];
            }
        }

        $model->insert($data);

        return redirect()
            ->to(site_url('AdmMaster/portfolio'))
            ->with('success', '정상적으로 등록되었습니다.');
    }

    public function update(int $id)
    {
        $model = new PortfolioModel();

        $main_exposure = $this->request->getPost('main_exposure') ?? 'N';

        $data = [
            'r_title' => $this->request->getPost('r_title'),
            'r_type' => $this->request->getPost('r_type'),
            'r_output' => $this->request->getPost('r_output'),
            'r_url' => $this->request->getPost('r_url'),
            'r_description' => $this->request->getPost('r_description'),
            'r_order' => $this->request->getPost('r_order'),
            'browser_title' => $this->request->getPost('browser_title'),
            'meta_keyword' => $this->request->getPost('meta_keyword'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_des' => $this->request->getPost('meta_des'),
            'r_used' => $this->request->getPost('r_used') === 'Y' ? 'Y' : 'N',
            'main_exposure' => $main_exposure,
        ];

        $uploadPath = ROOTPATH . 'public/uploads/file/';

         $oldRow = $model->find($id);
        if ($this->request->getPost('delete_r_file') == '1') {
            if (!empty($oldRow['r_file'])) {
                $oldFile = $uploadPath . $oldRow['r_file'];
                if (file_exists($oldFile)) {
                    @unlink($oldFile);
                }
            }
            $data['r_file'] = null;
        }
        $file = $this->request->getFile('r_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $oldRow = $model->find($id);
            if (!empty($oldRow['r_file'])) {
                $oldFile = $uploadPath . $oldRow['r_file'];
                if (file_exists($oldFile)) {
                    @unlink($oldFile);
                }
            }

            $result = simple_upload_and_convert_to_webp(
                $file,
                $uploadPath,
                90,
                15000
            );

            if ($result['success']) {
                $data['r_file'] = $result['filename'];

                if ($result['resized']) {
                    session()->setFlashdata('warning', '이미지가 10000px로 자동 축소되었습니다.');
                }
            }
        }

         if ($this->request->getPost('delete_r_file2') == '1') {
            if (!empty($oldRow['r_file2'])) {
                $oldFile2 = $uploadPath . $oldRow['r_file2'];
                if (file_exists($oldFile2)) {
                    @unlink($oldFile2);
                }
            }
            $data['r_file2'] = null;
        }
        $file2 = $this->request->getFile('r_file2');
        if ($file2 && $file2->isValid() && !$file2->hasMoved()) {
            $oldRow = $model->find($id);
            if (!empty($oldRow['r_file2'])) {
                $oldFile2 = $uploadPath . $oldRow['r_file2'];
                if (file_exists($oldFile2)) {
                    @unlink($oldFile2);
                }
            }

            $result2 = simple_upload_and_convert_to_webp(
                $file2,
                $uploadPath,
                85,
                10000
            );

            if ($result2['success']) {
                $data['r_file2'] = $result2['filename'];
            }
        }

        $model->update($id, $data);

        return redirect()
            ->to(site_url('AdmMaster/portfolio'))
            ->with('success', '정상적으로 수정되었습니다.');
    }

    public function delete()
    {
        $idx = (int)$this->request->getPost('idx');

        if (!$idx) {
            return $this->response->setJSON(['success' => false]);
        }

        $model = new PortfolioModel();
        $row = $model->find($idx);

        if (!$row) {
            return $this->response->setJSON(['success' => false]);
        }

        $model->delete($idx);

        return $this->response->setJSON(['success' => true]);
    }

    public function bulkDelete()
    {
        $json = $this->request->getJSON();
        $ids = $json->ids ?? [];

        if (empty($ids)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => '삭제할 항목이 없습니다.'
            ]);
        }

        $model = new PortfolioModel();
        $uploadPath = ROOTPATH . 'public/uploads/file/';
        $deleted = 0;

        foreach ($ids as $id) {
            $row = $model->find($id);

            if ($row) {
                if (!empty($row['r_file'])) {
                    $filePath = $uploadPath . $row['r_file'];
                    if (file_exists($filePath)) {
                        @unlink($filePath);
                    }
                }

                if (!empty($row['r_file2'])) {
                    $filePath2 = $uploadPath . $row['r_file2'];
                    if (file_exists($filePath2)) {
                        @unlink($filePath2);
                    }
                }

                $model->delete($id);
                $deleted++;
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => $deleted . '개 항목이 삭제되었습니다.',
            'deleted' => $deleted
        ]);
    }
}