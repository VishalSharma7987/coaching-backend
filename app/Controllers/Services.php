<?php

namespace App\Controllers;

use App\Models\ServicesModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Services extends ResourceController
{
    protected $modelName = ServicesModel::class;
    protected $format = 'json';

    // ✅ CI4 CORRECT WAY
    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        // 🔥 MODEL INIT HERE
        $this->model = new ServicesModel();
    }

    public function index()
    {
        try {
            $services = $this->model->findAll();

            if (empty($services)) {
                $defaultServices = [
                    ['title'=>'Web Development','description'=>'','icon'=>'fas fa-code'],
                    ['title'=>'Digital Marketing & SEO','description'=>'','icon'=>'fas fa-bullhorn'],
                    ['title'=>'Graphic Design','description'=>'','icon'=>'fas fa-paint-brush'],
                    ['title'=>'CRM & Reports','description'=>'','icon'=>'fas fa-chart-line'],
                    ['title'=>'Staff Augmentation','description'=>'','icon'=>'fas fa-users'],
                    ['title'=>'SEO Optimization','description'=>'','icon'=>'fas fa-search'],
                ];

                foreach ($defaultServices as $s) {
                    $this->model->insert($s);
                }

                $services = $this->model->findAll();
            }

            return $this->respond([
                'success' => true,
                'data' => $services
            ]);
        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function create()
    {
        $data = $this->request->getJSON(true);

        if (!$data) {
            return $this->fail('No data received');
        }

        $this->model->insert([
            'title' => $data['title'],
            'description' => $data['description'],
            'icon' => $data['icon'],
        ]);

        return $this->respond([
            'success' => true,
            'message' => 'Service added'
        ]);
    }

    public function delete($id = null)
    {
        $this->model->delete($id);
        return $this->respond(['success' => true]);
    }
}
