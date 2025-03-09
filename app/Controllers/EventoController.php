<?php
namespace App\Controllers;

use App\Models\EventoModel;
use CodeIgniter\Database\BaseConnection;

class EventoController {
    private $eventoModel;
    protected $response;
    protected $db;
    protected $session;

    public function __construct(BaseConnection $db, $response, \Config\Services $services) {
        $this->db = $db;
        $this->response = $response;
        $this->session = $services::session();
        $this->eventoModel = new EventoModel($db);
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
        $userId = $this->session->get('usuario_id'); // Obtener el ID del usuario actual
        $rolId = $this->session->get('id_rol'); // Obtener el rol del usuario
    
        if ($rolId == 1) {
            // Si el rol es 1, obtener solo los eventos del usuario
            $events = $this->eventoModel->obtenerEventos($userId);
        } else {
            // Si el rol es 2 o 3, obtener todos los eventos
            $events = $this->eventoModel->obtenerEventos(); // Asegúrate de que este método esté configurado para retornar todos los eventos
        }
    
        $data = [];
        foreach ($events as $event) {
            $data[] = [
                'id' => $event['id_evento'],
                'title' => $event['glosa'],
                'start' => $event['fecha_inicio'],
                'end' => $event['fecha_fin'], // Cambiar si se necesita un rango diferente
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
        $id_usuario = $this->session->get('id_usuario');

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
