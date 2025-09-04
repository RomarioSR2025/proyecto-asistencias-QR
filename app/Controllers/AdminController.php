<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function dashboard(): string
    {
        return view('administrador/dashboard/index');
    }
}