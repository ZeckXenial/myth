<?php include(APPPATH . 'Views/Components/NavBar.php');?>
<?php include(APPPATH . 'Views/Components/headers.php');?>

<h1 class="text-center">Libro de Anotaciones</h1>

<div class="row">
    <?php foreach ($anotaciones as $anotacion): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= isset($anotacion['nombre']) ? $anotacion['nombre'] : 'Estudiante Desconocido' ?></h5>
                    <p class="card-text">Descripción: <?= $anotacion['glosa_anot'] ?? 'Sin descripción' ?></p>
                    <p class="card-text">Fecha: <?= $anotacion['fecha_anotacion'] ?? 'Sin fecha' ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nuevo Estudiante</h5>
                <!-- Formulario para agregar nueva anotación -->
                <form action="<?= site_url("anotaciones/agregar") ?>" method="post">
                    <!-- Campos del formulario (por ejemplo, descripción, fecha, etc.) -->
                    <textarea name="descripcion" class="form-control" placeholder="Descripción"></textarea>
                    <!-- ... (otros campos) ... -->
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include(APPPATH . 'Views/Components/toast.php'); ?>
<?php include(APPPATH . 'Views/Components/footer.php'); ?>
