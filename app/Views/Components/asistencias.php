
<?php include(APPPATH . 'Views/Components/headers.php');?>
<?php include(APPPATH . 'Views/Components/NavBar.php');?>
<div class="container r">
    <h2 class="text-center" style="margin-top: 20px;">Lista de Asistencias</h2>
    <form class="form-control  datatable " action="<?= site_url('guardar_asistencias') ?>" method="post">
      
        <input type="hidden" name="fecha_asistencia" value="<?= date('Y-m-d') ?>">
        <table class="table datatable table-responsive table-hover table-striped ">
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Presente</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($asistencias as $asistencia): ?>
                <tr>
                    <td><?= $asistencia['nombre'] ?></td>
                    <td>
                        <input type="checkbox" name="asistencias[]" value="<?= $asistencia['estudiante_id'] ?>">
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Guardar Asistencias</button>
    </form>
</div>
