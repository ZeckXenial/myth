<?php include(APPPATH . 'Views/Components/headers.php');?>
<?php include(APPPATH . 'Views/Components/NavBar.php');?>


<body>
  <div class="container">
    <h2 class="text-center" style="margin-top: 20px;">Lista de Asistencias</h2>
    <form class="form-control" action="<?= site_url("guardar_asistencias/$cursoId") ?>" method="post">
      <input type="hidden" name="fecha_asistencia" value="<?= date('Y-m-d') ?>">
      <table class="table table-responsive table-hover table-striped" id="asistenciaTable">
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
                <td><?= $asistencia['nombre_estudiante'] ?></td>
                <td>
                <input class="form-check-input" type="checkbox" name="asistencias[<?= $asistencia['estudiante_id'] ?>][presente]" value="1">
                <input type="hidden" name="asistencias[<?= $asistencia['estudiante_id'] ?>][estudiante_id]" value="<?= $asistencia['estudiante_id'] ?>">
                <input type="hidden" name="asistencias[<?= $asistencia['estudiante_id'] ?>][fecha_asistencia]" value="<?= date('Y-m-d') ?>">
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

  </body>
</html>
