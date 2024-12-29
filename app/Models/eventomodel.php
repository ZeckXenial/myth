<?php
namespace App\Models;

use CodeIgniter\Database\BaseConnection;

class eventoModel {
    private $db;

    public function __construct(BaseConnection $db) {
        $this->db = $db;
    }

    public function insert($data)
    {
        return $this->db->table('eventos')->insert($data);
    }

    public function obtenerEventos() {
        $query = $this->db->table('eventos')->select('id_evento AS id, glosa AS title, fecha_inicio AS start, fecha_end AS end');
        $eventos = $query->get()->getResultArray();
        foreach ($eventos as &$evento) {
            $evento['start'] = date('c', strtotime($evento['start']));
            $evento['end'] = date('c', strtotime($evento['end']));
        }
        return $eventos;
    }

    public function eliminarEvento($id_evento) {
        return $this->db->table('eventos')->delete(['id_evento' => $id_evento]);
    }
}
?>
