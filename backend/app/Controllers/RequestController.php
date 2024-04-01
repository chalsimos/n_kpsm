<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RequestModel;

class RequestController extends ResourceController
{
    protected $format       = 'json';

    public function __construct(){
        $this->requestModel = new RequestModel;
    }
    public function getRequest()
    {
        // generate and return all types of request from all users
        // applicable to execute all data and return to superadmin and admin
        //generate 4.1.2024 8.06P
        $data = $this->requestModel->findAll();
        var_dump($data);
    }
    public function index()
    {
        //
    }
}
