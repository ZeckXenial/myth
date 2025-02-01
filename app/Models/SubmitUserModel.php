<?php 
namespace App\Models;

use CodeIgniter\Model;

class SubmitUserModel extends Model
{
    protected $table = 'users'; // Reemplaza 'users' con el nombre real de tu tabla

    protected $primaryKey = 'rut'; // Reemplaza 'rut' con la clave primaria de tu tabla

    protected $allowedFields = ['rut', 'email', 'password']; // Lista de campos permitidos para inserción

}