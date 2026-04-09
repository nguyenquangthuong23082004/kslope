<?php

namespace App\Controllers;

use App\Models\Code;

class Main extends BaseController
{
    public function index()
    {
        return view('main/main', []);
    }
}
