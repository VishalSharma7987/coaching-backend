<?php

namespace App\Controllers;

use App\Models\HeroModel;
use CodeIgniter\RESTful\ResourceController;

class Hero extends ResourceController
{
    protected $modelName = HeroModel::class;
    protected $format = 'json';

    // 🔹 GET HERO DATA (Frontend)
    public function index()
    {
        $hero = $this->model->first();

        return $this->respond([
            'success' => true,
            'data' => $hero
        ]);
    }

    // 🔹 INSERT / UPDATE HERO (Admin CMS)
    public function saveHero()
    {
        $heading = $this->request->getPost('heading');
        $description = $this->request->getPost('description');
        $image = $this->request->getFile('background_image');

        if (!$heading || !$description) {
            return $this->respond([
                'success' => false,
                'message' => 'Heading and description required'
            ], 400);
        }

        $data = [
            'heading' => $heading,
            'description' => $description,
        ];

        // 📸 IMAGE UPLOAD
        if ($image && $image->isValid()) {
            $newName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads', $newName);
            $data['background_image'] = $newName;
        }

        // 🔁 UPDATE IF EXISTS ELSE INSERT
        $existing = $this->model->first();

        if ($existing) {
            $this->model->update($existing['id'], $data);
        } else {
            $this->model->insert($data);
        }

        return $this->respond([
            'success' => true,
            'message' => 'Hero section updated successfully'
        ]);
    }
}
