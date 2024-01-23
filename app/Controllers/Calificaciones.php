<?php
namespace App\Controllers;

use App\Models\CalificacionesModel;

class Calificaciones extends BaseController
{
    private $calificacionesModel;

    public function __construct()
    {
        $this->calificacionesModel = new CalificacionesModel();
    }

    public function curso($cursoId)
    {
        $data['calificaciones'] = $this->calificacionesModel->getCalificacionesPorCurso($cursoId);
        return view('components/calificaciones_curso', $data);
    }
    public function actualizar()
    {
        $idCalificacion = $this->request->getPost('id_calificacion');
        $nuevaNota = $this->request->getPost('nueva_nota');

        // Validaciones si es necesario

        // Llamada al modelo para actualizar la calificación
        $success = $this->calificacionesModel->actualizarCalificacion($idCalificacion, $nuevaNota);

        if ($success) {
            $response['status'] = 'success';
            $response['message'] = 'Calificación actualizada correctamente.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error al actualizar la calificación.';
        }

        return $this->response->setJSON($response);
    }
}
