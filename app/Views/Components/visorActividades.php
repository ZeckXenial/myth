<?php include(APPPATH . 'Views/Components/headers.php') ;
include(APPPATH . 'Views/Components/NavBar.php');
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
                     <?php if (session()->get('idrol') == 2): ?>
        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarModal<?= $actividad['act_id'] ?>">Editar</button>

<?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div> 
    <div class="modal fade" id="editarModal<?= $actividad['act_id'] ?>" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Editar Actividad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('actividad/actualizar/' . $actividad['act_id']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" id="glosa" name="glosa" required><?= esc($actividad['glosa']) ?></textarea>
                            <label for="glosa">Glosa</label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
    <?php else: ?>
        <!-- Mensaje de no actividades -->
        <p class="text-center mt-4">No hay actividades registradas.</p>
    <?php endif; ?>
  
                </form>
            </div>
        </div>
    </div>
</div>
</body>