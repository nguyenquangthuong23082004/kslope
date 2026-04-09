<?php

namespace App\Controllers;
use CodeIgniter\I18n\Time;
class PopupController extends BaseController
{
    private $Popup;

    private $Files;
    
    private $currentTime;

    private $uploadPath = ROOTPATH . 'public/uploads/popup/';
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
        $this->Popup = model("Popup");
        $this->Files = model("Files");
    }

    public function index(): string
    {
        $data['db'] = $this->db;
        return view('inc/popup', $data);
    }

    public function list()
    {
        $data['db'] = $this->db;
        $data['pg'] = $this->request->getVar('pg');
        $data['search_word'] = $this->request->getVar("search_word");
        $data['g_list_rows'] = $this->request->getVar('g_list_rows');
        return view("AdmMaster/_popup/popup", $data);
    }

        public function detail($idx = null)
        {
            $data['db'] = $this->db;
            $data['popup'] = null; 

            if ($idx) {
                $data['idx'] = $idx;
                $data['popup'] = $this->Popup->adminSelect($idx);
            } else {
                $data['idx'] = '';
            }

            return view("AdmMaster/_popup/popup_detail", $data);
        }


    public function insert(){
        $post = $this->request->getPost();
        try {
            
            $this->db->transBegin();
            $insertId = $this->Popup->adminInsert($post);
            
            $uploadPath = $this->uploadPath;
            if(!is_dir($uploadPath)){
                mkdir($uploadPath, 0755, true);
            }

            $files = $this->request->getFiles();

            $files = $this->request->getFiles();

            if (isset($files['ufiles']) && is_array($files['ufiles'])) {
                foreach ($files['ufiles'] as $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $newName = $file->getRandomName();
                        $oldName = $file->getClientName();

                        $data_file = [
                            'popup_idx' => $insertId, // hoặc $idx
                            'code'      => 'popup',
                            'u_file'    => $newName,
                            'r_file'    => $oldName,
                            'r_date'    => date('Y-m-d H:i:s')
                        ];

                        if ($this->Files->fileInsert($data_file)) {
                            $file->move($uploadPath, $newName);
                        }
                    }
                }
            }

            
            $this->db->transCommit();
            $resultArr['result'] = true;
            $resultArr['message'] = "{$insertId}등록했습니다.";
        } catch (Exception $err) {
            $this->db->transRollback();
            $resultArr['result'] = false;
            $resultArr['message'] = $err->getMessage();
        } finally {
            return $this->response->setJSON($resultArr);
        }
    }

    public function update($idx = null){
        $post = $this->request->getPost();
        try {

            $this->db->transBegin();
            $updateResult = $this->Popup->adminUpdate($idx, $post);
            if(!$updateResult){
                throw new Exception("수정 과정 중 오류가 발생했습니다.");
            }
            $uploadPath = $this->uploadPath;
            if(!is_dir($uploadPath)){
                mkdir($uploadPath, 0755, true);
            }
            $files = $this->request->getFiles();

            $files = $this->request->getFiles();

            if (isset($files['ufiles']) && is_array($files['ufiles'])) {
                foreach ($files['ufiles'] as $file) {
                    if($file->isValid() && !$file->hasMoved()){
                        $newName = $file->getRandomName();
                        $oldName = $file->getClientName();
                        
                        $data_file = [
                            'popup_idx' => $idx,
                            'code' => 'popup',
                            'u_file' => $newName,
                            'r_file' => $oldName,
                            'r_date' => date('Y-m-d H:i:s')
                        ];
                        $fileResult = $this->Files->fileInsert($data_file);
                        if($fileResult){
                            $file->move($uploadPath, $newName);
                        }
                    }
                }
            }

            $this->db->transCommit();
            $resultArr['result'] = true;
            $resultArr['message'] = "수정했습니다.";
        } catch (Exception $err) {
            $this->db->transRollback();
            $resultArr['result'] = false;
            $resultArr['message'] = $err->getMessage();
        } finally {
            return $this->response->setJSON($resultArr);
        }
    }

    public function del_image() {
        $file_idx = $this->request->getPost('file_idx');
        $uploadPath = $this->uploadPath;

        try {
            if($file_idx){
                $this->db->transBegin();
                $data = $this->Files->fileSelect($file_idx);
                $u_file	= $data["u_file"];
    
                if($u_file != ""){
                    unlink($uploadPath.$u_file);
                }

                $this->Files->fileDelete($file_idx);

                $getCountSql = "SELECT * FROM tbl_files WHERE popup_idx = '".$data["popup_idx"]."'";
                $data_files = $this->db->query($getCountSql)->getResultArray();
                $count = count($data_files);

                $this->db->transCommit();
                $resultArr['result'] = true;
                $resultArr['count'] = $count;
            }
        } catch (Exception $err) {
            $this->db->transRollback();
            $resultArr['result'] = false;
            $resultArr['message'] = $err->getMessage();
        } finally {
            return $this->response->setJSON($resultArr);
        }
    }

    public function change_status() {
        $idx = $this->request->getPost('idx');
        $status = $this->request->getPost('status');

        try {
            if($idx){
                $this->db->transBegin();

                $data_popup = [
                    'status' => $status,
                ];
                $this->Popup->updateStatus($idx, $data_popup);

                $this->db->transCommit();
                $resultArr['result'] = true;
                $resultArr['message'] = "정상적으로 현황이 변경되었습니다.";
            }
        } catch (Exception $err) {
            $this->db->transRollback();
            $resultArr['result'] = false;
            $resultArr['message'] = $err->getMessage();
        } finally {
            return $this->response->setJSON($resultArr);
        }
    }

    public function del_popup() {
        $arr_idx = $this->request->getPost('idx');
        $uploadPath = $this->uploadPath;

        try {
            if(is_array($arr_idx)){
                $this->db->transBegin();

                foreach ($arr_idx as $idx) {
                    $this->Popup->adminDelete($idx);

                    $sql = "SELECT * FROM tbl_files WHERE popup_idx = '".$idx."'";
                    $data_files = $this->db->query($sql)->getResultArray();
                    foreach ($data_files as $file) {
                        $u_file	= $file["u_file"];
    
                        if($u_file != ""){
                            unlink($uploadPath.$u_file);
                        }

                        $this->Files->fileDelete($file["file_idx"]);
                    }
                }

                $this->db->transCommit();
                $resultArr['result'] = true;
                $resultArr['message'] = "정상적으로 삭제되었습니다.";
            }
        } catch (Exception $err) {
            $this->db->transRollback();
            $resultArr['result'] = false;
            $resultArr['message'] = $err->getMessage();
        } finally {
            return $this->response->setJSON($resultArr);
        }
    }
}
