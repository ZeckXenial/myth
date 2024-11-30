<?php

namespace App\Models;

use CodeIgniter\Model;

class matriculas_model extends Model
{
    protected $table = 'matriculas';

    // Obtener todos los estudiantes con sus datos de apoderado y matrícula
    public function obtener_todos()
    {
        return $this->db->table('estudiantes e')
            ->select('e.*, a.nombre_apoderado, a.apoderado_id, e.estudiante_id, m.matricula_id, a.numero_telefono, a.email, m.fecha_matriculacion, m.estado, c.grado, n.nombre')
            ->join('matriculas m', 'e.estudiante_id = m.estudiante_id', 'left')
            ->join('apoderados a', 'm.apoderado_id = a.apoderado_id', 'left')
            ->join('cursos c', 'e.curso_id = c.curso_id', 'left')  // Relaciona la tabla estudiantes con cursos
            ->join('nivel n', 'c.nivel_id = n.nivel_id', 'left') // Relaciona la tabla cursos con niveles
            ->get()
            ->getResult();
    }

    // Agregar un nuevo estudiante, apoderado y matrícula
    public function agregar_matricula($estudiante_data, $apoderado_data, $matricula_data)
    {
        $this->db->transStart();

        // Insertar el estudiante y obtener su ID
        $this->db->table('estudiantes')->insert($estudiante_data);
        $estudiante_id = $this->db->insertID();

        // Insertar el apoderado y obtener su ID
        $this->db->table('apoderados')->insert($apoderado_data);
        $apoderado_id = $this->db->insertID();

        // Insertar la matrícula asociando los IDs de estudiante y apoderado
        $matricula_data['estudiante_id'] = $estudiante_id;
        $matricula_data['apoderado_id'] = $apoderado_id;
        $this->db->table('matriculas')->insert($matricula_data);

        // Completar la transacción
        $this->db->transComplete();

        return $this->db->transStatus();
    }

    // Actualizar los datos de estudiante, apoderado y matrícula
    public function actualizar_matricula($id, $matricula_data)
    {
        $this->db->transStart();

        
        // Actualizar la matrícula
        $this->db->table('matriculas')->where('estudiante_id', $id)->update($matricula_data);

        // Completar la transacción
        $this->db->transComplete();

        return $this->db->transStatus();
    }

    // Eliminar la matrícula junto con el estudiante y el apoderado
    public function eliminar_matricula($id)
    {
        $this->db->transStart();

        // Eliminar la matrícula
        $this->db->table('matriculas')->where('matricula_id', $id)->delete();

        
        // Completar la transacción
        $this->db->transComplete();

        return $this->db->transStatus();
    }

    // Obtener un estudiante específico con su apoderado y matrícula
    public function editar($estudiante_id, $apoderado_id)
{
    // Pasar los dos IDs a la función obtener_por_id
    $data['matricula'] = $this->matriculasModel->obtener_por_id($estudiante_id, $apoderado_id);

    $data['estudiante_id'] = $estudiante_id;
    $data['apoderado_id'] = $apoderado_id;

    $data['cursos'] = $this->cursomodel->obtenerCursos();

    return view('components/crud_apoderados', $data);
}

     public function agregar_estudiante($data)
    {
        $builder = $this->db->table('estudiantes');
        $builder->insert($data);
        return $this->db->insertID();
    }

    public function agregar_apoderado($data)
    {
        $builder = $this->db->table('apoderados');
        $builder->insert($data);
        return $this->db->insertID();
    }

    public function actualizar_estudiante($estudiante_id, $data)
    {
        $builder = $this->db->table('estudiantes');
        $builder->where('estudiante_id', $estudiante_id);
        return $builder->update($data);
    }

    public function actualizar_apoderado($apoderado_id, $data)
    {
        $builder = $this->db->table('apoderados');
        $builder->where('apoderado_id', $apoderado_id);
        return $builder->update($data);
    }

    public function obtener_por_id($estudiante_id, $apoderado_id)
{
    $builder = $this->db->table($this->table);
    $builder->select('matriculas.*, estudiantes.*, apoderados.*, apoderados.rut as rut_apoderado, estudiantes.rut as rut_estudiantes');
    $builder->join('estudiantes', 'estudiantes.estudiante_id = matriculas.estudiante_id');
    $builder->join('apoderados', 'apoderados.apoderado_id = matriculas.apoderado_id');
    $builder->where('matriculas.estudiante_id', $estudiante_id);
    $builder->where('matriculas.apoderado_id', $apoderado_id);

    return $builder->get()->getRow();
}

}
