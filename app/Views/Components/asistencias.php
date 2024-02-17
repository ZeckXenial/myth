<?php include(APPPATH . 'Views/Components/headers.php');?>
<?php include(APPPATH . 'Views/Components/NavBar.php');?>

<div class="container ">
    <h2 class="text-center" style="margin-top: 20px;">Lista de Asistencias</h2>
    <form class="form-control  datatable " action="<?= site_url("guardar_asistencias/$cursoId") ?>" method="post">
      
        <input type="hidden" name="fecha_asistencia" value="<?= date('Y-m-d') ?>">
        <table class="table datatable table-responsive table-hover table-striped ">
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Presente</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($asistencias) && is_array($asistencias)): ?>
                    <?php foreach ($asistencias as $asistencia): ?>
                        <tr>
                            <td><?= $asistencia['nombre'] ?></td>
                            <td>
                                <input type="checkbox" name="asistencias[]" value="<?= $asistencia['estudiante_id'] ?>">
                                
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2">No hay asistencias disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Guardar Asistencias</button>
    </form>
</div>
