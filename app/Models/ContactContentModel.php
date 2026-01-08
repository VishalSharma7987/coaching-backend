<?php
namespace App\Models;

use CodeIgniter\Model;

class ContactContentModel extends Model
{
    protected $table = 'contact_content';
    protected $allowedFields = ['heading', 'description'];
}
