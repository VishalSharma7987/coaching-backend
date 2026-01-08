<?php

namespace App\Models;

use CodeIgniter\Model;

class AboutPointsModel extends Model
{
    protected $table = 'about_points';
    protected $primaryKey = 'id';
    protected $allowedFields = ['about_id','text'];
    protected $useTimestamps = false;
}