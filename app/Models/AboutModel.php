<?php

namespace App\Models;

use CodeIgniter\Model;

class AboutModel extends Model
{
    protected $table = 'about_section';
    protected $primaryKey = 'id';
    protected $allowedFields = ['heading','sub_heading','image'];
    protected $useTimestamps = false;
}