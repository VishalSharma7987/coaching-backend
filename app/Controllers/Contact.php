<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ContactContentModel;
use App\Models\ContactItemModel;
use App\Models\ContactMessageModel;

class Contact extends ResourceController
{
    protected $format = 'json';

    // FRONTEND LOAD
    public function index()
    {
        $content = (new ContactContentModel())->first();
        $items = (new ContactItemModel())->findAll();

        return $this->respond([
            'content' => $content,
            'items'   => $items
        ]);
    }

    // ADMIN UPDATE MAIN CONTENT
    public function saveContent()
    {
        $data = $this->request->getJSON(true);
        $model = new ContactContentModel();

        $row = $model->first();
        if ($row) {
            $model->update($row['id'], $data);
        } else {
            $model->insert($data);
        }

        return $this->respond(['success' => true]);
    }

    // ADMIN ADD / UPDATE ITEM
    public function saveItem()
    {
        $data = $this->request->getJSON(true);
        $model = new ContactItemModel();

        if (!empty($data['id'])) {
            $model->update($data['id'], $data);
        } else {
            $model->insert($data);
        }

        return $this->respond(['success' => true]);
    }

    // ADMIN DELETE ITEM
    public function deleteItem($id)
    {
        (new ContactItemModel())->delete($id);
        return $this->respond(['success' => true]);
    }

    // SAVE CONTACT FORM MESSAGE (optional)
    public function submit()
    {
        $data = $this->request->getJSON(true);
        (new ContactMessageModel())->insert($data);

        return $this->respond(['success' => true]);
    }
}
