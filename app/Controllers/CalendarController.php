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

        $events = $model->obtenerEventos();

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

        $db = \Config\Database::connect();
        $model = new eventoModel($db);

        $eventData = [
            'glosa' => $glosa,
            'tipo' => $tipo,
            'fecha_inicio' => $fechaInicio,
            'fecha_end' => $fechaFin,
            'id_usuario' => $id_usuario, // Añadir el id_usuario
        ];

        $model->insert($eventData);

        // Redirigir a la vista con un mensaje de éxito
        return redirect()->to('calendar')->with('success', 'Evento agregado exitosamente.');
    }

    public function showCalendar() {
        // Call the EventoController to load the events view
        return $this->eventoController->loadEventsView();
    }
}
