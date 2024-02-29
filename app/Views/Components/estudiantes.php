<?php include(APPPATH . 'Views/Components/NavBar.php');?>
<?php include(APPPATH . 'Views/Components/headers.php');?>
<body>
    
<div class="container mt-4">
    <h2 class="text-center h1">Gestión de Estudiantes y Apoderados</h2>
 
    <div class="modal mx-auto fade" id="crearEstudianteModal" data-backdrop="static" tabindex="-1" aria-labelledby="crearEstudianteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearEstudianteModalLabel">Agregar Estudiante y Apoderado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('estudiantes/agregar') ?>" method="post">
                    <div class="mb-3">
                        <label for="nombre_estudiante" class="form-label">Nombre del Estudiante</label>
                        <input type="text" class="form-control" id="nombre_estudiante" name="nombre_estudiante" placeholder="Nombre del estudiante" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_nacimiento_estudiante" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nacimiento_estudiante" name="fecha_nacimiento_estudiante" required>
                    </div>
                    <div class="mb-3">
                </div>
                    <div class="mb-3">
                        <label for="nombre_apoderado" class="form-label">Nombre del Apoderado</label>
                        <input type="text" class="form-control" id="nombre_apoderado" name="nombre_apoderado" placeholder="Nombre del apoderado" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono_apoderado" class="form-label">Teléfono del Apoderado</label>
                        <input type="tel" class="form-control" id="telefono_apoderado" name="telefono_apoderado" placeholder="Teléfono del apoderado" required>
                    </div>
                    <div class="mb-3">
                        <label for="email_apoderado" class="form-label">Correo Electrónico del Apoderado</label>
                        <input type="email" class="form-control" id="email_apoderado" name="email_apoderado" placeholder="Correo electrónico del apoderado" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="editarEstudianteModal" tabindex="-1" aria-labelledby="editarEstudianteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarEstudianteModalLabel">Editar Estudiante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body container">
                <form id="editarEstudianteForm"  method="post">
                    <div class="mb-3">
                        <label for="nombreEstudiante" class="form-label">Nombre del Estudiante</label>
                        <input type="text" class="form-control" id="nombre_estudiante" name="nombre_estudiante" placeholder="Nombre del estudiante">
                    </div>
                    <div class="mb-3">
                        <label for="fechaNacimientoEstudiante" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="fechaNacimientoEstudiante" name="fechaNacimientoEstudiante">
                    </div>
                    <div class="mb-3">
                        <label for="cursoEstudiante" class="form-label">Curso</label>
                        <select class="form-select" id="cursoEstudiante" name="curso_id">
                            <?php foreach ($cursos as $curso): ?>
                                <option value="<?= $curso['curso_id'] ?>"><?= $curso['grado']?> <?=$curso['nombre_nivel'] ?></option>

                            <?php endforeach; ?>
                        </select>
                    </div>
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#editarApoderadoModal">Editar Apoderado</button>
                            <button type="submit" class="btn btn-primary" id="guardarCambiosEstudiante">Guardar Cambios</button>
                </form>
            </div>
           
            
        </div>
    </div>
</div>
<div class="modal fade" id="editarApoderadoModal" tabindex="-1" aria-labelledby="editarApoderadoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarApoderadoModalLabel">Editar Apoderado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editarApoderadoForm" method="post">
                    <div class="mb-3">
                      
                        <div class="mb-3">
                        <label for="nombre_apoderado" class="form-label">Nombre del Apoderado</label>
                        <input type="text" class="form-control" id="nombre_apoderado" name="nombre_apoderado" placeholder="Nombre del apoderado">
                    </div>
                    <div class="mb-3">
                        <label for="telefono_apoderado" class="form-label">Teléfono del Apoderado</label>
                        <input type="tel" class="form-control" id="telefono_apoderado" name="telefono_apoderado" placeholder="Teléfono del apoderado">
                    </div>
                    <div class="mb-3">
                        <label for="email_apoderado" class="form-label">Correo Electrónico del Apoderado</label>
                        <input type="email" class="form-control" id="email_apoderado" name="email" placeholder="Correo electrónico del apoderado">
                    </div>
                        </select>
                    </div>
                    
                    <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#editarEstudianteModal">Volver</button>
                        <button type="submit" class="btn btn-primary" id="guardarCambiosApoderado">Guardar Cambios</button>
                    
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="eliminarEstudianteModal" tabindex="-1" aria-labelledby="eliminarEstudianteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarEstudianteModalLabel">Confirmación de Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este estudiante?
            </div>
            <div class="modal-footer">
                <form id="eliminarEstudianteForm" method="post">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger" id="confirmarEliminacionBtn">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

   
            
                <div class="container ">
                    <table class="table table-hover table-striped datatable" id="estudiantesTable">
                        <thead>
                            <tr>
                                
                                <th>Nombre del Estudiante</th>
                                <th>Nombre del Apoderado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($estudiantes as $estudiante): ?>
                                <tr>
                                    <td><?= $estudiante['nombre_estudiante'] ?></td>
                                    <td><?= $estudiante['nombre_apoderado'] ?></td>
                                    <td>
                                    <button type="button" class="btn btn-primary editarEstudiante" data-bs-toggle="modal" data-bs-target="#editarEstudianteModal" data-estudiante-id="<?= $estudiante['estudiante_id'] ?>" data-apoderado-id="<?= $estudiante['apoderados_id'] ?>">Editar</button>
                                     <button type="button" class="btn  btn-danger eliminarEstudiante" data-bs-toggle="modal" data-bs-target="#eliminarEstudianteModal" data-estudiante-id="<?= $estudiante['estudiante_id'] ?>">Eliminar</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="button" class="btn position-relative btn-primary"  data-bs-toggle="modal" data-bs-target="#crearEstudianteModal" style="margin-top:5%; position:static ;" >Agregar Estudiante y Apoderado</button>
                </div>
   
        
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var form = document.getElementById("eliminarEstudianteForm");

        var botonesEliminar = document.querySelectorAll(".eliminarEstudiante");

        botonesEliminar.forEach(function(boton) {
            boton.addEventListener("click", function() {
                var estudianteId = this.getAttribute("data-estudiante-id");
                form.action = "<?= site_url('estudiantes/eliminar/') ?>" + estudianteId;
            });
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
    var formEstudiante = document.getElementById("editarEstudianteForm");
    var formApoderado = document.getElementById("editarApoderadoForm");

    var botonesEditarEstudiante = document.querySelectorAll(".editarEstudiante");
    var botonesEditarApoderado = document.querySelectorAll(".editarEstudiante");

    botonesEditarEstudiante.forEach(function(boton) {
        boton.addEventListener("click", function() {
            var estudianteId = this.getAttribute("data-estudiante-id");
            formEstudiante.action = "<?= site_url('estudiantes/editar/') ?>" + estudianteId;
        });
    });

    botonesEditarApoderado.forEach(function(boton) {
        boton.addEventListener("click", function() {
            var apoderadoId = this.getAttribute("data-apoderado-id");
            formApoderado.action = "<?= site_url('estudiantes/editar/') ?>" + apoderadoId;
        });
    });
});


</script>
</body>
<?php include(APPPATH . 'Views/Components/toast.php'); ?>
<?php include(APPPATH . 'Views/Components/footer.php'); ?>
