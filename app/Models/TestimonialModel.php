<?php

namespace App\Models;

use CodeIgniter\Model;

class TestimonialModel extends Model
{
    protected $table = 'testimonials';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'company',
        'message',
        'image'
    ];

    protected $useTimestamps = false;
}
