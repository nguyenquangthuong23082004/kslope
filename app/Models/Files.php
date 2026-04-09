<?php
namespace App\Models;
use CodeIgniter\Model;

class Files extends Model{
    protected $table = "tbl_files";

    protected $primaryKey = "file_idx";

    protected function initialize()
    {
        $this->allowedFields = [];
    }

    public function fileSelect($idx){
        return $this->find($idx);
    }

    public function fileInsert($post){
        $this->allowedFields = ['popup_idx', 'code', 'u_file', 'r_file', 'r_date'];
        return $this->insert($post);
    }


    public function fileDelete($idx){
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