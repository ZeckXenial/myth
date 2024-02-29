<?php include(APPPATH . 'Views/Components/headers.php');?>
<?php include(APPPATH . 'Views/Components/NavBar.php');?>
<body>
    

<h1 class="text-center">Calificaciones por Asignatura</h1>

<div class="container mt-4">
    <div class="row">
        <?php foreach ($asignaturas as $asignatura): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $asignatura['nombre'] ?></h5>
                        <a href="<?= site_url('calificaciones/' . $asignatura['curso_id'] . '/' . $asignatura['asignatura_id']) ?>" class="btn btn-primary">Entrar a Calificaciones</a>
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
