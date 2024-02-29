<?php

namespace App\Models;

use CodeIgniter\Model;

class ApoderadoModel extends Model
{
    protected $table = 'apoderados';
    protected $primaryKey = 'apoderados_id';
    protected $allowedFields = ['nombre_apoderado', 'numero_telefono', 'email'];

    public function obtenerApoderados()
{
    return $this->select('apoderados.*')
                ->join('estudiantes_apoderados', 'estudiantes_apoderados.apoderados_id = apoderados.apoderados_id')
                ->findAll();
}
    public function obtenerApoderado($id)
    {
        return $this->find($id);
    }
    public function crearApoderado($data)
    {
        return $this->insert($data);
    }
    public function editarapoderado($apoderadoId, $apoderadoData)
    {
        $data = [
            'nombre_apoderado' => $apoderadoData['nombre_apoderado'],
            'numero_telefono' => $apoderadoData['numero_telefono'],
            'email' => $apoderadoData['email']
        ];
    
        $this->db->table('apoderados')
                 ->where('apoderados_id', $apoderadoId)
                 ->update($data);
    
        return $this->db->affectedRows() > 0;
    }
    public function eliminarApoderado($id)
    {
        return $this->delete($id);
    }
}
