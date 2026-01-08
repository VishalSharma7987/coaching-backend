<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\AboutModel;
use App\Models\AboutPointsModel;

class About extends ResourceController
{
    protected $format = 'json';

    // 🌐 PUBLIC API
    public function index()
    {
        $aboutModel = new AboutModel();
        $pointModel = new AboutPointsModel();

        $about = $aboutModel->first();

        if (!$about) {
            return $this->respond([
                'about' => [
                    'heading' => 'Why Choose SQTS',
                    'sub_heading' => 'UNIQUE VALUE WORK',
                    'image' => null
                ],
                'points' => []
            ]);
        }

        $points = $pointModel
            ->where('about_id', $about['id'])
            ->findAll();

        return $this->respond([
            'about' => $about,
            'points' => $points
        ]);
    }

    // 🔐 ADMIN – SAVE ABOUT
    public function saveAbout()
    {
        $model = new AboutModel();
        $about = $model->first();

        $data = [
            'heading' => $this->request->getPost('heading'),
            'sub_heading' => $this->request->getPost('sub_heading'),
        ];

        $file = $this->request->getFile('image');
        if ($file && $file->isValid()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/about', $newName);
            $data['image'] = $newName;
        }

        if ($about) {
            $model->update($about['id'], $data);
        } else {
            $model->insert($data);
        }

        return $this->respond(['success' => true]);
    }

    // 🔐 ADMIN – ADD POINT
    public function addPoint()
    {
        $about = (new AboutModel())->first();
        if (!$about) {
            return $this->fail('About not found');
        }

        (new AboutPointsModel())->insert([
            'about_id' => $about['id'],
            'text' => $this->request->getJSON(true)['text']
        ]);

        return $this->respond(['success' => true]);
    }

    // 🔐 ADMIN – DELETE POINT
    public function deletePoint($id)
    {
        (new AboutPointsModel())->delete($id);
        return $this->respond(['success' => true]);
    }
}
