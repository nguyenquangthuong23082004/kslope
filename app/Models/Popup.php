<?php
namespace App\Models;
use CodeIgniter\Model;

class Popup extends Model{
    protected $table = "tbl_popup";

    protected $primaryKey = "idx";

    protected function initialize()
    {
        $this->allowedFields = [];
    }

    public function adminSelect($idx){
        return $this->find($idx);
    }

    public function adminInsert($post){
        $this->allowedFields = ['P_SUBJECT', 'P_STARTDAY', 'P_START_HH', 'P_START_MM', 'P_ENDDAY', 'P_END_HH', 'P_END_MM', 'P_MOVEURL', 'status', 'is_mobile', 'P_WIN_TOP', 'P_WIN_LEFT'];
        if(empty($post['P_STARTDAY'])){
            $post['P_STARTDAY'] = null;
        }
        if(empty($post['P_ENDDAY'])){
            $post['P_ENDDAY'] = null;
        }
        return $this->insert($post);
    }
    /**
     * 관리자 팝업 등록
     */
    public function adminUpdate($idx, $post){
        $this->allowedFields = ['P_SUBJECT', 'P_STARTDAY', 'P_START_HH', 'P_START_MM', 'P_ENDDAY', 'P_END_HH', 'P_END_MM', 'P_MOVEURL', 'status', 'is_mobile', 'P_WIN_TOP', 'P_WIN_LEFT'];
        if(empty($post['P_STARTDAY']) || is_null($post['P_STARTDAY'])){
            $post['P_STARTDAY'] = null;
        }
        if(empty($post['P_ENDDAY'] || is_null($post['P_ENDDAY']))){
            $post['P_ENDDAY'] = null;
        }
        return $this->update($idx, $post);
    }

    public function updateStatus($idx, $post){
        $this->allowedFields = ['status'];
        return $this->update($idx, $post);
    }

    public function adminDelete($idx){
        return $this->delete($idx);
    }

    public function adminFileUpdate($idx, $data){
        $this->allowedFields = ['ufile', 'rfile'];
        return $this->update($idx, $data);
    }

    public function adminStatusChangeAjax($idx, $status){
        $this->allowedFields = ['status'];
        return $this->update($idx, ['status'=>$status]);
    }
}