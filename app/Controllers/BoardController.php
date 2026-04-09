<?php

namespace App\Controllers;

use App\Libraries\JkBbs;
use App\Libraries\Lib;

use CodeIgniter\Controller;
use Config\Database;


class BoardController extends BaseController
{
    private $bbsConfigModel;
    private $bbsModel;
    private $bbsCategoryModel;
    private $codeModel;
    private $ProductModel;
    private $bbsCommentModel;
    private $clinicModel;
    private $categoryModel;
    private $uploadPath = ROOTPATH . "public/data/bbs/";
    private $lang;
    private $bbsReviewModel;

    public function __construct()
    {
        $this->bbsConfigModel = model("BbsConfigModel");
        $this->bbsModel = model("Bbs");
        $this->bbsCategoryModel = model("BbsCategoryModel");
        $this->codeModel = model("Code");
        $this->ProductModel = model("ProductModel");
        $this->bbsCommentModel = model("BbsCommentModel");
        $this->clinicModel = model("Clinic");
        $this->categoryModel = model("CategoryModel");
        $this->bbsReviewModel = model("BbsReviewModel");
        $this->lang = service("request")->getLocale();
        error_reporting(1);
    }

    public function listNew($term, $reg_date1)
    {
        $sub_date = date("Y-m-d H:i:s", mktime(date('H') - $term, date('i'), date('s'), date('m'), date('d'), date('Y')));

        if ($reg_date1 < $sub_date) {
            $show = 1;
        } else {
            $show = 0;
        }

        return $show;
    }

    public function index()
    {
        $code = $this->request->getGet('code');
        $scategory = $this->request->getGet('scategory');
        $search_mode = $this->request->getGet('search_mode');
        $search_word = $this->request->getGet('search_word');
        $g_list_rows = 10;
        $whereArr = [
            'search_word' => $search_word,
            'search_mode' => $search_mode,
            'category' => $scategory,
            'lang' => $this->lang
        ];

        $builder = $this->bbsModel->List($code, $whereArr);

        // Get total count
        $nTotalCount = $builder->countAllResults(false);
    
        // Fetch paginated data
        $perPage = 15; // Number of rows per page
        $currentPage = $this->request->getVar('pg') ?? 1;
        $offset = ($currentPage - 1) * $perPage;
    
        $builder->limit($perPage, $offset);
        $promotions = $builder->get()->getResultArray();

        $codeInfo = $this->bbsConfigModel->where("board_code", $code)->first();

        $data = [
            'code' => $code,
            'scategory' => $scategory,
            'search_mode' => $search_mode,
            'search_word' => $search_word,
            'nTotalCount' => $nTotalCount,
            'g_list_rows' => $g_list_rows,
            'rows' => $promotions,
            'codeInfo' => $codeInfo,
            'categories' => $this->bbsCategoryModel->getCategoriesByCodeAndStatus($code)
        ];

        // Load the view with the data
        return view('admin/_board/list', $data);
    }

    public function board_write($bbs_idx = null)
    {
        $data = $this->request->getVar();

        $locale = getLocale();

        if ($bbs_idx) {
            $data['bbs_idx'] = $bbs_idx;
            $info = $this->bbsModel->View($bbs_idx);
            $data['info'] = $info;
            $data['list_comment'] = $this->bbsCommentModel->getCommentsWithMemberDetails($bbs_idx, $data['code'], private_key());
            $data['list_code3'] = $this->codeModel->getByParentAndDepth($info['product_code_1'], '3')->getResultArray();
            $info['list_code4'] = $this->codeModel->getByParentAndDepth($info['product_code_2'], '4')->getResultArray();
        }

        $data['config'] = $this->bbsConfigModel->where("board_code", $data['code'])->first();
        $data['list_category'] = $this->bbsCategoryModel->getCategoriesByCodeAndStatus($data['code']);
        $data['list_clinic'] = $this->clinicModel->getClinicAdmin("", 0, 1000, $locale);
        $data['list_code'] = $this->codeModel->getCodesByGubunDepthAndStatus('tour', '2');
        $data['list_code2'] = $this->codeModel->getCodesByGubunDepthAndStatusExclude('tour', '2', ['1308', '1309']);
        $data['categoryCodes'] =   $this->categoryModel->getCategoryDataAdmin("", 0, 1000);
        $data['reviews'] = $this->bbsReviewModel->getReviewsList(['code' => 'event', 'bbs_idx' => $bbs_idx], 1, 100000);
        $data['lang'] = $locale;
        return view('admin/_board/write', $data);
    }

