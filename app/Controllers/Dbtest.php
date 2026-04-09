<?php

namespace App\Controllers;

use CodeIgniter\Database\BaseConnection;

class Dbtest extends BaseController
{
    public function index(): string
    {
        /** @var BaseConnection $db */
        $db = db_connect();

        try {
            $db->initialize();
            $version = $db->query('SELECT VERSION() AS v')->getRowArray();

            return 'DB OK: ' . ($version['v'] ?? 'unknown');
        } catch (\Throwable $e) {
            return 'DB ERROR: ' . $e->getMessage();
        }
    }
}
