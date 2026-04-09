<?php

namespace App\Controllers;

use Config\CustomConstants as ConfigCustomConstants;

class CodeController extends BaseController
{
    private $CodeModel;
    private $productModel;
    private $Bbs;
    private $db;
    private $ProductAirModel;
    private $FlightModel;
    private $codeContents;
    private $countryModel;

    public function __construct()
    {
        $this->db = db_connect();
        $this->CodeModel = model('Code');
        $this->productModel = model('ProductModel');
        $this->ProductAirModel = model('ProductAirModel');
        $this->Bbs = model('Bbs');
        $this->FlightModel = model('FlightModel');
        $this->codeContents = model('CodeContents');
        $this->countryModel = model('Country');
        helper('my_helper');
        helper('alert_helper');
    }

    public function list_admin()
    {
        $g_list_rows = 100;
        $s_parent_code_no = $this->request->getVar('s_parent_code_no');
        $pg = $this->request->getVar('pg');

        $code_name = $this->CodeModel->getCodeName($s_parent_code_no);

        $nTotalCount = $this->CodeModel->getTotalCount($s_parent_code_no);
        $nPage = ceil($nTotalCount / $g_list_rows);
        if (empty($pg))
            $pg = 1;
        $nFrom = ($pg - 1) * $g_list_rows;

        $result = $this->CodeModel->getPagedData($s_parent_code_no, $nFrom, $g_list_rows);
        $num = $nTotalCount - $nFrom;

        $grandParentCode = $this->CodeModel->getParentCodeNoByCodeNo($s_parent_code_no)['code_no'] ?? '';

        return view('AdmMaster/_code/list', [
            'result' => $result,
            'num' => $num,
            's_parent_code_no' => $s_parent_code_no,
            'grandParentCode' => $grandParentCode,
            'nPage' => $nPage,
            'pg' => $pg,
            'nTotalCount' => $nTotalCount,
            'currentUri' => $this->request->getUri()->getPath(),
            'g_list_rows' => $g_list_rows,
            'code_name' => $code_name
        ]);
    }

    public function write_admin()
    {
        $code_idx = $this->request->getVar('code_idx') ?? 0;
        $s_parent_code_no = $this->request->getVar('s_parent_code_no') ?? '0';

        $titleStr = "생성";
        $parent_code_no = empty($s_parent_code_no) ? "0" : $s_parent_code_no;

        if ($code_idx) {
            // 수정 모드
            $row = $this->CodeModel->getCodeByIdx($code_idx);
            
            if (!$row) {
                return redirect()->to('AdmMaster/_code')->with('error', '존재하지 않는 코드입니다.');
            }

            $titleStr = "수정";
            $depth = $this->CodeModel->countByParentCodeNo($row['code_no']);
            $code_gubun = $row['code_gubun'];
        } else {
            // 신규 등록 모드
            if ($parent_code_no == '0') {
                // Root level: code_gubun 직접 입력
                $depth = 1;
                $code_gubun = '';
            } else {
                // 하위 level: parent의 code_gubun 상속
                $parentRow = $this->CodeModel->getDepthAndCodeGubunByNo($parent_code_no);
                $depth = ($parentRow['depth'] ?? 0) + 1;
                $code_gubun = $parentRow['code_gubun'] ?? ''; // ★ Parent에서 가져옴
            }

            $maxCodeNoRow = $this->CodeModel->getMaxCodeNo($parent_code_no, $s_parent_code_no);
            $code_no = $maxCodeNoRow['code_no'] ?? '';

            // 예약된 코드 처리
            if ($code_no == "1308") {
                $maxCodeNoRow = $this->CodeModel->getMaxCodeNoWithReserved($parent_code_no, $s_parent_code_no);
                $code_no = $maxCodeNoRow['code_no'];
            }

            $row = [
                'code_no' => $code_no,
                'code_name' => '',
                'code_name_en' => '',
                'status' => 'Y',
                'onum' => 0,
                'bestYN' => 'N',
                'ufile1' => '',
                'rfile1' => '',
                'ufile2' => '',
                'rfile2' => '',
                'color' => '',
                'types' => '',
                'link' => '',
                'code_memo' => '',
                'code_gubun' => $code_gubun, // ★ Parent에서 상속받은 값
            ];
        }

        return view("AdmMaster/_code/write", [
            "row" => $row,
            "s_parent_code_no" => $s_parent_code_no,
            "parent_code_no" => $parent_code_no,
            "depth" => $depth,
            "code_gubun" => $code_gubun,
            "titleStr" => $titleStr,
            "code_idx" => $code_idx,
        ]);
    }

