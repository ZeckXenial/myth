<?php

namespace App\Controllers;

use App\Models\estadisticasmodel;

class Estadisticas extends BaseController
{
    public function index()
    {
        // Instancia del modelo
        $estadisticasModel = new estadisticasmodel();

        // Obtener los datos de las estadísticas
        $asistenciasData = $estadisticasModel->getAsistenciasPorCurso();
        $matriculasData = $estadisticasModel->getTotalMatriculas();
        $anotacionesData = $estadisticasModel->getAnotacionesPorMes();
        $calificacionesData = $estadisticasModel->getPromedioCalificacionesPorCurso();
        $validacionesData = $estadisticasModel->obtenerValidaciones();

        // Preparar los datos para pasar a la vista
        $data = [
            'asistencias' => [
                'labels' => array_column($asistenciasData, 'curso'), // Nombres de los cursos
                'data' => array_column($asistenciasData, 'total_asistencias') // Cantidad de asistencias
            ],
            'matriculas' => [
                'labels' => array_column($matriculasData, 'fecha'), // IDs de cursos
                'data' => array_column($matriculasData, 'total_matriculados') // Total de matriculados
            ],
            'anotaciones' => [
                'labels' => array_column($anotacionesData, 'mes'), // Meses
                'data' => array_column($anotacionesData, 'total_anotaciones') // Total de anotaciones por mes
            ],
            'validaciones'=>$validacionesData,
            'calificaciones' => [
                'labels' => array_column($calificacionesData, 'curso'), // Nombres de los cursos
                'data' => array_column($calificacionesData, 'promedio_calificaciones') // Promedio de calificaciones
            ]
        ];
        
        // Cargar la vista y pasar los datos
        return view('Components/estadisticas.php', $data);
    }
}
