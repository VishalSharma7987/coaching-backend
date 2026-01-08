<?php

namespace App\Models;

use CodeIgniter\Model;

class ServicesModel extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'title',
        'description',
        'icon'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
}

