<?php

namespace App\Models;

use CodeIgniter\Model;

class ActividadModel extends Model
{
    protected $table = 'actividades';
    protected $primaryKey = 'act_id';
    protected $allowedFields = ['user_id', 'curso_id', 'asignatura_id', 'glosa', 'fecha_actividad'];
}
