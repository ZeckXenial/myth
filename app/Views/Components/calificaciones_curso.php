
<?php include(APPPATH . 'Views/Components/NavBar.php');?>
<?php include(APPPATH . 'Views/Components/headers.php');?>
<h1 class="text-center">Libro de Calificaciones</h1>

<table id="calificacionesTable" class="table table-bordered">
    <thead>
        <tr>
            <th>Estudiante</th>
            <th>Materia</th>
            <th>Nota</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($calificaciones as $calificacion): ?>
            <tr>
                <td><?= $calificacion['nombre_estudiante'] ?></td>
                <td><?= $calificacion['materia'] ?></td>
                <td contenteditable="true" class="editable" data-id="<?= $calificacion['Id_calificacion'] ?>">
                    <?= $calificacion['nota'] ?>
                </td>
                <td><?= $calificacion['fecha_ingreso'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
