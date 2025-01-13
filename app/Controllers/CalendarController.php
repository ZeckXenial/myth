<?php

namespace App\Controllers;

use App\Models\eventoModel;

/**
 * Class CalendarController
 *
 * @package App\Controllers
 */
class CalendarController extends BaseController
{
    public function index()
    {
        return view('Calendar'); // Asegúrate de que el nombre de la vista sea correcto
    }

    public function getEvents()
    {
        $db = \Config\Database::connect(); // Get the database connection
        $model = new eventoModel($db); // Pass the PDO instance to the model

        // Obtener el id_usuario del entorno de variables
        $userId = session()->get('iduser');  // Obtener el user_id de la sesión (autenticación)

        $events = $model->obtenerEventos($userId);

        $data = [];
        foreach ($events as $event) {
            $data[] = [
                'id' => $event['id'],
                'title' => $event['title'],
                'start' => $event['start'],
                'end' => $event['end'],
            ];
        }

        return $this->response->setJSON($data);
    }

    public function addEvent()
    {
        $request = \Config\Services::request();
        $data = $request->getPost(); // Use getPost() to retrieve form data

        // Obtener el id_usuario de la sesión
        $session = \Config\Services::session();
        $id_usuario = $session->get('iduser');

        // Ahora puedes acceder a los campos del formulario
        $glosa = $data['title'];
        $tipo = $data['type'];
        $fechaInicio = $data['start'];
        $fechaFin = $data['end'];
        $descripcion = $data['description'];


        $db = \Config\Database::connect();
        $model = new eventoModel($db);

        $eventData = [
            'glosa' => $glosa,
            'tipo' => $tipo,
            'fecha_inicio' => $fechaInicio,
            'fecha_end' => $fechaFin,
            'id_usuario' => $id_usuario, 
            'descripcion' => $descripcion
        ];

        $model->insert($eventData);

        // Redirigir a la vista con un mensaje de éxito
        return redirect()->to('calendar')->with('success', 'Evento agregado exitosamente.');
    }


    public function deleteEvent($id)
    {
        $db = \Config\Database::connect();
        $model = new eventoModel($db);
    
        if ($model->eliminarEvento($id)) { // Cambiar a eliminarEvento
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'No se pudo eliminar el evento.']);
        }
    }

    public function editEvent() {
        // Retrieve the JSON data from the request
        $data = $this->request->getJSON(true); // true to return as an associative array

        // Check if the data is valid
        if (!$data || !isset($data['id'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid data']);
        }

        // Retrieve the event ID and data
        $id = $data['id']; // Get the ID from the JSON
        $eventData = [
            'glosa' => $data['title'],
            'fecha_inicio' => $data['start'],
            'fecha_end' => $data['end'],
            // Add other fields as necessary
        ];

        try {
            // Update the event in the database
            $db = \Config\Database::connect();
            $model = new eventoModel($db);
            $result = $model->editarEvento($id, $eventData); // Use the ID here

            // Check if the update was successful
            if ($result) {
                return $this->response->setJSON(['success' => true]);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => $result]);
            }
        } catch (\Exception $e) {
            // Log the error message
            log_message('error', 'Database error: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Database error']);
        }
    }

    public function showCalendar() {
        // Call the EventoController to load the events view
        return $this->eventoController->loadEventsView();
    }
}
