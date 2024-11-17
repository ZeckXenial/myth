<?php

namespace App\Models;
use CodeIgniter\Model;

class ValidacionModel extends Model
{
    protected $table = 'validacion';
    protected $primaryKey = 'val_id';
    protected $allowedFields = ['fecha_val', 'user_id', 'status'];
}
