<?php include(APPPATH . 'Views/Components/headers.php') ;
include(APPPATH . 'Views/Components/Navbar.php');
?>
<body class="container">

<!-- Título -->
<h2 class="text-center my-4">Actividades para <?= esc($curso['grado']) ?> - <?= esc($asignatura['nombre_asignatura']) ?></h2>

<div class="mx-auto">
    <?php if (!empty($actividades)): ?>
        <!-- Lista de Actividades -->
        <ul class="list-group">
            <?php foreach ($actividades as $actividad): ?>
                <li class="list-group-item">
                    <strong>Fecha:</strong> <?= date('Y-m-d', strtotime($actividad['fecha_actividad'])) ?> <br>
                    <strong>Glosa:</strong> <?= esc($actividad['glosa']) ?> <br>
                    <strong>Responsable:</strong> <?= esc($actividad['nombre_responsable']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php else: ?>
        <!-- Mensaje de no actividades -->
        <p class="text-center mt-4">No hay actividades registradas.</p>
    <?php endif; ?>
</body>