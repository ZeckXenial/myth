<?php include(APPPATH . 'Views/Components/NavBar.php'); ?>
<?php include(APPPATH . 'Views/Components/headers.php'); ?>
<body>

<div class="container my-4">
    <h1 class="text-center">Gestión de Matrículas</h1>

    <!-- Botón para abrir el formulario de nueva matrícula -->
    <button type="button" class="btn btn-primary mb-4" id="btnIngresarMatricula">
        <i class="bi bi-person-plus"></i> Ingresar Matrícula
    </button>
    <button type="button" class="btn btn-primary mb-4" id="btnIngresarMatricula">
        <i class="bi bi-person-plus"></i> Ingresar Matrícula
    </button>

    <!-- Tabla de estudiantes y apoderados registrados -->
    <div class="table-responsive">
    <table id="matriculasTable" class="table table-bordered table-hover align-middle">
        <thead class="table-primary text-center">
            <tr>
                
                <th>Nombre del Estudiante</th>
               
                <th>Curso</th>
                <th>RUT del Estudiante</th>
                <th>Nombre del Apoderado</th>
                <th>Teléfono del Apoderado</th>
                <th>Email del Apoderado</th>
                <th>Fecha de Matrícula</th>
                <th>N° Matrícula</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($matriculas)): ?>
                <tr>
                    <td colspan="12" class="text-center text-muted">No hay matrículas registradas.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($matriculas as $index => $matricula): ?>
                    <tr>
                        
                        <td><?= esc($matricula->nombre_estudiante); ?></td>
                        <td><?= esc($matricula->grado . ' - ' . $matricula->nombre); ?></td>
                        <td><?= esc($matricula->rut); ?></td>
                        <td><?= esc($matricula->nombre_apoderado); ?></td>
                        <td><?= esc($matricula->numero_telefono); ?></td>
                        <td><?= ($matricula->email == 'notiene@gmail.com') ? 'N/A' : esc($matricula->email); ?></td>
                        <td><?= esc($matricula->fecha_matriculacion); ?></td>
                        <td><?= !empty($matricula->nmatricula) ? esc($matricula->nmatricula) : 'N/A'; ?></td>
                        <td>
                            <?php if ($matricula->estado == 'Matriculado'): ?>
                                <span class="badge bg-success">Matriculado</span>
                            <?php elseif ($matricula->estado == 'Pendiente'): ?>
                                <span class="badge bg-warning text-dark">Pendiente</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Anulado</span>
                            <?php endif; ?>
                        </td>
                        <td>
                        <a href="<?= site_url('matriculas/editar/' . $matricula->estudiante_id .'/'. $matricula->apoderado_id.'/'. $matricula->matricula_id); ?>" class="btn btn-sm btn-outline-primary" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" title="Eliminar" onclick="confirmarEliminacion(<?= esc($matricula->matricula_id); ?>)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <script>
                                function confirmarEliminacion(id) {
                                if (confirm('¿Estás seguro de que deseas eliminar esta matrícula?')) {
                                    window.location.href = '<?= site_url('matriculas/eliminar/'); ?>' + id;
                                }
                            }</script>
</div>
</div>

