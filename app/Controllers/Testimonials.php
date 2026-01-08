<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\TestimonialModel;

class Testimonials extends ResourceController
{
    protected $format = 'json';

    // 🔹 PUBLIC API (frontend)
    public function index()
    {
        $model = new TestimonialModel();
        $data = $model->findAll();

        // ✅ Default data insert (FIRST TIME ONLY)
        if (empty($data)) {
            $default = [
                [
                    'name' => 'William Jackson',
                    'company' => 'Edusity, USA',
                    'message' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
                    'image' => 'user-1.png'
                ],
                [
                    'name' => 'William Jackson',
                    'company' => 'Edusity, USA',
                    'message' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
                    'image' => 'user-2.png'
                ],
                [
                    'name' => 'William Jackson',
                    'company' => 'Edusity, USA',
                    'message' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
                    'image' => 'user-3.png'
                ],
                [
                    'name' => 'William Jackson',
                    'company' => 'Edusity, USA',
                    'message' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
                    'image' => 'user-4.png'
                ]
            ];

            foreach ($default as $d) {
                $model->insert($d);
            }

            $data = $model->findAll();
        }

        return $this->respond($data);
    }

    // 🔹 ADMIN ADD / UPDATE
    public function save()
    {
        $model = new TestimonialModel();
        $id = $this->request->getPost('id');

        $data = [
            'name' => $this->request->getPost('name'),
            'company' => $this->request->getPost('company'),
            'message' => $this->request->getPost('message'),
        ];

        // IMAGE UPLOAD
        $file = $this->request->getFile('image');
        if ($file && $file->isValid()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/testimonials', $newName);
            $data['image'] = $newName;
        }

        if ($id) {
            $model->update($id, $data);
        } else {
            $model->insert($data);
        }

        return $this->respond(['success' => true]);
    }

    // 🔹 DELETE
    public function delete($id = null)
    {
        (new TestimonialModel())->delete($id);
        return $this->respond(['success' => true]);
    }
}
