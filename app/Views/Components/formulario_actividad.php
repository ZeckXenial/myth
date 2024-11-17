<?php include(APPPATH . 'Views/Components/NavBar.php'); ?>
<?php include(APPPATH . 'Views/Components/headers.php'); ?>

<body>
    <div class="container text-center mt-4">
        <div class="form-control">
            <form action="<?= site_url('actividad/registrarActividad') ?>" method="post">
                <h1>Registra tu actividad diaria</h1>
                
                <input type="hidden" name="curso_id" value="<?= esc($curso['curso_id']) ?>">
                <input type="hidden" name="asignatura_id" value="<?= esc($asignatura['asignatura_id']) ?>">

                <div class="form-floating mb-3">
                      
                <textarea
                    class="form-floating form-control" 
                    name="glosa" 
                    placeholder="Descripción de la actividad" 
                        <?= $actividadRegistrada ? 'disabled' : '' ?>
                        required><?= $actividadRegistrada ? esc($glosaExistente) : '' ?></textarea><label for="">Descripción de la actividad</label>
                    <?php if ($actividadRegistrada): ?>
                        <div class="text-start mt-2 text-muted">
                            <small>Responsable de la actividad de hoy: <?= esc($nombreResponsable) ?></small>
                        </div>
                    <?php endif; ?>
                </div>

                <button class="btn btn-primary" type="submit" <?= $actividadRegistrada ? 'disabled' : '' ?>>Registrar actividad</button>
            </form>
        </div>
    </div>
</body>

<?php include(APPPATH . 'Views/Components/toast.php'); ?>
<?php include(APPPATH . 'Views/Components/footer.php'); ?>
