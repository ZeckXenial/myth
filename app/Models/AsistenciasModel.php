<?
namespace App\Models;

use CodeIgniter\Model;

class AsistenciasModel extends Model
{
    protected $table = 'asistencias';
    protected $primaryKey = 'id_asistencia';
    protected $allowedFields = ['rut_estudiante', 'fecha_asistencia', 'asistio', 'semestre', 'iduser', 'id_curso'];
    
    public function getAsistenciasPorCurso($cursoId)
    {
        return $this->where('id_curso', $cursoId)->findAll();
    }
}
