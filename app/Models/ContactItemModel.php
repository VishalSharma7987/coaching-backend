<?php
namespace App\Models;

use CodeIgniter\Model;

class ContactItemModel extends Model
{
    protected $table = 'contact_items';
    protected $allowedFields = ['type', 'value'];
}