    public function write_ok()
    {
        $code_idx = $this->request->getPost('code_idx');
        $parent_code_no = $this->request->getPost('parent_code_no');
        
        if ($parent_code_no == '0') {
            $code_gubun = $this->request->getPost('code_gubun');
        } else {
            $parentRow = $this->CodeModel->getDepthAndCodeGubunByNo($parent_code_no);
            $code_gubun = $parentRow['code_gubun'] ?? '';
        }
        
        $code_no = $this->request->getPost('code_no');
        $code_name = $this->request->getPost('code_name');
        $code_name_en = $this->request->getPost('code_name_en') ?? '';
        $depth = $this->request->getPost('depth');
        $status = $this->request->getPost('status');
        $onum = $this->request->getPost('onum');

        $file1 = $this->request->getFile('ufile1');
        $file2 = $this->request->getFile('ufile2');

        $upload = FCPATH . 'data/code/';

        if (!is_dir($upload)) {
            mkdir($upload, 0755, true);
        }

        if ($code_idx) {
            $data = [
                'code_name' => $code_name,
                'code_name_en' => $code_name_en,
                'status' => $status,
                'onum' => $onum,
            ];
            $this->CodeModel->update($code_idx, $data);
        } else {
            if ($parent_code_no == "0") {
                $existingCode = $this->CodeModel->where('code_gubun', $code_gubun)->first();
                if ($existingCode) {
                    return redirect()->back()->with('error', '중복된 코드구분입니다.');
                }
            }

            $data = [
                'code_gubun' => $code_gubun, 
                'code_no' => $code_no,
                'code_name' => $code_name,
                'code_name_en' => $code_name_en,
                'parent_code_no' => $parent_code_no,
                'depth' => $depth,
                'status' => $status,
                'onum' => $onum,
            ];
            $this->CodeModel->insert($data);
            $code_idx = $this->CodeModel->insertID();
        }


        return redirect()->to('AdmMaster/_code/list?s_parent_code_no=' . $parent_code_no)
                        ->with('success', '저장되었습니다.');
    }

    public function del()
    {
       $code_idx = $this->request->getPost('code_idx');

        if (empty($code_idx)) {
            echo "FAIL";
            return;
        }

        try {
            $hasChildren = $this->CodeModel->where('parent_code_no', $code_idx)->countAllResults();
            
            if ($hasChildren > 0) {
                echo "하위 코드가 존재하여 삭제할 수 없습니다.";
                return;
            }

            $this->CodeModel->delete($code_idx);
            echo "OK";
        } catch (\Exception $e) {
            echo "FAIL";
        }
    }

    public function delete_flight()
    {
        $f_idx = $this->request->getPost('idx');
        try {
            $this->FlightModel->deleteData($f_idx);
            $message = '삭제완료';
        } catch (\Throwable $th) {
            $message = '삭제오류: ' . $th->getMessage();
        }
        return $this->response->setJSON(['message' => $message]);
    }

    public function change_ajax()
    {
        $code_idx = $this->request->getPost('code_idx');
        $onum = $this->request->getPost('onum');
        $tot = count($code_idx);
        for ($j = 0; $j < $tot; $j++) {
            $this->CodeModel->update($code_idx[$j], ['onum' => $onum[$j]]);
        }
        return 'OK';
    }

    public function ajaxGet()
    {
        $depth = $this->request->getVar('depth');
        $parent_code_no = $this->request->getVar('parent_code_no');
        $results = $this->CodeModel->getByParentCode($parent_code_no)->getResultArray();
        return $this->response->setJSON($results);
    }

    public function get_tree_code()
    {
        $depth = $this->request->getVar('depth');
        $parent_code_no = $this->request->getVar('parent_code_no');
        $results = $this->CodeModel->getByParentCode($parent_code_no)->getResultArray();

        $code_child_list = $this->CodeModel->getByParentCode($results[0]['code_no'])->getResultArray();
        return $this->response->setJSON([
            'code_list' => $results,
            'code_child_list' => $code_child_list
        ]);
    }

    public function get_sub_code()
    {
        $depth = $this->request->getVar('depth');
        $parent_code_no = $this->request->getVar('code');
        $results = $this->CodeModel->getByParentAndDepth($parent_code_no, $depth)->getResultArray();
        $cnt = count($results);
        $data = [
            'results' => $results,
            'cnt' => $cnt
        ];
        return $this->response->setJSON($data);
    }

