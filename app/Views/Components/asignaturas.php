<?php include(APPPATH . 'Views/Components/headers.php'); ?>
<?php include(APPPATH . 'Views/Components/NavBar.php'); ?>

<body>
    <h1 class="text-center">Calificaciones por Asignatura</h1>

    <div class="container mt-4">
        <div class="row">
            <?php foreach ($asignaturas as $asignatura): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $asignatura['nombre_asignatura'] ?></h5>
                            <h5 class="h6">Profesor: <?= $asignatura['nombre'] ?></h5>
                            
                            <!-- Botón para acceder a las calificaciones -->
                            <a href="<?= site_url('calificaciones/' . $asignatura['curso_id'] . '/' . $asignatura['asignatura_id']) ?>" class="btn margin5px btn-primary">Entrar a Calificaciones</a>
                            
                            <!-- Botón para registro de actividades -->
                            <a href="<?= site_url('actividad/formulario/' . $asignatura['curso_id'] . '/' . $asignatura['asignatura_id']) ?>" class="btn margin5px btn-primary">Registro de Actividades</a>
                            <a href="<?= site_url('actividad/vista/' . $asignatura['curso_id'] . '/' . $asignatura['asignatura_id']) ?>" class="btn margin5px btn-primary">Ver actividades</a>
                            
                            <!-- Botón para editar, solo visible para ciertos roles -->
                            <?php if (session()->get('idrol') === '2' xor session('idrol') === '3'): ?>
                                <a href="<?= site_url('editar/' . $asignatura['asignatura_id']) ?>" class="btn btn-primary">Editar</a>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

<?php include(APPPATH . 'Views/Components/footer.php'); ?>