    public function write_ok($bbs_idx = null)
    {
        $uploadPath = $this->uploadPath;

        $files = $this->request->getFiles();

        $data = $this->request->getPost();

        // for ($i = 1; $i <= 6; $i++) {
        //     if ($this->request->getPost("del_$i") == "Y") {
        //         $data["ufile$i"] = "";
        //         $data["rfile$i"] = "";

        //     } elseif ($files["ufile$i"]) {
        //         $file = $files["ufile$i"];

        //         if ($file->isValid() && !$file->hasMoved()) {
        //             $fileName = $file->getClientName();
        //             $data["rfile$i"] = $fileName;

        //             if (no_file_ext($fileName) == "Y") {
        //                 $microtime = microtime(true);
        //                 $timestamp = sprintf('%03d', ($microtime - floor($microtime)) * 1000);
        //                 $date = date('YmdHis');
        //                 $ext = explode(".", strtolower($fileName));
        //                 $newName = $date . $timestamp . '.' . $ext[1];
        //                 $data["ufile$i"] = $newName;
        //                 write_log("$i - $uploadPath - $newName"); 
        //                 $file->move($uploadPath, $newName);

        //             }
        //         }
        //     }
        // }

        for ($i = 1; $i <= 6; $i++) {
            $ufile = "ufile$i";
            $rfile = "rfile$i";

            $oldFileName = "";
            if (!empty($bbs_idx)) {
                $oldData = $this->bbsModel->find($bbs_idx);
                $oldFileName = $oldData[$ufile] ?? "";
            }

            if ($this->request->getPost("del_$ufile") == "Y") {
                if (!empty($oldFileName)) {
                    $oldPath = $uploadPath . '/' . $oldFileName;
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                $data[$ufile] = "";
                $data[$rfile] = "";
            }

            elseif (!empty($files[$ufile])) {
                $file = $files[$ufile];

                if ($file->isValid() && !$file->hasMoved()) {
                    $fileName = $file->getClientName();
                    $data[$rfile] = $fileName;

                    $microtime = microtime(true);
                    $timestamp = sprintf('%03d', ($microtime - floor($microtime)) * 1000);
                    $date = date('YmdHis');
                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                    $newName = $date . $timestamp . '.' . $ext;

                    $data[$ufile] = $newName;
                    write_log("$i - $uploadPath - $newName");
                    $file->move($uploadPath, $newName);

                    if (!empty($oldFileName) && file_exists($uploadPath . '/' . $oldFileName)) {
                        unlink($uploadPath . '/' . $oldFileName);
                    }
                }
            }
        }


        if ($bbs_idx) {
            $data['m_date'] = date("Y-m-d H:i:s");
            $this->bbsModel->update($bbs_idx, $data);
            $msg = "수정완료";
        } else {
            $data['r_date'] = date("Y-m-d H:i:s");
            $data['lang'] = service('request')->getLocale();
            $this->bbsModel->insert($data);
            $msg = "등록완료";
        }

        return $this->response->setJSON([
            "message" => $msg
        ]);

    }

    public function bbs_change() {
        $idx = $this->request->getPost('idx');
        $onum = $this->request->getPost('onum');

        foreach ($idx as $key => $value) {
            $this->bbsModel->where('bbs_idx', $value)->set('onum', $onum[$key])->update();
        }

        return $this->response->setJSON([
            "message" => "순위 변경 성공",
            "status" => "OK"
        ]);

    }

    public function view($bbs_idx)
    {

        $info = $this->bbsModel->View($bbs_idx);

        $data = [
            'info' => $info,
        ];
        return view('admin/_board/view', $data);
    }

    public function bbs_del() {

    }
}
