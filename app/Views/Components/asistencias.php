<?php include(APPPATH . 'Views/Components/headers.php');?>
<?php include(APPPATH . 'Views/Components/NavBar.php');?>

<body>
  <div class="container">
    <h2 class="text-center" style="margin-top: 20px;">Registro de Asistencias</h2>
    <?php if (!empty($ultimaFechaAsistencia)): ?>
      <p class="text-center">Última fecha de registro de asistencia para este curso: <?= date('d/m/Y', strtotime($ultimaFechaAsistencia['fecha'])) ?></p>
    <?php else: ?>
      <p class="text-center">Sin registros para este curso</p>
    <?php endif; ?>
    
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
                  <div class="form-check">
                    <!-- Verificar si el estudiante está presente -->
                    <input class="form-check-input" 
                           type="checkbox" 
                           name="asistencias[<?= $asistencia['estudiante_id'] ?>][presente]" 
                           value="1" 
                           <?php if (isset($estudiantesPresentes) && in_array($asistencia['estudiante_id'], array_column($estudiantesPresentes, 'estudiante_id'))): ?> checked <?php endif; ?>>
                    <input type="hidden" name="asistencias[<?= $asistencia['estudiante_id'] ?>][estudiante_id]" value="<?= $asistencia['estudiante_id'] ?>">
                    <input type="hidden" name="curso_id" value="<?= $cursoId ?>">
                    <input type="hidden" name="asistencias[<?= $asistencia['estudiante_id'] ?>][fecha_asistencia]" value="<?= date('Y-m-d') ?>">
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="2">No hay asistencias disponibles para este curso.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
      <button type="submit" class="btn btn-primary">Guardar Asistencias</button>
    </form>
  </div>
</body>
</html>