<!-- Modal para agregar nueva matrícula -->
<div class="modal fade" id="modalIngresarMatricula" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 shadow-sm">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalLabel">Ingresar Nueva Matrícula</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('matriculas/guardar') ?>" method="post" enctype="multipart/form-data">

                    <!-- N° Matrícula -->
                    <div class="form-floating mb-3">
                        <input type="text" name="numero_matricula" class="form-control" placeholder="N° Matrícula" required>
                        <label for="numero_matricula">N° Matrícula</label>
                    </div>

                    <!-- Nombre del Estudiante -->
                    <div class="form-floating mb-3">
                        <input type="text" name="nombre_estudiante" class="form-control" placeholder="Nombre del Estudiante" required>
                        <label for="nombre_estudiante">Nombre del Estudiante</label>
                    </div>

                    <!-- Fecha de Nacimiento -->
                    <div class="form-floating mb-3">
                        <input type="date" name="fecha_nacimiento" class="form-control" required>
                        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                    </div>

                    <!-- Curso -->
                    <div class="form-floating mb-3">
                        <select name="curso_id" class="form-select" required>
                            <option value="">Seleccione un curso</option>
                            <?php foreach ($cursos as $curso): ?>
                                <option value="<?= esc($curso['curso_id']); ?>"><?= esc($curso['grado']) . ' - ' . esc($curso['nombre_nivel']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="curso_id">Curso</label>
                    </div>

                    <!-- RUT del Estudiante -->
                    <div class="form-floating mb-3">
                        <input type="text" id="rut_estudiante" name="rut_estudiante" class="form-control" placeholder="RUT del Estudiante" required>
                        <label for="rut_estudiante">RUT del Estudiante</label>
                    </div>

                    <!-- Nombre del Apoderado -->
                    <div class="form-floating mb-3">
                        <input type="text" name="nombre_apoderado" class="form-control" placeholder="Nombre del Apoderado" required>
                        <label for="nombre_apoderado">Nombre del Apoderado</label>
                    </div>

                    <!-- Teléfono del Apoderado -->
                    <div class="form-floating mb-3">
                        <input type="tel" name="numero_telefono" class="form-control" placeholder="Teléfono del Apoderado" required>
                        <label for="numero_telefono">Teléfono del Apoderado</label>
                    </div>

                    <!-- RUT del Apoderado -->
                    <div class="form-floating mb-3">
                        <input type="text" id="rut_apoderado" name="rut_apoderado" class="form-control" placeholder="RUT del Apoderado" required>
                        <label for="rut_apoderado">RUT del Apoderado</label>
                    </div>

                    <!-- Email del Apoderado -->
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email del Apoderado" required>
                        <label for="email">Email del Apoderado</label>
                    </div>

                    <!-- Fecha de Matrícula -->
                    <div class="form-floating mb-3">
                        <input type="date" name="fecha_matricula" class="form-control" required>
                        <label for="fecha_matricula">Fecha de Matrícula</label>
                    </div>

                    <!-- Estado -->
                    <div class="form-floating mb-3">
                        <select name="estado" class="form-select" required>
                            <option value="Matriculado">Matriculado</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Anulado">Anulado</option>
                        </select>
                        <label for="estado">Estado</label>
                    </div>

                    <!-- Botón de Guardar -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Guardar Matrícula
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inicializar DataTables con idioma español (México)
        $('#matriculasTable').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-MX.json"
            }
        });

        // Función para formatear el RUT y permitir la letra "K"
        function formatRUT(input) {
            input.addEventListener('input', function(event) {
                let value = event.target.value
                    .replace(/[^0-9kK-]/g, '')  // Permitir números, "k", "K" y "-"
                    .replace(/k$/, 'K');       // Convertir "k" minúscula a mayúscula

                // Validar el formato: hasta 8 dígitos + guion + 1 dígito o "K"
                let match = value.match(/^(\d{0,8})(-?)([0-9K]?)$/);

                if (match) {
                    let formatted = match[1]; // Parte numérica (máx. 8 dígitos)
                    if (match[1].length === 8) {
                        formatted += '-'; // Agregar guion después de 8 dígitos
                    }
                    if (match[3]) {
                        
                        formatted += match[3]; // Dígito verificador (número o "K")
                    }
                    event.target.value = formatted;
                }
            });
        }

        // Aplicar el formato a los campos de RUT
        formatRUT(document.getElementById('rut_estudiante'));
        formatRUT(document.getElementById('rut_apoderado'));

        // Mostrar el modal al hacer clic en el botón
        $('#btnIngresarMatricula').on('click', function() {
            $('#modalIngresarMatricula').modal('show');
        });
    });
</script>


</body>
<?php include(APPPATH . 'Views/Components/toast.php'); include(APPPATH . 'Views/Components/footer.php'); ?>
</html>
