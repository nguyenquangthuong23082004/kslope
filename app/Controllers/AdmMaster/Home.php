<?php

namespace App\Controllers\AdmMaster;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        // $userPw = 'a123456!';
        // dd(sql_password($userPw));
        return view('AdmMaster/index'); 
    }
}