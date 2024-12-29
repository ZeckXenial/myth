<?php
namespace App\Controllers;

use App\Models\EventoModel;
use CodeIgniter\Database\BaseConnection;

class EventoController {
    private $eventoModel;
    protected $response;
    protected $db;

    public function __construct(BaseConnection $db, $response) {
        $this->db = $db;
        $this->response = $response;
    }

    public function crearEvento($id_usuario, $tipo, $fecha, $glosa) {
        return $this->eventoModel->crearEvento($id_usuario, $tipo, $fecha, $glosa);
    }

    public function obtenerEventos() {
        return $this->eventoModel->obtenerEventos();
    }

    public function eliminarEvento($id_evento) {
        return $this->eventoModel->eliminarEvento($id_evento);
    }

    public function getEvents() {
        $events = $this->obtenerEventos(); // Llamar al método del modelo
        $data = [];
        
        foreach ($events as $event) {
            $data[] = [
                'id' => $event['id_evento'],
                'title' => $event['glosa'],
                'start' => $event['fecha'],
                'end' => $event['fecha'], // Cambiar si se necesita un rango diferente
            ];
        }

        return $this->response->setJSON($data);
    }

    public function loadEventsView() {
        $events = $this->obtenerEventos(); // Fetch events
        return view('eventos', ['events' => $events]); // Load the view with events data
    }

    public function addEvent()
    {
        $request = \Config\Services::request();
        $data = json_decode($request->getBody(), true);

        // Obtener el id_usuario de la sesión
        $session = \Config\Services::session();
        $id_usuario = $session->get('id_usuario');

        $model = new EventoModel($this->db); 

        $eventData = [
            'glosa' => $data['title'],
            'tipo' => $data['type'],
            'fecha_inicio' => $data['start'],
            'fecha_end' => $data['end'],
            'id_usuario' => $id_usuario, // Añadir el id_usuario
        ];

        $model->insert($eventData);

        return $this->response->setJSON(['status' => 'success', 'data' => $eventData]);
    }
}
?>
