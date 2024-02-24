<?php include(APPPATH . 'Views/Components/headers.php');?>


<body>
    <?php include(APPPATH . 'Views/Components/NavBar.php');?>
<div class="container mt-4">
    <h1 class="text-center">Cursos</h1>

    <div class="row">
        <?php foreach ($cursos as $curso): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text"><?= $curso['grado'] ?></p>
                        <p class="card-text">Nivel: <?= $curso['nombre_nivel'] ?></p> <!-- Agregamos el nivel aquí -->
                        <p class="card-text">Profesor Designado: <?= $curso['nombre_usuario'] ?></p>
                        <a href="<?= site_url("anotaciones/curso/{$curso['curso_id']}") ?>" class="btn margin5px btn-primary">Anotaciones</a>
                        <a href="<?= site_url("asistencias/curso/{$curso['curso_id']}") ?>" class="btn margin5px btn-primary">Asistencias</a>
                        <a href="<?= site_url("calificaciones/asignaturas/{$curso['curso_id']}") ?>" class="btn margin5px btn-primary">Calificaciones</a>
                        <?php if (session()->get('idrol') === '2' xor session('idrol') === '3'): ?>
                                <a href="<?= site_url("cursos/editar/{$curso['curso_id']}") ?>" class="btn margin5px btn-primary">Editar</a>
                            <?php endif; ?>
                            <a href="<?= site_url("cursos/exportar/{$curso['curso_id']}") ?>" class="btn margin5px btn-primary">Exportar</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if (session()->get('idrol') === '2' or session()->get('idrol') === '3'): ?>
                    
                        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Crear Nuevo Curso</h5>
                    <a href="<?= site_url('cursos/agregar') ?>" class="btn btn-primary">Crear</a>
                </div>
            </div>
        </div>
                <?php endif; ?>
        
    </div>
</div>    
<?php include(APPPATH . 'Views/Components/toast.php'); ?>
</body>

<?php include(APPPATH . 'Views/Components/footer.php'); ?>
