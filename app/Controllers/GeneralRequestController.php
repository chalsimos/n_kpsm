<?php

namespace App\Controllers;
use App\Models\RequestModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;


class GeneralRequestController extends BaseController
{
    public function index()
    {
        $rmodel = new RequestModel();
        $data['request'] = $rmodel->findAll();
        // var_dump($data);
        return $this->response->setJSON($data);
    }
}
