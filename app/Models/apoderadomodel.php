<?php

namespace App\Models;

use CodeIgniter\Model;

class ApoderadoModel extends Model
{
    protected $table = 'apoderados';
    protected $primaryKey = 'apoderado_id';
    protected $allowedFields = ['apoderado_id','rut','nombre_apoderado', 'numero_telefono', 'email'];

    public function obtenerApoderados()
{
    return $this->select('apoderados.*')
                ->join('estudiantes_apoderados', 'estudiantes_apoderados.apoderado_id = apoderados.apoderado_id')
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
                 ->where('apoderado_id', $apoderadoId)
                 ->update($data);
    
        return $this->db->affectedRows() > 0;
    }
    public function eliminarApoderado($id)
    {
        return $this->delete($id);
    }
}
