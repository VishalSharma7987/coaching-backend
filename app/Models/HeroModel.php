<?php

namespace App\Models;

use CodeIgniter\Model;

class HeroModel extends Model
{
    protected $table = 'hero_sections'; // ✅ CORRECT TABLE NAME
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'heading',
        'description',
        'background_image'
    ];

    protected $returnType = 'array';
}