    public function get_list_product()
    {
        $code_no = $this->request->getVar('product_code');
        $field = $this->request->getVar('field');
        $results = $this->productModel->getAllProductsBySubCode($field, $code_no);
        $cnt = count($results);
        $data = [
            'results' => $results,
            'cnt' => $cnt
        ];
        return $this->response->setJSON($data);
    }

    public function get_child_code()
    {
        $parent_code_no = $this->request->getVar('code');
        $results = $this->CodeModel->getByParentCode($parent_code_no)->getResultArray();
        return $this->response->setJSON($results);
    }

    public function add_contents()
    {
        $code_idx = $this->request->getPost('code_idx');
        $data['code_idx'] = $code_idx;
        $data['r_date'] = date('Y-m-d H:i:s');

        $idx = $this->codeContents->insertData($data);

        if (!empty($idx)) {
            return $this->response->setJSON([
                'result' => true
            ]);
        } else {
            return $this->response->setJSON([
                'result' => false,
                'message' => '삭제오류'
            ]);
        }
    }

    public function del_contents()
    {
        $idx = $this->request->getPost('idx');

        try {
            $this->codeContents->delete($idx);
            $message = '삭제완료';
        } catch (\Throwable $th) {
            $message = '삭제오류: ' . $th->getMessage();
        }

        return $this->response->setJSON(['message' => $message]);
    }

    public function country_list_admin()
    {
        $g_list_rows = 10;  // Rows per page
        $pg = $this->request->getVar('pg') ?? 1;  // Current page (default to 1 if not provided)
        $scategory = $this->request->getVar('scategory');
        $search_word = $this->request->getVar('search_word');
        $search_mode = $this->request->getVar('search_mode');
        $strSql = '';
        if ($search_mode && $search_word) {
            $strSql = " AND REPLACE($search_mode, '-', '') LIKE '%" . str_replace('-', '', $search_word) . "%'";
        }

        $nTotalCount = $this->countryModel->getCountryTotalCount($strSql);

        // Pagination
        $nPage = ceil($nTotalCount / $g_list_rows);
        $nFrom = ($pg - 1) * $g_list_rows;

        // Pass data to the view
        $data['countryData'] = $this->countryModel->getCountryDataAdmin($strSql, $nFrom, $g_list_rows);
        $data['nTotalCount'] = $nTotalCount;
        $data['nPage'] = $nPage;
        $data['pg'] = $pg;
        $data['num'] = $nTotalCount - $nFrom;

        return view('AdmMaster/_code/country_list', $data);
    }

    public function country_write()
    {
        $code_idx = $this->request->getVar('code_idx');

        $s_parent_code_no = $this->request->getVar('s_parent_code_no');

        $data = $this->countryModel->where('code_idx', $code_idx)->first() ?? [];

        $data['s_parent_code_no'] = $s_parent_code_no;

        $data['titleStr'] = $data['code_idx'] ? '수정' : '생성';

        if (!$data['code_idx']) {
            $data['code_no'] = $this->countryModel->getNextCodeNo($s_parent_code_no);
            $data['onum'] = 0;
        }

        return view('AdmMaster/_code/country_write', $data);
    }

    public function country_write_ok()
    {
        $data = $this->request->getPost();

        if ($data['code_idx']) {
            $code_idx = $data['code_idx'];
            unset($data['code_idx']);
            $this->countryModel->update($code_idx, $data);
            return $this->response->setBody("<script>alert('수정 완료');parent.location.reload();</script>");
        } else {
            unset($data['code_idx']);
            $this->countryModel->insert($data);
            return $this->response->setBody("<script>alert('등록 완료');parent.location.href='/AdmMaster/_code/country_list';</script>");
        }
    }

    public function country_change()
    {
        $data = $this->request->getPost();

        $code_idx = $data['code_idx'];
        $onum = $data['onum'];

        foreach ($code_idx as $key => $value) {
            $this->countryModel->where('code_idx', $value)->set('onum', $onum[$key])->update();
        }

        return $this->response->setJSON([
            'status' => 'OK',
            'message' => '순위 변경 성공'
        ]);
    }

    public function country_del()
    {
        $code_idx = $this->request->getRawInput()['code_idx'];

        foreach ($code_idx as $key => $value) {
            $this->countryModel->where('code_idx', $value)->delete();
        }

        return $this->response->setJSON([
            'result' => 'OK',
            'message' => '삭제 완료'
        ]);
    }
}
