<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Response;

class NanofwController extends Controller {
    public function index(): Response {
        return $this->view('nanofw', [
            'current_route'  => $this->request->path(),
            'controller'     => static::class . '::index',
            'is_https'       => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'session_active' => session_status() === PHP_SESSION_ACTIVE,
        ], 'blank');
    }
}