<?php

namespace App\Models;

use CodeIgniter\Model;

class Note extends Model
{
    protected $table = 'notes';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'title',
        'content',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $dateFormat    = 'datetime';
}
